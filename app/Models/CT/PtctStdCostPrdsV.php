<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdCostPrdsV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STD_COST_PRDS_V';
    public $timestamps = false;

    protected $guarded = [];

}
