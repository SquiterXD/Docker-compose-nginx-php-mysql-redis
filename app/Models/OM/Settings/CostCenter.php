<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_cost_center_v";
    // public $primaryKey = 'cost_center_code';

    public function getDesciption($code, $departmentCode)
    {
        $collection = CostCenter::where('meaning', $code)
                                ->where('department_code', $departmentCode)
                                ->first();

        return $collection->description ?? null;
    }


}
