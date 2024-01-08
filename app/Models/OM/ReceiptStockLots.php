<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptStockLots extends Model
{
    use HasFactory;

    protected $table = 'PTOM_RECEIPT_STOCK_LOTS';
    public $primaryKey = 'receipt_lot_id';
    public $timestamps = false;
}