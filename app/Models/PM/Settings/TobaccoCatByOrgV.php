<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TobaccoCatByOrgV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_tobacco_cat_by_org_v';
    public $primaryKey = false;
    public $timestamps = false;

    public function organization()
    {
        return $this->belongsTo(OrganizationsInfo::class, 'organization_id', 'organization_id');
    }

    public function parameter()
    {
        return $this->belongsTo(Parameters::class, 'organization_id', 'organization_id');
    }

}
