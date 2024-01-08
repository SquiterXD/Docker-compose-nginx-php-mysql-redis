<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeDomestic extends Model
{
    use HasFactory;

    protected $table = 'ptom_product_type_domestic';
    protected $primaryKey = 'lookup_code';
}
