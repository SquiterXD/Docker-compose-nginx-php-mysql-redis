<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdRawMeterialCostHead extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_STD_RM_COST_HEADS';
    public $primaryKey = "std_rm_ch_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];

    public function stdRawMaterialCostLines()
	{
		return $this->hasMany(StdRawMeterialCostLine::class, 'std_rm_ch_id', 'std_rm_ch_id');
	} 
}
