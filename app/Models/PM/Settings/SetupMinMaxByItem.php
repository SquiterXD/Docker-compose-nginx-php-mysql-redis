<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupMinMaxByItem extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_setup_min_max_by_item';
    public $primaryKey = 'setup_min_max_id';

    protected $fillable = [ 'setup_min_max_id', 'organization_id', 'subinventory_code', 'locator_id',
                            'inventory_item_id', 'min_qty', 'max_qty', 'program_code', 'created_by', 
                            'creation_date', 'last_updated_by', 'last_update_date'];

    public function organizationsInfo()
    {
        return $this->belongsTo(OrganizationsInfo::class, 'organization_id', 'organization_id');
    }

    public function itemLocationsKfv()
    {
        return $this->belongsTo(ItemLocationsKfv::class, 'locator_id', 'inventory_location_id');
    }

    public function itemNumberV()
    {
        return $this->belongsTo(ItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function tobaccoCatByOrgV()
    {
        return $this->belongsTo(TobaccoCatByOrgV::class, 'organization_id', 'organization_id');
    }
}
