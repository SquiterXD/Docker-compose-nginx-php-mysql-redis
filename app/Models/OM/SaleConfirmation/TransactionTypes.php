<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    use HasFactory;

    protected $table = 'PTOM_TRANSACTION_TYPES_V';
    public $primaryKey = 'ORDER_TYPE_ID';
    public $timestamps = false;


}
