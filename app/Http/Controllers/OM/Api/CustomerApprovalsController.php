<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\OM\ApprovalRepo;

use App\Models\OM\Api\CustomerApprovals;

class CustomerApprovalsController extends Controller
{

    public function byCustomerTypeFirst()
    {
        $customer_type = ApprovalRepo::byCustomerTypeFirst();
        return response()->json(['data' => $customer_type]);
    }

    public function byCustomerTypeGroupFirst()
    {
        $customer_type = ApprovalRepo::byCustomerTypeGroupFirst();
        return response()->json(['data' => $customer_type]);
    }

    public function byCustomerType($type)
    {
        $customer_type = ApprovalRepo::byCustomerType($type);
        return response()->json(['data' => $customer_type]);
    }

    public function byCustomerTypeExport()
    {
        $customer_type = ApprovalRepo::byCustomerType('Exporter');
        return response()->json(['data' => $customer_type]);
    }
}
