<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class CashAdvanceInfo extends Model
{
    protected $table = 'ptw_cash_advance_infos';
    public $primaryKey = 'cash_advance_info_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];

    public function cashAdvance(){
    	return $this->belongsTo('App\Models\IE\CashAdvance','cash_advance_id');
    }

    public function subCategory(){
    	return $this->belongsTo('App\Models\IE\CASubCategory','ca_sub_category_id');
    }

    public function subCategoryInfo(){
    	return $this->belongsTo('App\Models\IE\CASubCategoryInfo','ca_sub_category_info_id');
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
