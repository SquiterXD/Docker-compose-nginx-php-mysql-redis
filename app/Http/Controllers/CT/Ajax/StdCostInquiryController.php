<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\CT\PtYearsV;
use App\Models\CT\PtctCostCenterV;
use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\PtctStdCostInquiryV;

use Carbon\Carbon;
use Log;
use DB;

class StdCostInquiryController extends Controller
{

    public function getListVersions(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "version_nos"           => null
        ];

        try {

            $periodYear = $request->period_year;
            
            $versionNos = PtctStdCostInquiryV::select("version_no")->where('period_year', $periodYear)->groupBy("version_no")->get();

            $responseResult["version_nos"] = json_encode($versionNos);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getListCostCodes(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "cost_codes"            => null
        ];

        try {

            $periodYear = $request->period_year;
            
            $stdCostCodes = PtctStdCostInquiryV::select("cost_code")->where('period_year', $periodYear)->groupBy("cost_code")->pluck('cost_code');
            $costCodes = PtctCostCenterV::getListCostCodes()->whereIn("cost_code", $stdCostCodes)->get();

            $responseResult["cost_codes"] = json_encode($costCodes);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getListInventoryItems(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "inventory_items"       => null
        ];

        try {

            $periodYear = $request->period_year;
            
            $inventoryItemIds = PtctStdCostInquiryV::select("inventory_item_id")->where('period_year', $periodYear)->groupBy("inventory_item_id")->pluck('inventory_item_id');
            $inventoryItems = PtpmItemNumberV::select(DB::raw("item_number || ' : ' || item_desc as inventory_item_label, inventory_item_id as inventory_item_value, inventory_item_id, item_number, item_desc"))
                            ->whereIn('inventory_item_id', $inventoryItemIds)
                            ->groupBy('inventory_item_id','item_number','item_desc')
                            ->get();

            $responseResult["inventory_items"] = json_encode($inventoryItems);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getInquiries(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "std_cost_inquiries"    => []
        ];

        try {

            $periodYear = $request->period_year;
            $versionNo = $request->version_no;
            $costCode = $request->cost_code;
            $inventoryItemId = $request->inventory_item_id;
            $statusCost = $request->status_cost;
            
            $queryStdCostInquiries = PtctStdCostInquiryV::where('period_year', $periodYear)
                                                    ->where('version_no', $versionNo)
                                                    ->where('cost_code', $costCode);
            if($inventoryItemId) {
                $queryStdCostInquiries = $queryStdCostInquiries->where("inventory_item_id", $inventoryItemId);
            }
            if($statusCost) {
                $queryStdCostInquiries = $queryStdCostInquiries->where("status_cost", $statusCost);
            }

            $stdCostInquiries = $queryStdCostInquiries->get();
            
            $responseResult["std_cost_inquiries"] = json_encode($stdCostInquiries);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

}