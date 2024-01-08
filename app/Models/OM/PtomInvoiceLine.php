<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomInvoiceLine extends Model
{
    use HasFactory;
    protected $table = "ptom_invoice_lines";
    public $primaryKey = 'invoice_line_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function header()
    {
        return $this->belongsTo(PtomInvoiceHeader::class, 'invoice_headers_id', 'invoice_headers_id');
    }

    public function consignment()
    {
        return $this->hasOne('App\Models\OM\Consignment', 'consignment_header_id', 'document_id');
    }

    public function orderHeader()
    {
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'order_header_id', 'document_id');
    }

    public function orderLine()
    {
        return $this->hasOne('App\Models\OM\Api\OrderLines', 'order_line_id', 'document_line_id');
    }

    public function seqEcom()
    {
        return $this->hasOne('App\Models\OM\SequenceEcoms', 'item_id', 'item_id')->where('sale_type_code', 'DOMESTIC');
    }

    public function claimHeader()
    {
        return $this->hasOne('App\Models\OM\ClaimHeader', 'claim_header_id', 'document_id');
    }

    public function claimLine()
    {
        return $this->hasOne('App\Models\OM\ClaimLine', 'claim_line_id', 'document_line_id');
    }
}
