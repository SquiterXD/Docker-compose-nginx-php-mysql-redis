<?php

namespace App\Http\Controllers\OM\ApproveSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ApproveSaleOrder\OrderHeaderModel;
use App\Models\OM\ApproveSaleOrder\CustomerModel;

class ApproveSaleOrderDebtController extends Controller
{
    public function index()
    {
        $customer       = CustomerModel::with('Province')->ActiveDomestic()->orderBy('customer_number')->get(); //ลูกค้า
        return view('om.approvesaleorder.index',\compact('customer'));
    }
}
