<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctOemCostHeaderV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_OEM_COST_HEADERS_V';
	protected $primaryKey   = 'oem_cost_header_id';
    public $timestamps = false;

    protected $guarded = [];

    /**
	 * Relationship to lines
	 *
	 * @return void
	 */
	public function lines()
	{
		return $this->hasMany(PtctOemCostLineV::class, 'oem_cost_header_id');
	}

}
