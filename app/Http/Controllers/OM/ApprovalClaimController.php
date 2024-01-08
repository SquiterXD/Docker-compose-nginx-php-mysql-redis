<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\ClaimStatusV;
use App\Models\OM\ClaimHeaders;
use App\Models\OM\Customers;

class ApprovalClaimController extends Controller
{
    public function index()
    {
        $claimStatusList = ClaimStatusV::where('enabled_flag','Y')
                                    ->get();
        $headersList = ClaimHeaders::whereNotNull('claim_number')
                                    ->where('sales_type','DOMESTIC')
                                    ->with('customers')
                                    ->orderBy('claim_header_id', 'DESC')
                                    ->get();
        $customerList = Customers::where('sales_classification_code','Domestic')
                                ->whereNotNull('customer_number')
                                ->orderBy('customer_number', 'asc')
                                ->get();
        $btnTrans = trans('btn');
                                    
        return view('om.approval-claim.index', compact('claimStatusList', 'headersList', 'customerList', 'btnTrans'));
    }
}
