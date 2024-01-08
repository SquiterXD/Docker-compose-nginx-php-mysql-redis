<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenterCategory extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_COST_CENTER_CATEGORIES';
    public $primaryKey = 'cost_center_category_id';

    protected $guarded = [];
}
