<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptStockHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_RECEIPT_STOCK_HEADERS';
    public $primaryKey = 'receipt_header_id';
    public $timestamps = false;

    public function receiptable()
    {
        return $this->morphTo();
    }

    public function lines()
    {
        return $this->hasMany('App\Models\OM\ReceiptStockLines', 'receipt_header_id', 'receipt_header_id')->orderBy('receipt_line_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function transactionType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'transaction_type_id', 'transaction_type_id');
    }

    public function rmaTransType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'order_type_id', 'rma_order_type_id');
    }
}
