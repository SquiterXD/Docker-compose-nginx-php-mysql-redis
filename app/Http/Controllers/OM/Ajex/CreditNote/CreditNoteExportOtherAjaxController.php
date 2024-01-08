<?php

namespace App\Http\Controllers\OM\Ajex\CreditNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
use App\Models\OM\DebitNote\ProformaInvoiceModel;
use App\Models\OM\DebitNote\ProformaInvoiceLineModel;
use App\Models\OM\CreditNote\PaymentTypeModel;
use App\Models\OM\DebitNote\UomConversionModel;

use App\Models\OM\CreditNote\PaymentDncnModel;
use App\Models\OM\CreditNote\OutstandingDebtModel;

use App\Repositories\OM\GenerateNumberRepo;
use Illuminate\Support\Facades\Log;

class CreditNoteExportOtherAjaxController extends Controller
{
    public function getCustomer(Request $request)
    {
        // $thaiprovince = ThaiTerritoryModel::select('province_id','province_thai')->groupBy('province_id','province_thai')->get();
        // foreach($thaiprovince as $province_list){
        //     $data['province'][$province_list->province_id] = [
        //         'name'      => $province_list->province_thai
        //     ];
        // }

        $customer = CustomerModel::where('sales_classification_code','Export')
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
                'county'    => $customer_list->country_code,
                'currency'  => $customer_list->currency
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function getCreditNoteList(Request $request)
    {
        $list  = InvoiceHeaderModel::where('program_code','OMP0077')
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

            $date_nt    = \explode(' ',$list_item->invoice_date);
            $date_n     = \explode('-',$date_nt[0]);
            $year       = $date_n[0] + 543;
            $date       = $date_n[2].'/'.$date_n[1].'/'.$year;

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

    public function get_product_order(Request $request)
    {
        $customer = CustomerModel::where('customer_number',$request->customer_id)->first();
        if($customer->customer_type_id == 30){

        }else if($customer->customer_type_id == 40){

        }else{

        }
        pr($customer);
        pr($request->all());
    }

    public function createCreditNote()
    {
        $date =  date('d/m');
        $year =  date('Y');
        $ndate =  $date.'/'.$year;

        // $last_invoice   = InvoiceHeaderModel::where('invoice_headers_id','36')->orderBy('invoice_headers_number','desc')->first();

        // if(!empty($last_invoice)){
        //     $number = \explode('POSIN',$last_invoice->invoice_headers_number);
        //     if(is_numeric($number[1])){
        //         $newnumber = sprintf('%04d', 1);
        //         $newnumber = sprintf('%04d', $number[1]+1);
        //     }else{
        //         $newnumber = sprintf('%04d', 1);
        //     }
        //     $invoice_number = 'POSIN'.$newnumber;
        // }else{
        //     $invoice_number = 'POSIN0001';
        // }

        // $invoice_number = GenerateNumberRepo::generateCreditNoteOtherExportDomestics();

        $rest = [
            'status'    => true,
            'data'      => [
                'number'    => '',
                'date'      =>  $ndate
            ]
        ];
        return response()->json(['data' => $rest]);
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
        $contact    = CustomerContractGroupModel::join('ptom_credit_group','ptom_credit_group.lookup_code','=','ptom_customer_contract_groups.credit_group_code')
                                                ->where('ptom_customer_contract_groups.customer_id',$request->customer_id)
                                                ->first();

        $order      = ProformaInvoiceModel::select('ptom_proforma_invoice_headers.*','ptom_order_headers.payment_duedate','ptom_order_headers.order_date')
                                        ->join('ptom_order_headers','ptom_order_headers.order_header_id','=','ptom_proforma_invoice_headers.order_header_id')
                                        ->where('ptom_proforma_invoice_headers.customer_id',$request->customer_id)
                                        ->where('ptom_proforma_invoice_headers.pick_release_status','Confirm')
                                        ->whereNotNull('ptom_proforma_invoice_headers.pick_release_no')
                                        // ->whereNotNull('ptom_order_lines.credit_group_code')
                                        // ->groupBy('ptom_order_credit_groups.order_header_id')
                                        ->orderBy('ptom_proforma_invoice_headers.creation_date','desc')
                                        ->get();
        if($order->count() > 0){
            foreach($order as $order_item){
                $orderline  = InvoiceLineModel::where('invoice_headers_id',$request->invoice_id)->first();
                $payment    = PaymentTypeModel::where('lookup_code',$order_item->payment_type_code)->first();
                $term       = TermsModel::where('term_id',$order_item->term_id)->first();
                $final_date = "";
                $dayduedate = 0;
                //คำนวนวันที่ครบกำหนด
                if(!empty($order_item->delivery_date)){
                    $final_date         = date('Y-m-d',strtotime("$order_item->delivery_date +$term->due_days day"));

                    $final_dateex       = \explode('-',$final_date);
                    $year_final       = $final_dateex[0];
                    $date_final       = $final_dateex[2].'/'.$final_dateex[1].'/'.$year_final;
                }else{
                    $final_date     = "";
                }

                if(!empty($order_item->delivery_date)){
                    $dateorder_no_time  = \explode(' ',$order_item->delivery_date);
                    $dateorder          = \explode('-',$dateorder_no_time[0]);
                    $year_order         = $dateorder[0];
                    $date_order         = $dateorder[2].'/'.$dateorder[1].'/'.$year_order;
                }
                
                if(!empty($final_date)){
                    if(date('Y-m-d') > $final_date){
                        // $date_at    = \explode(' ',$item->order_date);
                        // $date_end   = \explode(' ',$item->payment_duedate);

                        $d_start    = strtotime($final_date);
                        $d_end      = strtotime(date('Y-m-d'));
                        $datediff   = $d_end - $d_start;
                        $day        = round($datediff / (60 * 60 * 24));
                        
                        // $duedate_no_time    = \explode(' ',$item->payment_duedate);
                        $duedate            = \explode('-',$final_date);
                        $year_duedate       = $duedate[0] + 543;
                        $date_duedate       = $duedate[2].'/'.$duedate[1].'/'.$year_duedate;

                        if ($duedate[0] % 4 == 0) { //หาจำนวนวันในปีวันที่กำหนด
                            $dayOfYear = 366;
                        }else{
                            $dayOfYear = 365;
                        }

                        $dayduedate = $day;
                        // if(date('Y-m-d') > $duedate_no_time[0]){ //กรณี วันที่เกินวันที่กำหนด
                        //     $now            = time();
                        //     $duedate_dif    = strtotime($duedate_no_time[0]);
                        //     $datediff       = $now - $duedate_dif;
                        //     $dayduedate     = round($datediff / (60*60*24));
                        //     $dayduedate     -= 1;
                        // }else{
                        //     $dayduedate     = 0;
                        // }
                    }
                }else{
                    $dayduedate     = 0;
                }
                $data['list'][] = $order_item->pick_release_no;

                $data['data'][$order_item->pick_release_no] = [ //ข้อมูล order header / line
                    'line_id'           => !empty($orderline)? $orderline->invoice_line_id : '' ,
                    'id'                => $order_item->pi_header_id,
                    'number'            => $order_item->pick_release_no,
                    'total'             => $order_item->grand_total,
                    'amount'            => !empty($orderline)? $orderline->payment_amount  : $order_item->grand_total,
                    'payment'           => $payment->description,
                    'order_date'        => !empty($order_item->delivery_date)? $date_order : '',
                    'payment_duedate'   => !empty($final_date)? $date_final : '',
                    'day'               => $term->due_days,
                    'check'             => !empty($orderline)? 'Yes' : 'No',
                    'product_type'      => $order_item->product_type_code
                    // 'payover'           => !empty($final_date)?  : '0.00',
                ];

                if(!empty($final_date)){
                    if(date('Y-m-d') > $final_date){
                        $data['data'][$order_item->pick_release_no]['payover'] = number_format($order_item->total_amount * (0.15 * $dayduedate / $dayOfYear),2,'.',',');
                    }
                }else{
                    $data['data'][$order_item->pick_release_no]['payover'] = '0.00';
                }


                if(!isset($data['data'][$order_item->pick_release_no]['total_group'])){ //เตรียท index ตัวแปรสำหรับใช้เก็บยอดรวม
                    $data['data'][$order_item->pick_release_no]['total_group'] = 0;
                    $total_group = 0;
                }
                $data['data'][$order_item->pick_release_no]['total_group'] += $order_item->total_amount; // ยอดรวมทั้งหมดของ กลุ่มวงเงิน
                $total_group += $order_item->total_amount;
                if(!empty($final_date)){ //ค่าปรับตามข้อมูลกลุ่มวงเงิน
                    if(date('Y-m-d') > $final_date){
                        $total_over = 0;
                        $total_over = $total_group * 0.15 * $dayduedate / $dayOfYear ;
                        $data['data'][$order_item->pick_release_no]['payover'] = number_format($total_over,2,'.',',');
                    }
                }else{
                    $data['data'][$order_item->pick_release_no]['payover'] = 0;
                }
            }

            $rest = [
                'status'    => true,
                'data'      => $data,
                'type'      => 'order'
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No Data Order'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function saveInvoice(Request $request)
    {

        if($request->_type === "remark") {
            $invoice            = InvoiceHeaderModel::where('invoice_headers_number',$request->invoice_headers_number)->first();
            if($invoice) {
                $invoice->remark = $request->remark;
                $invoice->save();
            }
            return true;
        }
        $validate = Validator::make($request->all(),[
            'customer_id'           => 'required',
            // 'price_amount'          => 'required',
            'date_at'               => 'required',
            'approve_date'          => 'required',
            'type_payment'          => 'required',
        ],[
            'customer_id.required'              => 'กรุณาเลือกรหัสลูกค้า',
            // 'price_amount.required'             => 'กรุณากรอกจำนวนเงิน',
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

                if(empty($request->price_amount_data) && empty($request->price_amount)){
                    $rest = [
                        'status'    => false,
                        'type'      => 'validate',
                        'data'      => [
                            'price_amount'  => [ 'กรุณากรอกจำนวนเงิน' ]
                        ]
                    ];
                    return response()->json(['data'=>$rest]);
                }

                $invoice            = InvoiceHeaderModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->first();
                $customer           = CustomerModel::where('customer_id',$request->customer_id)->first();
                $terms_data         = TermsModel::where('due_days',$request->type_payment)
                                                ->where('sale_type','EXPORT')
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->first();

                if(!empty($request->accountmapping_cid)){
                    $account       = AccountsMappingModel::where('account_code',$request->accountmapping_cid)->first();
                    $accmap_cr     = MappingAccountModel::where('account_code',$account->account_code)->first();
                }

                if(!empty($request->accountmapping_id)){
                    $accmap         = AccountsMappingModel::where('account_code',$request->accountmapping_id)->first();
                    $account_dr     = MappingAccountModel::where('account_code',$accmap->account_code)->first();
                }

                if (!empty($request->ceditnote_date)) {
                    $date_invoice = \explode('/', $request->ceditnote_date);
                    $invoice_year = $date_invoice[2];
                    $invoice_newdate = $invoice_year . '-' . $date_invoice[1] . '-' . $date_invoice[0];
                }

                if (!empty($request->date_at)) {
                    $date_document = \explode('/', $request->date_at);
                    $document_year = $date_document[2];
                    $document_date = $document_year . '-' . $date_document[1] . '-' . $date_document[0];
                }

                if(!empty($request->approve_date)){
                    $date_approve      = \explode('/',$request->approve_date);
                    $approve_year      = $date_approve[2];
                    $approve_date      = $approve_year.'-'.$date_approve[1].'-'.$date_approve[0];
                }

                $line_id = [];
                $customer = CustomerModel::where('customer_id',$request->customer_id)->first();

                if($invoice){
                    // $invoice->invoice_invoices_number     = $request->ceditnote_number;                               //เลขที่ใบลดหนี้
                    $invoice->remark                    = $request->remark;                                    //หมายเหตุ
                    $invoice->customer_id               = $request->customer_id;                                    //รหัสลูกค้า
                    $invoice->province_name             = $request->customer_provice_name;                          //จังหวัด
                    // $invoice->invoice_type              = 'CN_OTHER';                                               //ประเภท
                    $invoice->invoice_date              = !empty($request->ceditnote_date)? $invoice_newdate : '';  //วันที่
                    $invoice->invoice_amount            = !empty($request->price_amount_data)? str_replace(',','',$request->price_amount_data) : str_replace(',','',$request->price_amount);   //จำนวนเงิน
                    // $invoice->document_id               = $request->number_order;
                    $invoice->invoice_status            = 'Confirm';                                                  //สถานะ
                    // $invoice->document_date             = !empty($request->date_at)? $document_date : '';           //ลงวันที่
                    $invoice->document_number           = $request->number_order;                                   //เลขที่
                    $invoice->channel_receiving_code    = $request->invoice_channel;                                //ทาง
                    $invoice->term_id                   = $terms_data->term_id;                                     //ประเภทการรับเงิน
                    $invoice->ref_invoice_number         = $request->order_number_data;
                    // $invoice->total_amount              = $request->price_amount;
                    // $invoice->total_payment_amount      = $request->price_amount;
                    $invoice->exchange_rate             = $request->convertion_rate;  
                    $invoice->currency                  = $request->currency_code;                                                  //หน่วยเงิน
                    $invoice->approve_document          = $request->approve_document;                               //เลขที่อนุมัติ
                    $invoice->apprrove_date             = !empty($request->approve_date)?  $approve_date  : '';    // วันที่อนุมัติ
                    $invoice->dr_account_id             = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $invoice->dr_account_code           = !empty($accmap->account_id) ? $request->accountmapping_id : '';
                    $invoice->dr_account_desc           = !empty($accmap->account_id) ? $request->input_mapping_name : '';
                    if(empty($request->accountmapping_debit)){
                        $invoice->dr_segment1           = '';
                        $invoice->dr_segment2           = '';
                        $invoice->dr_segment3           = '';
                        $invoice->dr_segment4           = '';
                        $invoice->dr_segment5           = '';
                        $invoice->dr_segment6           = '';
                        $invoice->dr_segment7           = '';
                        $invoice->dr_segment8           = '';
                        $invoice->dr_segment9           = '';
                        $invoice->dr_segment10          = '';
                        $invoice->dr_segment11          = '';
                        $invoice->dr_segment12          = '';
                    }else{
                        $invoice->dr_segment1               = !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code;
                        $invoice->dr_segment2               = !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm;
                        $invoice->dr_segment3               = !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code;
                        $invoice->dr_segment4               = !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center;
                        $invoice->dr_segment5               = !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year;
                        $invoice->dr_segment6               = !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type;
                        $invoice->dr_segment7               = !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail;
                        $invoice->dr_segment8               = !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason;
                        $invoice->dr_segment9               = !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account;
                        $invoice->dr_segment10              = !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account;
                        $invoice->dr_segment11              = !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1;
                        $invoice->dr_segment12              = !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2;
                    }
                    //---------------------------------------------------------------------------------------------------------------
                    $invoice->cr_account_id             = !empty($account->account_id) ? $account->account_id : '';
                    $invoice->cr_account_code           = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $invoice->cr_account_desc           = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
                    if(empty($request->accountmapping_debit)){
                        $invoice->cr_segment1           = '';
                        $invoice->cr_segment2           = '';
                        $invoice->cr_segment3           = '';
                        $invoice->cr_segment4           = '';
                        $invoice->cr_segment5           = '';
                        $invoice->cr_segment6           = '';
                        $invoice->cr_segment7           = '';
                        $invoice->cr_segment8           = '';
                        $invoice->cr_segment9           = '';
                        $invoice->cr_segment10          = '';
                        $invoice->cr_segment11          = '';
                        $invoice->cr_segment12          = '';
                    }else{
                        $invoice->cr_segment1               = !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code;
                        $invoice->cr_segment2               = !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm;
                        $invoice->cr_segment3               = !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code;
                        $invoice->cr_segment4               = !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center;
                        $invoice->cr_segment5               = !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year;
                        $invoice->cr_segment6               = !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type;
                        $invoice->cr_segment7               = !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail;
                        $invoice->cr_segment8               = !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason;
                        $invoice->cr_segment9               = !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account;
                        $invoice->cr_segment10              = !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account;
                        $invoice->cr_segment11              = !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1;
                        $invoice->cr_segment12              = !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2;
                    }
                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        $invoice->attribute3                 = 'Y';
                    }else{
                        $invoice->attribute3                 = 'N';
                    }
                    $invoice->last_updated_by           = optional(auth()->user())->user_id;
                    $invoice->last_update_date          = date('Y-m-d H:i:s');
                    $invoice->save();

                    $header_id          = $invoice->invoice_headers_id;
                    $header_status      = $invoice->invoice_status;
                    $headers_number     = $invoice->invoice_headers_number;

                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        foreach($request->payment_status as $key_line => $item_line){
                            $line                           = InvoiceLineModel::where('invoice_line_id',$request->invoice_line[$key_line])->first();
                            // $line->document_id              = $request->order_id;
                            $line->payment_amount           = str_replace(',','',$request->payment_total[$key_line]);
                            // $line->uom_code                 = '-';
                            $line->ref_invoice_number       = $request->order_number_data;
                            $line->invoice_flag             = !empty($request->payment_status[$key_line])? 'Y' : 'N';
                            $line->currency                 = $request->currency_code;
                            // $line->credit_group_code        = $request->creadit_group[$key_line];
                            $line->last_updated_by          = optional(auth()->user())->user_id;
                            $line->last_update_date         = date('Y-m-d H:i:s');
                            $line->save();

                            $amount_l = str_replace(',','',$request->payment_total[$key_line]);
                            $real_amount_l = explode('.',$amount_l);

                            $line_id[$key_line]     = $line->invoice_line_id;

                            //check type user
                            if($customer->customer_type_id == 30 || $customer->customer_type_id == 10){
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
                                $cndn->invoice_number       =  $invoice->invoice_headers_number;
                                $cndn->invoice_header_id    = $invoice->invoice_headers_id;
                                $cndn->invoice_amount       = str_replace(',','',$request->payment_total[$key_line]);
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();
                            }elseif($dept >= $real_amount_l[0]){
                                $paymentApply                       = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $invoice->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $invoice->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();
                            }elseif($dept < $real_amount_l[0]){  
                                $paymentApply                       = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $invoice->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $invoice->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();

                                $less = str_replace(',','',$request->payment_total[$key_line]) - $dept *1;

                                $cndn = PaymentDncnModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->where('credit_group_code',$request->creadit_group[$key_line])->first();
                                $cndn->invoice_number       = $invoice->invoice_headers_number;
                                $cndn->invoice_header_id    = $invoice->invoice_headers_id;
                                $cndn->invoice_amount       = $less;
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();
                            }
                        }
                    }

                }else{
                    $invoice_number = GenerateNumberRepo::generateCreditNoteOtherExportDomestics();

                    $invoice                            = new InvoiceHeaderModel();
                    
                    $invoice->remark                    = $request->remark;                                    //หมายเหตุ
                    $invoice->invoice_headers_number    = $invoice_number;                               //เลขที่ใบลดหนี้
                    $invoice->customer_id               = $request->customer_id;                                    //รหัสลูกค้า
                    // $invoice->province_name             = $request->customer_provice_name;                          //จังหวัด
                    $invoice->invoice_type              = 'CN_OTHER';                                               //ประเภท
                    $invoice->invoice_date              = !empty($request->ceditnote_date)? $invoice_newdate : '';  //วันที่
                    $invoice->invoice_amount            = !empty($request->price_amount_data)? str_replace(',','',$request->price_amount_data) : str_replace(',','',$request->price_amount);  //จำนวนเงิน
                    // $invoice->document_id               = $request->number_order;
                    $invoice->invoice_status            = 'Confirm';                                                  //สถานะ
                    $invoice->document_date             = !empty($request->date_at)? $document_date : '';           //ลงวันที่
                    $invoice->document_number           = $request->number_order;                                   //เลขที่
                    $invoice->channel_receiving_code    = $request->invoice_channel;                                //ทาง
                    $invoice->term_id                   = $terms_data->term_id;                                     //ประเภทการรับเงิน
                    $invoice->ref_invoice_number         = $request->order_number_data;
                    // $invoice->total_amount              = $request->price_amount;
                    // $invoice->total_payment_amount      = $request->price_amount;
                    $invoice->exchange_rate             = $request->convertion_rate;  
                    $invoice->currency                  = $request->currency_code;                                                    //หน่วยเงิน
                    $invoice->approve_document          = $request->approve_document;                               //เลขที่อนุมัติ
                    $invoice->apprrove_date             = !empty($request->approve_date)?  $approve_date  : '';    // วันที่อนุมัติ
                    $invoice->dr_account_id             = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $invoice->dr_account_code           = !empty($accmap->account_id) ? $request->accountmapping_id : '';
                    $invoice->dr_account_desc           = !empty($accmap->account_id) ? $request->input_mapping_name : '';
                    if(empty($request->accountmapping_debit)){
                        $invoice->dr_segment1           = '';
                        $invoice->dr_segment2           = '';
                        $invoice->dr_segment3           = '';
                        $invoice->dr_segment4           = '';
                        $invoice->dr_segment5           = '';
                        $invoice->dr_segment6           = '';
                        $invoice->dr_segment7           = '';
                        $invoice->dr_segment8           = '';
                        $invoice->dr_segment9           = '';
                        $invoice->dr_segment10          = '';
                        $invoice->dr_segment11          = '';
                        $invoice->dr_segment12          = '';
                    }else{
                        $invoice->dr_segment1               = !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code;
                        $invoice->dr_segment2               = !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm;
                        $invoice->dr_segment3               = !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code;
                        $invoice->dr_segment4               = !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center;
                        $invoice->dr_segment5               = !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year;
                        $invoice->dr_segment6               = !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type;
                        $invoice->dr_segment7               = !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail;
                        $invoice->dr_segment8               = !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason;
                        $invoice->dr_segment9               = !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account;
                        $invoice->dr_segment10              = !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account;
                        $invoice->dr_segment11              = !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1;
                        $invoice->dr_segment12              = !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2;
                    }
                    //--------------------------------------------------------------------------------------------------------------
                    $invoice->cr_account_id             = !empty($account->account_id) ? $account->account_id : '';
                    $invoice->cr_account_code           = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $invoice->cr_account_desc           = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
                    if(empty($request->accountmapping_debit)){
                        $invoice->cr_segment1           = '';
                        $invoice->cr_segment2           = '';
                        $invoice->cr_segment3           = '';
                        $invoice->cr_segment4           = '';
                        $invoice->cr_segment5           = '';
                        $invoice->cr_segment6           = '';
                        $invoice->cr_segment7           = '';
                        $invoice->cr_segment8           = '';
                        $invoice->cr_segment9           = '';
                        $invoice->cr_segment10          = '';
                        $invoice->cr_segment11          = '';
                        $invoice->cr_segment12          = '';
                    }else{
                        $invoice->cr_segment1               = !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code;
                        $invoice->cr_segment2               = !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm;
                        $invoice->cr_segment3               = !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code;
                        $invoice->cr_segment4               = !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center;
                        $invoice->cr_segment5               = !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year;
                        $invoice->cr_segment6               = !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type;
                        $invoice->cr_segment7               = !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail;
                        $invoice->cr_segment8               = !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason;
                        $invoice->cr_segment9               = !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account;
                        $invoice->cr_segment10              = !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account;
                        $invoice->cr_segment11              = !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1;
                        $invoice->cr_segment12              = !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2;
                    }
                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        $invoice->attribute3                 = 'Y';
                    }else{
                        $invoice->attribute3                 = 'N';
                    }
                    $invoice->program_code              = 'OMP0077';
                    $invoice->created_by                = optional(auth()->user())->user_id;
                    $invoice->creation_date             = date('Y-m-d H:i:s');
                    $invoice->last_updated_by           = optional(auth()->user())->user_id;
                    $invoice->last_update_date          = date('Y-m-d H:i:s');
                    $invoice->save();

                    $header_id          = $invoice->invoice_headers_id;
                    $header_status      = $invoice->invoice_status;
                    $headers_number     = $invoice->invoice_headers_number;

                    if(!empty($request->order_id) && !empty($request->payment_status)){
                        foreach($request->payment_status as $key_line => $item_line){
                            $line                           = new InvoiceLineModel();
                            $line->invoice_headers_id       = $invoice->invoice_headers_id;
                            $line->document_id              = $request->order_id;
                            $line->payment_amount           = str_replace(',','',$request->payment_total[$key_line]);
                            $line->ref_invoice_number       = $request->order_number_data;
                            // $line->uom_code                 = '-';
                            $line->invoice_flag             = !empty($request->payment_status[$key_line])? 'Y' : 'N';
                            $line->currency                 = $request->currency_code;
                            // $line->credit_group_code        = $request->creadit_group[$key_line];
                            $line->program_code             = 'OMP0077';
                            $line->created_by               = optional(auth()->user())->user_id;
                            $line->creation_date            = date('Y-m-d H:i:s');
                            $line->last_updated_by          = optional(auth()->user())->user_id;
                            $line->last_update_date         = date('Y-m-d H:i:s');
                            $line->save();

                            $amount_l = str_replace(',','',$request->payment_total[$key_line]);
                            $real_amount_l = explode('.',$amount_l);

                            $line_id[$key_line]     = $line->invoice_line_id;

                            //check type user
                            if($customer->customer_type_id == 30 || $customer->customer_type_id == 10){
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
                                $cndn->invoice_number       = $invoice->invoice_headers_number;
                                $cndn->invoice_header_id    = $invoice->invoice_headers_id;
                                $cndn->invoice_amount       = str_replace(',','',$request->payment_total[$key_line]);
                                $cndn->attribute2           = 'CN_OTHER';
                                $cndn->program_code         = 'OMP0033';
                                $cndn->created_by           = optional(auth()->user())->user_id;
                                $cndn->creation_date        = date('Y-m-d H:i:s');
                                $cndn->last_updated_by      = optional(auth()->user())->user_id;
                                $cndn->last_update_date     = date('Y-m-d H:i:s');
                                $cndn->save();
                            }elseif($dept >= $real_amount_l[0]){
                                $paymentApply                       = new PaymentDncnModel();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $invoice->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $invoice->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->attribute2           = 'CN_OTHER';
                                $paymentApply->program_code         = 'OMP0033';
                                $paymentApply->created_by           = optional(auth()->user())->user_id;
                                $paymentApply->creation_date        = date('Y-m-d H:i:s');
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();
                            }elseif($dept < $real_amount_l[0]){  
                                $paymentApply                       = new PaymentDncnModel();
                                $paymentApply->order_header_id      = $request->order_id;
                                $paymentApply->pick_release_no      = $request->order_number_data;
                                $paymentApply->credit_group_code    = $request->creadit_group[$key_line];
                                $paymentApply->invoice_number       = $invoice->invoice_headers_number;
                                $paymentApply->invoice_header_id    = $invoice->invoice_headers_id;
                                $paymentApply->invoice_amount       = !empty($request->payment_total[$key_line])? str_replace(',','',$request->payment_total[$key_line]) : str_replace(',','',$request->price_amount);
                                $paymentApply->attribute1           = 'Y';
                                $paymentApply->attribute2           = 'CN_OTHER';
                                $paymentApply->program_code         = 'OMP0033';
                                $paymentApply->created_by           = optional(auth()->user())->user_id;
                                $paymentApply->creation_date        = date('Y-m-d H:i:s');
                                $paymentApply->last_updated_by      = optional(auth()->user())->user_id;
                                $paymentApply->last_update_date     = date('Y-m-d H:i:s');
                                $paymentApply->save();

                                $less = str_replace(',','',$request->payment_total[$key_line]) - $dept *1;

                                $cndn = new PaymentDncnModel();
                                $cndn->invoice_number       = $invoice->invoice_headers_number;
                                $cndn->invoice_header_id    = $invoice->invoice_headers_id;
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
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());
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
                                            $query->where('invoice_headers_number',$request->number);
                                        }
                                    })
                                    ->first();
        if($data){
            if(!empty($data->customer_id)){
                $customer           = CustomerModel::where('customer_id',$data->customer_id)->first();
            }
            $terms_data         = TermsModel::where('term_id',$data->term_id)
                                                    ->where('sale_type','EXPORT')
                                                    ->where('start_date_active','<=',date('Y-m-d'))
                                                    ->first();

            $invoice_line   = InvoiceLineModel::where('invoice_headers_id',$data->invoice_headers_id)
                                                ->join('ptom_proforma_invoice_headers','ptom_proforma_invoice_headers.pi_header_id','=','ptom_invoice_lines.document_id')
                                                ->get();

            $account_cr     = AccountsMappingModel::where('account_code',$data->cr_account_code)->first();
            $account_dr     = AccountsMappingModel::where('account_code',$data->dr_account_code)->first();
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
            $data->accd_code        = !empty($account_dr)? $account_dr->account_combine : '';
            $data->accr_code        = !empty($account_cr)? $account_cr->account_combine : '';

            $rest = [
                'status'    => true,
                'data'      => $data,
                'line'      => $data_outpush
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No Data'
            ];
        }
        return response()->json(['data' => $rest]);
    }

    public function searchOrder(Request $request)
    {
        $orderheader    = ProformaInvoiceModel::where('pi_header_id',$request->ordernumber)->first();
        if($orderheader){
            $orderline      = ProformaInvoiceLineModel::where('pi_header_id',$orderheader->pi_header_id)->get();
            $uom            = UomConversionModel::where('domestic','Y')->get();
            foreach( $uom as $uom_item){
                $uom_data[$uom_item->uom_code] = [
                    'code'              => $uom_item->uom_code,
                    'conversion_rate'   => $uom_item->conversion_rate
                ];
            }
            $date_nt    = \explode(' ',$orderheader->order_date);
            $date_n     = \explode('-',$date_nt[0]);
            $year       = $date_n[0] + 543;
            $date       = $date_n[2].'/'.$date_n[1].'/'.$year;
            $data['header'] = [
                'id'        => $orderheader->pi_header_id,
                'number'    => $orderheader->pick_release_no,
                'date'      => $date
            ];
            foreach($orderline as $key_line => $orderline){
                $data['line'][] = [
                    'id'                    => $orderline->pi_line_id,
                    'item_id'               => $orderline->item_id,
                    'item_code'             => $orderline->item_code,
                    'description'           => $orderline->item_description,
                    'uom_code'              => $orderline->uom_code,
                    // 'credit_group_code'     => $orderline->credit_group_code,
                    'approve_cardboardbox'  => !empty($orderline->approve_cardboardbox)? $orderline->approve_cardboardbox : '0',
                    'approve_carton'        => !empty($orderline->approve_carton)? $orderline->approve_carton : '0',
                    'approve_total'         => !empty($orderline->approve_quantity)? $orderline->approve_quantity : '0'
                ];
            }
            $rest = [
                'status'    => true,
                'data'      => $data
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No data'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function cancelInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $invoice                            = InvoiceHeaderModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->first();
            $invoice->invoice_status            = 'Cancelled';
            $invoice->last_updated_by           = optional(auth()->user())->user_id;
            $invoice->last_update_date          = date('Y-m-d H:i:s');
            $invoice->save();

            $updatePayment = [
                'attribute1'           => 'C',
                'last_updated_by'      => optional(auth()->user())->user_id,
                'last_update_date'     => date('Y-m-d H:i:s')
            ];
            $paymentApply = PaymentDncnModel::where('invoice_header_id',$request->cedirnote_invoice_id)->update($updatePayment);

            $rest = [
                'status'    => true,
                'data'      => 'Complate',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong',
                'message'   => $e->getMessage()
            ];
        }
        DB::commit();
        return response()->json(['data' => $rest]);
    }
}
