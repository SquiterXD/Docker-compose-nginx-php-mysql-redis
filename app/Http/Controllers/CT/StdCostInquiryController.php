<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\CostCenterCategory;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglCoaV;
use App\Models\CT\PtYearsV;
use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtctStdCostInquiryV; 

use Carbon\Carbon;
use Log;
use DB;

class StdCostInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $defaultData = getDefaultData("/ct/std-cost-inquiries");
        $organizationId = optional($defaultData)->organization_id ?? null;
        $organizationCode = optional($defaultData)->organization_code ?? null;

        // if(!canView('/ct/std-cost-inquiries') || !canEnter('/ct/std-cost-inquiries')) {

        $stdCostYears = PtctStdCostInquiryV::select("period_year")->groupBy("period_year")->pluck("period_year");
        $periodYears = PtYearsV::getListPeriodYears()->whereIn("period_year", $stdCostYears)->orderBy('period_year', 'desc')->get()->toArray();

        $versionNos = PtctStdCostInquiryV::select("version_no")->groupBy("version_no")->get();

        $stdCostCodes = PtctStdCostInquiryV::select("cost_code")->groupBy("cost_code")->pluck("cost_code");
        $costCodes = PtctCostCenterV::getListCostCodes()->whereIn("cost_code", $stdCostCodes)->get();

        $stdCostInventoryItemIds = PtctStdCostInquiryV::select("inventory_item_id")->groupBy("inventory_item_id")->pluck('inventory_item_id');;
        $inventoryItems = PtpmItemNumberV::select(DB::raw("item_number || ' : ' || item_desc as inventory_item_label, inventory_item_id as inventory_item_value, inventory_item_id, item_number, item_desc"))
                            ->whereIn('inventory_item_id', $stdCostInventoryItemIds)
                            ->groupBy('inventory_item_id','item_number','item_desc')
                            ->get();
                            
        $statusCosts = [["label" => "แสดงทั้งหมด", "value" => ""], ["label" => "ราคาตรงกัน", "value" => "Y"], ["label" => "ราคาไม่ตรงกัน", "value" => "N"]];

        $searchInputs = $request->all();

        return view('ct.std-cost-inquiries.index', compact('defaultData','periodYears' ,'versionNos', 'costCodes', 'inventoryItems', 'statusCosts', 'searchInputs'));

    }

}
