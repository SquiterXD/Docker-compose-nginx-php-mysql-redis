<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtctCtr0009WithPkg extends Model
{
    use HasFactory;
    protected $table = 'oact.ptct_ctr0009';

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
}
