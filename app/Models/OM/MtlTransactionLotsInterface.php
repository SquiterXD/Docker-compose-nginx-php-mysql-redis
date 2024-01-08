<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlTransactionLotsInterface extends Model
{
    use HasFactory;

    protected $table = 'MTL_TRANSACTION_LOTS_INTERFACE';
    public $primaryKey = 'transaction_interface_id';
    public $timestamps = false;
}