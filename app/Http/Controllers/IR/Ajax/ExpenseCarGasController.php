<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\ExpenseCarGasRequest;
use App\Models\IR\ExpenseCarGas;
use App\Models\IR\PtirCars;
use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\PtirExtendGasStations;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;
class ExpenseCarGasController extends Controller
{
    protected $userId;
    protected $listId = [];
    public function __construct()
    {
       $this->userId = optional(auth()->user())->user_id ?? -1;
    }
     /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\ExpenseCarGasRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseCarGasRequest $request) 
    {
        $year = $request->year;
        $period_name = $request->period_name;
        $expense_type_code = $request->type;
        $group_code = $request->group_code;
        $type_code = $request->type_code;
        $license_plate = $request->license_plate;
        $renew_type = $request->renew_type;
        $status = $request->status;

        $collection = PtirExpenseCarGas::select(DB::raw("
            ptir_expense_car_gas.department_code,
            ptir_expense_car_gas.department_name,
            ptir_expense_car_gas.document_header_id,
            ptir_expense_car_gas.document_line_id,
            ptir_expense_car_gas.document_number,
            to_char(add_months(ptir_expense_car_gas.end_date, 6516), 'DD/MM/YYYY') end_date,
            ptir_expense_car_gas.expense_account,
            ptir_expense_car_gas.expense_account_desc,
            ptir_expense_car_gas.expense_account_id,
            ptir_expense_car_gas.expense_flag,
            ptir_expense_car_gas.expense_id,
            ptir_expense_car_gas.expense_type_code,
            (ptir_exp_type_car_gas_v.description) expense_type_desc,
            ptir_expense_car_gas.gas_station_type_code,
            ptir_expense_car_gas.gas_station_type_name,
            ptir_expense_car_gas.group_code,
            (ptir_groups.meaning) group_name,
            ptir_expense_car_gas.license_plate,
            ptir_expense_car_gas.net_amount,
            to_char(add_months(to_date(ptir_expense_car_gas.period_name, 'mm-yy'), 6516), 'MM/YYYY') period_name,
            ptir_expense_car_gas.policy_set_description,
            ptir_expense_car_gas.policy_set_header_id,
            ptir_expense_car_gas.prepaid_account,
            ptir_expense_car_gas.prepaid_account_desc,
            ptir_expense_car_gas.prepaid_account_id,
            ptir_expense_car_gas.program_code,
            ptir_expense_car_gas.reference_document_number,
            ptir_expense_car_gas.reference_header_id,
            ptir_expense_car_gas.reference_line_id,
            ptir_expense_car_gas.renew_type,
            ptir_expense_car_gas.renew_type_code,
            ptir_expense_car_gas.sold_flag,
            to_char(add_months(ptir_expense_car_gas.start_date, 6516), 'DD/MM/YYYY') start_date,
            ptir_expense_car_gas.status,
            ptir_expense_car_gas.total_days,
            (case when ptir_expense_car_gas.expense_type_code = 'CAR001' then
                (case when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_INSURANCES' then
                    'IRS0002'
                when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_ACT' then 
                    'IRS0003'
                when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_LICENSE_PLATE' then 
                    'IRS0004'
                when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_INSPECTION' then 
                    'IRS0005'
                else 
                    ptir_renew_car_insurances.lookup_type
                end) 
            else
                null
            end) renew_program_code
        "))
        ->leftJoin('ptir_renew_car_insurances', 'ptir_expense_car_gas.renew_type', '=', 'ptir_renew_car_insurances.meaning')
        ->join('ptir_exp_type_car_gas_v', 'ptir_expense_car_gas.expense_type_code', '=', 'ptir_exp_type_car_gas_v.lookup_code')
        ->join('ptir_groups', 'ptir_expense_car_gas.group_code', '=', 'ptir_groups.lookup_code')
        ->whereRaw("
            ptir_expense_car_gas.period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')
            and (
                ptir_expense_car_gas.renew_type = ptir_renew_car_insurances.meaning 
                or ptir_expense_car_gas.renew_type is null
            )
            and (
                ptir_expense_car_gas.renew_type_code = ptir_renew_car_insurances.lookup_code 
                or ptir_expense_car_gas.renew_type_code is null
            )
        ", [$period_name])
        ->where('expense_type_code', $expense_type_code)
        ->when($group_code, function ($q, $group_code){
            return $q->where('group_code', $group_code);
        })
        ->when($type_code, function ($q, $type_code){
            return $q->where('gas_station_type_code', $type_code);
        })
        ->when($license_plate, function ($q, $license_plate){
            return $q->where('license_plate', $license_plate);
        })
        ->when($renew_type, function ($q, $renew_type){
            return $q->where('renew_type', $renew_type);
        })
        ->when($status, function ($q, $status){
            return $q->where('status', $status);
        })
        ->orderByRaw("group_code asc, renew_program_code asc, renew_type_code asc, license_plate asc")
        ->get();

        $response = getResponse($collection);

        return response($response, $response['status']);
    }

    public function checkFetch(ExpenseCarGasRequest $request)
    {
        $periodName = $request->period_name;
        $policyId = $request->policy_set_header_id;
        $expenseType = $request->type; // expense_type_code
        $groupCode = $request->group_code;
        $typeCode = $request->type_code; // gas_station_type
        $licensePlate = $request->license_plate;
        $renewType = $request->renew_type;

        $checkDataAll = PtirExpenseCarGas::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$periodName])
            // ->where(function ($q){
            //     return $q->whereIn('status', ['CONFIRMED', 'INTERFACE']);
            //     // return $q->whereIn('status', ['CONFIRMED', 'INTERFACE', 'NEW']);
            // })
            ->when(!!$policyId, function($q ,$policyId){
                return $q->where('policy_set_header_id', $policyId);
            })
            ->when(!!$groupCode, function($q ,$groupCode){
                return $q->where('group_code', $groupCode);
            })
            ->when(!!$typeCode, function($q ,$typeCode){
                return $q->where('gas_station_type_code', $typeCode);
            })
            ->when(!!$licensePlate, function($q ,$licensePlate){
                return $q->where('license_plate', $licensePlate);
            })
            ->when(!!$renewType, function($q ,$renewType){
                return $q->where('renew_type_code', $renewType);
            })
            ->where('expense_type_code', $expenseType)
            ->get();

        $hasData = PtirExpenseCarGas::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$periodName])
            ->where(function ($q){
                return $q->whereIn('status', ['CONFIRMED', 'INTERFACE']);
                // return $q->whereIn('status', ['CONFIRMED', 'INTERFACE', 'NEW']);
            })
            ->when(!!$policyId, function($q ,$policyId){
                return $q->where('policy_set_header_id', $policyId);
            })
            ->when(!!$groupCode, function($q ,$groupCode){
                return $q->where('group_code', $groupCode);
            })
            ->when(!!$typeCode, function($q ,$typeCode){
                return $q->where('gas_station_type_code', $typeCode);
            })
            ->when(!!$licensePlate, function($q ,$licensePlate){
                return $q->where('license_plate', $licensePlate);
            })
            ->when(!!$renewType, function($q ,$renewType){
                return $q->where('renew_type_code', $renewType);
            })
            ->where('expense_type_code', $expenseType)
            ->get();

            $countData    = count($checkDataAll);
            $countHasData = count($hasData);

        // dd($countHasData, $countData, $countHasData < $countData);

        if ($countHasData == 0) {
            $msg = '';
            $status = 'S';
        }elseif ($countHasData < $countData) {
            $text = '';

            // foreach ($hasData->pluck('license_plate') as $index => $data) {
            //     if ($index == 0) {
            //         $text = $data;
            //     } else {
            //         $text = $text . ', ' . $data;
            //     }
            // }

            $msg    = 'มีข้อมูลถูกดึงข้อมูลเรียบร้อยแล้ว ต้องการดึงข้อมูลต่อหรือไม่';
            $status = 'W';
        }elseif ($countHasData == $countData) {
            $msg    = 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบ';
            $status = 'E';
        }

        // $msg = '';

        // if(!!$hasData->count()){
        //     $msg = 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบ';
        // }

        return response()->json([
            'valid' => !$hasData->count(),
            'msg' => $msg,
            'status' => $status,
        ]);
    }

    public function fetch(ExpenseCarGasRequest $request)
    {
        ini_set('max_execution_time', 0);

        $collection = (new ExpenseCarGas())->getExpenseCarGas(
            $request->year, 
            $request->period_name, 
            $request->type,
            $request->group_code,
            $request->type_code, 
            $request->status, 
            $request->license_plate,
            $request->renew_type
        );

        $response = getResponse($collection);

        return response($response, $response['status']);
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\ExpenseCarGasRequest $request  
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCarGasRequest $request)
    {
        $requestData = $request->all()['data'];
        $i = 0;
        foreach($requestData as $index)
        {
            logger($index);
            $validator = Validator::make($index, [
                'status'             => 'required',
                'document_header_id' => 'required',
                'net_amount'         => 'required',
                'start_date'         => 'required',
                'end_date'           => 'required',
                'total_days'         => 'required',
                'expense_account_id' => 'required',
            ]);
    
            $validator->validate();
    
            $userId = optional(auth()->user())->user_id ?? -1;
            $data['expense_id']             = isset($index['expense_id']) ? $index['expense_id'] : '';
            $data['status']                 = isset($index['status']) ? $index['status'] : '';
            $data['document_number']        = isset($index['document_number']) ? $index['document_number'] : '';
            $data['document_header_id']     = isset($index['document_header_id']) ? $index['document_header_id'] : '';
            $data['document_line_id']       = isset($index['document_line_id']) ? $index['document_line_id'] : '';
            $data['expense_type_code']      = isset($index['expense_type_code']) ? $index['expense_type_code'] : '';
            $data['policy_set_header_id']   = isset($index['policy_set_header_id']) ? $index['policy_set_header_id'] : '';
            $data['policy_set_description'] = isset($index['policy_set_description']) ? $index['policy_set_description'] : '';
            $data['department_code']        = isset($index['department_code']) ? $index['department_code'] : '';
            $data['department_name']        = isset($index['department_name']) ? $index['department_name'] : '';
            $data['renew_type_code']        = isset($index['renew_type_code']) ? $index['renew_type_code'] : '';  
            $data['renew_type']             = isset($index['renew_type']) ? $index['renew_type'] : '';  
            $data['license_plate']          = isset($index['license_plate']) ? $index['license_plate'] : '';  
            $data['gas_station_type_code']  = isset($index['gas_station_type_code']) ? $index['gas_station_type_code'] : '';  
            $data['gas_station_type_name']  = isset($index['gas_station_type_name']) ? $index['gas_station_type_name'] : '';  
            $data['net_amount']             = isset($index['net_amount']) ? $index['net_amount'] : '';  
            $data['start_date']             = isset($index['start_date']) ? toDate($index['start_date']) : '';
            $data['end_date']               = isset($index['end_date']) ? toDate($index['end_date']) : '';
            $data['total_days']             = isset($index['total_days']) ? $index['total_days'] : '';  
            $data['expense_account_id']     = isset($index['expense_account_id']) ? $index['expense_account_id'] : '';  
            $data['expense_account']        = isset($index['expense_account']) ? $index['expense_account'] : '';  
            $data['expense_account_desc']   = isset($index['expense_account_desc']) ? $index['expense_account_desc'] : '';  
            $data['prepaid_account_id']     = isset($index['prepaid_account_id']) ? $index['prepaid_account_id'] : '';  
            $data['prepaid_account']        = isset($index['prepaid_account']) ? $index['prepaid_account'] : '';  
            $data['prepaid_account_desc']   = isset($index['prepaid_account_desc']) ? $index['prepaid_account_desc'] : '';  
            $data['expense_flag']            = isset($index['expense_flag']) ? $index['expense_flag'] : '';  
            $data['sold_flag']               = isset($index['sold_flag']) ? $index['sold_flag'] : '';  
            $data['reference_header_id']     = isset($index['reference_header_id']) ? $index['reference_header_id'] : '';  
            $data['reference_line_id']       = isset($index['reference_line_id']) ? $index['reference_line_id'] : '';  
            $data['reference_document_number'] = isset($index['reference_document_number']) ? $index['reference_document_number'] : '';  
            $data['period_name']            = isset($index['period_name']) ? $index['period_name'] : '';
            $data['group_code']             = isset($index['group_code']) ? $index['group_code'] : '';
            $data['program_code']           = isset($index['program_code']) ? $index['program_code'] : '';
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
                // $expenseCarGas = PtirExpenseCarGas::duplicateCheck($data['document_header_id'], $data['expense_type_code']);
                if ($data['expense_id'] == '')
                {
                    $expense = PtirExpenseCarGas::create($data); 
                    $data['expense_id'] = $expense->expense_id;
                    
                }
                else
                {
                    $db = PtirExpenseCarGas::where('expense_id', $data['expense_id'])
                                            ->update(['status' => $data['status'],
                                                      'updated_at' => $data['updated_at'],
                                                      'updated_by_id' => $data['updated_by_id'],
                                                      'last_update_date' => $data['last_update_date']]);
                } 

                if ($data['status'] == "CONFIRMED") {
                    $expenseFlag = "Y";
                } else {
                    $expenseFlag = "N";
                }
                if ($data['expense_type_code'] == 'CAR001')
                {
                    $db = PtirCars::find($data['document_header_id']);
                    if ($db) {
                        $db->expense_flag     = $expenseFlag;
                        $db->updated_at       = $data['updated_at'];
                        $db->updated_by_id    = $data['updated_by_id'];
                        $db->last_update_date = $data['last_update_date'];
                        $db->save();
                    }
                }
                else if ($data['expense_type_code'] == 'GAS001')
                {
                    $db = PtirExtendGasStations::find($data['document_header_id']);

                    if ($db) {
                        $db->expense_flag     = $expenseFlag;
                        $db->updated_at       = $data['updated_at'];
                        $db->updated_by_id    = $data['updated_by_id'];
                        $db->last_update_date = $data['last_update_date'];
                        $db->save();
                    }
                }

                DB::commit();
                
                if ($data['document_number'] == '')
                {
                    $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['expense_id'])['document_number'];
                }

                $db = PtirExpenseCarGas::find($data['expense_id']);
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
