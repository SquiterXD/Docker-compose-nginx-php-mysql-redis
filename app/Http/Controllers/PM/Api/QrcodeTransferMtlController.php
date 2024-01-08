<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmMachineRelationsV;
use App\Models\PM\PtpmQrcodeInterfaceT;
use App\Models\PM\PtpmMachinePlanHeaderV;

use App\Repositories\PM\QrCodeRepository;
use App\Models\User;
use DB;
use PDO;


class QrcodeTransferMtlController extends Controller
{
    public function detail()
    {
        $profile = getDefaultData('/pm/qrcode-transfer-mtls');
        $orgId = $profile->organization_id;
        $sessionName = "qr-transfer-mtls-{$profile->user_id}";
        $currentData = session()->get($sessionName, null);
        $step = request()->step;


        $defTransferDate = '';
        if (!optional($currentData)->transfer_date) {
            $currentData = (object)[];
            $currentData->transfer_date = request()->transfer_date;
            $currentData->machine = '';
            $currentData->items = [];
            session([$sessionName => $currentData]);
            $defTransferDate = parseToDateTh(now());
        }

        try {

            if (request()->new_session == 'true') {
                $currentData = '';
                session([$sessionName => $currentData]);
            }

            $itemData = null;
            $itemReq = '';
            $html = '';
            $machine = false;

            if (($step == 1 || $step == 2) && !request()->is_first_load && request()->new_session != 'true') {
                $data = (new QrCodeRepository)->mtlPlan($orgId, parseFromDateTh(request()->transfer_date));
                if (count($data) == 0) {
                    throw new \Exception("ไม่พบข้อมูลวางแผนของวันที่ ". request()->transfer_date);
                }
            }


            if ($step > 0) {

                if (request()->item) {

                    $itemReq = json_decode(request()->item);
                    $itemId = $itemReq->item_id;
                    $orgId = $profile->organization_id;

                    $itemData = (new QrCodeRepository)->mtlPlan($orgId, parseFromDateTh($currentData->transfer_date));
                    if ($itemData) {
                        $itemData = $itemData->where('inventory_item_id', $itemId)->first();
                    }


                    // $itemData = PtpmMachinePlanHeaderV::select([
                    //                     'organization_id',
                    //                     'inventory_item_id',
                    //                     'item_number',
                    //                     'description',
                    //                     'plan_date',
                    //                     'plan_quantity',
                    //                     'uom_code',
                    //                     'unit_of_measure',
                    //                     'item_type',
                    //                 ])
                    //                 ->whereDate('plan_date', parseFromDateTh($currentData->transfer_date))
                    //                 ->where('inventory_item_id', $itemId)
                    //                 ->where('organization_id', $orgId)
                    //                 ->first();
                }
                if ($step == 2) {
                    $machineGroupReq = request()->machine_set;
                    $machineGroupReq = json_decode($machineGroupReq ?? []);
                    if (!$machineGroupReq) {
                        throw new \Exception("ไม่พบข้อมูลเครื่องจักร ". request()->machine_set);
                    }

                    $machine = PtpmMachineRelationsV::select(['machine_set', 'machine_group_desc'])
                                ->where('machine_set', $machineGroupReq->machine_set)
                                ->first();
                    if (!$machine) {
                        throw new \Exception("ไม่พบข้อมูลเครื่องจักร ". request()->machine_set . " ในระบบ");
                    }

                    $currentData->machine = $machine;
                    session([$sessionName => $currentData]);
                }

                if ($step == 4) {
                    $items = $currentData->items;

                    $itemData->tranfer_qty = request()->tranfer_qty;
                    $items[$itemData->inventory_item_id] = $itemData;

                    $currentData->items = $items;
                    session([$sessionName => $currentData]);
                }

                $html = view('pm.qrcode-transfer-mtls._detail_html', compact(
                            'step', 'itemReq', 'itemData', 'currentData'
                        ))
                        ->render();

                if ($step == 7) {
                    $assignee = request()->assignee;
                    $assignee = json_decode($assignee ?? []);
                    if (!$assignee) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->assignee);
                    }
                    $user = User::find($assignee->user_id);
                    if (!$user) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->machine_set . " ในระบบ");
                    }

                    $items          = data_get($currentData, 'items', []);
                    $planDate       = parseFromDateTh($currentData->transfer_date);
                    $sysdate        = now()->format('Y-m-d H:i:s');
                    $webUserName    = $profile->user_name;
                    $fndUserId      = $profile->fnd_user_id;
                    $programCode    = $profile->program_code;
                    $webBatchNo     = now()->format('YmdHisu');
                    $webBatchNo     = "{$programCode}-{$webBatchNo}";
                    $machine        = data_get($currentData, 'machine', []);

                    foreach ($items as $key => $item) {
                        $tmp = new PtpmQrcodeInterfaceT;
                        $tmp->organization_id   = $item->organization_id;
                        $tmp->inventory_item_id = $item->inventory_item_id;
                        $tmp->plan_date         = $planDate;
                        $tmp->transaction_quantity = $item->tranfer_qty;
                        $tmp->transaction_uom   = $item->uom_code;
                        $tmp->transaction_date  = $sysdate;

                        $tmp->machine_set       = data_get($machine, 'machine_set', null);
                        $tmp->machine_name      = data_get($machine, 'machine_group_desc', null);

                        $tmp->program_name      = $profile->program_code;
                        $tmp->web_batch_no      = $webBatchNo;
                        $tmp->source_type       = 'TRANSFER';
                        $tmp->web_user          = $user->name;
                        $tmp->user_id           = $profile->fnd_user_id;
                        $tmp->save();
                    }


                    $result = $this->interface($webBatchNo);
                    if ($result['status'] != 'S') {
                        throw new \Exception("Interface: ". $result['message']);
                    }
                    session([$sessionName => null]);
                }

                if ($step == 8) { // delete Item
                    $deleteItemId = request()->delete_item_id;
                    $items = $currentData->items;
                    unset($items[$deleteItemId]);
                    $currentData->items = $items;
                    session([$sessionName => $currentData]);
                }
            }


            $canNextStep = false;
            switch ($step) {
                case '1':
                    $canNextStep = true;
                    // if (!$itemData) {
                    //     $canNextStep = false;
                    // }
                    break;

                case '2':
                    $canNextStep = false;
                    if ($machine) {
                        $canNextStep = true;
                    }
                    break;
                case '3':
                    $canNextStep = false;
                    if ($itemData) {
                        $canNextStep = true;
                    }
                    break;
                case '4':
                    $canNextStep = false;
                    if ($itemData) {
                        $canNextStep = true;
                    }
                    break;
                case '6':
                    $canNextStep = false;
                    if (count($currentData->items)) {
                        $canNextStep = true;
                    }
                    break;
                default:
                    # code...
                    break;
            }

            $data = [
                'status' => 'S',
                'html' => $html,
                'transfer_date' => optional($currentData)->transfer_date,
                'def_transfer_date' => $defTransferDate,
                'machine' => optional($currentData)->machine,
                'can_next_step' => $canNextStep,
                'item_detail' => $itemData,
                'items' => optional($currentData)->items ?? [],
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage(),
                'can_next_step' => false,
            ];
        }

       return response()->json(['data' => $data]);
    }

    private function interface($batchNo)
    {
        $header = $this;
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status         varchar2(500);
                v_err_msg        varchar2(2000);
            begin
                PTPM_TRANSACTION_PKG.QRCODE_TRANFER( P_web_batch_no      => '{$batchNo}'
                                                    ,V_MESSAGE      => :v_err_msg
                                                    ,V_STATUS       => :v_status);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error : ' || v_err_msg);
            end;
        ";
        \Log::info('App\Http\Controllers\PM\Api\QrcodeTransferMtlController INF', [$sql]);
        $logSql = $sql;

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 500);
        $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('App\Http\Controllers\PM\Api\QrcodeTransferMtlController INF', [$result]);

        $logSql = $logSql . ' v_status => '. $result['status'];
        $result['log_sql'] =  $logSql;

        PtpmQrcodeInterfaceT::where('web_batch_no', $batchNo)->update(['interface_name' => $logSql]);
        return $result;
    }
}
