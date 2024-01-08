<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PyamentTypeModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_PAYMENT_TYPE";
    public $timestamps = false;
}
