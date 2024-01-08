<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRate extends Model
{
    use HasFactory;

    protected $table = 'ptom_delivery_rates';
    public $primaryKey = 'delivery_rate_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'delivery_rate_name',
        'rate_start_date',
        'rate_end_date',
        'cigarette_delivery_rates',
        'leaf_delivery_rates',
        'other_delivery_rates',
        'oil_price_date',
        'oil_price',
        'program_code',
        'created_by',
        'last_updated_by',
    ];
}
