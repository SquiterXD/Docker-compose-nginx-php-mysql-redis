<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenterProductionProcess extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_CC_PRODUCTION_PROCESSES';
    public $primaryKey = "cc_production_process_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];

    /**
	 * Relationship to CostCenters
	 *
	 * @return void
	 */
	public function costCenters()
	{
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'cost_center_id');
	}
}
