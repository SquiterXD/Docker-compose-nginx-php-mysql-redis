<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProductPeriod extends Model
{
    use HasFactory;

    protected $table = 'ptpm_product_period';
    protected $primaryKey ='lookup_code';

}
