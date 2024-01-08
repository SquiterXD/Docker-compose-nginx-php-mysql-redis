<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\CT\PtctYearControlV;
use App\Models\CT\PtctOemCostHeader;
use App\Models\CT\PtctOemCostLine;
use App\Models\CT\PtctOemCostHeaderV;
use App\Models\CT\PtctOemCostLineV;

use Carbon\Carbon;
use Log;
use DB;

class OemCostController extends Controller
{

    public function getHeader(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_header"       => null,
            "version"               => null,
        ];

        try {

            $periodYear = $request->period_year;
            $ct14VersionNo = $request->ct14_version_no;
            $planVersionNo = $request->plan_version_no;
            $prdgrpYearId = $request->prdgrp_year_id;
            $costCode = $request->cost_code;
            $productGroup = $request->product_group;
            $productInventoryItemId = $request->product_inventory_item_id;

            $oemCostHeader = null;

            $yearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('ct14_version_no', $ct14VersionNo)->where('cost_code', $costCode)->orderby('year_main_id', 'DESC')->first();
            if($yearControl) {
                $oemCostHeader = PtctOemCostHeaderV::where('prdgrp_year_id', $prdgrpYearId)
                                ->where('cost_code', $costCode)
                                ->where('product_group', $productGroup)
                                ->where('product_inventory_item_id', $productInventoryItemId)
                                ->where('ct14_allocate_year_id', $yearControl->ct14_allocate_year_id)
                                ->orderBy("oem_cost_header_id", 'DESC')
                                ->first();
            }
            
            $responseResult["oem_cost_header"] = json_encode($oemCostHeader);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getListHeaders(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_headers"      => null
        ];

        try {

            $periodYear = $request->period_year;
            $planVersionNo = $request->plan_version_no;
            $prdgrpYearId = $request->prdgrp_year_id;
            $costCode = $request->cost_code;
            $ct14VersionNo = $request->ct14_version_no;

            $queryOemCostHeader = PtctOemCostHeaderV::where('period_year', $periodYear);
            if($prdgrpYearId) {
                $queryOemCostHeader = $queryOemCostHeader->where('prdgrp_year_id', $prdgrpYearId);
            }
            if($costCode) {
                $queryOemCostHeader = $queryOemCostHeader->where('cost_code', $costCode);
            }
            if($ct14VersionNo) {
                $queryOemCostHeader = $queryOemCostHeader->where('ct14_version_no', $ct14VersionNo);
            }
            $oemCostHeaders = $queryOemCostHeader->whereNotNull('ct14_allocate_year_id')->orderBy("oem_cost_header_id", 'DESC')->get();

            $responseResult["oem_cost_headers"] = json_encode($oemCostHeaders);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function getLines(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_lines"        => []
        ];

        try {

            $periodYear = $request->period_year;
            $inputOemCostHeader = $request->input_oem_cost_header ? json_decode($request->input_oem_cost_header) : null;
            $oemCostLines = PtctOemCostLineV::where('oem_cost_header_id', $inputOemCostHeader->oem_cost_header_id)
                    ->orderBy('account_code')
                    ->orderBy('sub_account_code')
                    ->get();

            $responseResult["oem_cost_lines"] = json_encode($oemCostLines);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeHeader(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_header"       => null,
        ];

        try {

            $periodYear = $request->period_year;
            $planVersionNo = $request->plan_version_no;
            $prdgrpYearId = $request->prdgrp_year_id;
            $ct14VersionNo = $request->ct14_version_no;
            $costCode = $request->cost_code;
            $productGroup = $request->product_group;
            $productInventoryItemId = $request->product_inventory_item_id;
            $productQuantity = $request->product_quantity;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $yearControl = PtctYearControlV::where('period_year', $periodYear)->where('prdgrp_year_id', $prdgrpYearId)->where('ct14_version_no', $ct14VersionNo)->where('cost_code', $costCode)->orderby('year_main_id', 'DESC')->first();
            if(!$yearControl) { throw new \Exception("ไม่พบข้อมูล PTCT_YEAR_CONTROL_V จาก ปีบัญชีงบประมาณ = " . (intval($periodYear)+543) . ", แผนการผลิตครั้งที่ = " . $planVersionNo . ", ครั้งที่ = " . $ct14VersionNo . ", ศูนย์ต้นทุน = " . $costCode); }

            $queryOemCostHeader = PtctOemCostHeader::where('period_year', $periodYear)
                                                ->where('prdgrp_year_id', $prdgrpYearId)
                                                ->where('cost_code', $costCode)
                                                ->where('product_group', $productGroup)
                                                ->where('ct14_allocate_year_id', $yearControl->ct14_allocate_year_id)
                                                ->where('year_main_id', $yearControl->year_main_id)
                                                ->where('product_inventory_item_id', $productInventoryItemId)
                                                ->first();

            if (!$queryOemCostHeader) {

                // CREATE NEW OEM HEADER
                $oemCostHeader                              = new PtctOemCostHeader;
                $oemCostHeader->period_year                 = $periodYear;
                $oemCostHeader->prdgrp_year_id              = $prdgrpYearId;
                $oemCostHeader->cost_code                   = $costCode;
                $oemCostHeader->product_group               = $productGroup;
                $oemCostHeader->product_inventory_item_id   = $productInventoryItemId;
                $oemCostHeader->allocate_year_id            = $yearControl->allocate_year_id;
                $oemCostHeader->ct14_allocate_year_id       = $yearControl->ct14_allocate_year_id;
                $oemCostHeader->year_main_id                = $yearControl->year_main_id;
                $oemCostHeader->created_by_id               = $userId;
                $oemCostHeader->created_by                  = $fndUserId;
                $oemCostHeader->created_at                  = $createdAt;

            } else {
                $oemCostHeaderId = $queryOemCostHeader->oem_cost_header_id;
                $oemCostHeader = PtctOemCostHeader::find($oemCostHeaderId);
            }

            $oemCostHeader->product_quantity            = $productQuantity;
            $oemCostHeader->updated_at                  = $createdAt;
            $oemCostHeader->updated_by_id               = $userId;
            $oemCostHeader->last_update_date            = $createdAt;
            $oemCostHeader->last_updated_by             = $fndUserId;
            $oemCostHeader->save();

            $updatedOemCostHeader = PtctOemCostHeaderV::find($oemCostHeader->oem_cost_header_id);
            $responseResult["oem_cost_header"] = json_encode($updatedOemCostHeader);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function storeLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_line"         => "",
        ];

        try {

            // $periodYear = $request->period_year;
            $inputOemCostHeader = $request->input_oem_cost_header ? json_decode($request->input_oem_cost_header) : null;
            $inputOemCostLine = $request->input_oem_cost_line ? json_decode($request->input_oem_cost_line) : null;

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $dateNow = Carbon::now();

            $resOemCostLine = null;
            if($inputOemCostHeader) {

                if(!$inputOemCostLine->oem_cost_line_id) {
                    $oemCostLine                        = new PtctOemCostLine;
                    $oemCostLine->oem_cost_header_id    = $inputOemCostHeader->oem_cost_header_id;
                    $oemCostLine->created_by_id         = $userId;
                    $oemCostLine->created_by            = $fndUserId;
                    $oemCostLine->created_at            = $dateNow;
                } else {
                    $oemCostLine = PtctOemCostLine::find($inputOemCostLine->oem_cost_line_id);
                }
                
                $oemCostLine->account_code              = $inputOemCostLine->account_code;
                $oemCostLine->sub_account_code          = $inputOemCostLine->sub_account_code;
                $oemCostLine->account_type              = $inputOemCostLine->account_type;
                $oemCostLine->expense_amount            = $inputOemCostLine->expense_amount;
                $oemCostLine->updated_at                = $dateNow;
                $oemCostLine->updated_by_id             = $userId;
                $oemCostLine->last_update_date          = $dateNow;
                $oemCostLine->last_updated_by           = $fndUserId;
                $oemCostLine->save();

            }

            $resOemCostLine = PtctOemCostLine::where('oem_cost_header_id', $oemCostLine->oem_cost_header_id)
                                                ->where('oem_cost_line_id', $oemCostLine->oem_cost_line_id)
                                                ->first();
            
            $responseResult["oem_cost_line"] = json_encode($resOemCostLine);

        } catch (\Exception $e) {
            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function deleteLine(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
        ];

        try {

            $inputOemCostHeader = $request->input_oem_cost_header ? json_decode($request->input_oem_cost_header) : null;
            $inputOemCostLine = $request->input_oem_cost_line ? json_decode($request->input_oem_cost_line) : null;

            if($inputOemCostHeader) {
                if($inputOemCostLine->oem_cost_line_id) {
                    $oemCostLine = PtctOemCostLine::find($inputOemCostLine->oem_cost_line_id);
                    $oemCostLine->delete();
                }
            }

        } catch (\Exception $e) {
            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    
    }

    public function transfer(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_lines"        => [],
        ];

        try {

            $inputOemCostHeader = $request->input_oem_cost_header ? json_decode($request->input_oem_cost_header) : null;
            $inputOemCostLines = $request->input_oem_cost_lines ? json_decode($request->input_oem_cost_lines) : [];

            $periodYear = $inputOemCostHeader->period_year;
            $allocateYearId = $inputOemCostHeader->allocate_year_id;
            $ct14AllocateYearId = $inputOemCostHeader->ct14_allocate_year_id;
            $prdgrpYearId = $inputOemCostHeader->prdgrp_year_id;
            $costCode = $inputOemCostHeader->cost_code; // allocate_account : version_no

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $oemCostLines = PtctOemCostLine::where('oem_cost_header_id', $inputOemCostHeader->oem_cost_header_id)->get();
            foreach($oemCostLines as $oemCostLine) {
                $oemCostLine->transfer_data = "Y";
                $oemCostLine->save();
            }

            // ## CALL PACKAGE FOR GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($allocateYearId);
            $pCt14AllocateYearId = intval($ct14AllocateYearId);
            $pCostCode = $costCode;
            $pProgramCode = "CTM0017";

            $resCreateMain = PtctOemCostHeader::createMain($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $pCostCode);

            DB::commit();

            // ERROR CALL PACKAGE 
            if($resCreateMain["status"] == "E") {
                // throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . "" . $resCreateMain["message"]);
                Log::error("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . "" . $resCreateMain["message"]);
            }

            $updatedOemCostLines = PtctOemCostLineV::where('oem_cost_header_id', $inputOemCostHeader->oem_cost_header_id)
                    ->orderBy('account_code')
                    ->orderBy('sub_account_code')
                    ->get();

            $responseResult["oem_cost_lines"]   = json_encode($updatedOemCostLines);
        
        } catch (\Exception $e) {
            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }
    
    public function cancelTransfer(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "oem_cost_lines"        => [],
        ];

        try {

            $inputOemCostHeader = $request->input_oem_cost_header ? json_decode($request->input_oem_cost_header) : null;
            $inputOemCostLines = $request->input_oem_cost_lines ? json_decode($request->input_oem_cost_lines) : [];

            $periodYear = $inputOemCostHeader->period_year;
            $allocateYearId = $inputOemCostHeader->allocate_year_id;
            $ct14AllocateYearId = $inputOemCostHeader->ct14_allocate_year_id;
            $prdgrpYearId = $inputOemCostHeader->prdgrp_year_id;
            $costCode = $inputOemCostHeader->cost_code; // allocate_account : version_no

            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $createdAt = Carbon::now();

            $oemCostLines = PtctOemCostLine::where('oem_cost_header_id', $inputOemCostHeader->oem_cost_header_id)->get();
            foreach($oemCostLines as $oemCostLine) {
                $oemCostLine->transfer_data = "N";
                $oemCostLine->save();
            }

            // ## CALL PACKAGE FOR GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
            $pPeriodYear = intval($periodYear);
            $pPrdgrpYearId = intval($prdgrpYearId);
            $pAllocateYearId = intval($allocateYearId);
            $pCt14AllocateYearId = intval($ct14AllocateYearId);
            $pCostCode = $costCode;
            $pProgramCode = "CTM0017";

            $resCreateMain = PtctOemCostHeader::createMain($pPeriodYear, $pPrdgrpYearId, $pAllocateYearId, $pCt14AllocateYearId, $pCostCode);

            DB::commit();

            // ERROR CALL PACKAGE 
            if($resCreateMain["status"] == "E") {
                // throw new \Exception("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ERROR MSG : ". $resCreateMain["message"]);
                Log::error("PERIOD_YEAR : " . $pPeriodYear . " PRDGRP_YEAR_ID : " . $pPrdgrpYearId . " ERROR MSG : ". $resCreateMain["message"]);
            }

            $updatedOemCostLines = PtctOemCostLineV::where('oem_cost_header_id', $inputOemCostHeader->oem_cost_header_id)
                    ->orderBy('account_code')
                    ->orderBy('sub_account_code')
                    ->get();

            $responseResult["oem_cost_lines"]   = json_encode($updatedOemCostLines);

        } catch (\Exception $e) {
            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

}