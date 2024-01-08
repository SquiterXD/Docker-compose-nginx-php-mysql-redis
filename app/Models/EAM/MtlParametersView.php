<?php

namespace App\Models\EAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtlParametersView extends Model
{
    use HasFactory;

    protected $table = 'MTL_PARAMETERS_VIEW';
    public $incrementing = false;
}
