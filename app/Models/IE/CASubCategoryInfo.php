<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class CASubCategoryInfo extends Model
{
    protected $table = 'ptw_ca_sub_category_infos';
    public $primaryKey = 'casub_cate_info_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];
    
	public function category(){
    	return $this->belongsTo('App\Models\IE\CACategory','ca_category_id');
    }

    public function subCategory(){
    	return $this->belongsTo('App\Models\IE\CASubCategory','ca_sub_category_id');
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public static function getlistFormTypes()
    {
    	$lists = [
	    			'text'		=>	'Text',
	    			'select'	=>	'List of value',
	    			'date'		=>	'Date picker'
	    		];

    	return $lists;
    }

    public function getInputFormValueAttribute()
    {
        if(!$this->form_value){ return ''; }

        if($this->form_type == 'date'){

            return dateFormatDisplay(implode(', ', json_decode($this->form_value)));

        }elseif($this->form_type == 'select'){

            $arrResult = [];
            $arrFormValue = json_decode($this->form_value);
            foreach ($arrFormValue as $key => $formValue) {
                $arrResult[$formValue] = $formValue;
            }
            return $arrResult;

        }else{ // text

            return implode(', ', json_decode($this->form_value));
            
        }
    }
}
