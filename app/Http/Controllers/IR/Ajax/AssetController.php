<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\AssetRequest;
use App\Models\IR\Views\PtirAssetHeadersView;
use App\Models\IR\Views\PtirAssetLinesView;
use App\Models\IR\Views\PtirAssetAdjustHeadersView;
use App\Models\IR\PtirAssetHeaders;
use App\Models\IR\PtirAssetLines;
use App\Models\IR\Assets;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\Views\PtirAssetAdjustLinesView;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

//สำหรับเช็ค account
use App\Models\IR\Settings\PtglCoaCompanyView       as Company;
use App\Models\IR\Settings\PtglCoaEvmView           as Evm;
use App\Models\IR\Settings\PtglCoaDeptCodeView      as Department;           
use App\Models\IR\Settings\PtglCoaCostCenterView    as CostCenter;
use App\Models\IR\Settings\PtglCoaBudgetYearView    as BudgetYear;
use App\Models\IR\Settings\PtglCoaBudgetTypeView    as BudgetType;
use App\Models\IR\Settings\PtglCoaBudgetDetailView  as BudgetDetail;
use App\Models\IR\Settings\PtglCoaBudgetReasonView  as BudgetReason;
use App\Models\IR\Settings\PtglCoaMainAccountView   as MainAccount;
use App\Models\IR\Settings\PtglCoaSubAccountView    as SubAccount;
use App\Models\IR\Settings\PtglCoaReserved1View     as Reserved1;
use App\Models\IR\Settings\PtglCoaReserved2View     as Reserved2;

use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Settings\PolicySetHeader;
class AssetController extends Controller
{
    protected $userId;
    protected $headerId;
    protected $line_data = [];

    public function __construct()
    {
        $this->userId = optional(auth()->user())->user_id ?? -1;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\IR\AssetRequest
     * @return \Illuminate\Http\Response
     */
    public function index(AssetRequest $request)
    {
        $collection = (new PtirAssetHeadersView())->getAllAssetHeaders($request->year,
            $request->insurance_start_date,
            $request->insurance_end_date,
            $request->policy_set_header_start,
            $request->policy_set_header_end,
            $request->as_of_date,
            $request->location_code,
            $request->status);
        $result = [];
        foreach ($collection as $obj) {
            $type = PtirAssetLinesView::select('net_amount',
                'receivable_name')
                ->where('header_id', $obj->header_id)
                ->whereRaw("receivable_name is not null")
                ->where('status', '=', 'CONFIRMED')
                ->get();
            $obj->type = $type;
            array_push($result, $obj);
        }

        $response = getResponse($result);
        return response($response, $response['status']);
    }

    public function fetch(AssetRequest $request)
    {
        //  ปิดการเช็ค duplicate ไปเช็ตจาก package แทน
        // if ($request->policy_set_header_start && $request->policy_set_header_end) {
        //     $check = PtirAssetHeadersView::whereRaw("year = nvl(?, year)
        //                                 and policy_set_header_id between nvl(?, policy_set_header_id) and nvl(?, policy_set_header_id)
        //                                 and as_of_date = nvl(to_date(?, 'dd/mm/yyyy'), as_of_date)
        //                                 and status in ('CONFIRMED', 'INTERFACE')
        //                                 and program_code = 'IRP0003'",
        //         [$request->year, $request->policy_set_header_start, $request->policy_set_header_end, $request->as_of_date])
        //         ->first();
        //     if ($check != null) {
        //         $response = error('ข้อมูลนี้เคยถูกดึงเรียบร้อยแล้ว', 400);
                
        //         return response($response, $response['status']);
        //         // $result['status'] == 'E';
        //         // $result['msg'] == 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว';
        //         // return response($result);
        //     }
        // }
        $result = (new Assets())->callGetAssets($request->year,
            $request->insurance_start_date,
            $request->insurance_end_date,
            $request->policy_set_header_start,
            $request->policy_set_header_end,
            $request->as_of_date,
            $request->location_code);
        if ($result['status'] == 'E') {
            return response($result);
            // return $result['msg'];
        }
        $collection = (new PtirAssetHeadersView())->getAllAssetHeaders($request->year,
            $request->insurance_start_date,
            $request->insurance_end_date,
            $request->policy_set_header_start,
            $request->policy_set_header_end,
            $request->as_of_date,
            $request->location_code,
            $request->status);

        $data = [];
        foreach ($collection as $obj) {
            \Log::info(" ----- IRP0003 fetch collection ----- ");
            $type = PtirAssetLinesView::select('net_amount',
                'receivable_name')
                ->where('header_id', $obj->header_id)
                ->whereRaw("receivable_name is not null")
                ->where('status', '=', 'CONFIRMED')
                ->get();
            $obj->type = $type;
            array_push($data, $obj);
            
            //อัพเดทการคำนวณ
            if ($obj->header_id) {
                \Log::info('--has header_id func fetch---');
                $this->calculateAsset($obj->header_id);

                $this->updateAssetFor2023();
            }
        }

        $response = getResponse($data);

        if ($result['status'] == 'W') {
            \Log::info('--Return---');
            \Log::info($result);
            $response['status'] = $result['status'];
            $response['msg']    = $result['msg'];
            return response($response);
        }

        // dd($response['status'], $result['status']);

        // return response($response, $result);
        return response($response, $response['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\IR\AssetRequest
     * @return \Illuminate\Http\Response
     */
    public function indexAdjustHeaders(AssetRequest $request)
    {
        $collection = (new PtirAssetAdjustHeadersView())->getAllAssetHeaders($request->year,
            $request->revision,
            $request->policy_id_from,
            $request->policy_id_to,
            $request->str_cal,
            $request->end_cal,
            $request->str_ad,
            $request->end_ad,
            $request->location_code,
            $request->status);

        $result = [];
        foreach ($collection as $obj) {
            $type = PtirAssetAdjustLinesView::select('net_amount',
                'receivable_name')
                ->where('header_id', $obj->header_id)
                ->whereRaw("receivable_name is not null")
                ->where('status', '=', 'CONFIRMED')
                ->get();

            $obj->type = $type;
            array_push($result, $obj);
        }

        $response = getResponse($result);

        return response($response, $response['status']);
    }

    public function fetchAdjustment(AssetRequest $request)
    {
        $result = (new Assets())->callGetAssetsAdjustment($request->year,
            $request->policy_id_from,
            $request->policy_id_to,
            $request->str_cal,
            $request->end_cal,
            $request->str_ad,
            $request->end_ad,
            $request->location_code);
        if ($result['status'] == 'E') {
            return response($result);
            // return $result['msg'];
        }
        $collection = (new PtirAssetAdjustHeadersView())->getAllAssetHeaders($request->year,
            $request->revision,
            $request->policy_id_from,
            $request->policy_id_to,
            $request->str_cal,
            $request->end_cal,
            $request->str_ad,
            $request->end_ad,
            $request->location_code,
            $request->status);

        $result = [];
        foreach ($collection as $obj) {
            $type = PtirAssetAdjustLinesView::select('net_amount',
                'receivable_name')
                ->where('header_id', $obj->header_id)
                ->whereRaw("receivable_name is not null")
                ->where('status', '!=', 'CANCELLED')
                ->get();
            $obj->type = $type;
            array_push($result, $obj);

            //อัพเดทการคำนวณ
            if ($obj->header_id) {
                $this->calculateAdjust($obj->header_id);
            }
        }

        $response = getResponse($result);

        return response($response, $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param App\Http\Requests\IR\Settings\AssetRequest
     * @return \Illuminate\Http\Response
     */
    public function show(AssetRequest $request)
    {
        $collection = (new PtirAssetLinesView())->getAssetLine($request->header_id,
            $request->year,
            $request->status,
            $request->policy_set_header_id,
            $request->input_status,
            $request->input_asset,
            $request->input_department);
        $response = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param App\Http\Requests\IR\Settings\AssetRequest
     * @return \Illuminate\Http\Response
     */
    public function showAdjustLines(AssetRequest $request)
    {
        $collection = (new PtirAssetAdjustLinesView())->getAssetLines($request->header_id,
            $request->status,
            $request->year,
            $request->policy_set_header_id,
            $request->input_status,
            $request->input_asset,
            $request->input_department);
        $response = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\IR\Settings\AssetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(AssetRequest $request)
    {
        $requestData = $request->all()['data'];
        $validator = Validator::make($requestData, [
            'status' => 'required',
            'year' => 'required',
            'policy_set_header_id' => 'required',
        ]);

        $validator->validate();
        $data['header_id'] = isset($requestData['header_id']) ? $requestData['header_id'] : '';
        $data['revision'] = isset($requestData['revision']) ? $requestData['revision'] : '';
        $data['document_number'] = isset($requestData['document_number']) ? $requestData['document_number'] : '';
        $data['status'] = isset($requestData['status']) ? $requestData['status'] : '';
        $data['asset_status'] = isset($requestData['asset_status']) ? $requestData['asset_status'] : '';
        $data['year'] = isset($requestData['year']) ? $requestData['year'] : '';
        $data['policy_set_header_id'] = isset($requestData['policy_set_header_id']) ? $requestData['policy_set_header_id'] : '';
        $data['policy_set_description'] = isset($requestData['policy_set_description']) ? $requestData['policy_set_description'] : '';
        $data['count_asset'] = isset($requestData['count_asset']) ? $requestData['count_asset'] : '';
        $data['total_cost'] = isset($requestData['total_cost']) ? $requestData['total_cost'] : '';
        $data['total_cover_amount'] = isset($requestData['total_cover_amount']) ? $requestData['total_cover_amount'] : '';
        $data['total_insu_amount'] = isset($requestData['total_insu_amount']) ? $requestData['total_insu_amount'] : '';
        $data['total_vat_amount'] = isset($requestData['total_vat_amount']) ? $requestData['total_vat_amount'] : '';
        $data['total_net_amount'] = isset($requestData['total_net_amount']) ? $requestData['total_net_amount'] : '';
        $data['total_rec_insu_amount'] = isset($requestData['total_rec_insu_amount']) ? $requestData['total_rec_insu_amount'] : '';
        $data['as_of_date'] = isset($requestData['as_of_date']) ? toDate($requestData['as_of_date']) : '';
        $data['start_calculate_date'] = isset($requestData['start_calculate_date']) ? toDate($requestData['start_calculate_date']) : '';
        $data['end_calculate_date'] = isset($requestData['end_calculate_date']) ? toDate($requestData['start_calculate_date']) : '';
        $data['start_addtion_date'] = isset($requestData['start_addtion_date']) ? toDate($requestData['start_calculate_date']) : '';
        $data['end_addtion_date'] = isset($requestData['end_addtion_date']) ? toDate($requestData['start_calculate_date']) : '';
        $data['insurance_start_date'] = isset($requestData['insurance_start_date']) ? toDate($requestData['insurance_start_date']) : '';
        $data['insurance_end_date'] = isset($requestData['insurance_end_date']) ? toDate($requestData['insurance_end_date']) : '';
        $data['rows'] = isset($requestData['rows']) ? $requestData['rows'] : '';
        $data['program_code'] = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        $data['created_by_id'] = $this->userId;
        $data['created_by'] = $this->userId;
        $data['updated_by_id'] = $this->userId;
        $data['last_updated_by'] = $this->userId;
        $data['creation_date'] = Carbon::now();
        $data['last_update_date'] = Carbon::now();
        $data['rows_delete'] = isset($requestData['rows_delete']) ? $requestData['rows_delete'] : '';

        try {
            $assetHeader = PtirAssetHeaders::find($data['header_id']);

            if ($assetHeader->document_number) {
                $data['document_number'] = $assetHeader ? $assetHeader->document_number : '';
            }else {
                $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['header_id'])['document_number'];
            }

            // if ($data['document_number'] == '') {
            //     $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['header_id'])['document_number'];
            // }
            DB::beginTransaction();
            $assetHeader = PtirAssetHeaders::find($data['header_id']);

            if ($assetHeader !== null) {
                (new PtirAssetHeaders())->updateAssetHeaders($data);
                $this->headerId = $data['header_id'];
            } else {
                $ptirAssetHeaders = PtirAssetHeaders::create($data);
                $this->headerId = $ptirAssetHeaders->header_id;
            }
            // $deleteLine = $this->deleteAssetLines($data);
            $assetLine = $this->storeAssetLines($data);

            if ($assetLine) {
                if ($assetLine['status'] == 'E') {
                    $response = error($assetLine['msg']);
                    DB::rollback();
                    return response($response, $response['status']);
                }
            }           

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }

        $obj = new \stdClass();
        $obj->header_id = $this->headerId;
        $obj->rows = $this->line_data;
        $obj->document_number = $data['document_number'];

        $response = success($obj);

        return response($response, $response['status']);
    }

    private function storeAssetLines($data)
    {
        $header = PtirAssetHeaders::find($this->headerId);
        $transactionAmount = 0;
        $totalCoverAmount = 0;
        $totalPremium = 0;
        $vat = 0;
        $netAmount = 0;
        $premiumIncrease = 0;
        $totalDuty = 0;
        $totalCost = 0;
        $i = 0;
        foreach ($data['rows'] as $index) {
            $validator = Validator::make($index, [
                'line_number' => 'required',
                'status' => 'required',
                'year' => 'required',
            ]);
            $validator->validate();
            $data['header_id'] = $this->headerId;
            $data['line_id'] = isset($index['line_id']) ? $index['line_id'] : '';
            $data['line_number'] = isset($index['line_number']) ? $index['line_number'] : '';
            $data['status'] = isset($index['status']) ? strtoupper($index['status']) : '';
            $data['asset_status'] = isset($index['asset_status']) ? $index['asset_status'] : '';
            $data['year'] = isset($index['year']) ? $index['year'] : '';
            $data['department_location_code'] = isset($index['department_location_code']) ? $index['department_location_code'] : '';
            $data['department_location_desc'] = isset($index['department_location_desc']) ? $index['department_location_desc'] : '';
            $data['department_cost_code'] = isset($index['department_cost_code']) ? $index['department_cost_code'] : '';
            $data['department_cost_desc'] = isset($index['department_cost_desc']) ? $index['department_cost_desc'] : '';
            $data['account_id'] = isset($index['account_id']) ? $index['account_id'] : '';
            $data['account_code'] = isset($index['account_code']) ? $index['account_code'] : '';
            $data['account_code_desc'] = isset($index['account_code_desc']) ? $index['account_code_desc'] : '';
            $data['asset_number'] = isset($index['asset_number']) ? $index['asset_number'] : '';
            $data['department_code'] = isset($index['department_code']) ? $index['department_code'] : '';
            $data['department_name'] = isset($index['department_name']) ? $index['department_name'] : '';
            $data['location_id'] = isset($index['location_id']) ? $index['location_id'] : '';
            $data['location_code'] = isset($index['location_code']) ? $index['location_code'] : '';
            $data['location_name'] = isset($index['location_name']) ? $index['location_name'] : '';
            $data['category_code'] = isset($index['category_code']) ? $index['category_code'] : '';
            $data['category_description'] = isset($index['category_description']) ? $index['category_description'] : '';
            $data['adjustment_source_type'] = isset($index['adjustment_source_type']) ? $index['adjustment_source_type'] : '';
            $data['adjustment_date'] = isset($index['adjustment_date']) ? toDate($index['adjustment_date']) : '';
            $data['adjustment_amount'] = isset($index['adjustment_amount']) ? $index['adjustment_amount'] : 0;
            $data['adjustment_line_id'] = isset($index['adjustment_line_id']) ? $index['adjustment_line_id'] : '';
            $data['adjustment_cost'] = isset($index['adjustment_cost']) ? $index['adjustment_cost'] : '';
            $data['adjustment_type'] = isset($index['adjustment_type']) ? $index['adjustment_type'] : '';
            $data['quantity'] = isset($index['quantity']) ? $index['quantity'] : '';
            $data['current_cost'] = isset($index['current_cost']) ? $index['current_cost'] : '';
            $data['coverage_amount'] = isset($index['coverage_amount']) ? $index['coverage_amount'] : 0;
            $data['insurance_amount'] = isset($index['insurance_amount']) ? $index['insurance_amount'] : '';
            $data['vat_amount'] = isset($index['vat_amount']) ? round($index['vat_amount'], 2) : '';
            $data['net_amount'] = isset($index['net_amount']) ? $index['net_amount'] : '';
            $data['receivable_code'] = isset($index['receivable_code']) ? $index['receivable_code'] : '';
            $data['receivable_name'] = isset($index['receivable_name']) ? $index['receivable_name'] : '';
            $data['calculate_start_date'] = $header->start_calculate_date;
            $data['calculate_end_date'] = $header->end_calculate_date;
            $data['expense_flag'] = isset($index['expense_flag']) ? $index['expense_flag'] : '';
            $data['line_type'] = isset($index['line_type']) ? $index['line_type'] : '';
            $data['duty_amount'] = isset($index['duty_amount']) ? $index['duty_amount'] : '';
            $data['premium_rate'] = isset($index['premium_rate']) ? $index['premium_rate'] : '';
            $data['revenue_stamp'] = isset($index['revenue_stamp']) ? $index['revenue_stamp'] : '';
            $data['tax'] = isset($index['tax']) ? $index['tax'] : '';
            $data['prepaid_insurance'] = isset($index['prepaid_insurance']) ? $index['prepaid_insurance'] : '';
            $data['asset_group_code'] = isset($index['asset_group_code']) ? $index['asset_group_code'] : '';
            $data['stock_list_description'] = isset($index['stock_list_description']) ? $index['stock_list_description'] : '';
            $i += 1;
            if ($index['account_id'] == '') {
                $account_combine = DB::table('ptgl_account_code_v')->where('concatenated_segments',$index['account_code'])->first();
                if($account_combine){
                    $index['account_id'] = $account_combine->code_combination_id;
                }else{
                    $account['status'] = 'E';
                    $account['msg'] = 'ไม่มีรหัสบัญชีนี้ โปรดเลือกบัญชีใหม่ '.$index['account_code'];
                    return $account;
                }
            }

            $data['account_id'] = isset($index['account_id']) ? $index['account_id'] : '';

            $insurance_amount = $data['insurance_amount'];
            $duty_amount      = $data['duty_amount'];
            $net_amount        = $data['net_amount'];

            $policySetHeader = PolicySetHeader::where('policy_set_header_id', $header->policy_set_header_id)->first();
            
            $data['include_tax_flag'] = $policySetHeader->include_tax_flag;

            // W. 27/06/22 แก้ไขแยกเงื่อนไขการคำนวณ ของ IRP0003 และ IRP0004
            if ($data['program_code'] == 'IRP0004') {
                if ($policySetHeader->include_tax_flag == 'Y') {
                    $end_month_28_365 = round($net_amount, 2) * 28 / $header->day_num;
                    $end_month_29_366 = round($net_amount, 2) * 29 / $header->day_num;
                    $end_month_30_365 = round($net_amount, 2) * 30 / $header->day_num;
                    $end_month_30_366 = round($net_amount, 2) * 30 / $header->day_num;
                    $end_month_31_365 = round($net_amount, 2) * 31 / $header->day_num;
                    $end_month_31_366 = round($net_amount, 2) * 31 / $header->day_num;
    
                    $data['end_month_28_365'] = round($end_month_28_365, 2);
                    $data['end_month_29_366'] = round($end_month_29_366, 2);
                    $data['end_month_30_365'] = round($end_month_30_365, 2);
                    $data['end_month_30_366'] = round($end_month_30_366, 2);
                    $data['end_month_31_365'] = round($end_month_31_365, 2);
                    $data['end_month_31_366'] = round($end_month_31_366, 2);
    
                } else {
                    $end_month_28_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 28 / $header->day_num;
                    $end_month_29_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 29 / $header->day_num;
                    $end_month_30_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / $header->day_num;
                    $end_month_30_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / $header->day_num;
                    $end_month_31_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / $header->day_num;
                    $end_month_31_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / $header->day_num;
                    
                    $data['end_month_28_365'] = round($end_month_28_365, 2);
                    $data['end_month_29_366'] = round($end_month_29_366, 2);
                    $data['end_month_30_365'] = round($end_month_30_365, 2);
                    $data['end_month_30_366'] = round($end_month_30_366, 2);
                    $data['end_month_31_365'] = round($end_month_31_365, 2);
                    $data['end_month_31_366'] = round($end_month_31_366, 2);
                }
            } else {
                if ($policySetHeader->include_tax_flag == 'Y') {
                    $end_month_28_365 = round($net_amount, 2) * 28 / 365;
                    $end_month_29_366 = round($net_amount, 2) * 29 / 366;
                    $end_month_30_365 = round($net_amount, 2) * 30 / 365;
                    $end_month_30_366 = round($net_amount, 2) * 30 / 366;
                    $end_month_31_365 = round($net_amount, 2) * 31 / 365;
                    $end_month_31_366 = round($net_amount, 2) * 31 / 366;
    
                    $data['end_month_28_365'] = round($end_month_28_365, 2);
                    $data['end_month_29_366'] = round($end_month_29_366, 2);
                    $data['end_month_30_365'] = round($end_month_30_365, 2);
                    $data['end_month_30_366'] = round($end_month_30_366, 2);
                    $data['end_month_31_365'] = round($end_month_31_365, 2);
                    $data['end_month_31_366'] = round($end_month_31_366, 2);
    
                } else {
                    $end_month_28_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 28 / 365;
                    $end_month_29_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 29 / 366;
                    $end_month_30_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / 365;
                    $end_month_30_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / 366;
                    $end_month_31_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / 365;
                    $end_month_31_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / 366;
                    
                    $data['end_month_28_365'] = round($end_month_28_365, 2);
                    $data['end_month_29_366'] = round($end_month_29_366, 2);
                    $data['end_month_30_365'] = round($end_month_30_365, 2);
                    $data['end_month_30_366'] = round($end_month_30_366, 2);
                    $data['end_month_31_365'] = round($end_month_31_365, 2);
                    $data['end_month_31_366'] = round($end_month_31_366, 2);
                }
            }
            


            if ($data['status'] == 'CONFIRMED' || $data['status'] == 'INTERFACE') {
                // $transactionAmount = $transactionAmount + $data['adjustment_amount'];
                // $totalCoverAmount = $totalCoverAmount + $data['coverage_amount'];
                // $totalPremium = $totalPremium + $data['insurance_amount'];
                // $vat = $vat + $data['vat_amount'];
                // $netAmount = $netAmount + $data['net_amount'];
                // $totalDuty += $data['duty_amount'] ?? 0;
                // $totalCost += $data['current_cost'] == '' || $data['current_cost'] == null ? 0 : $data['current_cost'];
                // if ($data['receivable_name'] != '') {

                //     $premiumIncrease = $premiumIncrease + $data['net_amount'];
                // }
                //  ปรับแก้ให้ มี การ round ก่อนเก็บข้อมูล
                $transactionAmount = $transactionAmount + round($data['adjustment_amount'], 2);
                $totalCoverAmount = $totalCoverAmount + round($data['coverage_amount'], 2);
                $totalPremium = $totalPremium + round($data['insurance_amount'], 2);
                $vat = $vat + round($data['vat_amount'], 2);
                $netAmount = $netAmount + round($data['net_amount'], 2);
                $totalDuty += round($data['duty_amount'] ?? 0, 2);
                $totalCost += $data['current_cost'] == '' || $data['current_cost'] == null ? 0 : round($data['current_cost'], 2);
                if ($data['receivable_name'] != '') {

                    $premiumIncrease = $premiumIncrease + round($data['net_amount'], 2);
                }
            }

            $stockLine = PtirAssetLines::find($data['line_id']);
            if ($stockLine !== null) {
                (new PtirAssetLines())->updateAssetLines($data);
            } else {
                $line = PtirAssetLines::create($data);
                $data['line_id'] = $line->line_id;
            }

            $this->line_data[$i - 1]['line_id'] = $data['line_id'];
            $this->line_data[$i - 1]['row_id'] = $index['rowId'];
        }

        $db = PtirAssetHeaders::find($data['header_id']);
        $db->total_adjustment_cost = $transactionAmount;
        $db->total_cost = $totalCost;
        $db->total_cover_amount = $totalCoverAmount;
        $db->total_insu_amount = $totalPremium;
        $db->total_vat_amount = $vat;
        $db->total_net_amount = $netAmount;
        $db->total_rec_insu_amount = $premiumIncrease;
        $db->total_duty_amount = $totalDuty;
        $db->updated_at = $data['updated_at'];
        $db->updated_by_id = $data['updated_by_id'];
        $db->last_update_date = $data['last_update_date'];
        $db->save();
    }

    public function inputFilterIrp($header_id,$program_code)
    {
        $status = DB::select("select DISTINCT status from ptir_asset_lines where program_code = '".$program_code."' and header_id =".$header_id);
        $department_codes = DB::select("select DISTINCT department_code , department_name from ptir_asset_lines where header_id = ".$header_id." ORDER BY department_code ASC");
        $asset_numbers = DB::select("select DISTINCT asset_number from ptir_asset_lines where header_id = ".$header_id." ORDER BY asset_number ASC");
        $response = array(
            'status' => $status,
            'asset_numbers' => $asset_numbers,
            'department_codes' => $department_codes
        );
        return response($response, 200);
    }

    public function validateAccount()
    {
        $segment1  = (new Company)->getDesciption(request()->segmentAlls[0]);
        $segment2  = (new Evm)->getDesciption(request()->segmentAlls[1]);
        $segment3  = (new Department)->getDesciption(request()->segmentAlls[2]);
        $segment4  = (new CostCenter)->getDesciption(request()->segmentAlls[3], request()->segmentAlls[2]);
        $segment5  = (new BudgetYear)->getDesciption(request()->segmentAlls[4]);
        $segment6  = (new BudgetType)->getDesciption(request()->segmentAlls[5]);
        $segment7  = (new BudgetDetail)->getDesciption(request()->segmentAlls[6], request()->segmentAlls[5]);
        $segment8  = (new BudgetReason)->getDesciption(request()->segmentAlls[7]);
        $segment9  = (new MainAccount)->getDesciption(request()->segmentAlls[8]);
        $segment10 = (new SubAccount)->getDesciption(request()->segmentAlls[9], request()->segmentAlls[8]);
        $segment11 = (new Reserved1)->getDesciption(request()->segmentAlls[10]);
        $segment12 = (new Reserved2)->getDesciption(request()->segmentAlls[11]);

        $response['data'] = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;
        
        $response['desc'] = $segment3.'.'.$segment9.'.'.$segment10;

        // W. 29/06/22 เช็ค Account CCID --- start---
        if (request()->coaEnter) {
            $account_combine = DB::table('ptgl_account_code_v')->where('concatenated_segments', request()->coaEnter)->first();
            if($account_combine){
                $index['account_id'] = $account_combine->code_combination_id;
            }else{
                $response['status'] = 'E';
                $response['msg'] = 'ไม่มีรหัสบัญชีนี้ โปรดเลือกบัญชีใหม่ '. request()->coaEnter;
                // return $account;
                return response($response);

            }
        }
        // --- end ---

        return response($response);
    }

    public function destroy()
    {
        $line = PtirAssetLines::find(request()->line_id);
        $line->delete();

        return response('success');
    }

    public function calculateAsset($headerId)
    {
        $assetHeader = PtirAssetHeaders::find($headerId);
        $collection = (new PtirPolicyGroupSets())->getPremiumRate($assetHeader->policy_set_header_id, $assetHeader->insurance_start_date, $assetHeader->insurance_end_date, $assetHeader->year);

        $insurance_amount_master = $collection->premium_rate;
        $vat_amount_master       = $collection->tax;
        $prepaid_insurance       = $collection->prepaid_insurance;
        $revenue_stamp           = $collection->revenue_stamp;

        
        $assetLines = PtirAssetLines::where('header_id', $assetHeader->header_id)->get();

        foreach ($assetLines as $line) {
            $insurance_amount = $line->coverage_amount * $insurance_amount_master / 100;
            $duty_amount      = round($insurance_amount, 2) * $revenue_stamp / 100;
            $vat_amount       = (round($insurance_amount, 2) + round($duty_amount, 2)) * $vat_amount_master / 100;
            $net_amount       = round($insurance_amount, 2) + round($duty_amount, 2) + round($vat_amount, 2);
            
            // \Log::info("--- calculateAsset ---");
            // \Log::info("--- vat_amount --- : $vat_amount");
            // \Log::info(round($vat_amount, 2));

            $line->premium_rate      = $insurance_amount_master;
            $line->revenue_stamp     = $revenue_stamp;
            $line->tax               = $vat_amount_master;
            $line->prepaid_insurance = $prepaid_insurance;

            $line->insurance_amount = round($insurance_amount, 2);
            $line->duty_amount      = round($duty_amount, 2);
            $line->vat_amount       = round($vat_amount, 2);
            $line->net_amount       = round($net_amount, 2);

            if ($line->include_tax_flag == 'Y') {
                $end_month_28_365 = round($net_amount, 2) * 28 / 365;
                $end_month_29_366 = round($net_amount, 2) * 29 / 366;
                $end_month_30_365 = round($net_amount, 2) * 30 / 365;
                $end_month_30_366 = round($net_amount, 2) * 30 / 366;
                $end_month_31_365 = round($net_amount, 2) * 31 / 365;
                $end_month_31_366 = round($net_amount, 2) * 31 / 366;

                $line->end_month_28_365 = round($end_month_28_365, 2);
                $line->end_month_29_366 = round($end_month_29_366, 2);
                $line->end_month_30_365 = round($end_month_30_365, 2);
                $line->end_month_30_366 = round($end_month_30_366, 2);
                $line->end_month_31_365 = round($end_month_31_365, 2);
                $line->end_month_31_366 = round($end_month_31_366, 2);

            } else {
                $end_month_28_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 28 / 365;
                $end_month_29_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 29 / 366;
                $end_month_30_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / 365;
                $end_month_30_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 30 / 366;
                $end_month_31_365 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / 365;
                $end_month_31_366 = (round($insurance_amount, 2) + round($duty_amount, 2)) * 31 / 366;
                
                $line->end_month_28_365 = round($end_month_28_365, 2);
                $line->end_month_29_366 = round($end_month_29_366, 2);
                $line->end_month_30_365 = round($end_month_30_365, 2);
                $line->end_month_30_366 = round($end_month_30_366, 2);
                $line->end_month_31_365 = round($end_month_31_365, 2);
                $line->end_month_31_366 = round($end_month_31_366, 2);
            }

            $line->save();
        }

        \Log::info(" ----- calculateAsset ----- ");

        // return true;
    }

    public function calculateAdjust($headerId)
    {
        $assetHeader = PtirAssetHeaders::find($headerId);
        $collection = (new PtirPolicyGroupSets())->getPremiumRate($assetHeader->policy_set_header_id, $assetHeader->insurance_start_date, $assetHeader->insurance_end_date, $assetHeader->year);

        $insurance_amount_master = $collection->premium_rate;
        $vat_amount_master       = $collection->tax;
        $prepaid_insurance       = $collection->prepaid_insurance;
        $revenue_stamp           = $collection->revenue_stamp;

        
        $assetLines = PtirAssetLines::where('header_id', $assetHeader->header_id)->get();

        foreach ($assetLines as $line) {
            $insurance_amount       = $line->coverage_amount * $insurance_amount_master / 100;
            $total_insurance_amount = round($insurance_amount, 2) * $assetHeader->day_num / $assetHeader->total_day_num;
            $duty_amount            = round($total_insurance_amount, 2) * $revenue_stamp / 100;
            $vat_amount             = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * $vat_amount_master / 100;
            $net_amount             = round($total_insurance_amount, 2) + round($duty_amount, 2) + round($vat_amount, 2);
            
            // \Log::info("--- calculateAsset ---");
            // \Log::info("--- vat_amount --- : $vat_amount");
            // \Log::info(round($vat_amount, 2));
            $line->premium_rate      = $insurance_amount_master;
            $line->revenue_stamp     = $revenue_stamp;
            $line->tax               = $vat_amount_master;
            $line->prepaid_insurance = $prepaid_insurance;

            $line->insurance_amount = round($total_insurance_amount, 2);
            $line->duty_amount      = round($duty_amount, 2);
            $line->vat_amount       = round($vat_amount, 2);
            $line->net_amount       = round($net_amount, 2);

            if ($line->include_tax_flag == 'Y') {
                $end_month_28_365 = round($net_amount, 2) * 28 / $assetHeader->day_num;
                $end_month_29_366 = round($net_amount, 2) * 29 / $assetHeader->day_num;
                $end_month_30_365 = round($net_amount, 2) * 30 / $assetHeader->day_num;
                $end_month_30_366 = round($net_amount, 2) * 30 / $assetHeader->day_num;
                $end_month_31_365 = round($net_amount, 2) * 31 / $assetHeader->day_num;
                $end_month_31_366 = round($net_amount, 2) * 31 / $assetHeader->day_num;

                $line->end_month_28_365 = round($end_month_28_365, 2);
                $line->end_month_29_366 = round($end_month_29_366, 2);
                $line->end_month_30_365 = round($end_month_30_365, 2);
                $line->end_month_30_366 = round($end_month_30_366, 2);
                $line->end_month_31_365 = round($end_month_31_365, 2);
                $line->end_month_31_366 = round($end_month_31_366, 2);

            } else {
                $end_month_28_365 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 28 / $assetHeader->day_num;
                $end_month_29_366 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 29 / $assetHeader->day_num;
                $end_month_30_365 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 30 / $assetHeader->day_num;
                $end_month_30_366 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 30 / $assetHeader->day_num;
                $end_month_31_365 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 31 / $assetHeader->day_num;
                $end_month_31_366 = (round($total_insurance_amount, 2) + round($duty_amount, 2)) * 31 / $assetHeader->day_num;
                
                
                $line->end_month_28_365 = round($end_month_28_365, 2);
                $line->end_month_29_366 = round($end_month_29_366, 2);
                $line->end_month_30_365 = round($end_month_30_365, 2);
                $line->end_month_30_366 = round($end_month_30_366, 2);
                $line->end_month_31_365 = round($end_month_31_365, 2);
                $line->end_month_31_366 = round($end_month_31_366, 2);
            }

            $line->save();
        }

        \Log::info(" ----- calculateAdjust ----- ");
    }

    public function checkDuplicate(AssetRequest $request)
    {
        $result = (new Assets())->callCheckDupAssets($request->year,
            $request->insurance_start_date,
            $request->insurance_end_date,
            $request->policy_set_header_start,
            $request->policy_set_header_end,
            $request->as_of_date,
            $request->location_code);
        // if ($result['status'] == 'S') {
        //     $this->fetch($request);
        // } else {
            $response['status'] = $result['status'];
            $response['msg']    = $result['msg'];

            return response($response);
        // }
    }

    public function updateAssetFor2023()
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            return_status      varchar2(1)   :=  NULL;
                            return_msg         varchar2(4000)  :=  NULL;
                        BEGIN
                            PTIR_WEB_UTILITIES_PKG.UPDATE_ASSET
                            (
                                O_RETURN_STATUS => :return_status, 
                                O_RETURN_MSG    => :return_msg
                            );				
                        END;


                    ";
        \Log::info($sql);
        $result = [];
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info(" ----- Start Call updateAssetFor2023 ----- ");
        \Log::info($result['status']);
        \Log::info($result['msg']);
        \Log::info(" ----- End Call updateAssetFor2023 ----- ");

        return $result;
    }
}
