<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeExport extends Model
{
    use HasFactory;

    protected $table = 'ptom_product_type_export';
    protected $primaryKey = 'lookup_code';
}
