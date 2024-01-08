<?php

namespace App\Http\Controllers\OM\Ajex\ApproveSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Repositories\OM\OrderRepo;

use App\Models\OM\ApproveSaleOrder\PrepareSaleOrderModel;
use App\Models\OM\ApproveSaleOrder\PaymentHeaderModel;
use App\Models\OM\ApproveSaleOrder\AdditionQuotaHeaderModel;
use App\Models\OM\PrepareSaleOrder\CustomerModel;

class ApproveSaleOrderAjaxController extends Controller
{
    public function searchSaleOrder(Request $request)
    {
        $data  = PrepareSaleOrderModel::with('Customer')
                                        ->select('ptom_order_headers.*')
                                        ->where('ptom_order_headers.order_status','Confirm')
                                        // ->where('ptom_order_history.order_status','Inprocess')
                                        // ->join('ptom_order_history','ptom_order_history.order_header_id','=','ptom_order_headers.order_header_id')
                                        ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->where(function($query)use($request){
                                            if(!empty($request->customer_id)){
                                                $query->where('ptom_order_headers.customer_id',$request->customer_id);
                                             }
                                        })
                                        ->where(function($query)use($request){
                                            if(!empty($request->prepare_number)){
                                               $query->where('ptom_order_headers.prepare_order_number',$request->prepare_number);
                                            }
                                        })
                                        ->where(function($query)use($request){
                                            if(!empty($request->delivary_date) && empty($request->delivary_date_to)){
                                                $date_ex = explode('/',$request->delivary_date);
                                                $year_1  = $date_ex[2] - 543;
                                                $date    = $year_1.'-'.$date_ex[1].'-'.$date_ex[0];

                                                $query->where('ptom_order_headers.delivery_date','>=',$date);
                                            }

                                            if(!empty($request->delivary_date) && !empty($request->delivary_date_to)){
                                                $date_ex = explode('/',$request->delivary_date);
                                                $year_1  = $date_ex[2] - 543;
                                                $date    = $year_1.'-'.$date_ex[1].'-'.$date_ex[0];

                                                $dateto_ex = explode('/',$request->delivary_date_to);
                                                $year_2  = $dateto_ex[2] - 543;
                                                $date2    = $year_2.'-'.$dateto_ex[1].'-'.$dateto_ex[0];

                                                $query->where('ptom_order_headers.delivery_date','>=',$date);
                                                $query->where('ptom_order_headers.delivery_date','<=',$date2);
                                            }
                                            if(empty($request->delivary_date) && !empty($request->delivary_date_to)){
                                                $dateto_ex = explode('/',$request->delivary_date_to);
                                                $year_2  = $dateto_ex[2] - 543;
                                                $date2    = $year_2.'-'.$dateto_ex[1].'-'.$dateto_ex[0];

                                                $query->where('ptom_order_headers.delivery_date','<=',$date2);
                                            }
                                        })
                                        ->join('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        ->leftJoin('ptom_order_history','ptom_order_history.order_header_id','=','ptom_order_headers.order_header_id')
                                        ->where('ptom_order_history.order_status','Inprocess')
                                        ->where('ptom_customers.sales_classification_code','Domestic')
                                        ->whereNull('ptom_order_history.deleted_at')
                                        ->where(function($query) use($request) {
                                            if(empty($request->status_order)){
                                                $query->whereNull('ptom_order_headers.payment_approve_flag');
                                                $query->orWhere('ptom_order_headers.payment_approve_flag','Y');
                                            }elseif($request->status_order == 'N'){
                                                $query->whereNull('ptom_order_headers.payment_approve_flag');
                                            }elseif($request->status_order == 'Y'){
                                                $query->where('ptom_order_headers.payment_approve_flag','Y');
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.prepare_order_number','desc')
                                        ->whereNotNull('ptom_order_headers.delivery_date')
                                        ->get();

        if($data->count() > 0){
            $i =1;
            $output = [];
            foreach($data as $item_data){

                $cash   = !empty($item_data->cash_amount)? $item_data->cash_amount : 0;
                $amount = !empty($item_data->credit_amount)? $item_data->credit_amount : 0;
                $total  = $cash + $amount;
                if(empty($item_data->payment_header_id)){
                    $payment = 'ยังไม่รับชำระ';
                    $payment_status = 'N';
                }else{
                    $payment_data = PaymentHeaderModel::where('payment_header_id',$item_data->payment_header_id)->first();
                    if(!empty($paymetn)){
                        if($payment_data->payment_status == 'Confirm'){
                            $payment = 'ชำระแล้ว';
                            $payment_status = 'Y';
                        }else{
                            $payment = 'ยังไม่รับชำระ';
                            $payment_status = 'N';
                        }
                    }else{
                        $payment = 'ยังไม่รับชำระ';
                        $payment_status = 'N';
                    }
                }
                if($item_data->program_code == 'OMP0020'){
                    $payment = 'ไม่ต้องชำระเงิน';
                    $payment_status = 'N';
                }

                $quota = AdditionQuotaHeaderModel::where('order_header_id', $item_data->order_header_id)->first();
                if(empty($quota)){
                    $status_order = 'order_nomal';
                }else{
                    $status_order = 'order_limit';
                }

                if(!empty($item_data->delivery_date)){
                    $time_ex = \explode(' ',$item_data->delivery_date);
                    $date_ex = \explode('-',$time_ex[0]);
                    $year    = $date_ex[0] + 543;
                    $n_date  = $date_ex[2].'/'.$date_ex[1].'/'.$year;
                }else{
                    $n_date  = '';
                }

                if(empty($request->payment_status)){
                    if($item_data->program_code == 'OMP0020') {
                        $link_report ="<a target='_blank' href='/om/prepare-saleorder/print/report?order=".$item_data->order_header_id."'>".$item_data->prepare_order_number."</a>";
                    } else {
                        $link_report = "<a target='_blank' href='/om/order/prepare/report_preparation?prepare_order_number=".$item_data->prepare_order_number."'>".$item_data->prepare_order_number."</a>";
                    }
                    $output[] = [
                        'id'                    => '<input type="checkbox" class="approve" value="Y" name="order['.$item_data->order_header_id.']">',
                        'number'                => $i,
                        'prepare_number'        => $link_report,
                        'customer_name'         => !empty( $item_data->Customer)? $item_data->Customer->customer_name_format : '',
                        'delivery_date'         => $n_date,
                        'cash_amount'           => number_format($cash,2,'.',','),
                        'credit_amount'         => number_format($amount,2,'.',','),
                        'amount_total'          => number_format($total,2,'.',','),
                        'approve_status'        => ($item_data->payment_approve_flag == 'Y')? '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green checked"></label></div>' : '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green"></label></div>',
                        'payment_status'        => $payment,
                        'row_status'            => $status_order,
                        'col_payment'           => $payment_status
                    ];
                    $i++;
                }elseif($request->payment_status == 'Confirm' && !empty($item_data->payment_header_id)){
                    $output[] = [
                        'id'                    => '<input type="checkbox" class="approve" value="Y" name="order['.$item_data->order_header_id.']">' ,
                        'number'                => $i,
                        'prepare_number'        => $item_data->prepare_order_number,
                        'customer_name'         => !empty( $item_data->Customer)? $item_data->Customer->customer_name : '',
                        'delivery_date'         => $n_date,
                        'cash_amount'           => number_format($cash,2,'.',','),
                        'credit_amount'         => number_format($amount,2,'.',','),
                        'amount_total'          => number_format($total,2,'.',','),
                        'approve_status'        => ($item_data->payment_approve_flag == 'Y')? '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green checked"></label></div>' : '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green"></label></div>',
                        'payment_status'        => $payment,
                        'row_status'            => $status_order,
                        'col_payment'           => $payment_status
                    ];
                    $i++;
                }elseif($request->payment_status != 'Confirm'){
                    $output[] = [
                        'id'                    => '<input type="checkbox" class="approve" value="Y" name="order['.$item_data->order_header_id.']">' ,
                        'number'                => $i,
                        'prepare_number'        => $item_data->prepare_order_number,
                        'customer_name'         => !empty( $item_data->Customer)? $item_data->Customer->customer_name : '',
                        'delivery_date'         => $n_date,
                        'cash_amount'           => number_format($cash,2,'.',','),
                        'credit_amount'         => number_format($amount,2,'.',','),
                        'amount_total'          => number_format($total,2,'.',','),
                        'approve_status'        => ($item_data->payment_approve_flag == 'Y')? '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green checked"></label></div>' : '<div class="i-checks wihtout-text m-auto disabled"><label class="icheckbox_square-green"></label></div>',
                        'payment_status'        => $payment,
                        'row_status'            => $status_order,
                        'col_payment'           => $payment_status
                    ];
                    $i++;
                }
            }

            $rest = [
                'status'    => true,
                'data'      => $output
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'No Data'
            ];
        }

        return response()->json(['data'=>$rest]);
    }

    public function updateStatusSaleOrder(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'order'                 => 'required',
        ],[
            'order.required'        => 'กรุณาเลือกรายการที่ต้องการดำเนินการ',
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
                if($request->type == 'approve'){
                    $data = [];
                    foreach($request->order as $key => $item){
                        $OrderData = PrepareSaleOrderModel::where('order_header_id',$key)->first();
                        // if($OrderData->cash_amount <> 0){
                        //     if(empty($OrderData->payment_header_id)){
                        //         $data['NotApprove'][] = $OrderData->prepare_order_number;
                        //     }else{
                        //         $payment_data = PaymentHeaderModel::where('payment_header_id',$OrderData->payment_header_id)->first();
                        //         if($payment_data->payment_status == 'Confirm'){
                        //             if($OrderData->payment_type_code == 10){
                        //                 $status = 'Wait Pay';
                        //             }else if($OrderData->payment_type_code == 20){
                        //                 $status = 'Invoice';
                        //             }
                        //             $OrderData->payment_approve_flag        = 'Y';
                        //             $OrderData->order_status                = 'Inprocess';
                        //             $OrderData->last_updated_by             = optional(auth()->user())->user_id;
                        //             $OrderData->last_update_date            = date('Y-m-d H:i:s');
                        //             $OrderData->save();

                        //             OrderRepo::insertOrdersHistoryv2($OrderData,$status);
                        //         }else{
                        //             $data['NotApprove'][] = $OrderData->prepare_order_number;
                        //         }
                        //     }
                        // }else{
                            $customer = CustomerModel::where('customer_id',$OrderData->customer_id)->first();
                            if($customer->customer_type_id != '30' && $customer->customer_type_id != '40'){ // ลูกค้าที่ไม่ได้เป็นสโมสร
                                if($OrderData->cash_amount > 0){ 
                                    $status = 'Wait Pay';
                                }elseif($OrderData->payment_type_code == 10){
                                    $status = 'Wait Pay';
                                }else if($OrderData->payment_type_code == 20){
                                    $status = 'Wait Pay';
                                }
                            }else{ // ลูกค้าที่เป็นสโมสร
                                $status = 'Invoice';
                            }

                            $OrderData->payment_approve_flag        = 'Y';
                            // $OrderData->order_status                = 'Inprocess';
                            $OrderData->last_updated_by             = optional(auth()->user())->user_id;
                            $OrderData->last_update_date            = date('Y-m-d H:i:s');
                            $OrderData->save();

                            OrderRepo::insertOrdersHistoryv2($OrderData,$status);
                        // }
                    }

                    $rest = [
                        'status'    => true,
                        'message'   => 'บันทึกข้อมูลสำเร็จสถานะ: อนุมัติ',
                        'data'      => $data
                    ];
                }elseif($request->type == 'reject'){
                    foreach($request->order as $key => $item){
                        $OrderData = PrepareSaleOrderModel::where('order_header_id',$key)->first();
                        $OrderData->payment_approve_flag        = 'N';
                        $OrderData->order_status                = 'Reject';
                        $OrderData->last_updated_by             = optional(auth()->user())->user_id;
                        $OrderData->last_update_date            = date('Y-m-d H:i:s');
                        $OrderData->save();
                    }

                    $rest = [
                        'status'    => true,
                        'message'   => 'บันทึกข้อมูลสำเร็จสถานะ: ยกเลิก',
                    ];
                }else{
                    $rest = [
                        'status'    => false,
                        'message'   => 'ผิดผลาดกรุณาลองใหม่อีกครั้ง',
                    ];
                }

            }catch (\Exception $e) {
                DB::rollBack();
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong',
                    'message'   => $e->getMessage()
                ];
            }
            DB::commit();
        }
        return response()->json(['data' => $rest]);
    }
}
