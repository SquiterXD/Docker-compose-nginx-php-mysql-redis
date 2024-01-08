<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupingExpenseHead extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_GROUPING_EXPENSE_HEAD';
    public $primaryKey = 'group_exp_head_id';
}
