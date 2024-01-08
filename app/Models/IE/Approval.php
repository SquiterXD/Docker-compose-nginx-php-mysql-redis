<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use SoftDeletes;
	protected $table = 'ptw_approvals';
    public $primaryKey = 'approval_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];
    protected $casts = [
        'last_approval' => 'boolean',
    ];

	 /**
     * Get all of the owning approvalable models.
     */
    public function approvalable()
    {
        return $this->morphTo();
    }
    
    public function parent()
    {
        if($this->approvalable_type == 'App\Models\IE\CashAdvance'){
            return $this->belongsTo('App\Models\IE\CashAdvance','approvalable_id');
        }elseif($this->approvalable_type == 'App\Models\IE\Reimbursement'){
            return $this->belongsTo('App\Models\IE\Reimbursement','approvalable_id');
        }elseif($this->approvalable_type == 'App\Models\IE\Invoice'){
            return $this->belongsTo('App\Models\IE\Invoice','approvalable_id');
        }else{
            return ;
        }
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
