<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductDistribution_old extends Model
{
    use HasFactory;

    protected $table = 'PTMES_PRODUCT_DISTRIBUTION';
    protected $primaryKey = 'BATCH_ID';

    protected $fillable=[
        'result_qty_01',
        'result_qty_02',
        'result_qty_03',
        'result_qty_04',
        'loss_qty',
        'result_loss_qty',
        'sample_qty',
        'product_qty'
    ];

    protected $appends =[
        'product_date_format'
    ];

    function getProductDateFormatAttribute()
    {
        if($this->product_date){
            return parseToDateTh($this->product_date);
        }
        return '';
    }

    public function ptmes_product_line()
    {
        return $this->belongsTo(PtmesProductLine::class);
    }
}
