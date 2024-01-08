<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtCtParams extends Model
{
    use HasFactory;
    protected $table = 'PTCT_PARAMS_T';

    public $primaryKey = 'param_id';
}
