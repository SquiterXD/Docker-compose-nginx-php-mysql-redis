<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class PtomPaoPercent extends Model
{
    protected $table = "ptom_pao_percent";
    public $primaryKey = 'pao_percent_id';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function province()
    {
        return $this->hasOne('App\Models\OM\Api\TerritoryV', 'province_id', 'province_id');
    }

    public function getCustomerNameAttribute()
    {
        return optional($this->customer)->customer_name;
    }

}
