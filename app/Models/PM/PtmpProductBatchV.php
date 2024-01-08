<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\PtpmManufactureStep;

class PtmpProductBatchV extends Model
{
    use HasFactory;
    protected $table = 'oapm.ptpm_wip_step_by_batch_v';

    public function manufactureStep()
    {
        return $this->belongsTo(PtpmManufactureStep::class, 'wip_id', 'wip_id')
            ->where('owner_organization', getDefaultData(\Request::path())->organization_code);
    }

    public function getConfirmQtyAttribute($value)
    {
        if ($this->organization_code == 'M06' && $this->wip_step == 'WIP01') {
            $productDateTh = \Carbon\Carbon::parse($this->transaction_date)->format("Y-m-d");

            $header =  \App\Models\PM\PtpmMesReviewIssueHeaders::where('program_code', 'PMP0051')
                            ->where('organization_id', $this->organization_id)
                            ->where('issue_status', 2) // ตัดใช้แล้ว
                            ->where('batch_id', $this->batch_id)
                            ->where('batch_no', $this->batch_no)
                            ->where('wip_step', $this->wip_step)
                            ->where('inventory_item_id', $this->inventory_item_id)
                            // ->whereDate('issue_date',  $dateEn)
                            ->whereRaw("TRUNC(issue_date) = TRUNC(to_date('{$productDateTh}', 'YYYY-MM-DD'))")
                            ->first();
            if ($header) {
                return $header->opt_plan_qty;
            }

            $setupLayoutData = \App\Models\PM\Settings\SetupLayoutsV::whereRaw("TRUNC(to_date('{$productDateTh}', 'YYYY-MM-DD')) BETWEEN TRUNC(start_date) and TRUNC(nvl(end_date, sysdate)) ")
                            ->where('inventory_item_id', $this->inventory_item_id)
                            ->orderBy('layout_id', 'desc')
                            ->first();

            $layoutQty = optional($setupLayoutData)->layout_qty ?? 0;
            return $value * $layoutQty;
        }
        return $value;
    }
}
