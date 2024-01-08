<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryVModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_ALL_COUNTRY_V";
    public $timestamps = false;
}
