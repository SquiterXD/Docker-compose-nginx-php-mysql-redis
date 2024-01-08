<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmPrintMachineV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRINT_MACHINE_V';
    public $timestamps = false;

    protected $guarded = [];

    public function asset()
    {
        return $this->hasOne(\App\Models\PM\PteamAssetV::class, 'asset_id', 'machine_id');
    }

    public function scopeGetMachines($query)
    {
        return $query->select('machine_id', 'machine_group','machine_name', 'print_type')
        ->groupBy('machine_id', 'machine_group','machine_name', 'print_type')
        ->orderBy('machine_group');
    }

    public function scopeGetMachinePowers($query)
    {
        return $query->select('machine_id', 'machine_group','machine_name','product_time','uom','power', 'print_type')
        ->groupBy('machine_id', 'machine_group','machine_name','product_time','uom','power', 'print_type')
        ->orderBy('machine_group');
    }

}
