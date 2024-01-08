<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdRawMeterialCostLine extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_STD_RM_COST_LINES';
    public $primaryKey = "std_rm_cl_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];
}
