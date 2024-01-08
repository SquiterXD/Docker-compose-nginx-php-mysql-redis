<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlParameters extends Model
{
    use HasFactory;
    protected $table = "mtl_parameters";

    public function secondaryInventory()
    {
        return $this->belongsTo('App\Models\INV\SecondaryInventory', 'organization_id', 'organization_id');
    }

    public function systemItem()
    {
        return $this->belongsTo('App\Models\INV\SystemItemB', 'organization_id', 'organization_id');
    }

    public function organizationUnit()
    {
        return $this->belongsTo('App\Models\INV\OrganizationUnits', 'organization_id', 'organization_id');
    }
}
