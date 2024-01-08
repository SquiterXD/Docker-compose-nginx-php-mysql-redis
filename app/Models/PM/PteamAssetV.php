<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PteamAssetV extends Model
{
    use HasFactory;

    protected $table = 'PTEAM_ASSET_V';
    public $timestamps = false;

    protected $guarded = [];

    public function eamPlanLines()
    {
        return $this->hasMany(\App\Models\PM\PteamPmPlanLine::class, 'asset_number', 'asset_number');
    }

    public function scopeFilterAsset($q)
    {
        return $q->whereRaw(" asset_id in (select machine_id from ptpm_print_machine_group)");
    }
}
