<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomClaimHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CLAIM_HEADERS';
    protected $primaryKey = 'CLAIM_HEADER_ID';
    public $timestamps = true;

    protected $fillable = [
        'CLAIM_HEADER_ID'
        ,'INVOICE_ID'
        ,'INVOICE_DATE'
        ,'CUSTOMER_ID'
        ,'SOURCE_SYSTEM'
        ,'REMARK_SOURCE_SYSTEM'
        ,'SHIP_TO_SITE_ID'
        ,'SYMPTOM_DESCRIPTION'
        ,'PROGRAM_CODE'
        ,'CREATED_BY'
        ,'CREATION_DATE'
        ,'LAST_UPDATED_BY'
        ,'LAST_UPDATE_DATE'
        ,'RMA_NUMBER'
        ,'RMA_DATE'
        ,'STATUS_RMA'
        ,'CREDIT_NOTE_NUMBER'
        ,'SALES_TYPE'
        ,'RMA_CANCEL_REASON'
    ];

    public function ptomClaimLines()
    {
        return $this->hasMany(PtomClaimLines::class,'CLAIM_HEADER_ID','CLAIM_HEADER_ID');
    }
}
