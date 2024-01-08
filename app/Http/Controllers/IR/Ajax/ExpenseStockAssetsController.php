<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\ExpenseStockAssetsRequest;
use App\Models\IR\ExpenseStockAssets;
use App\Models\IR\PtirAssetHeaders;
use App\Models\IR\PtirAssetLines;
use App\Models\IR\PtirCars;
use App\Models\IR\PtirExpenseStockAssets;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;
use App\Models\IR\PtirWebUtilitiesPkg;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\each;

class ExpenseStockAssetsController extends Controller
{
    protected $userId;
    protected $listId = [];
    public function __construct()
    {
       $this->userId = optional(auth()->user())->user_id ?? -1;; 
    }
     /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\ExpenseStockAssetsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseStockAssetsRequest $request) 
    {
        ini_set('max_execution_time', 0);

        $year = $request->year;
        $period_name = $request->period_name;
        $expense_type_code = $request->type;
        $policy_set_header_id = $request->policy_set_header_id;
        $status = $request->status;

        $collection = DB::table("ptir_expense_stock_assets as exst")
        ->selectRaw("
            exst.expense_id
            ,exst.status
            ,exst.document_number
            ,exst.document_header_id
            ,exst.document_line_id
            ,exst.expense_type_code
            ,exst.policy_set_header_id
            ,exst.policy_set_description
            ,exst.group_code
            ,exst.department_code
            ,exst.department_name
            ,exst.sector_code
            ,exst.sector_name
            ,exst.asset_id
            ,exst.asset_number
            ,exst.insurance_premium
            ,to_char(add_months(to_date(exst.period_name, 'MON-YY'), 6516), 'MM/YYYY') as period_name
            ,exst.expense_account_id
            ,exst.expense_account
            ,exst.expense_account_desc
            ,exst.prepaid_account_id
            ,exst.prepaid_account
            ,exst.prepaid_account_desc
            ,exst.coverage_amount
            ,exst.insurance_amount
            ,exst.coverage_amount_cal
            ,exst.insurance_amount_cal
            ,exst.net_amount
            ,exst.expense_flag
            ,exst.reference_header_id
            ,exst.reference_line_id
            ,exst.reference_document_number
            ,exst.document_header_id2
            ,exst.document_line_id2
            ,exst.program_code
            ,(extas.description) as expense_type_desc
            ,(policy.policy_set_number) as policy_set_number
            ,(irg.meaning) as group_name
        ")
        ->join("ptir_exp_type_asset_stock_v as extas", "extas.lookup_code", "=", "exst.expense_type_code")
        ->join("ptir_policy_set_headers as policy", "policy.policy_set_header_id", "=", "exst.policy_set_header_id")
        ->join("ptir_groups as irg", "irg.lookup_code", "=", "exst.group_code")
        ->whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$period_name])
        ->where('expense_type_code', $expense_type_code)
        ->when($policy_set_header_id, function ($q, $policy_set_header_id){
            return $q->where('exst.policy_set_header_id', $policy_set_header_id);
        })
        ->when($status, function ($q, $status){
            return $q->where('exst.status', $status);
        })
        ->orderByRaw("exst.status DESC, exst.policy_set_header_id ASC, exst.department_code ASC")
        ->get();

        // dd($listStockId);

        $response = getResponse($collection);
        
        return response($response, $response['status']);
    }

    public function checkFetch(ExpenseStockAssetsRequest $request)
    {
        $periodName = $request->period_name;
        $policyId = $request->policy_set_header_id;
        $expenseType = $request->expense_type_code;

        $hasData = PtirExpenseStockAssets::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$periodName])
            ->where(function ($q){
                return $q->whereIn('status', ['CONFIRMED', 'INTERFACE']);
                // return $q->whereIn('status', ['CONFIRMED', 'INTERFACE', 'NEW']);
            })
            ->when(!!$policyId, function($q) use($policyId){
                return $q->where('policy_set_header_id', $policyId);
            })
            ->where('expense_type_code', $expenseType)
            ->get();

        $msg = '';

        if(!!$hasData->count()){
            $msg = 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบ';
        }

        return response()->json([
            'valid' => !$hasData->count(),
            'msg' => $msg,
        ]);
    }

    public function fetch(ExpenseStockAssetsRequest $request) 
    {
        ini_set('max_execution_time', 0);

        $collection = (new ExpenseStockAssets())->getExpenseAssetsStock(
            $request->year, 
            $request->period_name, 
            $request->expense_type_code,
            $request->policy_set_header_id, 
            $request->status
        );

        $arr = [];
        foreach($collection as $item) {
            array_push($arr, $item);
        }

        $response = getResponse($arr);

        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\ExpenseStockAssetsRequest $request  
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStockAssetsRequest $request)
    {
        $requestData = $request->all()['data'];
        
        $i = 0;
        foreach($requestData as $index)
        {
            $validator = Validator::make($index, [
                'coverage_amount'       => 'required',
                'insurance_amount'      => 'required',
                'coverage_amount_cal'   => 'required',
                'insurance_amount_cal'  => 'required',
                'net_amount'            => 'required',
            ]);
    
            $validator->validate();
    
            $data['expense_id']              = isset($index['expense_id']) ? $index['expense_id'] : '';
            $data['status']                  = isset($index['status']) ? strtoupper($index['status']) : '';
            $data['document_number']         = isset($index['document_number']) ? $index['document_number'] : '';
            $data['document_header_id']      = isset($index['document_header_id']) ? $index['document_header_id'] : (isset($index['header_id']) ? $index['header_id'] : '');
            $data['document_line_id']        = isset($index['document_line_id']) ? $index['document_line_id'] : (isset($index['line_id']) ? $index['line_id'] : '');
            $data['expense_type_code']       = isset($index['expense_type_code']) ? $index['expense_type_code'] : '';
            $data['policy_set_header_id']    = isset($index['policy_set_header_id']) ? $index['policy_set_header_id'] : '';
            $data['policy_set_description']  = isset($index['policy_set_description']) ? $index['policy_set_description'] : '';
            $data['group_code']              = isset($index['group_code']) ? $index['group_code'] : '';
            $data['department_code']         = isset($index['department_code']) ? $index['department_code'] : '';
            $data['department_name']         = isset($index['department_name']) ? $index['department_name'] : '';
            $data['sector_code']             = isset($index['sector_code']) ? $index['sector_code'] : '';
            $data['sector_name']             = isset($index['sector_name']) ? $index['sector_name'] : '';
            $data['asset_id']                = isset($index['asset_id']) ? $index['asset_id'] : '';  
            $data['asset_number']            = isset($index['asset_number']) ? $index['asset_number'] : '';  
            $data['insurance_premium']       = isset($index['premium_rate']) ? $index['premium_rate'] : '';  
            $data['period_name']             = isset($index['period_name']) ? $index['period_name'] : '';  
            $data['expense_account_id']      = isset($index['expense_account_id']) ? $index['expense_account_id'] : '';  
            $data['expense_account']         = isset($index['expense_account']) ? $index['expense_account'] : '';  
            $data['expense_account_desc']    = isset($index['expense_account_desc']) ? $index['expense_account_desc'] : '';  
            $data['prepaid_account_id']      = isset($index['prepaid_account_id']) ? $index['prepaid_account_id'] : '';  
            $data['prepaid_account']         = isset($index['prepaid_account']) ? $index['prepaid_account'] : '';  
            $data['prepaid_account_desc']    = isset($index['prepaid_account_desc']) ? $index['prepaid_account_desc'] : '';  
            $data['coverage_amount']         = isset($index['coverage_amount']) ? $index['coverage_amount'] : '';  
            $data['insurance_amount']        = isset($index['insurance_amount']) ? $index['insurance_amount'] : '';  
            $data['coverage_amount_cal']     = isset($index['coverage_amount_cal']) ? $index['coverage_amount_cal'] : '';  
            $data['insurance_amount_cal']    = isset($index['insurance_amount_cal']) ? $index['insurance_amount_cal'] : '';  
            $data['net_amount']              = isset($index['net_amount']) ? $index['net_amount'] : '';  
            $data['expense_flag']            = isset($index['expense_flag']) ? $index['expense_flag'] : '';  
            $data['reference_header_id']     = isset($index['reference_header_id']) ? $index['reference_header_id'] : '';  
            $data['reference_line_id']       = isset($index['reference_line_id']) ? $index['reference_line_id'] : '';  
            $data['reference_document_number'] = isset($index['reference_document_number']) ? $index['reference_document_number'] : '';  
            $data['document_header_id2']       = isset($index['header_id2']) ? $index['header_id2'] : '';  
            $data['document_line_id2']         = isset($index['line_id2']) ? $index['line_id2'] : '';  
            $data['program_code']            = isset($index['program_code']) ? $index['program_code'] : '';
            $data['created_at']             = Carbon::now();
            $data['updated_at']             = Carbon::now();
            $data['created_by_id']          = $this->userId;
            $data['created_by']             = $this->userId;
            $data['updated_by_id']          = $this->userId;
            $data['last_updated_by']        = $this->userId;
            $data['creation_date']          = Carbon::now();
            $data['last_update_date']       = Carbon::now();

            $i += 1;

            $expenseFlag = '';
            try {
                DB::beginTransaction(); 
                // $expenseAsset = PtirExpenseStockAssets::duplicateCheck($data['document_line_id'], $data['expense_type_code']);
                if ($data['expense_id'] == '')
                {
                    $expense = PtirExpenseStockAssets::create($data);
                    $data['expense_id'] = $expense->expense_id;
                   
                }
                else
                {
                    $expense = PtirExpenseStockAssets::find($data['expense_id']);
                    $expense->status            = $data['status'];
                    $expense->updated_at        = $data['updated_at'];
                    $expense->updated_by_id     = $data['updated_by_id'];
                    $expense->last_update_date  = $data['last_update_date'];
                    $expense->save();
                }

                if ($data['status'] == "CONFIRMED") {
                    $expenseFlag = "Y";
                } else {
                    $expenseFlag = "N";
                }

                if ($data['expense_type_code'] == 'ASSET001')
                {
                    $db = PtirAssetLines::whereRaw("line_id in (?, ?)", [$data['document_line_id'], $data['document_line_id2']])
                        ->update([
                            'expense_flag' => $expenseFlag,
                            'updated_at' => $data['updated_at'],
                            'updated_by_id' => $data['updated_by_id'],
                            'last_update_date' => $data['last_update_date']
                        ]);

                    $db = PtirAssetHeaders::whereRaw("header_id in (?, ?)", [$data['document_header_id'], $data['document_header_id2']])
                        ->update([
                            'expense_flag' => $expenseFlag,
                            'updated_at' => $data['updated_at'],
                            'updated_by_id' => $data['updated_by_id'],
                            'last_update_date' => $data['last_update_date']
                        ]);

                }
                else if ($data['expense_type_code'] == 'STOCK001')
                {
                    $db = PtirStockLines::find($data['document_line_id']);
                    $db->expense_flag     = $expenseFlag;
                    $db->updated_at       = $data['updated_at'];
                    $db->updated_by_id    = $data['updated_by_id'];
                    $db->last_update_date = $data['last_update_date'];
                    $db->save();

                    $db = PtirStockHeaders::find($data['document_header_id']);
                    $db->expense_flag     = $expenseFlag;
                    $db->updated_at       = $data['updated_at'];
                    $db->updated_by_id    = $data['updated_by_id'];
                    $db->last_update_date = $data['last_update_date'];
                    $db->save();

                    $db = PtirStockLines::where('header_id', $data['document_header_id'])
                    ->where('policy_set_header_id', $expense->policy_set_header_id)
                    ->where('status', 'CONFIRMED')
                    ->update([
                        'expense_flag' => $expenseFlag,
                        'updated_at' => Carbon::now(),
                        'updated_by_id' => $this->userId,
                        'last_update_date' => Carbon::now()
                    ]);
                }
                
                DB::commit();

                if ($data['document_number'] == '')
                {
                    $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['expense_id'])['document_number'];
                }
                
                $db = PtirExpenseStockAssets::find($data['expense_id']);
                $db->document_number  = $data['document_number'];
                $db->updated_at       = $data['updated_at'];
                $db->updated_by_id    = $data['updated_by_id'];
                $db->last_update_date = $data['last_update_date'];
                $db->save();

                $this->listId[$i - 1]['expense_id'] = $data['expense_id'];              
                $this->listId[$i - 1]['document_number'] = $data['document_number'];              
                $this->listId[$i - 1]['row_id'] = isset($index['rowId']) ? $index['rowId'] : '';      

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError($e->getMessage());
            }
        }
      
        DB::commit();

        $obj = new \stdClass();
        $obj->rows = $this->listId;

        $response   = success($obj);

        return response($response, $response['status']);
    }
}
