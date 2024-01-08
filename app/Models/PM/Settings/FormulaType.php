<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaType extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_formula_type';
    protected $primaryKey = 'lookup_code';
}
