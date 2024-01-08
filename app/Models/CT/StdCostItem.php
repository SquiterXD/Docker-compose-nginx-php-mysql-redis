<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCostItem extends Model
{
    use HasFactory;

    protected $table = 'OACT.ptct_std_cost_items';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
}
