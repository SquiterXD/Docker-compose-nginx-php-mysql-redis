<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EAM\WorkOrderHT;
use App\Models\EAM\WorkOrderHV;
use App\Models\EAM\WorkOrderHVReport;
use App\Models\EAM\WorkOrderHTInterface;
use App\Models\EAM\WorkOrderOpT;
use App\Models\EAM\WorkOrderOpV;
use App\Models\EAM\WorkOrderReV;
use App\Models\EAM\WorkRequestImage;
use App\Http\Requests\EAM\StoreWorkOrderRequest;
use App\Models\EAM\CloseJPV;
use App\Models\EAM\WorkOrderOpTInterface;
use App\Models\EAM\WorkOrderUncloseInterface;
use App\Models\EAM\WorkOrderReT;
use App\Models\EAM\WorkOrderReTInterface;

use App\Models\EAM\WorkOrderMtV;
use App\Models\EAM\WorkOrderMtDirectV;
use App\Models\EAM\WorkOrderMtT;
use App\Models\EAM\WorkOrderMtDirectT;
use App\Models\EAM\WorkOrderMtTInterface;
use App\Models\EAM\WorkOrderMtDirectTInterface;
use App\Models\EAM\WorkOrderMtDirectTPrInterface;
use App\Models\EAM\WorkOrderMtUsedInterface;
use App\Models\EAM\WorkOrderMtReturnInterface;
use App\Models\EAM\WorkOrderMtrT;

use App\Models\EAM\WorkOrderLbV;
use App\Models\EAM\WorkOrderLbT;
use App\Models\EAM\WorkOrderLbInterface;
use App\Models\EAM\WorkOrderLbSubmitInterface;
use App\Models\EAM\WorkOrderLbCancelInterface;

use App\Models\EAM\WorkOrderCpV;
use App\Models\EAM\WorkOrderCpT;
use App\Models\EAM\WorkOrderCpTInterface;
use App\Models\EAM\WorkOrderCostV;
use App\Models\EAM\PayableMntV;
use App\Models\EAM\ClosedWoJpV;
use App\Models\EAM\MntHistoryV;
use App\Models\EAM\MaintenanceV;
use App\Models\EAM\PurchaseV;
use App\Models\EAM\JobAccountV;
use App\Models\EAM\LaborAccountV;
use App\Models\EAM\WoCostV;

use App\Models\EAM\LaborV;
use App\Models\EAM\SummaryLaborV;

use App\Models\EAM\ReceiptMatV;
use App\Models\EAM\LOV\WipClass;
use App\Models\EAM\LOV\WorkReceiptStatus;
use App\Models\EAM\ItemCostV;
use App\Models\EAM\LOV\ItemOnHand;

use App\Models\EAM\LOV\Departments;

use App\Models\EAM\WorkOrderReMaterialV;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class WorkOrderController extends Controller
{
    private $limit = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function headSearch(Request $request)
    {
        try {
            $limit  = $request->p_limit ??  $this->limit;
            $result = (new WorkOrderHV())->search($request->all(), $limit);
            $result->map(function ($item, $key) {
                $item->actual_start_date = parseToDateTh($item->actual_start_date, 'H:i:s');
                $item->actual_end_date = parseToDateTh($item->actual_end_date, 'H:i:s');
            });
            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function closeAndUncompleteWorkOrder(Request $request)
    {
        try {
            $data = $request->data;
            $status = $request->status;
            $jpData = $request->jp_data;
            $programCode = $request->program_code;
            $workOrder = new WorkOrderHT;
            $result = $workOrder->closeAndUncomplete($status, $data, $jpData, $programCode);
            return response()->json(['message' => $result['message']], $result['code']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function waitingConfirm(Request $request)
    {
        try {
            $limit  = $request->p_limit ??  $this->limit;
            $result = (new WorkOrderHV())->waitingConfirm($limit);
            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function headShow($workRequestNumber)
    {
        $datas = WorkOrderHV::where('wip_entity_name', $workRequestNumber)
                            ->leftJoin('pteam_asset_number_v', 'pteam_work_order_h_v.asset_number', '=', 'pteam_asset_number_v.asset_number')
                            ->select('pteam_work_order_h_v.*', 'pteam_asset_number_v.department')
                            ->first();

        if($datas == null){
            $datas = WorkOrderHV::where('wip_entity_id', $workRequestNumber)
                                ->leftJoin('pteam_asset_number_v', 'pteam_work_order_h_v.asset_number', '=', 'pteam_asset_number_v.asset_number')
                                ->select('pteam_work_order_h_v.*', 'pteam_asset_number_v.department')
                                ->first();
        }

        if (isset($datas->wo_reference)) {
            $datas->wo_reference_name = $datas->wo_reference . ':' . WorkReceiptStatus::getName($datas->wo_reference);
        } else {
            $datas->wo_reference_name = '';
        }

        return response()->json(['data' => $datas]);
        // return back()->with('workrequest',$workRequest);
    }

    public function opAll($wipEntityId)
    {
        $datas = WorkOrderOpV::where('wip_entity_id', $wipEntityId)
            ->select('pteam_work_order_op_v.*', 'pteam_departments_v.department_code')
            ->leftJoin('pteam_departments_v', 'pteam_work_order_op_v.department_description', '=', 'pteam_departments_v.description')
            ->orderBy('wip_entity_id')
            ->orderBy('operation_seq_num')
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function reAll($wipEntityId)
    {
        $datas = WorkOrderReV::where('wip_entity_id', $wipEntityId)
            ->select('pteam_work_order_re_v.*', 'pteam_departments_v.description as department_desc', 'pteam_resource_v.description as resource_desc')
            ->leftJoin('pteam_departments_v', 'pteam_work_order_re_v.department_code', '=', 'pteam_departments_v.department_code')
            ->leftJoin('pteam_resource_v', 'pteam_work_order_re_v.resource_id', '=', 'pteam_resource_v.resource_id')
            ->orderBy('operation_seq_num')
            ->orderBy('resource_seq_num')
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function mtAll($wipEntityId)
    {
        $datas = WorkOrderMtV::where('wip_entity_id', $wipEntityId)->get();
        return response()->json(['data' => $datas]);
    }

    public function mtDirectAll($wipEntityId)
    {

        $datas = WorkOrderMtDirectV::where('wip_entity_id', $wipEntityId)->get();
        return response()->json(['data' => $datas]);
    }

    public function lbAll($wipEntityId)
    {
        $datas = WorkOrderLbV::where('wip_entity_id', $wipEntityId)
            ->select('pteam_work_order_lb_v.*', 'pteam_resource_v.description as resource_desc')
            ->whereRaw(" (attribute2 != 'N' or attribute2 is null)")
            ->leftJoin('pteam_resource_v', 'pteam_work_order_lb_v.resource_code', '=', 'pteam_resource_v.resource_code')
            ->orderBy('line_num')
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function cpAll($wipEntityId)
    {
        $datas = WorkOrderCpV::where('wip_entity_id', $wipEntityId)
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function costAll($wipEntityId)
    {
        $datas = WorkOrderCostV::where('wip_entity_id', $wipEntityId)
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function getItemCost(StoreWorkOrderRequest $request)
    {
        $itemCode = $request->p_item_code ?? '';
        $datas = ItemCostV::where('item_code', $itemCode)->first();
        return response()->json(['data' => $datas]);
    }

    public function getItemOnhand(StoreWorkOrderRequest $request)
    {
        $subinventoryName = $request->p_subinventory_name ?? '';
        $locatorName = $request->p_locator_name ?? '';
        $itemCode = $request->p_item_code ?? '';
        $query = ItemOnHand::select('*');
        if ($subinventoryName != '') {
            $query = $query->where('subinventory_name', 'like', $subinventoryName);
        }
        if ($locatorName != '') {
            $query = $query->where('locator_name', 'like', $locatorName);
        }
        if ($itemCode != '') {
            $query = $query->where('item_code', 'like', $itemCode);
        }
        $datas = $query->get();
        return response()->json(['data' => $datas]);
    }

    public function defaultWipClass(Request $request)
    {
        $departmentCode = (isset($request->department_code)) ? $request->department_code : '%';
        $data = WipClass::where('department', 'like', $departmentCode)
            ->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function headStore(StoreWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $newData = WorkOrderHT::saveData($request->all(), $userId, $fndUserId, $fndUserId);
            $interface = $this->interfaceH($newData['web_batch_no']);

            if ($interface['status'] == 'E') {
                DB::rollback();
                $code = 400;
            } else {
                DB::commit();
                $code = 200;
            }
            
            $response = WorkOrderHT::where('web_batch_no', $newData['web_batch_no'])->first();

            if (isset($response->wo_reference)) {
                $response->wo_reference_name = $response->wo_reference . ':' . WorkReceiptStatus::getName($response->wo_reference);
            } else {
                $response->wo_reference_name = '';
            }

            return response()->json(
                [
                    'code' => $code,
                    'data' => $response,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function headUnclose(StoreWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $newData = WorkOrderHT::uncloseHead($request->all(), $userId, $fndUserId, $fndUserId);
            $interface = $this->interfaceUnclose($newData['web_batch_no']);
            if ($interface['status'] == 'E') {
                DB::rollback();
                $code = 400;
            } else {
                DB::commit();
                $code = 200;
            }
            $response = WorkOrderHT::where('web_batch_no', $newData['web_batch_no'])->first();

            if (isset($response->wo_reference)) {
                $response->wo_reference_name = $response->wo_reference . ':' . WorkReceiptStatus::getName($response->wo_reference);
            } else {
                $response->wo_reference_name = '';
            }

            return response()->json(
                [
                    'code' => $code,
                    'data' => $response,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function opStore(StoreWorkOrderRequest $request)
    {
        try {
            $result = [];
            foreach ($request["data"] as $value) {
                $newDataBatch = WorkOrderOpT::saveData($value);
                $interface = $this->interfaceOp($newDataBatch);
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                } else {
                    $code = 200;
                }
                array_push($result, WorkOrderOpV::where('wip_entity_id', $value["wip_entity_id"])->where('operation_seq_num', $value["operation_seq_num"])->first());
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function reStore(StoreWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            foreach ($request["data"] as $value) {
                $newData = WorkOrderReT::saveData($value, $userId, $fndUserId);
                $interface = $this->interfaceRe($newData->web_batch_no);
                if ($interface['status'] == 'E') {
                    DB::rollback();
                    $code = 400;
                    break;
                } else {
                    DB::commit();
                    $code = 200;
                }
                array_push(
                    $result,
                    WorkOrderReV::where('wip_entity_id', $value["wip_entity_id"])
                        ->where('operation_seq_num', $value["operation_seq_num"])
                        ->where('resource_seq_num', $value["resource_seq_num"])
                        ->first()
                );
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function mtStore(StoreWorkOrderRequest $request)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            $count = 0;
            $data = [];
            foreach ($request["data"] as $value) {
                $value["created_at"] = now();
                $value["created_by"] = $userId;
                $value["created_by_id"] = $fndUserId;
                $value["last_updated_by"] = $userId;
                $value["web_status"] = 'UPDATE';

                array_push($data, $value);
            }
            //debug
            $batchNst = '';

            foreach ($data as $key => $value) {
                $count++;
                $newData = WorkOrderMtT::saveData($value, $userId, $fndUserId, $count);
                $interface = $this->interfaceMt($newData->web_batch_no);
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                } else {
                    $code = 200;
                }
            }
            return response()->json(
                [
                    'code' => $code,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function mtDirectStore(StoreWorkOrderRequest $request)
    {
        try {
            $userId     = optional(auth()->user())->user_id ?? -1;
            $fndUserId  = optional(auth()->user())->fnd_user_id ?? -1;
            $result     = [];
            $count      = 0;
            $data       = [];
            $webBatchNo = WorkOrderMtDirectT::getWebBatchNo();
            foreach ($request["data"] as $value) {
                $value["created_at"] = now();
                $value["created_by"] = $userId;
                $value["created_by_id"] = $fndUserId;
                $value["last_updated_by"] = $userId;
                $value["web_batch_no"] =  $webBatchNo;
                $value["web_status"] = 'UPDATE';

                array_push($data, $value);
            }
            
            $batchNst = '';

            foreach ($data as $key => $value) {
                $count++;
                $newData = WorkOrderMtDirectT::saveData($value, $userId, $fndUserId, $count);
            }

            $interface = $this->interfaceMtDirect($webBatchNo);
            if ($interface['status'] == 'E') {
                $code = 400;
            } else {
                $code = 200;
            }

            return response()->json(
                [
                    'code' => $code,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function mtIssue(StoreWorkOrderRequest $request)
    {
        foreach ($request["data"] as $value) {
            $data = WorkOrderMtT::where('wip_entity_id', $value['wip_entity_id'])
                                ->where('operation_seq_num', $value['operation_seq_num'])
                                ->where('material_id', $value['material_id'])
                                ->first();
            $dataV = WorkOrderMtV::where('material_id', $value['wip_entity_id'] . $value['operation_seq_num'] . $value['inventory_item_id'])
                                ->first();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

            if (!empty($dataV)) {
                if (!empty($data)) {
                    $value['updated_by']        = $fndUserId;
                    $value['updated_by_id']     = $userId;
                    $value['ready_issue_flag']  = 'Y';
                    $value['wms_issue']         = $value['wms_issue'] == 'null' ? 'No' : $value['wms_issue'];
                    $value['web_status']        = 'UPDATE';
                    $value['lot_number']        = $dataV['lot_number'];
                    $value['web_batch_no']      = WorkOrderMtT::getWebBatchNo();
                    $newData                    = WorkOrderMtT::updateTableT($data, $value, $userId, $fndUserId);
                    $batchNo                    = $newData->web_batch_no;
                    $organizationId             = $newData->organization_id;
                } else {
                    $value['updated_by']        = $fndUserId;
                    $value['updated_by_id']     = $userId;
                    $value['created_by']        = $fndUserId;
                    $value['created_by_id']     = $userId;
                    $value['material_id']       = null;
                    $value['wms_issue']         = $value['wms_issue'] == 'null' ? 'No' : $value['wms_issue'];
                    $value['web_status']        = 'UPDATE';
                    $value['lot_number']        = $dataV['lot_number'];
                    $newData                    = WorkOrderMtT::createTableT($value, $userId, $fndUserId);
                    $batchNo                    = $newData->web_batch_no;
                    $organizationId             = $newData->organization_id;
                }
                $interface  = $this->interfaceMtUsed($batchNo, $organizationId, $value['wip_entity_id'], $value['operation_seq_num'], $value['inventory_item_id']);
                $message    = $interface['message'];
                if ($interface['status'] == 'E') {
                    DB::rollback();
                    $code = 400;
                    break;
                } else {
                    DB::commit();
                    $code = 200;
                }
            } else {
                $code = 400;
                $message = "MATERIAL_ID not found in PTEAM_WORK_ORDER_MT_V";
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function mtReturn(StoreWorkOrderRequest $request)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            foreach ($request["data"] as $value) {
                if($value['quantity_return'] != null){
                    $newData = WorkOrderMtrT::saveData($value, $userId, $fndUserId);
                    $interface = $this->interfaceMtReturn($newData->web_batch_no, 
                                                        $newData->organization_id, 
                                                        $value['wip_entity_id'], 
                                                        $value['operation_seq_num'], 
                                                        $value['inventory_item_id'],
                                                        $newData->lot_no);
                    if ($interface['status'] == 'E') {
                        $code = 400;
                        break;
                    } else {
                        $code = 200;
                    }
                    $result = WorkOrderMtrT::where('web_batch_no', $newData->web_batch_no)->first();
                }                
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function lbStore(StoreWorkOrderRequest $request)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId =  optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            $lineNum = 0;
            foreach ($request["data"] as $value) {
                $lineNum++;
                $value['line_num'] = $lineNum;
                $value['attribute1'] = "1";
                $value['attribute2'] = "Y";
                $newData = WorkOrderLbT::saveData($value, $userId, $fndUserId);
                $interface = $this->interfaceLb($newData->web_batch_no);
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                } else {
                    $code = 200;
                }
                $result = WorkOrderLbT::where('web_batch_no', $newData->web_batch_no)->first();
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $interface['message'],
                    'old' => $request->all()
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function lbSubmit(StoreWorkOrderRequest $request)
    {
        try {
            $profile    = getDefaultData();
            $result     = [];
            $lineNum    = 0;
            $batchNo    = WorkOrderLbT::getWebBatchNo();
            foreach ($request["data"] as $value) {
                $lineNum++;
                $value['line_num']      = $lineNum;
                $value['attribute1']    = "1";
                $value['attribute2']    = "Y";
                $newData                = WorkOrderLbT::submitData($value, $profile->user_id, $profile->fnd_user_id, $batchNo);
                $message                = null;                
            }

            $interfaceStore = $this->interfaceLb($batchNo);
            $interfaceSubmit = $this->interfaceSubmitLb($batchNo);

            if ($interfaceStore['status'] == 'E') {
                $code = 400;
                $message = $interfaceStore['message'];
            } else {
                $code = 200;
            }

            if ($interfaceSubmit['status'] == 'E') {
                $code = 400;
                $message = $interfaceSubmit['message'];
            } else {
                $code = 200;
            }

            $result = WorkOrderLbT::where('web_batch_no', $batchNo)->first();
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $message
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function lbCancel(StoreWorkOrderRequest $request)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId =  optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            $lineNum = 0;
            foreach ($request["data"] as $value) {
                $lineNum++;
                $value['line_num'] = $lineNum;
                $value['attribute1'] = "1";
                $value['attribute2'] = "Y";
                $batchNo = WorkOrderLbT::getWebBatchNo();
                $newData = WorkOrderLbT::submitData($value, $userId, $fndUserId, $batchNo);
                $interfaceStore = $this->interfaceLb($newData->web_batch_no);
                $interfaceCancel = $this->interfaceCancelLb($newData->web_batch_no, $newData->or_transaction_id, $newData->wip_entity_name);
                $message = null;
                if ($interfaceStore['status'] == 'E') {
                    $code = 400;
                    $message = $interfaceStore['message'];
                    break;
                } else {
                    $code = 200;
                }
                if ($interfaceCancel['status'] == 'E') {
                    $code = 400;
                    $message = $interfaceCancel['message'];
                    break;
                } else {
                    $code = 200;
                }
                $result = WorkOrderLbT::where('web_batch_no', $newData->web_batch_no)->first();
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $message
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function cpStore(StoreWorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = optional(auth()->user())->user_id ?? -1;
            $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
            $result = [];
            foreach ($request["data"] as $value) {
                $newData = WorkOrderCpT::saveData($value, $userId, $fndUserId);
                $interface = $this->interfaceCp($newData->web_batch_no);
                if ($interface['status'] == 'E') {
                    DB::rollback();
                    $code = 400;
                    break;
                } else {
                    DB::commit();
                    $code = 200;
                }
                $result = WorkOrderCpT::where('web_batch_no', $newData->web_batch_no)->first();
            }
            return response()->json(
                [
                    'code' => $code,
                    'data' => $result,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $data = $request->all();
            $data['updated_by'] = $userId;
            $data['updated_by_id'] = $userId;

            $workRequest = WorkRequest::find($id);
            $workRequest->update($data);

            $workRequest->web_batch_no = WorkRequest::getWebBatchNo();
            $workRequest->save();

            return $workRequest;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function headDelete(StoreWorkOrderRequest $request)
    {
        $dataToDel = WorkOrderHT::where('wip_entity_name', $request['wip_entity_name'])->first();
        if (!empty($dataToDel)) {
            $dataToDel->delete();
        }
        return response()->json(['message' => 'Success.', 'code' => 200]);;
    }

    public function opDelete(StoreWorkOrderRequest $request)
    {
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderOpT::where('wip_entity_id', $value['wip_entity_id'])
                ->where('operation_seq_num', $value['operation_seq_num'])
                ->first();
            if (!empty($dataToDel)) {

                $head = WorkOrderHV::where('wip_entity_id', $value['wip_entity_id'])
                    ->first();
                $data1 = WorkOrderReV::where('wip_entity_id', $value['wip_entity_id'])
                    ->where('operation_seq_num', $value['operation_seq_num'])
                    ->first();
                $data2 = WorkOrderMtV::where('wip_entity_id', $value['wip_entity_id'])
                    ->where('operation_seq_num', $value['operation_seq_num'])
                    ->first();

                $can_delete = array("1", "3", "17");
                if (empty($data1) && empty($data2) && in_array($head['status_type'], $can_delete)) {
                    $newWebBatch = WorkOrderOpT::deleteData($value);
                    $interface = $this->interfaceOp($newWebBatch);
                    $message = $interface['message'];
                    if ($interface['status'] == 'E') {
                        DB::rollback();
                        $code = 400;
                        break;
                    } else {
                        DB::commit();
                        $code = 200;
                    }
                } else {
                    $code = 400;
                    $message = 'workorder status not in ("1", "3", "17")';
                }
            } else {
                $code = 400;
                $message = 'no data found';
            }
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message
            ],
            $code
        );
    }

    public function reDelete(StoreWorkOrderRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderReT::where('wip_entity_id', $value['wip_entity_id'])
                ->where('operation_seq_num', $value['operation_seq_num'])
                ->where('resource_seq_num', $value['resource_seq_num'])
                ->first();
            if (!empty($dataToDel)) {
                $head = WorkOrderHV::where('wip_entity_id', $value['wip_entity_id'])
                    ->first();
                $data1 = WorkOrderLbV::where('wip_entity_id', $value['wip_entity_id'])
                    ->where('operation_seq_num', $value['operation_seq_num'])
                    ->where('resource_seq_num', $value['resource_seq_num'])
                    ->first();
                $can_delete = array("1", "3", "17");
                if (empty($data1) && in_array($head['status_type'], $can_delete)) {
                    $newDataWebBatch = WorkOrderReT::deleteData($value, $userId, $fndUserId);
                    $interface = $this->interfaceRe($newDataWebBatch);
                    $message = $interface['message'];
                    if ($interface['status'] == 'E') {
                        DB::rollback();
                        $code = 400;
                        break;
                    } else {
                        DB::commit();
                        $code = 200;
                    }
                } else {
                    $code = 400;
                    $message = 'workorder status not in ("1", "3", "17")';
                }
            } else {
                $code = 400;
                $message = 'no data found';
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function mtDelete(StoreWorkOrderRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderMtV::where('material_id', $value['material_id'])
                                    ->first();
            if (!empty($dataToDel)) {
                $head = WorkOrderHV::where('wip_entity_id', $value['wip_entity_id'])
                                    ->first();
                $can_delete = array("1", "3", "17");
                if (in_array($head['status_type'], $can_delete)) {
                    $newDataWebBatch = WorkOrderMtT::deleteData($value, $userId, $fndUserId);
                    $interface = $this->interfaceMt($newDataWebBatch);
                    $message = $interface['message'];
                    if ($interface['status'] == 'E') {
                        $code = 400;
                        break;
                    } else {
                        $code = 200;
                    }
                } else {
                    $code = 400;
                    $message = 'workorder status not in ("1", "3", "17")';
                }
            } else {
                $code = 400;
                $message = 'no data found';
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function mtDirectDelete(StoreWorkOrderRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderMtDirectV::where('material_id', $value['material_id'])
                ->first();
            if (!empty($dataToDel)) {
                $head = WorkOrderHV::where('wip_entity_id', $value['wip_entity_id'])
                    ->first();
                $can_delete = array("1", "3", "17");
                if (in_array($head['status_type'], $can_delete) && is_null($dataToDel->pr_number)) {
                    $newDataWebBatch = WorkOrderMtDirectT::deleteData($value, $userId, $fndUserId);
                    $interface = $this->interfaceMtDirect($newDataWebBatch);
                    $message = $interface['message'];
                    if ($interface['status'] == 'E') {
                        $code = 400;
                        break;
                    } else {
                        $code = 200;
                    }
                } else {
                    $code = 400;
                    $message = 'workorder status not in ("1", "3", "17")';
                }
            } else {
                $code = 400;
                $message = 'no data found';
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function mtDirectDeletePr(StoreWorkOrderRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderMtDirectV::where('material_id', $value['material_id'])
                ->first();
            if (!empty($dataToDel)) {
                $newDataWebBatch = WorkOrderMtDirectT::deleteData($value, $userId, $fndUserId);
                $interface = $this->interfaceMtDirectPr($newDataWebBatch, $dataToDel->wip_entity_id, $dataToDel->pr_number);
                $message = $interface['message'];
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                } else {
                    $code = 200;
                }
            } else {
                $code = 400;
                $message = 'no data found';
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function lbDelete(StoreWorkOrderRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId =  optional(auth()->user())->fnd_user_id ?? -1;
        foreach ($request["data"] as $value) {
            $dataToDel = WorkOrderLbT::where('or_transaction_id', $value['or_transaction_id'])
                ->first();
            if (!empty($dataToDel)) {
                $head = WorkOrderHV::where('wip_entity_id', $value['wip_entity_id'])
                    ->first();
                $can_delete = array("1", "3", "17");
                if (in_array($head['status_type'], $can_delete)) {

                    $value['attribute1'] = "1";
                    $value['attribute2'] = "N";
                    $value['cancel_flag'] = "Y";
                    $value['web_status'] = "DELETE";
                    $savedDeletedData = WorkOrderLbT::saveDataDelete($value, $userId, $fndUserId);

                    // $value['or_transaction_id']  = null;// ยกขั้นตอนนี้ออก
                    // $value['attribute1'] = "2";
                    // $value['web_status'] = 'CREATE';
                    // $newData          = WorkOrderLbT::saveDataDeleteForDuplicate($value,$userId,$fndUserId);

                    $interface = $this->interfaceLb($savedDeletedData->web_batch_no);
                    $message = $interface['message'];
                    if ($interface['status'] == 'E') {
                        $code = 400;
                        break;
                    } else {
                        $code = 200;
                    }
                    // $interface = $this->interfaceLb($newData->web_batch_no);
                    // $message = $interface['message'];
                    // if ($interface['status'] == 'E') {
                    //     $code = 400;
                    //     break;
                    // } else {
                    //     $code = 200;
                    // }
                } else {
                    $code = 400;
                    $message = 'workorder status not in ("1", "3", "17")';
                    break;
                }
            } else {
                $code = 400;
                $message = 'no data found';
                break;
            }
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    public function report(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $scheduledStartDate = parseFromDateTh($request->p_scheduled_start_date) ?? null;
        $scheduledStartDateTo = parseFromDateTh($request->p_scheduled_start_date_to) ?? $scheduledStartDate;
        $areaCode = trim($request->p_area_code ?? '%');
        $areaCodeTo = trim($request->p_area_code_to ?? '%');
        $assetNumber = trim($request->p_asset_number ?? '%');
        $statusDesc = trim($request->p_status_desc ?? '%');
        $owningDeptCode = trim($request->p_owning_department_code ?? '%');
        $owningDeptDesc = trim($request->p_owning_department_desc ?? '%');
        if ($wipEntityName != '%') {
            $data = WorkOrderHVReport::selectRaw("
                pteam_work_order_h_v.*,
                pteam_work_req_v.creation_date as work_req_creation_date,
                PTEAM_ASSET_NUMBER_V.area_code,
                PTEAM_ASSET_NUMBER_V.parent,
                pteam_work_req_v.employee_code as work_req_employee_code,
                pteam_work_req_v.employee_desc as work_req_employee_desc,
                PTEAM_WIP_CLASS_V.class_code as wip_class_code,
                PTEAM_WIP_CLASS_V.description as wip_class_description,
                PTEAM_WORK_ORDER_COST_V.actual_total_cost,
                PTEAM_WORK_ORDER_CP_V.actual_duration,
                (SELECT PNPS_TITLE || PNPS_PSNL_NAME || ' ' || PNPS_PSNL_SURNAME || ',' || POS_NAME || PNDP_DIVISION_NAME FROM PERSONAL_DEPT_LOCATION WHERE DEPT_CD_F02 = pteam_work_order_h_v.OWNING_DEPARTMENT_CODE AND POS_NAME = 'หัวหน้ากอง' AND PNPS_RESIGN_DATE IS NULL) as pnps
            ")
                ->leftJoin('pteam_work_req_v', 'pteam_work_order_h_v.work_request_number', '=', 'pteam_work_req_v.work_request_number')
                ->leftJoin('PTEAM_ASSET_NUMBER_V', 'pteam_work_order_h_v.asset_number', '=', 'PTEAM_ASSET_NUMBER_V.asset_number')
                ->leftJoin('PTEAM_WIP_CLASS_V', 'pteam_work_order_h_v.class_code', '=', 'PTEAM_WIP_CLASS_V.class_code')
                ->leftJoin('PTEAM_WORK_ORDER_COST_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_COST_V.wip_entity_id')
                ->leftJoin('PTEAM_WORK_ORDER_CP_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_CP_V.wip_entity_id')
                ->whereBetween('wip_entity_name', [$wipEntityName, $wipEntityNameTo])
                ->get();
        } else {
            $query = WorkOrderHVReport::selectRaw("
                pteam_work_order_h_v.*,
                pteam_work_req_v.creation_date as work_req_creation_date,
                PTEAM_ASSET_NUMBER_V.area_code,
                PTEAM_ASSET_NUMBER_V.parent,
                pteam_work_req_v.employee_code as work_req_employee_code,
                pteam_work_req_v.employee_desc as work_req_employee_desc,
                PTEAM_WIP_CLASS_V.description as wip_class_description,
                PTEAM_WORK_ORDER_COST_V.actual_total_cost,
                PTEAM_WORK_ORDER_CP_V.actual_duration,
                (SELECT PNPS_TITLE || PNPS_PSNL_NAME || ' ' || PNPS_PSNL_SURNAME || ',' || POS_NAME || PNDP_DIVISION_NAME FROM PERSONAL_DEPT_LOCATION WHERE DEPT_CD_F02 = pteam_work_order_h_v.OWNING_DEPARTMENT_CODE AND POS_NAME = 'หัวหน้ากอง' AND PNPS_RESIGN_DATE IS NULL) as pnps
            ")
                ->leftJoin('pteam_work_req_v', 'pteam_work_order_h_v.work_request_number', '=', 'pteam_work_req_v.work_request_number')
                ->leftJoin('PTEAM_ASSET_NUMBER_V', 'pteam_work_order_h_v.asset_number', '=', 'PTEAM_ASSET_NUMBER_V.asset_number')
                ->leftJoin('PTEAM_WIP_CLASS_V', 'pteam_work_order_h_v.class_code', '=', 'PTEAM_WIP_CLASS_V.class_code')
                ->leftJoin('PTEAM_WORK_ORDER_COST_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_COST_V.wip_entity_id')
                ->leftJoin('PTEAM_WORK_ORDER_CP_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_CP_V.wip_entity_id');
            if ($scheduledStartDate != null) {
                $query = $query->whereRaw(" trunc(pteam_work_order_h_v.scheduled_start_date) >= '{$scheduledStartDate}' ");
            }
            if ($scheduledStartDateTo != null) {
                $query = $query->whereRaw(" trunc(pteam_work_order_h_v.scheduled_start_date) <= '{$scheduledStartDateTo}' ");
            }
            if ($areaCode != '%' && $areaCodeTo  != '%') {
                $query = $query->whereBetween('PTEAM_ASSET_NUMBER_V.area_code', [$areaCode, $areaCodeTo]);
            }
            $query = $query->where('pteam_work_order_h_v.asset_number', 'like', $assetNumber)
                ->where('pteam_work_order_h_v.status_desc', 'like', $statusDesc)
                ->where('pteam_work_order_h_v.owning_department_code', 'like', $owningDeptCode)
                ->where('pteam_work_order_h_v.owning_department_desc', 'like', $owningDeptDesc)
                ->orderBy('pteam_work_order_h_v.wip_entity_name');
            $data =  $query->get();
        }

        $itemImages = array();
        foreach ($data as $item) {
            $images = WorkRequestImage::index($item->work_request_id);
            if (isset($images)) {
                if (count($images)) {
                    $itemImages[$item->wip_entity_id] = $images;
                } else {
                    $obj = new \stdClass;
                    $obj->items[] = (object)["file_name" => ""];
                    $itemImages[$item->wip_entity_id] = $obj;
                }
            }
        }

        $newImages = array();
        foreach ($itemImages as $key1 => $items) {
            $indexArr = 0;
            $indexImages = 0;
            foreach ($items as $item) {
                $newImages[$key1][$indexArr][] = $item;
                if (($indexImages % 2) == 1) {
                    $indexArr++;
                }
                $indexImages++;
            }
        }

        $newData = array();
        foreach ($newImages as $key1 => $newImage) {
            foreach ($newImage as $key2 => $itemImage) {
                foreach ($data as $key3 => $dataItem) {
                    if ($key1 == $dataItem->wip_entity_id) {
                        $dataItem->reference_work_order = WorkOrderHVReport::select('work_request_number', 'employee_code', 'employee_desc')->where('wip_entity_name', $dataItem->wo_reference)->first();
                        if (isset($dataItem->reference_work_order)) {
                            $dataItem->reference_work_request = DB::table('pteam_work_req_v')->select('employee_code', 'employee_desc')->where('work_request_number', $dataItem->reference_work_order->work_request_number)->first();
                        }
                        $newData[] = array("data" => $dataItem, "images" => $itemImage);
                    }
                }
            }
        }
        
        $pdf = \PDF::loadView('eam.exports.pdf-eam0019', ['workOrders' => $newData])
                    ->setPaper('a4')
                    ->setOption('margin-top', '0.5cm')
                    ->setOption('margin-bottom', '0.5cm')
                    ->setOption('margin-left', '0.7cm')
                    ->setOption('margin-right', '0.7cm')
                    ->setOption('encoding', 'utf-8');

        return $pdf->inline();
    }
    public function interfaceOp($batchNo)
    {
        $result = (new WorkOrderOpTInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceUnclose($batchNo)
    {
        $result = (new WorkOrderUncloseInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceRe($batchNo)
    {
        $result = (new WorkOrderReTInterface)->Import($batchNo);
        return $result;
    }

    public function reportSummaryMonth(Request $request)
    {
        $params = $request->all();
        $service = new WorkOrderHVReport();
        $pdf = $service->reportMonth($params);
        return $pdf;
    }

    public function exportSummaryMonth(Request $request)
    {
        $params = $request->all();
        $service = new WorkOrderHVReport();
        $pdf = $service->reportMonthExcel($params);
        return $pdf;
    }
    public function reportPart(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $scheduledStartDate = parseFromDateTh($request->p_scheduled_start_date) ?? null;
        $scheduledStartDateTo = parseFromDateTh($request->p_scheduled_start_date_to) ?? $scheduledStartDate;
        $areaCode = trim($request->p_area_code ?? '%');
        $areaCodeTo = trim($request->p_area_code_to ?? '%');
        $assetNumber = trim($request->p_asset_number ?? '%');
        $statusDesc = trim($request->p_status_desc ?? '%');
        $owningDeptCode = trim($request->p_owning_department_code ?? '%');
        $owningDeptDesc = trim($request->p_owning_department_desc ?? '%');
        if ($wipEntityName != '%') {
            $data = WorkOrderHVReport::selectRaw("
                pteam_work_order_h_v.*,
                pteam_work_req_v.creation_date as work_req_creation_date,
                pteam_work_req_v.jp_qty,
                PTEAM_ASSET_NUMBER_V.area_code,
                PTEAM_ASSET_NUMBER_V.parent,
                PTEAM_ASSET_NUMBER_V.part_number,
                PTEAM_ASSET_NUMBER_V.part_number_old,
                PTEAM_ASSET_NUMBER_V.old_item_number,
                PTEAM_ASSET_NUMBER_V.machine_01,
                PTEAM_ASSET_NUMBER_V.primary_unit_of_measure,
                pteam_work_req_v.employee_code as work_req_employee_code,
                pteam_work_req_v.employee_desc as work_req_employee_desc,
                PTEAM_WIP_CLASS_V.description as wip_class_description,
                PTEAM_WORK_ORDER_COST_V.actual_total_cost,
                PTEAM_WORK_ORDER_CP_V.actual_duration,
                (SELECT PNPS_TITLE || PNPS_PSNL_NAME || ' ' || PNPS_PSNL_SURNAME || ',' || POS_NAME || PNDP_DIVISION_NAME FROM PERSONAL_DEPT_LOCATION WHERE DEPT_CD_F02 = pteam_work_order_h_v.OWNING_DEPARTMENT_CODE AND POS_NAME = 'หัวหน้ากอง' AND PNPS_RESIGN_DATE IS NULL) as pnps
            ")
                ->leftJoin('pteam_work_req_v', 'pteam_work_order_h_v.work_request_number', '=', 'pteam_work_req_v.work_request_number')
                ->leftJoin('PTEAM_ASSET_NUMBER_V', 'pteam_work_order_h_v.asset_number', '=', 'PTEAM_ASSET_NUMBER_V.asset_number')
                ->leftJoin('PTEAM_WIP_CLASS_V', 'pteam_work_order_h_v.class_code', '=', 'PTEAM_WIP_CLASS_V.class_code')
                ->leftJoin('PTEAM_WORK_ORDER_COST_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_COST_V.wip_entity_id')
                ->leftJoin('PTEAM_WORK_ORDER_CP_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_CP_V.wip_entity_id')
                ->whereBetween('pteam_work_order_h_v.wip_entity_name', [$wipEntityName, $wipEntityNameTo])
                ->get();
        } else {
            $query = WorkOrderHVReport::selectRaw("
                pteam_work_order_h_v.*,
                pteam_work_req_v.creation_date as work_req_creation_date,
                pteam_work_req_v.jp_qty,
                PTEAM_ASSET_NUMBER_V.area_code,
                PTEAM_ASSET_NUMBER_V.parent,
                PTEAM_ASSET_NUMBER_V.part_number,
                PTEAM_ASSET_NUMBER_V.part_number_old,
                PTEAM_ASSET_NUMBER_V.old_item_number,
                PTEAM_ASSET_NUMBER_V.machine_01,
                PTEAM_ASSET_NUMBER_V.primary_unit_of_measure,
                pteam_work_req_v.employee_code as work_req_employee_code,
                pteam_work_req_v.employee_desc as work_req_employee_desc,
                PTEAM_WIP_CLASS_V.description as wip_class_description,
                PTEAM_WORK_ORDER_COST_V.actual_total_cost,
                PTEAM_WORK_ORDER_CP_V.actual_duration,
                (SELECT PNPS_TITLE || PNPS_PSNL_NAME || ' ' || PNPS_PSNL_SURNAME || ',' || POS_NAME || PNDP_DIVISION_NAME FROM PERSONAL_DEPT_LOCATION WHERE DEPT_CD_F02 = pteam_work_order_h_v.OWNING_DEPARTMENT_CODE AND POS_NAME = 'หัวหน้ากอง' AND PNPS_RESIGN_DATE IS NULL) as pnps
            ")
                ->leftJoin('pteam_work_req_v', 'pteam_work_order_h_v.work_request_number', '=', 'pteam_work_req_v.work_request_number')
                ->leftJoin('PTEAM_ASSET_NUMBER_V', 'pteam_work_order_h_v.asset_number', '=', 'PTEAM_ASSET_NUMBER_V.asset_number')
                ->leftJoin('PTEAM_WIP_CLASS_V', 'pteam_work_order_h_v.class_code', '=', 'PTEAM_WIP_CLASS_V.class_code')
                ->leftJoin('PTEAM_WORK_ORDER_COST_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_COST_V.wip_entity_id')
                ->leftJoin('PTEAM_WORK_ORDER_CP_V', 'pteam_work_order_h_v.wip_entity_id', '=', 'PTEAM_WORK_ORDER_CP_V.wip_entity_id');
            if ($scheduledStartDate != null) {
                $query = $query->whereRaw(" trunc(pteam_work_order_h_v.scheduled_start_date) >= '{$scheduledStartDate}' ");
            }
            if ($scheduledStartDateTo != null) {
                $query = $query->whereRaw(" trunc(pteam_work_order_h_v.scheduled_start_date) <= '{$scheduledStartDateTo}' ");
            }
            if ($areaCode != '%' && $areaCodeTo  != '%') {
                $query = $query->whereBetween('PTEAM_ASSET_NUMBER_V.area_code', [$areaCode, $areaCodeTo]);
            }
            $query = $query->where('pteam_work_order_h_v.asset_number', 'like', $assetNumber)
                ->where('pteam_work_order_h_v.status_desc', 'like', $statusDesc)
                ->where('pteam_work_order_h_v.owning_department_code', 'like', $owningDeptCode)
                ->where('pteam_work_order_h_v.owning_department_desc', 'like', $owningDeptDesc)
                ->orderBy('pteam_work_order_h_v.wip_entity_name');
            $data = $query->get();
        }
        $itemImages = array();
        foreach ($data as $item) {
            $images = WorkRequestImage::index($item->work_request_id);
            // $item->images = $images;
            if (isset($images)) {
                if (count($images)) {
                    $itemImages[$item->wip_entity_id] = $images;
                } else {
                    $obj = new \stdClass;
                    $obj->items[] = (object)["file_name" => ""];
                    $itemImages[$item->wip_entity_id] = $obj;
                }
            }
        }
        $newImages = array();
        foreach ($itemImages as $key1 => $items) {
            $indexArr = 0;
            $indexImages = 0;
            foreach ($items as $item) {
                $newImages[$key1][$indexArr][] = $item;
                if (($indexImages % 2) == 1) {
                    $indexArr++;
                }
                $indexImages++;
            }
        }

        $newData = array();
        foreach ($newImages as $key1 => $newImage) {
            foreach ($newImage as $key2 => $itemImage) {
                foreach ($data as $key3 => $dataItem) {
                    if ($key1 == $dataItem->wip_entity_id) {
                        $dataItem->reference_work_order = WorkOrderHVReport::select('work_request_number', 'employee_code', 'employee_desc')->where('wip_entity_name', $dataItem->wo_reference)->first();
                        if (isset($dataItem->reference_work_order)) {
                            $dataItem->reference_work_request = DB::table('pteam_work_req_v')->select('employee_code', 'employee_desc')->where('work_request_number', $dataItem->reference_work_order->work_request_number)->first();
                        }
                        // $dataItem->images = $itemImage;
                        // $newData[] = $dataItem;
                        $newData[] = array("data" => $dataItem, "images" => $itemImage);
                    }
                }
            }
        }
        // foreach ($newData as $item1) {
        //     dump($item1["images"]);
        // }
        // dump($newData);
        /*$newImages = [];
        foreach ($itemImages as $items) {
            $indexArr = 0;
            $indexImages = 0;
            foreach ($items as $item) {
                $newImages[$indexArr][] = $item;
                if (($indexImages % 2) == 1) {
                    $indexArr++;
                }
                $indexImages++;
            }
        }
        $newData = [];
        foreach ($newImages as $itemImage) {
            foreach ($data as $itemData) {
                $itemData->reference_work_order = WorkOrderHVReport::select('work_request_number', 'employee_code', 'employee_desc')->where('wip_entity_name', $itemData->wo_reference)->first();
                if (isset($itemData->reference_work_order)) {
                    $itemData->reference_work_request = DB::table('pteam_work_req_v')->select('employee_code', 'employee_desc')->where('work_request_number', $itemData->reference_work_order->work_request_number)->first();
                }
                $newData[] = $itemData;
            }
        }*/
        // dd($newData);
        // $pdf = \PDF::loadView('eam.exports.pdf-eam0020', ['workOrders' => $data])
        // $pdf = \PDF::loadView('eam.exports.pdf-eam0020', ['workOrders' => $newData, 'newImages' => $newImages])
        $pdf = \PDF::loadView('eam.exports.pdf-eam0020', ['workOrders' => $newData])
            ->setPaper('a4')
            ->setOption('margin-top', '0.5cm')
            ->setOption('margin-bottom', '0.5cm')
            ->setOption('margin-left', '0.7cm')
            ->setOption('margin-right', '0.7cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->inline();
    }

    public function reportPayable(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $date = parseFromDateTh($request->p_date) ?? null;
        $dateTo = parseFromDateTh($request->p_date_to) ?? $date;

        $workOrderType = trim($request->p_work_order_type ?? '%');

        $query = PayableMntV::select('pteam_payable_mnt_v.*');
        if ($wipEntityName != '%') {
            $query = $query->whereBetween('pteam_payable_mnt_v.h1_work_order', [$wipEntityName, $wipEntityNameTo]);
        }
        if ($date != null) {
            $query = $query->whereRaw(" trunc(pteam_payable_mnt_v.h1_date) >= '{$date}' ");
        }
        if ($dateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_payable_mnt_v.h1_date) <= '{$dateTo}' ");
        }
        $query = $query->whereRaw("to_char(pteam_payable_mnt_v.work_order_type) like '{$workOrderType}'");
        $data = $query->orderByRaw(' h1_invoice_number , h1_work_order ')->get();

        $costs = ['total' => 0];
        foreach ($data as $value) {
            $costs['total'] = $costs['total'] + $value->h1_current_cost;
        }

        $date = [
            'from' => Carbon::parse($date)->format('d-M-y'),
            'to' => Carbon::parse($dateTo)->format('d-M-y'),
            'now' => Carbon::now()->format('d-M-y H:i:s')
        ];

        $pdf = \PDF::loadView('eam.exports.work-order-payable-mnt.body', ['workOrders' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-payable-mnt.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportCloseWoJp(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $assetGroupDesc = trim($request->p_asset_group_desc ?? '%');
        $assetNumber = trim($request->p_asset_number ?? '%');
        $scheduledStartDate = parseFromDateTh($request->p_scheduled_start_date) ?? null;
        $scheduledStartDateTo = parseFromDateTh($request->p_scheduled_start_date_to) ?? $scheduledStartDate;
        $actualStartDate = parseFromDateTh($request->p_actual_start_date) ?? null;
        $actualStartDateTo = parseFromDateTh($request->p_actual_start_date_to) ?? $actualStartDate;
        $scheduledCompletetionDate = parseFromDateTh($request->p_scheduled_completion_date) ?? null;
        $scheduledCompletetionDateTo = parseFromDateTh($request->p_scheduled_completion_date_to) ?? $scheduledCompletetionDate;
        $actualEndDate = parseFromDateTh($request->p_actual_end_date) ?? null;
        $actualEndDateTo = parseFromDateTh($request->p_actual_end_date_to) ?? $actualEndDate;

        $owningDeptCode = trim($request->p_owning_department_code ?? '%');

        $query = ClosedWoJpV::selectRaw("wip_entity_name, creation_date,work_request_number, closed_emp,owning_department_code,owning_department_desc,asset_number, asset_desc, order_qty, produce_qty, description, unit_cost, actual_labor_cost, actual_material_cost, actual_total_cost
        , NVL(SUBSTR(wip_entity_name, 0, INSTR(wip_entity_name, '-')-1), wip_entity_name) AS wip_entity_name_pre
        , NVL(SUBSTR(wip_entity_name, INSTR(wip_entity_name, '-')+1 ), wip_entity_name) AS wip_entity_name_post ")
            ->groupByRaw('wip_entity_name, creation_date, work_request_number, closed_emp, owning_department_code, owning_department_desc, asset_number, asset_desc, order_qty, produce_qty, description, unit_cost, actual_labor_cost, actual_material_cost, actual_total_cost');

        if ($wipEntityName != '%') {
            $query = $query->whereBetween('pteam_closed_wo_jp_v.wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        }
        if ($scheduledStartDate != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.scheduled_start_date) >= '{$scheduledStartDate}' ");
        }
        if ($scheduledStartDateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.scheduled_start_date) <= '{$scheduledStartDateTo}' ");
        }
        if ($actualStartDate != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.actual_start_date) >= '{$actualStartDate}' ");
        }
        if ($actualStartDateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.actual_start_date) <= '{$actualStartDateTo}' ");
        }
        if ($scheduledCompletetionDate != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.scheduled_completion_date) >= '{$scheduledCompletetionDate}' ");
        }
        if ($scheduledCompletetionDateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.scheduled_completion_date) <= '{$scheduledCompletetionDateTo}' ");
        }
        if ($actualEndDate != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.actual_end_date) >= '{$actualEndDate}' ");
        }
        if ($actualEndDateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_closed_wo_jp_v.actual_end_date) <= '{$actualEndDateTo}' ");
        }

        $query = $query->whereRaw(" pteam_closed_wo_jp_v.owning_department_code like '{$owningDeptCode}'")
            ->whereRaw(" pteam_closed_wo_jp_v.asset_group_desc like '{$assetGroupDesc}'")
            ->whereRaw(" pteam_closed_wo_jp_v.asset_number like '{$assetNumber}'");
        $data = $query->orderByRaw('to_number(wip_entity_name_pre)  asc')
            ->orderByRaw('to_number(wip_entity_name_post)  asc')
            ->get();

        $wip_entity_name = '';
        foreach ($data as $item) {
            $wip_entity_name = $item->wip_entity_name;
            $items = ClosedWoJpV::where('pteam_closed_wo_jp_v.wip_entity_name', '=', $wip_entity_name)->get();
            $item->items = $items;
        }
        $pdf = \PDF::loadView('eam.exports.pdf-close-wo-jp', ['workOrders' => $data])
            ->setPaper('a4')
            ->setOption('margin-top', '0.5cm')
            ->setOption('margin-bottom', '0.5cm')
            ->setOption('margin-left', '0.7cm')
            ->setOption('margin-right', '0.7cm')
            ->setOption('encoding', 'utf-8');

        return $pdf->inline();
    }

    public function reportMntHistory(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? '%');
        $assetNumber = trim($request->p_asset_number ?? '%');
        $assetNumberTo = trim($request->p_asset_number_to ?? '%');
        $activityNumber = trim($request->p_activity_number ?? '%');
        $activityNumberTo = trim($request->p_activity_number_to ?? '%');
        $statusDesc = trim($request->p_status_desc ?? '%');
        $departmentCode = trim($request->p_department_code ?? '%');
        $owningDepartmentCode = trim($request->p_owning_department_desc ?? '%');
        $transactionDate = parseFromDateTh($request->p_transaction_date) ?? null;
        $transactionDateTo = parseFromDateTh($request->p_transaction_date_to) ?? $transactionDate;

        $workRequestNumber = trim($request->p_work_request_number ?? '%');
        $workRequestNumberTo = trim($request->p_work_request_number_to ?? '%');
        $employeeCode = trim($request->p_employee_code ?? '%');

        //get separate owning_department_code
        $query = MntHistoryV::select('pteam_mnt_history_v.owning_department_code', 'pteam_mnt_history_v.owning_department_desc')
            ->groupByRaw('owning_department_code, pteam_mnt_history_v.owning_department_desc');
        if ($wipEntityName != '%' && $wipEntityNameTo  != '%') {
            $query = $query->whereBetween('pteam_mnt_history_v.wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        } else if ($wipEntityName != '%' && $wipEntityNameTo  == '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.wip_entity_name = '{$wipEntityName}'");
        } else if ($wipEntityName == '%' && $wipEntityNameTo  != '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.wip_entity_name = '{$wipEntityNameTo}'");
        }
        if ($assetNumber != '%' && $assetNumberTo  != '%') {
            $query = $query->whereBetween('pteam_mnt_history_v.wasset_number', [$assetNumber, $assetNumberTo]);
        } else if ($assetNumber != '%' && $assetNumberTo  == '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.wasset_number = '{$assetNumber}'");
        } else if ($assetNumber == '%' && $assetNumberTo  != '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.wasset_number = '{$assetNumberTo}'");
        }
        if ($activityNumber != '%' && $activityNumberTo  != '%') {
            $query = $query->whereBetween('pteam_mnt_history_v.item_number', [$activityNumber, $activityNumberTo]);
        } else if ($activityNumber != '%' && $activityNumberTo  == '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.item_number = '{$activityNumber}'");
        } else if ($activityNumber == '%' && $activityNumberTo  != '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.item_number = '{$activityNumberTo}'");
        }
        if ($workRequestNumber != '%' && $workRequestNumberTo  != '%') {
            $query = $query->whereBetween('pteam_mnt_history_v.work_request_number', [$workRequestNumber, $workRequestNumberTo]);
        } else if ($workRequestNumber != '%' && $workRequestNumberTo  == '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.work_request_number = '{$workRequestNumber}'");
        } else if ($workRequestNumber == '%' && $workRequestNumberTo  != '%') {
            $query = $query->whereRaw("pteam_mnt_history_v.work_request_number = '{$workRequestNumberTo}'");
        }
        if ($transactionDate != null) {
            $query = $query->whereRaw(" trunc(pteam_mnt_history_v.transaction_date) >= '{$transactionDate}' ");
        }
        if ($transactionDateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_mnt_history_v.transaction_date) <= '{$transactionDateTo}' ");
        }
        $query = $query->whereRaw("to_char(pteam_mnt_history_v.status_desc) like '{$statusDesc}'");
        $query = $query->whereRaw("to_char(pteam_mnt_history_v.department_code) like '{$departmentCode}'");
        $query = $query->whereRaw("to_char(pteam_mnt_history_v.owning_department_code) like '{$owningDepartmentCode}'");
        $query = $query->whereRaw("to_char(pteam_mnt_history_v.employee_code) like '{$employeeCode}'");
        $data = $query->orderBy('owning_department_code', 'ASC')->get();
        //end get separate owning_department_code

        //get each owning_department_code items

        foreach ($data as $item) {
            $query = MntHistoryV::where('pteam_mnt_history_v.owning_department_code', '=', $item->owning_department_code);
            if ($wipEntityName != '%' && $wipEntityNameTo  != '%') {
                $query = $query->whereBetween('pteam_mnt_history_v.wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
            } else if ($wipEntityName != '%' && $wipEntityNameTo  == '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.wip_entity_name = '{$wipEntityName}'");
            } else if ($wipEntityName == '%' && $wipEntityNameTo  != '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.wip_entity_name = '{$wipEntityNameTo}'");
            }
            if ($assetNumber != '%' && $assetNumberTo  != '%') {
                $query = $query->whereBetween('pteam_mnt_history_v.wasset_number', [$assetNumber, $assetNumberTo]);
            } else if ($assetNumber != '%' && $assetNumberTo  == '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.wasset_number = '{$assetNumber}'");
            } else if ($assetNumber == '%' && $assetNumberTo  != '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.wasset_number = '{$assetNumberTo}'");
            }
            if ($activityNumber != '%' && $activityNumberTo  != '%') {
                $query = $query->whereBetween('pteam_mnt_history_v.item_number', [$activityNumber, $activityNumberTo]);
            } else if ($activityNumber != '%' && $activityNumberTo  == '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.item_number = '{$activityNumber}'");
            } else if ($activityNumber == '%' && $activityNumberTo  != '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.item_number = '{$activityNumberTo}'");
            }
            if ($workRequestNumber != '%' && $workRequestNumberTo  != '%') {
                $query = $query->whereBetween('pteam_mnt_history_v.work_request_number', [$workRequestNumber, $workRequestNumberTo]);
            } else if ($workRequestNumber != '%' && $workRequestNumberTo  == '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.work_request_number = '{$workRequestNumber}'");
            } else if ($workRequestNumber == '%' && $workRequestNumberTo  != '%') {
                $query = $query->whereRaw("pteam_mnt_history_v.work_request_number = '{$workRequestNumberTo}'");
            }
            if ($transactionDate != null) {
                $query = $query->whereRaw(" trunc(pteam_mnt_history_v.transaction_date) >= to_date('{$transactionDate}') ");
            }
            if ($transactionDateTo != null) {
                $query = $query->whereRaw(" trunc(pteam_mnt_history_v.transaction_date) <= to_date('{$transactionDateTo}') ");
            }
            $query = $query->whereRaw("to_char(pteam_mnt_history_v.status_desc) like '{$statusDesc}'");
            $query = $query->whereRaw("to_char(pteam_mnt_history_v.department_code) like '{$departmentCode}'");
            $query = $query->whereRaw("to_char(pteam_mnt_history_v.owning_department_code) like '{$owningDepartmentCode}'");
            $query = $query->whereRaw("to_char(pteam_mnt_history_v.employee_code) like '{$employeeCode}'");

            $items = $query->get();
            $item->items = $items;
        }
        //
        $costs = [
            'sumAllMaterial' => 0,
            'sumAllLabor' => 0,
            'sumAllTotal' => 0
        ];
        $lastOwningDepCode = '';
        $sumAllMaterial = 0;
        $sumAllLabor = 0;
        $sumAllTotal = 0;
        foreach ($data as $department) {
            $sumDepMaterial = 0;
            $sumDepLabor = 0;
            $sumDepTotal = 0;
            foreach ($department->items as $value) {
                //sum for own dep
                $sumDepMaterial = $sumDepMaterial + $value->actual_material_cost;
                $sumDepLabor = $sumDepLabor + $value->actual_labor_cost;
                $sumDepTotal = $sumDepTotal + $value->actual_total_cost;

                //sum for all dep
                $sumAllMaterial = $sumAllMaterial + $value->actual_material_cost;
                $sumAllLabor = $sumAllLabor + $value->actual_labor_cost;
                $sumAllTotal = $sumAllTotal + $value->actual_total_cost;
            }
            //put sum for own dep
            $department->sumDepMaterial = $sumDepMaterial;
            $department->sumDepLabor = $sumDepLabor;
            $department->sumDepTotal = $sumDepTotal;
        }
        //put sum for all dep
        $costs = [
            'sumAllMaterial' => $sumAllMaterial,
            'sumAllLabor' => $sumAllLabor,
            'sumAllTotal' => $sumAllTotal
        ];
        $date = [
            'now' => Carbon::now()->format('d-M-y H:i:s')
        ];
        $pdf = \PDF::loadView('eam.exports.work-order-mnt-history.body', ['departments' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-mnt-history.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportMaintenance(Request $request)
    {
        $params = $request->all();
        $service = new MaintenanceV();
        $pdf = $service->reportMaintenanceVExcel($params);
        return $pdf;
    }

    public function reportPurchase(Request $request)
    {
        $params = $request->all();
        $service = new PurchaseV();
        $pdf = $service->reportPurchaseVExcel($params);
        return $pdf;
    }

    public function reportJobAccount(Request $request)
    {
        $wipEntityName      = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo    = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $period             = trim($request->p_period ?? '%');
        $query              = JobAccountV::select('pteam_job_account_v.*');

        if ($wipEntityName != '%') {
            $query = $query->whereBetween('pteam_job_account_v.p_wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        }
        if ($period != '%') {
            $query = $query->whereRaw("to_char(pteam_job_account_v.p_period_name) like '{$period}'");
        }
        $data = $query->get();

        $costs = [
            'sum1Current'       => 0,
            'sum2Extend'        => 0,
            'sum3TotalCost'     => 0,
            'sum4Remittance'    => 0,
            'sum5ActualTotal'   => 0
        ];

        foreach ($data as $value) {
            $costs['sum1Current']       = $costs['sum1Current'] + $value->h1_current_cost_06;
            $costs['sum2Extend']        = $costs['sum2Extend'] + $value->h1_extend_cost_07;
            $costs['sum3TotalCost']     = $costs['sum3TotalCost'] + $value->h1_total_cost_08;
            $costs['sum4Remittance']    = $costs['sum4Remittance'] + $value->h1_remittance_cost_09;
            $costs['sum5ActualTotal']   = $costs['sum5ActualTotal'] + $value->h1_sum_actual_total_cost_10;
        }
        $headers = [
            'start' => $data[0]->schedule_close_date ?? null,
            'close' => $data[0]->schedule_close_date ?? null
        ];
        $date = [
            'now'       => Carbon::now()->format('d-M-y H:i:s'),
            'period'    => $period
        ];

        $pdf = \PDF::loadView('eam.exports.work-order-job-account.body', 
                                [   'workOrders'    => $data, 
                                    'costs'         => $costs, 
                                    'headers'       => $headers]
                            )
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOptions([
                        'margin-top' => '2cm',
                        'margin-bottom' => '0.5cm',
                        'margin-left' => '0.7cm',
                        'margin-right' => '0.7cm',
                        'encoding' => 'utf-8',
                        'header-html' => view('eam.exports.work-order-job-account.header', ['date' => $date])
                    ]);
        return $pdf->inline();
    }

    public function reportLaborAccount(Request $request)
    {
        $wipEntityName      = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo    = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $period             = trim($request->p_period ?? null);

        $query = LaborAccountV::select('pteam_labor_account_v.*');
        if ($wipEntityName != '%') {
            $query = $query->whereBetween('pteam_labor_account_v.p_wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        }
        if ($period != null) {
            $query = $query->whereRaw("to_char(pteam_labor_account_v.p_period_name) like '{$period}'");
        }
        $data = $query->get();

        $costs = [
            'sumDebit'      => 0,
            'sumCredit'     => 0,
            'totalLabor'    => 0
        ];

        foreach ($data as $value) {
            $costs['sumDebit']      = $costs['sumDebit'] + $value->h1_debit;
            $costs['sumCredit']     = $costs['sumCredit'] + $value->h1_credit;
            $costs['totalLabor']    = $costs['totalLabor'] + $value->sum_labor ?? 0;
        }

        $date = [
            'now' => Carbon::now()->format('d-M-y H:i:s'),
            'period' => $period
        ];

        $pdf = \PDF::loadView('eam.exports.work-order-labor-account.body', ['workOrders' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-labor-account.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportWoCost(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? null);
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? null);
        $assetNumber = trim($request->p_asset_number ?? null);
        $assetNumberTo = trim($request->p_asset_number_to ?? null);
        $workRequestNumber = trim($request->p_work_request_number ?? null);
        $workRequestNumberTo = trim($request->p_work_request_number_to ?? null);

        $assignedDepartmentCode = trim($request->p_assigned_department ?? null);
        $owningDepartmentCode = trim($request->p_owning_department ?? null);

        $sumActualTotalCost = trim($request->p_h1_sum_actual_total_cost ?? null);
        $classCode = trim($request->p_class_code ?? null);

        $period = trim($request->p_h1_period_name ?? null);

        //get separate owning_department_code
        $query = WoCostV::select('pteam_wo_cost_v.h1_owning_depart_desc')
            ->groupByRaw('h1_owning_depart_desc');
        if ($wipEntityName != null && $wipEntityNameTo  != null) {
            $query = $query->whereBetween('pteam_wo_cost_v.p_wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        } else if ($wipEntityName != null && $wipEntityNameTo  == null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_wip_entity_name = '{$wipEntityName}'");
        } else if ($wipEntityName == null && $wipEntityNameTo  != null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_wip_entity_name = '{$wipEntityNameTo}'");
        }
        if ($assetNumber != null && $assetNumberTo  != null) {
            $query = $query->whereBetween('pteam_wo_cost_v.p_asset_number', [$assetNumber, $assetNumberTo]);
        } else if ($assetNumber != null && $assetNumberTo  == null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_asset_number = '{$assetNumber}'");
        } else if ($assetNumber == null && $assetNumberTo  != null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_asset_number = '{$assetNumberTo}'");
        }
        if ($workRequestNumber != null && $workRequestNumberTo  != null) {
            $query = $query->whereBetween('pteam_wo_cost_v.p_work_request_number', [$workRequestNumber, $workRequestNumberTo]);
        } else if ($workRequestNumber != null && $workRequestNumberTo  == null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_work_request_number = '{$workRequestNumber}'");
        } else if ($workRequestNumber == null && $workRequestNumberTo  != null) {
            $query = $query->whereRaw("pteam_wo_cost_v.p_work_request_number = '{$workRequestNumberTo}'");
        }

        if ($assignedDepartmentCode != null) {
            $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_assigned_department) like '{$assignedDepartmentCode}'");
        }
        if ($owningDepartmentCode != null) {
            $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_owning_department) like '{$owningDepartmentCode}'");
        }
        if ($classCode != null) {
            $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_class_code) like '{$classCode}'");
        }
        if ($period != null) {
            $query = $query->whereRaw("to_char(pteam_wo_cost_v.h1_period_name) like '{$period}'");
        }
        if ($sumActualTotalCost != null) {
            $query = $query->whereRaw("pteam_wo_cost_v.h1_sum_actual_total_cost > {$sumActualTotalCost}");
        }

        $data = $query->orderBy('h1_owning_depart_desc', 'ASC')->get();

        // for test
        // $data = $query->orderBy('owning_department_code', 'ASC')->toSql();
        // return $data;

        //end get separate owning_department_code

        //get each owning_department_code items

        $sumAllMaterial = [
            'estimated' => 0,
            'actual' => 0,
            'variance' => 0
        ];
        $sumAllLabor = [
            'estimated' => 0,
            'actual' => 0,
            'variance' => 0
        ];
        $sumAllTotal = [
            'estimated' => 0,
            'actual' => 0,
            'variance' => 0
        ];

        foreach ($data as $item) {
            $query = WoCostV::where('pteam_wo_cost_v.h1_owning_depart_desc', '=', $item->h1_owning_depart_desc);
            if ($wipEntityName != null && $wipEntityNameTo  != null) {
                $query = $query->whereBetween('pteam_wo_cost_v.p_wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
            } else if ($wipEntityName != null && $wipEntityNameTo  == null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_wip_entity_name = '{$wipEntityName}'");
            } else if ($wipEntityName == null && $wipEntityNameTo  != null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_wip_entity_name = '{$wipEntityNameTo}'");
            }
            if ($assetNumber != null && $assetNumberTo  != null) {
                $query = $query->whereBetween('pteam_wo_cost_v.p_asset_number', [$assetNumber, $assetNumberTo]);
            } else if ($assetNumber != null && $assetNumberTo  == null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_asset_number = '{$assetNumber}'");
            } else if ($assetNumber == null && $assetNumberTo  != null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_asset_number = '{$assetNumberTo}'");
            }
            if ($workRequestNumber != null && $workRequestNumberTo  != null) {
                $query = $query->whereBetween('pteam_wo_cost_v.p_work_request_number', [$workRequestNumber, $workRequestNumberTo]);
            } else if ($workRequestNumber != null && $workRequestNumberTo  == null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_work_request_number = '{$workRequestNumber}'");
            } else if ($workRequestNumber == null && $workRequestNumberTo  != null) {
                $query = $query->whereRaw("pteam_wo_cost_v.p_work_request_number = '{$workRequestNumberTo}'");
            }

            if ($assignedDepartmentCode != null) {
                $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_assigned_department) like '{$assignedDepartmentCode}'");
            }
            if ($owningDepartmentCode != null) {
                $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_owning_department) like '{$owningDepartmentCode}'");
            }
            if ($classCode != null) {
                $query = $query->whereRaw("to_char(pteam_wo_cost_v.p_class_code) like '{$classCode}'");
            }
            if ($period != null) {
                $query = $query->whereRaw("to_char(pteam_wo_cost_v.h1_period_name) like '{$period}'");
            }
            if ($sumActualTotalCost != null) {
                $query = $query->whereRaw("pteam_wo_cost_v.h1_sum_actual_total_cost > {$sumActualTotalCost}");
            }

            //get data for table
            $items = $query->get();
            $item->items = $items;

            // process sum of same dep
            $sumDepMaterial = [
                'estimated' => 0,
                'actual' => 0,
                'variance' => 0
            ];
            $sumDepLabor = [
                'estimated' => 0,
                'actual' => 0,
                'variance' => 0
            ];
            $sumDepTotal = [
                'estimated' => 0,
                'actual' => 0,
                'variance' => 0
            ];

            //material
            $sumDepMaterial['estimated'] = $query->sum('pteam_wo_cost_v.h1_estimated_material_cost');
            $sumDepMaterial['actual'] = $query->sum('pteam_wo_cost_v.h1_actual_material_cost');
            $sumDepMaterial['variance'] = $query->sum('pteam_wo_cost_v.h1_variance_material_cost');
            //labor
            $sumDepLabor['estimated'] = $query->sum('pteam_wo_cost_v.h1_estimated_labor_cost');
            $sumDepLabor['actual'] = $query->sum('pteam_wo_cost_v.h1_actual_labor_cost');
            $sumDepLabor['variance'] = $query->sum('pteam_wo_cost_v.h1_variance_labor_cost');
            //total
            $sumDepTotal['estimated'] = $query->sum('pteam_wo_cost_v.h1_sum_estimated_total_cost');
            $sumDepTotal['actual'] = $query->sum('pteam_wo_cost_v.h1_sum_actual_total_cost');
            $sumDepTotal['variance'] = $query->sum('pteam_wo_cost_v.h1_sum_variance_total_cost');

            $item->sumDepMaterial = $sumDepMaterial;
            $item->sumDepLabor = $sumDepLabor;
            $item->sumDepTotal = $sumDepTotal;

            // process sum of of all dep
            $sumAllMaterial['estimated'] = $sumAllMaterial['estimated'] + $sumDepMaterial['estimated'];
            $sumAllMaterial['actual'] = $sumAllMaterial['actual'] + $sumDepMaterial['actual'];
            $sumAllMaterial['variance'] = $sumAllMaterial['variance'] + $sumDepMaterial['variance'];

            $sumAllLabor['estimated'] = $sumAllLabor['estimated'] + $sumDepLabor['estimated'];
            $sumAllLabor['actual'] = $sumAllLabor['actual'] + $sumDepLabor['actual'];
            $sumAllLabor['variance'] = $sumAllLabor['variance'] + $sumDepLabor['variance'];

            $sumAllTotal['estimated'] = $sumAllTotal['estimated'] + $sumDepTotal['estimated'];
            $sumAllTotal['actual'] = $sumAllTotal['actual'] + $sumDepTotal['actual'];
            $sumAllTotal['variance'] = $sumAllTotal['variance'] + $sumDepTotal['variance'];
        }

        $costs = [
            'sumAllMaterial' => $sumAllMaterial,
            'sumAllLabor' => $sumAllLabor,
            'sumAllTotal' => $sumAllTotal
        ];
        $date = [
            'now' => Carbon::now()->format('d-M-y H:i:s')
        ];
        $pdf = \PDF::loadView('eam.exports.work-order-wo-cost.body', ['departments' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-wo-cost.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportSummaryLabor(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? null);
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $date = parseFromDateTh($request->p_date) ?? null;
        $dateTo = parseFromDateTh($request->p_date_to) ?? $date;
        $departmentCode = trim($request->p_department_code ?? '%');

        $workOrderType = trim($request->p_work_order_type ?? '%');

        $query = SummaryLaborV::selectRaw("pteam_summary_labor_v.* , NVL(SUBSTR(wip_entity_name, 0, INSTR(wip_entity_name, '-')-1), wip_entity_name) AS wip_entity_name_pre
        , NVL(SUBSTR(wip_entity_name, INSTR(wip_entity_name, '-')+1 ), wip_entity_name) AS wip_entity_name_post");

        if ($wipEntityName != null) {
            $wipEntityNameArr = sscanf($wipEntityName, '%d-%d');
            $wipEntityNameToArr = sscanf($wipEntityNameTo, '%d-%d');
            $query = $query->whereRaw(
                "( ( To_number(Nvl(Substr(wip_entity_name, 0, Instr(wip_entity_name, '-') - 1),wip_entity_name)) > " . $wipEntityNameArr[0] . " AND To_number(Nvl(Substr(wip_entity_name, 0, Instr(wip_entity_name, '-') - 1),wip_entity_name)) < " . $wipEntityNameToArr[0] . " ) "
                    . " OR  ( To_number(Nvl(Substr(wip_entity_name, 0, Instr(wip_entity_name, '-') - 1),wip_entity_name)) = " . $wipEntityNameArr[0] . " AND To_number(Nvl(Substr(wip_entity_name, Instr(wip_entity_name, '-') + 1),wip_entity_name)) >= " . $wipEntityNameArr[1] . " AND $wipEntityNameArr[0] <> $wipEntityNameToArr[0]) "
                    . " OR ( To_number(Nvl(Substr(wip_entity_name, 0, Instr(wip_entity_name, '-') - 1),wip_entity_name)) = " . $wipEntityNameToArr[0] . " AND To_number(Nvl(Substr(wip_entity_name, Instr(wip_entity_name, '-') + 1),wip_entity_name)) <= " . $wipEntityNameToArr[1] . " AND $wipEntityNameArr[0] <> $wipEntityNameToArr[0]) "
                    . " OR (" . $wipEntityNameArr[0] . " = " . $wipEntityNameToArr[0] . " AND To_number(Nvl(Substr(wip_entity_name, Instr(wip_entity_name, '-') + 1),wip_entity_name)) between " . $wipEntityNameArr[1] . " AND " . $wipEntityNameToArr[1] . "  ) "
                    . ")"
            );
        }

        if ($date != null) {
            $query = $query->whereRaw(" trunc(pteam_summary_labor_v.transaction_date) >= '{$date}' ");
        }
        if ($dateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_summary_labor_v.transaction_date) <= '{$dateTo}' ");
        }
        if ($departmentCode != null) {
            $query = $query->whereRaw("to_char(pteam_summary_labor_v.department_code) like '{$departmentCode}'");
        }
        if ($workOrderType != null) {
            $query = $query->whereRaw("to_char(pteam_summary_labor_v.meaning) like '{$workOrderType}'");
        }
        $data = $query
            ->orderByRaw('to_number(wip_entity_name_pre)  asc')
            ->orderByRaw('to_number(wip_entity_name_post)  asc')
            ->orderBy('transaction_date', 'ASC')
            ->get();
        $costs = ['total' => 0];
        foreach ($data as $value) {
            $costs['total'] = $costs['total'] + ($value->wage_hour);
        }

        $date = [
            'wipFrom' => $wipEntityName,
            'wipTo' => $wipEntityNameTo,
            'from' => Carbon::parse($date)->format('d-M-y'),
            'to' => Carbon::parse($dateTo)->format('d-M-y'),
            'now' => Carbon::now()->format('d-M-y H:i:s')
        ];

        $pdf = \PDF::loadView('eam.exports.work-order-summary-labor.body', ['workOrders' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-summary-labor.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportReceiptMat(Request $request)
    {
        $wipEntityName = trim($request->p_wip_entity_name ?? '%');
        $wipEntityNameTo = trim($request->p_wip_entity_name_to ?? $wipEntityName);
        $date = parseFromDateTh($request->p_date) ?? null;
        $dateTo = parseFromDateTh($request->p_date_to) ?? $date;
        $period = trim($request->p_period) ?? null;
        $employee = trim($request->p_employee ?? '');

        $query = ReceiptMatV::select('pteam_receipt_mat_v.*');
        if ($wipEntityName != '%') {
            $query = $query->whereBetween('pteam_receipt_mat_v.p_wip_entity_name', [$wipEntityName, $wipEntityNameTo]);
        }
        if ($date != null) {
            $query = $query->whereRaw(" trunc(pteam_receipt_mat_v.p_transaction_date) >= '{$date}' ");
        }
        if ($dateTo != null) {
            $query = $query->whereRaw(" trunc(pteam_receipt_mat_v.p_transaction_date) <= '{$dateTo}' ");
        }
        if ($period != null) {
            $query = $query->whereRaw("to_char(pteam_receipt_mat_v.p_period_name) like '{$period}'");
        }
        if ($employee != null) {
            $query = $query->whereRaw("pteam_receipt_mat_v.p_employee_code = '{$employee}'");
        }

        $data = $query->get();
        $costs = [
            'total' => 0,
            'employee' => $employee
        ];
        foreach ($data as $value) {
            $costs['total'] = $costs['total'] + ($value->h1_actual_total_cost);
        }

        if ($period != null) {
            if (isset($data[0])) {
                $from = $data[0]->p_period_form;
                $to = $data[0]->p_period_to;
            } else {
                $from = $date;
                $to = $dateTo;
            }
        } else {
            $from = $date;
            $to = $dateTo;
        }
        $date = [
            'wipFrom' => $wipEntityName,
            'wipTo' => $wipEntityNameTo,
            'from' => Carbon::parse($from)->format('d-M-y'),
            'to' => Carbon::parse($to)->format('d-M-y'),
            'now' => Carbon::now()->format('d-M-y H:i:s')
        ];

        $pdf = \PDF::loadView('eam.exports.work-order-receipt-mat.body', ['workOrders' => $data, 'costs' => $costs])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOptions([
                'margin-top' => '2cm',
                'margin-bottom' => '0.5cm',
                'margin-left' => '0.7cm',
                'margin-right' => '0.7cm',
                'encoding' => 'utf-8',
                'header-html' => view('eam.exports.work-order-receipt-mat.header', ['date' => $date])
            ]);
        return $pdf->inline();
    }

    public function reportLabor(Request $request)
    {
        $params = $request->all();
        $service = new LaborV();
        $pdf = $service->reportExcel($params);
        return $pdf;
    }

    public function interfaceH($batchNo)
    {
        $result = (new WorkOrderHTInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceMt($batchNo)
    {
        $result = (new WorkOrderMtTInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceMtDirect($batchNo)
    {
        $result = (new WorkOrderMtDirectTInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceMtDirectPr($batchNo, $wipEntityId, $prNumber)
    {
        $result = (new WorkOrderMtDirectTPrInterface)->Import($batchNo, $wipEntityId, $prNumber);
        return $result;
    }

    public function interfaceMtUsed($batchNo, $organizationId, $wipEntityId, $operationSeqNum, $inventoryItemId)
    {
        $result = (new WorkOrderMtUsedInterface)->Import($batchNo, $organizationId, $wipEntityId, $operationSeqNum, $inventoryItemId);
        return $result;
    }

    public function interfaceMtReturn($batchNo, $organizationId, $wipEntityId, $operationSeqNum, $inventoryItemId, $lotNo)
    {
        $result = (new WorkOrderMtReturnInterface)->Import( $batchNo, 
                                                            $organizationId, 
                                                            $wipEntityId, 
                                                            $operationSeqNum, 
                                                            $inventoryItemId, $lotNo);
        return $result;
    }

    public function interfaceCp($batchNo)
    {
        $result = (new WorkOrderCpTInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceLb($batchNo)
    {
        $result = (new WorkOrderLbInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceSubmitLb($batchNo)
    {
        $result = (new WorkOrderLbSubmitInterface)->Import($batchNo);
        return $result;
    }

    public function interfaceCancelLb($batchNo, $orTransactionId, $wipEntityName)
    {
        $result = (new WorkOrderLbCancelInterface)->Import($batchNo, $orTransactionId, $wipEntityName);
        return $result;
    }

    public function closeJP($wipEntityName)
    {
        try {
            $data = CloseJPV::getByWipEntityName($wipEntityName);
            return response()->json(['data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function autoClassEMP0007(Request $request)
    {
        $assetNumber = (string)$request->assetNumber ?? '';
        $departmentCode = (string)$request->departmentCode ?? '';

        try {
            $result = [];
            $db = DB::getPdo();
            $sql = "
                DECLARE
                    V_CLASS_CODE VARCHAR(100);
                    V_P_INF_MSG VARCHAR(4000);
                BEGIN
                    :V_CLASS_CODE := PTEAM_WORK_ORDER_PKG.GET_WIP_CLASS_CODE(
                        P_ASSET_NUMBER => '${assetNumber}'
                        ,P_RECEIVING_DEPARTMENT_CODE => '${departmentCode}'
                        ,P_ERR_MESSAGE => :V_P_INF_MSG
                    );
                    dbms_output.put_line('V_CLASS_CODE = '||V_CLASS_CODE);
                    dbms_output.put_line('V_P_INF_MSG = '||V_P_INF_MSG);
                END;
            ";

            $sql = preg_replace("/[\r\n]*/", "", $sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':V_CLASS_CODE', $result['v_class_code'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':V_P_INF_MSG', $result['v_p_inf_msg'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function mtCheckCutThroughWMS(Request $request)
    {
        try {
            $departmentCode = WorkOrderOpV::where('wip_entity_id', $request['p_wip_entity_id'])
                                ->where('operation_seq_num', $request['p_operation_seq_num'])
                                ->value('department_code');

            $data = Departments::where('department_code', $departmentCode)
                                ->value('wms_issue');
            return response()->json(['data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function checkConfirmMt($wipEntityName)
    {
        $header = WorkOrderHV::where('wip_entity_name',$wipEntityName)->first();
        if (!$header) {
            $header = WorkOrderHV::where('wip_entity_id',$wipEntityName)->first();
        }

        $inv = WorkOrderMtV::where('wip_entity_id',$header->wip_entity_id)->get(); // Inventory
        $nonStock = WorkOrderMtDirectV::where('wip_entity_id', $header->wip_entity_id)->get(); //Non Stock

        $checkConfirmMtSuccess = true;
        if (count($inv)) {
            $checkIssueStatusYes            = $inv->where('wms_issue', 'Yes');
            $checkIssueStatusNo             = $inv->where('wms_issue', 'No');
            $checkAttribute6StatusNull      = $inv->where('attribute6', '==', '');
            $checkAttribute6StatusYes       = $inv->where('attribute6', 'Yes');
            $checkAtt6NoAndIssueYes         = $inv->where('attribute6', 'No')
                                                  ->where('wms_issue', 'Yes');

            if(count($checkIssueStatusYes) == count($inv)){
                if(count($checkAttribute6StatusYes) == count($inv)){
                    $checkConfirmMtSuccess = false;
                }else{
                    $checkConfirmMtSuccess = true;
                }
            }else{
                if (count($checkIssueStatusNo)) {
                    if(count($checkAttribute6StatusNull) >= 1){
                        $checkConfirmMtSuccess = true;
                    }else{
                        $checkConfirmMtSuccess = false;
                        if(count($checkAtt6NoAndIssueYes) >= 1){
                            $checkConfirmMtSuccess = true;
                        }
                    }
                }
            }
        }else{
            $checkConfirmMtSuccess = false;
        }

        if (count($nonStock)) {
            $checkPrStatus = $nonStock->whereNotNUll('pr_number');
            $checkConfirmMtSuccess = (count($nonStock) == count($checkPrStatus)) && $checkConfirmMtSuccess;
        }

        return response()->json(['data' => [
            'is_material_flag' => ($header->material_flag == 'Y'),
            'confirm_mt_success' => $checkConfirmMtSuccess
        ]]);
    }

    public function mtShowReMaterial(Request $request)
    {
        $reMateriaList = WorkOrderReMaterialV::where('wip_entity_id', $request['p_wip_entity_id'])
                                            ->where('item_code', $request['p_item_code'])
                                            ->get();

        return response()->json(['data' => $reMateriaList], 200);
    }
}
