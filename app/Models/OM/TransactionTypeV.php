<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypeV extends Model
{
    use HasFactory;

    protected $table = 'ptom_transaction_types_v';
    public $primaryKey = 'order_type_id';
}