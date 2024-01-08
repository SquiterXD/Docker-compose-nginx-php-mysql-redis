<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupingExpenseLine extends Model
{
    use HasFactory;

    protected $table = 'OACT.PTCT_GROUPING_EXPENSE_LINE';
    public $primaryKey = 'group_exp_line_id';
}
