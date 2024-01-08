<?php

namespace App\Models\OM\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApproves extends Model
{
    use HasFactory;
    protected $table = 'PTOM_CUSTOMER_APPROVES as ce';
    public $primaryKey = 'approve_id';
    public $timestamps = false;
    protected $dates = ['creation_date'];

    public static function joinCustomerAdmin($customer_id)
    {
        return self::join('ptom_customers as c', 'c.customer_id', '=', 'ce.customer_id')
        ->join('ptom_customer_type_export as cep', 'cep.customer_type', '=', 'c.customer_type_id')
        ->join('ptom_customer_approvals as ca', 'ca.employee_number', '=', 'ce.to_user_number')
        ->join('ptom_all_country_v as ac', 'ac.country_code', '=', 'c.country_code')
        ->join('ptom_currencies_v as cv', 'cv.currency_code', '=', 'c.currency')
        ->where('ce.customer_id',$customer_id)
        ->orderBy('ce.approve_id','DESC')
        ->get(['ce.*','c.*','ca.*','ac.*','cep.description as custype_name','cv.name as currency_as_name','ce.status as approves_as_status']);
    }

    public static function joinCustomer($customer_id)
    {
        return self::join('ptom_customers as c', 'c.customer_id', '=', 'ce.customer_id')
        ->join('ptom_customer_type_export as cep', 'cep.customer_type', '=', 'c.customer_type_id')
        ->join('ptom_customer_approvals as ca', 'ca.employee_number', '=', 'ce.to_user_number')
        ->join('ptom_all_country_v as ac', 'ac.country_code', '=', 'c.country_code')
        ->join('ptom_currencies_v as cv', 'cv.currency_code', '=', 'c.currency')
        ->where('ce.customer_id',$customer_id)
        // ->where('ce.to_user_id',$employee_number)
        ->orderBy('ce.approve_id','DESC')
        ->get(['ce.*','c.*','ca.*','ac.*','cep.description as custype_name','cv.name as currency_as_name','ce.status as approves_as_status']);
    }

    public static function approvesHistory($customer_id)
    {
        return self::join('ptom_customers as c', 'c.customer_id', '=', 'ce.customer_id')
        ->where('ce.customer_id',$customer_id)
        ->orderBy('ce.approve_id','ASC')
        ->get(['ce.status','ce.approver_comment','ce.from_user_id','ce.to_user_id','ce.from_user_nunber','ce.to_user_number']);
    }
}