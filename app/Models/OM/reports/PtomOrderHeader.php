<?php

namespace  App\Models\OM\reports;

//----------------------------------------------
//FILE NAME:  PtomOrderHeader.php gen for Servit Framework Model
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2022-01-24(Mon)  22:08:40

//----------------------------------------------


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use DB;

class PtomOrderHeader extends Model
{
        protected    $table='ptom_order_headers';
        protected    $primaryKey='id';
        protected    $keyType = 'string';
        public       $timestamps = false;
        protected    $dateFormat = 'U';
        protected    $guarded = array('id');
        protected    $fillable = [];
        protected    $hidden = []; //สำหรับใส่ mutations
        protected    $appends = [];
        protected    $with = [];
        protected    $connection = '';

        public function customer(){
            return $this->hasOne(PtomCustomer::class,'customer_id','customer_id');
        }

        public function shipsite(){
            return $this->hasOne(PtomCustomerShipSite::class,'ship_to_site_id','ship_to_site_id');
        }


}