<?php

namespace App\Http\Controllers\OM\PrintReceipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\PrintReceipt\CustomerModel;
use App\Models\OM\PrintReceipt\PaymentHeaderModel;

class ReprintReceiptController extends Controller
{
    public function index()
    {
        // if(!canView('/om/print-receipt/reprint') || !canEnter('/om/print-receipt/reprint')){
        //     return \redirect()->back()->withError(trans('403'));
        // }

        $customer   = CustomerModel::ActiveDomestic()->orderBy('customer_number')->get();
        $list       = PaymentHeaderModel::select(  'ptom_release_receipts.*',
                                            'ptom_customers.customer_name',
                                            'ptom_payment_headers.payment_date','ptom_payment_headers.payment_number','ptom_payment_headers.total_payment_amount')
                                    ->join('ptom_release_receipts','ptom_payment_headers.payment_header_id','=','ptom_release_receipts.payment_header_id')
                                    ->join('ptom_customers','ptom_customers.customer_id','=','ptom_payment_headers.customer_id')
                                    ->where('ptom_payment_headers.payment_status','Confirm')
                                    ->where('ptom_customers.sales_classification_code','Domestic')
                                    ->whereNotNull('ptom_payment_headers.payment_number')
                                    ->orderBy('ptom_payment_headers.payment_number','desc')
                                    ->get();


        return view('om.printreceipt.index',\compact('customer','list'));
    }
}
