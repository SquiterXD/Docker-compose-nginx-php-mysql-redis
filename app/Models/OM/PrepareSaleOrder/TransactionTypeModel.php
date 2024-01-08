<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypeModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_transaction_types_v';
}
