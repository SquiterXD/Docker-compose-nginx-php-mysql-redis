<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLBudgetV extends Model
{
    use HasFactory;
    protected $table        = 'gl_budgets_with_dates_v';
    protected $connection   = 'oracle';
}
