<?php

namespace App\Models\OM\SaleConfirmation;

use App\Models\OM\SequenceEcoms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PROFORMA_INVOICE_LINES';
    public $primaryKey = 'PI_LINE_ID';
    public $timestamps = false;


    public function sequenceEcoms() {
        return $this->belongsTo(SequenceEcoms::class, 'item_code', 'item_code');
    }

    public function onHands()
    {
        return $this->hasMany('App\Models\OM\OnHandV', 'item_code', 'item_code')->orderBy('lot_number');
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockLines', 'issueable');
    }
}
