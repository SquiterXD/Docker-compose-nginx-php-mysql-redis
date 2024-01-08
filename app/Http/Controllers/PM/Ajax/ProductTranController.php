<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmProductTransferH;
use App\Models\PM\PtpmProductTransferL;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtinvOnhandQuantitiesV;
use App\Models\PM\MtlLotNumber;
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

class ProductTranController extends Controller
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
                $transferHeader = self::setHeader($transferHeader->transfer_header_id);
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
            if (request()->action == 'get-param') {
                $inventoryItemList[]    = ['value'  => '', 'label'  => 'ท้ังหมด'];
                $transferNumberList[]   = ['value'  => '', 'label'  => 'ท้ังหมด'];
                $transferStatusList[]   = ['value'  => '', 'label'  => 'ท้ังหมด'];

                $transferDateFrom       = request()->transfer_date_from ?? false;
                $transferDateTo         = request()->transfer_date_to ?? false;
                $inventoryItemId        = request()->inventory_item_id ?? false;
                $transferNumber         = request()->transfer_number ?? false;
                $transferStatus         = request()->transfer_status ?? false;
                $organizationId         = session('organization_id');

                $conditions = "and h.organization_id = $organizationId ";
                if ($transferDateFrom && $transferDateFrom != 'Invalid date') {
                    $transferDateFrom = parseFromDateTh($transferDateFrom);
                    $conditions .= "and TRUNC(h.transfer_date) >= to_date('$transferDateFrom', 'YYYY-MM-DD') ";
                }
                if ($transferDateTo && $transferDateTo != 'Invalid date') {
                    $transferDateTo = parseFromDateTh($transferDateTo);
                    $conditions .= "and TRUNC(h.transfer_date) <= to_date('$transferDateTo', 'YYYY-MM-DD') ";
                }
                if ($inventoryItemId) {
                    $conditions .= "and l.inventory_item_id = $inventoryItemId ";
                }
                if ($transferNumber) {
                    $conditions .= "and h.transfer_number = '$transferNumber' ";
                }
                if ($transferStatus) {
                    $conditions .= "and h.transfer_status = $transferStatus ";
                }


                $datas = collect(\DB::select("
                    SELECT
                        distinct
                        h.transfer_date
                        , h.transfer_number
                        , l.inventory_item_id
                        , msi.segment1 || ': ' || msi.description item_number
                        , h.transfer_status
                        , pts.description transfer_status_desc
                    FROM OAPM.PTPM_PRODUCT_TRANSFER_H h
                        , OAPM.PTPM_PRODUCT_TRANSFER_L l
                        , mtl_system_items_b msi
                        , PTPM_TRANSFER_STATUS pts
                    WHERE   1=1
                    and     h.transfer_header_id = l.transfer_header_id
                    and     l.inventory_item_id = msi.inventory_item_id
                    and     h.organization_id = msi.organization_id
                    and     h.transfer_status = pts.lookup_code
                    and     h.program_code = 'PMP0052'
                    $conditions
                    order by h.transfer_date, h.transfer_number
                "));

                if (count($datas)) {
                    foreach ($datas->pluck('item_number', 'inventory_item_id') as $value => $label) {
                        $inventoryItemList[] = ['value'  => $value, 'label'  => $label];
                    }
                    foreach ($datas->pluck('transfer_number', 'transfer_number') as $value => $label) {
                        $transferNumberList[] = ['value'  => $value, 'label'  => $label];
                    }
                    foreach ($datas->pluck('transfer_status_desc', 'transfer_status') as $value => $label) {
                        $transferStatusList[] = ['value'  => $value, 'label'  => $label];
                    }
                }
                $responseResult['inventory_item_list'] = $inventoryItemList;
                $responseResult['transfer_number_list'] = $transferNumberList;
                $responseResult['transfer_status_list'] = $transferStatusList;
                return response()->json(['data' => $responseResult]);
            }

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
                // "transfer_number"           => $transferNumber,
                // "product_date_from"         => $productDateFrom,
                // "product_date_to"           => $productDateTo,
                "transfer_date_from"        => (is_null($transferDateFrom)  || $transferDateFrom == 'Invalid date' ) ? '' : $transferDateFrom,
                "transfer_date_to"          => (is_null($transferDateTo)  || $transferDateTo == 'Invalid date' ) ? '' : $transferDateTo,
                "inventory_item_id"         => request()->inventory_item_id ?? false,
                "transfer_number"           => request()->transfer_number ?? false,
                "transfer_status"           => request()->transfer_status ?? false,
            ];

            $transferHeaders = PtpmProductTransferH::where("program_code", $programCode)
                ->where('organization_id', $organizationId)
                ->with(['status'])
                ->search($searchInputs)
                ->orderBy('transfer_date')
                ->orderBy('transfer_number')
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
                // $transferHeader->transfer_objective     = '';
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
            $transferHeader->attribute1         = now()->weeksInYear();
            $transferHeader->attribute1         = (now()->weekOfYear > 52) ? 52 : now()->weekOfYear;
            // $transferHeader->attribute10        = $toDepartmentCode;
            $transferHeader->attribute11        = $toLocatorId;
            $transferHeader->attribute12        = $toLocatorModel->organization_id;
            $transferHeader->attribute15        = $transObjective;

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

            // $updatedRequestHeader = PtpmProductTransferH::find($transferHeader->transfer_header_id);
            $updatedRequestHeader = self::setHeader($transferHeader->transfer_header_id);
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
            $objectiveCode = $request->objective_code ?? '';

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

            $hasTag = false;
            if ($objectiveCode) {
                $setup = self::getObjectiveCode($objectiveCode, $onlyEnabled = true);
                if (count($setup) && $setup->first()->tag) {
                    $hasTag = true;
                    $mfgDepartment = self::findMfgDepartmentData($objectiveCode);
                    $confirmedInvItems = self::getInvItems($mfgDepartment->to_organization_id, parse_from_date_th($transferDate));
                }
            }

            if (!$hasTag) {
                // ## CASE : M06
                $confirmedInvItems = self::getConfirmedInvItems($organizationId, parse_from_date_th($transferDate));
            }

            if (request()->objective_code == $this->getLetterPlateObjectiveCode()) {
                if (count($confirmedInvItems)) {
                    $confirmedInvItems = collect($confirmedInvItems)->where('convert_flag', 'Y');
                    $confirmedInvItems = collect($confirmedInvItems);
                }
            } else {
                if (count($confirmedInvItems)) {
                    $confirmedInvItems = collect($confirmedInvItems)->where('convert_flag', 'N');
                    $confirmedInvItems = collect($confirmedInvItems);
                }
            }
            if (count($confirmedInvItems)) {
                $confirmedInvItems = array_values($confirmedInvItems->sortBy('item_number')->toArray());
            }
            $transactionItems = self::getTransactionItems($organizationId, parse_from_date_th($transferDate), $objectiveCode, $confirmedInvItems);

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

            // ## CASE : M06

            $transactionLines = self::getTransactionItems($organizationId, parse_from_date_th($transferDate), $transObjective ?? false, $transferInvItemLines);
            if(count($transactionLines) <= 0){
                throw new \Exception("ไม่พบข้อมูลสินค้าสำเร็จรูป วันที่ได้ผลผลิต: {$transferDate}");
            }

            // $preparedInputTransferLines = self::fifoLineItems($transactionLines, $transferInvItemLines);
            $preparedInputTransferLines = self::prepareTransferLines($transactionLines, $transferInvItemLines);

            if($transferHeader) {

                if($transferHeader->transfer_status != "1") {
                    throw new \Exception("ไม่สามารถบันทึกส่งสินค้าสำเร็จรูป ที่ยืนยันแล้วหรือยกเลิกแล้ว");
                }

                // REMOVE OLD TRANSFER LINES
                $transferLines = PtpmProductTransferL::where('transfer_header_id', $transferHeader->transfer_header_id)->get();
                foreach ($transferLines as $transferLine) {
                    $transferLine->delete();
                }

                // ALWAYS CREATE NEW TRANSFER LINES (AFTER REMOVE OLD)
                foreach ($preparedInputTransferLines as $key => $preparedInputTransferLine) {

                    $mfgData = self::getMfgDepartmentData($organizationId, $preparedInputTransferLine);
                    $mfgDepartment = $mfgData->mfg_department;
                    $convertFlag = $mfgData->convert_flag;
                    $fmLocatorModel = (object) [
                        'organization_id' => optional($mfgDepartment)->to_organization_id,
                        'subinventory_code' => optional($mfgDepartment)->to_subinventory,
                        'inventory_location_id' => optional($mfgDepartment)->to_locator_id,
                    ];

                    // if ($convertFlag != 'Y') {
                    $locator =  PtinvLocatorV::where('organization_id', $transferHeader->attribute12)
                                    ->where('inventory_location_id', $transferHeader->attribute11)->first();
                    $fmLocatorModel = (object) [
                        'organization_id' => $locator->organization_id,
                        'subinventory_code' => $locator->subinventory_code,
                        'inventory_location_id' => $locator->inventory_location_id,
                    ];
                    // }

                    $toLocator =  PtinvLocatorV::where('inventory_location_id', $fmLocatorModel->inventory_location_id)->first();
                    $transferLine                           = new PtpmProductTransferL;
                    $transferLine->transfer_header_id       = $transferHeader->transfer_header_id;
                    $transferLine->inventory_item_id        = $preparedInputTransferLine["inventory_item_id"];
                    $transferLine->created_by               = $fndUserId;
                    $transferLine->created_by_id            = $userId;
                    $transferLine->created_at               = $nowDate;
                    $transferLine->creation_date            = $nowDate;
                    $transferLine->program_code             = $programCode;

                    $transferLine->lot_number               = $preparedInputTransferLine["lot_number"];
                    $transferLine->transaction_uom          = $preparedInputTransferLine["transaction_uom"];
                    $transferLine->organization_id_from     = $preparedInputTransferLine["organization_id_from"];
                    $transferLine->subinventory_from        = $preparedInputTransferLine["subinventory_from"];
                    $transferLine->locator_id_from          = $preparedInputTransferLine["locator_id_from"];

                    $transferLine->organization_id_to       = $fmLocatorModel->organization_id ? $fmLocatorModel->organization_id : null;
                    $transferLine->subinventory_to          = $fmLocatorModel->subinventory_code;
                    $transferLine->locator_id_to            = $fmLocatorModel->inventory_location_id;

                    $transferLine->attribute2               = $toLocator->locator;
                    $transferLine->attribute3               = $preparedInputTransferLine["item_number"];
                    $transferLine->attribute4               = $preparedInputTransferLine["item_desc"];
                    $transferLine->attribute5               = $preparedInputTransferLine["unit_of_measure"];
                    $transferLine->attribute6               = $preparedInputTransferLine["tobacco_group_code"];
                    $transferLine->attribute7               = $preparedInputTransferLine["tobacco_type_code"];
                    $transferLine->attribute8               = $preparedInputTransferLine["locator_code_from"];
                    $transferLine->attribute10              = $preparedInputTransferLine["batch_no"];
                    $transferLine->attribute11              = $convertFlag;
                    $transferLine->attribute12              = data_get($preparedInputTransferLine, 'destination_locator_id', null);

                    $transferLine->transaction_qty          = $preparedInputTransferLine["transaction_qty"] ?: 0;
                    $transferLine->biweekly                 = $transferBiweekly->biweekly;

                    $transferLine->web_batch_no             = $transferHeader->web_batch_no;

                    $transferLine->updated_by_id            = $userId;
                    $transferLine->last_updated_by          = $fndUserId;
                    $transferLine->updated_at               = $nowDate;
                    $transferLine->last_update_date         = $nowDate;

                    $transferLine->save();

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

    public function findMfgDepartmentData($ojbectCode = false, $tobaccoGroupCode = false)
    {
        $mfgDepartment = false;
        $organizationId = session('organization_id');
        if ($ojbectCode) {
            $objectiveCodes = \App\Models\PM\FndLookupValue::selectRaw("
                                    LOOKUP_CODE, MEANING, DESCRIPTION, TAG
                                ")
                                ->where('lookup_type', 'PTPM_PMP0052')
                                ->where('enabled_flag','Y')
                                ->where('lookup_code', $ojbectCode)
                                ->orderBy('lookup_code')
                                ->first();
            if (!$objectiveCodes) {
                throw new \Exception("ไม่พบข้อมูล lookup_type : PTPM_PMP0052 ของ lookup_code: $ojbectCode");
            }
            $mfgDepartment = PtpmSetupMfgDepartmentsV::where('wip_transaction_type_name', $objectiveCodes->tag)
                                    ->when($tobaccoGroupCode, function($q) use ($tobaccoGroupCode){
                                            $q->where('tobacco_group_code', $tobaccoGroupCode);
                                        })
                                    ->where('organization_id', $organizationId)
                                    ->first();
        }

        if ($mfgDepartment) {
            return $mfgDepartment;
        }

        $mfgDepartment = PtpmSetupMfgDepartmentsV::wipCompleteType()
                            ->where('organization_id', $organizationId)
                            ->when($tobaccoGroupCode, function($q) use ($tobaccoGroupCode){
                                $q->where('tobacco_group_code', $tobaccoGroupCode);
                            })
                            ->first();
        return $mfgDepartment;
    }

    public function getObjectiveCode($ojbectCode = false, $onlyEnabled = true)
    {
        $objectiveCodes = \App\Models\PM\FndLookupValue::selectRaw("
                                LOOKUP_CODE, MEANING, DESCRIPTION, TAG
                            ")
                            ->where('lookup_type', 'PTPM_PMP0052')
                            ->orderBy('lookup_code');
                            // ->where('lookup_code', $ojbectCode)
                            // ->get();

        if ($onlyEnabled) {
            $objectiveCodes = $objectiveCodes->where('enabled_flag','Y');
        }

        if ($ojbectCode) {
            $objectiveCodes = $objectiveCodes->where('lookup_code', $ojbectCode)->get();
        } else {
            $objectiveCodes = $objectiveCodes->get();
        }
        return $objectiveCodes;
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

        return (object)[
            "mfg_department" => $mfgDepartment,
            "convert_flag" => $convertFlag
        ];

    }

    private static function prepareTransferLines($transactionLines, $transferInvItemLines) {

        $preparedTransferLines = [];

        foreach ($transferInvItemLines as $indexInvItemL => $transferInvItemLine) {

            $confirmTransactionQty = round(floatval($transferInvItemLine["transaction_qty"]), 2);

            $preparedTransferLines[$indexInvItemL] = [];
            foreach ($transactionLines as $transactionLine) {
                if($transferInvItemLine["inventory_item_id"] == $transactionLine["inventory_item_id"] && $transferInvItemLine["lot_number"] == $transactionLine["lot_number"]) {
                    $preparedTransferLines[$indexInvItemL] = $transactionLine;
                }
            }
            $preparedTransferLines[$indexInvItemL]["item_number"] = $transferInvItemLine["item_number"];
            $preparedTransferLines[$indexInvItemL]["inventory_item_id"] = $transferInvItemLine["inventory_item_id"];
            $preparedTransferLines[$indexInvItemL]["confirm_transaction_qty"] = $confirmTransactionQty;
            $preparedTransferLines[$indexInvItemL]["transaction_qty"] = $confirmTransactionQty;

        }

        return $preparedTransferLines;

    }

    // private static function fifoLineItems($transactionLines, $transferInvItemLines) {

    //     $preparedTransferLines = [];

    //     // FIFO PICK ITEM
    //     foreach ($transferInvItemLines as $indexInvItemL => $transferInvItemLine) {

    //         $totalTransactionQty = 0;
    //         $confirmTransactionQty = round(floatval($transferInvItemLine["transaction_qty"]), 2);
    //         $remainTransactionQty = round(floatval($transferInvItemLine["transaction_qty"]), 2);

    //         $preparedTransferLines[$indexInvItemL] = [];
    //         $preparedTransferLines[$indexInvItemL]["inventory_item_id"] = $transferInvItemLine["inventory_item_id"];
    //         // $preparedTransferLines[$indexInvItemL]["marked_as_deleted"] = $transferInvItemLine["marked_as_deleted"];
    //         $preparedTransferLines[$indexInvItemL]["confirm_transaction_qty"] = $confirmTransactionQty;
    //         $preparedTransferLines[$indexInvItemL]["line_items"] = [];


    //         $fIndex = 0;
    //         foreach ($transactionLines as $transactionLine) {

    //             if($transferInvItemLine["inventory_item_id"] == $transactionLine["inventory_item_id"] && $transferInvItemLine["lot_number"] == $transactionLine["lot_number"]) {

    //                 $preparedTransferLines[$indexInvItemL]["line_items"][$fIndex] = json_decode(json_encode($transactionLine), true);
    //                 $transactionQty = round(floatval($transactionLine["transaction_qty"]), 2);
    //                 $totalTransactionQty = $totalTransactionQty + $transactionQty;

    //                 if($transactionQty > $remainTransactionQty) {
    //                     $transactionQty = $remainTransactionQty;
    //                     $remainTransactionQty = 0;
    //                 } else {
    //                     $remainTransactionQty = $remainTransactionQty - $transactionQty;
    //                 }

    //                 $preparedTransferLines[$indexInvItemL]["line_items"][$fIndex]["transaction_qty"] = $transactionQty;

    //                 $fIndex++;

    //             }

    //         }

    //         // VALIDATE : IF NOT FOUND ANY TRANSACTION OF THIS ITEM
    //         if(count($preparedTransferLines[$indexInvItemL]["line_items"]) == 0) {
    //             throw new \Exception("ไม่พบรายการ transaction ของ สินค้าสำเร็จรูป {$transferInvItemLine['item_number']} : {$transferInvItemLine['item_desc']}");
    //         }

    //         // VALIDATE : IF TOTAL_TRANSACTION_QTY IS NOT OVER COMFIRM_QTY
    //         if($confirmTransactionQty > $totalTransactionQty) {
    //             throw new \Exception("จำนวน transaction qty (ptpm_batch_transactions_v) ไม่เพียงพอ ( confirm qty : {$confirmTransactionQty} , transaction qty : {$totalTransactionQty} ) | สินค้าสำเร็จรูป {$transferInvItemLine['item_number']} : {$transferInvItemLine['item_desc']}");
    //         }


    //     }

    //     return $preparedTransferLines;

    // }

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

            $setup = self::getObjectiveCode($inputTransferHeader->attribute15, $onlyEnabled = true);
            if (count($setup) && $setup->first()->tag) {
                $resMainProcess = PtpmPmp0052V::subinvTransfer($pWebBatchNo, $pUsername);
            } else {
                $resMainProcess = PtpmPmp0052V::callMainProcess($pWebBatchNo, $pUsername);
            }

            // ERROR CALL PACKAGE
            if($resMainProcess["status"] == "E") {
                $responseResult["status"]   = "error";
                $responseResult["message"]  = $resMainProcess["message"];
            } else {
                if (count($setup) && $setup->first()->tag) {
                    $profile = getDefaultData();
                    $userId = $profile->fnd_user_id;
                    $fndUserId = $profile->user_id;
                    $nowDate = Carbon::now();

                    $header = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
                    $header->transfer_status    = 2;
                    $header->updated_by_id      = $userId;
                    $header->updated_at         = $nowDate;
                    $header->save();
                }
            }

            DB::commit();

            $updatedRequestHeader = self::setHeader($inputTransferHeader->transfer_header_id);
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

        // DB::beginTransaction();

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

            $setup = self::getObjectiveCode($inputTransferHeader->attribute15, $onlyEnabled = true);
            $pWebBatchNo    = $inputTransferHeader->web_batch_no;
            $pUsername      = auth()->user()->getOAUserName();
            $header = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);

            if (count($setup) && $setup->first()->tag) {
                $header->record_status = null;
                $header->save();
                $preRequestLines = PtpmProductTransferL::where('transfer_header_id', $inputTransferHeader->transfer_header_id)
                                    ->where('interface_status')
                                    ->get();
                foreach ($preRequestLines as $index => $preRequestLine) {
                    $preRequestLine->record_status = null;
                    $preRequestLine->save();
                }
                $resMainProcess = PtpmPmp0052V::cancelSubinvTransfer($pWebBatchNo, $pUsername);

                // ERROR CALL PACKAGE
                if($resMainProcess["status"] == "E") {
                    $responseResult["status"]   = "error";
                    $responseResult["message"]  = $resMainProcess["message"];
                } else {
                    if (count($setup) && $setup->first()->tag) {
                        $header = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
                        $header->transfer_status    = 4;
                        $header->updated_by_id      = $userId;
                        $header->updated_at         = $nowDate;
                        $header->save();
                    }
                }
            } else {
                if ($header->canCancelAfterInf()) {
                    $header = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
                    $header->transfer_status    = 4;
                    $header->export_to_wms_flag = "C";
                    $header->updated_by_id      = $userId;
                    $header->updated_at         = $nowDate;
                    $header->save();

                    $preRequestLines = PtpmProductTransferL::where('transfer_header_id', $inputTransferHeader->transfer_header_id)
                                    ->where('interface_status', 'S')
                                    ->get();
                    foreach ($preRequestLines as $index => $preRequestLine) {
                        $preRequestLine->export_to_wms_flag = "C";
                        $preRequestLine->updated_by_id      = $userId;
                        $preRequestLine->updated_at         = $nowDate;
                        $preRequestLine->save();
                    }
                } else {
                    $responseResult["status"]   = "error";
                    $responseResult["message"]  = "ข้อมูลสถานะบนระบบ WMS ยังไม่ถูกอัพเดท เป็น C ท้ังหมด";
                }

            }

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

            // DB::commit();

            // $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $transferHeader = self::setHeader($inputTransferHeader->transfer_header_id);
            $responseResult['transfer_header'] = $transferHeader ? json_encode($transferHeader) : null;

        } catch (\Exception $e) {

            Log::error($e);

            // DB::rollBack();
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

            // $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $transferHeader = self::setHeader($inputTransferHeader->transfer_header_id);
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

            // $transferHeader = PtpmProductTransferH::find($inputTransferHeader->transfer_header_id);
            $transferHeader = self::setHeader($inputTransferHeader->transfer_header_id);
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

            // ## CASE : M06

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
                ,lot_number
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
                ,'lot_number'
            ])
            ->orderBy("attribute3")
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

    public static function getTransactionItems($organizationId, $transferDate, $objectiveCode = false, $itemList = []) {

        $transferLines = [];
        $transactionItems = collect([]);
        if (count($itemList)) {
            foreach ($itemList as $key => $item) {
                $data = [];
                $itemId = data_get($item, 'inventory_item_id');

                if (data_get($item, 'convert_flag') == 'Y') {
                    $organizationId         = data_get($item, 'destination_organization_id');
                    $locatorId              = data_get($item, 'destination_locator_id');
                    $data = self::findOnhand($organizationId, $locatorId, $transferDate, $exceptLocatorId = [], [$itemId]);
                } else {
                    $mfgDepartment          = self::findMfgDepartmentData($objectiveCode, data_get($item, 'tobacco_group_code', '') ?? '');
                    if ($mfgDepartment) {
                        $organizationId     = $mfgDepartment->from_organization_id;
                        $locatorId          = $mfgDepartment->from_locator_id ?? false;
                        if ($mfgDepartment->isWipCompletion()) {
                            $organizationId = $mfgDepartment->to_organization_id;
                            $locatorId      = $mfgDepartment->to_locator_id ?? false;
                        }
                        // $transactionItems = MtlLotNumber::getListLotNumbers($organizationId)->get();
                        $data               = self::findOnhand($organizationId, $locatorId, $transferDate, $exceptLocatorId = [], [$itemId]);
                        // $transactionItems[] = self::findOnhand($organizationId, $transDate = false, $exceptLocatorId = [], [$itemId]);
                    }
                }

                data_set($data, "*.convert_flag", data_get($item, 'convert_flag'));
                data_set($data, "*.destination_organization_id", data_get($item, 'destination_organization_id'));
                data_set($data, "*.destination_locator_id", data_get($item, 'destination_locator_id'));
                if (count($data)) {
                    $transactionItems = $transactionItems->merge($data);
                }
            }
        }

        if (count($transactionItems)) {
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
            // ->where('item_number', '1701P0053')
            ->orderBy('inventory_item_id')
            ->get();

            $transferLines = self::mapConfirmedInvItemTransferLines($confirmedInvItems);
            if (count($transferLines)) {
                $transferLines = array_values($transferLines);
            }
        }

        return $transferLines;

    }

    public static function getInvItems($toOrganizationId, $transferDate) {
        $organizationCode = session('organization_code');
        $transferLines = [];
        if ($transferDate) {

            $confirmedInvItems = \App\Models\PM\PtinvOnhandQuantitiesV::selectRaw("
                                    organization_id
                                    , to_date('$transferDate', 'YYYY-MM-DD') send_date
                                    , inventory_item_id
                                    , item_number
                                    , item_desc
                                    , primary_uom_code              as uom_code
                                    , NULL                          as destination_organization_id
                                    , NULL                          as destination_locator_id
                                    , 'N'                           as convert_flag
                                    , sum(onhand_quantity)          as confirm_issue_qty
                                ")
                                ->where('organization_id', $toOrganizationId)
                                ->whereNotNUll('onhand_quantity')
                                ->whereRaw(" inventory_item_id in (select product_item_id from ptpm_mfg_formula_v where organization_code = '$organizationCode' group by product_item_id)")
                                ->when($transferDate, function($q) use ($transferDate){
                                    $q->whereRaw("TRUNC(nvl(expiration_date, sysdate)) >= to_date('$transferDate', 'YYYY-MM-DD')");
                                })
                                ->groupByRaw("organization_id, inventory_item_id, item_number, item_desc, primary_uom_code")
                                ->get();

            $transferLines = self::mapConfirmedInvItemTransferLines($confirmedInvItems);
            if (count($transferLines)) {
                $transferLines = array_values($transferLines);
            }
        }

        return $transferLines;

    }

    public static function mapConfirmedInvItemTransferLines($transferInvItems) {

        $itemLines = [];

        foreach($transferInvItems as $index => $transferInvItem) {
            $transferedQty   = self::getTransferedQty($transferInvItem) ?? 0;
            $confirmIssueQty = $transferInvItem->confirm_issue_qty ?? 0;
            if ($transferedQty >= $confirmIssueQty) {
                continue; // next loop
            }
            $confirmIssueQty = $confirmIssueQty - $transferedQty;
            $invItem = $transferInvItem->invItem()->first();
            $itemUomCode = $transferInvItem->uomCode()->first();

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
            $itemLines[$index]['available_confirm_issue_qty']   = $confirmIssueQty;
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

            // $invItem = $transactionItem->invItem()->first();
            // $itemUomCode = $transactionItem->uomCode()->first();
            $invItem = PtpmItemNumberV::where('inventory_item_id', $transactionItem->inventory_item_id)->first();
            $itemUomCode = PtInvUomV::where('uom_code', $transactionItem->transaction_uom)->first();
            $locatorData = PtinvLocatorV::where('inventory_location_id', $transactionItem->locator_id)->first();
            $transactionQty = $transactionItem->transaction_quantity ?? 0;
            $confirmIssueQty = $transactionItem->confirm_issue_qty ?? 0;

            // dd('xx', $transactionItem->transaction_quantity);
            $primaryRatioPerUnit = 1;

            if ($invItem->primary_uom_code != $transactionItem->transaction_uom) {
                $ratioPerUnit = collect(DB::select("
                                    SELECT
                                            (apps.inv_convert.inv_um_convert (
                                                        item_id           => $transactionItem->inventory_item_id,
                                                        organization_id   => $transactionItem->organization_id,
                                                        PRECISION         => NULL,
                                                        from_quantity     => 1,
                                                        from_unit         => '$transactionItem->transaction_uom',
                                                        to_unit           => '$invItem->primary_uom_code',
                                                        from_name         => NULL,
                                                        to_name           => NULL)
                                            ) qty
                                    from dual
                                "))
                                ->first();
                $primaryRatioPerUnit = $ratioPerUnit->qty ?? 0;
            }
            if ((float)$primaryRatioPerUnit <= 0) {
                $primaryRatioPerUnit = 1;
            }

            $itemLines[$index]                              = [];
            $itemLines[$index]['organization_id']           = $transactionItem->organization_id;
            $itemLines[$index]['inventory_item_id']         = $transactionItem->inventory_item_id;
            $itemLines[$index]['item_number']               = $transactionItem->item_number;
            $itemLines[$index]['item_desc']                 = $transactionItem->item_desc;
            $itemLines[$index]['organization_id_to']        = '';
            $itemLines[$index]['transaction_type_id_to']    = '';
            $itemLines[$index]['subinventory_to']           = '';
            $itemLines[$index]['locator_id_to']             = '';
            $itemLines[$index]['organization_id_from']      = $transactionItem->organization_id ?? '';
            $itemLines[$index]['transaction_type_id_from']  = '';
            $itemLines[$index]['subinventory_from']         = $transactionItem->subinventory_code ?? '';
            $itemLines[$index]['locator_id_from']           = $transactionItem->locator_id ?? '';
            // $itemLines[$index]['locator_code_from']         = $transactionItem->locator_code ?? '';
            $itemLines[$index]['locator_code_from']         = $locatorData ? $locatorData->locator : '';
            $itemLines[$index]['tobacco_type_code']         = $invItem->tobacco_type_code ?? '';
            $itemLines[$index]['tobacco_group_code']        = $invItem->tobacco_group_code ?? '';
            $itemLines[$index]['primary_uom_code']          = $invItem->primary_uom_code;
            $itemLines[$index]['primary_ratio_per_unit']    = $primaryRatioPerUnit;

            $itemLines[$index]['uom_code']                  = $transactionItem->transaction_uom;
            $itemLines[$index]['transaction_uom']           = $transactionItem->transaction_uom;
            $itemLines[$index]['unit_of_measure']           = $itemUomCode->unit_of_measure;
            $itemLines[$index]['lot_number_desc']           = $transactionItem->lot_number_desc;

            $itemLines[$index]['confirm_issue_qty']         = $confirmIssueQty;
            $itemLines[$index]['transaction_qty']           = $transactionQty;
            // $itemLines[$index]['transfer_line_id']          = null;
            $itemLines[$index]['lot_number']                = $transactionItem->lot_number;
            $itemLines[$index]['batch_id']                  = '';
            $itemLines[$index]['batch_no']                  = '';

            $itemLines[$index]['convert_flag']              = data_get($transactionItem, 'convert_flag');
            $itemLines[$index]['destination_organization_id'] = data_get($transactionItem, 'destination_organization_id');
            $itemLines[$index]['destination_locator_id']    = data_get($transactionItem, 'destination_locator_id');

        }

        return $itemLines;

    }

    public static function getTransferedQty($data) {

        $originationDate = $data->send_date;
        $transferedQty = PtpmProductTransferL::whereHas('header', function ($query) use ($originationDate) {
                                $query->isTransfered()->whereDate('transfer_date', $originationDate);
                            })
                            ->where('inventory_item_id', $data->inventory_item_id)
                            ->sum('transaction_qty');
        return $transferedQty;

    }

    public static function findBiweekly($date)
    {
       $findBiweekly = PtBiweeklyV::whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        return $findBiweekly;
    }

    public static function getLocators($organizationId, $locatorId = false, $onlyEnabled = true)
    {
        $locators = PtinvLocatorV::select(DB::raw("locator ||' : '|| subinventory_desc ||' : '|| description as locator_full_desc, inventory_location_id, inventory_location_id as locator_id, locator, description, subinventory_code, organization_code"))
                ->where('organization_id', $organizationId)
                ->when($locatorId, function($q) use ($locatorId){
                    $q->where('inventory_location_id', $locatorId);
                })
                ->when($onlyEnabled, function($q) {
                    $q->where('enabled_flag', 'Y');
                })
                ->orderBy('locator')
                ->get();

        return $locators;
    }

    public static function findOnhand($organizationId, $locatorId = false, $transDate = false, $exceptLocatorId = [], $itemList = [])
    {
        $date = \App\Models\PM\PtinvOnhandQuantitiesV::selectRaw("
                    organization_id
                    , organization_code
                    , origination_date            as transaction_date
                    , lot_number
                    , 'lot: ' ||lot_number || '       onhand: ' || sum(onhand_quantity) as lot_number_desc
                    , inventory_item_id
                    , item_desc
                    , subinventory_code
                    , locator_id
                    , sum(onhand_quantity)        as transaction_quantity
                    , primary_uom_code            as transaction_uom
                ")
                ->where('organization_id', $organizationId)
                ->when($locatorId, function($q) use ($locatorId){
                    $q->where('locator_id', $locatorId);
                })
                ->when(count($itemList) > 0, function($q) use ($itemList){
                    $q->whereIn('inventory_item_id', $itemList);
                })
                ->when($transDate, function($q) use ($transDate){
                    $q->whereRaw("TRUNC(nvl(expiration_date, sysdate)) >= to_date('$transDate', 'YYYY-MM-DD')");
                })
                ->groupByRaw("organization_code, organization_id, subinventory_code, locator_id, locator_code, inventory_item_id, item_number, item_desc, lot_number, primary_uom_code, primary_unit_of_measure, origination_date")
                ->orderByRaw("origination_date")
                ->get();
        return $date;
    }

    public static function setHeader($id)
    {
        $data       = PtpmProductTransferH::find($id);
        $obj        = self::getObjectiveCode($data->attribute15, $onlyEnabled = false);
        $toLocator  = self::getLocators($data->attribute12, $data->attribute11, $onlyEnabled = false);

        $data->obj_desc = optional(optional($obj)->first())->description ?? '';
        $data->to_locator_desc = optional(optional($toLocator)->first())->locator_full_desc ?? '';
        $data->can_cancel_after_inf = $data->canCancelAfterInf();

        return $data;
    }

    public static function getLetterPlateObjectiveCode() {
        return '40';
    }

    private static function generateWebBatchNo()
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }
}
