<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctSummaryBatchV extends Model
{
    use HasFactory;
    protected $table = 'PTCT_SUMMARY_BATCH_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetCostBatchItems($query)
    {
        return $query->select(DB::raw("item_no as item_value, item_no || ' : ' || item_desc as item_label, cost_code, batch_no, item_no, item_desc"))
            ->groupBy('cost_code', 'batch_no', 'item_no', 'item_desc')
            // ->orderBy('cost_code')
            // ->orderBy('batch_no')
            ->orderBy('item_no')
            ->orderBy('item_desc');

    }


}
