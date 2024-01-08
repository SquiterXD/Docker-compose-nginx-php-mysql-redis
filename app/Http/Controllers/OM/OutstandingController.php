<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\OrderHeaders;
use App\Models\OM\OrderLines;
use App\Models\OM\ConsignmentHeaders;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\PaymentMatchInvoices;
use App\Models\OM\OrderCreditGroups;
use App\Models\OM\Customers;
use App\Models\OM\ImproveFines;

use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\CustomerTypeDomestic;
use App\Models\OM\Day;
use App\Models\OM\CreditGroup;

class OutstandingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $dataSearch                       = (object)[];
        $dataSearch->customer_id          = request()->customer_id;
        $dataSearch->date_selected        = request()->date_selected ? parseFromDateTh(request()->date_selected) : '';
        $dataSearch->customer_type        = request()->customer_type;
        $dataSearch->weekly_delivery_day  = request()->weekly_delivery_day;
        $dataSearch->check_search         = request()->check_search;
        $dataSearch->credit_group_code    = request()->credit_group_code;

        // $customerSearch   = request()->customer_id;
        // $dateSearch       = request()->date_selected ? parseFromDateTh(request()->date_selected) : '';

        $customer = Customers::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->where('customer_number', $user->username)
                                ->first();

        $customers = Customers::where('sales_classification_code', 'Domestic')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();

        $customerTypes = CustomerTypeDomestic::orderBy('meaning', 'asc')->get();
        $days          = Day::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $creditGroups  = CreditGroup::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();

        if ($customer) {
            // search($customer->customer_number, $dataSearch->date_selected, $dataSearch->customer_type, $dataSearch->weekly_delivery_day, $dataSearch->credit_group_code)
            $dataLists = OutstandingDebtDomesticV::search($customer->customer_number, $dataSearch)
                                                ->orderBy('customer_number', 'asc')
                                                ->orderBy('prepare_order_number', 'asc')
                                                ->orderBy('credit_group_code', 'asc')
                                                ->paginate(15);
            // if (request()->date_selected) {
            //     $dataLists = OutstandingDebtDomesticV::where('customer_id', $customer->customer_id)
            //                                 ->where('due_date', $dateSearch)
            //                                 ->orderBy('prepare_order_number', 'asc')
            //                                 ->orderBy('credit_group_code', 'asc')
            //                                 ->paginate(15);
            // } else {
            //     $dataLists = OutstandingDebtDomesticV::where('customer_id', $customer->customer_id)
            //                                 ->orderBy('prepare_order_number', 'asc')
            //                                 ->orderBy('credit_group_code', 'asc')
            //                                 ->paginate(15);
            // }
            
        } else {
            
            $customerS = Customers::where('customer_id', request()->customer_id)->first();
            $CustomerNumber = $customerS ? $customerS->customer_number : '';

            $dataLists = [];

            if (request()->check_search) {
                $dataLists = OutstandingDebtDomesticV::search($CustomerNumber, $dataSearch)
                                            ->orderBy('customer_number', 'asc')
                                            ->orderBy('prepare_order_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->paginate(15);
            } 
        }

        return view('om.outstanding.index', compact('customers', 'customer', 'dataLists', 'customerTypes', 'days', 'dataSearch', 'creditGroups'));
    }

    public function getData()
    {
        // dd(request()->all());

        if (request()->customer_id && !request()->date_selected) {
            //////////////// Has Customer//////////////// 
            // dd(request()->all());
            $data = OutstandingDebtDomesticV::where('customer_id', request()->customer_id)
                                            ->orderBy('credit_group_code', 'asc')
                                            ->get();

            // dd($header);

        } elseif (request()->date_selected && !request()->customer_id) {
            //////////////// Has Date//////////////// 
            // dd(request()->all());
            $data = OutstandingDebtDomesticV::where('due_date', date("Y-m-d", strtotime(request()->date_selected)))
                                                ->orderBy('customer_number', 'asc')
                                                ->orderBy('credit_group_code', 'asc')
                                                ->get();

        } elseif (request()->customer_id && request()->date_selected) {
            //////////////// Has Both//////////////// 
            // dd(request()->all());
            $data = OutstandingDebtDomesticV::where('customer_id', request()->customer_id)
                                            ->where('due_date', date("Y-m-d", strtotime(request()->date_selected)))
                                            ->orderBy('credit_group_code', 'asc')
                                            ->get();

        } elseif (!request()->customer_id && !request()->date_selected) {
            //////////////// Has Both//////////////// 
            // dd(request()->all());
            $data = OutstandingDebtDomesticV::orderBy('customer_number', 'asc')
                                            ->orderBy('credit_group_code', 'asc')
                                            ->get();

        }

        // dd($data);
        return response()->json($data);
    }

    public function getYear()
    {
    //    dd(request()->year);
        $startDate = date_create(request()->year . "-12-31");
        $endDate   = date_create(request()->year + 1 . "-12-31");

        $diff      = date_diff($startDate, $endDate);
        $data      = $diff->days;

        // $startDate21 = date_create(request()->year + 1 . "-12-31");
        // $endDate21   = date_create("2021-12-31");
        // $diff21      = date_diff($startDate21,$endDate21);

        // dd($diff20->days, $diff21->days);
        // dd($startDate, $endDate, $diff->days);

        return response()->json($data);
    }

    // function calFine($orderHeaderId, $prepareOrderNumber)
    // {
    //     // dd($orderHeaderId);
    //     $orderHeader =  App\Models\OM\OrderHeaders::where('order_header_id', $orderHeaderId)->first();

    //     dd($orderHeader, $prepareOrderNumber);
        
    //     // $paymentMatch = App\Models\OM\PaymentMatchInvoices::where('url', $menuUrl)->first();
    // }
}
