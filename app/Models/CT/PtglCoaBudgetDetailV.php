<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaBudgetDetailV extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_budget_detail_v";
    public $primaryKey = 'budget_detail';
}
