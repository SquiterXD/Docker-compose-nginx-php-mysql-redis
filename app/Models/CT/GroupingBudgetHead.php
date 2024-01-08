<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupingBudgetHead extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_GROUPING_BUDGET_HEAD';
    public $primaryKey = 'group_budget_head_id';
}
