<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaxStorage extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_max_storage';
    protected $primaryKey = 'id';
    public $timestamps = false;
    

    public function organization()
    {
        return $this->hasOne(\App\Models\OrgOrganizationDefinition::class, 'organization_id', 'organization_id');
    }

    public function itemGroup()
    {
        return $this->hasOne(ItemGroup::class, 'item_cat_code', 'item_cat_code');
    }

    public function uom()
    {
        return $this->hasOne(PtinvUomV::class, 'uom_code', 'uom_code');
    }
}
