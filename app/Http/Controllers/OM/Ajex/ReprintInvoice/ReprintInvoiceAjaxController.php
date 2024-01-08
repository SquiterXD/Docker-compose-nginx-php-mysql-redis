<?php

namespace App\Http\Controllers\OM\Ajex\ReprintInvoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ReprintInvoice\ReprintInvoiceModel;
use App\Models\OM\ReprintInvoice\OrderHeaderModel;
use App\Models\OM\ReprintInvoice\PrintHistoryModel;
use App\Models\OM\ReprintInvoice\CustomerModel;
use App\Models\OM\ReprintInvoice\OrderLineModel;
use App\Models\OM\ReprintInvoice\InvoiceHeaderModel;
use Illuminate\Support\Facades\DB;

class ReprintInvoiceAjaxController extends Controller
{
    public function searchinvoice(Request $request)
    {
        // DB::enableQueryLog();

        if(empty($request->invoice_number) && empty($request->pick_release)){
            //find by preparenumber order with or without customer and delivarydate
            $order = OrderHeaderModel::select('ptom_order_headers.*','ptom_customers.customer_name')
                                        ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->whereNotNull('ptom_order_headers.pick_release_no') 
                                        ->whereNotNull('ptom_order_headers.delivery_date')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where(function($query) use ($request){
                                            if(!empty($request->pre_order_number)){
                                                $query->where('ptom_order_headers.prepare_order_number',$request->pre_order_number);
                                            }else{
                                                $query->where('ptom_order_headers.PICK_RELEASE_APPROVE_FLAG','Y');
                                            }
                                            //find with delivarydate
                                            if(!empty($request->input_date)){
                                                $date_xp = \explode('/',$request->input_date);
                                                $year = $date_xp[2] - 543;
                                                $date = $year.'-'.$date_xp[1].'-'.$date_xp[0];
                                                $query->whereDate('ptom_order_headers.delivery_date',$date);
                                            }
                                            //find with customer
                                            if(!empty($request->customer_number)){
                                                $query->where('ptom_customers.customer_number',$request->customer_number);
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.delivery_date','desc')
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
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if(!empty($print_hit)){
                            if($order_item->pick_release_print_flag == 'N' && $print_hit->print_flag == 'Y'){
                                if($print_hit->print_flag == 'Y'){
                                    $status = 'ปลดรายการ Reprint';
                                }else{
                                    $status = 'Reprint'.$print_hit->print_revision;
                                }
                            }else{
                                $status = 'Reprint'.$print_hit->print_revision;
                            }
                        }else{
                            $status = 'ปลดรายการ';
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" >';
                        if($order_item->pick_release_print_flag == 'N'){
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }else{
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }


                        if($order_item->unlock_print_flag == 'Y'){
                            $html_unlock = '<input type="checkbox" class="" disabled value="Y" name="unlockdis['.$order_item->order_header_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$order_item->order_header_id.']">';
                        }else{
                            $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$order_item->order_header_id.']" >';
                        }

                        //recorde data 
                        $data_order['data'][] = [
                            'id'            => $id,
                            'invoice'       => $order_item->pick_release_no.'<br>'.$html_id,
                            'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name' => $order_item->customer_name,
                            'total'         => number_format($order_item->grand_total,2,'.',','),
                            'unlock'        => $html_unlock,
                            'reprint'       => $html_repint,
                            'status'        => $status
                        ];

                        //กรณีไมไ่ด้ค้นหาจาก invoice ทำการ เช็คเลข invoice
                        // if(!empty($order_item->pick_release_no) && empty($request->pick_release)){
                        //     //สถานะinvoice
                        //     $data_order['data'][] = [
                        //         'id'            => $id,
                        //         'invoice'       => $order_item->pick_release_no.'<br>'.$html_id,
                        //         'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                        //         'customer_name' => $order_item->customer_name,
                        //         'total'         => number_format($order_item->grand_total,2,'.',','),
                        //         'unlock'        => $html_unlock,
                        //         'reprint'       => $html_repint,
                        //         'status'        => $status
                        //     ];
                        // }

                        $creditnote = DB::table('ptom_invoice_headers')
                                            ->select('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                                    'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->join('ptom_invoice_lines','ptom_invoice_lines.invoice_headers_id','=','ptom_invoice_headers.invoice_headers_id')
                                            ->where('ptom_invoice_lines.document_id',$order_item->order_header_id)
                                            ->where(function($query){
                                                $query->where('ptom_invoice_headers.program_code','OMP0033');
                                                $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                                $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            })
                                            // ->where('ptom_invoice_headers.program_code','OMP0033')
                                            // ->orWhere('ptom_invoice_headers.program_code','OMP0034')
                                            // ->where('ptom_invoice_headers.invoice_status','Confirm')
                                            ->groupBy('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                            'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->get();
                        if($creditnote->count() > 0){
                            foreach($creditnote  as $creditnote_item){
                                $print_hit = PrintHistoryModel::where('document_id',$creditnote_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                                if(!empty($print_hit)){
                                    if($creditnote_item->attribute1 == 'Y' && $print_hit->print_flag == 'Y'){
                                        if($print_hit->print_flag == 'Y'){
                                            $status = 'ปลดรายการ Reprint';
                                        }else{
                                            $status = 'Reprint'.$print_hit->print_revision;
                                        }
                                    }else{
                                        $status = 'Reprint'.$print_hit->print_revision;
                                    }
                                }else{
                                    $status = 'ปลดรายการ';
                                }

                                $id = $creditnote_item->invoice_headers_id;
                                $html_id = '<input type="hidden" name="invoice['.$creditnote_item->invoice_headers_id.']" >';
                                if($creditnote_item->attribute1 == 'Y'){
                                    $html_unlock = '<input type="checkbox" class="" value="Y" disabled name="unlockdis['.$creditnote_item->invoice_headers_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$creditnote_item->invoice_headers_id.']">';
                                }else{
                                    $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$creditnote_item->invoice_headers_id.']" >';
                                }
            
                                if($creditnote_item->attribute2 == 'Y'){
                                    $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$creditnote_item->invoice_headers_id.']">';
                                }else{
                                    $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$creditnote_item->invoice_headers_id.']">';
                                }

                                $data_order['data'][] = [
                                    'id'            => $id,
                                    'invoice'       => $order_item->invoice_headers_number.'<br>'.$html_id,
                                    'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                                    'customer_name' => $order_item->customer_name,
                                    'total'         => number_format($order_item->grand_total,2,'.',','),
                                    'unlock'        => $html_unlock,
                                    'reprint'       => $html_repint,
                                    'status'        => $status
                                ];
                            }
                        }
                    }else{ //ลูกค้าสโมสร
                        $consigmentdata = DB::table('ptom_consignment_headers')->where('order_header_id',$order_item->order_header_id)->first();

                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if(!empty($print_hit)){
                            if($order_item->pick_release_print_flag == 'N' && $print_hit->print_flag == 'Y'){
                                if($print_hit->print_flag == 'Y'){
                                    $status = 'ปลดรายการ Reprint';
                                }else{
                                    $status = 'Reprint'.$print_hit->print_revision;
                                }
                            }else{
                                $status = 'Reprint'.$print_hit->print_revision;
                            }
                        }else{
                            $status = 'ปลดรายการ';
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" >';
                        if($order_item->pick_release_print_flag == 'N'){
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }else{
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }


                        if($order_item->unlock_print_flag == 'Y'){
                            $html_unlock = '<input type="checkbox" class="" disabled value="Y" name="unlockdis['.$order_item->order_header_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$order_item->order_header_id.']">';
                        }else{
                            $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$order_item->order_header_id.']" >';
                        }

                        $data_order['data'][] = [
                            'id'            => $id,
                            'invoice'       => $order_item->pick_release_no.'<br>'.$html_id,
                            'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name' => $order_item->customer_name,
                            'total'         => number_format($order_item->grand_total,2,'.',','),
                            'unlock'        => $html_unlock,
                            'reprint'       => $html_repint,
                            'status'        => $status
                        ];

                        //กรณีไมไ่ด้ค้นหาจาก invoice ทำการ เช็คเลข invoice
                        // if(!empty($order_item->pick_release_no) && empty($request->pick_release)){
                        //     //สถานะinvoice
                        //     $data_order['data'][] = [
                        //         'id'            => $id,
                        //         'invoice'       => $order_item->pick_release_no.'<br>'.$html_id,
                        //         'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                        //         'customer_name' => $order_item->customer_name,
                        //         'total'         => number_format($order_item->grand_total,2,'.',','),
                        //         'unlock'        => $html_unlock,
                        //         'reprint'       => $html_repint,
                        //         'status'        => $status
                        //     ];
                        // }

                        $creditnote = DB::table('ptom_invoice_headers')
                                            ->select('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                                    'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->join('ptom_invoice_lines','ptom_invoice_lines.invoice_headers_id','=','ptom_invoice_headers.invoice_headers_id')
                                            ->where('ptom_invoice_lines.document_id',$order_item->order_header_id)
                                            ->where(function($query){
                                                $query->where('ptom_invoice_headers.program_code','OMP0033');
                                                $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                                $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            })
                                            // ->where(function($query){
                                            //     $query->where('ptom_invoice_headers.program_code','OMP0033');
                                            //     $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                            //     $query->where('ptom_invoice_headers.invoice_status','Confirm');
                                            // })
                                            ->groupBy('ptom_invoice_headers.invoice_headers_id','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_number',
                                            'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                                            ->get();
                        if($creditnote->count() > 0){
                            foreach($creditnote  as $creditnote_item){
                                $print_hit = PrintHistoryModel::where('document_id',$order_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                                if(!empty($print_hit)){
                                    if($order_item->pick_release_print_flag == 'N' && $print_hit->print_flag == 'Y'){
                                        if($print_hit->print_flag == 'Y'){
                                            $status = 'ปลดรายการ Reprint';
                                        }else{
                                            $status = 'Reprint'.$print_hit->print_revision;
                                        }
                                    }else{
                                        $status = 'Reprint'.$print_hit->print_revision;
                                    }
                                }else{
                                    $status = 'ปลดรายการ';
                                }

                                $id = $order_item->invoice_headers_id;
                                $html_id = '<input type="hidden" name="invoice['.$order_item->invoice_headers_id.']" >';
                                if($order_item->attribute1 == 'Y'){
                                    $html_unlock = '<input type="checkbox" class="" value="Y" disabled name="unlockdis['.$order_item->invoice_headers_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$order_item->order_header_id.']">';
                                }else{
                                    $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$order_item->invoice_headers_id.']" >';
                                }
                            
                                if($order_item->attribute2 == 'Y'){
                                    $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->invoice_headers_id.']">';
                                }else{
                                    $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->invoice_headers_id.']">';
                                }

                                $data_order['data'][] = [
                                    'id'            => $id,
                                    'invoice'       => $order_item->invoice_headers_number.'<br>'.$html_id,
                                    'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                                    'customer_name' => $order_item->customer_name,
                                    'total'         => number_format($order_item->grand_total,2,'.',','),
                                    'unlock'        => $html_unlock,
                                    'reprint'       => $html_repint,
                                    'status'        => $status
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
            $order = OrderHeaderModel::joincreditnoteunlock($request->all())
                                        ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->whereNotNull('ptom_order_headers.pick_release_no') 
                                        ->whereNotNull('ptom_order_headers.delivery_date')
                                        ->where('ptom_order_headers.order_status','!=','Draft')
                                        ->where(function($query) use ($request){
                                            //find with delivarydate
                                            if(!empty($request->input_date)){
                                                $date_xp = \explode('/',$request->input_date);
                                                $year = $date_xp[2] - 543;
                                                $date = $year.'-'.$date_xp[1].'-'.$date_xp[0];
                                                $query->whereDate('ptom_order_headers.delivery_date',$date);
                                            }
                                            //find with customer
                                            if(!empty($request->customer_number)){
                                                $query->where('ptom_customers.customer_number',$request->customer_number);
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.delivery_date','desc')
                                        ->get();
            if($order->count() > 0){
                $i  = 1;
                foreach($order as $order_item){
                    if(!empty($request->pick_release)){
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->order_header_id)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if(!empty($print_hit)){
                            if($order_item->pick_release_print_flag == 'N' && $print_hit->print_flag == 'Y'){
                                if($print_hit->print_flag == 'Y'){
                                    $status = 'ปลดรายการ Reprint';
                                }else{
                                    $status = 'Reprint'.$print_hit->print_revision;
                                }
                            }else{
                                $status = 'Reprint'.$print_hit->print_revision;
                            }
                        }else{
                            $status = 'ปลดรายการ';
                        }

                        $id = $order_item->order_header_id;
                        $html_id = '<input type="hidden" name="order['.$order_item->order_header_id.']" >';
                        if($order_item->pick_release_print_flag == 'N'){
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }else{
                            $html_repint = '<input type="checkbox" class="unlock-print" value="Y" name="reprint['.$order_item->order_header_id.']">';
                        }


                        if($order_item->unlock_print_flag == 'Y'){
                            $html_unlock = '<input type="checkbox" class="" disabled value="Y" name="unlockdis['.$order_item->order_header_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$order_item->order_header_id.']">';
                        }else{
                            $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$order_item->order_header_id.']" >';
                        }

                        //recorde data 
                        $data_order['data'][] = [
                            'id'            => $id,
                            'invoice'       => $order_item->pick_release_no.'<br>'.$html_id,
                            'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name' => $order_item->customer_name,
                            'total'         => number_format($order_item->grand_total,2,'.',','),
                            'unlock'        => $html_unlock,
                            'reprint'       => $html_repint,
                            'status'        => $status
                        ];
                    }else{
                        $print_hit = PrintHistoryModel::where('document_id',$order_item->invoice_headers_id)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                        if(!empty($print_hit)){
                            if($order_item->attribute1 == 'Y' && $print_hit->print_flag == 'Y'){
                                if($print_hit->print_flag == 'Y'){
                                    $status = 'ปลดรายการ Reprint';
                                }else{
                                    $status = 'Reprint'.$print_hit->print_revision;
                                }
                            }else{
                                $status = 'Reprint'.$print_hit->print_revision;
                            }
                        }else{
                            $status = 'ปลดรายการ';
                        }

                        $id = $order_item->invoice_headers_id;
                        $html_id = '<input type="hidden" name="invoice['.$order_item->invoice_headers_id.']" >';
                        if($order_item->attribute1 == 'Y'){
                            $html_unlock = '<input type="checkbox" class="" value="Y" disabled name="unlockdis['.$order_item->invoice_headers_id.']" checked=""> <input type="hidden" value="Y" name="unlock['.$order_item->order_header_id.']">';
                        }else{
                            $html_unlock = '<input type="checkbox" class="unlock-print" value="Y" name="unlock['.$order_item->invoice_headers_id.']" >';
                        }
                    
                        if($order_item->attribute2 == 'Y'){
                            $html_repint = '<input type="checkbox" value="Y" class="unlock-print" name="reprint['.$order_item->invoice_headers_id.']">';
                        }else{
                            $html_repint = '<input type="checkbox"  class="unlock-print" value="Y" name="reprint['.$order_item->invoice_headers_id.']">';
                        }

                        $data_order['data'][] = [
                            'id'            => $id,
                            'invoice'       => $order_item->invoice_headers_number.'<br>'.$html_id,
                            'delivary_date' => !empty($order_item->delivery_date)? dateNoTimeNoSlad($order_item->delivery_date) : '',
                            'customer_name' => $order_item->customer_name,
                            'total'         => number_format($order_item->grand_total,2,'.',','),
                            'unlock'        => $html_unlock,
                            'reprint'       => $html_repint,
                            'status'        => $status
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

    public function savereprint(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!empty($request->order)){
                foreach($request->order as $key_order => $item_order){
                    if(!empty($request->reprint[$key_order]) || !empty($request->unlock[$key_order])){
                        $print_hit = PrintHistoryModel::where('document_id',$key_order)->where('attribute1','Order')->orderBy('print_id','desc')->first();
                        if(empty($print_hit)){
                            $print_history = [
                                'from_program_code' => 'OMP0037',
                                'document_id'       => $key_order,
                                'print_revision'    => 0,
                                'print_date'        => date('Y-m-d H:i:s'),
                                'print_flag'        => !empty($request->reprint[$key_order])? 'N' : 'Y',
                                'program_code'      => 'OMP0037',
                                'attribute1'        => 'Order',
                                'created_by'        => optional(auth()->user())->user_id,
                                'creation_date'     => date('Y-m-d H:i:s'),
                                'last_updated_by'   => optional(auth()->user())->user_id,
                                'last_update_date'  => date('Y-m-d H:i:s'),
                            ];

                            PrintHistoryModel::insert($print_history);
                        }else{
                            $print_history = [
                                'print_flag'        => !empty($request->reprint[$key_order])? 'N' : 'Y',
                                'last_updated_by'   => optional(auth()->user())->user_id,
                                'last_update_date'  => date('Y-m-d H:i:s'),
                            ];

                            PrintHistoryModel::where('document_id',$key_order)->where('attribute1','Order')->update($print_history);
                        }
                    }
                    if(!empty($request->unlock[$key_order])){
                        $update_order = [
                            'pick_release_print_flag'   => ($request->unlock[$key_order] == 'Y')? 'N' : 'Y',
                            'unlock_print_flag'         => !empty($request->reprint[$key_order])? 'Y' : 'N',
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];
                        OrderHeaderModel::where('order_header_id',$key_order)->update($update_order);
                    }
                }
            }

            if(!empty($request->invoice)){
                foreach($request->invoice as $key_invoice => $item_invoice){
                    if(!empty($request->reprint[$key_invoice]) || !empty($request->unlock[$key_invoice])){
                        $print_hit = PrintHistoryModel::where('document_id',$key_invoice)->where('attribute1','Invoice')->orderBy('print_id','desc')->first();
                        if(empty($print_hit)){
                            $print_history = [
                                'from_program_code' => 'OMP0037',
                                'document_id'       => $key_invoice,
                                'print_revision'    => 0,
                                'print_date'        => date('Y-m-d H:i:s'),
                                'print_flag'        => !empty($request->reprint[$key_invoice])? 'N' : 'Y',
                                'program_code'      => 'OMP0037',
                                'attribute1'        => 'Invoice',
                                'created_by'        => optional(auth()->user())->user_id,
                                'creation_date'     => date('Y-m-d H:i:s'),
                                'last_updated_by'   => optional(auth()->user())->user_id,
                                'last_update_date'  => date('Y-m-d H:i:s'),
                            ];

                            PrintHistoryModel::insert($print_history);
                        }else{
                            $print_history = [
                                'print_flag'        => !empty($request->reprint[$key_invoice])? 'N' : 'Y',
                                'last_updated_by'   => optional(auth()->user())->user_id,
                                'last_update_date'  => date('Y-m-d H:i:s'),
                            ];

                            PrintHistoryModel::where('document_id',$key_invoice)->where('attribute1','Invoice')->update($print_history);
                        }
                    }
                    if(!empty($request->unlock[$key_order])){
                        $update_order = [
                            'attribute1'                => ($request->unlock[$key_invoice] == 'Y')? 'Y' : 'N',
                            'attribute2'                => !empty($request->reprint[$key_invoice])? 'Y' : 'N',
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s'),
                        ];
                        InvoiceHeaderModel::where('invoice_headers_id',$key_invoice)->update($update_order);
                    }
                }
            }

            DB::commit();
            $rest = [
                'status'    => true,
                'message'   => 'success'
            ];
            return response()->json(['data'=>$rest]);
        } catch (\Exception $em) {
            DB::rollBack();
            $result = [
                'status'    => false,
                'message'   => $em->getMessage()." line: " . $em->getLine(),
            ];
            return response()->json(['data'=>$result]);
        }
    }
}
