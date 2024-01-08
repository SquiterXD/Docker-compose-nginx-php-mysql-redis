<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    use HasFactory;
    protected $table = "ptir_group_products";
    public $primaryKey = 'group_product_id';

    protected $fillable = ['group_product_id', 'policy_set_header_id', 'asset_group_code', 'description',
                            'account_id', 'active_flag'];                                   
                            
    public function policySetHeader()
    {
        return $this->belongsTo(PolicySetHeader::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function accountsMapping()
    {
        return $this->belongsTo(PtirAccountsMapping::class, 'account_id', 'account_id');
    }

    public function assetGroup()
    {
        return $this->belongsTo(AssetGroupV::class, 'asset_group_code', 'value');
    }

    public function updateActiveFlag($id, $flag, $userId) 
    {
        $db = GroupProduct::find($id);
        $db->ACTIVE_FLAG      = $flag;
        $db->LAST_UPDATED_BY  = $userId;
        $db->LAST_UPDATE_DATE = now();
        $db->save();
    }
    
}
