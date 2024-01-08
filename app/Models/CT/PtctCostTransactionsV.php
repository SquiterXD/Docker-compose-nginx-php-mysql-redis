<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtctCostTransactionsV extends Model
{
    use HasFactory;
    protected $table = 'ptct_cost_transactions_v';
    // protected $appends = ['total_cost'];

    // public function getTotalCostAttribute()
    // {
    //     return $this->transaction_cost * $this->transaction_quantity;
    // }
}
