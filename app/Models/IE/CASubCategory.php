<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class CASubCategory extends Model
{
    protected $table = 'ptw_ca_sub_categories';
    public $primaryKey = 'ca_sub_category_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];

    public function accessibleOrgs()
    {
        return $this->morphMany('App\Models\IE\AccessibleOrg', 'accessible_orgable');
    }

    public function category(){
    	return $this->belongsTo('App\Models\IE\CACategory','ca_category_id');
    }

    public function infos(){
        return $this->hasMany('App\Models\IE\CASubCategoryInfo','ca_sub_category_id');
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public function scopeAccessibleOrg($query, $orgId = null){
        if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        return $query->whereHas('accessibleOrgs', function ($query1) use ($orgId) {
            $query1->where('org_id', $orgId);
        });
    }

    public function scopeOnDateActive($query){

        $now = date('Y-m-d');

        $query->where('start_date','<=',$now);
        $query->whereNull('end_date');
        $query->orWhere(function ($query) use ($now) {
            $query->whereNotNull('end_date');
            $query->where('end_date','>=',$now);
        });


        return $query;
    }
}
