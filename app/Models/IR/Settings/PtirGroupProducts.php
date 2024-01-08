<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGroupProducts extends Model
{
    use HasFactory;

    protected $table = 'PTIR_GROUP_PRODUCTS';
    public $primaryKey = 'group_product_id';
    public $timestamps = false;
    private $limit = 50;

    protected $fillable = [
        'group_product_id', 'policy_set_header_id', 'asset_group_code', 'description', 'account_id',
        'active_flag', 'attribute1', 'attribute2', 'attribute3', 'attribute4', 'attribute5',
        'attribute6', 'attribute7', 'attribute8', 'attribute9', 'attribute10', 'attribute11',
        'attribute12', 'attribute13', 'attribute14', 'attribute15', 'program_code', 'created_at',
        'updated_at', 'deleted_at', 'created_by_id', 'updated_by_id', 'deleted_by_id',
        'created_by', 'last_updated_by', 'creation_date', 'last_update_date', 'web_batch_no',
        'interfaced_msg', 'interface_status'
    ];

    public function getAccountId($policyId, $assetGroupCode, $description)
    {
        $collection = PtirGroupProducts::select('account_id')
        ->where('policy_set_header_id', $policyId)
        ->where('asset_group_code', $assetGroupCode)
        ->where('description', $description)
        ->first();

        return $collection;
    }

    public function policySetHeaders() 
    {
        return $this->hasOne(PtirPolicySetHeaders::class, 'policy_set_header_id' ,'policy_set_header_id');
    }

    public function mappingAcc() 
    {
        return $this->hasOne(PtirAccountsMapping::class, 'account_id' ,'account_id');
    }

    public function assetGroup() 
    {
        return $this->hasOne(PtirAssetGroupV::class, 'value' ,'asset_group_code');
    }

    public function scopeSearch($q, $request)
    {    
        if ($request){
            
            if ($request['policy'] != null) {
                $q->where('policy_set_header_id', $request['policy'])->get();
            } else {
                $q;
            }

            if ($request['assetGroup'] != null) {
                $q->where('asset_group_code', $request['assetGroup'])->get();
            } else {
                $q;
            }

            if ($request['description'] != null) {
                $q->where('description', 'like', '%'.$request['description'].'%')->get();
            } else {
                $q;
            }

            if ($request['status'] != null) {
                $q->where('active_flag', $request['status'])->get();
            } else {
                $q;
            }

        }

        return $q;
    }

    public function accountMap()
    {
        return $this->hasOne(PtirAccountsMapping::class, 'account_id', 'account_id');
    }

    public function updateActiveFlag($id, $flag, $userId) 
    {
        $db = PtirGroupProducts::find($id);
        $db->ACTIVE_FLAG      = $flag;
        $db->LAST_UPDATED_BY  = $userId;
        $db->LAST_UPDATE_DATE = now();
        $db->save();
    }
}
