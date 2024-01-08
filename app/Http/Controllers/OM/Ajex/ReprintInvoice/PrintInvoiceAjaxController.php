<?php

namespace App\Http\Controllers\OM\Ajex\ReprintInvoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\OM\ReprintInvoice\ReprintInvoiceModel;
use App\Models\OM\ReprintInvoice\OrderHeaderModel;
use App\Models\OM\ReprintInvoice\PrintHistoryModel;
use App\Models\OM\ReprintInvoice\CustomerModel;
use App\Models\OM\ReprintInvoice\OrderLineModel;
use App\Models\OM\ReprintInvoice\InvoiceHeaderModel;
use App\Models\OM\ReprintInvoice\ConsigmentHeadersModel;
use Illuminate\Support\Facades\DB;

class PrintInvoiceAjaxController extends Controller
{
    public function search_order(Request $request)
    {
        // DB::enableQueryLog();

        $date = [
            'delidate'  =>  '',
            'delicomp'  =>  ''
        ];

        if(!empty($request->delivary_date) && empty($request->delivary_to)){
            $date_xp = \explode('/',$request->delivary_date);
            $year = $date_xp[2] - 543;
            $date = $year.'-'.$date_xp[1].'-'.$date_xp[0];
            $date['delidate']   = $date;
        }

        if(!empty($request->delivary_date) && !empty($request->delivary_to)){
            $date_xp = \explode('/',$request->delivary_date);
            $year = $date_xp[2] - 543;
            $date_s = $year.'-'.$date_xp[1].'-'.$date_xp[0];
            $date['delidate']   = $date_s;

            $date_to_xp = \explode('/',$request->delivary_to);
            $year_to = $date_to_xp[2] - 543;
            $date_to = $year_to.'-'.$date_to_xp[1].'-'.$date_to_xp[0];
            $date['delicomp']   = $date_to;
        }

        if(empty($request->invoice_number) && empty($request->pick_release)){
            //find by preparenumber order with or without customer and delivarydate
            $order = OrderHeaderModel::select('ptom_order_headers.*','ptom_customers.customer_name')
                                        ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->whereNotNull('ptom_order_headers.pick_release_no') 
                                        ->whereNotNull('ptom_order_headers.delivery_date')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where(function($query) use ($request,$date){
                                            if(!empty($request->pre_order_number)){
                                                $query->where('ptom_order_headers.prepare_order_number',$request->pre_order_number);
                                            }else{
                                                $query->where('ptom_order_headers.PICK_RELEASE_APPROVE_FLAG','Y');
                                            }
                                            //find with delivarydate
                                            if(!empty($request->delivary_date) && empty($request->delivary_to)){
                                                $query->whereDate('ptom_order_headers.delivery_date',$date['delidate']);
                                            }
                                            if(!empty($request->delivary_date) && !empty($request->delivary_to)){
                                                $query->whereDate('ptom_order_headers.delivery_date','>=',$date['delidate']);
                                                $query->whereDate('ptom_order_headers.delivery_date','<=',$date['delicomp']);
                                            }
                                            //find with customer
                                            if(!empty($request->customer_id)){
                                                $query->where('ptom_customers.customer_number',$request->customer_id);
                                            }

                                            if(!empty($request->print_status)){
                                                if($request->print_status == 'Y'){
                                                    // $query->where('ptom_order_headers.pick_release_print_flag','N');
                                                    $query->whereNull('ptom_order_headers.pick_release_print_flag');
                                                }
                                                if($request->print_status == 'N'){
                                                    $query->where('ptom_order_headers.pick_release_print_flag','Y');
                                                    // $query->whereNotNull('ptom_order_headers.pick_release_print_flag');
                                                }
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.pick_release_no','asc')
                                        ->orderBy('ptom_order_headers.prepare_order_number','desc')
                                        // ->orderBy('ptom_order_headers.pick_release_print_flag','desc')
                                        ->orderByRaw('ptom_order_headers.pick_release_print_flag DESC NULLS LAST')
                                        ->get();

            // dd(DB::getQueryLog());
            // exit;
            if($order->count() > 0){
                $i  = 1;
                foreach($order as $order_item){
                    $customer   = CustomerModel::where('customer_id',$order_item->customer_id)->first();
                    if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
                        $consignorder = false;
                    }else{
                        $consigment = DB::table('ptom_consignment_headers')->where('order_header_id',$order_item->order_header_id)->count();
                        if($consigment > 0){
                            $consignorder = true;
                        }else{
                            $consignorder = false;
                        }
                    }

                    if(!$consignorder){ // ลูกค้าที่ไม่ได้เป็นสโมสร

                        //กรณีค้นหาจากลขที่ invoice
                        $promo = OrderLineModel::where('order_header_id',$order_item->order_header_id)->where('promo_flag','Y')->count();
                        if($promo > 0){
                            $row = 'promo';
                        }else{
                            if($order_item->pick_release_status == 'Confirm'){
                                $row = 'normal';
                            }else{
                                $row = 'invoice_cancel';
                            }
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" value="'.$order_item->order_header_id.'" >';
                        $print_hit = '';
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if($order_item->pick_release_print_flag == 'Y' && $order_item->unlock_print_flag == 'Y' && !empty($print_hit)){
                            $html = '<input type="checkbox" data-type="normal" value="Y" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->pick_release_print_flag == 'N' && $order_item->unlock_print_flag == 'Y'){
                            $html = '<input type="checkbox" data-type="normal" class="print_invoice" value="Y" name="print['.$order_item->order_header_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                        }elseif( $order_item->unlock_print_flag == 'N'){
                            $html = '<input type="checkbox" data-type="normal" value="Y" data-value="'.$order_item->order_header_id.'" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->unlock_print_flag == 'Y' && empty($order_item->pick_release_print_flag)){
                            $html = '<input type="checkbox" data-type="normal"  class="print_invoice" value="Y" name="print['.$order_item->order_header_id.']"  data-value="'.$order_item->order_header_id.'"> <p style="display:none;">1</p>';
                        }

                        //recorde data 
                        $data_order['data'][] = [
                            'number'            => $i++ ,
                            'id'                => $id,
                            'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                            'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name'     => $order_item->customer_name,
                            'total'             => number_format($order_item->grand_total,2,'.',','),
                            'reprint'           => $html,
                            'invoice'           => $order_item->pick_release_no,
                            'status'            => $order_item->pick_release_status,
                            'row_status'        => $row,
                            'product_type_code' => $order_item->product_type_code
                        ];

                        //กรณีไมไ่ด้ค้นหาจาก invoice ทำการ เช็คเลข invoice
                        // if(!empty($order_item->pick_release_no) && empty($request->pick_release)){
                        //     //สถานะinvoice
                        //     if($order_item->pick_release_status == 'Confirm'){
                        //         $row = 'normal';
                        //     }else{
                        //         $row = 'invoice_cancel';
                        //     }
                        //     $data_order['data'][] = [
                        //         'number'            => $i++ ,
                        //         'id'                => $id,
                        //         'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                        //         'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                        //         'customer_name'     => $order_item->customer_name,
                        //         'total'             => number_format($order_item->grand_total,2,'.',','),
                        //         'reprint'           => $html,
                        //         'invoice'           => $order_item->pick_release_no,
                        //         'status'            => $order_item->pick_release_status,
                        //         'row_status'        => $row
                        //     ];
                        // }

                        $creditnote = DB::table('ptom_invoice_headers')
                                            ->select('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                                    'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->join('ptom_invoice_lines','ptom_invoice_lines.invoice_headers_id','=','ptom_invoice_headers.invoice_headers_id')
                                            ->where('ptom_invoice_lines.document_id',$order_item->order_header_id)
                                            ->where(function($query) use($request){
                                                $query->where('ptom_invoice_headers.program_code','OMP0033');
                                                $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                                $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            })
                                            ->where(function($query) use($request){
                                                if(!empty($request->print_status)){
                                                    if($request->print_status == 'Y'){
                                                        $query->where('ptom_invoice_headers.attribute2','N');
                                                    }elseif($request->print_status == 'N'){
                                                        $query->where('ptom_invoice_headers.attribute2','Y');
                                                    }
                                                }
                                            })
                                            // ->where('ptom_invoice_headers.program_code','OMP0033')
                                            // ->orWhere('ptom_invoice_headers.program_code','OMP0034')
                                            // ->where('ptom_invoice_headers.invoice_status','Confirm')
                                            ->groupBy('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                            'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->get();
                        // dd(DB::getQueryLog());
                        // exit;
                        if($creditnote->count() > 0){
                            foreach($creditnote  as $creditnote_item){
                                $id = $creditnote_item->invoice_headers_id;
                                $html_id = '<input type="hidden" name="invoice['.$creditnote_item->invoice_headers_id.']" value="'.$creditnote_item->invoice_headers_id.'" >';
                                $print_hit = [];
                                $print_hit = PrintHistoryModel::where('document_id',$creditnote_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                                if($creditnote_item->attribute1 == 'Y' && $creditnote_item->attribute2 == 'N' && !empty($print_hit)){
                                    $html = '<input type="checkbox" data-type="creditnote-normal" value="Y" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                                }else{
                                    $html = '<input type="checkbox" data-type="creditnote-normal" class="print_invoice" value="Y" name="print['.$creditnote_item->invoice_headers_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                                }

                                $data_order['data'][] = [
                                    'number'            => $i++ ,
                                    'id'                => $id,
                                    'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                                    'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                                    'customer_name'     => $order_item->customer_name,
                                    'total'             => number_format($creditnote_item->invoice_amount,2,'.',','),
                                    'reprint'           => $html,
                                    'invoice'           => $creditnote_item->invoice_headers_number,
                                    'status'            => $order_item->pick_release_status,
                                    'row_status'        => 'invoice',
                                    'product_type_code' => $order_item->product_type_code
                                ];
                            }
                        }
                    }else{ //ลูกค้าสโมสร
                        $consigmentdata = DB::table('ptom_consignment_headers')->where('order_header_id',$order_item->order_header_id)->first();

                        $promo = OrderLineModel::where('order_header_id',$order_item->order_header_id)->where('promo_flag','Y')->count();
                        if($promo > 0){
                            $row = 'promo';
                        }else{
                            // $row = 'normal';
                            if($order_item->pick_release_status == 'Confirm'){
                                $row = 'normal';
                            }else{
                                $row = 'invoice_cancel';
                            }
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" value="'.$order_item->order_header_id.'" >';
                        $print_hit = [];
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if($order_item->pick_release_print_flag == 'Y' && $order_item->unlock_print_flag == 'Y' && !empty($print_hit)){
                            $html = '<input type="checkbox" value="Y" data-type="consig" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->pick_release_print_flag == 'N' && $order_item->unlock_print_flag == 'Y'){
                            $html = '<input type="checkbox" data-type="consig" class="print_invoice" value="Y" name="print['.$order_item->order_header_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                        }elseif( $order_item->unlock_print_flag == 'N'){
                            $html = '<input type="checkbox" data-type="consig" value="Y" data-value="'.$order_item->order_header_id.'" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->unlock_print_flag == 'Y' && empty($order_item->pick_release_print_flag)){
                            $html = '<input type="checkbox" data-type="consig"  class="print_invoice" name="print['.$order_item->order_header_id.']"  value="Y" data-value="'.$order_item->order_header_id.'"> <p style="display:none;">1</p>';
                        }

                        $data_order['data'][] = [
                            'number'            => $i++ ,
                            'id'                => $id,
                            'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                            'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name'     => $order_item->customer_name,
                            'total'             => number_format($consigmentdata->total_unit_price_amount,2,'.',','),
                            'reprint'           => $html,
                            'invoice'           => $order_item->pick_release_no,
                            'status'            => $order_item->pick_release_status,
                            'row_status'        => $row,
                            'product_type_code' => $order_item->product_type_code
                        ];

                        //กรณีไมไ่ด้ค้นหาจาก invoice ทำการ เช็คเลข invoice
                        // if(!empty($order_item->pick_release_no) && empty($request->pick_release)){
                        //     //สถานะinvoice
                        //     if($order_item->pick_release_status == 'Confirm'){
                        //         $row = 'normal';
                        //     }else{
                        //         $row = 'invoice_cancel';
                        //     }
                        //     $data_order['data'][] = [
                        //         'number'            => $i++ ,
                        //         'id'                => $id,
                        //         'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                        //         'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                        //         'customer_name'     => $order_item->customer_name,
                        //         'total'             => number_format($consigmentdata->total_unit_price_amount,2,'.',','),
                        //         'reprint'           => $html,
                        //         'invoice'           => $order_item->pick_release_no,
                        //         'status'            => $order_item->pick_release_status,
                        //         'row_status'        => $row
                        //     ];
                        // }

                        $creditnote = DB::table('ptom_invoice_headers')
                                            ->select('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                                    'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->join('ptom_invoice_lines','ptom_invoice_lines.invoice_headers_id','=','ptom_invoice_headers.invoice_headers_id')
                                            ->where('ptom_invoice_lines.document_id',$order_item->order_header_id)
                                            ->where(function($query) use($request){
                                                $query->where('ptom_invoice_headers.program_code','OMP0033');
                                                $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                                $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            })
                                            ->where(function($query) use($request){
                                                if(!empty($request->print_status)){
                                                    if($request->print_status == 'Y'){
                                                        $query->where('ptom_invoice_headers.attribute2','N');
                                                    }elseif($request->print_status == 'N'){
                                                        $query->where('ptom_invoice_headers.attribute2','Y');
                                                    }
                                                }
                                            })
                                            // ->where('ptom_invoice_headers.program_code','OMP0033')
                                            // ->orWhere('ptom_invoice_headers.program_code','OMP0034')
                                            // ->where('ptom_invoice_headers.invoice_status','Confirm')
                                            ->groupBy('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                            'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->get();
                        if($creditnote->count() > 0){
                            foreach($creditnote  as $creditnote_item){
                                $id = $creditnote_item->invoice_headers_id;
                                $html_id = '<input type="hidden" name="invoice['.$creditnote_item->invoice_headers_id.']" value="'.$creditnote_item->invoice_headers_id.'" >';
                                $print_hit = [];
                                $print_hit = PrintHistoryModel::where('document_id',$creditnote_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                                if($creditnote_item->attribute1 == 'Y' && $creditnote_item->attribute2 == 'N' && !empty($print_hit)){
                                    $html = '<input type="checkbox" data-type="creditnote-consig" value="Y" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                                }elseif($creditnote_item->attribute1 == 'Y' && $creditnote_item->attribute2 == 'Y'){
                                    $html = '<input type="checkbox" data-type="creditnote-consig" class="print_invoice" value="Y" name="print['.$creditnote_item->invoice_headers_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                                }elseif( $creditnote_item->attribute1 == 'N'){
                                    $html = '<input type="checkbox" data-type="creditnote-consig" value="Y" data-value="'.$order_item->order_header_id.'" disabled> <p style="display:none;">1</p>';
                                }
        

                                $data_order['data'][] = [
                                    'number'            => $i++ ,
                                    'id'                => $id,
                                    'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                                    'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                                    'customer_name'     => $order_item->customer_name,
                                    'total'             => number_format($creditnote_item->invoice_amount,2,'.',','),
                                    'reprint'           => $html,
                                    'invoice'           => $creditnote_item->invoice_headers_number,
                                    'status'            => $order_item->pick_release_status,
                                    'row_status'        => 'invoice',
                                    'product_type_code' => $order_item->product_type_code
                                ];
                            }
                        }
                    }
                }
                $data_order['status'] = true;
            }else{
                $data_order['status'] = false;
                $data_order['data'] = [];
                $data_order['customer'] = '';
            }
        }else{
            $order = OrderHeaderModel::joincreditnote($request->all())
                                        ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->whereNotNull('ptom_order_headers.pick_release_no') 
                                        ->whereNotNull('ptom_order_headers.delivery_date')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where(function($query) use ($request,$date){
                                            //find with delivarydate
                                            if(!empty($request->delivary_date) && empty($request->delivary_to)){
                                                $query->whereDate('ptom_order_headers.delivery_date',$date['delidate']);
                                            }
                                            if(!empty($request->delivary_date) && !empty($request->delivary_to)){
                                                $query->whereDate('ptom_order_headers.delivery_date','>=',$date['delidate']);
                                                $query->whereDate('ptom_order_headers.delivery_date','<=',$date['delicomp']);
                                            }
                                            //find with customer
                                            if(!empty($request->customer_id)){
                                                $query->where('ptom_customers.customer_number',$request->customer_id);
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.pick_release_no','asc')
                                        ->orderBy('ptom_order_headers.prepare_order_number','desc')
                                        ->orderBy('ptom_order_headers.pick_release_print_flag','desc')
                                        ->get();
            if($order->count() > 0){
                $i  = 1;
                foreach($order as $order_item){
                    if(!empty($request->pick_release)){
                        //สถานะinvoice
                        if($order_item->pick_release_status == 'Confirm'){
                            $row = 'normal';
                        }else{
                            $row = 'invoice_cancel';
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" value="'.$order_item->order_header_id.'" >';
                        $print_hit = [];
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if($order_item->pick_release_print_flag == 'Y' && $order_item->unlock_print_flag == 'Y' && !empty($print_hit)){
                            $html = '<input type="checkbox" data-type="order" value="Y" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->pick_release_print_flag == 'N' && $order_item->unlock_print_flag == 'Y'){
                            $html = '<input type="checkbox" data-type="order" class="print_invoice" value="Y" name="print['.$order_item->order_header_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                        }elseif( $order_item->unlock_print_flag == 'N'){
                            $html = '<input type="checkbox" data-type="order" value="Y" data-value="'.$order_item->order_header_id.'" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->unlock_print_flag == 'Y' && empty($order_item->pick_release_print_flag)){
                            $html = '<input type="checkbox" data-type="order"  class="print_invoice" name="print['.$order_item->order_header_id.']"  value="Y" data-value="'.$order_item->order_header_id.'"> <p style="display:none;">1</p>';
                        }

                        //recorde data 
                        $data_order['data'][] = [
                            'number'            => $i++ ,
                            'id'                => $id,
                            'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                            'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name'     => $order_item->customer_name,
                            'total'             => number_format($order_item->grand_total,2,'.',','),
                            'reprint'           => $html,
                            'invoice'           => $order_item->pick_release_no,
                            'status'            => $order_item->pick_release_status,
                            'row_status'        => $row,
                            'product_type_code' => $order_item->product_type_code
                        ];
                    }else{
                        $id = $order_item->invoice_headers_id;
                        $print_hit = [];
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                        $html_id = '<input type="hidden" name="invoice['.$order_item->invoice_headers_id.']" value="'.$order_item->invoice_headers_id.'" >';
                        if($order_item->attribute1 == 'Y' && $order_item->attribute2 == 'N' && !empty($print_hit)){
                            $html = '<input type="checkbox" data-type="invoice" value="Y" data-value="'.$order_item->order_header_id.'" checked="" disabled> <p style="display:none;">1</p>';
                        }elseif($order_item->attribute1 == 'Y' && $order_item->attribute2 == 'Y'){
                            $html = '<input type="checkbox" data-type="invoice" class="print_invoice" value="Y" name="print['.$order_item->invoice_headers_id.']" data-value="'.$order_item->order_header_id.'" > <p style="display:none;">0</p>';
                        }elseif( $order_item->attribute1 == 'N'){
                            $html = '<input type="checkbox" data-type="invoice" value="Y" data-value="'.$order_item->order_header_id.'" disabled> <p style="display:none;">1</p>';
                        }

                        $data_order['data'][] = [
                            'number'            => $i++ ,
                            'id'                => $id,
                            'prepare_number'    => $order_item->prepare_order_number.'<br>'.$html_id,
                            'delivary_date'     => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name'     => $order_item->customer_name,
                            'total'             => number_format($order_item->invoice_amount,2,'.',','),
                            'reprint'           => $html,
                            'invoice'           => $order_item->invoice_headers_number,
                            'status'            => $order_item->pick_release_status,
                            'row_status'        => 'invoice',
                            'product_type_code' => $order_item->product_type_code
                        ];
                    }
                }
                $data_order['status'] = true;
            }else{
                $data_order['status'] = false;
                $data_order['data'] = [];
                $data_order['customer'] = '';
            }
                                       
        }

        return response()->json(['data' => $data_order]);
    }

    public function print_data(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'print'               => 'required',
        ],[
            'print.required'      => 'กรุณาเลือกรายการที่จะพิมพ์',
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
            try {
                foreach($request->print as $key => $item){
                    if(!empty($request->invoice[$key])){
                        $update = [
                            'attribute1'                => 'Y',
                            'attribute2'                => 'N',
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];

                        InvoiceHeaderModel::where('invoice_headers_id',$key)->update($update);

                        $print = PrintHistoryModel::where('document_id',$key)->where('attribute1','Invoice')->first();
                        if(!empty($print)){
                            $update_history = [
                                'print_revision'            => $print->print_revision +1,
                                'print_date'                => date('Y-m-d H:i:s'),
                                'print_by'                  => optional(auth()->user())->user_id,
                                'print_flag'                => 'Y',
                                'last_updated_by'           => optional(auth()->user())->user_id,
                                'last_update_date'          => date('Y-m-d H:i:s'),
                            ];
                            PrintHistoryModel::where('document_id',$key)->where('attribute1','Invoice')->update($update_history);
                        }else{
                            $update_history = [
                                'from_program_code'         => 'OMP0036',
                                'print_revision'            => '1',
                                'document_id'               => $key,
                                'print_date'                => date('Y-m-d H:i:s'),
                                'print_by'                  => optional(auth()->user())->user_id,
                                'print_flag'                => 'Y',
                                'program_code'              => 'OMP0037',
                                'attribute1'                => 'Invoice',
                                'created_by'                => optional(auth()->user())->user_id,
                                'creation_date'             => date('Y-m-d H:i:s'),
                                'last_updated_by'           => optional(auth()->user())->user_id,
                                'last_update_date'          => date('Y-m-d H:i:s'),
                            ];
                            PrintHistoryModel::create($update_history);
                        }
                    }
                    if(!empty($request->order[$key])){
                        $update = [
                            // 'unlock_print_flag'   => 'Y',
                            'pick_release_print_flag'   => 'Y',
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];

                        OrderHeaderModel::where('order_header_id',$key)->update($update);

                        $print = PrintHistoryModel::where('document_id',$key)->where('attribute1','Order')->first();
                        if(!empty($print)){
                            $update_history = [
                                'print_revision'            => $print->print_revision +1,
                                'print_date'                => date('Y-m-d H:i:s'),
                                'print_by'                  => optional(auth()->user())->user_id,
                                'print_flag'                => 'Y',
                                'last_updated_by'           => optional(auth()->user())->user_id,
                                'last_update_date'          => date('Y-m-d H:i:s'),
                            ];
                            PrintHistoryModel::where('document_id',$key)->where('attribute1','Order')->update($update_history);
                        }else{
                            $update_history = [
                                'from_program_code'         => 'OMP0036',
                                'print_revision'            => '1',
                                'document_id'               => $key,
                                'print_date'                => date('Y-m-d H:i:s'),
                                'print_by'                  => optional(auth()->user())->user_id,
                                'print_flag'                => 'Y',
                                'program_code'              => 'OMP0037',
                                'attribute1'                => 'Order',
                                'created_by'                => optional(auth()->user())->user_id,
                                'creation_date'             => date('Y-m-d H:i:s'),
                                'last_updated_by'           => optional(auth()->user())->user_id,
                                'last_update_date'          => date('Y-m-d H:i:s'),
                            ];
                            PrintHistoryModel::create($update_history);
                        }
                    }
                }
            } catch (\Exception $em) {
                DB::rollBack();
                $result = [
                    'status'    => false,
                    'message'   => $em->getMessage(),
                ];
                return response()->json(['data'=>$result]);
            }

            DB::commit();

            $rest = [
                'status'    => true,
                'message'   => 'success',
            ];
            return response()->json(['data'=>$rest]);
        }
    }

    public function customer_list()
    {
        $list = CustomerModel::ActiveDomestic()->orderBy('customer_number')->get();

        if(!empty($list)){
            $rest = [
                'status'    => true,
                'data'      => $list
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No data'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function creditNoteList(Request $request)
    {
        $invoice    = InvoiceHeaderModel::select('ptom_invoice_headers.invoice_headers_number','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.creation_date')
                                        ->whereNotNull('ptom_invoice_headers.invoice_headers_number')
                                        ->join('ptom_invoice_lines','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_id')
                                        ->join('ptom_order_headers','ptom_order_headers.order_header_id','ptom_invoice_lines.document_id')
                                        ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_invoice_headers.customer_id')
                                        ->where(function($query) use($request){
                                            if(!empty($request->order_id)){
                                                $query->where('ptom_order_headers.pick_release_no',$request->order_id);
                                            }else{
                                                $query->where('ptom_invoice_headers.program_code','OMP0033');
                                                $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                                $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            }
                                        })
                                        ->groupBy('ptom_invoice_headers.invoice_headers_number','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.creation_date')
                                        ->orderBy('ptom_invoice_headers.creation_date','desc')
                                        ->get();

        if($invoice->count() > 0){
            $rest = [
                'status'    => true,
                'data'      => $invoice
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No data'
            ];
        }
        return response()->json(['data' => $rest]);
    }
}
