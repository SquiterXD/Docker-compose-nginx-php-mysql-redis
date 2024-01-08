<?php

namespace App\Models\OM\DebitNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountyModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_ALL_COUNTRY_V";
    public $timestamps = false;
}
