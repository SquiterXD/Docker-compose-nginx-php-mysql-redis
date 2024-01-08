<?php

namespace App\Http\Controllers\PM\Api;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\Mock;
use App\Models\PM\PtpmBatchLossHeaders;
use App\Models\PM\PtpmBatchLossLines;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;
use Psy\Util\Json;

class WipLossQuantityApiController extends Controller
{
    public function updateJobLines(Request $request): JsonResponse
    {
        $profile = getDefaultData('/pm/wip-loss-quantity');
        $sysdate = now();
        $data = $request->all();
        $isOpenFlag = $data['isOpenFlag'];
        $requestData = $data['jobHeaderLines'];
        $jobHeader = $requestData['jobHeader'];

        try {
            DB::beginTransaction();

            $invItemId = $jobHeader['item_data']['inventory_item_id'];
            $uom = $jobHeader['item_data']['primary_unit_of_measure'];

            if ($isOpenFlag == 'Y') {

                $lossHeader = PtpmBatchLossHeaders::where('organization_id', $jobHeader['organization_id'])
                            ->where('batch_id', $jobHeader['batch_id'])
                            ->where('opt', $jobHeader['opt'])
                            ->where('wip_step', $jobHeader['wip_step'])
                            ->where('loss_date', $jobHeader['transaction_date'])
                            ->first();

                $lossHeader->loss_date          = $jobHeader['transaction_date'];
                $lossHeader->organization_id    = $jobHeader['organization_id'];
                $lossHeader->batch_id           = $jobHeader['batch_id'];
                $lossHeader->inventory_item_id  = $invItemId;
                $lossHeader->wip_step           = $jobHeader['wip_step'];
                $lossHeader->loss_qty           = $jobHeader['loss_qty'];
                $lossHeader->loss_uom           = $uom;
                $lossHeader->product_item_id    = null;
                $lossHeader->attribute_category = null;

                $lossHeader->program_code       = $profile->program_code ?? 'PMP0047';
                $lossHeader->created_by_id      = $profile->user_id;
                $lossHeader->updated_by_id      = $profile->user_id;
                $lossHeader->created_by         = $profile->fnd_user_id;
                $lossHeader->last_updated_by    = $profile->fnd_user_id;

                $lossHeader->created_at         = $sysdate;
                $lossHeader->updated_at         = $sysdate;
                $lossHeader->last_update_date   = $sysdate;
                $lossHeader->creation_date      = $sysdate;

                $lossHeader->save();

                if( count($jobHeader['jobLines']) > 0) {
                    $lineNo = 0;
                    foreach ($jobHeader['jobLines'] as $key => $jobLine) {
                        $lineNo++;
                        $lossLine = PtpmBatchLossLines::find($jobLine['loss_line_id']);
                        $lossLine->loss_header_id       = $lossHeader->loss_header_id;
                        $lossLine->line_number          = $lineNo;
                        $lossLine->loss_code            = $jobLine['loss_code'];
                        $lossLine->loss_qty             = $jobLine['loss_qty'];
                        $lossLine->loss_uom             = $uom;
                        $lossLine->attribute_category   = null;

                        $lossLine->program_code         = $profile->program_code ?? 'PMP0047';
                        $lossLine->created_by_id        = $profile->user_id;
                        $lossLine->updated_by_id        = $profile->user_id;
                        $lossLine->created_by           = $profile->fnd_user_id;
                        $lossLine->last_updated_by      = $profile->fnd_user_id;

                        $lossLine->created_at           = $sysdate;
                        $lossLine->updated_at           = $sysdate;
                        $lossLine->last_update_date     = $sysdate;
                        $lossLine->creation_date        = $sysdate;

                        $lossLine->save();
                    }
                }

            } else {

                $lossHeader = new PtpmBatchLossHeaders();
                $lossHeader->loss_date          = $jobHeader['transaction_date'];
                $lossHeader->organization_id    = $jobHeader['organization_id'];
                $lossHeader->batch_id           = $jobHeader['batch_id'];
                $lossHeader->inventory_item_id  = $invItemId;
                $lossHeader->wip_step           = $jobHeader['wip_step'];
                $lossHeader->loss_qty           = $jobHeader['loss_qty'];
                $lossHeader->loss_uom           = $uom;
                $lossHeader->product_item_id    = null;
                $lossHeader->attribute_category = null;

                $lossHeader->program_code       = $profile->program_code ?? 'PMP0047';
                $lossHeader->created_by_id      = $profile->user_id;
                $lossHeader->updated_by_id      = $profile->user_id;
                $lossHeader->created_by         = $profile->fnd_user_id;
                $lossHeader->last_updated_by    = $profile->fnd_user_id;

                $lossHeader->created_at         = $sysdate;
                $lossHeader->updated_at         = $sysdate;
                $lossHeader->last_update_date   = $sysdate;
                $lossHeader->creation_date      = $sysdate;

                $lossHeader->save();

                if( count($jobHeader['jobLines']) > 0) {
                    $lineNo = 0;
                    foreach ($jobHeader['jobLines'] as $key => $jobLine) {
                        $lineNo++;
                        $lossLine = new PtpmBatchLossLines();
                        $lossLine->loss_header_id       = $lossHeader->loss_header_id;
                        $lossLine->line_number          = $lineNo;
                        $lossLine->loss_code            = $jobLine['lookup_code'];
                        $lossLine->loss_qty             = $jobLine['attribute1'];
                        $lossLine->loss_uom             = $uom;
                        $lossLine->attribute_category   = null;

                        $lossLine->program_code         = $profile->program_code ?? 'PMP0047';
                        $lossLine->created_by_id        = $profile->user_id;
                        $lossLine->updated_by_id        = $profile->user_id;
                        $lossLine->created_by           = $profile->fnd_user_id;
                        $lossLine->last_updated_by      = $profile->fnd_user_id;

                        $lossLine->created_at           = $sysdate;
                        $lossLine->updated_at           = $sysdate;
                        $lossLine->last_update_date     = $sysdate;
                        $lossLine->creation_date        = $sysdate;

                        $lossLine->save();
                    }
                }

            }

            DB::commit();

            return response()->json([
                'jobHeader' => $jobHeader,
                'jobLines' => $jobHeader['jobLines'],
            ]);

        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());

            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
