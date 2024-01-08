<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'ptw_sub_categories';
    public $primaryKey = 'sub_category_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $casts = [
        'org_options'   => 'array',
    ];


    public function accessibleOrgs()
    {
        return $this->morphMany(AccessibleOrg::class, 'accessible_orgable');
    }

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function infos(){
        return $this->hasMany('App\SubCategoryInfo','sub_category_id');
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

    public function scopeAdvanceOver($query){
        return $query->where('name',config('services.sub_category.advance_over_name'));
    }

    public function isAdvanceOver(){
        return $this->name == config('services.sub_category.advance_over_name');
    }

    public function getCombinationCodeAttribute()
    {
        return $this->company_code.'.'.$this->evm_code.'.'.$this->department_code.'.'.$this->cost_center_code.'.'.$this->budget_year_code.'.'.$this->budget_type_code.'.'.$this->budget_detail_code.'.'.$this->budget_reason_code.'.'.$this->account_code.'.'.$this->sub_account_code.'.'.$this->reserve1_code.'.'.$this->reserve2_code;
    }

}
