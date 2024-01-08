<?php

namespace App\Http\Controllers\OM\ApproveSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ApproveSaleOrder\PrepareSaleOrderModel;
use App\Models\OM\ApproveSaleOrder\CustomerModel;

class ApproveSaleOrderController extends Controller
{
    public function index()
    {
        $customer       = CustomerModel::with('Province')->ActiveDomestic()->orderBy('customer_number')->get(); //ลูกค้า
        $order = [];
        if (request()->_type === "query") {
            $order          = PrepareSaleOrderModel::select('ptom_order_headers.*')
                ->where('ptom_order_headers.order_status', 'Confirm')
                ->whereNotNull('ptom_order_headers.prepare_order_number')
                ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                ->leftJoin('ptom_order_history', 'ptom_order_history.order_header_id', '=', 'ptom_order_headers.order_header_id')
                ->where('ptom_order_history.order_status', 'Inprocess')
                ->whereNull('ptom_order_history.deleted_at')
                ->where('ptom_customers.sales_classification_code', 'Domestic')
                ->when(!empty(request()->q), function($q) {
                    $q->where('ptom_order_headers.prepare_order_number', 'LIKE', "%".request()->q."%");
                })
                ->where(function ($query) {
                    $query->whereNull('ptom_order_headers.payment_approve_flag');
                    $query->orWhere('ptom_order_headers.payment_approve_flag', 'Y');
                })
                ->orderBy('ptom_order_headers.creation_date', 'desc')
                ->whereNotNull('ptom_order_headers.delivery_date')
                ->take(500)
                ->get();
            return $order;
        }

        $year           = date('Y') + 543;
        $dateThai       = date('d/m') . '/' . $year;

        return view('om.approvesaleorder.index', \compact('customer', 'order', 'dateThai'));
    }
}
