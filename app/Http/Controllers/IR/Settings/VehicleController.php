<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use App\Models\IR\Settings\PtirLookup;
use App\Models\IR\Settings\PtirVehicles;

use App\Models\IR\Views\PtirVehiclesView;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IR\VehicleExport;
class VehicleController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $dataSearch = (object)[];
        $dataSearch->license_plate       = request()->license_plate;
        $dataSearch->vehicle_type_code   = request()->vehicle_type_code;
        $dataSearch->insurance_type_code = request()->insurance_type_code;
        $dataSearch->location_code       = request()->location_code; 
        $dataSearch->return_vat_flag     = request()->return_vat_flag;
        $dataSearch->active_flag         = request()->active_flag; 

        $dataList = PtirVehiclesView::with(['policySet', 'policyGroupSet', 'policyGroupLines'])
                                ->search($dataSearch)
                                ->get();

        return view('ir.settings.vehicle.index', compact('btnTrans', 'dataList', 'dataSearch'));
    }
    
    public function create()
    {
        $btnTrans = trans('btn');
        $carAct = PtirLookup::selectRaw('lookup_code, meaning, description')
                ->where('lookup_type', 'PTIR_RENEW_CAR_ACT')
                ->orderBy('lookup_code')
                ->get();

        $carLicense = PtirLookup::selectRaw('lookup_code, meaning, description')
                ->where('lookup_type', 'PTIR_RENEW_CAR_LICENSE_PLATE')
                ->orderBy('lookup_code')
                ->get();

        $carInspection = PtirLookup::selectRaw('lookup_code, meaning, description')
                ->where('lookup_type', 'PTIR_RENEW_CAR_INSPECTION')
                ->orderBy('lookup_code')
                ->get();

        $defaultInput = (object)[];
        $defaultInput->car_act = count($carAct) > 1? '': $carAct->first()->lookup_code;
        $defaultInput->car_license = count($carLicense) > 1? '': $carLicense->first()->lookup_code;
        $defaultInput->car_inspection = count($carInspection) > 1? '': $carInspection->first()->lookup_code;
        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1 =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2 =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3 =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4 =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9 =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';
        return view('ir.settings.vehicle.create', compact('defaultInput', 'btnTrans', 'defaultValueSetName'));
    }

    public function edit($vehicle_id)
    {
        $vehicle = PtirVehicles::find($vehicle_id);
        $btnTrans = trans('btn');
        $assetId = $vehicle->asset_id;
        $vehicleId = $vehicle_id;
        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1 =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2 =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3 =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4 =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9 =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';
        return view('ir.settings.vehicle.edit', compact('assetId', 'vehicleId', 'btnTrans', 'defaultValueSetName'));
    }

    public function getFALocation()
    {
        \Log::info('--- start getFALocation---');
        $data = (new PtirVehicles)->callGetFALocationPackage();
        \Log::info($data);
        \Log::info('--- end getFALocation---');

        $result = ['status' => $data['status'], 'msg' => $data['message']];
        return response()->json($data);
    }

    public function export()
    {
        return Excel::download(new VehicleExport, 'IRM0007'.'.xlsx');
    }
}
