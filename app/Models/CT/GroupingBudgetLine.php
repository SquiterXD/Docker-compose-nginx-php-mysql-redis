<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupingBudgetLine extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_GROUPING_BUDGET_LINE';
    public $primaryKey = 'group_budget_line_id';
}
