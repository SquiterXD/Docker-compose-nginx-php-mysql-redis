<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'PTOM_CUSTOMERS as c';
    public $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public static function byCustomerId($id)
    {
        $result = self::where('customer_id',$id)->first();
        return $result;
    }

    public static function byCustomerNumber($number)
    {
        $result = self::where('customer_number',$number)->first();
        return $result;
    }

    public static function byCustomerExport()
    {
        $result = self::whereRaw("lower(sales_classification_code) = 'export'")->whereRaw("lower(status) = 'active'")->get();
        return $result;
    }

    public static function joinCustomerApproves($employee_number='')
    {
        return self::leftJoin('ptom_customer_approves as ce', 'ce.customer_id', '=', 'c.customer_id')
        ->join('ptom_customer_approvals as ca', 'ca.employee_number', '=', 'ce.to_user_number')
        ->join('ptom_all_country_v as ac', 'ac.country_code', '=', 'c.country_code')
        ->whereNotNull('c.request_number')
        ->whereNotNull('ce.status')
        ->where('ce.to_user_number',$employee_number)
        ->orderBy('ce.approve_id','DESC')
        ->get(['ce.*','c.*','ac.*','ac.country_name as country_as_name','ce.status as approves_as_status']);
    }

    public static function joinCustomerApprovesByAdmin($employee_number='')
    {
        return self::leftJoin('ptom_customer_approves as ce', 'ce.customer_id', '=', 'c.customer_id')
        ->join('ptom_customer_approvals as ca', 'ca.employee_number', '=', 'ce.to_user_number')
        ->join('ptom_all_country_v as ac', 'ac.country_code', '=', 'c.country_code')
        ->join('ptom_currencies_v as cv', 'cv.currency_code', '=', 'c.currency')
        ->whereNotNull('c.request_number')
        ->whereNotNull('ce.status')
        ->orderBy('ce.approve_id','DESC')
        ->get(['ce.*','c.*','ac.*','ac.country_name as country_as_name','ce.status as approves_as_status']);
    }
}