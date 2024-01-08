<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatCodeModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_TAX_CODE_V";
    public $timestamps = false;
}
