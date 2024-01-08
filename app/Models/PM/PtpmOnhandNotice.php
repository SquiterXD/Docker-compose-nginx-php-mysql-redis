<?php

namespace App\Models\PM;

use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\PM\PtInvUomV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmOnhandNotice extends Model
{
    use HasFactory;
    protected $table        = 'ptpm_onhand_notice';
    public $incrementing    = false;
    public $timestamps      = false;
    public function uomV() {
        return $this->belongsTo(PtInvUomV::class, 'uom2','uom_code');
    }
    public function uomVP() {
        return $this->belongsTo(PtInvUomV::class, 'primary_uom_code','uom_code');
    }
    public function log() {
        return $this->belongsTo(PtpmOnhandLog::class, 'inventory_item_id', 'inventory_item_id');
    }

    

}
