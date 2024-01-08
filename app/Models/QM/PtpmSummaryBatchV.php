<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmSummaryBatchV extends Model
{
    use HasFactory;

    protected $table  = 'PTPM_SUMMARY_BATCH_V';

    public function scopeGetListBrandCigarettes($query)
    {
        return $query->select(DB::raw("item_desc as brand_value, item_desc as brand_label, item_desc as description"))
        ->whereRaw("organization_code = 'MG6'")
        ->groupBy('item_desc')
        ->orderBy('item_desc');
    }

}
