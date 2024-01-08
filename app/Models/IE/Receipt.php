<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
	use SoftDeletes;
    protected $table = 'ptw_receipts';
    public $primaryKey = 'receipt_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];

     /**
     * Get all of the owning receiptable models.
     */
    public function receiptable()
    {
        return $this->morphTo();
    }
    
    public function employee()
    {
        return $this->belongsTo('App\Models\IE\Employee', 'employee_id');
    }

    public function location(){
        return $this->belongsTo('App\Models\IE\Location','location_id');
    }

    public function scopeProcessType($q, $processType)
    {
        return $q->where('process_type', $processType);
    }

    public function scopeTypeReim($q)
    {
        return $q->processType('REIMBURSEMENT');
    }

    public function vendor()
    {
        // if($this->vendor_id == 'other') return null;
        return $this->hasOne('App\Models\IE\Vendor', 'vendor_id', 'vendor_id')->where('vendor_site_code', $this->vendor_site_code);
    }

    public function parent()
    {
        if($this->receiptable_type == 'App\Models\IE\CashAdvance'){
            return $this->belongsTo('App\Models\IE\CashAdvance','receiptable_id');
        }elseif($this->receiptable_type == 'App\Models\IE\Reimbursement'){
            return $this->belongsTo('App\Models\IE\Reimbursement','receiptable_id');
        }elseif($this->receiptable_type == 'App\Models\IE\Invoice'){
            return $this->belongsTo('App\Models\IE\Invoice','receiptable_id');
        }else{
            return ;
        }
    }

    public function lines()
    {
        return $this->hasMany('App\Models\IE\ReceiptLine','receipt_id')->orderBy('creation_date');
    }

    public function attachments()
    {
        return $this->morphMany('App\Models\IE\Attachment', 'attachmentable');
    }

    public function getReceiptTypeAttribute(){
        if($this->receiptable_type == 'App\Models\IE\CashAdvance'){
            return $this->process_type;
            // return 'CLEARING';
        }elseif($this->receiptable_type == 'App\Models\IE\Reimbursement'){
            return 'REIMBURSEMENT';
        }elseif($this->receiptable_type == 'App\Models\IE\Invoice'){
            return 'INVOICE';
        }else{
            return ;
        }
    }

    public function getExchangeRateForCalAttribute()
    {
        if($this->exchange_rate){
            return $this->exchange_rate;
        }
        return 1;
    }

    public function isNotLock()
    {
        if($this->receiptable_type == 'App\Models\IE\CashAdvance'){
            // CA CLEARING NOT LOCK ON STATUS 'CLEARING_REQUEST'
            return $this->parent->isNotLock();
            // return  in_array($this->parent->status, ['CLEARING_REQUEST', 'NEW_REQUEST']);
        }elseif($this->receiptable_type == 'App\Models\IE\Reimbursement'){
            // REIM NOT LOCK ON STATUS 'NEW_REQUEST','BLOCKED'
            return $this->parent->isNotLock();
        }else{
            return false || \Auth::user()->isAccountantUser();
        }
    }

    public function getTotalAmountAttribute()
    {
        $totalAmount = 0;
        if(count($this->lines)>0){
            $totalAmount = $this->lines->sum('total_amount');
        }
        return $totalAmount;
    }

}
