<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class SubGroups extends Model
{
    use HasFactory;
    protected $table = "ptir_sub_groups";
    public $primaryKey = 'sub_group_id';
    protected $softDelete = true;
    public $timestamps = false;

    protected $fillable = [
        'sub_group_id', 'policy_set_header_id', 'policy_set_number', 'policy_set_description',
        'sub_group_code', 'sub_group_description', 'sub_group_source', 'active_flag', 'program_code',
        'created_at', 'updated_at', 'created_by_id', 'created_by', 'last_updated_by', 
        'creation_date', 'last_update_date'
    ];

    public function scopeSearch($q, $request)
    {
        if($request){
            if ($request['policy_set_header_id'] != null) {
                $q->where('policy_set_header_id', $request['policy_set_header_id'])->get();
            } else {
                $q;
            }
        }
        return $q;
    }

    public function policySetHeaders()
    {
        return $this->belongsTo(PtirPolicySetHeaders::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function updateActiveFlag($id, $flag, $userId) 
    {
        $db                     = SubGroups::find($id);
        $db->ACTIVE_FLAG        = $flag;
        $db->LAST_UPDATED_BY    = $userId;
        $db->LAST_UPDATE_DATE   = now();
        $db->save();
    }
}
