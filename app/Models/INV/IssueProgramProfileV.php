<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueProgramProfileV extends Model
{
    use HasFactory;
    protected $table = 'PTINV_PROGRAM_PROFILES_V';


    public function issueHeader()
    {
        return $this->hasMany('App\Models\INV\IssueHeader', 'organization_id', 'organization_id');
    }

    public function organizationUnits()
    {
        return $this->hasMany('App\Models\INV\OrganizationUnits', 'organization_id', 'organization_id');
    }

}
