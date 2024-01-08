<?php

namespace App\Models\OM\Rma\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomClaimLines extends Model
{
    use HasFactory;
    protected $table = 'PTOM_CLAIM_LINES';
    protected $primaryKey = 'CLAIM_LINE_ID';
    public $timestamps = true;

    protected $fillable = [
        'CLAIM_LINE_ID'
        ,'ITEM_ID'
        ,'ITEM_CODE'
        ,'ITEM_DESCRIPTION'
        ,'ORDER_QUANTITY'
        ,'UOM_CODE'
        ,'ORDER_LINE_ID'
        ,'PROGRAM_CODE'
        ,'CREATED_BY'
        ,'CREATION_DATE'
        ,'LAST_UPDATED_BY'
        ,'LAST_UPDATE_DATE'
        ,'INTERFACED_MSG'
        ,'INTERFACE_STATUS'
        ,'RMA_LINE_NO'
        ,'RMA_QUANTITY'
        ,'RMA_UOM_CODE'
        ,'ENTER_RMA_QUANTITY'
        ,'ENTER_RMA_UOM'
        ,'RMA_QUANTITY_CBB'
        ,'RMA_QUANTITY_CARTON'
        ,'RMA_QUANTITY_PACK'
    ];

    public function ptomClaimHeader()
    {
        return $this->belongsTo(PtomClaimHeaders::class);
    }
}
