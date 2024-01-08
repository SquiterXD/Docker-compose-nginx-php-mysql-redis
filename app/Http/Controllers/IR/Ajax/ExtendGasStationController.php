<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\ExtendGasStationsRequest;
use App\Http\Requests\IR\Settings\GasStationSRequest;
use App\Models\IR\GasStations;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\PtirExtendGasStations;
use App\Models\IR\Settings\PtirAccountsMapping;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\Settings\PtirGasStations;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
class ExtendGasStationController extends Controller
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
     * @param  App\Http\Requests\IR\Settings\ExtendGasStationsRequest 
     * @return \Illuminate\Http\Response
     */
    public function index(ExtendGasStationsRequest $request) 
    {
        $collection = (new PtirExtendGasStations())->getAllExtendGasStation(
            $request->year, 
            $request->type_code, 
            $request->group_code,
            $request->status,
            'search'
        );
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    public function checkFetch(ExtendGasStationsRequest $request)
    {
        $pYear = +($request->year) - 543;
        $typeCode = $request->type_code;
        $groupCode = $request->group_code;
        $deptFrom = $request->department_from;
        $deptTo = $request->department_to;

        
        $msg = '';

        // $checkDataAll = PtirExtendGasStations::where("year", $pYear)
        // // ->where(function ($q){
        // //     return $q->whereIn('status', ['CONFIRMED', 'INTERFACE', 'NEW'])
        // //     ->whereNotNull('document_number');
        // // })
        // ->when(!!$typeCode, function($q) use($typeCode){
        //     return $q->where('type_code', $typeCode);
        // })
        // ->when(!!$groupCode, function($q) use($groupCode){
        //     return $q->where('group_code', $groupCode);
        // })
        // ->when(!!$deptFrom, function($q) use($deptFrom){
        //     return $q->where('department_code', '>=', $deptFrom);
        // })
        // ->when(!!$deptTo, function($q) use($deptTo){
        //     return $q->where('department_code', '<=', $deptTo);
        // })
        // ->get();

        $checkDataAll = \DB::select("
            SELECT  gs.gas_station_id                 gas_station_id
                    ,'NEW'                            STATUS          
                    ,dept.DEPARTMENT_CODE             DEPARTMENT_CODE
                    ,dept.description                 DEPARTMENT_NAME
                    ,gs.group_code                    GROUP_CODE   
                    ,nvl(GSG.DESCRIPTION,GSG.meaning) GROUP_NAME
                    ,GS.TYPE_CODE                     TYPE_CODE
                    ,GST.DESCRIPTION                  TYPE_NAME                       
                    ,'IRP0006'                        program_code
                    ,gs.active_flag  
            FROM    OAIR.PTIR_GAS_STATIONS       gs
                    ,OAIR.PTIR_GAS_STATION_TYPES  gst
                    ,OAIR.PTIR_GROUPS             gsg
                    ,APPS.PTIR_ACCOUNTS_MAPPING_V gcc
                    ,APPS.PTGL_COA_DEPT_CODE_V    dept
                    
                    ,OAIR.PTIR_POLICY_SET_HEADERS  psh
                    ,OAIR.PTIR_POLICY_CATEGORY_V   pc
                    
                    ,APPS.PTIR_ACCOUNTS_MAPPING_V   PAM
            WHERE   1 = 1
            AND     gs.type_code      = gst.lookup_code
            AND     gs.group_code     = gsg.lookup_code
            AND     gs.account_id     = gcc.account_id(+)
            AND     gcc.segment_3     = dept.department_code(+)
            
            AND     gs.policy_set_header_id   = psh.policy_set_header_id
            AND     psh.policy_category_code  = pc.lookup_code(+)
            AND     psh.gl_expense_account_id = PAM.ACCOUNT_ID (+)

            ORDER BY gs.gas_station_id ASC
        ");

        $countData = count($checkDataAll);

        $hasData = PtirExtendGasStations::where("year", $pYear)
                    ->whereNotNull('document_number')
                    ->when(!!$typeCode, function($q) use($typeCode){
                        return $q->where('type_code', $typeCode);
                    })
                    ->when(!!$groupCode, function($q) use($groupCode){
                        return $q->where('group_code', $groupCode);
                    })
                    ->when(!!$deptFrom, function($q) use($deptFrom){
                        return $q->where('department_code', '>=', $deptFrom);
                    })
                    ->when(!!$deptTo, function($q) use($deptTo){
                        return $q->where('department_code', '<=', $deptTo);
                    })
                    ->get();

        $countHasData = count($hasData);

        if ($countHasData == 0) {
            $status = 'S';
        }elseif ($countHasData < $countData) {
            $text = '';

            foreach ($hasData->pluck('type_name') as $index => $data) {
                if ($index == 0) {
                    $text = $data;
                } else {
                    $text = $text . ', ' . $data;
                }
            }

            $msg    = 'ประเภทสถานีน้ำมัน '. $text . ' ถูกดึงข้อมูลเรียบร้อยแล้ว ต้องการดึงข้อมูลต่อหรือไม่';
            $status = 'W';
        }elseif ($countHasData == $countData) {
            $msg    = 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบ';
            $status = 'E';
        }

        // dd($countData, $countHasData);


        // if(!!$hasData->count()){
        //     $msg = 'รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว กรุณาตรวจสอบ';
        // }

        return response()->json([
            'valid'  => !$hasData->count(),
            'msg'    => $msg,
            'status' => $status,
        ]);
    }

    public function fetch(ExtendGasStationsRequest $request)
    {
        $result = (new GasStations())->callGetGasStation(
            $request->year,
            $request->type_code,
            $request->group_code,
            $request->department_from,
            $request->department_to
        );
                                                
        if ($result['status'] == 'E')
        {
            // $response = error('msg');
            // return response($response, $response['status']);

            return response($result);
        }

        $collection = (new PtirExtendGasStations())->getAllExtendGasStation(
            $request->year, 
            $request->type_code, 
            $request->group_code,
            'NEW',
            'fetch'
        );
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\ExtendGasStationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(ExtendGasStationsRequest $request)
    {
        $requestData = $request->all()['data'];
        $i = 0;
        foreach($requestData as $index)
        {
            $validator = Validator::make($index, [
                'status'               => 'required',
            ]);

            $validator->validate();
            $data['ex_gas_station_id']      = isset($index['ex_gas_station_id']) ? $index['ex_gas_station_id'] : '';
            $data['gas_station_id']         = isset($index['gas_station_id']) ? $index['gas_station_id'] : '';
            $data['document_number']        = isset($index['document_number']) ? $index['document_number'] : '';
            $data['reference_document_number'] = isset($index['reference_document_number']) ? $index['reference_document_number'] : '';
            $data['status']                 = isset($index['status']) ? strtoupper($index['status']) : '';
            $data['year']                   = isset($index['year']) ? convertYearToAd($index['year']) : '';
            $data['start_date']             = isset($index['start_date']) ? parseFromDateTh($index['start_date']) : '';
            $data['end_date']               = isset($index['end_date']) ? parseFromDateTh($index['end_date']) : '';
            $data['total_days']             = isset($index['total_days']) ? $index['total_days']  : '';
            $data['department_code']        = isset($index['department_code']) ? $index['department_code'] : '';
            $data['department_name']        = isset($index['department_name']) ? $index['department_name'] : '';
            $data['group_code']             = isset($index['group_code']) ? $index['group_code'] : '';
            $data['group_name']             = isset($index['group_name']) ? $index['group_name'] : '';
            $data['type_code']              = isset($index['type_code']) ? $index['type_code'] : '';
            $data['type_name']              = isset($index['type_code']) ? $index['type_code'] : '';
            $data['insurance_amount']       = isset($index['insurance_amount']) ? $index['insurance_amount'] : '';
            $data['discount']               = isset($index['discount']) ? str_replace(',', '',$index['discount']) : 0;
            $data['duty_amount']            = isset($index['duty_amount']) ? str_replace(',', '',$index['duty_amount']) : '';
            $data['vat_amount']             = isset($index['vat_amount']) ? str_replace(',', '',$index['vat_amount']) : '';
            $data['net_amount']             = isset($index['net_amount']) ? str_replace(',', '',$index['net_amount']) : '';
            $data['vat_refund']             = isset($index['vat_refund']) ? $index['vat_refund'] : '';
            $data['policy_number']          = isset($index['policy_number']) ? $index['policy_number'] : '';
            $data['company_id']             = isset($index['company_id']) ? $index['company_id'] : '';
            $data['company_name']           = isset($index['company_name']) ? $index['company_name'] : '';
            $data['expense_account']        = isset($index['expense_account']) ? $index['expense_account'] : '';
            $data['expense_account_desc']   = isset($index['expense_account_desc']) ? $index['expense_account_desc'] : '';
            $data['expense_flag']           = isset($index['expense_flag']) ? $index['expense_flag'] : '';
            $data['policy_set_header_id']   = isset($index['policy_set_header_id']) ? $index['policy_set_header_id'] : '';
            $data['program_code']           = isset($index['program_code']) ? $index['program_code'] : 'IRP0006';
            // $data['line_type']              = isset($index['line_type']) ? $index['line_type'] : '';
            $data['created_at']             = Carbon::now();
            $data['created_by_id']          = $this->userId;
            $data['created_by']             = $this->userId;
            $data['last_updated_by']        = $this->userId;
            $data['updated_at']             = Carbon::now();
            $data['creation_date']          = Carbon::now();
            $data['last_update_date']       = Carbon::now();

            $data['coverage_amount']       = isset($index['coverage_amount']) ? $index['coverage_amount'] : '';

            // W. 20/12/22 เพิ่มการคำนวณ end_month
            if ($data['vat_refund'] == 'N') {
                $end_month_28_365 = round($data['net_amount'], 2) * 28 / 365;
                $end_month_29_366 = round($data['net_amount'], 2) * 29 / 366;
                $end_month_30_365 = round($data['net_amount'], 2) * 30 / 365;
                $end_month_30_366 = round($data['net_amount'], 2) * 30 / 366;
                $end_month_31_365 = round($data['net_amount'], 2) * 31 / 365;
                $end_month_31_366 = round($data['net_amount'], 2) * 31 / 366;
            } else {
                $end_month_28_365 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 28 / 365;
                $end_month_29_366 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 29 / 366;
                $end_month_30_365 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 30 / 365;
                $end_month_30_366 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 30 / 366;
                $end_month_31_365 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 31 / 365;
                $end_month_31_366 = ((round($data['insurance_amount'], 2) - round($data['discount'],2)) + round($data['duty_amount'], 2)) * 31 / 366;
            }

            $data['end_month_28_365'] = round($end_month_28_365, 2);
            $data['end_month_29_366'] = round($end_month_29_366, 2);
            $data['end_month_30_365'] = round($end_month_30_365, 2);
            $data['end_month_30_366'] = round($end_month_30_366, 2);
            $data['end_month_31_365'] = round($end_month_31_365, 2);
            $data['end_month_31_366'] = round($end_month_31_366, 2);    

            $i += 1;

            try {
                DB::beginTransaction();
                // if ($data['line_type'] == 'Fix Asset' && $data['status'] == 'NEW') {
                //     PtirExtendGasStations::where('ex_gas_station_id', $data['ex_gas_station_id'])->delete();
                //     continue;
                // }
                if ($index['expense_account_id'] == '')
                {
                    // $account = (new PtirWebUtilitiesPkg())->getAccountId($data['expense_account']);
                    // if ($account['status'] == 'E') 
                    // {
                        $response = error('ไม่มีรหัสบัญชีนี้ โปรดเลือกบัญชีใหม่');
                        DB::rollback();
                        return response($response, $response['status']);
                    // }
                }

                $data['expense_account_id']     = isset($index['expense_account_id']) ? $index['expense_account_id'] : '';

                $exGasStation = PtirExtendGasStations::find($data['ex_gas_station_id']); 
                if ($exGasStation !== null) 
                {
                    (new PtirExtendGasStations())->updateExtendGasStaion($data);
                } 
                else 
                {
                    $policy = (new PtirPolicySetHeaders())->getPolicySetHeaders($data['policy_set_header_id']);
                    $account = (new PtirAccountsMapping())->getSpecifiedAccountMapping($policy->gl_expense_account_id, 'Y');
                    $data['prepaid_account_id']   = isset($account->account_id) ? $account->account_id : '';
                    $data['prepaid_account']      = isset($account->account_combine) ? $account->account_combine : '';
                    $data['prepaid_account_desc'] = isset($account->account_combine_desc) ? $account->account_combine_desc : '';
                    
                    $exGasStation = PtirExtendGasStations::create($data);
                    $data['ex_gas_station_id'] = $exGasStation->ex_gas_station_id;
                } 

                DB::commit();
                
                if ($data['document_number'] == '')
                {
                    $data['document_number'] = (new PtirWebUtilitiesPkg())->genDocumentNumber($data['program_code'], $data['ex_gas_station_id'])['document_number'];
                }
                (new PtirExtendGasStations())->updateExtendGasStaion($data);
                if ($data['status'] == 'CONFIRMED') {
                    $end_date = PtirExtendGasStations::select(DB::raw('max(end_date) end_date'))
                                ->where('gas_station_id', $data['gas_station_id'])
                                ->whereRaw("status in ('CONFIRMED', 'INTERFACE')")
                                ->first();
                    $gas = PtirGasStations::find($data['gas_station_id']);
                    $gas->insurance_expire_date = $end_date->end_date;
                    $gas->updated_at            = $data['updated_at'];
                    $gas->last_updated_by       = $data['last_updated_by'];
                    $gas->last_update_date      = $data['last_update_date'];
                    $gas->save();
                }
                $this->listId[$i - 1]['ex_gas_station_id'] = $data['ex_gas_station_id'];              
                $this->listId[$i - 1]['document_number'] = $data['document_number'];              
                $this->listId[$i - 1]['row_id'] = isset($index['row_id']) ? $index['row_id'] : '';          
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError($e->getMessage());
            } 
       }

        $obj = new \stdClass();
        $obj->rows = $this->listId;

        $response   = success($obj);

       return  response($response, $response['status']); 
    }
    
    public function duplicateCheck(ExtendGasStationsRequest $request)
    {
        $requestData = $request->all()['data'];
        $rows = $requestData['rows'];
        for($i = 0; $i < count($rows); $i++) {
            if ($i != count($rows)-1 && $i != $requestData['row_id'])
            {
                if ($rows[$i]['year'] == $requestData['year'] && $rows[$i]['type_code'] == $requestData['type_code'] && 
                    $rows[$i]['status'] != 'Cancelled') 
                {
                    $response = duplicate();
                    return response($response, $response['status']);
                }
            }
            // $gas = PtirExtendGasStations::find($rows[$i]['ex_gas_station_id']);
            if ($rows[$i]['status'] != 'Cancelled' && $rows[$i]['type_code'] == $requestData['type_code']) {
                $gasStation = PtirExtendGasStations::where('year', convertYearToAD($requestData['year']))
                                                ->where('type_code', $requestData['type_code'])
                                                ->where('status', '!=', 'CANCELLED')
                                                ->first();
                if ($gasStation != null) {
                    $response = duplicate();
                        return response($response, $response['status']);
                    }
    
                }
            }
    
            $response = duplicate('ข้อมูลไม่ซ้ำ', 200);
    
            return response($response, $response['status']);                           
    }

    public function updateStatus(GasStationSRequest $request)
    {
        $requestData = $request->all()['data'];
        $db = PtirExtendGasStations::find($requestData['ex_gas_station_id']);
        $db->status                = isset($requestData['status']) ? $requestData['status'] : $db->status;
        $db->updated_at            = Carbon::now();
        $db->last_updated_by       = $this->userId;
        $db->last_update_date      = Carbon::now();
        $db->save();
    }
    
    public function destroy()
    {
        // dd(request()->ex_gas_station_id);
        $line = PtirExtendGasStations::find(request()->ex_gas_station_id);
        $line->delete();

        return response('success');
    }
}
