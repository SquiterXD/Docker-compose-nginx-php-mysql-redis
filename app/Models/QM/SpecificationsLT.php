<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificationsLT extends Model
{
    use HasFactory;
    protected $table  = 'PTQM_SPECIFICATIONS_L_T';
    protected $primaryKey = 'QM_SPEC_LINE_ID';

    public function createData($header, $spec, $seq, $recordType, $batchNo, $profile, $user, $sysdate)
    {
        $line                       = new self;
        $line->qm_spec_id           = $header->qm_spec_id ;
        $line->line_number          = $seq;
        $line->test_id              = optional($spec)->test_id ?? null;
        $line->min_value            = optional($spec)->min_value ?? null;
        $line->max_value            = optional($spec)->max_value ?? null;
        $line->qc_unit_code         = optional($spec)->test_unit ?? null;
        $line->low_level_minor      = optional($spec)->low_level_minor ?? null;
        $line->low_level_major      = optional($spec)->low_level_major ?? null;
        $line->low_level_critical   = optional($spec)->low_level_critical ?? null;
        $line->high_level_minor     = optional($spec)->high_level_minor ?? null;
        $line->high_level_major     = optional($spec)->high_level_major ?? null;
        $line->high_level_critical  = optional($spec)->high_level_critical ?? null;
        $line->optional_flag        = $spec->optional_ind ? 'Y' : 'N';
        $line->record_type          = $recordType;
        $line->optimal_value        = optional($spec)->optimal_value ?? null;
        $line->attribute8           = optional($spec)->evaluation_flag == 'true' ? 'Y' : 'N';
        $line->web_batch_no         = $batchNo;
        $line->program_code         = $profile->program_code;
        $line->created_by_id        = $user->user_id;
        $line->updated_by_id        = $user->user_id;
        $line->created_by           = $user->fnd_user_id;
        $line->creation_date        = $sysdate;
        $line->last_updated_by      = $user->fnd_user_id;
        $line->last_update_date     = $sysdate;
        $line->save();
    }
}
