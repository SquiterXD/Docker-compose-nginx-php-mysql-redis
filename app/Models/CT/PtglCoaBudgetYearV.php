<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetYearV extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_year_v";
    public $primaryKey = 'budget_year';
}
