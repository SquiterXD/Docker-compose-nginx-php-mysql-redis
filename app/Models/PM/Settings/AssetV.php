<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetV extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_asset_v';
    // protected $table  = 'pteam_asset_v';
    protected $primaryKey = 'asset_id';
    protected $appends = [
        'machine_speed_unit',
    ];

    public function getMachineSpeedUnitAttribute()
    {
        if ($this->wip_step_desc) {
            return (new \App\Repositories\PM\MachineRelationRepository)->getMachineSpeedUnit($this->wip_step_desc);
        }

        return '';
    }
}
