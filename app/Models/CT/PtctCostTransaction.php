<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class PtctCostTransaction extends Model
{
    use HasFactory;
    protected $table = 'PTCT_COST_TRANSACTIONS';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetCostBatchNos($query)
    {
        return $query->select(DB::raw("batch_no as batch_no_value, batch_no as batch_no_label, batch_no, cost_code"))
            ->groupBy('cost_code', 'batch_no')
            ->orderBy('cost_code')
            ->orderBy('batch_no');

    }
}
