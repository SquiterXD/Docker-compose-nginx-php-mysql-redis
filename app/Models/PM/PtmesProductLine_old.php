<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductLineOld extends Model
{
    use HasFactory;

    protected $table = 'PTMES_PRODUCT_LINE';
    protected $primaryKey ='WIP_STEP';
    protected $fillable = ['transfer_qty','transfer_wip','receive_wip','example_qty'];
    protected $appends =[
        'product_date_format',
        'product_date_original'
    ];

    function getProductDateFormatAttribute()
    {
        if($this->product_date){
            return parseToDateTh($this->product_date);
        }
        return '';
    }

    function getProductDateOriginalAttribute()
    {
        if($this->product_date){
            return parseToDateTh($this->product_date);
        }
        return '';
    }

    public function ptmes_product_distributions()
    {
        return $this->hasMany(PtmesProductDistribution::class,'BATCH_ID');
    }

    public function ptmes_product_header()
    {
        return $this->belongsTo(PtmesProductHeader::class);
    }
}
