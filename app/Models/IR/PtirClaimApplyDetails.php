<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IR\PtirClaimPolicyGroups;
use App\Models\IR\PtirClaimApplyCompany;

class PtirClaimApplyDetails extends Model
{
    use HasFactory;
    protected $table = "ptir_claim_apply_details";
    public $primaryKey = 'claim_detail_id';
    protected $fillable = [
        'claim_apply_id',
        'line_number',
        'line_description',
        'line_amount',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'claim_header_id',
        'claim_group_id'
    ];

    public function claimPolicyGroup()
    {
        return $this->hasOne(PtirClaimPolicyGroups::class, 'claim_group_id', 'claim_group_id');
    }

    public function claimApplyCompany()
    {
        return $this->hasMany(PtirClaimApplyCompany::class, 'claim_detail_id', 'claim_detail_id');
    }

    public function getClaimApplyDetail($id)
    {
        $collection = PtirClaimApplyDetails::select('claim_detail_id', 'line_number', 'line_amount', 'line_description')
                                            ->where('claim_apply_id', $id)
                                            ->get();

        return $collection;
    }

    public static function updateApplyDetail($data)
    {
        $db = PtirClaimApplyDetails::find($data['claim_detail_id']);
        $db->line_description     = $data['line_description'];
        $db->line_number          = $data['line_number'];
        $db->line_amount          = $data['line_amount'];
        $db->updated_at           = $data['updated_at'];
        $db->last_updated_by      = $data['last_updated_by'];
        $db->last_update_date     = $data['last_update_date'];
        $db->save();
    }

    public static function deleteClaimApplyDetail($applyId)
    {
        PtirClaimApplyDetails::where('claim_apply_id', $applyId)->delete();
    }

    public function claimHeader()
    {
        return $this->belongsTo(PtirClaimHeader::class, 'claim_header_id', 'claim_header_id');
    }
}
