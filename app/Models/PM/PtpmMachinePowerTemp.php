<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmMachinePowerTemp extends Model
{
    use HasFactory;

    protected $table = 'PTPM_MACHINE_POWER_TEMP';
    public $timestamps = false;

    protected $guarded = [];

    public function asset()
    {
        return $this->hasOne(\App\Models\PM\PteamAssetV::class, 'asset_id', 'machine_id');
    }

    public function scopeGetMachines($query)
    {
        return $query->select('machine_id', 'machine_group','machine_name')
        ->groupBy('machine_id', 'machine_group','machine_name')
        ->orderBy('machine_group');
    }

    public function scopeGetMachinePowers($query)
    {
        return $query->select('machine_id', 'machine_group','machine_name','product_time','uom','power')
        ->groupBy('machine_id', 'machine_group','machine_name','product_time','uom','power')
        ->orderBy('machine_group');
    }

}
