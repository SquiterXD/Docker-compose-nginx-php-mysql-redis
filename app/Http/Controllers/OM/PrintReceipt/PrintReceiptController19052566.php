<?php

namespace App\Http\Controllers\OM\PrintReceipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;

use App\Models\OM\PrintReceipt\PrintReceiptModel;
use App\Models\OM\PrintReceipt\PaymentHeaderModel;
use App\Models\OM\Customers\Export\ThailandTerritoryVModel;
use Barryvdh\Snappy\Facades\SnappyPdf;

class PrintReceiptController extends Controller
{
    public function index()
    {
        // if(!canView('/om/print-receipt/print') || !canEnter('/om/print-receipt/print')){
        //     return \redirect()->back()->withError(trans('403'));
        // }

        $list       = PaymentHeaderModel::select(  'ptom_release_receipts.*',
                                                'ptom_customers.customer_name',
                                                'ptom_payment_headers.payment_date','ptom_payment_headers.payment_number','ptom_payment_headers.total_payment_amount')
                                        ->join('ptom_release_receipts','ptom_payment_headers.payment_header_id','=','ptom_release_receipts.payment_header_id')
                                        ->join('ptom_customers','ptom_customers.customer_id','=','ptom_payment_headers.customer_id')
                                        ->where('ptom_payment_headers.payment_status','!=','Draft')
                                        ->where('ptom_customers.sales_classification_code','Domestic')
                                        ->whereNotNull('ptom_payment_headers.payment_number')
                                        ->orderBy('ptom_payment_headers.payment_number','desc')
                                        ->get();

        $date       = date('Y-m-d');
        $d_xp       = explode('-',$date);
        $year       = $d_xp[0] +543;
        $dateThai   = $d_xp[2].'/'.$d_xp[1].'/'.$year; 
        return view('om.printreceipt.index_print',compact('list','dateThai'));
    }

    public function print_page(Request $request)
    {
        $id[] = 0;
        foreach($request->receipt as $key_id => $item){
            if(!empty($request->print[$key_id])){
                $id[] = $request->number[$key_id] ;
            }
        }
        $prints = PaymentHeaderModel::leftJoin('ptom_customers','ptom_payment_headers.customer_id','=','ptom_customers.customer_id')
                                    ->leftJoin('ptom_payment_match_invoices','ptom_payment_match_invoices.payment_header_id','=','ptom_payment_headers.payment_header_id')
                                    ->whereIn('ptom_payment_headers.payment_number',$id)
                                    ->get();

       // dd($prints);                            
        $list_territory = ThailandTerritoryVModel::select('province_id','province_thai','province_eng')->groupBy('province_id','province_thai','province_eng')->get();
        foreach($list_territory as $item_province){ //จังหวัด
            $province_list[$item_province->province_id] = [
                'id'        => $item_province->province_id,
                'name_th'   => $item_province->province_thai,
                'name_en'   => $item_province->province_eng
            ];
        }
        if (empty($prints)) {
            return back();
        }
        return view('om.printreceipt.print_receipt', compact('prints','province_list'));
    }

    public function print_page_pdf(Request $request)
    {
        $id[] = 0;
        foreach($request->receipt as $key_id => $item){
            if(!empty($request->print[$key_id])){
                $id[] = $request->number[$key_id] ;
            }
        }
        //dd($request->receipt );
   
      
        
        $data = PaymentHeaderModel::leftJoin('ptom_customers','ptom_payment_headers.customer_id','=','ptom_customers.customer_id')
                                    // ->leftJoin('ptom_payment_match_invoices','ptom_payment_match_invoices.payment_header_id','=','ptom_payment_headers.payment_header_id')
                                    ->whereIn('ptom_payment_headers.payment_number',$id)
                                    ->orderBy('ptom_payment_headers.payment_number','asc')
                                    ->get();

      
        // pr($prints->count());
        // exit;

        

        $list_territory = ThailandTerritoryVModel::select('province_id','province_thai','province_eng')->groupBy('province_id','province_thai','province_eng')->get();
        foreach($list_territory as $item_province){ //จังหวัด
            $province_list[$item_province->province_id] = [
                'id'        => $item_province->province_id,
                'name_th'   => $item_province->province_thai,
                'name_en'   => $item_province->province_eng
            ];
        }
        if (empty($data)) {
            return back();
        }

        foreach($data as $data_item){
             //toat_edit 02052566
            if($data_item->customer_number=="D00003"){
                $prints_ship = DB::select("SELECT hd.pick_release_no,ship.address_line1,ship.address_line2,ship.address_line3,ship.alley,ship.district ,ship.city,ship.province_name,ship.postal_code
                FROM PTOM_PAYMENT_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_PAYMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID
                LEFT JOIN PTOM_THAILAND_TERRITORY_V ON PTOM_CUSTOMERS.PROVINCE_CODE = PTOM_THAILAND_TERRITORY_V.PROVINCE_ID
                INNER JOIN ptom_payment_match_invoices pm ON pm.PAYMENT_HEADER_ID = PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID
                inner join ptom_order_headers hd on hd.pick_release_no = pm.invoice_number
                inner join PTOM_CUSTOMER_SHIP_SITES ship on ship.ship_to_site_id = hd.ship_to_site_id
                WHERE PTOM_PAYMENT_HEADERS.PAYMENT_NUMBER = '$data_item->payment_number' ORDER BY PTOM_PAYMENT_HEADERS.PAYMENT_HEADER_ID DESC FETCH FIRST 1 ROWS ONLY");
            }else{
                $prints_ship[] = '';   
            }
            

            $sum_total = DB::table('ptom_payment_details')->where('payment_header_id',$data_item->payment_header_id)->sum('payment_amount');
            $data_item->payment_amount = $sum_total;
            $payMatch       = DB::table('ptom_payment_match_invoices')->where('payment_header_id',$data_item->payment_header_id)->get();
            if($payMatch->count() > 0){
                $paymentDetail  = DB::table('ptom_payment_details')->where('payment_header_id',$data_item->payment_header_id)->get();
                $data_item->cash    = false;
                $data_item->bill    = false;
                $data_item->tranf   = false;

                foreach($paymentDetail as $pD_item){
                    if($pD_item->payment_method_code == 10){
                        $data_item->cash            = true;
                        $data_item->cash_amount     = $pD_item->payment_amount;
                    }
                    if($pD_item->payment_method_code <> 10){
                        $data_item->tranf           = true;
                        $data_item->tranf_amount    = $pD_item->payment_amount;
                    }
                    if(empty($pD_item->payment_method_code)){
                        $data_item->bill            = true;
                        $data_item->bill_amount     = $pD_item->payment_amount;
                    }
                }

                $data_item->product_type_10 = false;
                $data_item->product_type_20 = false;
                $invoice_number = [];
                $preprenumber = [];
                $data_item->invoice_list = '';
                foreach($payMatch as $paymatch_item){
                    $orderHeader = DB::table('ptom_order_headers')->where('prepare_order_number',$paymatch_item->prepare_order_number)->first();
                    if($orderHeader->product_type_code == 10){
                        $data_item->product_type_10 = true; 
                    }elseif($orderHeader->product_type_code == 20){
                        $data_item->product_type_20 = true; 
                    }
                    $preprenumber[$paymatch_item->prepare_order_number] = $paymatch_item->prepare_order_number;
                    $invoice_number[$paymatch_item->invoice_number] = $paymatch_item->invoice_number;
                }
                $listInvoice = self::concatInvoice($invoice_number); /// implode(',',$invoice_number);
                $data_item->invoice_list =  $listInvoice;
                $listpreprenumber = implode(',',$preprenumber);
                $data_item->prepare_order_number =  $listpreprenumber;
            }
            $prints[] = $data_item;
        }
        
    
        $pdf = SnappyPdf::loadView('om.printreceipt.print_receipt', compact('prints','province_list','prints_ship'))
                    ->setOption('page-height', '5.5in')
                    ->setOption('page-width', '8in')
                    ->setOption('margin-left','0')
                    ->setOption('margin-right','0')
                    ->setOption('margin-top','0')
                    ->setOption('margin-bottom','0');
        return $pdf->stream('omp0027.pdf');
        // return view('om.printreceipt.print_receipt', compact('prints','province_list'));
    }

    private static function concatInvoice($invoice_list){
        $invList = collect($invoice_list)->filter();

        $listInvoice = "";
        $count = 0;
        $max = 2;
        $first = $invList->first();
        $last = $invList->last();
        $prev = "";
        $check = "";
        
        foreach($invList as $list){
            if($list == $first){
                $listInvoice .= $list;
                $count++;
            }elseif($list == $last) {
                if((int)substr($list, -4) - (int)substr($prev, -4) > 1){
                    if($count > $max){
                        if($check == $prev){
                            $listInvoice .= '<br>, '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).'<br>, '.$list;
                        }
                    }else {
                        if($check == $prev){
                            $listInvoice .= ', '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).', '.$list;
                        }
                    }
                }else{
                    $listInvoice .= '-'.$list;
                }
            }else {
                if((int)substr($list, -4) - (int)substr($prev, -4) > 1){
                    if($count > $max){
                        if($check == $prev){
                            $listInvoice .= '<br>, '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).'<br>, '.$list;
                        }
                        $max = 3;
                        $count = 0;
                    }else {
                        if($check == $prev){
                            $listInvoice .= ', '.$list;
                        }else {
                            $listInvoice .= '-'.substr($prev,-3).', '.$list;
                        }
                    }
                    $check = $list;
                    $count++;
                }
            }
            $prev = $list;
        }

        //$listInvoice = $invList->count() ? ($invList->count() > 1 ? $invList->first().'-'.substr($invList->last(),-3) : $invList->first()) : "";
        return $listInvoice;
    }
}
