<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mock;
use App\Models\PM\PtpmOperationOfBatchV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmConfirmBatchLossV;
use App\Models\PM\PtpmLoss;
use App\Models\PM\PtpmBatchLossHeaders;
use App\Models\PM\PtpmBatchLossLines;

use Illuminate\Http\JsonResponse;
use DB;

class WipLossQuantityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $url = (object)[];
        $url->wip_loss_quantity_index = route('pm.wip-loss-quantity.index');
        $url->ajax_store = route('pm.ajax.wip-loss-quantity.store');

        $jobHeaders = PtpmConfirmBatchLossV::query()
                ->where('organization_id', $user->organization_id)
                ->whereNotNull('blend_no')
                ->orderBy('batch_no')
                ->orderBy('transaction_date')
                ->orderBy('opt')
                ->get();

        $jobHeaders = collect($jobHeaders)->map(function ($row) {
            $item = PtpmItemNumberV::select(['blend_no', 'inventory_item_id', 'item_number', 'item_desc', 'primary_unit_of_measure'])
                        ->where('item_number', $row->item_no)
                        ->where('organization_id', $row->organization_id)
                        ->first();

            $row->item_data = $item;

            if ($row->open_flag == 'Y') {
                $lossHeader = PtpmBatchLossHeaders::where('organization_id', $row->organization_id)
                                ->where('batch_id', $row->batch_id)
                                ->where('opt', $row->opt)
                                ->where('wip_step', $row->wip_step)
                                ->where('loss_date', $row->transaction_date)
                                ->first();

                $lossLines = PtpmBatchLossLines::where('loss_header_id', $lossHeader->loss_header_id)->get();
                $lossLines = collect($lossLines)->map(function ($lineRow) {
                    $lossData = PtpmLoss::select('lookup_code', 'meaning')->where('lookup_code', $lineRow->loss_code)->first();
                    $lineRow->loss_data = $lossData;
                    return $lineRow;
                });
                $row->jobLines = $lossLines;
            } else {
                $ptpmLosses = PtpmLoss::orderBy('lookup_code')->get();
                $row->jobLines = $ptpmLosses;
            }

            return $row;
        });

        $wipSteps = PtpmOperationOfBatchV::query()
            ->orderBy('oprn_class_desc')
            ->get()
            ->toArray();

        foreach ($jobHeaders as $jobHeader) {
            $organizationId = $jobHeader['organization_id'];
            $batchNo = $jobHeader['batch_no'];
            $wipStep = $jobHeader['wip_step'];
            $wipStepsForHeader = array_filter($wipSteps, function ($wip) use ($organizationId,$batchNo,$wipStep) {
                return $wip['organization_id'] === $organizationId 
                        && $wip['batch_no'] === $batchNo
                        && $wip['oprn_class_desc'] === $wipStep;
            });

            $jobHeader['wip_steps'] = array_values($wipStepsForHeader);
        }

        $headers = $jobHeaders;

        return view('pm.wip-loss-quantity.index', compact(
            "headers", "url"
        ));
    }
}