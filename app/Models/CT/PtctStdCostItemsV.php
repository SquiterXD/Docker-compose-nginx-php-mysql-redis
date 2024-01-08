<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdCostItemsV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STD_COST_ITEMS_V';
    public $timestamps = false;

    protected $guarded = [];

}
