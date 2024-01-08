<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtmesProductHeader extends Model
{
    use HasFactory;
    protected $table = 'ptmes_product_header';
    protected $primaryKey = 'batch_id';
    protected $casts = ['start_date' => 'datetime:d/m/Y'];
    protected $guarded = [];
    protected $appends =[
        'start_date_format',
        'start_date_original'
    ];

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

    function getStartDateFormatAttribute()
    {
        if($this->start_date){
            return parseToDateTh($this->start_date);
        }
        return '';
    }

    function getStartDateOriginalAttribute()
    {
        if($this->start_date){
            return $this->start_date;
        }
        return '';
    }


    public function ptmes_product_lines()
    {
        return $this->hasMany(PtmesProductLine::class,'batch_id');
    }

}
