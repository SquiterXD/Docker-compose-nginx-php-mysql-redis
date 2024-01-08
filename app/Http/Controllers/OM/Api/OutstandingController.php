<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\PaymentMatchInvoices;
use App\Models\OM\OrderHeaders;
use App\Models\OM\ConsignmentHeaders;
use App\Models\OM\CustomerTypeDomestic;
use App\Models\OM\Day;

class OutstandingController extends Controller
{
    public function index()
    {
        // \Log::info("message");
        // \Log::info(request()->customer_number);
        // \Log::info("-------");
        $datLists = OutstandingDebtDomesticV::search(request()->customer_number, request()->date, request()->customer_type, request()->weekly_delivery_day)
                                            ->orderBy('customer_number', 'asc')
                                            ->orderBy('prepare_order_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->with('orderHeader', 'consignmentHeader', 'paymentMatchInvoices', 'orderCreditGroup')
                                            ->get();

        $customerTypes = CustomerTypeDomestic::orderBy('meaning', 'asc')->get();
        $days          = Day::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();

        return response()->json([
            'data'           => $datLists,
            'customer_types' => $customerTypes,
            'days'           => $days,
        ]);

    }
}
