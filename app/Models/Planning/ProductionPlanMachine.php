<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlanMachine extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_tab1";
    public $primaryKey = 'product_tab1_id';
}
