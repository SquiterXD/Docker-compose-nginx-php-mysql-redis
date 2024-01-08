<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypeAllV extends Model
{
    use HasFactory;

    protected $table = 'ptom_transaction_types_all_v';
    public $primaryKey = 'order_type_id';
}