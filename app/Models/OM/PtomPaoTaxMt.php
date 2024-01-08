<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Model;

class PtomPaoTaxMt extends Model
{
    protected $table = "ptom_pao_tax_mt";
    public $primaryKey = 'pao_tax_mt_id';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    public function interfaces()
    {
        return $this->hasMany('App\Models\OM\TranspotReportModel', 'web_batch_no', 'ap_web_batch_no');
    }

    public function glinterfaces()
    {
        return $this->hasMany('App\Models\OM\GLInterfaceModel', 'web_batch_no', 'gl_web_batch_no');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function province()
    {
        return $this->hasOne('App\Models\OM\PrepareSaleOrder\ThailandTerritoryModel', 'province_id', 'province_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\OM\Promotions\Oaom\Itemv', 'inventory_item_id', 'item_id');
    }

    public function uomV()
    {
        return $this->hasOne('App\Models\OM\Promotions\UomV', 'uom_code', 'uom_code');
    }

    public function getMonthTh()
    {
        $monthLists = [
            '1' => 'มกราคม',
            '2' => 'กุมภาพันธ์',
            '3' => 'มีนาคม',
            '4' => 'เมษายน',
            '5' => 'พฤษภาคม',
            '6' => 'มิถุนายน',
            '7' => 'กรกฎาคม',
            '8' => 'สิงหาคม',
            '9' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];

        $this->month_no;

        return $monthLists[$this->month_no];
    }
}
