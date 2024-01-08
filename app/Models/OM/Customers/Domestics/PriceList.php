<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;

    protected $table = "PTOM_PRICE_LIST_HEAD_V";
    // public $primaryKey = '';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    // protected $fillable = [
    //     'CUSTOMER_NAME'
    // ];

    public function listLines()
    {
        return $this->hasMany('App\Models\OM\Customers\Domestics\PriceListLine', 'list_header_id', 'list_header_id');
    }
}
