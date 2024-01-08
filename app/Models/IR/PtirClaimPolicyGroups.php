<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IR\PtirClaimApplyDetails;

class PtirClaimPolicyGroups extends Model
{
    use HasFactory;
    protected $table = "ptir_claim_policy_groups";
    public $primaryKey = 'claim_group_id';
    protected $fillable = [
        'claim_header_id',
        'group_header_id',
        'group_code',
        'group_description',
        'group_set_id',
        'policy_set_header_id',
        'policy_set_description',
        'amount',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ]; 

    public function claimPolicyDetail()
    {
        return $this->hasOne(PtirClaimApplyDetails::class, 'claim_group_id', 'claim_group_id');
    }

    public function getClaimGroup($claimHeaderId) {
        $collection = PtirClaimPolicyGroups::select('claim_group_id',
                                                    'claim_header_id', 
                                                    'group_header_id',
                                                    'group_code',
                                                    'group_description',
                                                    'group_set_id',
                                                    'policy_set_header_id',
                                                    'policy_set_description',
                                                    'amount')
                                            ->where('claim_header_id', $claimHeaderId)
                                            ->get();

        return $collection;
    }

    public static function deleteClaimPolicyGroups($claimGroupId) {
        PtirClaimPolicyGroups::where('claim_group_id', $claimGroupId)->delete();
    } 
    
    public static function updateClaimGroup($data) {
        $db = PtirClaimPolicyGroups::find($data['claim_group_id']);
        if (!$db) {
            return;
        }
        $db->group_header_id        = $data['group_header_id'];
        $db->group_code             = $data['group_code'];
        $db->group_description      = $data['group_description'];
        $db->group_set_id           = $data['group_set_id'];
        $db->policy_set_header_id   = $data['policy_set_header_id'];
        $db->policy_set_description = $data['policy_set_description'];
        $db->amount                 = $data['amount'];
        $db->updated_at             = $data['updated_at'];
        $db->last_updated_by        = $data['last_updated_by'];
        $db->last_update_date       = $data['last_update_date'];
        $db->save();
    }

    public function claimPolicySetHeader()
    {
        return $this->hasOne(\App\Models\IR\Settings\PolicySetHeader::class, 'policy_set_header_id', 'policy_set_header_id');
    }
}