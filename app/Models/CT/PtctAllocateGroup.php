<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;

class PtctAllocateGroup extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_GROUP';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'allocate_year_id'
        ,'allocate_group'
        ,'allocate_group_code'
        ,'level_no'
        ,'allocate_type'
        ,'dept_code'
        ,'cost_code'
        ,'product_group'
        ,'target_account_code'
        ,'target_acc_code'
        ,'target_sub_acc_code'
        ,'account_code'
        ,'acc_segment1'
        ,'acc_segment2'
        ,'acc_segment3'
        ,'acc_segment4'
        ,'acc_segment5'
        ,'acc_segment6'
        ,'acc_segment7'
        ,'acc_segment8'
        ,'acc_segment9'
        ,'acc_segment10'
        ,'acc_segment11'
        ,'acc_segment12'
        ,'program_code'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
        ,'created_by_id'
        ,'updated_by_id'
        ,'deleted_by_id'
        ,'created_by'
        ,'creation_date'
        ,'last_update_date'
        ,'last_updated_by'
        ,'last_update_login'
        ,'quantity'
        ,'ratio_rate'
        ,'comments'
        ,'validate_msg'
    ];

    protected function setKeysForSaveQuery($query)
    {
        // $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('allocate_year_id', $this->getAttribute('allocate_year_id'))
            ->where('allocate_group_code', $this->getAttribute('allocate_group_code'))
            ->where('target_account_code', $this->getAttribute('target_account_code'));

        return $query;
    }

}
