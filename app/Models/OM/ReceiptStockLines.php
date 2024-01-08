<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptStockLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_RECEIPT_STOCK_LINES';
    public $primaryKey = 'receipt_line_id';
    public $timestamps = false;

    public function receiptable()
    {
        return $this->morphTo();
    }

    public function lots()
    {
        return $this->hasMany('App\Models\OM\ReceiptStockLots', 'receipt_line_id', 'receipt_line_id')->orderBy('receipt_lot_id');
    }

    public function getTotalQtyAttribute()
    {
        return $this->lots()->sum('quantity');
    }
}