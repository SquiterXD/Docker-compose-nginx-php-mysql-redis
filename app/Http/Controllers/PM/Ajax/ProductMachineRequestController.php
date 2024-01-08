<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmProductMachineRequest;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\FndLookupValue;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtpmDailyPlanCompleteV;

use App\Models\PM\PtpmMicsPkg;

use App\Models\PM\Lookup\PtpmObjectiveRequest;

use Carbon\Carbon;

use Log;
use DB;

class ProductMachineRequestController extends Controller
{

    public function getItems(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "inv_items"             => json_encode([]),
        ];

        try {

            $requestDate = $request->request_date;
            $parseRequestDate = parse_from_date_th($requestDate);
            
            $prePlanItems = PtpmDailyPlanCompleteV::select('inventory_item_id', 'segment1', 'description')
                                ->where('plan_date', $parseRequestDate)
                                ->groupBy('inventory_item_id', 'segment1', 'description')
                                ->get();

            $planItems = [];
            foreach ($prePlanItems as $index => $planItem) {
                $planItems[$index] = $planItem;
                $planItems[$index]['inv_item_number'] = $planItem->segment1;
                $planItems[$index]['inv_item_desc'] = $planItem->description;
                $planItems[$index]['inv_item_fulldesc'] = $planItem->segment1 . " : " . $planItem->description;
            }

            $responseResult["inv_items"] = json_encode($planItems);

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getItemMachineName(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "machine_name"          => "",
        ];

        try {

            $inventoryItemId = $request->inventory_item_id;
            $requestDate = $request->request_date;
            $parseRequestDate = parse_from_date_th($requestDate);
            
            $machineName = PtpmDailyPlanCompleteV::select('machine_name')
                                ->where('plan_date', $parseRequestDate)
                                ->where('inventory_item_id', $inventoryItemId)
                                ->value('machine_name');

            $responseResult["machine_name"] = $machineName;

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function searchRequestHeaders(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "header_requests"       => json_encode([]),
        ];

        try {

            $requestDate = $request->request_date;

            $queryMachineRequests = PtpmProductMachineRequest::select('request_number','request_date')->whereNull('deleted_at');
            if($requestDate) {
                $parseRequestDate = parse_from_date_th($requestDate);
                $machineRequests = $queryMachineRequests->where('request_date', $parseRequestDate)->groupBy('request_number','request_date')->get();
            }else{
                $machineRequests = $queryMachineRequests->groupBy('request_number','request_date')->get();
            }

            $responseResult["header_requests"] = json_encode($machineRequests);

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }
    
    public function getRequests(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "machine_requests"       => json_encode([]),
        ];

        try {

            $requestNumber = $request->request_number;
            
            $preProductMachineRequests = PtpmProductMachineRequest::where('request_number', $requestNumber)->get();

            $productMachineRequests = [];
            foreach ($preProductMachineRequests as $index => $productMachineRequest) {
                $productMachineRequests[$index] = $productMachineRequest->toArray();
                $productMachineRequests[$index]['product_item_number'] = $productMachineRequest->productItem()->value('item_number');
                $productMachineRequests[$index]['product_item_type'] = $productMachineRequest->productItem()->value('item_type');
                $productMachineRequests[$index]['product_item_desc'] = $productMachineRequest->productItem()->value('item_desc');
                $productMachineRequests[$index]['inv_item_number'] = $productMachineRequest->invItem()->value('item_number');
                $productMachineRequests[$index]['inv_item_type'] = $productMachineRequest->invItem()->value('item_type');
                $productMachineRequests[$index]['inv_item_desc'] = $productMachineRequest->invItem()->value('item_desc');
            }

            $responseResult["machine_requests"] = json_encode($productMachineRequests);

        } catch (\Exception $e) {

            Log::error($e);
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function generateRequests(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "machine_requests"       => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $requestDate = $request->request_date;
            $inventoryItemId = $request->inventory_item_id;
            $machineName = $request->machine_name;
            $objectiveRequest = $request->objective_request;
            $parseRequestDate = parse_from_date_th($requestDate);

            $organizationId = optional(getDefaultData("/pm/products/machine-requests"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $createdAt = Carbon::now();

            $requestNumber = "";

            // ##########################
            // GET PRODUCT MACHINE REQUESTS
            // $countYearlyMachineRequests = PtpmProductMachineRequest::where('request_date', $parseRequestDate)
            //                             ->whereNull('deleted_at')
            //                             ->count();
            // if($countYearlyMachineRequests == 0) {

            // ####################################################
            // PRODUCT MACHINE REQUESTS OF THIS REQUEST_DATE IS NOT EXISTS

            // CALL PACKAGE GENERATE PRODUCT MACHINE REQUESTS
            $pRequestDate           = $parseRequestDate;
            $pInventoryItemId       = $inventoryItemId;
            $pMachineName           = $machineName;
            $pObjectiveRequest      = $objectiveRequest;
            $resGenerateProductMachineRequest = PtpmMicsPkg::generateProductMachineRequest($pRequestDate, $pInventoryItemId, $pMachineName, $pObjectiveRequest);

            // ERROR CALL PACKAGE 
            if($resGenerateProductMachineRequest["status"] == "E") {
                throw new \Exception("REQUEST_DATE : " . $pRequestDate . " ERROR MSG : ". $resGenerateProductMachineRequest["message"]);
            } else {
                if($resGenerateProductMachineRequest["status"] == "S") {
                    $requestNumber = $resGenerateProductMachineRequest["message"];
                }
            }

            // }

            // $preProductMachineRequests = PtpmProductMachineRequest::where('request_date', $parseRequestDate)
            //                 ->whereNull('deleted_at')
            //                 ->get();

            $preProductMachineRequests = PtpmProductMachineRequest::where('request_number', $requestNumber)->get();

            $productMachineRequests = [];
            foreach ($preProductMachineRequests as $index => $productMachineRequest) {
                $productMachineRequests[$index] = $productMachineRequest->toArray();
                $productMachineRequests[$index]['product_item_number'] = $productMachineRequest->productItem()->value('item_number');
                $productMachineRequests[$index]['product_item_type'] = $productMachineRequest->productItem()->value('item_type');
                $productMachineRequests[$index]['product_item_desc'] = $productMachineRequest->productItem()->value('item_desc');
                $productMachineRequests[$index]['inv_item_number'] = $productMachineRequest->invItem()->value('item_number');
                $productMachineRequests[$index]['inv_item_type'] = $productMachineRequest->invItem()->value('item_type');
                $productMachineRequests[$index]['inv_item_desc'] = $productMachineRequest->invItem()->value('item_desc');
            }

            $responseResult["machine_requests"] = json_encode($productMachineRequests);

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeRequests(Request $request) {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "machine_requests"       => json_encode([]),
        ];

        DB::beginTransaction();

        try {

            $requestDate = $request->request_date;
            $parseRequestDate = parse_from_date_th($requestDate);
            $inputMachineRequests = $request->machine_requests ? json_decode($request->machine_requests) : [];

            $organizationId = optional(getDefaultData("/pm/products/machine-requests"))->organization_id ?? null;
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $departmentCode = optional(auth()->user())->department_code;
            $nowDate = Carbon::now();

            foreach($inputMachineRequests as $inputMachineRequest) {

                if ((!$inputMachineRequest->product_request_id && $inputMachineRequest->marked_as_deleted) || !$inputMachineRequest->inventory_item_id) {
                    // => PREVENT STORE NEW COMING LINE WITH MARKED_AS_DELETED
                } else {

                    if ($inputMachineRequest->product_request_id) {
                        $planLine = PtpmProductMachineRequest::where('product_request_id', $inputMachineRequest->product_request_id)->first();
                    } else {
                        $planLine = new PtpmProductMachineRequest;
                        $planLine->request_date         = $parseRequestDate;
                        $planLine->organization_id      = $inputMachineRequest->organization_id;
                        $planLine->request_number       = $inputMachineRequest->request_number;
                        $planLine->creation_date        = $inputMachineRequest->creation_date;
                    }
                    $planLine->attribute10              = $inputMachineRequest->is_new_line ? "Y" : "N"; // attribute10 == is_new_line
                    $planLine->request_qty              = $inputMachineRequest->request_qty;
                    $planLine->uom2                     = $inputMachineRequest->uom2;
                    $planLine->deleted_at               = $inputMachineRequest->marked_as_deleted ? $nowDate : null;
                    $planLine->updated_by_id            = $userId;
                    $planLine->last_updated_by          = $fndUserId;
                    $planLine->updated_at               = $nowDate;
                    $planLine->last_update_date         = $nowDate;
                    $planLine->save();
                    
                }
            
            }

            DB::commit();

            // GET UPDATED DATA FOR RESPONSE
            $preProductMachineRequests = PtpmProductMachineRequest::where('request_date', $parseRequestDate)
                            ->whereNull('deleted_at')
                            ->get();

            $productMachineRequests = [];
            foreach ($preProductMachineRequests as $index => $productMachineRequest) {
                $productMachineRequests[$index] = $productMachineRequest->toArray();
                $productMachineRequests[$index]['product_item_number'] = $productMachineRequest->productItem()->value('item_number');
                $productMachineRequests[$index]['product_item_type'] = $productMachineRequest->productItem()->value('item_type');
                $productMachineRequests[$index]['product_item_desc'] = $productMachineRequest->productItem()->value('item_desc');
                $productMachineRequests[$index]['inv_item_number'] = $productMachineRequest->invItem()->value('item_number');
                $productMachineRequests[$index]['inv_item_type'] = $productMachineRequest->invItem()->value('item_type');
                $productMachineRequests[$index]['inv_item_desc'] = $productMachineRequest->invItem()->value('item_desc');
            }
            
            $responseResult["machine_requests"] = json_encode($productMachineRequests);


        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function exportPdf(Request $request) {
    
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "file_name"             => "", 
            "file_path"             => ""
        ];

        try {

            $requestDate = $request->request_date;
            $parseRequestDate = parse_from_date_th($requestDate);

            $preProductMachineRequests = PtpmProductMachineRequest::where('request_date', $parseRequestDate)
                            ->whereNull('deleted_at')
                            ->get();

            $productMachineRequests = [];
            foreach ($preProductMachineRequests as $index => $productMachineRequest) {
                $productMachineRequests[$index] = $productMachineRequest->toArray();
                $productMachineRequests[$index]['product_item_number'] = $productMachineRequest->productItem()->value('item_number');
                $productMachineRequests[$index]['product_item_type'] = $productMachineRequest->productItem()->value('item_type');
                $productMachineRequests[$index]['product_item_desc'] = $productMachineRequest->productItem()->value('item_desc');
                $productMachineRequests[$index]['inv_item_number'] = $productMachineRequest->invItem()->value('item_number');
                $productMachineRequests[$index]['inv_item_type'] = $productMachineRequest->invItem()->value('item_type');
                $productMachineRequests[$index]['inv_item_desc'] = $productMachineRequest->invItem()->value('item_desc');
                $productMachineRequests[$index]['formatted_creation_date'] = parse_to_date_th($productMachineRequests[$index]['creation_date']);
            }

            $file_name = time() . ".pdf";
            $file_path = storage_path("app/pm/products/machine-requests/pdf/{$file_name}");

            \PDF::loadView('pm.exports.products.machine-requests', compact('productMachineRequests'))
                ->setPaper('a4')
                ->setOption('margin-top', '1cm')
                ->setOption('margin-bottom', '2cm')
                ->setOption('margin-left', '0.7cm')
                ->setOption('margin-right', '0.7cm')
                ->setOption('encoding', 'utf-8')
                ->save($file_path);

            $responseResult["file_name"]   = $file_name;
            $responseResult["file_path"]   = $file_path;

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

}