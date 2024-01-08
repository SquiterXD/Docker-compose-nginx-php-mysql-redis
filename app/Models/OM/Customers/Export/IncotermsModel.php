<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncotermsModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_INCOTERMS";
    public $timestamps = false;
}
