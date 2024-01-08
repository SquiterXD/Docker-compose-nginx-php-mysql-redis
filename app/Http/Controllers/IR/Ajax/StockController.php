<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockLinesRequestStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockRequestStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockServiceInterface;
use App\Http\Requests\IR\StockRequest;
use App\Models\IR\Stocks;
use DateTime;

use App\Models\IR\PtirStockHeaders;


class StockController extends Controller
{
    protected $userId;
    protected $headerId;
    protected $line_data = [];
    private   $service;

    public function __construct(StockServiceInterface $service)
    {
        $this->userId  = optional(auth()->user())->user_id ?? -1;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\Settings\AssetRequest 
     * @return \Illuminate\Http\Response
     */ 
    public function index(StockRequest $request) {
        $data = $request->all();
        $periodYear     = isset($data['period_year']) ? $data['period_year'] : '';
        $periodName     = isset($data['period_name']) ? $data['period_name'] : '';
        $startDate      = isset($data['insurance_start_date']) ? $data['insurance_start_date'] : '';
        $endDate        = isset($data['insurance_end_date']) ? $data['insurance_end_date'] : '';
        $policyId       = isset($data['policy_set_header_id']) ? $data['policy_set_header_id'] : 0;
        $status         = isset($data['status']) ? $data['status'] : '';
        $periodFrom     = isset($data['period_from']) ? $data['period_from'] : '';
        $periodTo       = isset($data['period_to']) ? $data['period_to'] : '';
        $departmentFrom = isset($data['department_from']) ? $data['department_from'] : '';
        $departmentTo   = isset($data['department_to']) ? $data['department_to'] : '';
        $programCode    = isset($data['program_code']) ? $data['program_code'] : '';

        $response = $this->service->getAll($periodYear
                                          ,$periodName
                                          ,$startDate
                                          ,$endDate
                                          ,$policyId
                                          ,$status
                                          ,$periodFrom
                                          ,$periodTo
                                          ,$departmentFrom
                                          ,$departmentTo
                                          ,$programCode);

        return response($response, $response['status']);
    }

    public function checkFetch(StockRequest $request)
    {
        if ($request->program_code == 'IRP0001')
        {
            $result = (new Stocks())->checkDupStockYearly(
                $request->period_year,
                $request->policy_set_header_id,
                $request->status,
                $request->period_from, 
                $request->period_to,
                $request->department_from,
                $request->department_to
            );
        }
        else
        {
            $result = (new Stocks())->checkDupStockMonthly(
                $request->period_year, 
                $request->policy_set_header_id,
                $request->data_month,
                $request->department_from,
                $request->department_to
            );
        }

        $data = [
            'status' => $result['status'],
            'msg' => $result['msg'],
        ];

        return response()->json($data);
    }

    public function fetch(StockRequest $request) {
        if ($request->program_code == 'IRP0001')
        {
            $result = (new Stocks())->callGetStockYearly(
                $request->period_year,
                $request->policy_set_header_id,
                $request->status,
                $request->period_from, 
                $request->period_to,
                $request->department_from,
                $request->department_to);
        }
        else
        {
            $result = (new Stocks())->callGetStockMonthly(
                $request->period_year, 
                $request->policy_set_header_id,
                $request->data_month,
                $request->department_from,
                $request->department_to
            );
        }

        if ($result['status'] == 'E')
        {
            return $result['msg'];
        }

        $data = $request->all();
        $periodYear     = isset($data['period_year']) ? $data['period_year'] : '';
        $periodName     = isset($data['period_name']) ? $data['period_name'] : '';
        $startDate      = isset($data['insurance_start_date']) ? $data['insurance_start_date'] : '';
        $endDate        = isset($data['insurance_end_date']) ? $data['insurance_end_date'] : '';
        $policyId       = isset($data['policy_set_header_id']) ? $data['policy_set_header_id'] : 0;
        $status         = isset($data['status']) ? $data['status'] : '';
        $periodFrom     = isset($data['period_from']) ? $data['period_from'] : '';
        $periodTo       = isset($data['period_to']) ? $data['period_to'] : '';
        $departmentFrom = isset($data['department_from']) ? $data['department_from'] : '';
        $departmentTo   = isset($data['department_to']) ? $data['department_to'] : '';
        $programCode    = isset($data['program_code']) ? $data['program_code'] : '';

        $response = $this->service->getAll($periodYear
                                          ,$periodName
                                          ,$startDate
                                          ,$endDate
                                          ,$policyId
                                          ,$status
                                          ,$periodFrom
                                          ,$periodTo
                                          ,$departmentFrom
                                          ,$departmentTo
                                          ,$programCode);
        
        $response   = getResponse($response);

        return response($response, $response['status']);
    }

    public function show(StockRequest $request) {
        $data        = $request->all(); 
        $headerId    = isset($data['header_id']) ? $data['header_id'] : '';
        $programCode = isset($data['program_code']) ? $data['program_code'] : '';
 
        $response = $this->service->getByID($headerId, $programCode);

        return response($response, $response['status']);
    }

    public function createOrUpdate(StockRequest $request) {
        ini_set('max_execution_time', 0);
        $requestData = $request->all()['data'];
        $stock = new StockRequestStruct();
        $stock->header_id        = isset($requestData['header_id']) ? $requestData['header_id'] : '';
        $stock->department_code  = isset($requestData['department_code']) ? $requestData['department_code'] : '';
        $stock->department_desc  = isset($requestData['department_desc']) ? $requestData['department_desc'] : '';
        // $stock->document_number  = isset($requestData['document_number']) ? $requestData['document_number'] : '';
        $stock->expense_flag     = isset($requestData['expense_flag']) ? $requestData['expense_flag'] : '';
        $stock->status           = isset($requestData['status']) ? $requestData['status'] : '';
        $stock->program_code     = isset($requestData['program_code']) ? $requestData['program_code'] : '';

        if ($stock->header_id) {
            $header = PtirStockHeaders::find($stock->header_id);

            $stock->document_number  = $header ? $header->document_number : '';
        } else {
            $stock->document_number  = isset($requestData['document_number']) ? $requestData['document_number'] : '';
        }

        $stock->rows             = array();

        foreach($requestData['rows'] as $line) {
            $stockLine = new StockLinesRequestStruct();
            $stockLine->line_id                = isset($line['line_id']) ? $line['line_id'] : '';
            $stockLine->line_number            = isset($line['line_number']) ? (int)$line['line_number'] : '';
            $stockLine->document_number        = isset($line['document_number']) ? $line['document_number'] : '';
            $stockLine->status                 = isset($line['status']) ? strtoupper($line['status']) : '';
            $stockLine->year                   = isset($line['year']) ? $line['year'] : '';
            $stockLine->period_name            = isset($line['period_name']) ? $line['period_name'] : '';
            $stockLine->period_from            = isset($line['period_from']) ? convertMonthAndYearDate($line['period_from'], 'start') : '';
            $stockLine->period_to              = isset($line['period_to']) ? convertMonthAndYearDate($line['period_to'], 'start') : '';
            $stockLine->policy_set_header_id   = isset($line['policy_set_header_id']) ? $line['policy_set_header_id'] : (isset($requestData['policy_set_header_id']) ? $requestData['policy_set_header_id'] : '');
            $stockLine->policy_set_description = isset($line['policy_set_description']) ? $line['policy_set_description'] : (isset($requestData['policy_set_description']) ? $requestData['policy_set_description'] : '');
            $stockLine->department_code        = isset($line['department_code']) ? $line['department_code'] : '';
            $stockLine->department_description = isset($line['department_desc']) ? $line['department_desc'] : '';
            $stockLine->org_id                 = isset($line['org_id']) ? (int)$line['org_id'] : '';
            $stockLine->sub_inventory_code     = isset($line['sub_inventory_code']) ? $line['sub_inventory_code'] : '';
            $stockLine->sub_inventory_desc     = isset($line['sub_inventory_desc']) ? $line['sub_inventory_desc']  : '';
            $stockLine->location_code          = isset($line['location_code']) ? $line['location_code'] : '';
            $stockLine->location_desc          = isset($line['location_desc']) ? $line['location_desc'] : '';
            $stockLine->item_id                = isset($line['item_id']) ? (int)$line['item_id'] : '';
            $stockLine->item_code              = isset($line['item_code']) ? $line['item_code'] : '';
            $stockLine->item_description       = isset($line['item_description']) ? $line['item_description'] : '';
            $stockLine->uom_code               = isset($line['uom_code']) ? $line['uom_code'] : '';
            $stockLine->original_quantity      = isset($line['original_quantity']) ? $line['original_quantity'] : '';
            $stockLine->unit_price             = isset($line['unit_price']) ? $line['unit_price'] : '';
            $stockLine->line_amount            = isset($line['line_amount']) ? $line['line_amount'] : '';
            $stockLine->coverage_amount        = isset($line['coverage_amount']) ? $line['coverage_amount'] : '';
            $stockLine->calculate_start_date   = isset($line['calculate_start_date']) ? toDate($line['calculate_start_date']) : '';
            $stockLine->calculate_end_date     = isset($line['calculate_end_date']) ? toDate($line['calculate_end_date']) : '';
            $stockLine->calculate_days         = isset($line['calculate_days']) ? $line['calculate_days'] : 0;
            $stockLine->line_type              = isset($line['line_type']) ? $line['line_type'] : '';
            $stockLine->premium_rate           = isset($line['premium_rate']) ? $line['premium_rate'] : '';
            $stockLine->invent_creation_date   = isset($line['invent_creation_date']) ? $line['invent_creation_date'] : '';
            $stockLine->invent_creation_by_id  = isset($line['invent_creation_by_id']) ? $line['invent_creation_by_id'] : '';
            $stockLine->invent_creation_by_name= isset($line['invent_creation_by_name']) ? $line['invent_creation_by_name'] : '';
            $stockLine->organization_id        = isset($line['organization_id']) ? $line['organization_id'] : '';
            $stockLine->organization_code      = isset($line['organization_code']) ? $line['organization_code'] : '';
            $stockLine->expense_flag           = isset($line['expense_flag']) ? $line['expense_flag'] : '';
            $stockLine->asset_group_code       = isset($line['asset_group_code']) ? $line['asset_group_code'] : ''; 
            $stockLine->stock_list_description = isset($line['stock_list_description']) ? $line['stock_list_description'] : ''; 
            $stockLine->premium_rate           = isset($line['premium_rate']) ? $line['premium_rate'] : 0;
            $stockLine->revenue_stamp          = isset($line['revenue_stamp']) ? $line['revenue_stamp'] : 0;
            $stockLine->tax                    = isset($line['tax']) ? $line['tax'] : 0;
            $stockLine->prepaid_insurance      = isset($line['prepaid_insurance']) ? $line['prepaid_insurance'] : 0;
            $stockLine->item_exp_account_id    = isset($line['item_exp_account_id']) ? $line['item_exp_account_id'] : 0;
            $stockLine->item_exp_account       = isset($line['item_exp_account']) ? $line['item_exp_account'] : 0;
            $stockLine->flag                   = isset($line['flag']) ? $line['flag'] : 0;
            $stockLine->program_code           = isset($line['program_code']) ? $line['program_code'] : '';

            $stockLine->row_id                 = isset($line['row_id']) ? $line['row_id'] : '';

            array_push($stock->rows, $stockLine);

        }
        $response = $this->service->createOrUpdate($stock);

        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\StockRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function createOrUpdate(StockRequest $request) {

    //     $requestData = $request->all()['data'];
        // $validator = Validator::make($requestData, [
        //     'status'               => 'required',
        //     'year'                 => 'required',
        //     'policy_set_header_id' => 'required',
        //     'department_code'      => 'required',
        // ]);
        // $validator->validate();
    //     $data['header_id']              = isset($requestData['header_id']) ? $requestData['header_id'] : '';
    //     $data['document_number']        = isset($requestData['document_number']) ? $requestData['document_number'] : '';
    //     $data['status']                 = isset($requestData['status']) ? strtoupper($requestData['status']) : '';
    //     $data['year']                   = isset($requestData['year']) ? $requestData['year'] : '';
    //     $data['period_name']            = isset($requestData['period_name']) ? $requestData['period_name'] : '';
    //     $data['period_from']            = isset($requestData['period_from']) ? convertMonthAndYearDate($requestData['period_from'], 'start') : '';
    //     $data['period_to']              = isset($requestData['period_to']) ? convertMonthAndYearDate($requestData['period_to'], 'end') : '';
    //     $data['policy_set_header_id']   = isset($requestData['policy_set_header_id']) ? (int)$requestData['policy_set_header_id'] : '';
    //     $data['policy_set_description'] = isset($requestData['policy_set_description']) ? $requestData['policy_set_description'] : '';
    //     $data['department_code']        = isset($requestData['department_code']) ? $requestData['department_code'] : '';
    //     $data['department_desc']        = isset($requestData['department_desc']) ? $requestData['department_desc'] : '';
    //     $data['total_amount']           = isset($requestData['total_amount']) ? $requestData['total_amount'] : '';
    //     $data['total_cover_amount']     = isset($requestData['total_cover_amount']) ? $requestData['total_cover_amount'] : '';
    //     $data['total_insu_amount']      = isset($requestData['total_insu_amount']) ? $requestData['total_insu_amount'] : '';
    //     $data['manual_amount']          = isset($requestData['manual_amount']) ? $requestData['manual_amount'] : '';
    //     $data['manual_cover_amount']    = isset($requestData['manual_cover_amount']) ? $requestData['manual_cover_amount'] : '';
    //     $data['manual_insu_amount']     = isset($requestData['manual_insu_amount']) ? $requestData['manual_insu_amount'] : '';
    //     $data['inventory_amount']       = isset($requestData['inventory_amount']) ? $requestData['inventory_amount'] : '';
    //     $data['inventory_cover_amount'] = isset($requestData['inventory_cover_amount']) ? $requestData['inventory_cover_amount'] : '';
    //     $data['inventory_insu_amount']  = isset($requestData['inventory_insu_amount']) ? $requestData['inventory_insu_amount'] : '';
    //     $data['expense_flag']           = isset($requestData['expense_flag']) ? $requestData['expense_flag'] : '';
    //     $data['rows']                   = isset($requestData['rows']) ? $requestData['rows'] : '';
    //     $data['program_code']           = isset($requestData['program_code']) ? $requestData['program_code'] : '';;
    //     $data['created_at']             = Carbon::now();
    //     $data['created_by_id']          = $this->userId;
    //     $data['created_by']             = $this->userId;
    //     $data['last_updated_by']        = $this->userId;
    //     $data['update_at']              = Carbon::now();
    //     $data['creation_date']          = Carbon::now();
    //     $data['last_update_date']       = Carbon::now();
    //     try {
    //         if ($data['document_number'] == '')
    //         {
    //             $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['header_id'])['document_number'];
    //         }
    //         $stockHeader = PtirStockHeaders::find($data['header_id']); 
    //         DB::beginTransaction();
    //         if ($stockHeader !== null) 
    //         {
    //             (new PtirStockHeaders())->updateStockHeaders($data);
    //             $this->headerId = $data['header_id'];
    //             $this->storeStockLines($data);
    //         } 
    //         else 
    //         {
    //             $ptirStockHeaders = PtirStockHeaders::create($data);
    //             $this->headerId = $ptirStockHeaders->header_id;
    //             $this->storeStockLines($data);
    //         }  
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withError($e->getMessage());
    //     }
      
    //     DB::commit();

    //     $obj = new \stdClass();
    //     $obj->header_id = $this->headerId;
    //     $obj->rows = $this->line_data;

    //     $response   = success($obj);

    //     return response($response, $response['status']);

    // }
    
    // private function storeStockLines($data)
    // {
    //     $i = 0;
    //     $amountInventory   = 0;
    //     $amountManual      = 0;
    //     $amountTotal       = 0;
    //     $coverageInventory = 0;
    //     $coverageManual    = 0;
    //     $coverageTotal     = 0;
    //     $premiumInventory  = 0;
    //     $premiumManual     = 0;
    //     $premiumTotal      = 0;
    //     $dutyInventory     = 0;
    //     $dutyManual        = 0;
    //     $dutyTotal         = 0;
    //     $vatInventory      = 0;
    //     $vatManual         = 0;
    //     $vatTotal          = 0;
    //     $netInventory      = 0;
    //     $netManual         = 0;
    //     $netTotal          = 0;

    //     $validator = Validator::make($data, [
    //         'row.*.line_number'          => 'required',
    //         'row.*.status'               => 'required',
    //         'row.*.year'                 => 'required',
    //         'row.*.sub_inventory_code'   => 'required',
    //         'row.*.coverage_amount'      => 'required',
    //         'row.*.line_type'            => 'required',
    //     ]);

    //     $validator->validate();
    //     foreach($data['rows'] as $index) {
    //         $data['header_id']              = $this->headerId;
    //         $data['line_id']                = isset($index['line_id']) ? $index['line_id'] : '';
    //         $data['line_number']            = isset($index['line_number']) ? (int)$index['line_number'] : '';
    //         $data['document_number']        = isset($index['document_number']) ? $index['document_number'] : '';
    //         $data['status']                 = isset($index['status']) ? strtoupper($index['status']) : '';
    //         $data['year']                   = isset($index['year']) ? $index['year'] : '';
    //         $data['period_name']            = isset($index['period_name']) ? $index['period_name'] : '';
    //         // $data['period_from']            = isset($index['period_from']) ? convertMonthAndYearDate($index['period_from'], 'start') : '';
    //         // $data['period_to']              = isset($index['period_to']) ? convertMonthAndYearDate($index['period_to'], 'end') : '';
    //         $data['department_description'] = $data['department_desc'];
    //         $data['org_id']                 = isset($index['org_id']) ? (int)$index['org_id'] : '';
    //         $data['sub_inventory_code']     = isset($index['sub_inventory_code']) ? $index['sub_inventory_code'] : '';
    //         $data['sub_inventory_desc']     = isset($index['sub_inventory_desc'] ) ? $index['sub_inventory_desc']  : '';
    //         $data['location_code']          = isset($index['location_code']) ? $index['location_code'] : '';
    //         $data['location_desc']          = isset($index['location_desc']) ? $index['location_desc'] : '';
    //         $data['item_id']                = isset($index['item_id']) ? (int)$index['item_id'] : '';
    //         $data['item_code']              = isset($index['item_code']) ? $index['item_code'] : '';
    //         $data['item_description']       = isset($index['item_description']) ? $index['item_description'] : '';
    //         $data['uom_code']               = isset($index['uom_code']) ? $index['uom_code'] : '';
    //         $data['original_quantity']      = isset($index['original_quantity']) ? $index['original_quantity'] : '';
    //         $data['unit_price']             = isset($index['unit_price']) ? $index['unit_price'] : '';
    //         $data['line_amount']            = isset($index['line_amount']) ? $index['line_amount'] : '';
    //         $data['coverage_amount']        = isset($index['coverage_amount']) ? $index['coverage_amount'] : '';
    //         $data['calculate_start_date']   = isset($index['calculate_start_date']) ? toDate($index['calculate_start_date']) : '';
    //         $data['calculate_end_date']     = isset($index['calculate_end_date']) ? toDate($index['calculate_end_date']) : '';
    //         $data['calculate_days']         = isset($index['calculate_days']) ? $index['calculate_days'] : 0;
    //         $data['line_type']              = isset($index['line_type']) ? $index['line_type'] : '';
    //         $data['premium_rate']           = isset($index['premium_rate']) ? $index['premium_rate'] : '';
    //         $data['invent_creation_date']   = isset($index['invent_creation_date']) ? $index['invent_creation_date'] : '';
    //         $data['invent_creation_by_id']  = isset($index['invent_creation_by_id']) ? $index['invent_creation_by_id'] : '';
    //         $data['invent_creation_by_name']= isset($index['invent_creation_by_name']) ? $index['invent_creation_by_name'] : '';
    //         $data['organization_id']        = isset($index['organization_id']) ? $index['organization_id'] : '';
    //         $data['organization_code']      = isset($index['organization_code']) ? $index['organization_code'] : '';
    //         $data['expense_flag']           = isset($index['expense_flag']) ? $index['expense_flag'] : '';
    //         $data['asset_group_code']       = isset($index['asset_group_code']) ? $index['asset_group_code'] : ''; 
    //         $data['stock_list_description'] = isset($index['stock_list_description']) ? $index['stock_list_description'] : ''; 
    //         $i += 1;

    //         $data['premium_rate']           = isset($index['premium_rate']) ? $index['premium_rate'] : 0;
    //         $data['revenue_stamp']          = isset($index['revenue_stamp']) ? $index['revenue_stamp'] : 0;
    //         $data['tax']                    = isset($index['tax']) ? $index['tax'] : 0;
    //         $data['prepaid_insurance']      = isset($index['prepaid_insurance']) ? $index['prepaid_insurance'] : 0;

        
    //         $groupProduct = (new PtirGroupProducts())->getAccountId($data['policy_set_header_id']);
            
    //         $data['item_exp_account_id']    = isset($groupProduct->account_id) ? $groupProduct->account_id : '';
           
    //         $accountMapping = (new PtirAccountsMapping())->getAccount($data['item_exp_account_id']);

    //         $data['item_exp_account']    = isset($accountMapping->account_combine) ? $accountMapping->account_combine : '';

    //         if ($data['premium_rate'] == '') {
    //             $rate = (new PtirPolicyGroupSets())->getPremiumRate($data['policy_set_header_id'], '', '', $data['year']);
    //             if ($rate != null) {
    //                 $data['premium_rate'] = $rate->premium_rate;
    //                 $data['revenue_stamp'] = $rate->revenue_stamp;
    //                 $data['tax'] = $rate->tax;
    //                 $data['prepaid_insurance'] = $rate->prepaid_insurance;
    //             }
    //         }
    //         $stockLine = PtirStockLines::find($data['line_id']); 
    //         if ($stockLine !== null)
    //         {
    //             (new PtirStockLines())->updateStockLines($data);
    //         }
    //         else
    //         {
    //             $data['invent_creation_date']    = Carbon::now();
    //             $data['invent_creation_by_id']   = $this->userId;
    //             $data['invent_creation_by_name'] = $this->userId; 
    //             $line = PtirStockLines::create($data);
    //             $data['line_id'] = $line->line_id;
    //             DB::commit();
    //         }

    //         $this->line_data[$i - 1]['line_id'] = $data['line_id'];
    //         $this->line_data[$i - 1]['row_id'] = $index['rowId']; 
    //         $periodName = date("Y-m-t", strtotime($data['period_name']));
    //         $explode = explode('-', $periodName);
    //         if ($data['line_type'] == 'INVENTORY' and $data['status'] == 'CONFIRMED' || $data['status'] == 'INTERFACE')
    //         {
    //             $amountInventory   = $amountInventory + $data['line_amount'];
    //             $coverageInventory = $coverageInventory + $data['coverage_amount']; 
    //             if ($data['program_code'] == 'IRP0001') {
    //                 $premiumCal        = (($data['coverage_amount'] * $data['premium_rate'])/100);
    //             } else {
    //                 $premiumCal        = ((($data['coverage_amount'] * $data['premium_rate'])/100) * $explode[2] / (date("z", mktime(0,0,0,12,31,$data['year']))+1));
    //             }
    //             $premiumInventory  = $premiumInventory + $premiumCal;
    //             $dutyCal           = ($premiumCal * $data['revenue_stamp']) / 100;
    //             $dutyInventory     = $dutyInventory + $dutyCal; 
    //             $vatCal            = (($premiumCal + $dutyCal) *  $data['tax']) / 100;
    //             $vatInventory      = $vatInventory + $vatCal; 
    //             $netInventory      = $netInventory + $premiumCal + $dutyCal + $vatCal;
    //         }
    //         else if ($data['line_type'] == 'MANUAL' and $data['status'] == 'CONFIRMED' || $data['status'] == 'INTERFACE')
    //         {
    //             $amountManual   = $amountManual + $data['line_amount'];
    //             $coverageManual = $coverageManual + $data['coverage_amount']; 
    //             $premiumCal     = (((($data['coverage_amount'] * $data['premium_rate'])/100) * $data['calculate_days']) / (date("z", mktime(0,0,0,12,31,$data['year']))+1));                
    //             $premiumManual  = $premiumManual + $premiumCal;
    //             $dutyCal        = ($premiumCal * $data['revenue_stamp']) / 100;
    //             $dutyManual     = $dutyManual + $dutyCal;
    //             $vatCal         = (($premiumCal + $dutyCal) *  $data['tax']) / 100;
    //             $vatManual      = $vatManual + $vatCal; 
    //             $netManual      += $premiumCal + $dutyCal + $vatCal;
    //         }
            
    //     }
        
    //     $amountTotal     = $amountTotal + $amountInventory + $amountManual;
    //     $coverageTotal   = $coverageTotal + $coverageInventory + $coverageManual;
    //     $premiumTotal    = $premiumTotal + $premiumManual + $premiumInventory;
    //     $dutyTotal      += $dutyInventory + $dutyManual;
    //     $vatTotal       += $vatInventory + $vatManual;
    //     $netTotal       += $netInventory + $netManual;

    //     $db = PtirStockHeaders::find($data['header_id']);             
    //     $db->total_amount           = $amountTotal;
    //     $db->total_cover_amount     = $coverageTotal;
    //     $db->total_insu_amount      = $premiumTotal;
    //     $db->manual_amount          = $amountManual;
    //     $db->manual_cover_amount    = $coverageManual;
    //     $db->manual_insu_amount     = $premiumManual;
    //     $db->inventory_amount       = $amountInventory;
    //     $db->inventory_cover_amount = $coverageInventory;
    //     $db->inventory_insu_amount  = $premiumInventory;
    //     $db->manual_vat_amount      = $vatManual;
    //     $db->manual_duty_amount     = $dutyManual;
    //     $db->manual_net_amount      = $netManual;
    //     $db->inventory_vat_amount   = $vatInventory;
    //     $db->inventory_duty_amount  = $dutyInventory;
    //     $db->inventory_net_amount   = $netInventory;
    //     $db->total_duty_amount      = $dutyTotal;
    //     $db->total_vat_amount       = $vatTotal;
    //     $db->total_net_amount       = $netTotal;
    //     $db->updated_at             = $data['update_at'];
    //     $db->last_updated_by        = $data['last_updated_by'];
    //     $db->last_update_date       = $data['last_update_date'];
    //     $db->save();
    // }
}