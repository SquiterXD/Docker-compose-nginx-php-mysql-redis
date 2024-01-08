<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'PTIE_EMPLOYEE_V';
    public $primaryKey = 'employee_id';
    
    public function scopeHasExpenseAccount($q)
    {
        return $q->whereNotNull('expense_account');
    }
}
