<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupLot extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_PRODUCT_GROUP_LOTS';

    public $primaryKey = 'product_group_lot_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    
	protected $guarded = [];
}
