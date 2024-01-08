<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductHeaderv extends Model
{
    use HasFactory;

    protected $table = 'PTMES_PRODUCT_HEADER_V';
    protected $primaryKey = 'BATCH_ID';
    protected $appends =[
        'start_date_format',
        'start_date_original'
    ];

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
        return $this->hasMany(PtmesProductLine::class,'batch_id','batch_id');
    }

}
