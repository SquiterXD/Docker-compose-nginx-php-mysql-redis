<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeDomestic extends Model
{
    use HasFactory;

    protected $table = "ptom_product_type_domestic";
    public $primaryKey = 'lookup_code';
    protected $keyType = 'string';
}
