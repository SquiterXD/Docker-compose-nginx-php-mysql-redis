<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdMaterialCostHeader extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_STD_MATERIAL_COST_HEADERS';
    public $primaryKey = "std_head_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];

    public function materialCostLines()
	{
		return $this->hasMany(StdMaterialCostLine::class, 'std_head_id', 'std_head_id')->orderBy('item_number');
	} 
}
