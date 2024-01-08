<?php

namespace App\Http\Controllers\Mobile\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use DB;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmMachinePlanHeaderV;
use App\Models\PM\PtpmQrcodeLog;
use App\Repositories\Mobile\PM\QrCodeRepository;


class QrcodeCheckMtlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail()
    {
        try {
            $profile = getDefaultData('/pm/qrcode-check-mtls');
            $orgId = $profile->organization_id;

            $step = request()->step;
            $itemReq = (request()->item);
            $transferDate = request()->transfer_date;
            $itemId = getItemIdFmQr($itemReq);


            if ($transferDate) {
                // $data = PtpmMachinePlanHeaderV::whereDate('plan_date', ($transferDate))
                //             ->where('organization_id', $orgId)
                //             ->get();
                $data = (new QrCodeRepository)->mtlPlan($orgId, ($transferDate));
                if (count($data) == 0) {
                    throw new \Exception("ไม่พบข้อมูลวางแผนของวันที่ ". parseToDateTh($transferDate) );
                }
            }

            // $itemData = (new QrCodeRepository)->mtlPlan($orgId, ($transferDate));
            // if ($itemData) {
            //     // $itemData = $itemData->where('inventory_item_id', $itemId)->first();
            //     $itemData = $itemData->where('inventory_item_id', 21030)->first();
            // }

            $planDate = ($transferDate);
            $itemData = PtpmItemNumberV::selectRaw("
                            organization_id
                            , inventory_item_id
                            , item_number
                            , item_desc as description
                            , to_date('{$planDate}','yyyy-mm-dd') as plan_date
                            , 0 as plan_quantity
                            , primary_uom_code as uom_code
                            , primary_unit_of_measure as unit_of_measure
                        ")
                        ->where('inventory_item_id', $itemId)
                        ->where('organization_id', $orgId)
                        ->first();
            if (is_null($itemData)) {
                throw new \Exception("ไม่พบข้อมูลวัตถุดิบ ". $itemReq);
            }

            $compareItemReq = false;
            $compareItemData = false;
            if (request()->compare_item) {
                $compareItemReq = (request()->compare_item ?? []);
                $compareItemReqId = getItemIdFmQr($compareItemReq);
                $compareItemData = PtpmItemNumberV::where('inventory_item_id', $compareItemReqId)
                                    ->where('organization_id', $orgId)
                                    ->first();

                if (is_null($compareItemData)) {
                    throw new \Exception("ไม่พบข้อมูลวัตถุดิบ ". $compareItemReq);
                }
            }

            if ($step == 2) {
                if ($itemData->inventory_item_id == $compareItemData->inventory_item_id) {
                    $planDate       = ($transferDate);
                    $sysdate        = now()->format('Y-m-d H:i:s');
                    $fndUserId      = $profile->fnd_user_id;
                    $programCode    = $profile->program_code;

                    $log = new PtpmQrcodeLog;
                    $log->organization_id   = $itemData->organization_id;
                    $log->inventory_item_id = $itemData->inventory_item_id;
                    $log->plan_date         = $planDate;
                    $log->transaction_quantity = $itemData->plan_quantity;
                    $log->transaction_uom   = $itemData->uom_code;
                    $log->transaction_date  = $sysdate;

                    $log->program_name      = $profile->program_code;
                    $log->user_id           = $profile->fnd_user_id;
                    $log->save();
                }
            }



            $canNextStep = false;
            switch ($step) {
                case '1':
                    $canNextStep = true;
                    if (!$itemData) {
                        $canNextStep = false;
                    }
                    break;
                case '2':
                    $canNextStep = false;
                    if ($itemData && $compareItemData) {
                        if ($itemData->inventory_item_id == $compareItemData->inventory_item_id) {
                            $canNextStep = true;
                        }
                    }
                    break;
                default:
                    # code...
                    break;
            }

            $html = view('mobile.pm.qrcode-check-mtls._detail_html', compact(
                        'step', 'itemData', 'itemReq', 'compareItemReq', 'compareItemData', 'transferDate'
                    ))
                    ->render();
            $data = [
                'status' => 'S',
                'html' => $html,
                'can_next_step' => $canNextStep
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
}
