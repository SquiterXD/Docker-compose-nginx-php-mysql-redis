<?php

namespace App\Http\Controllers\OM\Ajex\DebitNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\OM\DebitNote\DebitNoteModel;
use App\Models\OM\DebitNote\DebitNoteLineModel;
use App\Models\OM\DebitNote\CustomerModel;
use App\Models\OM\DebitNote\ConsigmentHeadersModel;
use App\Models\OM\DebitNote\ConsignmentLineModel;
use App\Models\OM\DebitNote\ThaiTerritoryModel;
use App\Models\OM\DebitNote\OrderHeaderModel;
use App\Models\OM\DebitNote\OrderLineModel;
use App\Models\OM\DebitNote\UomConversionModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\MappingAccountModel;

use App\Repositories\OM\GenerateNumberRepo;

class DebitNoteAjaxController extends Controller
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

    public function getDebitNoteList(Request $request)
    {
        $list  = DebitNoteModel::where('program_code','OMP0032')
                                ->where(function($query) use($request){
                                    if(!empty($request->customer_id)){
                                        $query->where('customer_id',$request->customer_id);
                                    }
                                })
                                ->orderBy('creation_date','desc')
                                ->get();
        if($list->count() > 0){
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
        }else{
            $data = [
                'status'    => false,
                'data'      => 'No data'
            ];
        }
  
        return response()->json(['data' => $data]);
    }

    public function get_product_order(Request $request)
    {
        $customer = CustomerModel::where('customer_number',$request->customer_id)->first();
        if($customer->customer_type_id == 30){

        }else if($customer->customer_type_id == 40){

        }else{
            $data = [
                'status'    => false,
                'data'      => 'No data'
            ];
        }
 
        return response()->json(['data' => $data]);
    }

    public function genNumberDebitNote()
    {
        $date =  date('d/m');
        $year =  date('Y') + 543;
        $ndate =  $date.'/'.$year;

        // $last_invoice   = DebitNoteModel::orderBy('invoice_headers_number','desc')->first();

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
        

        $rest = [
            'status'    => true,
            'data'      => [
                // 'number'    => $invoice_number,
                'date'      =>  $ndate
            ]
        ];
        return response()->json(['data' => $rest]);
    }

    public function getOrderList(Request $request)
    {
        $customer   = CustomerModel::where('customer_id',$request->customer_id)->first();
        if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
            $order      = OrderHeaderModel::where('ptom_order_headers.customer_id',$request->customer_id)
                                            ->where(function($query) use($request) {
                                                if(!$request->invoice_id){
                                                    $query->where('ptom_order_headers.pick_release_status','Confirm');
                                                }
                                            })
                                            ->whereNotNull('ptom_order_headers.pick_release_no')
                                            // ->whereNotNull('ptom_order_lines.credit_group_code')
                                            // ->groupBy('ptom_order_credit_groups.order_header_id')
                                            ->get();
            if($order->count() > 0){

                foreach($order as $item){
                    $data[] = [
                        'id'        => $item->order_header_id,
                        'number'    => $item->pick_release_no
                    ];
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

        }else{ // ลูกค้าที่เป็นสโมสร

            $order1     = OrderHeaderModel::where('customer_id',$request->customer_id)
                                            ->where('product_type_code','<>',10)
                                            ->where('pick_release_status','Confirm')
                                            ->whereNotNull('pick_release_no')
                                            ->get();

            $order      = OrderHeaderModel::join('ptom_consignment_headers','ptom_consignment_headers.order_header_id','=','ptom_order_headers.order_header_id')
                                                ->where('ptom_order_headers.product_type_code','=',10)
                                                ->where('ptom_order_headers.customer_id',$request->customer_id)
                                                ->whereNotNull('ptom_consignment_headers.consignment_no')
                                                ->where('ptom_consignment_headers.consignment_status','Confirm')
                                                ->get();
            if($order->count() > 0){
                foreach($order as $item){
                    $data[] = [
                        'id'        => $item->consignment_header_id,
                        'number'    => $item->consignment_no,
                        'type'      => 'consig'
                    ];
                }

                if($order1->count() > 0){
                    foreach($order1 as $item1){
                        $data[] = [
                            'id'        => $item1->order_header_id,
                            'number'    => $item1->pick_release_no,
                            'type'      => 'order'
                        ];
                    }
                }


                $rest = [
                    'status'    => true,
                    'data'      => $data,
                    'type'      => 'consig'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'message'   => 'No Data Consignment'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function saveInvoiceDebit(Request $request )
    {
        $validate = Validator::make($request->all(),[
            // 'debitnote_number_input'      => 'required',
            // 'debitnote_date'        => 'required',
            // 'debitnote_status_data'      => 'required',
            'customer_number'       => 'required',
            'amount'                => 'required',
            // 'debit_type'            => 'required',
        ],[
            // 'debitnote_number_input.required'     => 'กรุณากดสร้าง invoice',
            // 'debitnote_date.required'       => 'กรุณากดสร้าง invoice',
            // 'debitnote_status_data.required'     => 'กรุณากดสร้าง invoice',
            'customer_number.required'      => 'กรุณาเลือกลูกค้า',
            'amount.required'               => 'กรุณากรอกจำนวนเงิน',
            // 'debit_type.required'           => 'กรุณาเลือกประเภทเดบิต',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data'=>$rest]);
        }else{
            $date       = explode('/',$request->debitnote_date);
            $year       = $date[2] - 543;
            $date_new   = $year.'-'.$date[1].'-'.$date[0];

            if(!empty($request->accountmapping_cid)){
                $account       = AccountsMappingModel::where('account_code',$request->accountmapping_cid)->first();
                $accmap_cr     = MappingAccountModel::where('account_code',$account->account_code)->first();
            }

            if(!empty($request->accountmapping_id)){
                $accmap         = AccountsMappingModel::where('account_code',$request->accountmapping_id)->first();
                $account_dr     = MappingAccountModel::where('account_code',$accmap->account_code)->first();
            }

            $header_id          = '';
            $headers_number     = '';
            $header_status      = '';
            $line_id            = [];

            DB::beginTransaction();
            try {
                if(!empty($request->invoice_id)){
                    $invoice                            = DebitNoteModel::where('invoice_headers_id',$request->invoice_id)->first();
                    $invoice->customer_id               = $request->customer_id;                // รหัสลูกค้า
                    $invoice->province_name             = $request->customer_provice_name;      // จังหวัด
                    $invoice->invoice_amount            = str_replace(',','',$request->amount);                     // จำนวนเงิน
                    // $invoice->document_id               = $request->order_number;
                    // $invoice->delivery_date             = $request->order_date;
                    $invoice->account_debit_type_code   = $request->debit_type;                 // ประเภทเดบิต
                    $invoice->invoice_status            = 'Confirm';                           // สถานะ
                    // $invoice->term_id                   = $request->debitnote_number_input;
                    // $invoice->document_number           = $request->debitnote_number_input;
                    // $invoice->channel_receiving_code    = $request->debitnote_number_input;
                    $invoice->ref_invoice_number        = $request->order_number_data;
                    $invoice->document_id               = $request->order_id;                   // อ้างอิงใบกำกับสินค้าเลขที่
                    // $invoice->document_date             = $request->document_date_data;
                    // $invoice->currency                  = $request->debitnote_number_input;
                    if(empty($request->product)){
                    $invoice->dr_account_id             = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $invoice->dr_account_code           = !empty($accmap->account_id) ? $request->accountmapping_id : '';             // เดบิตบัญชี
                    $invoice->dr_account_desc           = !empty($accmap->account_id) ? $request->input_mapping_name : '';            // ชื่อเดบิตบัญชี
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
                    if(empty($request->product)){
                    $invoice->cr_account_id             = !empty($account->account_id) ? $account->account_id : '';
                    $invoice->cr_account_code           = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $invoice->cr_account_desc           = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
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
                    $invoice->last_updated_by           = optional(auth()->user())->user_id;
                    $invoice->last_update_date          = date('Y-m-d H:i:s');
                    $invoice->save();

                    $header_id      = $invoice->invoice_headers_number;
                    $header_status  = $invoice->invoice_status;
                }else{
                    $invoice_number = GenerateNumberRepo::generateDebitNoteNumberDomestics();
                    
                    $invoice                            = new DebitNoteModel();
                    $invoice->invoice_headers_number    = $invoice_number;                      // เลขที่ใบเพิ่มหนี้
                    $invoice->customer_id               = $request->customer_id;                // รหัสลูกค้า
                    $invoice->province_name             = $request->customer_provice_name;      // จังหวัด
                    $invoice->invoice_type              = 'DN';
                    $invoice->invoice_date              = $date_new;                            // วันที่
                    $invoice->invoice_amount            = str_replace(',','',$request->amount);                     // จำนวนเงิน
                    // $invoice->document_id               = $request->order_number;
                    // $invoice->delivery_date             = $request->order_date;
                    $invoice->account_debit_type_code   = $request->debit_type;                 // ประเภทเดบิต
                    $invoice->invoice_status            = 'Confirm';                              // สถานะ
                    // $invoice->term_id                   = $request->debitnote_number_input;
                    // $invoice->document_number           = $request->debitnote_number_input;
                    // $invoice->channel_receiving_code    = $request->debitnote_number_input;
                    $invoice->document_id               = $request->order_id;                    // อ้างอิงใบกำกับสินค้าเลขที่
                    $invoice->ref_invoice_number        = $request->order_number_data;
                    // $invoice->document_date             = $request->document_date_data;
                    // $invoice->currency                  = $request->debitnote_number_input;
                    if(empty($request->product)){
                    $invoice->dr_account_id             = !empty($accmap->account_id) ? $accmap->account_id : '';
                    $invoice->dr_account_code           = !empty($accmap->account_id) ? $request->accountmapping_id : '';             // เดบิตบัญชี
                    $invoice->dr_account_desc           = !empty($accmap->account_id) ? $request->input_mapping_name : '';            // ชื่อเดบิตบัญชี
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
                   if(empty($request->product)){
                    $invoice->cr_account_id             = !empty($account->account_id) ? $account->account_id : '';
                    $invoice->cr_account_code           = !empty($account->account_id) ? $request->accountmapping_cid : '';             // เดบิตบัญชี
                    $invoice->cr_account_desc           = !empty($account->account_id) ? $request->input_mapping_ceditname : '';            // ชื่อเดบิตบัญชี
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
                    $invoice->program_code              = 'OMP0032';
                    $invoice->created_by                = optional(auth()->user())->user_id;
                    $invoice->creation_date             = date('Y-m-d H:i:s');
                    $invoice->last_updated_by           = optional(auth()->user())->user_id;
                    $invoice->last_update_date          = date('Y-m-d H:i:s');
                    $invoice->save();

                    $header_id          = $invoice->invoice_headers_id;
                    $header_status      = $invoice->invoice_status;
                    $headers_number     = $invoice->invoice_headers_number;
                }

                if(!empty($request->product)){
                    foreach($request->product as $key_product => $product_item){
                        $invoiceline = DebitNoteLineModel::where('invoice_line_id',$request->invoice_line[$key_product])->first();
                        if($invoiceline){
                            // $invoiceline->quantity              = $request->line_total[$key_product];
                            $invoiceline->diff_amount           = $request->product_value[$key_product];
                            $invoiceline->uom_code              = $request->product_uom[$key_product];
                            $invoiceline->item_id               = $request->product_id[$key_product];
                            $invoiceline->item_code             = $request->product_code[$key_product];
                            $invoiceline->item_description      = $request->product_desc[$key_product];
                            $invoiceline->quantity              = $request->line_total[$key_product];
                            $invoiceline->diff_amount           = str_replace(',','',$request->product_value[$key_product]);
                            $invoiceline->document_id           = $request->order_id;
                            $invoiceline->document_line_id      = $product_item;
                            $invoiceline->credit_group_code     = $request->ceditgroup[$key_product];
                            $invoiceline->last_updated_by       = optional(auth()->user())->user_id;
                            $invoiceline->last_update_date      = date('Y-m-d H:i:s');
                            $invoiceline->save();

                            $line_id[$key_product]     = $invoiceline->order_line_id;
                        }else{
                            $invoiceline                        = new DebitNoteLineModel();
                            $invoiceline->invoice_headers_id    = $invoice->invoice_headers_id;
                            $invoiceline->uom_code              = $request->product_uom[$key_product];
                            $invoiceline->item_id               = $request->product_id[$key_product];
                            $invoiceline->item_code             = $request->product_code[$key_product];
                            $invoiceline->item_description      = $request->product_desc[$key_product];
                            $invoiceline->quantity              = $request->line_total[$key_product];
                            $invoiceline->diff_amount           = str_replace(',','',$request->product_value[$key_product]);
                            $invoiceline->document_id           = $request->order_id;
                            $invoiceline->document_line_id      = $product_item;
                            $invoiceline->credit_group_code     = $request->ceditgroup[$key_product];
                            $invoiceline->conversion_rate       = '1';
                            $invoiceline->invoice_flag          = 'N';
                            $invoiceline->program_code          = 'OMP0032';
                            $invoiceline->created_by            = optional(auth()->user())->user_id;
                            $invoiceline->creation_date         = date('Y-m-d H:i:s');
                            $invoiceline->last_updated_by       = optional(auth()->user())->user_id;
                            $invoiceline->last_update_date      = date('Y-m-d H:i:s');
                            $invoiceline->save();

                            $line_id[$key_product]     = $invoiceline->invoice_line_id;
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
                    'message'   => $e->getMessage()
                ];
            }
            DB::commit();
            return response()->json(['data' => $rest]);
        }
    }

    public function searchInvoice(Request $request)
    {

        $data   = DebitNoteModel::where('invoice_type','DN')
                                    ->where(function($query) use($request){
                                        if(!empty($request->number)){
                                            $query->where('invoice_headers_number',$request->number);
                                        }
                                        if(!empty($request->date)){
                                            $date_ex    = explode('/',$request->date);
                                            $year       = $date_ex[2] - 543;
                                            $date_n     = $year.'-'.$date_ex[1].'-'.$date_ex[0];

                                            $query->where('invoice_date',$date_n);
                                        }
                                    })
                                    ->first();
        if($data){
            $customer                   = CustomerModel::where('customer_id',$data->customer_id)->first();
            $data->customer_number      =  $customer->customer_number;

            if(!empty($data->document_id)){
                if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){
                    $orderheader    = OrderHeaderModel::where('order_header_id',$data->document_id)->first();
                    $datahead = [
                        'id'        => $orderheader->order_header_id,
                        'number'    => $orderheader->order_number,
                    ];
                    $orderinvoice_line = DebitNoteLineModel::where('invoice_headers_id',$data->invoice_headers_id)->get();
                    $invoice_line['total'] = 0;
                    foreach($orderinvoice_line as $invoiceline_item){
                        $invoice_line['line'][$invoiceline_item->document_line_id] = [
                            'diff'  => $invoiceline_item->diff_amount,
                            'id'    => $invoiceline_item->invoice_line_id
                        ];
                        $invoice_line['total'] += $invoiceline_item->diff_amount;
                    }
                }else{
                    $orderheader    = ConsigmentHeadersModel::where('consignment_header_id',$data->document_id)->first();
                    $datahead = [
                        'id'        => $orderheader->consignment_header_id,
                        'number'    => $orderheader->consignment_no,
                    ];
                    $orderinvoice_line = DebitNoteLineModel::where('invoice_headers_id',$data->invoice_headers_id)->get();
                    $invoice_line['total'] = 0;
                    foreach($orderinvoice_line as $invoiceline_item){
                        $invoice_line['line'][$invoiceline_item->document_line_id] = [
                            'diff'  => $invoiceline_item->diff_amount,
                            'id'    => $invoiceline_item->invoice_line_id
                        ];
                        $invoice_line['total'] += $invoiceline_item->diff_amount;
                    }
                }  
            }else{
                $datahead = [];
                $invoice_line = [];
            }

            $notime                     = explode(' ',$data->invoice_date);
            $date_in                    = explode('-',$notime[0]);
            $in_year                    = $date_in[0] + 543;
            $data->date_invoice         = $date_in[2].'/'.$date_in[1].'/'.$in_year;

            $account_cr         = AccountsMappingModel::where('account_code',$data->cr_account_code)->first();
            $data->accr_code    =  !empty($account_cr)? $account_cr->account_combine : '';
            $account_dr         = AccountsMappingModel::where('account_code',$data->dr_account_code)->first();
            $data->accd_code    =  !empty($account_dr)? $account_dr->account_combine : '';

            $rest = [
                'status'        => true,
                'data'          => $data,
                'header'        => $datahead,
                'invoice_line'  => $invoice_line
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
        $customer   = CustomerModel::where('customer_id',$request->customer_id)->first();
        if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
            $orderheader    = OrderHeaderModel::where('order_header_id',$request->ordernumber)->first();
            if($orderheader){
                $orderline      = OrderLineModel::where('order_header_id',$orderheader->order_header_id)->get();
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
                    'id'                => $orderheader->order_header_id,
                    'number'            => $orderheader->order_number,
                    'pick_release_no'   => $orderheader->pick_release_no,
                    'date'              => $date
                ];
        
                foreach($orderline as $key_line => $orderline){
                    $data['line'][] = [
                        'id'                    => $orderline->order_line_id,
                        'item_id'               => $orderline->item_id,
                        'item_code'             => $orderline->item_code,
                        'description'           => $orderline->item_description,
                        'uom_code'              => $orderline->uom_code,
                        'credit_group_code'     => $orderline->credit_group_code,
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
        }else{ // ลูกค้าที่เป็นสโมสร
            if($request->order_type == 'consig'){
                $consignmentheader    = ConsigmentHeadersModel::where('consignment_header_id',$request->ordernumber)->first();
                if($consignmentheader){
                    $consignmentline    = ConsignmentLineModel::where('consignment_header_id',$consignmentheader->consignment_header_id)->get();
                    $uom                = UomConversionModel::where('domestic','Y')->get();
                    foreach( $uom as $uom_item){
                        $uom_data[$uom_item->uom_code] = [
                            'code'              => $uom_item->uom_code,
                            'conversion_rate'   => $uom_item->conversion_rate
                        ];
                    }
            
                    $date_nt    = \explode(' ',$consignmentheader->consignment_date);
                    $date_n     = \explode('-',$date_nt[0]);
                    $year       = $date_n[0] + 543;
                    $date       = $date_n[2].'/'.$date_n[1].'/'.$year;
            
                    $data['header'] = [
                        'id'        => $consignmentheader->consignment_header_id,
                        'number'    => $consignmentheader->consignment_no,
                        'date'      => $date
                    ];
            
                    foreach($consignmentline as $key_line => $consignmentline_item){
                        $orderline      = OrderLineModel::where('order_line_id',$consignmentline_item->order_line_id)->first();
                        $data['line'][] = [
                            'id'                    => $consignmentline_item->consignment_line_id,
                            'item_id'               => $consignmentline_item->item_id,
                            'item_code'             => $consignmentline_item->item_code,
                            'description'           => $consignmentline_item->item_description,
                            'uom_code'              => $orderline->uom_code,
                            'credit_group_code'     => $orderline->credit_group_code,
                            'approve_cardboardbox'  => '',
                            'approve_carton'        => '',
                            'approve_total'         => !empty($consignmentline_item->actual_quantity)? $consignmentline_item->actual_quantity : '0'
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
            }elseif($request->order_type == 'order'){
                $orderheader    = OrderHeaderModel::where('order_header_id',$request->ordernumber)->first();
                if($orderheader){
                    $orderline      = OrderLineModel::where('order_header_id',$orderheader->order_header_id)->get();
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
                        'id'                => $orderheader->order_header_id,
                        'number'            => $orderheader->order_number,
                        'pick_release_no'   => $orderheader->pick_release_no,
                        'date'              => $date
                    ];
            
                    foreach($orderline as $key_line => $orderline){
                        $data['line'][] = [
                            'id'                    => $orderline->order_line_id,
                            'item_id'               => $orderline->item_id,
                            'item_code'             => $orderline->item_code,
                            'description'           => $orderline->item_description,
                            'uom_code'              => $orderline->uom_code,
                            'credit_group_code'     => $orderline->credit_group_code,
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
            }else{
                $rest = [
                    'status'    => false,
                    'message'   => 'No data'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function cancelInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $invoice                            = DebitNoteModel::where('invoice_headers_id',$request->invoice_id)->first();
            if($invoice->close_sale_flag != 'Y'){
                $invoice->invoice_status            = 'Cancel';
                $invoice->last_updated_by           = optional(auth()->user())->user_id;
                $invoice->last_update_date          = date('Y-m-d H:i:s');
                $invoice->save();

                $rest = [
                    'status'        => true,
                    'data'          => 'Complate',
                    'header_status' => 'Cancel'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Close'
                ];
            }
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
