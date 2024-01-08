<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductDistribution extends Model
{
    use HasFactory;

    protected $table = 'ptmes_product_distribution';
    // protected $primaryKey = ['inventory_item_id', 'organization_code'];
    protected $casts = ['product_date' => 'datetime:d/m/Y'];
    protected $primaryKey = 'BATCH_ID';

    protected $fillable=[
        'result_qty_01',
        'result_qty_02',
        'result_qty_03',
        'result_qty_04',
        'loss_qty',
        'result_loss_qty',
        'sample_qty',
        'product_qty',
        'attribute2'
    ];

    protected $appends =[
        'product_date_format',
        'product_date_original'
    ];

    public function getTransactionFlagAttribute($value)
    {
        return $value === 'Y';
    }

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
            return $this->product_date->format('Y-m-d');
        }
        return '';
    }

    public function ptmes_product_line()
    {
        return $this->belongsTo(PtmesProductLine::class);
    }
}
