<?php

namespace App\Http\Controllers\OM\ReprintInvoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ReprintInvoice\ReprintInvoiceModel;
use App\Models\OM\ReprintInvoice\OrderHeaderModel;

class ReprintInvoiceController extends Controller
{
    public function index()
    {
        $order_prepare      = OrderHeaderModel::leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->where('ptom_customers.SALES_CLASSIFICATION_CODE','Domestic')
                                        ->whereNotNull('prepare_order_number')
                                        ->whereNotNull('pick_release_no')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where('PICK_RELEASE_APPROVE_FLAG','Y')
                                        ->orderBy('prepare_order_number','desc')
                                        ->limit(1000)
                                        ->get();

        $order_release      = OrderHeaderModel::leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->where('ptom_customers.SALES_CLASSIFICATION_CODE','Domestic')
                                        ->whereNotNull('prepare_order_number')
                                        ->whereNotNull('pick_release_no')
                                        ->whereNotNull('PICK_RELEASE_APPROVE_DATE')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where('PICK_RELEASE_APPROVE_FLAG','Y')
                                        ->orderBy('PICK_RELEASE_APPROVE_DATE','desc')
                                        ->limit(1000)
                                        ->get();

        $date       = date('Y-m-d');
        $d_xp       = explode('-',$date);
        $year       = $d_xp[0] +543;
        $dateThai   = $d_xp[2].'/'.$d_xp[1].'/'.$year; 

        return view('om.reprintinvoice.reprintinvoice',compact('order_prepare','order_release','dateThai'));
    }
}
