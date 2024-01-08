<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndLookupValue extends Model
{
    use HasFactory;
    protected $table = "FND_LOOKUP_VALUES";
    public $timestamps = false;
}
