<?php
namespace App\Http\Controllers\Mobile\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use DB;
use PDO;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmMachinePlanHeaderV;
use App\Models\PM\PtpmQrcodeInterfaceT;
use App\Models\User;
use App\Repositories\Mobile\PM\QrCodeRepository;


class QrcodeRcvTransferMtlController extends Controller
{
    public function detail()
    {
        $profile = getDefaultData('/pm/qrcode-rcv-transfer-mtls');
        $orgId = $profile->organization_id;
        $sessionName = "qr-rcv-transfer-mtls-{$profile->user_id}";
        $currentData = session()->get($sessionName, null);
        // dd('xx', $currentData, session()->all());

        try {
            $defTransferDate = '';
            if (!optional($currentData)->transfer_date) {
                $currentData = (object)[];
                $currentData->transfer_date = request()->transfer_date;
                $currentData->items = [];
                session([$sessionName => $currentData]);
                $defTransferDate = date('Y-m-d');
            }

            if (request()->new_session == 'true') {
                $currentData = '';
                session([$sessionName => $currentData]);
            }



            $step = request()->step;
            $itemData = null;
            $itemReq = '';
            $html = '';

            if (($step == 1 || $step == 2) && !request()->is_first_load && request()->new_session != 'true') {
                // $data = PtpmMachinePlanHeaderV::whereDate('plan_date', (request()->transfer_date))
                //             ->where('organization_id', $orgId)
                //             ->get();
                // dd('zz', request()->all());
                // $data = (new QrCodeRepository)->mtlPlan($orgId, (request()->transfer_date));
                $data = (new QrCodeRepository)->mtlPlan($orgId, ($currentData->transfer_date));
                if (count($data) == 0) {
                    throw new \Exception("ไม่พบข้อมูลวางแผนของวันที่ ". parseToDateTh($currentData->transfer_date));
                }
            }

            if ($step > 0) {

                if (request()->item) {
                    $itemId = getItemIdFmQr(request()->item);
                    $itemData = (new QrCodeRepository)->mtlPlan($orgId, ($currentData->transfer_date));
                    if ($itemData) {
                        $itemData = $itemData->where('inventory_item_id', $itemId)->first();
                        if ($itemData) {
                            $itemData->exists_plan = 'Y';
                        }
                    }
                    if (is_null($itemData)) {
                        // throw new \Exception("ไม่พบข้อมูลวัตถุดิบ ". request()->item);
                        $itemData = PtpmItemNumberV::selectRaw("
                            organization_id
                            , inventory_item_id
                            , item_number
                            , item_desc as description
                            -- , to_date('{$currentData->transfer_date}','yyyy-mm-dd') as plan_date
                            , '' as plan_date
                            , '' as plan_quantity
                            , primary_uom_code as uom_code
                            , primary_unit_of_measure as unit_of_measure
                            , 'N' as exists_plan
                        ")
                        ->where('inventory_item_id', $itemId)
                        ->where('organization_id', $orgId)
                        ->first();
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
                    //                 ->where('inventory_item_id', $itemId)
                    //                 ->where('organization_id', $orgId)
                    //                 ->first();
                }

                if ($step == 3) {
                    $items = $currentData->items;

                    $itemData->tranfer_qty = request()->tranfer_qty;
                    $result = (new QrCodeRepository)->checkOnhand(
                        $itemData->inventory_item_id,
                        $itemData->organization_id,
                        $itemData->tranfer_qty,
                        'TRANSFER');

                    $onhand = data_get($result, 'onhand', 0) ?? 0;
                    $uom = data_get($result, 'uom');
                    if ($itemData->tranfer_qty > $onhand) {
                        throw new \Exception("$itemData->item_number : จำนวนคงคลังไม่เพียงพอ, ปัจจุบันมียอด $onhand $uom");
                    }
                    $items[$itemData->inventory_item_id] = $itemData;

                    $currentData->items = $items;
                    session([$sessionName => $currentData]);
                }

                $html = view('mobile.pm.qrcode-rcv-transfer-mtls._detail_html', compact(
                            'step', 'itemReq', 'itemData', 'currentData'
                        ))
                        ->render();
                if ($step == 5.5) {
                    $uerId = getUserIdFmQr(request()->assignee);
                    if (!$uerId) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->assignee);
                    }
                    $user = User::find($uerId);
                    if (!$user) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->machine_group . " ในระบบ");
                    }

                    $assigneeData = $user;
                    $html = view('mobile.pm.qrcode-rcv-transfer-mtls._detail_html', compact(
                                'step', 'itemReq', 'itemData', 'currentData', 'assigneeData'
                            ))
                            ->render();
                }

                if ($step == 6) {
                    $items          = data_get($currentData, 'items', []);
                    $planDate       = ($currentData->transfer_date);
                    $sysdate        = now()->format('Y-m-d H:i:s');
                    $webUserName    = $profile->user_name;
                    $fndUserId      = $profile->fnd_user_id;
                    $programCode    = $profile->program_code;
                    $webBatchNo     = now()->format('YmdHisu');
                    $webBatchNo     = "{$programCode}-{$webBatchNo}";

                    $uerId = getUserIdFmQr(request()->assignee);
                    if (!$uerId) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->assignee);
                    }
                    $user = User::find($uerId);
                    if (!$user) {
                        throw new \Exception("ไม่พบข้อมูลนักงาน ". request()->machine_group . " ในระบบ");
                    }

                    foreach ($items as $key => $item) {
                        $tmp = new PtpmQrcodeInterfaceT;
                        $tmp->organization_id   = $item->organization_id;
                        $tmp->inventory_item_id = $item->inventory_item_id;
                        $tmp->plan_date         = $planDate;
                        $tmp->transaction_quantity = $item->tranfer_qty;
                        $tmp->transaction_uom   = $item->uom_code;
                        $tmp->transaction_date  = $sysdate;

                        $tmp->program_name      = $profile->program_code;
                        $tmp->web_batch_no      = $webBatchNo;
                        $tmp->source_type       = 'TRANSFER';
                        $tmp->web_user          = $user->name;
                        $tmp->user_id           = $fndUserId;
                        $tmp->save();
                    }
                    $result = $this->interface($webBatchNo);
                    if ($result['status'] != 'S') {
                        throw new \Exception("Interface: ". $result['message']);
                    }

                    session([$sessionName => null]);
                }

                if ($step == 7) { // delete Item
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
                    if ($itemData) {
                        $canNextStep = true;
                    }
                    break;
                case '3':
                    $canNextStep = false;
                    if ($itemData) {
                        $canNextStep = true;
                    }
                    break;
                case '5':
                    $canNextStep = false;
                    if (count($currentData->items)) {
                        $canNextStep = true;
                    }
                    break;
                case '5.5':
                    $canNextStep = false;
                    if (count($currentData->items)) {
                        $canNextStep = true;
                    }
                    break;
                default:
                    break;
            }

            $data = [
                'status' => 'S',
                'html' => $html,
                'transfer_date' => optional($currentData)->transfer_date,
                'def_transfer_date' => $defTransferDate,
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
        \Log::info('App\Http\Controllers\PM\Api\QrcodeRcvTransferMtlController INF', [$sql]);
        $logSql = $sql;

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 500);
        $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('App\Http\Controllers\PM\Api\QrcodeRcvTransferMtlController INF', [$result]);

        $logSql = $logSql . ' v_status => '. $result['status'];
        $result['log_sql'] =  $logSql;

        PtpmQrcodeInterfaceT::where('web_batch_no', $batchNo)->update(['interface_name' => $logSql]);
        return $result;
    }
}
