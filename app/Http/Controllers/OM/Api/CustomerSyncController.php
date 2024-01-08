<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use Illuminate\Http\Request;

class CustomerSyncController extends Controller
{
    public function getInfoCustomer($cus_code) {
        $customer = Customer::where('customer_number', $cus_code)
        ->join('ptom_customer_type_domestic', 'ptom_customer_type_domestic.customer_type', '=', 'c.customer_type_id')
        ->join('ptom_customer_owners', 'ptom_customer_owners.customer_id', '=', 'c.customer_id')
        ->where('ptom_customer_owners.status', 'Active')
        ->first();
        return response()->json($customer, 200);
    }

    public function syncCustomer(Request $request) {
        $usersEcom = [];
        foreach($request->users as $user) {
            $usersEcom[] = $user['username'];
        }

        $customer = Customer::query()
                            ->whereIn('status', ['Active', 'Inactive'])
                            ->whereNotNull('customer_number')
                            ->get();
                            
        return response()->json($customer, 200);
    }
}
