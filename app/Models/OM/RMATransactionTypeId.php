<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RMATransactionTypeId extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_TRANSACTION_TYPES_ALL_V';
    protected $primaryKey   = 'order_type_id';
}
