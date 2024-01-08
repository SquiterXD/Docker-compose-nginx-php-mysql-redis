<?php

namespace App\Models\Ptom;

use App\Models\OM\AttachFiles;
use App\Models\OM\Promotions\UomV;
use App\Models\OM\SequenceEcoms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomClaimLine extends Model
{
    use HasFactory;
    protected $table = "ptom_claim_lines";
    public $primaryKey = 'claim_line_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];

    public function sequence_ecoms() 
    {
        return $this->belongsTo(SequenceEcoms::class, 'item_code', 'item_code');
    }

    public function uom_description() 
    {
        return $this->belongsTo(UomV::class, 'uom_code','uom_code');
    }
    public function orderLine() {
        return $this->belongsTo(PtomOrderLine::class, 'order_line_id', 'order_line_id');
    }

    public function enter_uom_description() 
    {
        return $this->belongsTo(UomV::class, 'enter_claim_uom','uom_code');
    }
    public function attachment() {
        return $this->hasMany(AttachFiles::class, 'line_id', 'claim_line_id');
    }
}
