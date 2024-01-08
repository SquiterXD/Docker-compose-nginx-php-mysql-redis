<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class CACategory extends Model
{
    protected $table = 'ptw_ca_categories';
    public $primaryKey = 'ca_category_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];
	
    public function scopeActive($query){
        return $query->where('active',true);
    }
}
