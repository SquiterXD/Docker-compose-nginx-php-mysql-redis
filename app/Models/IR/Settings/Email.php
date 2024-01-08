<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $table = "ptir_emails";
    public $primaryKey = 'email_id';

    public function scopeSearch($q, $companyName, $employeeName, $status)
    {
        return $q->when($companyName, function($q) use($companyName) {
            $q->where('company_name', $companyName);
        })->when($employeeName, function($q) use($employeeName) {
            $q->where('employee_number', $employeeName)
                ->orWhere('department_name', $employeeName);
        })->when($status, function($q) use($status) {
            $q->where('active_flag', $status);
        });
    }

    public function scopeIsCompany($q)
    {
        return $q->where('company_flag', 'Y');
    }

    public function scopeIsSender($q)
    {
        return $q->where('sender_flag', 'Y');
    }

    public function scopeIsReceive($q)
    {
        return $q->where('to_flag', 'Y');
    }

    public function scopeIsCCReceive($q)
    {
        return $q->where('cc_flag', 'Y');
    }

    public function scopeIsActive($q)
    {
        return $q->where('active_flag', 'Y');
    }

    public function composeSender()
    {
        $userData = self::selectRaw('distinct email, employee_name')
                        ->where('employee_number', \Auth::user()->username)
                        ->isSender()
                        ->isActive()
                        ->first();
        $dept = \Auth::user()->department_code;
        if (!$userData) {
            $userWithDept = self::selectRaw('distinct email, department_name as employee_name')
                            ->where('department_group_code', $dept)
                            ->isSender()
                            ->isActive()
                            ->first();
            if ($userWithDept) {
                $userData = $userWithDept;
            }elseif (!$userWithDept) {
                $parentCode = collect(\DB::select("
                        select parent_flex_value, child_flex_value_low, child_flex_value_high
                        from FND_FLEX_VALUE_NORM_HIERARCHY  h
                            , fnd_flex_value_sets           s
                        where 1=1
                        and s.flex_value_set_name = 'TOAT_GL_ACCT_CODE-DEPT_CODE'
                        and h.flex_value_set_id   = s.flex_value_set_id
                        and '{$dept}' BETWEEN h.child_flex_value_low and h.child_flex_value_high
                    "));
                $parent = $parentCode->first();
                $userData = self::selectRaw('distinct email, department_name as employee_name')
                                ->where('department_group_code', $parent->parent_flex_value)
                                ->isSender()
                                ->isActive()
                                ->first();
                if (!$userData) {
                    $userData = self::selectRaw('distinct email, department_name as employee_name')
                                ->whereNull('department_group_code')
                                ->isSender()
                                ->isActive()
                                ->first();
                }
            }
        }
        $sender = [];
        if(!$userData){ return $sender; }
        return $sender = $userData;
    }

    public function composeReceivers()
    {
        $userData = self::selectRaw('distinct email, company_name')->isCompany()->isReceive()->isActive()->get();
        $receivers = [];
        if(!$userData){ return $receivers; }

        if(count($userData)>0){
            foreach ($userData as $key => $user) {
                if($user->email){
                    array_push($receivers, ['email' =>  $user->email,
                                            'name'  =>  $user->company_name]);
                }
            }
        }
        return $receivers;
    }

    public function composeCCReceivers()
    {
        $userData = self::selectRaw('distinct email, company_name, employee_name, employee_flag, company_flag')->isCCReceive()->isActive()->get();
        $ccReceivers = [];
        if(!$userData){ return $ccReceivers; }

        if(count($userData)>0){
            foreach ($userData as $key => $user) {
                if($user->company_flag == 'Y'){
                    if($user->email){
                        array_push($ccReceivers, ['email' =>  $user->email,
                                                'name'  =>  $user->company_name]);
                    }
                }
                if($user->employee_flag == 'Y') {
                    if($user->email){
                        array_push($ccReceivers, ['email' =>  $user->email,
                                                'name'  =>  $user->employee_name]);
                    }
                }
            }
        }
        return $ccReceivers;
    }
    
    public function company()
    {
        return $this->belongsTo(PtirCompanies::class, 'company_number', 'company_number');
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\HREmployee::class, 'employee_number', 'employee_number');
    }

    // public function departmentGroup()
    // {
    //     return $this->belongsTo(PtglCoaDeptCodeView::class, 'department_group_code', 'department_group_code');
    // }

    public function departmentGroups()
    {
        return $this->hasMany(DepartmentGroup::class, 'email_id', 'email_id');
    }
}
