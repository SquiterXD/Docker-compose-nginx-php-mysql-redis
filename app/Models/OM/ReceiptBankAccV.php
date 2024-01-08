<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptBankAccV extends Model
{
    use HasFactory;
    protected $table = "OAOM.PTOM_RECEIPT_BANK_ACC_V";
    public $primaryKey = '';
    public $timestamps = false;
}