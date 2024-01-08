<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupItem extends Model
{
    use HasFactory;
    protected $table = 'OACT.ptct_prdgrp_plan_items_v';

    public $primaryKey = 'prdgrp_year_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    
	protected $guarded = [];
}

