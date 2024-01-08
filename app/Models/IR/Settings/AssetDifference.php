<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDifference extends Model
{
    use HasFactory;

    protected $table = "oair.ptir_asset_difference";
    public $primaryKey = 'id';

    protected $fillable = ['id', 'asset_id', 'policy_set_header_id', 'active_flag', 'created_by_id', 'created_by', 'last_updated_by']; 

    public function policy()
    {
        return $this->belongsTo(PolicySetHeader::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function asset()
    {
        return $this->belongsTo(AssetDifferenceV::class, 'asset_id', 'asset_id')
                ->where('policy_set_header_id', $this->policy_set_header_id);
    }

    public function scopeSearch($q, $search)
    {
        if ($search) {
            if ($search->policy_set_header_id) {
                $q->where('policy_set_header_id', $search->policy_set_header_id);
            }

            if ($search->asset_id) {
                $q->where('asset_id', $search->asset_id);
            }
        }

        return $q;
    }
}
