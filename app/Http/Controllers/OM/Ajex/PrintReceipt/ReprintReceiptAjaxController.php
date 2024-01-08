<?php

namespace App\Http\Controllers\OM\Ajex\PrintReceipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\OM\PrintReceipt\PrintReceiptModel;
use App\Models\OM\PrintReceipt\PaymentHeaderModel;

class ReprintReceiptAjaxController extends Controller
{
    public function searchReprint(Request $request)
    {
        $data = PaymentHeaderModel::select(  'ptom_release_receipts.*',
                                            'ptom_customers.customer_name',
                                            'ptom_payment_headers.payment_date','ptom_payment_headers.payment_number','ptom_payment_headers.total_payment_amount','ptom_payment_headers.payment_header_id')
                                    ->join('ptom_release_receipts','ptom_payment_headers.payment_header_id','=','ptom_release_receipts.payment_header_id')
                                    ->join('ptom_customers','ptom_customers.customer_id','=','ptom_payment_headers.customer_id')
                                    ->where('ptom_payment_headers.payment_status','Confirm')
                                    ->where('ptom_customers.sales_classification_code','Domestic')
                                    ->where(function($query) use ($request){
                                        if(!empty($request->payment_date)){
                                            $date_ep    = explode('/',$request->payment_date);
                                            $year       = $date_ep[2] - 543;
                                            $date       = $year.'-'.$date_ep[1].'-'.$date_ep[0];
                                            $query->whereDate('ptom_payment_headers.payment_date',$date);
                                        }
                                        if(!empty($request->receript_number)){
                                            $query->where('ptom_payment_headers.payment_number',$request->receript_number);
                                        }
                                        if(!empty($request->customer_number)){
                                            $query->where('ptom_payment_headers.customer_id',$request->customer_number);
                                        }
                                    })
                                    ->get();
        $list_data = [];
        if($data->count() > 0 ){
            foreach($data as $item_data){

                if($item_data->release_flag == 'Y' && $item_data->reprint_flag == 'N' && $item_data->print_flag == 'N'){
                    $status = 'ปลดรายการ';
                }else{
                    if($item_data->release_flag == 'Y' && $item_data->reprint_flag == 'Y'){
                        $check  = explode(' ',$item_data->status);
                        if($check[1] == 0){
                            $status = 'ปลดรายการ Reprint';
                        }else{
                            $status = ucfirst($item_data->status);
                        }
                    }else{
                        $check  = explode(' ',$item_data->status);
                        if($check[1] == 0 && $item_data->print_flag == 'N' && $item_data->release_flag == 'N'){
                            $status = '';
                        }else{
                            $status = 'พิมพ์แล้ว';
                        }
                        // if($item_data->release_flag == 'N' && $item_data->reprint_flag =='N'){
                            
                        // }else{
                 
                        // }
                    }
                }

                $sum_total = DB::table('ptom_payment_details')->where('payment_header_id',$item_data->payment_header_id)->sum('payment_amount');
                $unlockPrint = '';

                if($item_data->release_flag == 'N' && $item_data->release_flag == 'N'  && $item_data->release_flag == 'N'  && $item_data->release_flag == 'N' ) {
                    $unlockPrint = '<input type="checkbox" value="Y" disabled="">';
                } elseif($item_data->reprint_flag == 'Y' ) {
                    $unlockPrint = '<input type="checkbox" value="Y" disabled="" checked=""> <input type="hidden" value="Y" name="reprint['.$item_data->receipt_id.']" > ';
                } else {
                    $unlockPrint = '<input type="checkbox" value="Y" name="reprint['.$item_data->receipt_id.']" >';
                }

                $list_data['data'][] = [
                    'id'                    => $item_data->receipt_id,
                    'recripet_number'       => $item_data->payment_number.'<br> <input type="hidden" name="receipt['.$item_data->receipt_id.']" > ',
                    'payment_date'          => !empty($item_data->payment_date)? dateNoTimeNoSlad($item_data->payment_date) : '',
                    'customer_name'         => $item_data->customer_name,
                    'total_payment_amount'  => number_format($sum_total,2,'.',','),
                    'unlock'                => ($item_data->release_flag == 'Y')? '<input type="checkbox" value="Y" disabled="" checked=""> <input type="hidden" value="Y" name="unlock['.$item_data->receipt_id.']" > ' : '<input type="checkbox" value="Y" name="unlock['.$item_data->receipt_id.']" >',
                    'reprint'               => $unlockPrint,
                    'status'                => $status

                ];

                if(!empty($request->customer_number)){
                    $list_data['customer'] = $item_data->customer_name;
                }
            }
        }else{
            $list_data['data'] = [];
            $list_data['customer'] = '';
        }

        return response()->json(['data' => $list_data]);
        // pr($list_data);
    }

    public function reprint_receipt(Request $request)
    {
        DB::beginTransaction();
        try{
            foreach($request->receipt as $key_receipt => $item_receipt){
                if(!empty($request->unlock[$key_receipt]) && empty($request->reprint[$key_receipt])){
                    $update = [
                        'release_flag'          => !empty($request->unlock[$key_receipt]) ? 'Y' : 'N',
                        // 'print_flag'            => !empty($request->reprint[$key_receipt]) ? 'N' : 'Y',
                        // 'printed_flag'          => !empty($request->reprint[$key_receipt]) ? 'N' : 'Y',
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                }else{
                    $update = [
                        'release_flag'          => !empty($request->unlock[$key_receipt]) ? 'Y' : 'N',
                        'reprint_flag'          => !empty($request->reprint[$key_receipt]) ? 'Y' : 'N',
                        'print_flag'            => 'N',
                        'printed_flag'          => 'N',
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];
                }

                if(!empty($request->reprint[$key_receipt])){
                    $data = PrintReceiptModel::where('receipt_id',$key_receipt)->first();
                    $reprint_ep = explode(' ',$data->status);

                    $reprint = $reprint_ep[1] + 1;

                    $update['status'] = 'Reprint '.$reprint;
                }

                PrintReceiptModel::where('receipt_id',$key_receipt)->update($update);
            }

            $rest = [
                'status'    => true,
                'message'   => 'Success'
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
        return response()->json(['data'=>$rest]);
    }
}
