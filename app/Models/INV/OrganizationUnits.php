<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUnits extends Model
{
    use HasFactory;
    protected $table = 'hr_organization_units';

    public function parameters()
    {
        return $this->hasMany('App\Models\INV\MtlParameters', 'organization_id', 'organization_id');
    }

    public function issueProgramProfileV()
    {
        return $this->belongsTo('App\Models\INV\IssueProgramProfileV', 'organization_id', 'organization_id');
    }
}
