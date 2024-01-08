<?php

namespace  App\Models\OM\reports;

//----------------------------------------------
//FILE NAME:  Untitled-1 gen for Servit Framework Model
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2022-01-25(Tue)  00:40:05

//----------------------------------------------


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OM\reports\PtomOrderHeader;
//use DB;

class PtomCustomerShipSite extends Model
{
        protected    $table='PTOM_CUSTOMER_SHIP_SITES';
        protected    $primaryKey='id';
        protected    $guarded = array('id');
        protected    $fillable = [];
        protected    $hidden = []; //สำหรับใส่ mutations
        protected    $appends = [];
        protected    $with = [];
        protected    $connection = '';

        public function orders(){
            return $this->hasMany(PtomOrderHeader::class,'ship_to_site_id','ship_to_site_id');
        }
}