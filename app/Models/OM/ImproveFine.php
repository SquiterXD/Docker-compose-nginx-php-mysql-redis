<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImproveFine extends Model
{
    use HasFactory;

    protected $table = "ptom_improve_fines";
    public $primaryKey = 'improve_id';
    
}
