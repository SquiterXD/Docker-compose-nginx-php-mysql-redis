<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\CT\AllocateRatioLevelTemplateExport;

use App\Models\CT\CostCenterCategory;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglCoaV;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtppPeriodsV;
use App\Models\CT\GlLedger;
use App\Models\CT\PtApprovedStatusV;
use App\Models\CT\PtctAllocateYear;
use App\Models\CT\PtctAllocateAccount;
use App\Models\CT\PtctAllocateTarget;
use App\Models\CT\PtctAllocateGroupV;
use App\Models\CT\PtctAccountDeptV;
use App\Models\CT\PtctAllocateTypeV;
use App\Models\CT\PtctStdcostYearAccV;

use Carbon\Carbon;
use Log;
use DB;

class AllocateRatioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/allocate-ratios");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/allocate-ratios') || !canEnter('/ct/allocate-ratios')) {

        $coa = GlLedger::where('short_name', 'TOAT')->value('chart_of_accounts_id');
        $periodYears = PtYearsV::getListPeriodYears()->where('period_year', '<=', intval(date('Y'))+1)->orderBy('period_year', 'desc')->get()->toArray();
        $existYears = PtctAllocateYear::select("period_year")->groupBy("period_year")->pluck("period_year");
        $existPeriodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $existYears)->orderBy('period_year', 'desc')->get()->toArray();

        $approveStatuses = PtApprovedStatusV::getStatuses()->get();
        $listAllocateGroups = PtctAllocateGroupV::getListAllocateGroups()->get();
        $allocateTypes = PtctAllocateTypeV::getListAllocateTypes()->get();
        
        $existTransferAccountCodes = PtctAllocateAccount::select("transfer_account_code")->groupBy("transfer_account_code")->pluck("transfer_account_code");
        
        $preAccountCodes = PtctAccountDeptV::getListTransferAccountCodes()->get();
        $accountCodes = [["account_code_label" => "-", "account_code_value" => "", "acc_code" => "", "sub_acc_code" => ""]];
        foreach($preAccountCodes as $index => $preAccountCode) {
            $accountCodes[$index+1] = $preAccountCode->toArray();
            $accCodeDesc = PtctStdcostYearAccV::getTargetAccCodeDesc($coa, $preAccountCode->acc_code);
            $subAccCodeDesc = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $preAccountCode->acc_code, $preAccountCode->sub_acc_code);
            $accountCodes[$index+1]["account_code_label"] = "{$preAccountCode->account_code_value} : {$subAccCodeDesc}";
        }

        $preExistAccountCodes = PtctAccountDeptV::getListTransferAccountCodes()->whereIn("account_code_disp", $existTransferAccountCodes)->orderBy('account_code_disp')->get();
        $existAccountCodes = [];
        foreach($preExistAccountCodes as $index => $preExistAccountCode) {
            $existAccountCodes[$index] = $preExistAccountCode->toArray();
            $accCodeDesc = PtctStdcostYearAccV::getTargetAccCodeDesc($coa, $preExistAccountCode->acc_code);
            $subAccCodeDesc = PtctStdcostYearAccV::getTargetSubAccCodeDesc($coa, $preExistAccountCode->acc_code, $preExistAccountCode->sub_acc_code);
            $existAccountCodes[$index]["account_code_label"] = "{$preExistAccountCode->account_code_value} : {$subAccCodeDesc}";
        }

        $searchInputs = $request->all();

        return view('ct.allocate-ratios.index', compact('defaultData','periodYears', 'existPeriodYears', 'approveStatuses', 'listAllocateGroups', 'allocateTypes', 'accountCodes', 'existAccountCodes', 'searchInputs'));

    }

    public function downloadTemplate(Request $request)
    {
        $filename = "IMPORT_RATIO_LEVEL_TEMPLATE";
        return \Excel::download(new AllocateRatioLevelTemplateExport(), "{$filename}.xlsx");
    }

}
