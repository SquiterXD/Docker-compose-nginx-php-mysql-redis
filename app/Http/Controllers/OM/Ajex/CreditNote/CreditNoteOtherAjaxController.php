<?php

namespace App\Http\Controllers\OM\Ajex\CreditNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\OM\CreditNote\InvoiceHeaderModel;
use App\Models\OM\CreditNote\InvoiceLineModel;

use App\Models\OM\CreditNote\ThaiTerritoryModel;
use App\Models\OM\CreditNote\ClubAssociationModel;
use App\Models\OM\CreditNote\ChannelReceivingModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\CustomerModel;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\CreditNote\ConsigmentHeadersModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\CreditNote\TermsModel;
use App\Models\OM\CreditNote\OrderHeaderModel;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\CreditNote\MappingAccountModel;

use App\Models\OM\CreditNote\PaymentDncnModel;
use App\Models\OM\CreditNote\OutstandingDebtModel;


use App\Repositories\OM\GenerateNumberRepo;
use Illuminate\Support\Facades\DB;

class CreditNoteOtherAjaxController extends Controller
{
    public function createCreditNote()
    {
        // $last_invoice   = InvoiceHeaderModel::orderBy('invoice_headers_number','desc')->first();
        // if(!empty($last_invoice)){
        //     $number = \explode('POSIN',$last_invoice->invoice_headers_number);
        //     if(is_numeric($number[1])){
        //         $newnumber = sprintf('%04d', $number[1]+1);
        //     }else{
        //         $newnumber = sprintf('%04d', 1);
        //     }
        //     $invoice_number = 'POSIN'.$newnumber;
        // }else{
        //     $invoice_number = 'POSIN0001';
        // }

        // $invoice_number = GenerateNumberRepo::generateCreditNoteOtherNumberDomestics();

        $date =  date('d/m');
        $year =  date('Y') + 543;
        $ndate =  $date.'/'.$year;

        $rest = [
            'status'    => true,
            'data'      => [
                // 'number'    => $invoice_number,
                'date'      =>  $ndate
            ]
        ];

        return response()->json(['data' => $rest]);
    }

    public function getCustomer(Request $request)
    {
        $thaiprovince = ThaiTerritoryModel::select('province_id','province_thai')->groupBy('province_id','province_thai')->get();
        foreach($thaiprovince as $province_list){
            $data['province'][$province_list->province_id] = [
                'name'      => $province_list->province_thai
            ];
        }

        $customer = CustomerModel::where('sales_classification_code','Domestic')
                                    // ->where('customer_type_id','30')
                                    // ->orWhere('customer_type_id','40')
                                    ->where('status','Active')
                                    ->where(function($query) use($request){
                                        if(!empty($request->customer)){
                                            $query->where('customer_number',$request->customer);
                                        }
                                    })
                                    ->orderBy('customer_number','asc')->get();
        foreach($customer as $customer_list){
            $data['data'][$customer_list->customer_number] = [
                'id'        => $customer_list->customer_id,
                'name'      => $customer_list->customer_name,
                'number'    => $customer_list->customer_number,
                'province'  => !empty($customer_list->province_code)?$data['province'][$customer_list->province_code]['name']  : ''
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getCreditNoteList(Request $request)
    {
        $list  = InvoiceHeaderModel::whereIn('program_code',['OMP0033','OMP0050','OMP0052'])
                                ->where(function($query) use($request){
                                    if(!empty($request->customer_id)){
                                        $query->where('customer_id',$request->customer_id);
                                    }
                                })
                                ->orderBy('creation_date','desc')
                                ->get();
        $datalist = [];
        foreach($list as $list_item){
            $customer = CustomerModel::where('customer_id',$list_item->customer_id)->first();

            if(!empty($list_item->invoice_date)){
                $date_nt    = \explode(' ',$list_item->invoice_date);
                $date_n     = \explode('-',$date_nt[0]);
                $year       = $date_n[0] + 543;
                $date       = $date_n[2].'/'.$date_n[1].'/'.$year;
            }else{
                $date       = '';
            }


            $datalist[] = [
                'invoice_headers_number'    => $list_item->invoice_headers_number,
                'invoice_date'              => $date,
                'customer_name'             => $customer->customer_name
            ];
        }

        $data = [
            'status'    => true,
            'data'      => $datalist
        ];
        return response()->json(['data' => $data]);
    }

    public function getChannelReceiving()
    {
        $channel = ChannelReceivingModel::where('enabled_flag','Y')
                                        ->where('start_date_active','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date_active');
                                        })
                                        ->get();

        foreach($channel as $channel_item){
            $data['data'][$channel_item->lookup_code] = [
                'id'    => $channel_item->lookup_code,
                'name'  => $channel_item->description
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getOrder(Request $request)
    {
        $customer   = CustomerModel::where('customer_id',$request->customer_id)->first();
        $contact    = CustomerContractGroupModel::join('ptom_credit_group','ptom_credit_group.lookup_code','=','ptom_customer_contract_groups.credit_group_code')
                                                ->where('ptom_customer_contract_groups.customer_id',$request->customer_id)
                                                ->first();

        $data = [];
        if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
            $order      = OrderHeaderModel::leftJoin('ptom_order_credit_groups','ptom_order_credit_groups.order_header_id','=','ptom_order_headers.order_header_id')
                                            ->where('ptom_order_headers.customer_id',$request->customer_id)
                                            ->where('ptom_order_headers.order_status','Confirm')
                                            ->where('ptom_order_headers.pick_release_status','Confirm')
                                            ->where('ptom_order_credit_groups.order_line_id','=',0)
                                            ->where('ptom_order_credit_groups.amount','!=',0)
                                            // ->groupBy('ptom_order_credit_groups.order_header_id')
                                            ->get();

            if($order->count() > 0){
                foreach($order as $order_item){
                    if(!empty($request->invoice_id)){
                        $orderline  = InvoiceLineModel::where('invoice_headers_id',$request->invoice_id)->where('credit_group_code',$order_item->credit_group_code)->first();
                    }else{
                        $orderline = [];
                    }

                    if(!empty($order_item->delivery_date)){
                        if(!empty($request->invoice_id)){
                            if(!empty($orderline->day_amount)){
                                $alldate = date('Y-m-d',strtotime($order_item->delivery_date . "+$orderline->day_amount days"));
                            }else{
                                $alldate = $order_item->delivery_date;
                            }
                        }else{
                            $alldate = $order_item->delivery_date;
                        }
                        $dateorder_no_time  = \explode(' ',$alldate);
                        $dateorder          = \explode('-',$dateorder_no_time[0]);
                        $year_order         = $dateorder[0] + 543;
                        $date_order         = $dateorder[2].'/'.$dateorder[1].'/'.$year_order;
                    }

                    if(!empty($order_item->delivery_date)){
                        $duedate = DB::table('ptom_terms_v')
                                            ->where('credit_group_code',$order_item->credit_group_code)
                                            ->where('sale_type','DOMESTIC')
                                            ->first();
                        $total_day = $duedate->due_days;
                        $final_date = date('Y-m-d',strtotime($order_item->delivery_date." + ".$duedate->due_days." day"));
                        $duedate_no_time    = $final_date;
                        $duedate            = \explode('-',$duedate_no_time);
                        $year_duedate       = $duedate[0] + 543;
                        $date_duedate       = $duedate[2].'/'.$duedate[1].'/'.$year_duedate;

                        if ($duedate[0] % 4 == 0) { //หาจำนวนวันในปีวันที่กำหนด
                            $dayOfYear = 366;
                        }else{
                            $dayOfYear = 365;
                        }


                        if(date('Y-m-d') > $duedate_no_time){ //กรณี วันที่เกินวันที่กำหนด
                            $now            = time();
                            $duedate_dif    = strtotime($duedate_no_time);
                            $datediff       = $now - $duedate_dif;
                            $dayduedate     = round($datediff / (60*60*24));
                            $dayduedate     -= 1;
                        }else{
                            $dayduedate     = 0;
                        }

                    }else{
                        $dayduedate     = 0;
                    }

                    if(!empty($order_item->credit_group_code)){ // check group credit 0 เงินสด  2,3 เงินเชื่อ
                        $contact    = CreditGroupModel::where('lookup_code',$order_item->credit_group_code)->first();
                        if($contact){
                            $contact_data    = $contact->description;
                            $contact_id      = $contact->lookup_code;
                        }else{
                            $contact_data    = '';
                            $contact_id      = $order_item->credit_group_code;
                        }
                    }else{
                        if($order_item->credit_group_code == 0){
                            $contact_data    = 'เงินสด';
                            $contact_id      = 0;
                        }else{
                            $contact_data    = '';
                            $contact_id      = '';
                        }
                    }

                    $data[$order_item->pick_release_no][$order_item->credit_group_code]   = [ //ข้อมูล order header / line
                        'line_id'           => !empty($orderline)? $orderline->invoice_line_id : '' ,
                        'id'                => $order_item->order_header_id,
                        'number'            => $order_item->pick_release_no,
                        'amount'            => $order_item->amount,
                        'amount_invoice'    => !empty($orderline)? $orderline->payment_amount  : '',
                        'cash'              => $order_item->cash_amount,
                        'credit'            => $order_item->credit_amount,
                        'order_date'        => !empty($order_item->order_date)? $date_order : '',
                        'payment_duedate'   => !empty($order_item->delivery_date)? $date_duedate : '',
                        'contact'           => $contact_data,
                        'contact_id'        => $contact_id,
                        'day'               => !empty($order_item->delivery_date)? $total_day : '0',
                        'check'             => !empty($orderline)? 'Yes' : 'No',
                        'payover'           => !empty($order_item->delivery_date)? number_format($order_item->amount * ($dayduedate * 0.15 / $dayOfYear),2,'.',',') : '0.001',
                        'delivery_date'     => $order_item->delivery_date,
                        'type'              => 'order',
                        'linedata'          => !empty($orderline)? 'Yes' : 'No',
                        'line'              => $orderline,
                        'product_type'      => $order_item->product_type_code,
                        'final_date'              => $final_date,
                        'duedate_no_time'              => $duedate_no_time,
                        'dayduedate'        => $dayduedate
                        
                    ];
                    if(!isset($data[$order_item->pick_release_no][$order_item->credit_group_code]['total_group'])){ //เตรียท index ตัวแปรสำหรับใช้เก็บยอดรวม
                        $data[$order_item->pick_release_no][$order_item->credit_group_code]['total_group'] = 0;
                        $total_group = 0;
                    }

                    $data[$order_item->pick_release_no][$order_item->credit_group_code]['total_group'] += $order_item->amount; // ยอดรวมทั้งหมดของ กลุ่มวงเงิน
                    $total_group += $order_item->amount;

                    if(!empty($order_item->delivery_date)){ //ค่าปรับตามข้อมูลกลุ่มวงเงิน
                        $total_over = 0;
                        $total_over = $total_group * 0.15 * $dayduedate / $dayOfYear ;
                        $data[$order_item->pick_release_no][$order_item->credit_group_code]['payover'] = number_format($total_over,2,'.',',');
                    }else{
                        $data[$order_item->pick_release_no][$order_item->credit_group_code]['payover'] = 0;
                    }
                }

                $rest = [
                    'status'    => true,
                    'data'      => $data,
                    'type'      => 'order'
                ];
            }else{
                $data   = [];
                $rest = [
                    'status'    => false,
                    'data'      => $data,
                    'message'   => 'No Data Order'
                ];
            }

        }else{ // ลูกค้าที่เป็นสโมสร

            $order1     = OrderHeaderModel::leftJoin('ptom_order_lines','ptom_order_lines.order_header_id','=','ptom_order_headers.order_header_id')
                                            ->where('ptom_order_headers.customer_id',$request->customer_id)
                                            ->where('ptom_order_headers.pick_release_status','Confirm')
                                            ->where('ptom_order_headers.product_type_code','<>',10)
                                            ->whereNotNull('ptom_order_lines.credit_group_code')
                                            ->whereNotNull('ptom_order_headers.pick_release_no')
                                            ->get();

            $order      = OrderHeaderModel::join('ptom_consignment_headers','ptom_consignment_headers.order_header_id','=','ptom_order_headers.order_header_id')
                                                ->where('ptom_order_headers.product_type_code','=',10)
                                                ->where('ptom_order_headers.customer_id',$request->customer_id)
                                                ->whereNotNull('ptom_consignment_headers.consignment_no')
                                                ->where('ptom_consignment_headers.consignment_status','Confirm')
                                                ->get();
            if($order->count() > 0){
                foreach($order as $order_item){
                    if(!empty($request->invoice_id)){
                        $orderline  = InvoiceLineModel::where('invoice_headers_id',$request->invoice_id)->first();
                    }else{
                        $orderline = [];
                    }

                    if(!empty($order_item->consignment_date)){
                        $dateorder_no_time  = \explode(' ',$order_item->consignment_date);
                        $dateorder          = \explode('-',$dateorder_no_time[0]);
                        $year_order         = $dateorder[0] + 543;
                        $date_order         = $dateorder[2].'/'.$dateorder[1].'/'.$year_order;
                    }

                    if(!empty($order_item->delivery_date)){
                        $duedate = DB::table('ptom_terms_v')
                                            ->where('credit_group_code',$order_item->credit_group_code)
                                            ->where('sale_type','DOMESTIC')
                                            ->first();

                        $final_date = date('Y-m-d',strtotime($order_item->delivery_date." + ".$duedate->due_days." day"));

                        $duedate_no_time    = $final_date;
                        $duedate            = \explode('-',$duedate_no_time);
                        $year_duedate       = $duedate[0] + 543;
                        $date_duedate       = $duedate[2].'/'.$duedate[1].'/'.$year_duedate;

                        if ($duedate[0] % 4 == 0) { //หาจำนวนวันในปีวันที่กำหนด
                            $dayOfYear = 366;
                        }else{
                            $dayOfYear = 365;
                        }

                        if(date('Y-m-d') > $duedate_no_time){ //กรณี วันที่เกินวันที่กำหนด
                            $now            = time();
                            $duedate_dif    = strtotime($duedate_no_time);
                            $datediff       = $now - $duedate_dif;
                            $dayduedate     = round($datediff / (60*60*24));
                            $dayduedate     -= 1;
                        }else{
                            $dayduedate     = 0;
                        }

                    }else{
                        $dayduedate     = 0;
                    }

                    $data[$order_item->consignment_no][]   = [
                        'id'                => $order_item->order_header_id,
                        'number'            => $order_item->consignment_no,
                        'amount'            => $order_item->grand_total,
                        'amount_invoice'    => !empty($orderline)? $orderline->payment_amount  : '',
                        'cash'              => $order_item->cash_amount,
                        'credit'            => $order_item->credit_amount,
                        'order_date'        => !empty($order_item->order_date)? $date_order : '',
                        'payment_duedate'   => !empty($order_item->delivery_date)? $date_duedate : '',
                        'contact'           => !empty($contact)? $contact->description : '',
                        'delivery_date'     => $order_item->delivery_date,
                        'check'             => !empty($orderline)? 'Yes' : 'No',
                        'contact_id'        => !empty($contact)? $contact->lookup_code : '',
                        'type'              => 'consig',
                        'product_type'      => $order_item->product_type_code
                    ];
                }
            }

            if($order1->count() > 0){
                foreach($order1 as $order1_item){
                    if(!empty($request->invoice_id)){
                        $orderline  = InvoiceLineModel::where('invoice_headers_id',$request->invoice_id)->where('credit_group_code',$order_item->credit_group_code)->first();
                    }else{
                        $orderline = [];
                    }

                    if(!empty($order1_item->order_date)){
                        $dateorder_no_time  = \explode(' ',$order1_item->order_date);
                        $dateorder          = \explode('-',$dateorder_no_time[0]);
                        $year_order         = $dateorder[0] + 543;
                        $date_order         = $dateorder[2].'/'.$dateorder[1].'/'.$year_order;
                    }

                    if(!empty($order1_item->delivery_date)){
                        $duedate = DB::table('ptom_terms_v')
                                        ->where('credit_group_code',$order_item->credit_group_code)
                                        ->where('sale_type','DOMESTIC')
                                        ->first();
                        $total_day = $duedate->due_days;
                        $final_date = date('Y-m-d',strtotime($order1_item->delivery_date." + ".$duedate->due_days." day"));
    
                        $duedate_no_time    = \explode(' ',$final_date);
                        $duedate            = \explode('-',$duedate_no_time[0]);
                        $year_duedate       = $duedate[0] + 543;
                        $date_duedate       = $duedate[2].'/'.$duedate[1].'/'.$year_duedate;

                        if ($duedate[0] % 4 == 0) { //หาจำนวนวันในปีวันที่กำหนด
                            $dayOfYear = 366;
                        }else{
                            $dayOfYear = 365;
                        }

                        if(date('Y-m-d') > $duedate_no_time[0]){ //กรณี วันที่เกินวันที่กำหนด
                            $now            = time();
                            $duedate_dif    = strtotime($duedate_no_time[0]);
                            $datediff       = $now - $duedate_dif;
                            $dayduedate     = round($datediff / (60*60*24));
                            $dayduedate     -= 1;
                        }else{
                            $dayduedate     = 0;
                        }

                    }else{
                        $dayduedate     = 0;
                    }

                    if(!empty($order1_item->credit_group_code)){ // check group credit 0 เงินสด  2,3 เงินเชื่อ
                        if($order1_item->credit_group_code == 0){
                            $contact_data    = 'เงินสด';
                            $contact_id      = 0;
                        }else{
                            $contact    = CreditGroupModel::where('lookup_code',$order1_item->credit_group_code)->first();
                            if($contact){
                                $contact_data    = $contact->description;
                                $contact_id      = $contact->lookup_code;
                            }else{
                                $contact_data    = '';
                                $contact_id      = '';
                            }
                        }
                    }

                    $data[$order1_item->pick_release_no][$order1_item->credit_group_code]   = [ //ข้อมูล order header / line
                        'line_id'           => !empty($orderline)? $orderline->invoice_line_id : '' ,
                        'id'                => $order1_item->order_header_id,
                        'number'            => $order1_item->pick_release_no,
                        'amount'            => $order_item->grand_total,
                        'amount_invoice'    => !empty($orderline)? $orderline->payment_amount  : '',
                        'cash'              => $order1_item->cash_amount,
                        'credit'            => $order1_item->credit_amount,
                        'order_date'        => !empty($order1_item->order_date)? $date_order : '',
                        'payment_duedate'   => !empty($order1_item->delivery_date)? $date_duedate : '',
                        'contact'           => !empty($order1_item->credit_group_code)? $contact_data : '',
                        'contact_id'        => !empty($order1_item->credit_group_code)? $contact_id : '',
                        'day'               => !empty($order1_item->delivery_date)? $total_day : '0',
                        'check'             => !empty($orderline)? 'Yes' : 'No',
                        'payover'           => !empty($order1_item->delivery_date)? number_format($order1_item->total_amount * 0.15 * $dayduedate / $dayOfYear,2,'.',',') : '0.00',
                        'linedata'          => !empty($orderline)? 'Yes' : 'No',
                        'delivery_date'     => $order_item->delivery_date,
                        'type'              => 'order',
                        'product_type'      => $order1_item->product_type_code
                    ];
                    if(!isset($data[$order1_item->pick_release_no][$order1_item->credit_group_code]['total_group'])){ //เตรียท index ตัวแปรสำหรับใช้เก็บยอดรวม
                        $data[$order1_item->pick_release_no][$order1_item->credit_group_code]['total_group'] = 0;
                        $total_group = 0;
                    }

                    $data[$order1_item->pick_release_no][$order1_item->credit_group_code]['total_group'] += $order1_item->amount; // ยอดรวมทั้งหมดของ กลุ่มวงเงิน
                    $total_group += $order1_item->amount;

                    if(!empty($order1_item->delivery_date)){ //ค่าปรับตามข้อมูลกลุ่มวงเงิน
                        $total_over = 0;
                        $total_over = $total_group * 0.15 * $dayduedate / $dayOfYear ;
                        $data[$order1_item->pick_release_no][$order1_item->credit_group_code]['payover'] = number_format($total_over,2,'.',',');
                    }else{
                        $data[$order1_item->pick_release_no][$order1_item->credit_group_code]['payover'] = 0;
                    }
                }
            }

            if($data){
                $rest = [
                    'status'    => true,
                    'data'      => $data,
                ];
            }else{
                $data   = [];
                $rest = [
                    'status'    => false,
                    'data'      => $data,
                    'message'   => 'No Data Consignment'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function saveInvoice(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'customer_id'           => 'required',
            // 'price_amount'          => 'required',
            // 'number_order'          => 'required',
            // 'invoice_channel'       => 'required',
            'date_at'               => 'required',
            'approve_date'          => 'required',
            'type_payment'          => 'required',
        ],[
            'customer_id.required'              => 'กรุณาเลือกรหัสลูกค้า',
            // 'price_amount.required'             => 'กรุณากรอกจำนวนเงิน',
            // 'number_order.required'             => 'กรุณากรอกเลขที่',
            // 'invoice_channel.required'          => 'กรุณาเลือกทาง',
            'date_at.required'                  => 'กรุณาเลือกวันที่ ลงวันที่',
            'approve_date.required'             => 'กรุณาเลือกวันที่ วันที่อนุมัติ',
            'type_payment.required'             => 'กรุณาเลือกประเภทการรับเงิน',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{
            DB::beginTransaction();
            try{
                $header             = InvoiceHeaderModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->first();
                $customer           = CustomerModel::where('customer_id',$request->customer_id)->first();
                $terms_data         = TermsModel::where('due_days',$request->type_payment)
                                                ->where('sale_type','DOMESTIC')
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->first();

                $account        = MappingAccountModel::where('account_code','TRX-DOM-Sales Invoice-01')->first();
                // $accmap_cr      = AccountsMappingModel::where('account_code','06')->first();

                if(!empty($request->accountmapping_cid)){
                    $account       = AccountsMappingModel::where('account_code',$request->accountmapping_cid)->first();
                    $accmap_cr     = MappingAccountModel::where('account_code',$account->account_code)->first();
                }

                if(!empty($request->accountmapping_id)){
                    $accmap         = AccountsMappingModel::where('account_code',$request->accountmapping_id)->first();
                    $account_dr     = MappingAccountModel::where('account_code',$request->accountmapping_id)->first();
                }

                if (!empty($request->ceditnote_date)) {
                    $date_invoice = \explode('/', $request->ceditnote_date);
                    $invoice_year = $date_invoice[2] - 543;
                    $invoice_newdate = $invoice_year . '-' . $date_invoice[1] . '-' . $date_invoice[0];
                }

                if (!empty($request->date_at)) {
                    $date_document = \explode('/', $request->date_at);
                    $document_year = $date_document[2] - 543;
                    $document_date = $document_year . '-' . $date_document[1] . '-' . $date_document[0];
                }

                if(!empty($request->approve_date)){
                    $date_approve      = \explode('/',$request->approve_date);
                    $approve_year      = $date_approve[2] - 543;
                    $approve_date      = $approve_year.'-'.$date_approve[1].'-'.$date_approve[0];
                }

                $header_id          = '';
                $headers_number     = '';
                $header_status      = '';
                $line_id            = [];
                $customer = CustomerModel::where('customer_id',$request->customer_id)->first();

                if($header){
                    // $header->invoice_headers_number     = $request->ceditnote_number;                               //เลขที่ใบลดหนี้
                    $header->customer_id                = $request->customer_id;                                    //รหัสลูกค้า
                    $header->province_name              = $request->customer_provice_name;                          //จังหวัด
                    // $header->invoice_type               = 'CN_OTHER';                                               //ประเภท
                    $header->invoice_date               = !empty($request->ceditnote_date)? $invoice_newdate : '';  //วันที่
                    $header->invoice_amount             = !empty($request->price_amount_data)? str_replace(',','',$request->price_amount_data) : str_replace(',','',$request->price_amount);   //จำนวนเงิน
                    // $header->document_id                = $request->number_order;
                    $header->invoice_status             = 'Confirm';                                                  //สถานะ
                    // $header->document_date              = !empty($request->date_at)? $document_date : '';           //ลงวันที่
                    $header->document_number            = $request->number_order;                                   //เลขที่
                    $header->channel_receiving_code     = $request->invoice_channel;                                //ทาง
                    $header->term_id                    = $terms_data->term_id;                                     //ประเภทการรับเงิน
                    $header->ref_invoice_number         = $request->order_number_data;
                    // $header->total_amount               = $request->price_amount;
                    // $header->total_payment_amount       = $request->price_amount;
                    // $header->currency                   = 'THB';                                                    //หน่วยเงิน
                    $header->approve_document           = $request->approve_document;                               //เลขที่อนุมัติ
                    $header->apprrove_date              = !empty($request->approve_date)?  $approve_date  : '';    // วันที่อนุมัติ
                    $header->dr_account_id              = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $header->dr_account_code            = !empty($accmap->account_id) ? $request->accountmapping_id : '';
                    $header->dr_account_desc            = !empty($accmap->account_id) ? $request->input_mapping_name : '';
                    $header->dr_segment1                = !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code;
                    $header->dr_segment2                = !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm;
                    $header->dr_segment3                = !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code;
                    $header->dr_segment4                = !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center;
                    $header->dr_segment5                = !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year;
                    $header->dr_segment6                = !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type;
                    $header->dr_segment7                = !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail;
                    $header->dr_segment8                = !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason;
                    $header->dr_segment9                = !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account;
                    $header->dr_segment10               = !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account;
                    $header->dr_segment11               = !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1;
                    $header->dr_segment12               = !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2;
                    //---------------------------------------------------------------------------------------------------------------
                    $header->cr_account_id              = !empty($account->account_id) ? $account->account_id : '';
                    $header->cr_account_code            = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $header->cr_account_desc            = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
                    $header->cr_segment1                = !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code;
                    $header->cr_segment2                = !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm;
                    $header->cr_segment3                = !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code;
                    $header->cr_segment4                = !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center;
                    $header->cr_segment5                = !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year;
                    $header->cr_segment6                = !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type;
                    $header->cr_segment7                = !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail;
                    $header->cr_segment8                = !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason;
                    $header->cr_segment9                = !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account;
                    $header->cr_segment10               = !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account;
                    $header->cr_segment11               = !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1;
                    $header->cr_segment12               = !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2;
                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        $header->attribute3                 = 'Y';
                    }else{
                        $header->attribute3                 = 'N';
                    }
                    $header->last_updated_by            = optional(auth()->user())->user_id;
                    $header->last_update_date           = date('Y-m-d H:i:s');
                    $header->save();

                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        foreach($request->payment_status as $key_line => $item_line){
                            $line                           = InvoiceLineModel::where('invoice_line_id',$request->invoice_line[$key_line])->first();
                            // $line->document_id              = $request->order_id;
                            $line->payment_amount           = str_replace(',','',$request->payment_total[$key_line]);
                            // $line->uom_code                 = 'คิดเป็นพันมวน';
                            // $line->conversion_rate          = '1';
                            $line->invoice_flag             = !empty($request->payment_status[$key_line])? 'Y' : 'N';
                            $line->ref_invoice_number         = $request->order_number_data;
                            // $line->currency                 = 'THB';
                            $line->credit_group_code        = $request->creadit_group[$key_line];
                            $line->last_updated_by          = optional(auth()->user())->user_id;
                            $line->last_update_date         = date('Y-m-d H:i:s');
                            $line->save();

                            $amount_l = str_replace(',','',$request->payment_total[$key_line]);
                            $real_amount_l = explode('.',$amount_l);

                            //check type user
                            if($customer->customer_type_id == 30 || $customer->customer_type_id == 40){
                                //if customer is consignment
                                $dept = OutstandingDebtModel::where('consignment_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }elseif($request->product_type == 10){
                                //if product is type 10
                                $dept = OutstandingDebtModel::where('consignment_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }else{
                                //if order normal
                                $dept = OutstandingDebtModel::where('pick_release_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }

                            // check dept payment
                            if(empty($dept)){
                                $cndn = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $cndn->invoice_number       =  $header->invoice_headers_number;
                                $cndn->invoice_header_id    = $header->invoice_headers_id;
                                $cndn->invoice_amount       = str_replace(',','',$request->payment_total[$key_line]);
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();

                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }
                            }elseif($dept >= $real_amount_l[0]){
                                $paymentApply                       = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $header->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $header->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();
                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }
                            }elseif($dept < $real_amount_l[0]){  
                                $paymentApply                       = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $header->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $header->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();
                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }

                                $less = str_replace(',','',$request->payment_total[$key_line]) - $dept *1;

                                $cndn = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $cndn->invoice_number       = $header->invoice_headers_number;
                                $cndn->invoice_header_id    = $header->invoice_headers_id;
                                $cndn->invoice_amount       = $less;
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();
                            }
                        }
                    }

                }else{
                    $invoice_number = GenerateNumberRepo::generateCreditNoteOtherNumberDomestics();

                    $header                             = new InvoiceHeaderModel();
                    $header->invoice_headers_number     = $invoice_number;                               //เลขที่ใบลดหนี้
                    $header->customer_id                = $request->customer_id;                                    //รหัสลูกค้า
                    $header->province_name              = $request->customer_provice_name;                          //จังหวัด
                    $header->invoice_type               = 'CN_OTHER';                                               //ประเภท
                    $header->invoice_date               = !empty($request->ceditnote_date)? $invoice_newdate : '';  //วันที่
                    $header->invoice_amount             = !empty($request->price_amount_data)? str_replace(',','',$request->price_amount_data) : str_replace(',','',$request->price_amount);  //จำนวนเงิน
                    // $header->document_id                = $request->number_order;
                    $header->invoice_status             = 'Confirm';                                                  //สถานะ
                    $header->document_date              = !empty($request->date_at)? $document_date : '';           //ลงวันที่
                    $header->document_number            = $request->number_order;                                   //เลขที่
                    $header->channel_receiving_code     = $request->invoice_channel;                                //ทาง
                    $header->term_id                    = $terms_data->term_id;                                     //ประเภทการรับเงิน
                    $header->ref_invoice_number         = $request->order_number_data;
                    // $header->total_amount               = $request->price_amount;
                    // $header->total_payment_amount       = $request->price_amount;
                    $header->currency                   = 'THB';                                                    //หน่วยเงิน
                    $header->approve_document           = $request->approve_document;                               //เลขที่อนุมัติ
                    $header->apprrove_date              = !empty($request->approve_date)?  $approve_date  : '';    // วันที่อนุมัติ
                    $header->dr_account_id              = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $header->dr_account_code            = !empty($accmap->account_id) ? $request->accountmapping_id : '';
                    $header->dr_account_desc            = !empty($accmap->account_id) ? $request->input_mapping_name : '';
                    if(empty($request->accountmapping_debit)){
                        $header->dr_segment1           = '';
                        $header->dr_segment2           = '';
                        $header->dr_segment3           = '';
                        $header->dr_segment4           = '';
                        $header->dr_segment5           = '';
                        $header->dr_segment6           = '';
                        $header->dr_segment7           = '';
                        $header->dr_segment8           = '';
                        $header->dr_segment9           = '';
                        $header->dr_segment10          = '';
                        $header->dr_segment11          = '';
                        $header->dr_segment12          = '';
                    }else{
                        $header->dr_segment1                = !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code;
                        $header->dr_segment2                = !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm;
                        $header->dr_segment3                = !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code;
                        $header->dr_segment4                = !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center;
                        $header->dr_segment5                = !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year;
                        $header->dr_segment6                = !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type;
                        $header->dr_segment7                = !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail;
                        $header->dr_segment8                = !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason;
                        $header->dr_segment9                = !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account;
                        $header->dr_segment10               = !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account;
                        $header->dr_segment11               = !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1;
                        $header->dr_segment12               = !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2;
                    }
                      //---------------------------------------------------------------------------------------------------------------
                    $header->cr_account_id              = !empty($account->account_id) ? $account->account_id : '';
                    $header->cr_account_code            = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $header->cr_account_desc            = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
                    if(empty($request->accountmapping_cedit)){
                        $header->cr_segment1           = '';
                        $header->cr_segment2           = '';
                        $header->cr_segment3           = '';
                        $header->cr_segment4           = '';
                        $header->cr_segment5           = '';
                        $header->cr_segment6           = '';
                        $header->cr_segment7           = '';
                        $header->cr_segment8           = '';
                        $header->cr_segment9           = '';
                        $header->cr_segment10          = '';
                        $header->cr_segment11          = '';
                        $header->cr_segment12          = '';
                    }else{
                        $header->cr_segment1                = !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code;
                        $header->cr_segment2                = !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm;
                        $header->cr_segment3                = !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code;
                        $header->cr_segment4                = !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center;
                        $header->cr_segment5                = !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year;
                        $header->cr_segment6                = !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type;
                        $header->cr_segment7                = !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail;
                        $header->cr_segment8                = !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason;
                        $header->cr_segment9                = !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account;
                        $header->cr_segment10               = !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account;
                        $header->cr_segment11               = !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1;
                        $header->cr_segment12               = !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2;
                    }
                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        $header->attribute3                 = 'Y';
                    }else{
                        $header->attribute3                 = 'N';
                    }
                    $header->program_code               = 'OMP0033';
                    $header->created_by                 = optional(auth()->user())->user_id;
                    $header->creation_date              = date('Y-m-d H:i:s');
                    $header->last_updated_by            = optional(auth()->user())->user_id;
                    $header->last_update_date           = date('Y-m-d H:i:s');
                    $header->save();

                    $header_id          = $header->invoice_headers_id;
                    $header_status      = $header->invoice_status;
                    $headers_number     = $header->invoice_headers_number;

                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        foreach($request->payment_status as $key_line => $item_line){
                            $line                           = new InvoiceLineModel();
                            $line->invoice_headers_id       = $header->invoice_headers_id;
                            $line->document_id              = $request->order_id;
                            $line->payment_amount           = str_replace(',','',$request->payment_total[$key_line]);
                            // $line->uom_code                 = 'คิดเป็นพันมวน';
                            $line->conversion_rate          = '1';
                            $line->ref_invoice_number       = $request->order_number_data;
                            $line->invoice_flag             = !empty($request->payment_status[$key_line])? 'Y' : 'N';
                            $line->currency                 = 'THB';
                            $line->credit_group_code        = $request->creadit_group[$key_line];
                            $line->program_code             = 'OMP0033';
                            $line->created_by               = optional(auth()->user())->user_id;
                            $line->creation_date            = date('Y-m-d H:i:s');
                            $line->last_updated_by          = optional(auth()->user())->user_id;
                            $line->last_update_date         = date('Y-m-d H:i:s');
                            $line->save();

                            $line_id[$key_line]     = $line->invoice_line_id;

                            $amount_l = str_replace(',','',$request->payment_total[$key_line]);
                            $real_amount_l = explode('.',$amount_l);

                            //check type user
                            if($customer->customer_type_id == 30 || $customer->customer_type_id == 40){
                                //if customer is consignment
                                $dept = OutstandingDebtModel::where('consignment_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }elseif($request->product_type == 10){
                                //if product is type 10
                                $dept = OutstandingDebtModel::where('consignment_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }else{
                                //if order normal
                                $dept = OutstandingDebtModel::where('pick_release_no',$request->order_number_data)->where('credit_group_code',$request->creadit_group[$key_line])->sum('outstanding_debt');
                            }

                            // check dept payment
                            if(empty($dept)){
                                $cndn = new PaymentDncnModel();
                                $cndn->invoice_number       =  $header->invoice_headers_number;
                                $cndn->invoice_header_id    = $header->invoice_headers_id;
                                $cndn->invoice_amount       = str_replace(',','',$request->payment_total[$key_line]);
                                $cndn->attribute2           = 'CN_OTHER';
                                $cndn->program_code         = 'OMP0033';
                                $cndn->created_by           = optional(auth()->user())->user_id;
                                $cndn->creation_date        = date('Y-m-d H:i:s');
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();

                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }
                            }elseif($dept >= $real_amount_l[0]){
                                $paymentApply                       = new PaymentDncnModel();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $header->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $header->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->attribute2           = 'CN_OTHER';
                                $paymentApply->program_code         = 'OMP0033';
                                $paymentApply->created_by           = optional(auth()->user())->user_id;
                                $paymentApply->creation_date        = date('Y-m-d H:i:s');
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();

                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }
                            }elseif($dept < $real_amount_l[0]){  
                                $paymentApply                       = new PaymentDncnModel();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $header->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $header->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->attribute2           = 'CN_OTHER';
                                $paymentApply->program_code         = 'OMP0033';
                                $paymentApply->created_by           = optional(auth()->user())->user_id;
                                $paymentApply->creation_date        = date('Y-m-d H:i:s');
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();

                                if($request->creadit_group[$key_line] != 0){
                                    $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                        ->where('credit_group_code',$request->creadit_group[$key_line])
                                                                        ->first();
                                    $ccg->remaining_amount = $ccg->remaining_amount + $real_amount_l[0];
                                    $ccg->save();
                                }

                                $less = str_replace(',','',$request->payment_total[$key_line]) - $dept *1;

                                $cndn = new PaymentDncnModel();
                                $cndn->invoice_number       = $header->invoice_headers_number;
                                $cndn->invoice_header_id    = $header->invoice_headers_id;
                                $cndn->invoice_amount       = $less;
                                $cndn->attribute2           = 'CN_OTHER';
                                $cndn->program_code         = 'OMP0033';
                                $cndn->created_by           = optional(auth()->user())->user_id;
                                $cndn->creation_date        = date('Y-m-d H:i:s');
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();
                            }
                        }
                    }
                }

                $rest = [
                    'status'        => true,
                    'data'          => 'Complate',
                    'header'        => $header_id,
                    'header_number' => $headers_number,
                    'header_status' => $header_status,
                    'line_id'       => $line_id
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong',
                    'message'   => $e->getMessage().' Line:'.$e->getLine()
                ];
            }

            DB::commit();
            return response()->json(['data' => $rest]);
        }
    }

    public function searchInvoice(Request $request)
    {
        $data   = InvoiceHeaderModel::where('invoice_type','CN_OTHER')
                                    ->where(function($query) use($request){
                                        if(!empty($request->number)){
                                            $query->where('INVOICE_HEADERS_NUMBER',$request->number);
                                        }
                                    })
                                    ->first();

        // $line   = InvoiceLineModel::where('invoice_headers_id',$data->invoice_headers_id)
        //                             ->join('ptom_order_headers','ptom_order_headers.order_header_id','=','ptom_invoice_lines.document_id')
        //                             ->first();

        if(!empty($data->customer_id)){
            $customer           = CustomerModel::where('customer_id',$data->customer_id)->first();
        }
        $terms_data         = TermsModel::where('term_id',$data->term_id)
                                                ->where('sale_type','DOMESTIC')
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->first();

        $invoice_line   = InvoiceLineModel::where('invoice_headers_id',$data->invoice_headers_id)
                                            ->join('ptom_order_headers','ptom_order_headers.order_header_id','=','ptom_invoice_lines.document_id')
                                            ->get();

        $account_dr         = AccountsMappingModel::where('account_code',$data->dr_account_code)->first();
        $account_cr         = AccountsMappingModel::where('account_code',$data->cr_account_code)->first();
        $itemline = '';
        if($invoice_line->count() > 0){
            foreach($invoice_line as $inv_item){
                $itemline = $inv_item->pick_release_no;

                $data_outpush['inv_line'][$inv_item->pick_release_no][$inv_item->credit_group_code] = [
                    'id'                => $inv_item->invoice_line_id,
                    'payment_amount'    => $inv_item->payment_amount,
                    'invoice_flag'      => $inv_item->invoice_flag,
                ];
            }
        }else{
            $data_outpush['inv_line'] = '';
        }


        $data->customer_number  = !empty($customer)? $customer->customer_number : '';
        $data->approve_date     = !empty($data->apprrove_date)? GlobalToDateThai($data->apprrove_date) : '';
        $data->document_date    = !empty($data->document_date)? GlobalToDateThai($data->document_date) : '';
        $data->date_invoice     = !empty($data->invoice_date)? GlobalToDateThai($data->invoice_date) : '';
        $data->term_data        = !empty($terms_data)? $terms_data->due_days : '';
        $data->item_line        = !empty($itemline)? $itemline : '';
        $data->acc_code         =  !empty($account_dr)? $account_dr->account_combine : '';
        $data->accr_code        =  !empty($account_cr)? $account_cr->account_combine : '';

        $rest = [
            'status'    => true,
            'data'      => $data,
            'line'      => $data_outpush
        ];

        return response()->json(['data' => $rest]);
    }

    public function cancelInvoice(Request $request)
    {
        DB::beginTransaction();

        try {
            $update = [
                'invoice_status'            => 'Cancelled',
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];
            $data = InvoiceHeaderModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->update($update);
    
            $updatePayment = [
                'attribute1'           => 'C',
                'last_updated_by'      => optional(auth()->user())->user_id,
                'last_update_date'     => date('Y-m-d H:i:s')
            ];
            $paymentApply = PaymentDncnModel::where('invoice_header_id',$request->cedirnote_invoice_id)->update($updatePayment);
    
            $line = InvoiceLineModel::where('invoice_headers_id',$request->invoice_headers_id)->get();
            foreach($line as $line_item){
                if($line_item->credit_group_code != 0){
                    $ccg = CustomerContractGroupModel::where('customer_id',$data->customer_id)
                                                        ->where('credit_group_code',$line_item->credit_group_code)
                                                        ->first();
                    $ccg->remaining_amount = $ccg->remaining_amount - $line_item->invoice_amount;
                    $ccg->save();
                }
            }
            
            $rest = [
                'status'    => true,
                'data'      => 'Complate',
            ];

            DB::commit();
            return response()->json(['data' => $rest]);
        } catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong',
                'message'   => $e->getMessage().' Line:'.$e->getLine()
            ];

            return response()->json(['data' => $rest]);
        }
    }
}
