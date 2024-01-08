<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\ReleaseCredit;
use App\Models\OM\Customers\Domestics\Customer;

class ReleaseCreditAjaxController extends Controller
{
    public function customers($customer_number='')
    {
        $customers = Customer::where('customer_number','LIKE',"%{$customer_number}%")->get();
        return response()->json(['data' => $customers]);
    }
}