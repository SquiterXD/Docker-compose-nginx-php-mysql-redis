<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListLine extends Model
{
    use HasFactory;

    protected $table = "PTOM_PRICE_LIST_LINE_V";
    public $primaryKey = 'LIST_LINE_ID';
    public $timestamps = false;

    public function priceList()
    {
        return $this->hasMany('App\Models\OM\Customers\Domestics\PriceList', 'list_header_id', 'list_header_id');
    }
}
