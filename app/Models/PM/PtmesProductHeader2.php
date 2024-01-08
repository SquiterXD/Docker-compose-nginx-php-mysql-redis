<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtmesProductHeader2 extends Model
{
    use HasFactory;

    protected $table = 'oapm.ptmes_product_header';
    protected $primaryKey = 'batch_id';

    public function manufactureStep()
    {
        return $this->hasMany(PtpmManufactureStep::class, 'department_code', 'department_code');
    }

    //TODO: pls do not add Accessors & Mutators to model. because can affected other page logic
//    public function getUomAttribute($value)
//    {
//        $desc = DB::table('ptinv_uom_v')->where('uom_code', $value)->value('description');
//        return $desc ? $desc : $value;
//    }
}
