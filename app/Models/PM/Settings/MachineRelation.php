<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRelation extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_machine_relation';
    protected $primaryKey = 'machine_relation_id';
    public $timestamps = false;

    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'organization_id', 'organization_id');
    }

    // public function organization()
    // {
    //     return $this->belongsTo(OrganizationCodeV::class, 'organization_id', 'asset_id');
    // }

    public function machineType()
    {
        return $this->belongsTo(MachineType::class, 'machine_type', 'lookup_code');
        // ->where('attribute1', $this->machine_type)
    }
}
