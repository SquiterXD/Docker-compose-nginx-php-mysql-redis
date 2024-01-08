<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtr0004WithPkg extends Model
{
    use HasFactory;
    protected $table = 'oact.ptct_ctr0004';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeSearch($q, $batch_from, $batch_to, $product_from, $product_to)
    {
        if ($batch_from != '' || $batch_from != null && $batch_to != '' || $batch_to != null) {
            $q->whereRaw("batch_no BETWEEN '{$batch_from}' and '{$batch_to}'");
        }elseif($batch_from != '' || $batch_from != null){
            $q->where('batch_no', '>=', $batch_from);
        }

        if ($product_from != '' || $product_from != null && $product_to != '' || $product_to != null) {
            $q->whereRaw("item_number BETWEEN '{$product_from}' and '{$product_to}'");
        }elseif($product_from != '' || $product_from != null){
            $q->where('item_number', '>=', $product_from);
        }

        return $q;
    }
}
