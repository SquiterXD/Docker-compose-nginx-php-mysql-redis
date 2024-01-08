<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlParameter extends Model
{
    use HasFactory;
    protected $table = "mtl_parameters";
    public $timestamps = false;
}
