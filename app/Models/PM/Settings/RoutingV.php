<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutingV extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_routing_v';
    protected $primaryKey = 'routing_id';

    public function wipSteps()
    {
        return $this->hasMany(WipStepV::class, 'rout_id', 'routing_id');
    }

    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'organization_code', 'organization_code');
    }
}
