<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptLine extends Model
{
	use SoftDeletes;
    protected $table = 'ptw_receipt_lines';
    public $primaryKey = 'receipt_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];

    public function header()
    {
    	return $this->belongsTo('App\Models\IE\Receipt', 'receipt_id');
    }

    public function infos()
    {
        return $this->hasMany('App\Models\IE\ReceiptLineInfo', 'receipt_line_id');
    }

    public function category()
    {
        $receipt = $this->header;
        // $receiptType = $receipt->receipt_type;
        // if($receiptType == 'CLEARING'){
        //     return $this->belongsTo('App\Models\IE\CACategory', 'category_id', 'ca_category_id');
        // }elseif($receiptType == 'REIMBURSEMENT'){
        //     return $this->belongsTo('App\Models\IE\Category', 'category_id');
        // }
        
    	return $this->belongsTo('App\Models\IE\Category','category_id');
    }

    public function subCategory()
    {
        $receipt = $this->header;
        // $receiptType = $receipt->receipt_type;
        // if($receiptType == 'CLEARING'){
        //     return $this->belongsTo('App\Models\IE\CASubCategory', 'sub_category_id', 'ca_sub_category_id');
        // }elseif($receiptType == 'REIMBURSEMENT'){
        //     return $this->belongsTo('App\Models\IE\SubCategory', 'sub_category_id');
        // }

    	return $this->belongsTo('App\Models\IE\SubCategory','sub_category_id');
    }

    public function policy()
    {
        return $this->belongsTo('App\Models\IE\Policy','policy_id');
    }

    public function rate()
    {
        return $this->belongsTo('App\Models\IE\PolicyRate','rate_id');
    }
    
    public function wht()
    {
        return $this->hasOne('App\Models\IE\WHT', 'pay_awt_group_id', 'wht_id');
    }
}
