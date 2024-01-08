<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_PRICE_LIST_HEAD_V";
    public $timestamps = false;
}
