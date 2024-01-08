<?php

namespace App\Http\Controllers\IR\Ajax\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IR\Settings\VehiclesRequest;
use App\Models\IR\PtieWebInfApInvoicePkg;
use App\Models\IR\Settings\PtirVehicles;
use App\Models\IR\Views\GlCodeCombinationView;
use App\Models\IR\Views\PtirFaVehiclesView;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\Settings\PtirLookup;
use App\Models\IR\Views\PtirFaLocationView;

use App\Models\IR\Views\PtglCoaCompanyView;
use App\Models\IR\Views\PtglCoaEvmView;
use App\Models\IR\Views\PtglCoaDeptCodeView;
use App\Models\IR\Views\PtglCoaCostCenterView;
use App\Models\IR\Views\PtglCoaBudgetYearView;
use App\Models\IR\Views\PtglCoaBudgetTypeView;
use App\Models\IR\Views\PtglCoaBudgetDetailView;
use App\Models\IR\Views\PtglCoaBudgetReasonView;
use App\Models\IR\Views\PtglCoaMainAccountView;
use App\Models\IR\Views\PtglCoaSubAccountView;
use App\Models\IR\Views\PtglCoaReserved1View;
use App\Models\IR\Views\PtglCoaReserved2View;

use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;
class VehiclesController extends Controller
{
    public function index(VehiclesRequest $request)
    {
        $collection = PtirVehiclesView::with(['policySet', 'policyGroupSet', 'policyGroupLines'])
                                ->search($request)
                                ->get();

        $response = getResponse($collection);
        return response($response, $response['status']);
    }

    public function show(VehiclesRequest $request)
    {
        $collection = (new PtirVehiclesView())->objectVehicle($request->asset_id, $request->vehicle_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    public function createOrUpdate(VehiclesRequest $request)
    {
        // dd($request->all());
        // check and validate account --17032022 Piyawut A.
        $requestData = $request->all()['data'];
        $result = (new PtirVehicles)->callValidateAccount($requestData['account_number']);
        if ($result['status'] == 'E') {
            $data = [
                'status' => 'E',
                'msg' => $result['message'] ?? 'มีข้อผิดพลาด'
            ];
            return response()->json($data);
        }
        // Get COA Description
        $description = getDescriptionAccount($result['account_code']);

        $userId = optional(auth()->user())->user_id ?? -1;
        $data['vehicle_id']            = isset($requestData['vehicle_id']) ? $requestData['vehicle_id'] : '';
        $data['asset_id']              = isset($requestData['asset_id']) ? (int)$requestData['asset_id'] : '';
        $data['asset_number']          = isset($requestData['asset_number']) ? $requestData['asset_number'] : '';
        $data['vehicle_type_code']     = isset($requestData['vehicle_type_code']) ? $requestData['vehicle_type_code'] : '';
        $data['vehicle_brand_code']    = isset($requestData['vehicle_brand_code']) ? $requestData['vehicle_brand_code'] : '';
        $data['license_plate']         = isset($requestData['license_plate']) ? $requestData['license_plate'] : '';
        $data['vehicle_cc']            = isset($requestData['vehicle_cc']) ? $requestData['vehicle_cc'] : '';
        $data['engine_number']         = isset($requestData['engine_number']) ? $requestData['engine_number'] : '';
        $data['tank_number']           = isset($requestData['tank_number']) ? $requestData['tank_number'] : '';
        $data['group_code']            = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        // $data['vat_percent']           = isset($requestData['vat_percent']) ? (int)$requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? (int)$requestData['revenue_stamp_percent'] : '';
        $data['insurance_type_code']   = isset($requestData['insurance_type_code']) ? $requestData['insurance_type_code'] : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['policy_set_header_id']  = isset($requestData['policy_set_header_id']) ? $requestData['policy_set_header_id'] : '';
        $data['group_code']            = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['account_id']            = $result['ccid'];
        $data['account_number']        = $result['account_code'];
        $data['account_description']   = $description;
        $data['insurance_expire_date'] = isset($requestData['insurance_expire_date']) ? parseFromDateTh($requestData['insurance_expire_date']) : '';
        $data['license_plate_expire_date'] = isset($requestData['license_plate_expire_date']) ? parseFromDateTh($requestData['license_plate_expire_date']) : '';
        $data['acts_expire_date']      = isset($requestData['acts_expire_date']) ? parseFromDateTh($requestData['acts_expire_date']) : '';
        $data['car_inspection_expire_date'] = isset($requestData['car_inspection_expire_date']) ? parseFromDateTh($requestData['car_inspection_expire_date']) : '';
        $data['category_segment4']         = isset($requestData['category_segment4']) ? $requestData['category_segment4'] : '';
        $data['sold_flag']             = isset($requestData['sold_flag']) ? $requestData['sold_flag'] : '';
        $data['sold_date']             = isset($requestData['sold_date']) ? parseFromDateTh($requestData['sold_date']) : '';
        $data['reason']                = isset($requestData['reason']) ? $requestData['reason'] : '';
        $data['last_updated_by']       = $userId;
        $data['created_by']            = $userId;
        $data['created_by_id']         = $userId;
        $data['created_at']            = Carbon::now();
        $data['updated_at']            = Carbon::now();
        $data['creation_date']         = Carbon::now();
        $data['last_update_date']      = Carbon::now();
        // New requirement 09012022
        $data['location_code']          = isset($requestData['location_code']) ? $requestData['location_code'] : '';
        $data['location_description']   = isset($requestData['location_description']) ? $requestData['location_description'] : '';
        $data['renew_car_act']          = isset($requestData['renew_car_act']) ? $requestData['renew_car_act'] : '';
        $data['renew_car_license_plate'] = isset($requestData['renew_car_license_plate']) ? $requestData['renew_car_license_plate'] : '';
        $data['renew_car_inspection']   = isset($requestData['renew_car_inspection']) ? $requestData['renew_car_inspection'] : '';

        try {
            \DB::beginTransaction();
            // $check = GlCodeCombinationView::select('code_combination_id')->where('concatenated_segments', $data['account_number'])->first();
            // if ($check == null) {
            //     $data['account_id'] = (new PtieWebInfApInvoicePkg())->getAccountId($data['account_number'])['account_id'];
            // } else {
            //     $data['account_id'] = isset($check->code_combination_id) ? $check->code_combination_id : '';
            // }

            if ($data['vehicle_id'] != '') {
                (new PtirVehicles)->updateVehicle($data);
            } else {
                PtirVehicles::create($data);
            }
            \DB::commit();

            $data = [ 'status' => 'S' ];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function updateActiveFlag(VehiclesRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['vehicle_id']            = isset($requestData['vehicle_id']) ? $requestData['vehicle_id'] : '';
        $data['asset_id']              = isset($requestData['asset_id']) ? $requestData['asset_id'] : '';
        $data['asset_number']          = isset($requestData['asset_number']) ? $requestData['asset_number'] : '';
        $data['license_plate']         = isset($requestData['license_plate']) ? $requestData['license_plate'] : '';
        $data['vehicle_type_code']     = isset($requestData['vehicle_type_code']) ? $requestData['vehicle_type_code'] : '';
        $data['vehicle_brand_code']    = isset($requestData['vehicle_brand_code']) ? $requestData['vehicle_brand_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        // $data['vat_percent']           = isset($requestData['vat_percent']) ? $requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? $requestData['revenue_stamp_percent'] : '';
        $data['account_id']            = isset($requestData['account_id']) ? $requestData['account_id'] : '';
        $data['account_number']        = isset($requestData['account_number']) ? $requestData['account_number'] : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['program_code']          = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['last_updated_by']       = $userId;
        $data['created_by']            = $userId;
        $data['created_by_id']         = $userId;
        $data['created_at']            = Carbon::now();
        $data['updated_at']            = Carbon::now();
        $data['creation_date']         = Carbon::now();
        $data['last_update_date']      = Carbon::now();
        try {
            \DB::beginTransaction();
            if ($data['vehicle_id'] == '') {
                $vehicle = PtirVehicles::where('asset_id', $data['asset_id'])->first();
                $data['vehicle_id'] = isset($vehicle->vehicle_id) ? $vehicle->vehicle_id : '';
            }
            (new PtirVehicles)->updateActiveFlag($data);
            \DB::commit();
            $response   = success();
            return response($response, $response['status']);
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function updateReturnVatFlag(VehiclesRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['vehicle_id']            = isset($requestData['vehicle_id']) ? $requestData['vehicle_id'] : '';
        $data['asset_id']              = isset($requestData['asset_id']) ? $requestData['asset_id'] : '';
        $data['asset_number']          = isset($requestData['asset_number']) ? $requestData['asset_number'] : '';
        $data['license_plate']         = isset($requestData['license_plate']) ? $requestData['license_plate'] : '';
        $data['vehicle_type_code']     = isset($requestData['vehicle_type_code']) ? $requestData['vehicle_type_code'] : '';
        $data['vehicle_brand_code']    = isset($requestData['vehicle_brand_code']) ? $requestData['vehicle_brand_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        // $data['vat_percent']           = isset($requestData['vat_percent']) ? $requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? $requestData['revenue_stamp_percent'] : '';
        $data['account_id']            = isset($requestData['account_id']) ? $requestData['account_id'] : '';
        $data['account_number']        = isset($requestData['account_number']) ? $requestData['account_number'] : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['program_code']          = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['last_updated_by']       = $userId;
        $data['created_by']            = $userId;
        $data['created_by_id']         = $userId;
        $data['created_at']            = Carbon::now();
        $data['updated_at']            = Carbon::now();
        $data['creation_date']         = Carbon::now();
        $data['last_update_date']      = Carbon::now();

        try {
            \DB::beginTransaction();
            if ($data['vehicle_id'] == '') {
                $vehicle = PtirVehicles::where('asset_id', $data['asset_id'])->first();
                $data['vehicle_id'] = isset($vehicle->vehicle_id) ? $vehicle->vehicle_id : '';
            }
            (new PtirVehicles)->updateReturnVatFlag($data);
            \DB::commit();
            $response   = success();
            return response($response, $response['status']);
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function duplicateCheck(VehiclesRequest $request) {
        $data = PtirVehiclesView::where('license_plate', $request->license_plate)->first();
        if ($data == null) {
            $response = success();
        } else {
            $response = duplicate();
        }
        return response($response, $response['status']);
    }

    public function updateSoldFlag(VehiclesRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['vehicle_id']            = isset($requestData['vehicle_id']) ? $requestData['vehicle_id'] : '';
        $data['asset_id']              = isset($requestData['asset_id']) ? $requestData['asset_id'] : '';
        $data['asset_number']          = isset($requestData['asset_number']) ? $requestData['asset_number'] : '';
        $data['license_plate']         = isset($requestData['license_plate']) ? $requestData['license_plate'] : '';
        $data['vehicle_type_code']     = isset($requestData['vehicle_type_code']) ? $requestData['vehicle_type_code'] : '';
        $data['vehicle_brand_code']    = isset($requestData['vehicle_brand_code']) ? $requestData['vehicle_brand_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        // $data['vat_percent']           = isset($requestData['vat_percent']) ? $requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? $requestData['revenue_stamp_percent'] : '';
        $data['account_id']            = isset($requestData['account_id']) ? $requestData['account_id'] : '';
        $data['account_number']        = isset($requestData['account_number']) ? $requestData['account_number'] : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['sold_flag']             = isset($requestData['sold_flag']) ? $requestData['sold_flag'] : '';
        $data['sold_date']             = isset($requestData['sold_date']) ? parseFromDateTh($requestData['sold_date']) : '';
        $data['reason']                = isset($requestData['reason']) ? $requestData['reason'] : '';
        $data['program_code']          = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['last_updated_by']       = $userId;
        $data['created_by']            = $userId;
        $data['created_by_id']         = $userId;
        $data['created_at']            = Carbon::now();
        $data['updated_at']            = Carbon::now();
        $data['creation_date']         = Carbon::now();
        $data['last_update_date']      = Carbon::now();

        try {
            \DB::beginTransaction();
            if ($data['vehicle_id'] == '') {
                $vehicle = PtirVehicles::where('asset_id', $data['asset_id'])->first();
                $data['vehicle_id'] = isset($vehicle->vehicle_id) ? $vehicle->vehicle_id : '';
            }
            (new PtirVehicles)->updateSoldFlag($data);
            \DB::commit();
            $response   = success();
            return response($response, $response['status']);
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    // Fa location, ประเภทประกัน พรบ, ประเภทประกันป้ายทะเบียน, ประเภทประกันตรวจสภาพ
    public function getLookupData(VehiclesRequest $request)
    {
        $request->validate([
            'flex_value_set_name' => 'required',
        ]);
        $setName = $request->flex_value_set_name;
        $setValue = $request->flex_value_set_data;
        $text  = $request->get('query');
        $flexValue = [];

        // FA
        if ($setName == 'FA_LOCATION') {
            $flexValue = (new PtirFaLocationView)->getAllLocation($setValue, $text);
        }

        // ประเภทประกัน พรบ
        if ($setName == 'PTIR_RENEW_CAR_ACT') {
            $flexValue = (new PtirLookup)->lookupResult($setName, $setValue, $text);
        }

        // ประเภทประกันป้ายทะเบียน
        if ($setName == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
            $flexValue = (new PtirLookup)->lookupResult($setName, $setValue, $text);
        }

        // ประเภทประกันตรวจสภาพ
        if ($setName == 'PTIR_RENEW_CAR_INSPECTION') {
            $flexValue = (new PtirLookup)->lookupResult($setName, $setValue, $text);
        }

        return $flexValue;
    }

    // New Requirement
    public function getCoaLists(Request $request)
    {
        $setName = $request->flex_value_set_name;
        $setValue = $request->flex_value_set_data;
        $setParent = $request->flex_value_parent;
        $text  = $request->get('query');
        $flexValue = [];


        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
            $flexValue = (new PtglCoaCompanyView)->companyResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-EVM') {
            $flexValue = (new PtglCoaEvmView)->emvResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE') {
            $flexValue = (new PtglCoaDeptCodeView)->departmentResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {
            $flexValue = (new PtglCoaCostCenterView)->costCenterResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR') {
            $flexValue = (new PtglCoaBudgetYearView)->budgetYearResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE') {
            $flexValue = (new PtglCoaBudgetTypeView)->budgetTypeResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL') {
            $flexValue = (new PtglCoaBudgetDetailView)->budgetDetailResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON') {
            $flexValue = (new PtglCoaBudgetReasonView)->budgetReasonResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT') {
            $flexValue = (new PtglCoaMainAccountView)->mainAccountResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT') {
            $flexValue = (new PtglCoaSubAccountView)->subAccountResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1') {
            $flexValue = (new PtglCoaReserved1View)->reserved1Result($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2') {
            $flexValue = (new PtglCoaReserved2View)->reserved2Result($setName, $setValue, $text);
        }

        return $flexValue;
    }

    public function getCoaDescription(Request $request)
    {
        // dd('getCoaDescription', request()->all());
        // Get COA Description
        $desc = '';
        if ($request->coa) {
            $result = (new PtirVehicles)->callValidateAccount($request->coa);
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['message'] ?? 'มีข้อผิดพลาด',
                    'return_account_code' => $result['account_code'],
                ];
                return response()->json($data);
            }

            $descFull = getDescriptionAccount($request->coa);
            $descDisply = getSegmentDisplay($request->coa);
        }

        $data = ['desc_full' => $descFull, 'desc_disply' => $descDisply, 'status' => 'S'];
        return response()->json($data);
    }

    public function updateActive()
    {
        // $xx = request()->vehicle;
        
        $dataVehicle = PtirVehicles::find(request()->vehicle_id);
        // dd(request()->all(), $dataVehicle);

        $userId = optional(auth()->user())->user_id ?? -1;
        $data['vehicle_id']            = $dataVehicle->vehicle_id            ? $dataVehicle->vehicle_id            : '';
        $data['asset_id']              = $dataVehicle->asset_id              ? $dataVehicle->asset_id              : '';
        $data['asset_number']          = $dataVehicle->asset_number          ? $dataVehicle->asset_number          : '';
        $data['license_plate']         = $dataVehicle->license_plate         ? $dataVehicle->license_plate         : '';
        $data['vehicle_type_code']     = $dataVehicle->vehicle_type_code     ? $dataVehicle->vehicle_type_code     : '';
        $data['vehicle_brand_code']    = $dataVehicle->vehicle_brand_code    ? $dataVehicle->vehicle_brand_code    : '';
        $data['return_vat_flag']       = $dataVehicle->return_vat_flag       ? $dataVehicle->return_vat_flag       : '';
        // $data['vat_percent']           = $dataVehicle->vat_percent           ? $dataVehicle->vat_percent           : '';
        $data['revenue_stamp_percent'] = $dataVehicle->revenue_stamp_percent ? $dataVehicle->revenue_stamp_percent : '';
        $data['account_id']            = $dataVehicle->account_id            ? $dataVehicle->account_id            : '';
        $data['account_number']        = $dataVehicle->account_number        ? $dataVehicle->account_number        : '';
        $data['active_flag']           = request()->active_flag;
        $data['program_code']          = $dataVehicle->program_code          ? $dataVehicle->program_code          : '';
        $data['last_updated_by']       = $userId;
        $data['updated_at']            = Carbon::now();
        $data['last_update_date']      = Carbon::now();
        // dd('xx', $data);
        try {
            \DB::beginTransaction();
            if ($data['vehicle_id'] == '') {
                $vehicle = PtirVehicles::where('asset_id', $data['asset_id'])->first();
                $data['vehicle_id'] = isset($vehicle->vehicle_id) ? $vehicle->vehicle_id : '';
            }
            (new PtirVehicles)->updateActiveFlag($data);
            \DB::commit();
            $response   = success();
            return response($response, $response['status']);
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}


