<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignmentLines extends Model
{
    // use HasFactory;
    protected $table = "PTOM_CONSIGNMENT_LINES";
    public $primaryKey = "CONSIGNMENT_LINE_ID";
    public $timestamps = false;

    public function header()
    {
        return $this->hasOne('App\Models\OM\Consignment', 'consignment_header_id', 'consignment_header_id');
    }

    public function orderHeader()
    {
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'order_header_id', 'order_header_id');
    }

    public function orderLine()
    {
        return $this->hasOne('App\Models\OM\Api\OrderLines', 'order_line_id', 'order_line_id');
    }

    public function uom()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'attribute1');
    }

    public function seqEcom()
    {
        return $this->hasOne('App\Models\OM\SequenceEcoms', 'item_id', 'item_id')->where('sale_type_code', 'DOMESTIC');
    }
}
