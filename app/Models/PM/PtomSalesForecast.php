<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtomSalesForecast extends Model
{
    use HasFactory;

    protected $table = 'PTOM_SALES_FORECAST';
    public $timestamps = false;

    protected $guarded = [];

}
