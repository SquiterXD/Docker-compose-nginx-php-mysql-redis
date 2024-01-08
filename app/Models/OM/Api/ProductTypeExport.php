<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeExport extends Model
{
    use HasFactory;
    protected $table = 'PTOM_PRODUCT_TYPE_EXPORT';
    public $primaryKey = 'lookup_code';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
}