<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTypeModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_TRANSACTION_TYPES_V";
    public $timestamps = false;
}
