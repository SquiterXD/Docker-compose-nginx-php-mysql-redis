<?php

namespace App\Models\OM\SequenceEcoms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryCode extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PRODUCT_CATEGORY_CODE_V';
    public $primaryKey = 'LOOKUP_CODE';
    public $timestamps = false;


}
