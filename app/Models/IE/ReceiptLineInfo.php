<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptLineInfo extends Model
{
    // use SoftDeletes;
    protected $table = 'ptw_receipt_line_infos';
    // protected $dates = ['deleted_at'];
    public $primaryKey = 'receipt_line_info_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function header(){
    	return $this->belongsTo('App\Models\IE\Receipt','receipt_id');
    }

    public function line(){
    	return $this->belongsTo('App\Models\IE\ReceiptLine','receipt_id');
    }

    public function subCategory(){
    	return $this->belongsTo('App\Models\IE\SubCategory','sub_category_id');
    }

    public function subCategoryInfo(){
    	return $this->belongsTo('App\Models\IE\SubCategoryInfo','sub_category_info_id');
    }

    public function getDescriptionForShowAttribute()
    {
        if($this->subCategoryInfo->form_type == 'date'){

            return $this->description ? dateFormatDisplay($this->description) : '-';

        // }else if($this->subCategoryInfo->form_type == 'select'){ // select
        //     $result = '-';
        //     $inputFormValue = $this->subCategoryInfo->input_form_value;
        //     if( array_key_exists($this->description, $inputFormValue) ){
        //         $result = $inputFormValue[$this->description];
        //     }
        //     return $result;
            
        }else{ // text

            return $this->description ? $this->description : '-';

        }
    }
}
