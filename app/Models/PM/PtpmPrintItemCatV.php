<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmPrintItemCatV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRINT_ITEM_CAT_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetPrintTypes($query)
    {
        return $query->select(DB::raw("cost_segment1 as print_type_value, cost_description as print_type_label, cost_segment1, cost_description"))
            ->groupBy('cost_segment1', 'cost_description')
            ->orderBy('cost_segment1', 'DESC');
    }

}
