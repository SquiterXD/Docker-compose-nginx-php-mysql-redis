<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;

class PtctAllocateTarget extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_TARGET';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'allocate_year_id'
        ,'allocate_group_code'
        ,'target_account_code'
        ,'target_code'
        ,'target_dept_code'
        ,'target_cc_code'
        ,'target_product_group'
        ,'quantity'
        ,'ratio_rate'
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
    ];

    protected function setKeysForSaveQuery($query)
    {
        // $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('allocate_year_id', $this->getAttribute('allocate_year_id'))
            ->where('allocate_group_code', $this->getAttribute('allocate_group_code'))
            ->where('target_account_code', $this->getAttribute('target_account_code'))
            ->where('target_code', $this->getAttribute('target_code'));

        return $query;
    }

}
