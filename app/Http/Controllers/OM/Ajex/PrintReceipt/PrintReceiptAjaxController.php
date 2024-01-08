<?php

namespace App\Http\Controllers\OM\Ajex\PrintReceipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\OM\PrintReceipt\PrintReceiptModel;

class PrintReceiptAjaxController extends Controller
{
    public function searchRecreipt(Request $request)
    {
        $data = PrintReceiptModel::select(  'ptom_release_receipts.*',
                                            'ptom_customers.customer_name',
                                            'ptom_payment_headers.payment_date','ptom_payment_headers.payment_number','ptom_payment_headers.total_payment_amount','ptom_payment_headers.payment_status','ptom_payment_headers.payment_header_id')
                                    ->leftJoin('ptom_payment_headers','ptom_payment_headers.payment_header_id','=','ptom_release_receipts.payment_header_id')
                                    ->leftJoin('ptom_customers','ptom_customers.customer_id','=','ptom_payment_headers.customer_id')
                                    ->where('ptom_customers.sales_classification_code','Domestic')
                                    ->where('ptom_release_receipts.release_flag','Y')
                                    ->whereNotNull('ptom_payment_headers.payment_number')
                                    ->where(function($query) use ($request){
                                        if(!empty($request->payment_date)){
                                            $date_ep    = \explode('/',$request->payment_date);
                                            $year       = $date_ep[2] - 543;
                                            $date       = $year.'-'.$date_ep[1].'-'.$date_ep[0];
                                            $query->whereDate('ptom_payment_headers.payment_date',$date);
                                        }
                                        if(!empty($request->receript_number)){
                                            $query->where('ptom_payment_headers.payment_number',$request->receript_number);
                                        }
                                    })
                                    ->where('ptom_payment_headers.payment_status','!=','Draft')
                                    ->orderBy('ptom_release_receipts.print_flag','desc')
                                    ->orderBy('ptom_payment_headers.payment_number','desc')
                                    ->get();
        $list_data = [];
        if(!empty($data)){
            foreach($data as $item_data){

                $sum_total = DB::table('ptom_payment_details')->where('payment_header_id',$item_data->payment_header_id)->sum('payment_amount');

                $list_data['data'][] = [
                    'id'                    => $item_data->receipt_id,
                    'recripet_number'       => $item_data->payment_number.'<br> <input type="hidden" name="receipt['.$item_data->receipt_id.']" > <input type="hidden" name="number['.$item_data->receipt_id.']" value="'.$item_data->payment_number.'" > ',
                    'payment_date'          => !empty($item_data->payment_date)? dateNoTimeNoSlad($item_data->payment_date) : '',
                    'customer_name'         => $item_data->customer_name,
                    'total_payment_amount'  => number_format($sum_total,2,'.',','),
                    'unlock'                => ($item_data->print_flag == 'Y')? '<input type="checkbox" value="Y" disabled="" name="print['.$item_data->receipt_id.']" checked="">' : '<input type="checkbox" class="print_data" value="Y" name="print['.$item_data->receipt_id.']" >',
                    'reprint'               => ($item_data->printed_flag == 'Y')? '<input type="checkbox" value="Y" disabled="" name="printed['.$item_data->receipt_id.']" checked="">' : '<input type="checkbox" value="Y" disabled="" name="printed['.$item_data->receipt_id.']">',
                    'payment_status'        => !empty($item_data->payment_status) ? $item_data->payment_status : ''
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
    }

    public function print_receipt(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'print'                 => 'required',
        ],[
            'print.required'        => 'กรุณาเลือกรายการที่ต้องการพิมพ์',
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
                $print = [];
                $print_id = [];
                foreach($request->receipt as $key_receipt => $item_receipt){
                    if(!empty($request->print[$key_receipt])){
                        $update = [
                            'reprint_flag'          => 'N',
                            'print_flag'            => !empty($request->print[$key_receipt]) ? 'Y' : 'N',
                            'printed_flag'          => !empty($request->print[$key_receipt]) ? 'Y' : 'N',
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s'),
                        ];
                        $print[] = 'Y';
                        $print_id[] = $request->number[$key_receipt];
                        PrintReceiptModel::where('receipt_id',$key_receipt)->update($update);
                    }
                }

                if(\in_array('Y',$print)){
                    $printed = true;
                }else{
                    $printed = false;
                }

                $rest = [
                    'status'    => true,
                    'message'   => 'Success',
                    'print'     => $printed,
                    'print_id'  => $print_id
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
}
