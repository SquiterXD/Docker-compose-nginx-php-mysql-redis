<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrctCtr0004 extends Model
{
    use HasFactory;
    protected $table = 'PTCT_CTR0004';

    public function scopeSelectCtr009Raw($q)
    {
        return $q->selectRaw('transaction_date,
                                product_item_number,
                                cost_code,
                                period_year,
                                product_group_desc,
                                description,
                                product_group,
                                product_item_desc,
                                batch_no,
                                item_number,
                                item_desc,
                                detail_uom,
                                transaction_quantity,
                                transaction_cost,
                                tobacco_group_code,
                                tobacco_group');
    }

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
