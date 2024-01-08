<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarHistoryV extends Model
{
    use HasFactory;
    protected $table = 'PTINV_CAR_HISTORY_V';

    public function webFuelOils()
    {
        return $this->hasMany(WebFuelOil::class, 'mmt_transaction_id', 'mmt_transaction_id');
    }
}
