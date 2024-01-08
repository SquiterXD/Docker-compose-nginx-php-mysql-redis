<?php

    namespace  App\Models\OM\reports;

//----------------------------------------------
//FILE NAME:  PtomOrderLine.php gen for Servit Framework Model
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2022-01-24(Mon)  22:09:14

//----------------------------------------------


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use DB;

class PtomOrderLine extends Model
{
        protected    $table='ptom_order_lines';
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

    }