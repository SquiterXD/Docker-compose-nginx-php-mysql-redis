<?php

namespace App\Http\Controllers\OM\Ajex\CreditNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\OM\CreditNote\RanchTransferModel;
use App\Models\OM\CreditNote\CustomerModel;
use App\Models\OM\CreditNote\ThaiTerritoryModel;
use App\Models\OM\CreditNote\ClubAssociationModel;
use App\Models\OM\CreditNote\ChannelReceivingModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\ConsigmentHeadersModel;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\CreditNote\TermsModel;
use App\Models\OM\CreditNote\RanchTransFerLineModel;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\CreditNote\OrderCreditNoteModel;
//-
use App\Models\OM\CreditNote\PaymentApplyCndnModel;
use App\Models\OM\CreditNote\OutstandingDebtModel;


use App\Repositories\OM\GenerateNumberRepo;

class CreditNoteRanchTransferAjaxController extends Controller
{
    public function get_customer(Request $request)
    {
        $thaiprovince = ThaiTerritoryModel::select('province_id','province_thai')->groupBy('province_id','province_thai')->get();
        foreach($thaiprovince as $province_list){
            $data['province'][$province_list->province_id] = [
                'name'      => $province_list->province_thai
            ];
        }

        $customer = CustomerModel::where('sales_classification_code','Domestic')
                                    ->where('customer_type_id','40')
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

    public function getCaditNoteList(Request $request)
    {
        $list  = RanchTransferModel::where('program_code','OMP0034')
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

    public function get_club_association()
    {
        $club = ClubAssociationModel::where('enabled_flag','Y')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->get();
        foreach($club as $club_item){
            $data['data'][$club_item->lookup_code] = [
                'id'    => $club_item->lookup_code,
                'code'  => $club_item->meaning,
                'name'  => $club_item->description
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function get_channel_receiving()
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

    public function get_account_mapping()
    {
        $account = AccountsMappingModel::where('active_flag','Y')->get();

        foreach($account as $account_item){
            $data['data'][$account_item->account_id] = [
                'id'    => $account_item->account_id,
                'code'  => $account_item->account_code,
                'name'  => $account_item->account_description
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function get_consignment(Request $request)
    {
        $wherein=[];
        //ถ้าส่ง Invoice id มา
        if(!empty($request->invoice_id)){
            // getline ทั้งหมดของ invoice id ที่ค้นหา
            $line = RanchTransFerLineModel::where('invoice_headers_id',$request->invoice_id)->get();
            $wherein[] = 0;
            //เอา document id เข้า array
            foreach($line as $line_item){
                $wherein[] = $line_item->document_id;
            }
        }

        //ดึงใบฝากขายทั้งหมดของ ลูกค้า หรือ ใบฝากขายใน array
        $data = ConsigmentHeadersModel::select('ptom_consignment_headers.*',
                                                'ptom_order_headers.order_date','ptom_order_headers.payment_duedate','ptom_order_headers.period_id','ptom_order_headers.delivery_date')
                                        ->leftJoin('ptom_order_headers','ptom_order_headers.order_header_id','=','ptom_consignment_headers.order_header_id')
                                        ->where(function($query) use($request,$wherein){
                                            //ถ้าส่ง Invoice id มา หาจาก array ที่เตรียมไว้
                                            if(!empty($request->invoice_id)){
                                                $query->whereIn('ptom_consignment_headers.consignment_header_id',$wherein);
                                            //ถ้า ไม่ได้ส่ง invoice id มาหาจาก customer id
                                            }else{
                                                $query->where('ptom_order_headers.customer_id',$request->customer_id);
                                            }
                                        })
                                        // ->where('ptom_order_headers.customer_id',$request->customer_id)
                                        // ->where('ptom_order_headers.order_status','Confirm')
                                        ->where('ptom_consignment_headers.consignment_status','Confirm')
                                        ->orderBy('ptom_consignment_headers.consignment_no','desc')
                                        ->get();

        //ดึงข้อมูลลูกค้าเพื่อเช็คประเภทลูกค้า และ group วงเงิน
        $customer = CustomerModel::leftJoin('ptom_payment_method_domestic','ptom_payment_method_domestic.lookup_code','=','ptom_customers.payment_method_id')
                                    ->where('customer_id',$request->customer_id)
                                    ->first();

        //get data สำหรับคำนวนค่าปรับ
        $consigduedate     = TermsModel::where('sale_type','DOMESTIC')->where('credit_group_code','0')->first();

        $data_list['total'] = 0;
        $data_list['total_payment'] = 0;
        if(!empty($data)){
            //loop data invoice ที่ confirm แล้วเพื่อหา จำนวนเงินที่ชำระแล้วทั้งหมดของใบฝากขาย
            foreach($data as $item_t){
                //ดึง invoice ตาม id ใบฝากขาย
                $c_line = RanchTransFerLineModel::select('ptom_invoice_lines.*','ptom_invoice_headers.invoice_status')
                                                ->where('ptom_invoice_lines.document_id',$item_t->consignment_header_id)
                                                ->join('ptom_invoice_headers','ptom_invoice_headers.invoice_headers_id','=','ptom_invoice_lines.invoice_headers_id')
                                                ->where('ptom_invoice_headers.invoice_status','Confirm')
                                                ->where('ptom_invoice_headers.program_code','OMP0034')
                                                ->orderBy('ptom_invoice_headers.invoice_headers_id','desc')
                                                ->first();

                if(!empty($c_line->document_id)){
                    if(!isset($consign_amount[$c_line->document_id]['sum'])){
                        $consign_amount[$c_line->document_id]['sum'] = 0;
                    }
    
                    $consign_amount[$c_line->document_id]['sum'] += $c_line->payment_amount;
                    $data_list['sum'] = $consign_amount;
                }
            }
            // loop data consignment
            foreach($data as $item){
                $amount_line = 0;
                $sum_amLine = 0;
                //ดึง invoice ตาม id ใบฝากขาย
                $line = RanchTransFerLineModel::select('ptom_invoice_lines.*','ptom_invoice_headers.invoice_status')
                                                ->where('ptom_invoice_lines.document_id',$item->consignment_header_id)
                                                ->join('ptom_invoice_headers','ptom_invoice_headers.invoice_headers_id','=','ptom_invoice_lines.invoice_headers_id')
                                                ->orderBy('ptom_invoice_headers.invoice_headers_id','desc')
                                                ->first();
                $dept = OutstandingDebtModel::where('customer_id',$request->customer_id)->where('consignment_no',$item->consignment_no)->first();
                //ถ้ามีข้อมูล invoice line 
                if(!empty($line)){
                    if(!empty($dept)){
                        //ถ้า invoice header id ส่งมา
                        if(empty($request->invoice_id)){
                            //check สถานะ header ถ้า invoice ถูกยกเลิก
                            if($line->invoice_status == 'Cancelled' || $line->invoice_status == 'Cancel'){
                                //แสดงรายการใหม่
                                $chk_line = false;
                            }else{
                                //ถ้ามีค่าจาก จำนวนเงินที่ชำระแล้วทั้งหมดของใบฝากขาย
                                if(!empty($consign_amount[$line->document_id])){

                                    $data_list['consign_amount'][$line->document_id] = $item->total_amount;

                                    //ถ้าไม่เท่ากับมูลค่าใบฝากขาย
                                    if($consign_amount[$line->document_id]['sum'] != $item->total_amount){
                                        //แสดงรายการใหม่
                                        $amount_line = $consign_amount[$item->consignment_header_id]['sum'];
                                        $chk_line = false;
                                    }else{   
                                        //ไม่แสดง
                                        $amount_line = 0;
                                        $chk_line = true;
                                    }
                                }else{
                                    //แสดงรายการใหม่
                                    $chk_line = false;
                                }
                            }
                        }else{
                            //ไม่แสดง
                            $chk_line = true;
                        }
                    }else{
                        //ไม่แสดง
                        $chk_line = true;
                    }
                }else{
                    if(!empty($dept)){
                        //แสดงรายการใหม่
                        $chk_line = false;
                    }else{
                        //ไม่แสดง
                        $chk_line = true;
                    }
                }

                //ถ้าลูกค้าสโมสร
                // if($customer->payment_method_id == 10 || $customer->payment_method_id == 60){
                //     $group_item = OrderCreditNoteModel::where('order_header_id',$item->order_header_id)
                //                                     ->where('order_line_id',0)
                //                                     ->where('amount','>',0)
                //                                     ->first();

                //     $duedate = DB::table('ptom_terms_v')
                //                         ->where('credit_group_code',0)
                //                         ->where('sale_type','DOMESTIC')
                //                         ->first();
                //     $group_data[0] = [
                //         'method'    => 'เงินสด',
                //         'group'     => 0,
                //         'duedate'   => !empty($duedate->due_days_consignment)? $duedate->due_days_consignment : 0,
                //         'amount'    => $group_item->amount
                //     ];
                // //ถ้าลูกค้าไม่ใช่สโมสร
                // }elseif($item->payment_type_code == '10'){
                //     $duedate = DB::table('ptom_terms_v')
                //                         ->where('credit_group_code',0)
                //                         ->where('sale_type','DOMESTIC')
                //                         ->first();
                //     $group_data[0] = [
                //         'method'    => 'เงินสด',
                //         'group'     => 0,
                //         'duedate'   => !empty($duedate->due_days_consignment)? $duedate->due_days_consignment : 0,
                //         'amount'    => $item->total_amount
                //     ];
                // }else{
                    //check credit group
                    $duedate = DB::table('ptom_terms_v')
                                            ->where('credit_group_code',0)
                                            ->where('sale_type','DOMESTIC')
                                            ->first();
                    $group_data[0] = [
                        'method'    => 'เงินสด',
                        'group'     => 0,
                        'duedate'   => !empty($duedate->due_days_consignment)? $duedate->due_days_consignment : 0,
                        'amount'    => $item->total_amount
                    ];
                    // $group = OrderCreditNoteModel::where('order_header_id',$item->order_header_id)
                    //                                 ->where('order_line_id',0)
                    //                                 ->where('amount','>',0)
                    //                                 ->get();

                    // foreach($group as $group_item){
                    //     if($group_item->credit_group_code != 0){
                    //         $group_dec = DB::table('ptom_credit_group')
                    //                                 ->where('lookup_code',$group_item->credit_group_code)
                    //                                 ->first();
                    //         $duedate = DB::table('ptom_terms_v')
                    //                                 ->where('credit_group_code',$group_item->credit_group_code)
                    //                                 ->where('sale_type','DOMESTIC')
                    //                                 ->first();
                    //         $group_data[$group_item->credit_group_code] = [
                    //             'method'    => $group_dec->description,
                    //             'group'     => $group_item->credit_group_code,
                    //             'duedate'   => !empty($duedate->due_days_consignment)? $duedate->due_days_consignment : 0,
                    //             'amount'    => $group_item->amount
                    //         ];
                    //     }else{
                    //         $duedate = DB::table('ptom_terms_v')
                    //                                 ->where('credit_group_code',0)
                    //                                 ->where('sale_type','DOMESTIC')
                    //                                 ->first();
                    //         $group_data[0] = [
                    //             'method'    => 'เงินสด',
                    //             'group'     => 0,
                    //             'duedate'   => !empty($duedate->due_days_consignment)? $duedate->due_days_consignment : 0,
                    //             'amount'    => $group_item->amount
                    //         ];
                    //     }
                    // }
                // }

                //ถ้าไม่่มี invoice id ส่งมา กรณีสร้างใหม่  และ check line เป็น false
                if(empty($request->invoice_id) && !$chk_line ){
                    //ดึงงวดของ ฝบฝากขาย
                    $period = PeriodModel::where('period_line_id',$item->period_id)->first();

                    foreach($group_data as $g_item){
                        //คำนวนวันที่ครบกำหนด
                        if(!empty($item->delivery_date)){
                            $final_date = date('Y-m-d',strtotime($item->delivery_date." + ".$g_item['duedate']." day"));
                        }

                        //ถ้าวันเกินกำหนด  ทำการคำนวนค่าปรับ และวัน
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
                        }else{
                            $dayduedate        = 0;
                        }

                        //set data สำหรับส่งไปแสดงผล
            
                        $data_list['data'][$item->consignment_no][$g_item['group']] = [
                            'curdition'     => '1',
                            'prerot'        => $period->period_no, //งวด
                            'number'        => $item->consignment_no, //เลขที่เอกสาร
                            'amount'        => !empty($amount_line)? abs($amount_line - $g_item['amount']) : $g_item['amount'], // จำนวนเงิน
                            'amline'        => !empty($amount_line)? $amount_line : 0,
                            'order_date'    => dateNoTimeNoSlad($item->delivery_date), //วันที่สั่งซื้อ
                            'final_date'    => !empty($item->delivery_date) ? dateNoTimeNoSlad($final_date) : '', //วันที่ครบกำหนด
                            'pay_group'     => $g_item['method'], //กลุ่มวงเงิน
                            'group_code'    => $g_item['group'],
                            'day_total'     => !empty($g_item['duedate'])? $g_item['duedate'] : 0, //จำนวนวัน
                            'amount_pay'    => !empty($line)? abs($amount_line - $g_item['amount']) : $g_item['amount'], //จำนวนเงินที่ชำระ
                            'id'            => $item->consignment_header_id, // id ใบฝากขาย
                            'delivery_date' => $item->delivery_date, // วันที่ส่ง
                            'payover'       => !empty($dayduedate)? number_format(($g_item['amount'] - $amount_line) * ($dayduedate * 0.15 / $dayOfYear),2,'.',',') : '0.00', //ค่าปรับ
                            'product_type'  => $item->product_type_code,
                            'consigamung'   => $g_item['amount']
                        ];

                        $data_list['total'] += !empty($amount_line)? $amount_line - $g_item['amount'] : $g_item['amount']; // รวมเงินเชื่อและสด

                        $data_list['total_payment'] += !empty($line)? $line->payment_amount  : $g_item['amount']; //จำนวนเงินที่ขำระ	
                    }

                }

                //ถ้ามี invoice id ส่งมา กรณีค้าหา และ check line เป็น true
                if(!empty($request->invoice_id) && $chk_line){
                    //ดึงงวดของ ฝบฝากขาย
                    $period = PeriodModel::where('period_line_id',$item->period_id)->first();

                    foreach ($group_data as $g_item) {
                        //คำนวนวันที่ครบกำหนด
                        if (!empty($item->delivery_date)) {
                            $final_date = date('Y-m-d',strtotime($item->delivery_date." + ".$g_item['duedate']." day"));
                        }

                        //ถ้าวันเกินกำหนด  ทำการคำนวนค่าปรับ และวัน
                        if (date('Y-m-d') > $final_date) {
                            // $date_at    = \explode(' ',$item->order_date);
                            // $date_end   = \explode(' ',$item->payment_duedate);

                            $d_start    = strtotime($final_date);
                            $d_end      = strtotime(date('Y-m-d'));
                            $datediff   = $d_end - $d_start;
                            $day        = round($datediff / (60 * 60 * 24));

                            // $duedate_no_time    = \explode(' ',$item->payment_duedate);
                            $duedate            = \explode('-', $final_date);
                            $year_duedate       = $duedate[0] + 543;
                            $date_duedate       = $duedate[2].'/'.$duedate[1].'/'.$year_duedate;

                            if ($duedate[0] % 4 == 0) { //หาจำนวนวันในปีวันที่กำหนด
                                $dayOfYear = 366;
                            } else {
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
                        } else {
                            $dayduedate        = 0;
                        }

                        //set data สำหรับส่งไปแสดงผล
                        $data_list['data'][$item->consignment_no][$g_item['group']] = [
                            'curdition'     => '2',
                            'line_id'       => !empty($line)? $line->invoice_line_id : '' ,
                            'prerot'        => $period->period_no,
                            'number'        => $item->consignment_no,
                            'amount'        => !empty($amount_line)? abs($amount_line - $g_item['amount']) : $g_item['amount'],
                            'order_date'    => dateNoTimeNoSlad($item->delivery_date),
                            'final_date'    => !empty($item->delivery_date) ? dateNoTimeNoSlad($final_date) : '',
                            'pay_group'     => $g_item['method'], //กลุ่มวงเงิน
                            'group_code'    => $g_item['group'],
                            'day_total'     => !empty($g_item['duedate'])? $g_item['duedate'] : 0,
                            'amount_pay'    => !empty($line)? abs($amount_line - $g_item['amount']) : !empty($line)? $line->payment_amount  : $g_item['amount'],
                            'id'            => $item->consignment_header_id,
                            'delivery_date' => $item->delivery_date,
                            'payover'       => !empty($item->payment_duedate)? number_format(($g_item['amount'] - $amount_line) * ($dayduedate * 0.15 / $dayOfYear), 2, '.', ',') : '0.00',
                            'check'         => !empty($line)? 'Yes' : 'No',
                            'product_type'  => $item->product_type_code,
                            'consigamung'   => $g_item['amount']
                        ];

                        $data_list['total'] += $g_item['amount']; // รวมเงินเชื่อและสด

                        $data_list['total_payment'] += !empty($line)? $line->payment_amount  : $g_item['amount']; //จำนวนเงินที่ขำระ
                    }
                }
            }
        }else{
            $data_list = []; //ถ้าไม่มีใบฝากขาย
        }

        return response()->json(['data' => $data_list]);
    }

    public function edit_invoice(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'ceditnote_date'        => 'required',
            'customer_id'           => 'required',
            'price_amount'          => 'required',
            // 'clubassocia_list'      => 'required',
            'clubassocia_id'        => 'required',
            'accountmapping_debit'   => 'required',
            'accountmapping_cedit'   => 'required',
            // 'invoice_on'            => 'required',
            // 'invoice_channel'       => 'required',
            // 'date_at'               => 'required',
            // 'invoice_date'          => 'required',
            // 'invoice_number'        => 'required',
            // 'type_payment'          => 'required',
            'key'                   => 'array|required',
        ],[
            'ceditnote_date.required'           => 'กรุณาเลือกวันที่',
            'customer_id.required'              => 'กรุณาเลือกรหัสลูกค้า',
            'price_amount.required'             => 'กรุณากรอกจำนวนเงิน',
            'clubassocia_id.required'           => 'กรุณาเลือกชำระผ่านสำนักงานยาสูบ',
            'accountmapping_debit.required'      => 'กรุณาเลือกเดบิต บัญชี',
            'accountmapping_cedit.required'      => 'กรุณาเลือกเคดิต บัญชี',
            // 'invoice_on.required'               => 'กรุณากรอกเลขที่',
            // 'invoice_channel.required'          => 'กรุณาเลือกทาง',
            // 'date_at.required'                  => 'กรุณาเลือกวันที่ ลงวันที่',
            // 'invoice_date.required'             => 'กรุณาเลือกวันที่ วันที่ใบเสร็จรับเงิน',
            // 'invoice_number.required'           => 'กรุณากรอกเลขที่ใบเสร็จรับเงิน',
            // 'type_payment.required'             => 'กรุณาเลือกประเภทการรับเงิน',
            'key.required'                      => 'กรุณาเลือกอย่างน้อย 1 รายการเพื่อทำการชำระเงิน'
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
                $check = RanchTransferModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->first();

                $date_invoice       = \explode('/',$request->ceditnote_date);
                $invoice_year       = $date_invoice[2] - 543;
                $invoice_newdate    = $invoice_year.'-'.$date_invoice[1].'-'.$date_invoice[0];

                // $terms_data     = TermsModel::where('due_days',$request->type_payment)
                //                             ->where('sale_type','DOMESTIC')
                //                             ->where('start_date_active','<=',date('Y-m-d'))
                //                             ->first();
                if(!empty($request->accountmapping_cid)){
                    $account       = AccountsMappingModel::where('account_code',$request->accountmapping_cid)->first();
                    $accmap_cr     = MappingAccountModel::where('account_code',$account->account_code)->first();
                }
                if(!empty($request->accountmapping_id)){
                    $accmap         = AccountsMappingModel::where('account_code',$request->accountmapping_id)->first();
                    $account_dr     = MappingAccountModel::where('account_code',$accmap->account_code)->first();
                }
                
                if (!empty($request->invoice_date)) {
                    $date_invoice = \explode('/', $request->ceditnote_date);
                    $invoice_year = $date_invoice[2] - 543;
                    $invoice_newdate2 = $invoice_year . '-' . $date_invoice[1] . '-' . $date_invoice[0];
                }else{
                    $invoice_newdate2 = '';
                }

                if (!empty($request->date_at)) {
                    $date_document = \explode('/', $request->date_at);
                    $document_year = $date_document[2] - 543;
                    $document_date = $document_year . '-' . $date_document[1] . '-' . $date_document[0];
                }else{
                    $document_date = '';
                }

                if($check){
                    $customer = CustomerModel::where('customer_id',$request->customer_id)->first();
                    $amount = str_replace(',','',$request->price_amount);
                    $real_amount = explode('.',$amount);
                   
                    $update = [
                        'customer_id'               => $request->customer_id,                   // ลูกค้า
                        'province_name'             => $request->customer_provice_name,         // จังหวัดลูกค้า
                        'invoice_date'              => $invoice_newdate,                        // วันที่ใบลดหนี้
                        'invoice_amount'            => $amount,                  // จำนวนเงิน
                        // 'document_id'               => $item,
                        // 'delivery_date'             => $request->delivery_date[$item],
                        // 'dr_account_id'             => $customer->accountmapping_list,
                        // 'dr_account_code'           => $customer->currency,
                        // 'dr_account_desc'           => 'Draft',
                        // 'invoice_status'            => 'Confirm',
                        // 'term_id'                   => $terms_data->term_id,                    //ประเภทการรับเงิน
                        'document_date'             => $document_date,     //ลงวันที่
                        'document_number'           => $request->invoice_on,                    //เลขที่
                        'channel_receiving_code'    => $request->invoice_channel,               //ทาง
                        // 'account_debit_type_code'   => $customer->type_payment,
                        'company_code'              => $request->clubassocia_id,                //ชำระผ่านสำนักงานยาสูบ
                        // 'total_amount'              => $request->price_amount,
                        // 'total_payment_amount'      => $request->amount_pay[$item],
                        'currency'                  => 'THB',                                   // สกุลเงิน
                        'receipt_ref_num'           => $request->invoice_number,                // เลขที่ใบเสร็จรับเงิน
                        'receipt_ref_date'          =>  $invoice_newdate2,// วันที่ใบเสร็จรับเงิน
                        'dr_account_id'             => !empty($accmap->account_id) ? $accmap->account_id : '',
                        'dr_account_code'           => !empty($accmap->account_id) ? $request->accountmapping_id : '',             // เดบิตบัญชี
                        'dr_account_desc'           => !empty($accmap->account_id) ? $request->input_mapping_name : '',            // ชื่อเดบิตบัญชี
                        'dr_segment1'               => !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code,
                        'dr_segment2'               => !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm,
                        'dr_segment3'               => !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code,
                        'dr_segment4'               => !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center,
                        'dr_segment5'               => !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year,
                        'dr_segment6'               => !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type,
                        'dr_segment7'               => !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail,
                        'dr_segment8'               => !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason,
                        'dr_segment9'               => !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account,
                        'dr_segment10'              => !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account,
                        'dr_segment11'              => !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1,
                        'dr_segment12'              => !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2,
                         //---------------------------------------------------------------------------------------------------------------
                        'cr_account_id'             => !empty($account->account_id) ? $account->account_id : '',
                        'cr_account_code'           => !empty($account->account_id) ? $request->accountmapping_cid : '',
                        'cr_account_desc'           => !empty($account->account_id) ? $request->input_mapping_ceditname : '',
                        'cr_segment1'               => !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code,
                        'cr_segment2'               => !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm,
                        'cr_segment3'               => !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code,
                        'cr_segment4'               => !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center,
                        'cr_segment5'               => !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year,
                        'cr_segment6'               => !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type,
                        'cr_segment7'               => !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail,
                        'cr_segment8'               => !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason,
                        'cr_segment9'               => !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account,
                        'cr_segment10'              => !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account,
                        'cr_segment11'              => !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1,
                        'cr_segment12'              => !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2,
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s'),
                    ];

                    if($request->type_save == 'confirm'){
                        $update['invoice_status']   = 'Confirm';
                    }

                    RanchTransferModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->update($update);
                    $lastupdate = RanchTransferModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->first();

                    $header_id          = $lastupdate->invoice_headers_id;
                    $header_status      = $lastupdate->invoice_status;
                    $headers_number     = $lastupdate->invoice_headers_number;

                    foreach($request->key as $key => $item){
                        $amount_l = str_replace(',','',$request->amount_pay[$item]);
                        $real_amount_l = explode('.',$amount_l);
                        $line = [
                            'payment_amount'            => $amount_l,
                            'currency'                  => $customer->currency,
                            'credit_group_code'         => !empty($request->groupcode[$item])? $request->groupcode[$item] : 0,
                            'invoice_flag'              => 'Y',
                            'ref_invoice_number'        => $request->pick_consing[$item],
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];
                        $linedata = RanchTransFerLineModel::where('invoice_line_id',$request->invoice_line[$item])->update($line);
                    }
                }else{
                    $customer = CustomerModel::where('customer_id',$request->customer_id)->first();
                    $amount = str_replace(',','',$request->price_amount);
                    $real_amount = explode('.',$amount);
                    $invoice_number = GenerateNumberRepo::generateCreditNoteRanchTransferNumberDomestics();

                    $insert = [
                        'invoice_headers_number'    => $invoice_number,
                        'customer_id'               => $request->customer_id,                   // ลูกค้า
                        'province_name'             => $request->customer_provice_name,         // จังหวัดลูกค้า
                        'invoice_type'              => 'CN_TRANFER',
                        'invoice_date'              => $invoice_newdate,                        // วันที่ใบลดหนี้
                        'invoice_amount'            => $amount,                  // จำนวนเงิน
                        // 'document_id'               => $item,
                        // 'delivery_date'             => $request->delivery_date[$item],
                        // 'dr_account_id'             => $customer->accountmapping_list,
                        // 'dr_account_code'           => $customer->currency,
                        // 'dr_account_desc'           => 'Draft',
                        // 'term_id'                   => $terms_data->term_id,                    //ประเภทการรับเงิน
                        'document_date'             =>  $document_date,     //ลงวันที่
                        'document_number'           => $request->invoice_on,                    //เลขที่
                        'channel_receiving_code'    => $request->invoice_channel,               //ทาง
                        // 'account_debit_type_code'   => $customer->type_payment,
                        'company_code'              => $request->clubassocia_id,                //ชำระผ่านสำนักงานยาสูบ
                        // 'total_amount'              => $request->price_amount,
                        // 'total_payment_amount'      => $request->amount_pay[$item],
                        'currency'                  => 'THB',                                   // สกุลเงิน
                        'receipt_ref_num'           => $request->invoice_number,                // เลขที่ใบเสร็จรับเงิน
                        'receipt_ref_date'          =>  $invoice_newdate2,// วันที่ใบเสร็จรับเงิน
                        'dr_account_id'             => !empty($accmap->account_id) ? $accmap->account_id : '',
                        'dr_account_code'           => !empty($accmap->account_id) ? $request->accountmapping_id : '',             // เดบิตบัญชี
                        'dr_account_desc'           => !empty($accmap->account_id) ? $request->input_mapping_name : '',            // ชื่อเดบิตบัญชี
                        'dr_segment1'               => !empty($accmap->account_id) ? $account_dr->segment1  : $request->company_code,
                        'dr_segment2'               => !empty($accmap->account_id) ? $account_dr->segment2  : $request->evm,
                        'dr_segment3'               => !empty($accmap->account_id) ? $account_dr->segment3  : $request->department_code,
                        'dr_segment4'               => !empty($accmap->account_id) ? $account_dr->segment4  : $request->cost_center,
                        'dr_segment5'               => !empty($accmap->account_id) ? $account_dr->segment5  : $request->budget_year,
                        'dr_segment6'               => !empty($accmap->account_id) ? $account_dr->segment6  : $request->budget_type,
                        'dr_segment7'               => !empty($accmap->account_id) ? $account_dr->segment7  : $request->budget_detail,
                        'dr_segment8'               => !empty($accmap->account_id) ? $account_dr->segment8  : $request->budget_reason,
                        'dr_segment9'               => !empty($accmap->account_id) ? $account_dr->segment9  : $request->main_account,
                        'dr_segment10'              => !empty($accmap->account_id) ? $account_dr->segment10 : $request->sub_account,
                        'dr_segment11'              => !empty($accmap->account_id) ? $account_dr->segment11 : $request->reserved1,
                        'dr_segment12'              => !empty($accmap->account_id) ? $account_dr->segment12 : $request->reserved2,
                        //---------------------------------------------------------------------------------------------------------------------
                        'cr_account_id'             => !empty($account->account_id) ? $account->account_id : '',
                        'cr_account_code'           => !empty($account->account_id) ? $request->accountmapping_cid : '',
                        'cr_account_desc'           => !empty($account->account_id) ? $request->input_mapping_ceditname : '',
                        'cr_segment1'               => !empty($account->account_id) ? $accmap_cr->segment1  : $request->cr_company_code,
                        'cr_segment2'               => !empty($account->account_id) ? $accmap_cr->segment2  : $request->cr_evm,
                        'cr_segment3'               => !empty($account->account_id) ? $accmap_cr->segment3  : $request->cr_department_code,
                        'cr_segment4'               => !empty($account->account_id) ? $accmap_cr->segment4  : $request->cr_cost_center,
                        'cr_segment5'               => !empty($account->account_id) ? $accmap_cr->segment5  : $request->cr_budget_year,
                        'cr_segment6'               => !empty($account->account_id) ? $accmap_cr->segment6  : $request->cr_budget_type,
                        'cr_segment7'               => !empty($account->account_id) ? $accmap_cr->segment7  : $request->cr_budget_detail,
                        'cr_segment8'               => !empty($account->account_id) ? $accmap_cr->segment8  : $request->cr_budget_reason,
                        'cr_segment9'               => !empty($account->account_id) ? $accmap_cr->segment9  : $request->cr_main_account,
                        'cr_segment10'              => !empty($account->account_id) ? $accmap_cr->segment10 : $request->cr_sub_account,
                        'cr_segment11'              => !empty($account->account_id) ? $accmap_cr->segment11 : $request->cr_reserved1,
                        'cr_segment12'              => !empty($account->account_id) ? $accmap_cr->segment12 : $request->cr_reserved2, 
                        'program_code'              => 'OMP0034',
                        'created_by'                => optional(auth()->user())->user_id,
                        'creation_date'             => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s'),
                    ];

                    if($request->type_save == 'confirm'){
                        $insert['invoice_status']   = 'Confirm';
                    }else{
                        $insert['invoice_status']   = 'Draft';
                    }

                    $lastinsert = RanchTransferModel::create($insert);

                    $header_id          = $lastinsert->invoice_headers_id;
                    $header_status      = $lastinsert->invoice_status;
                    $headers_number     = $lastinsert->invoice_headers_number;

                    foreach($request->key as $key => $item){
                        $amount_l = str_replace(',','',$request->amount_pay[$item]);
                        $real_amount_l = explode('.',$amount_l);

                        $line = [
                            'invoice_headers_id'        => $lastinsert->invoice_headers_id,
                            // 'uom_code'                  => 'U4',
                            'document_id'               => $item,
                            'payment_amount'            => $amount_l,
                            'credit_group_code'         => !empty($request->groupcode[$item])? $request->groupcode[$item] : 0,
                            'invoice_flag'              => 'Y',
                            'currency'                  => $customer->currency,
                            'ref_invoice_number'        => $request->pick_consing[$item],
                            'program_code'              => 'OMP0034',
                            'created_by'                => optional(auth()->user())->user_id,
                            'creation_date'             => date('Y-m-d H:i:s'),
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];

                        $linedata = RanchTransFerLineModel::create($line);

                        //check type user
                        if($customer->customer_type_id == 30 || $customer->customer_type_id == 40){
                            //if customer is consignment
                            $dept = OutstandingDebtModel::where('consignment_no',$request->pick_consing[$item])->where('credit_group_code',0)->sum('outstanding_debt');
                        }elseif($request->product_type[$item] == 10){
                            //if product is type 10
                            $dept = OutstandingDebtModel::where('consignment_no',$request->pick_consing[$item])->where('credit_group_code',0)->sum('outstanding_debt');
                        }else{
                            //if order normal
                            $dept = OutstandingDebtModel::where('pick_release_no',$request->pick_consing[$item])->where('credit_group_code',0)->sum('outstanding_debt');
                        }
                        // check dept payment
                        if(empty($dept)){
                            $cndn = new PaymentApplyCndnModel();
                            $cndn->invoice_number       =  $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $amount_l;
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();

                            if($request->groupcode[$item] != 0){
                                $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                    ->where('credit_group_code',$request->groupcode[$item])
                                                                    ->first();
                                $ccg->remaining_amount = $ccg->remaining_amount + $amount_l;
                                $ccg->save();
                            }
                        }elseif($dept >= $amount_l){
                            $cndn = new PaymentApplyCndnModel();
                            $cndn->order_header_id      = $item;
                            $cndn->pick_release_no      = $request->pick_consing[$item];
                            $cndn->credit_group_code    = $request->groupcode[$item];
                            $cndn->invoice_number       = $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $amount_l;
                            $cndn->attribute1           = 'Y';
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();

                            if($request->groupcode[$item] != 0){
                                $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                    ->where('credit_group_code',$request->groupcode[$item])
                                                                    ->first();
                                $ccg->remaining_amount = $ccg->remaining_amount + $amount_l;
                                $ccg->save();
                            }
                        }elseif($dept < $amount_l && $dept <= 0){
                            $cndn = new PaymentApplyCndnModel();
                            $cndn->order_header_id      = $item;
                            $cndn->pick_release_no      = $request->pick_consing[$item];
                            $cndn->credit_group_code    = $request->groupcode[$item];
                            $cndn->invoice_number       = $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $dept;
                            $cndn->attribute1           = 'Y';
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();
                            if($request->groupcode[$item] != 0){
                                $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                    ->where('credit_group_code',$request->groupcode[$item])
                                                                    ->first();
                                $ccg->remaining_amount = $ccg->remaining_amount + $amount_l;
                                $ccg->save();
                            }

                            $less = $amount_l - $dept;

                            $cndn = new PaymentApplyCndnModel();
                            $cndn->invoice_number       = $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $less;
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();
                        }else if($dept < $amount_l){
                            $cndn = new PaymentApplyCndnModel();
                            $cndn->order_header_id      = $item;
                            $cndn->pick_release_no      = $request->pick_consing[$item];
                            $cndn->credit_group_code    = $request->groupcode[$item];
                            $cndn->invoice_number       = $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $dept;
                            $cndn->attribute1           = 'Y';
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();
                            if($request->groupcode[$item] != 0){
                                $ccg = CustomerContractGroupModel::where('customer_id',$customer->customer_id)
                                                                    ->where('credit_group_code',$request->groupcode[$item])
                                                                    ->first();
                                $ccg->remaining_amount = $ccg->remaining_amount + $amount_l;
                                $ccg->save();
                            }

                            $less = $amount_l - $dept;

                            $cndn = new PaymentApplyCndnModel();
                            $cndn->invoice_number       = $lastinsert->invoice_headers_number;
                            $cndn->invoice_header_id    = $lastinsert->invoice_headers_id;
                            $cndn->invoice_amount       = $less;
                            $cndn->attribute2           = 'CN_TRANFER';
                            $cndn->program_code         = 'OMP0034';
                            $cndn->created_by           = optional(auth()->user())->user_id;
                            $cndn->creation_date        = date('Y-m-d H:i:s');
                            $cndn->last_updated_by      = optional(auth()->user())->user_id;
                            $cndn->last_update_date     = date('Y-m-d H:i:s');
                            $cndn->save();
                        }
                    }
                }

                $rest = [
                    'status'        => true,
                    'data'          => 'Complate',
                    'header'        => $header_id,
                    'header_number' => $headers_number,
                    'header_status' => $header_status
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

    public function cancel_invoice(Request $request)
    {
        DB::beginTransaction();
        try{
            $update = [
                'invoice_status'            => 'Cancelled',
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];
            $data = RanchTransferModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->update($update);

            $updatePayment = [
                'attribute1'           => 'C',
                'last_updated_by'      => optional(auth()->user())->user_id,
                'last_update_date'     => date('Y-m-d H:i:s')
            ];
            $paymentApply = PaymentApplyCndnModel::where('invoice_header_id',$request->cedirnote_invoice_id)->update($updatePayment);
            
            $line = RanchTransFerLineModel::where('invoice_headers_id',$request->cedirnote_invoice_id)->get();
            foreach($line as $line_item){
                if($line_item->credit_group_code != 0){
                    $ccg = CustomerContractGroupModel::where('customer_id',$data->customer_id)
                                                        ->where('credit_group_code',$line_item->credit_group_code)
                                                        ->first();
                    $ccg->remaining_amount = $ccg->remaining_amount - $line_item->invoice_amount;
                    $ccg->save();
                }
            }

            DB::commit();
            $rest = [
                'status'    => true,
                'data'      => 'Complate',
            ];
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

    public function Search_invoice (Request $request)
    {

        $data = RanchTransferModel::where('invoice_type','CN_TRANFER')
                                    ->where(function($query) use($request){
                                        if(!empty($request->number)){
                                            $query->where('INVOICE_HEADERS_NUMBER',$request->number);
                                        }
                                    })
                                    ->first();
        $customer = CustomerModel::where('customer_id',$data->customer_id)->first();

        $accrmapp  = AccountsMappingModel::where('account_code',$data->cr_account_code)->first();
        $accdmapp  = AccountsMappingModel::where('account_code',$data->dr_account_code)->first();

        $terms_data         = TermsModel::where('term_id',$data->term_id)
                                                ->where('sale_type','DOMESTIC')
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->first();

        $data->customer_number  =  $customer->customer_number;
        $data->receipt_ref_date =  !empty($data->receipt_ref_date)? GlobalToDateThai($data->receipt_ref_date) : '';
        $data->document_date    =  !empty($data->document_date)? GlobalToDateThai($data->document_date) : '';
        $data->date_invoice     =  !empty($data->invoice_date)? GlobalToDateThai($data->invoice_date) : '';
        $data->term_data        = !empty($terms_data)? $terms_data->due_days : '';
        $data->accd_code        = !empty($accdmapp)? $accdmapp->account_combine : '';
        $data->accr_code        = !empty($accrmapp)? $accrmapp->account_combine : '';
        return response()->json(['data' => $data]);
    }

    public function genNumberCreditNote()
    {
        // $last_invoice   = RanchTransferModel::orderBy('invoice_headers_number','desc')->first();
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
        // $invoice_number = GenerateNumberRepo::generateCreditNoteRanchTransferNumberDomestics();
        $date =  date('d/m');
        $year =  date('Y') + 543;
        $ndate =  $date.'/'.$year;

        $rest = [
            'status'    => true,
            'data'      => [
                'number'    => '',
                'date'      =>  $ndate
            ]
        ];
        return response()->json(['data' => $rest]);
    }
}
