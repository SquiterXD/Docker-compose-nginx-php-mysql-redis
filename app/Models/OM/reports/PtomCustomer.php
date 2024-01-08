<?php

namespace  App\Models\OM\reports;

//----------------------------------------------
//FILE NAME:  PtomCustomer.php gen for Servit Framework Model
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2022-01-25(Tue)  00:11:31

//----------------------------------------------


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use DB;

class PtomCustomer extends Model
{
        protected    $table='PTOM_CUSTOMERS';
        protected    $primaryKey='id';
        protected    $guarded = array('id');
        protected    $fillable = [];
        protected    $hidden = []; //สำหรับใส่ mutations
        protected    $appends = [];
        protected    $with = [];
        protected    $connection = '';

}