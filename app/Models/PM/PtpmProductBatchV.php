<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmProductBatchV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_BATCH_V';
    public $timestamps = false;

    public function scopeIsWipStatus($query)
    {
        return $query->where('batch_status', 'WIP');
    }

    public function scopeForUserProcess($query)
    {
        return $query->where(function ($q) {
            // $q->isWipStatus()->orWhereRaw("batch_id in (select distinct batch_id from ptpm_product_header where deleted_at is null)");
            $q->isWipStatus();
        });
    }

    public function scopeGetHeader($query)
    {
        return $query->select(DB::raw("organization_id, batch_no, batch_id, blend_no, actual_start_date, plan_start_date, period_year, biweekly, start_date, end_date, product_date, inventory_item_id, item_no, item_desc, plan_qty, dtl_um"))
            ->groupBy("organization_id", "batch_no", "batch_id", "blend_no", "actual_start_date", "plan_start_date", "period_year", "biweekly", "start_date", "end_date", "product_date", "inventory_item_id", "item_no", "item_desc", "plan_qty", "dtl_um");
    }
    

}


