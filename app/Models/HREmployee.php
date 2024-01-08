<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HREmployee extends Model
{
    use HasFactory;

    protected $table = "employee_user_view";
    protected $dates = ['employment_date', 'employment_end_date'];
    protected $primaryKey = 'username';
    protected $keyType = 'string';

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'username');
    }

    public function PersonalDeptLocation()
    {
        return $this->hasOne(PersonalDeptLocation::class, 'pnps_psnl_no', 'username');
    }

    public function userAccounts()
    {
        return $this->hasMany(\App\Models\IE\UserAccount::class, 'employee_number', 'username')->orderBy('user_account_id');
    }

    public function deptEmp()
    {
        return $this->hasOne(\App\Models\IE\Employee::class, 'employee_number', 'dept_code_account');
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameAttribute()
    {
        return $this->title.' '.$this->first_name.' '.$this->last_name;
    }

}
