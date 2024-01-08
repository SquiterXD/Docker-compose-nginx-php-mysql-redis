<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleTypeV extends Model
{
    use HasFactory;
    protected $table = "ptom_sales_type_v";
    public $primaryKey = null;
    public $timestamps = false;
}