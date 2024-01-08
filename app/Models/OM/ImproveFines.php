<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImproveFines extends Model
{
    use HasFactory;
    // use HasFactory;
    protected $table = "oaom.ptom_improve_fines";
    public $primaryKey = 'improve_id';
    public $timestamps = false;

}
