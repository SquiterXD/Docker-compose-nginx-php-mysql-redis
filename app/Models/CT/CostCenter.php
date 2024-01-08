<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_COST_CENTERS';
    public $primaryKey = 'cost_center_id';
	public $timestamps = false;
	protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];	

    /**
	 * Relationship to CostCenterProductionProcesss
	 *
	 * @return void
	 */
	public function costCenterProductionProcesss()
	{
		return $this->hasMany(CostCenterProductionProcess::class);
	}

	/**
	 * Get the user that owns the CostCenter
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function costCenterCategory()
	{
		return $this->belongsTo(CostCenterCategory::class, 'cost_center_category_id');
	}

	public function measureVl()
	{
		return $this->belongsTo('App\Models\CT\GetMeasureVl', 'unit_id', 'uom_code')->select('unit_of_measure','uom_code');
	}

	public function productGroups()
	{
		return $this->hasMany(ProductGroup::class, 'cost_center_id', 'cost_center_id');
	}

	public function costCenterOrg()
	{	
		return $this->hasMany(CostCenterOrg::class, 'cost_center_id', 'cost_center_id');
	}
}
