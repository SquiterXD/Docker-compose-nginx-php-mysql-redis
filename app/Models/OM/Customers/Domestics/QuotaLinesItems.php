<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotaLinesItems extends Model
{
    use HasFactory;

    protected $table = "PTOM_SEQUENCE_ECOMS";
    public $timestamps = false;
}
