<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlTransactionsInterface extends Model
{
    use HasFactory;

    protected $table = 'MTL_TRANSACTIONS_INTERFACE';
    public $primaryKey = 'transaction_interface_id';
    public $timestamps = false;
}