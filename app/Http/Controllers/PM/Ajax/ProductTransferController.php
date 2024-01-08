<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PM\PtBiweekly;
use Illuminate\Http\Request;

use App\Models\PM\PtpmProductTransferH;
use App\Models\PM\PtpmProductTransferL;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtinvOnhandQuantitiesV;
use App\Models\PM\PtpmPmp0052V;
use App\Models\PM\PtpmBatchTransactionsV;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtInvUomV;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PM\PtinvLocatorV;
use App\Repositories\PM\CommonRepository;
use App\Repositories\PM\TransferProductRepository;
use App\Repositories\PM\Settings\SavePublicationLayoutRepository;

use Carbon\Carbon;
use Log;
use DB;
use Arr;

class ProductTransferController extends Controller
{
    
    public function findHeader(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"        => null
        ];

        try {

            $transferNumber = $request->transfer_number;

            $profile = getDefaultData('/pm/products/transfers');
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;

            $transferHeader = null;
            $builderRequestHeader = PtpmProductTransferH::where("program_code", $programCode)
                                        ->where('organization_id', $organizationId);
            if($transferNumber) {
                $transferHeader = $builderRequestHeader->where('transfer_number', $transferNumber)->first();
            }

            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;


        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getHeaders(Request $request)
    {
        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_headers"       => null
        ];

        try {   

            $transferNumber = $request->search_transfer_number;
            // $productDateFrom = $request->product_date_from;
            // $productDateTo = $request->product_date_to;
            $transferDateFrom = $request->transfer_date_from;
            $transferDateTo = $request->transfer_date_to;

            // $transObjective = $request->transfer_objective;
            // $toLocatorId = $request->to_locator_id;

            $profile = getDefaultData('/pm/products/transfers');
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;

            $searchInputs = [
                "transfer_number"           => $transferNumber,
                // "product_date_from"         => $productDateFrom,
                // "product_date_to"           => $productDateTo,
                "transfer_date_from"        => $transferDateFrom,
                "transfer_date_to"          => $transferDateTo,
            ];

            $transferHeaders = PtpmProductTransferH::where("program_code", $programCode)
                ->where('organization_id', $organizationId)
                ->search($searchInputs)
                ->get();

            $responseResult['transfer_headers'] = json_encode($transferHeaders);
            

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function storeHeader(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"       => null,
        ];

        DB::beginTransaction();

        try {

            // $productDate = $request->product_date;
            $transferDate = $request->transfer_date;
            $transObjective = $request->transfer_objective;
            $toLocatorId = $request->to_locator_id;

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            // $mfgDepartment = PtpmSetupMfgDepartmentsV::wipCompleteType()->where('organization_id', $organizationId)->first();
            // $toLocatorModel = PtinvLocatorV::where('organization_id', $mfgDepartment->to_organization_id)->where('inventory_location_id', $toLocatorId)->first();

            $toLocatorModel = PtinvLocatorV::where('organization_id', 165)->where('inventory_location_id', 9191)->first();
            $toLocatorModel = PtinvLocatorV::where('inventory_location_id', $toLocatorId)->first();
            // dd('xxxxx', $inputTransferHeader, $request->all());

            if ($inputTransferHeader) {

                $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
                $organizationId = data_get($transferHeader, 'organization_id', $profile->organization_id);

            } else {
                
                $webBatchNo = self::generateWebBatchNo();

                $transferHeader                         = new PtpmProductTransferH;
                $transferHeader->transfer_status        = "1";
                $transferHeader->transfer_objective     = $transObjective;
                $transferHeader->transfer_objective     = 8; // สินค้าคงคลัง
                // $transferHeader->product_date           = parse_from_date_th($productDate);
                $transferHeader->created_by             = $fndUserId;
                $transferHeader->created_by_id          = $userId;
                $transferHeader->created_at             = $nowDate;
                $transferHeader->creation_date          = $nowDate;
                $transferHeader->program_code           = $programCode;
                $transferHeader->organization_id        = $organizationId;
                $transferHeader->web_batch_no           = $webBatchNo;

            }

            $transferHeader->transfer_date      = parse_from_date_th($transferDate);
            // $transferHeader->attribute10        = $toDepartmentCode;
            $transferHeader->attribute11        = $toLocatorId;
            $transferHeader->attribute12        = $toLocatorModel->organization_id;
            $transferHeader->attribute1 = now()->weeksInYear();
            // $transferHeader->attribute11        = 9193;
            // $transferHeader->attribute12        = 165;
            $transferHeader->updated_by_id      = $userId;
            $transferHeader->last_updated_by    = $fndUserId;
            $transferHeader->updated_at         = $nowDate;
            $transferHeader->last_update_date   = $nowDate;

            $transferHeader->save();

            // $toLocatorModel = (object) [
            //     'organization_id' => 165,
            //     'subinventory_code' => 'PURROJ04',
            //     'inventory_location_id' => 9193,
            // ];

            DB::commit();

            $updatedRequestHeader = PtpmProductTransferH::find($transferHeader->transfer_header_id);
            $responseResult['transfer_header'] = json_encode($updatedRequestHeader);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function getConfirmItems(Request $request)
    {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "confirm_inv_items"         => [],
            "transaction_items"         => [],
        ];

        try {

            $transferDate = $request->transfer_date;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();
            
            $confirmedInvItems = [];
            $transactionItems = [];
            // ## CASE : NORMAL
            $confirmedInvItems = self::getConfirmedInvItems($organizationId, parse_from_date_th($transferDate));

            $responseResult['confirm_inv_items'] = json_encode($confirmedInvItems);
            $responseResult['transaction_items'] = json_encode($transactionItems);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }
    
    public function getLines(Request $request)
    {

        $responseResult = [
            "status"                        => "success",
            "message"                       => "",
            "transfer_header"               => null,
            "transfer_inv_item_lines"       => [],
        ];

        try {

            $transferNumber = $request->transfer_number;
            
            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            $transferHeader = PtpmProductTransferH::where("program_code", $programCode)
                                ->where('organization_id', $organizationId)
                                ->where('transfer_number', $transferNumber)
                                ->first();

            // $transferLines = [];
            $transferInvItemLines = [];
            if($transferHeader) {
                $transferInvItemLines = self::getTransferInvItemLines($transferHeader->transfer_header_id);
                // dd('xxx', $transferInvItemLines);
            }

            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;
            $responseResult['transfer_inv_item_lines'] = json_encode($transferInvItemLines);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);
    }

    public function getOnhands(Request $request)
    {

        $responseResult = [
            "status"                    => "success",
            "message"                   => "",
            "onhand_inv_item_lines"     => [],
        ];

        try {

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;
            $inputTransferInvItemLines = $request->transfer_inv_item_lines ? json_decode($request->transfer_inv_item_lines) : [];

            $onhandInvItemLines = [];
            foreach($inputTransferInvItemLines as $index => $inputTransferInvItemLine) {

                $onhandInvItemLines[$index] = json_decode(json_encode($inputTransferInvItemLine), true);

                $organizationId = $inputTransferHeader->organization_id;
                $productDate = date('Y-m-d', strtotime($inputTransferHeader->product_date));
                $inventoryItemId = $inputTransferInvItemLine->inventory_item_id;
                $uomCode = $inputTransferInvItemLine->uom_code;

                if($organizationId && $inventoryItemId && $uomCode && $productDate) {
                    $onhandInvItemLines[$index]['onhand_qty'] = self::callGetOnhandQty($organizationId, $inventoryItemId, $uomCode, $productDate);
                } else {
                    $onhandInvItemLines[$index]['onhand_qty'] = 0;
                }

            }

            $responseResult['onhand_inv_item_lines'] = json_encode($onhandInvItemLines);

        } catch (\Exception $e) {

            Log::error($e);

            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public static function callGetOnhandQty($organizationId, $inventoryItemId, $uomCode, $productDate) {

        $onhandQty = 0;

        $resGetOnnhand = DB::select("
            select ptpm_pmp0052_pkg.get_onhand_qty(p_organization_id => :organization_id,
                p_item_id => :item_id,
                p_uom_code => :uom_code,
                p_tran_date => TO_DATE(:tran_date, 'yyyy-mm-dd')) as onhand_qty from dual
        ", [
            'organization_id'   => $organizationId,
            'item_id'           => $inventoryItemId,
            'uom_code'          => $uomCode,
            'tran_date'         => $productDate
        ]);
        
        if($resGetOnnhand) {
            if(count($resGetOnnhand) > 0) {
                $onhandQty = $resGetOnnhand[0]->onhand_qty;
            }
        }

        return $onhandQty;

    }

    public function getDataAttribute($transfer_number, $year) {
        $sql = "SELECT(SELECT MIL.SEGMENT1
                    FROM MTL_ITEM_LOCATIONS MIL
                    WHERE H.ATTRIBUTE12 = MIL.ORGANIZATION_ID
                    AND H.ATTRIBUTE11 = MIL.INVENTORY_LOCATION_ID) LOCATOR_1 --L.ATTRIBUTE2
                ,   ( SELECT MIL.SEGMENT2
                    FROM MTL_ITEM_LOCATIONS MIL
                    WHERE H.ATTRIBUTE12 = MIL.ORGANIZATION_ID
                    AND H.ATTRIBUTE11 = MIL.INVENTORY_LOCATION_ID) LOCATOR_2 --L.ATTRIBUTE2
                ,       (SELECT PIN.ITEM_NUMBER
                        FROM PTPM_ITEM_NUMBER_V PIN
                        WHERE PIN.ORGANIZATION_ID = H.ORGANIZATION_ID
                        AND PIN.INVENTORY_ITEM_ID = L.INVENTORY_ITEM_ID) ITEM_NUMBER --L.ATTRIBUTE3
                ,       (SELECT PIN.ITEM_DESC
                        FROM PTPM_ITEM_NUMBER_V PIN
                        WHERE PIN.ORGANIZATION_ID = H.ORGANIZATION_ID
                        AND PIN.INVENTORY_ITEM_ID = L.INVENTORY_ITEM_ID) ITEM_DESC --L.ATTRIBUTE4
                ,       (SELECT UOM.UNIT_OF_MEASURE
                        FROM PTINV_UOM_V UOM
                        WHERE UOM.UOM_CODE = L.TRANSACTION_UOM) UNIT_OF_MEASURE --L.ATTRIBUTE5 
                ,       (SELECT PIN.TOBACCO_GROUP_CODE
                        FROM PTPM_ITEM_NUMBER_V PIN
                        WHERE PIN.ORGANIZATION_ID = H.ORGANIZATION_ID
                        AND PIN.INVENTORY_ITEM_ID = L.INVENTORY_ITEM_ID) CAT_CODE --L.ATTRIBUTE6
                ,H.*
                ,L.*
                FROM    OAPM.PTPM_PRODUCT_TRANSFER_H H
                        , OAPM.PTPM_PRODUCT_TRANSFER_L L
                        , (SELECT FLV.LOOKUP_CODE   TRANSFER_OBJECTIVE
                                , FLV.DESCRIPTION  OBJECTIVE_DESCRIPTION
                            FROM APPS.FND_LOOKUP_TYPES_VL    FLT
                                , APPS.FND_LOOKUP_VALUES_VL  FLV
                            WHERE 1=1
                                AND FLT.LOOKUP_TYPE     = FLV.LOOKUP_TYPE
                                AND FLT.LOOKUP_TYPE     = 'PTPM_TRANSFER_OBJECTIVE'
                                AND FLV.ENABLED_FLAG   = 'Y')  FLV
                        , (SELECT FLV1.LOOKUP_CODE          TRANSFER_STATUS
                                , FLV1.DESCRIPTION         STATUS_DESCRIPTION
                            FROM APPS.FND_LOOKUP_TYPES_VL    FLT1
                                , APPS.FND_LOOKUP_VALUES_VL  FLV1
                            WHERE 1=1
                                AND FLT1.LOOKUP_TYPE     = FLV1.LOOKUP_TYPE
                                AND FLT1.LOOKUP_TYPE     = 'PTPM_TRANSFER_STATUS'
                                AND FLV1.ENABLED_FLAG     = 'Y')  FLV1
                WHERE   1=1
                AND     H.TRANSFER_HEADER_ID    = L.TRANSFER_HEADER_ID
                AND     H.TRANSFER_OBJECTIVE    = FLV.TRANSFER_OBJECTIVE
                AND     H.TRANSFER_STATUS       = FLV1.TRANSFER_STATUS
                AND     TO_CHAR(H.CREATION_DATE,'YYYY') = '{$year}'
                AND     H.TRANSFER_NUMBER       = '{$transfer_number}'
                ";
        
        // dd($sql);
        return DB::select($sql)[0];
    }

    public function storeLines(Request $request)
    {

        $responseResult = [
            "status"                        => "success",
            "message"                       => "",
            "transfer_header"               => null,
            "transfer_inv_item_lines"       => [],
        ];

        DB::beginTransaction();

        try {

            $transferNumber = $request->transfer_number;
            // $productDate = $request->product_date;
            $transferDate = $request->transfer_date;
            $transObjective = $request->transfer_objective;
            $toLocatorId = $request->to_locator_id;

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;
            $inputTransferInvItemLines = $request->transfer_inv_item_lines ? json_decode($request->transfer_inv_item_lines) : [];

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $transferInvItemLines = json_decode(json_encode($inputTransferInvItemLines), true);
            $transferBiweekly = self::findBiweekly(parse_from_date_th($transferDate));

            // ## CASE : NORMAL

            if($transferHeader) {

                if($transferHeader->transfer_status != "1") {
                    throw new \Exception("ไม่สามารถบันทึกส่งสินค้าสำเร็จรูป ที่ยืนยันแล้วหรือยกเลิกแล้ว");
                }
                
                $biweekly = PtBiweekly::whereRaw("'". $transferHeader->transfer_date->format('Y-m-d') ."' between trunc(START_DATE) AND trunc(END_DATE)")->first();

                // REMOVE OLD TRANSFER LINES
                $transferLines = PtpmProductTransferL::where('transfer_header_id', $transferHeader->transfer_header_id)->get();
                foreach ($transferLines as $transferLine) {
                    $transferLine->delete();
                }

                foreach ($transferInvItemLines as $key => $transferInvItemLine) {
                    
                    $mfgData = self::getMfgDepartmentData($organizationId, $transferInvItemLine);
                    $mfgDepartment = $mfgData->mfg_department;
                    $convertFlag = $mfgData->convert_flag;
                    $fmLocatorModel = (object) [
                        'organization_id' => $mfgDepartment->to_organization_id,
                        'subinventory_code' => $mfgDepartment->to_subinventory,
                        'inventory_location_id' => $mfgDepartment->to_locator_id,
                    ];

                    // #################################
                    // CALL PACKAGE INSERT LINE
                    $transferHeaderId = $transferHeader->transfer_header_id;
                    $resInsertLine = PtpmPmp0052V::callInsertLine($transferHeaderId, $transferInvItemLine, $fmLocatorModel);

                    // get Attribute data 07/09/2563
                    $att = $this->getDataAttribute($transferHeader->transfer_number,Carbon::createFromFormat('Y-m-d H:i:s', $transferHeader->created_at)->format('Y'));
                    // UPDATE LINES
                    $locator =  PtinvLocatorV::where('organization_id', $transferHeader->attribute12)
                        ->where('inventory_location_id', $transferHeader->attribute11)->first();
                    $line = [
                        'organization_id_to' => $transferHeader->attribute12,
                        'subinventory_to'    => optional($locator)->subinventory_code,
                        'locator_id_to'      => $transferHeader->attribute11,
                        'BIWEEKLY'           => optional($biweekly)->biweekly,
                        'created_by'         => $fndUserId,
                        'created_by_id'      => $userId,
                        'created_at'         => $nowDate,
                        'creation_date'      => $nowDate,
                        'program_code'       => $programCode,
                        'attribute2'        => optional($att)->locator_1.'.'.optional($att)->locator_2,
                        'attribute3'        => optional($att)->item_number,
                        'attribute4'        => optional($att)->item_desc,
                        'attribute5'        => optional($att)->unit_of_measure,
                        'attribute6'        => optional($att)->cat_code,
                        'attribute11'        => $convertFlag,
                        'attribute12'        => data_get($transferInvItemLine, 'destination_locator_id', null),
                    ];
                    $transferLines = PtpmProductTransferL::where('transfer_header_id', $transferHeader->transfer_header_id)
                                        ->where('inventory_item_id', data_get($transferInvItemLine, 'inventory_item_id', -999))
                                        ->update($line);
                    // ERROR CALL PACKAGE 
                    if($resInsertLine["status"] == "E") {
                        // $responseResult["status"]   = "error";
                        // $responseResult["message"]  = $resInsertLine["message"];
                        throw new \Exception("ไม่สามารถบันทึกรายการ transaction ของ สินค้าสำเร็จรูป {$transferInvItemLine['item_number']} : {$transferInvItemLine['item_desc']} : {$resInsertLine['message']}");
                    }

                    // Update Attribute8
                    $transferLines = PtpmProductTransferL::where('transfer_header_id', $transferHeader->transfer_header_id)->get();
                    foreach ($transferLines as $key => $line) {
                        if ($line->locator_id_from) {
                            $locator =  PtinvLocatorV::where('inventory_location_id', $line->locator_id_from)->first();
                            if ($locator) {
                                $line->attribute8 = $locator->locator;
                                $line->save();
                            }
                        }
                    }

                }

            }

            DB::commit();

            $transferInvItemLines = [];
            if($inputTransferHeader) {
                $transferInvItemLines = self::getTransferInvItemLines($inputTransferHeader->transfer_header_id);
            }

            $responseResult['transfer_inv_item_lines'] = json_encode($transferInvItemLines);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    private static function getMfgDepartmentData($organizationId, $transferInvItemLine) {

        $tableName = (new PtpmSetupMfgDepartmentsV)->getTable();
        $joinTableName = (new \App\Models\PM\PtpmItemNumberV)->getTable();

        $mfgDepartment = PtpmSetupMfgDepartmentsV::wipCompleteType()
                            ->leftJoin($joinTableName, function($join) use ($tableName, $joinTableName, $transferInvItemLine, $organizationId) {
                                $join->on("$joinTableName.tobacco_group_code", "$tableName.tobacco_group_code")
                                    ->whereRaw("($tableName.from_organization_id) = ($tableName.organization_id)")
                                    ->whereRaw("$joinTableName.inventory_item_id = ".  data_get($transferInvItemLine, 'inventory_item_id', ''))
                                    ->whereRaw("$tableName.organization_id = $organizationId");
                            })
                        ->whereRaw("
                            $tableName.organization_id = $organizationId
                            and $tableName.organization_id = $organizationId
                            and $tableName.enable_flag = 'Y'
                        ")
                        ->first();

        $convertFlag = data_get($transferInvItemLine, 'convert_flag', 'N');
        if ( $convertFlag == 'Y') {
            $fromLocatorId = data_get($transferInvItemLine, 'destination_locator_id', null);
            $locator = PtinvLocatorV::where('inventory_location_id', $fromLocatorId)->first();
            $mfgDepartment = (object) [];
            $mfgDepartment->to_organization_id  = $locator->organization_id;
            $mfgDepartment->to_subinventory     = $locator->subinventory_code;
            $mfgDepartment->to_locator_id       = $fromLocatorId;
        }

        /* select  psmd.to_organization_id,psmd.to_subinventory,psmd.to_locator_id
        from    ptpm_setup_mfg_departments_v psmd,
                ptpm_item_number_v pin
        where   psmd.wip_transaction_type_id = 44
        and     psmd.organization_id = 183 --log in org id
        and     psmd.tobacco_group_code = pin.tobacco_group_code
        and     psmd.from_organization_id = pin.organization_id
        and     pin.inventory_item_id = 65638; */

        return (object)[
            "mfg_department" => $mfgDepartment,
            "convert_flag" => $convertFlag
        ];

    }

    public static function fifoLineItems($transactionLines, $transferInvItemLines) {

        $preparedTransferLines = [];

        // FIFO PICK ITEM
        foreach ($transferInvItemLines as $indexInvItemL => $transferInvItemLine) {

            $totalTransactionQty = 0;
            $confirmTransactionQty = round(floatval($transferInvItemLine["transaction_qty"]), 2);
            $remainTransactionQty = round(floatval($transferInvItemLine["transaction_qty"]), 2);

            $preparedTransferLines[$indexInvItemL] = [];
            $preparedTransferLines[$indexInvItemL]["inventory_item_id"] = $transferInvItemLine["inventory_item_id"];
            // $preparedTransferLines[$indexInvItemL]["marked_as_deleted"] = $transferInvItemLine["marked_as_deleted"];
            $preparedTransferLines[$indexInvItemL]["confirm_transaction_qty"] = $confirmTransactionQty;
            $preparedTransferLines[$indexInvItemL]["line_items"] = [];
            

            $fIndex = 0;
            foreach ($transactionLines as $transactionLine) {

                if($transferInvItemLine["inventory_item_id"] == $transactionLine["inventory_item_id"] && $transferInvItemLine["lot_number"] == $transactionLine["lot_number"]) {

                    $preparedTransferLines[$indexInvItemL]["line_items"][$fIndex] = json_decode(json_encode($transactionLine), true);
                    $transactionQty = round(floatval($transactionLine["transaction_qty"]), 2);
                    $totalTransactionQty = $totalTransactionQty + $transactionQty;

                    if($transactionQty > $remainTransactionQty) {
                        $transactionQty = $remainTransactionQty;
                        $remainTransactionQty = 0;
                    } else {
                        $remainTransactionQty = $remainTransactionQty - $transactionQty;
                    }

                    $preparedTransferLines[$indexInvItemL]["line_items"][$fIndex]["transaction_qty"] = $transactionQty;

                    $fIndex++;

                }

            }

            // VALIDATE : IF NOT FOUND ANY TRANSACTION OF THIS ITEM
            if(count($preparedTransferLines[$indexInvItemL]["line_items"]) == 0) {
                throw new \Exception("ไม่พบรายการ transaction ของ สินค้าสำเร็จรูป {$transferInvItemLine['item_number']} : {$transferInvItemLine['item_desc']}");
            }

            // VALIDATE : IF TOTAL_TRANSACTION_QTY IS NOT OVER COMFIRM_QTY
            if($confirmTransactionQty > $totalTransactionQty) {
                throw new \Exception("จำนวน transaction qty (ptpm_batch_transactions_v) ไม่เพียงพอ ( confirm qty : {$confirmTransactionQty} , transaction qty : {$totalTransactionQty} ) | สินค้าสำเร็จรูป {$transferInvItemLine['item_number']} : {$transferInvItemLine['item_desc']}");
            }


        }

        return $preparedTransferLines;

    }

    public function confirmRequest(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"        => null
        ];

        DB::beginTransaction();

        try {

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            // #################################
            // CALL PACKAGE MAIN PROCESS

            $pWebBatchNo    = $inputTransferHeader->web_batch_no;
            $pUsername      = auth()->user()->getOAUserName();

            $resMainProcess = PtpmPmp0052V::callMainProcess($pWebBatchNo, $pUsername);
            
            // ERROR CALL PACKAGE 
            if($resMainProcess["status"] == "E") {
                $responseResult["status"]   = "error";
                $responseResult["message"]  = $resMainProcess["message"];
            }

            DB::commit();

            $updatedRequestHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $responseResult['transfer_header'] = json_encode($updatedRequestHeader);

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function discardConfirmedRequest(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"        => null
        ];

        DB::beginTransaction();

        try {

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            //     $header = (new TransferProductRepository)->store($request);

            //     $header->refresh();
            //     $resHeader = request()->header;
            //     $resHeader['transfer_header_id'] =  data_get($header, 'transfer_header_id',  -1);
            //     $resHeader['transfer_number'] = data_get($header, 'transfer_number', date('Ymd-His'));
            //     $resHeader['can'] = $header->can;

            //      $data = [
            //         'status' => 'S',
            //         'header' => $resHeader
            //     ];

            DB::commit();

            $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function cancelRequest(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"        => null
        ];

        DB::beginTransaction();

        try {

            $transferNumber = $request->transfer_number;
            // $productDate = $request->product_date;
            $transferDate = $request->transfer_date;
            $transObjective = $request->transfer_objective;
            $toLocatorId = $request->to_locator_id;

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            //     $header = (new TransferProductRepository)->store($request);

            //     $header->refresh();
            //     $resHeader = request()->header;
            //     $resHeader['transfer_header_id'] =  data_get($header, 'transfer_header_id',  -1);
            //     $resHeader['transfer_number'] = data_get($header, 'transfer_number', date('Ymd-His'));
            //     $resHeader['can'] = $header->can;

            //      $data = [
            //         'status' => 'S',
            //         'header' => $resHeader
            //     ];

            DB::commit();

            $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public function submitRequest(Request $request)
    {

        $responseResult = [
            "status"                => "success",
            "message"               => "",
            "transfer_header"        => null
        ];

        DB::beginTransaction();

        try {

            $transferNumber = $request->transfer_number;
            // $productDate = $request->product_date;
            $transferDate = $request->transfer_date;
            $transObjective = $request->transfer_objective;
            $toLocatorId = $request->to_locator_id;

            $inputTransferHeader = $request->transfer_header ? json_decode($request->transfer_header) : null;

            $profile = getDefaultData('/pm/products/transfers');
            $userId = $profile->fnd_user_id;
            $fndUserId = $profile->user_id;
            $departmentCode = $profile->department_code;
            $organizationId = $profile->organization_id;
            $organizationCode = $profile->organization_code;
            $programCode = $profile->program_code;
            $nowDate = Carbon::now();

            //     $header = (new TransferProductRepository)->store($request);

            //     $header->refresh();
            //     $resHeader = request()->header;
            //     $resHeader['transfer_header_id'] =  data_get($header, 'transfer_header_id',  -1);
            //     $resHeader['transfer_number'] = data_get($header, 'transfer_number', date('Ymd-His'));
            //     $resHeader['can'] = $header->can;

            //      $data = [
            //         'status' => 'S',
            //         'header' => $resHeader
            //     ];

            DB::commit();

            $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollBack();
            $responseResult["status"]   = "error";
            $responseResult["message"]  = $e->getMessage();
        }

        return response()->json(['data' => $responseResult]);

    }

    public static function getTransferLines($transferHeaderId) {

        $transferLines = [];
        if($transferHeaderId) {
            $preRequestLines = PtpmProductTransferL::where('transfer_header_id', $transferHeaderId)->orderBy('inventory_item_id')->get();
            foreach ($preRequestLines as $index => $preRequestLine) {

                $invItem = $preRequestLine->invItem()->first();
                $itemUomCode = $preRequestLine->uomCode()->first();

                $transferLines[$index]                                      = $preRequestLine->toArray();
                $transferLines[$index]['uom_code']                          = $preRequestLine->transaction_uom;
                $transferLines[$index]['item_number']                       = $invItem->item_number;
                $transferLines[$index]['item_desc']                         = $invItem->item_desc;
                $transferLines[$index]['unit_of_measure']                   = $itemUomCode->unit_of_measure;
                $transferLines[$index]['tobacco_group_code']                = $invItem->tobacco_group_code ?? '';
                $transferLines[$index]['tobacco_type_code']                 = $invItem->tobacco_type_code ?? '';
                // $transferLines[$index]['locator_code_from']                 = $preRequestLine->attribute8;
                // $transferLines[$index]['batch_no']                          = $preRequestLine->attribute10;
                $transferLines[$index]['marked_as_deleted']                 = false;
            }
        }

        return $transferLines;

    }

    public static function getTransferInvItemLines($transferHeaderId) {

        $profile = getDefaultData('/pm/products/transfers');
        $organizationCode = $profile->organization_code;

        $preRequestLines = [];
        $transferInvLines = [];
        if($transferHeaderId) {

            // ## CASE : NORMAL

            $preRequestLines = PtpmProductTransferL::selectRaw("
                transfer_header_id
                ,organization_id_from
                ,inventory_item_id
                ,subinventory_from
                ,locator_id_from
                ,organization_id_to
                ,subinventory_to
                ,locator_id_to
                ,attribute1
                ,attribute2
                ,attribute3
                ,attribute4
                ,attribute5
                ,attribute6
                ,attribute7
                ,attribute8
                ,attribute9
                ,attribute10
                ,attribute11
                ,attribute12
                ,attribute13
                ,attribute14
                ,attribute15
                ,transaction_uom
                ,attribute11 convert_flag
                ,attribute12 destination_locator_id
                ,organization_id_to destination_organization_id
                ,sum(transaction_qty) transaction_qty
            ")->where('transfer_header_id', $transferHeaderId)
            ->groupBy([
                'transfer_header_id'
                ,'organization_id_from'
                ,'inventory_item_id'
                ,'subinventory_from'
                ,'locator_id_from'
                ,'organization_id_to'
                ,'subinventory_to'
                ,'locator_id_to'
                ,'attribute1'
                ,'attribute2'
                ,'attribute3'
                ,'attribute4'
                ,'attribute5'
                ,'attribute6'
                ,'attribute7'
                ,'attribute8'
                ,'attribute9'
                ,'attribute10'
                ,'attribute11'
                ,'attribute12'
                ,'attribute13'
                ,'attribute14'
                ,'attribute15'
                ,'transaction_uom'
            ])
            ->orderBy("inventory_item_id")
            ->get();

            foreach ($preRequestLines as $index => $preRequestLine) {

                $invItem = $preRequestLine->invItem()->first();
                $itemUomCode = $preRequestLine->uomCode()->first();
                $transferInvLines[$index]                                      = $preRequestLine->toArray();
                $transferInvLines[$index]['uom_code']                          = $preRequestLine->transaction_uom;
                $transferInvLines[$index]['item_number']                       = $invItem->item_number;
                $transferInvLines[$index]['item_desc']                         = $invItem->item_desc;
                $transferInvLines[$index]['unit_of_measure']                   = $itemUomCode->unit_of_measure;
                $transferInvLines[$index]['tobacco_group_code']                = $invItem->tobacco_group_code ?? '';
                $transferInvLines[$index]['tobacco_type_code']                 = $invItem->tobacco_type_code ?? '';
                // $transferInvLines[$index]['locator_code_from']                 = $preRequestLine->attribute8;
                // $transferInvLines[$index]['marked_as_deleted']                 = false;

                if ($preRequestLine->convert_flag == 'Y') {
                    $transferInvLines[$index]['locators'] = self::getLocators($preRequestLine->destination_organization_id);
                }
            }

        }

        return $transferInvLines;

    }
    
    public static function getTransactionItems($organizationId, $transferDate) {

        $transferLines = [];
        if ($organizationId) {

            $transactionItems = PtpmBatchTransactionsV::where('organization_id', $organizationId)
                // ->whereDate('transaction_date', $transferDate)
                ->where('transaction_type_name', 'WIP Completion')
                ->whereNotNUll('transaction_quantity')
                ->orderBy('transaction_date')
                ->get();

            $transferLines = self::mapTransactionItemTransferLines($transactionItems);
            
        }

        return $transferLines;

    }

    public static function getTransactionLotItems($organizationId, $transferDate) {

        $transferLines = [];
        if ($organizationId) {

            $transactionItems = PtpmBatchTransactionsV::selectRaw("
                    organization_id
                    ,inventory_item_id
                    ,item_no as item_number
                    ,item_desc
                    ,subinventory_code
                    ,locator_id
                    ,locator_code
                    ,lot_number
                    ,transaction_uom
                    ,transaction_type_name
                    ,sum(transaction_quantity) transaction_quantity
                ")
                ->where('organization_id', $organizationId)
                // ->whereDate('transaction_date', $transferDate)
                ->where('transaction_type_name', 'WIP Completion')
                ->whereNotNUll('transaction_quantity')
                ->groupBy([
                    'organization_id'
                    ,'inventory_item_id'
                    ,'item_no'
                    ,'item_desc'
                    ,'subinventory_code'
                    ,'locator_id'
                    ,'locator_code'
                    ,'lot_number'
                    ,'transaction_uom'
                    ,'transaction_type_name'
                ])
                ->orderBy('lot_number')
                ->orderBy('inventory_item_id')
                ->get();

            $transferLines = self::mapTransactionItemTransferLines($transactionItems);
            
        }

        return $transferLines;

    }

    public static function getConfirmedInvItems($organizationId, $transferDate) {

        $transferLines = [];
        if ($transferDate) {

            $confirmedInvItems = PtpmPmp0052V::selectRaw("
                organization_id
                , send_date
                , inventory_item_id
                , item_number
                , item_desc
                , uom_code
                , destination_organization_id
                , destination_locator_id
                , convert_flag
                , sum(confirm_issue_qty) confirm_issue_qty
            ")
            ->where('organization_id', $organizationId)
            ->whereDate('send_date', $transferDate)
            ->whereNotNUll('confirm_issue_qty')
            ->groupBy([
                'organization_id',
                'send_date',
                'inventory_item_id',
                'item_number',
                'item_desc',
                'destination_organization_id',
                'destination_locator_id',
                'convert_flag',
                'uom_code'
            ])
            ->orderBy('inventory_item_id')
            ->get();

            $transferLines = self::mapConfirmedInvItemTransferLines($confirmedInvItems);
        }

        return $transferLines;

    }

    public static function mapConfirmedInvItemTransferLines($transferInvItems) {

        $itemLines = [];

        foreach($transferInvItems as $index => $transferInvItem) {
            $invItem = $transferInvItem->invItem()->first();
            $itemUomCode = $transferInvItem->uomCode()->first();
            $confirmIssueQty = $transferInvItem->confirm_issue_qty ?? 0;

            $itemLines[$index]                                  = [];
            $itemLines[$index]['organization_id']               = $transferInvItem->organization_id;
            $itemLines[$index]['inventory_item_id']             = $transferInvItem->inventory_item_id;
            $itemLines[$index]['item_number']                   = $invItem->item_number;
            $itemLines[$index]['item_desc']                     = $invItem->item_desc;
            $itemLines[$index]['organization_id_to']            = '';
            $itemLines[$index]['transaction_type_id_to']        = '';
            $itemLines[$index]['subinventory_to']               = '';
            $itemLines[$index]['locator_id_to']                 = '';
            $itemLines[$index]['organization_id_from']          = $transferInvItem->organization_id ?? '';
            $itemLines[$index]['transaction_type_id_from']      = '';
            $itemLines[$index]['subinventory_from']             = $transferInvItem->subinventory_code ?? '';
            $itemLines[$index]['locator_id_from']               = $transferInvItem->locator_id ?? '';
            $itemLines[$index]['locator_code_from']             = $transferInvItem->locator_code ?? '';
            $itemLines[$index]['tobacco_type_code']             = $invItem->tobacco_type_code ?? '';
            $itemLines[$index]['tobacco_group_code']            = $invItem->tobacco_group_code ?? '';

            $itemLines[$index]['uom_code']                      = $transferInvItem->uom_code;
            $itemLines[$index]['transaction_uom']               = $transferInvItem->uom_code;
            $itemLines[$index]['unit_of_measure']               = $itemUomCode->unit_of_measure;
            //     $transferedQty   = self::getTransferedQty($transferInvItem);
            //     $itemLines[$index]['transaction_qty']        = $confirmIssueQty - $transferedQty;
            $itemLines[$index]['transaction_qty']               = $confirmIssueQty;
            $itemLines[$index]['convert_flag']                  = $transferInvItem->convert_flag;
            $itemLines[$index]['destination_organization_id']   = $transferInvItem->destination_organization_id;
            $itemLines[$index]['destination_locator_id']        = $transferInvItem->destination_locator_id;

            if ($transferInvItem->convert_flag == 'Y') {
                $itemLines[$index]['locators'] = self::getLocators($transferInvItem->destination_organization_id);
            }

        }

        return $itemLines;

    }

    public static function mapTransactionItemTransferLines($transactionItems) {

        $itemLines = [];

        foreach($transactionItems as $index => $transactionItem) {
            
            $invItem = $transactionItem->invItem()->first();
            $itemUomCode = $transactionItem->uomCode()->first();
            $transactionQty = $transactionItem->transaction_quantity ?? 0;

            $itemLines[$index]                              = [];
            $itemLines[$index]['organization_id']           = $transactionItem->organization_id;
            $itemLines[$index]['inventory_item_id']         = $transactionItem->inventory_item_id;
            $itemLines[$index]['item_number']               = $invItem->item_number;
            $itemLines[$index]['item_desc']                 = $invItem->item_desc;
            $itemLines[$index]['organization_id_to']        = '';
            $itemLines[$index]['transaction_type_id_to']    = '';
            $itemLines[$index]['subinventory_to']           = '';
            $itemLines[$index]['locator_id_to']             = '';
            $itemLines[$index]['organization_id_from']      = $transactionItem->organization_id ?? '';
            $itemLines[$index]['transaction_type_id_from']  = '';
            $itemLines[$index]['subinventory_from']         = $transactionItem->subinventory_code ?? '';
            $itemLines[$index]['locator_id_from']           = $transactionItem->locator_id ?? '';
            $itemLines[$index]['locator_code_from']         = $transactionItem->locator_code ?? '';
            $itemLines[$index]['tobacco_type_code']         = $invItem->tobacco_type_code ?? '';
            $itemLines[$index]['tobacco_group_code']        = $invItem->tobacco_group_code ?? '';

            $itemLines[$index]['uom_code']                  = $transactionItem->transaction_uom;
            $itemLines[$index]['transaction_uom']           = $transactionItem->transaction_uom;
            $itemLines[$index]['unit_of_measure']           = $itemUomCode->unit_of_measure;

            $itemLines[$index]['transaction_qty']           = $transactionQty;
            // $itemLines[$index]['transfer_line_id']          = null;
            $itemLines[$index]['lot_number']                = $transactionItem->lot_number;
            $itemLines[$index]['batch_id']                  = '';
            $itemLines[$index]['batch_no']                  = '';

        }

        return $itemLines;

    }

    // public static function getTransferedQty($data) {

    //     $originationDate = $data->origination_date;

    //     $transferedQty = PtpmProductTransferL::whereHas('header', function ($query) use ($originationDate) {
    //                             $query->isTransfered()->whereDate('product_date', $originationDate);
    //                         })
    //                         ->where('inventory_item_id', $data->inventory_item_id)
    //                         ->sum('transaction_qty');

    //     return $transferedQty;

    // }

    public static function findBiweekly($date)
    {
       $findBiweekly = PtBiweeklyV::whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        return $findBiweekly;
    }

    public static function getLocators($organizationId)
    {
        $locators = PtinvLocatorV::select(DB::raw("locator ||' : '|| description as locator_full_desc, inventory_location_id, inventory_location_id as locator_id, locator, description, subinventory_code, organization_code"))
                ->where('organization_id', $organizationId)
                ->where('enabled_flag', 'Y')
                ->get();

        return $locators;
    }

    private static function generateWebBatchNo()
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }
}
