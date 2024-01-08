<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipStepV extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_wip_step_v';

    public function routing()
    {
        return $this->belongsTo(RoutingV::class, 'rout_id', 'rout_id');
    }

    public function ptinvUom()
    {
        return $this->belongsTo(PtinvUomV::class, 'uom_code', 'uom_code');
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'organization_code', 'organization_code');
    }
    
    public function openClass()
    {
        return $this->belongsTo(OpenClassV::class, 'wip_step', 'oprn_class');
    }
}
