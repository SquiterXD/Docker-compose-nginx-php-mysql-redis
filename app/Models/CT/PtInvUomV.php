<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtInvUomV extends Model
{

    use HasFactory;

    protected $table = 'PTINV_UOM_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListUomCodes($query)
    {
        return $query->select(DB::raw("uom_code as uom_code_value, unit_of_measure as uom_code_label, uom_code, description, unit_of_measure"))
            ->groupBy('uom_code', 'description', 'unit_of_measure');

    }
}
