<?php

namespace App\Repositories\OM;

use Illuminate\Support\Facades\DB;
use App\Models\OM\Api\CustomerApprovals;

class ApprovalRepo
{
    public static function byCustomerTypeFirst()
    {
        return CustomerApprovals::where('status','=','Active')->where('primary_approval','=','Y')->first();
    }

    public static function byCustomerTypeGroupFirst($type_code)
    {
        $primaryApproval = CustomerApprovals::where('status','=','Active')->where('customer_type_code','=',$type_code)->where('primary_approval','=','Y')->first();

        if (isset($primaryApproval) && !empty($primaryApproval)) {
            return $primaryApproval;
        }else{
            $typeApproval = CustomerApprovals::where('status','=','Active')->where('customer_type_code','=',$type_code)->first();
            if (isset($typeApproval) && !empty($typeApproval)) {
                return  $typeApproval;
            }else{
                return CustomerApprovals::where('status','=','Active')->first();
            }
        }

    }

    public static function byCustomerType($type)
    {
        return CustomerApprovals::where('status','=','Active')->where('customer_type','=',$type)->get();
    }

    public static function byCustomerApprovalReassign($type,$id)
    {
        // ->where('customer_type','=',$type)
        return CustomerApprovals::where('status','=','Active')->where('customer_type_code','=',$type)->where('employee_number','!=',$id)->get();
    }

    public static function getFromUser($id)
    {
        $customerApp = [];
        try {
            $customerApp = CustomerApprovals::where('status','=','Active')->where('employee_number','=',$id)->first('employee_name as ename');
        } catch (\Exception $e) {}

        if (!empty($customerApp)) {
            return $customerApp;
        }else{
            return DB::table('ptw_users')->where('username','=',$id)->first(['name as ename']);
        }

    }
}