<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTermsModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_TERMS_V";
    public $timestamps = false;
}
