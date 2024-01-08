<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPeriod extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PRODUCT_PERIOD';
    public $primaryKey = false;
    public $timestamps = 'lookup_code';
}
