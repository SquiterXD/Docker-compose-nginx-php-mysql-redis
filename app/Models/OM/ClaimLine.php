<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class ClaimLine extends Model
{
    protected $table = 'ptom_claim_lines';
    public $primaryKey = 'claim_line_id';
    public $timestamps = false;

    public function onHands()
    {
        return $this->hasMany('App\Models\OM\OnHandV', 'item_code', 'item_code')->orderBy('lot_number');
    }

    public function uomV()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'uom_code');
    }

    public function rmaUomV()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'rma_uom_code');
    }

    public function claimUomV()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'claim_uom_code');
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockLines', 'issueable');
    }

    public function receipts()
    {
        return $this->morphMany('App\Models\OM\ReceiptStockLines', 'receiptable');
    }

    public function orderLine()
    {
        return $this->hasOne('App\Models\OM\Api\OrderLines', 'order_line_id', 'order_line_id');
    }
}
