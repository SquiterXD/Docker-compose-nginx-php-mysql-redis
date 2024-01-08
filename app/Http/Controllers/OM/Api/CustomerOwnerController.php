<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Customers\Domestics\CustomerOwners;
use App\Models\OM\Customers\Domestics\Customer;

class CustomerOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byCustomerId($customer_id)
    {
        $customerOwners = CustomerOwners::where("customer_id",$customer_id)->whereRaw("status = 'Active' ")->orderBy('owner_no')->first();

        if (!is_null($customerOwners)) {
            return response()->json(['data' => $customerOwners]);
        }else{
            return response()->json(['data' => []]);
        }

    }

    public function byId($customer_owner_id)
    {
        $customerOwners = CustomerOwners::where("customer_owner_id",$customer_owner_id)->whereRaw("status = 'Active' ")->orderBy('owner_no')->first();

        if (isset($customerOwners) && !empty($customerOwners)) {
            return response()->json(['data' => $customerOwners]);
        }else{
            return response()->json(['data' => []]);
        }

    }

}
