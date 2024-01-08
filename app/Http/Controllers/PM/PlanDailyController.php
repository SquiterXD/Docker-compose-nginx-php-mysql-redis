<?php

namespace App\Http\Controllers\PM;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\PM\Web\BaseController;
use Illuminate\Http\Request;

use App\Models\PM\PtomYearlySalesForecastV;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\MtlSystemItemsB;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\FndLookupValue;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtpmMachinePowerTemp;
use App\Models\PM\PtpmPrintMachineV;
use App\Models\PM\PtomSalesTypeV;
use App\Models\PM\PteamAssetV;
use App\Models\PM\PtpmPrintItemCatV;

use App\Models\PM\PtpmDailyPlanHeader;
use App\Models\PM\PtpmDailyPlanLine;
use App\Models\PM\PtWeekly;

use Carbon\Carbon;

class PlanDailyController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (request()->print_pdf) {
            return $this->printPdf($request);
        }

        $organizationId = optional(getDefaultData("/pm/plans/daily"))->organization_id ?? null;
        $organizationCode = optional(getDefaultData("/pm/plans/daily"))->organization_code ?? null;

        $periodYears = PtomYearlySalesForecastV::getListPeriodYears()->orderBy('period_year', 'desc')->get()->toArray();
        foreach($periodYears as $index => $periodYear) {
            $periodYears[$index]["period_year_label"] = strval(intval($periodYear["period_year_label"]) + 543);
        }
        $planStatuses = FndLookupValue::getDailyPlanStatuses()->get();
        $printTypes = PtpmPrintItemCatV::getPrintTypes()->get();
        $saleTypes = PtomSalesTypeV::where('enabled_flag', 'Y')->get();
        $uomCodes = PtInvUomV::getListUomCodes()->get();
        // $machines = PtpmMachinePowerTemp::getMachines()->get();
        // $machinePowers = PtpmMachinePowerTemp::getMachinePowers()->get();
        $machines = PtpmPrintMachineV::getMachines()->get();
        $machinePowers = PtpmPrintMachineV::getMachinePowers()->get();
        $machineTimes = FndLookupValue::getPrintMachineTimes()->where('enabled_flag', 'Y')->orderBy('meaning')->get();
        // $assets = PteamAssetV::with('eamPlanLines')->filterAsset()->orderBy('asset_id')->get();
        $assets = PteamAssetV::filterAsset()->orderBy('asset_id')->get();
        
        $searchInputs = $request->all();

        return view('pm.plans.daily.index', compact('periodYears', 'planStatuses', 'printTypes', 'saleTypes', 'uomCodes', 'machines', 'machinePowers', 'machineTimes', 'assets', 'searchInputs'));
    }

    public function printPdf(Request $request)
    {
        $rows = [
            1 => ['MON', 'TUE', 'WED'],
            2 => ['THU', 'FRI', 'SAT'],
        ];
        $uomCodes = PtInvUomV::getListUomCodes()->get();
        $planStatuses = FndLookupValue::getDailyPlanStatuses()->get();
        // dd('xx', $planStatuses);
        $machineList = [];
        $machineData = false;
        $dailyPlanHeaderId = $request->daily_plan_header_id;
        if ($request->daily_plan_line_id) {
            $planLineData = PtpmDailyPlanLine::where('daily_plan_line_id', $request->daily_plan_line_id)->first();
            $dailyPlanHeaderId = $planLineData->daily_plan_header_id;
            $machineList[$planLineData->machine_name] = $planLineData->machine_name;
        } else {
            $planLineData = PtpmDailyPlanLine::where('daily_plan_header_id', $request->daily_plan_header_id)->get();
            $machineList = $planLineData->pluck('machine_name', 'machine_name')->all();
        }


        foreach ($machineList as $key => $machineName) {
            if ($machineName || true) {
                $planHeader = PtpmDailyPlanHeader::where('daily_plan_header_id', $dailyPlanHeaderId)->first();
                $table = (new PtpmDailyPlanLine)->getTable();
                $planLine = PtpmDailyPlanLine::where('daily_plan_header_id', $planHeader->daily_plan_header_id)
                                        ->where("machine_name", $machineName)
                                        ->selectRaw("
                                            to_char($table.plan_date, 'DY') dy
                                            , to_char($table.plan_date, 'DAY','nls_calendar=''Thai Buddha'' nls_date_language = Thai') day_name_th
                                            , to_char((plan_date), 'DD/MM/YYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') date_th
                                            , $table.*
                                        ")
                                        ->whereNull('deleted_at')
                                        // ->with('productItem')
                                        ->with(['invItem', 'planTime:lookup_code,description'])
                                        ->get();
                $weeklyNum = PtWeekly::selectRaw("DISTINCT weekly")
                                    ->where('period_year', $planHeader->year)
                                    ->where('biweekly', $planHeader->biweekly)
                                    ->where('weekly', '<=', $planHeader->week_number)
                                    ->orderBy('weekly')
                                    ->count();
                $machineData[] = (object)[
                    'rows' => $rows,
                    'planHeader' => $planHeader,
                    'planLine' => $planLine,
                    'uomCodes' => $uomCodes,
                    'weeklyNum' => $weeklyNum
                ];
            }
        }

        // return view('pm.plans.daily.pdf-day', compact('rows', 'planLine', 'uomCodes'));
        $pdf = \PDF::loadView('pm.plans.daily.pdf-day', compact('machineData', 'planStatuses'))
            ->setPaper('a4')
            ->setOrientation('landscape')
            // ->setOption('margin-top', '0.5cm')
            // ->setOption('margin-bottom', '0.5cm')
            // ->setOption('margin-left', '0.7cm')
            // ->setOption('margin-right', '0.7cm')

            ->setOption('margin-top', '0.3cm')
            ->setOption('margin-bottom', '0.3cm')
            ->setOption('margin-left', '0.2cm')
            ->setOption('margin-right', '0.2cm')
            ->setOption('encoding', 'utf-8');
        return $pdf->inline();
    }

}
