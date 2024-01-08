<?php

namespace App\Http\Controllers\OM\Ajex\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OM\CreditNote\CustomerContractGroupModel;
use App\Models\OM\CreditNote\RanchTransFerLineModel;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Invoice\CancelInvoiceModel;
use App\Models\OM\CreditNote\PaymentDncnModel;


class CancelInvoiceAjaxController extends Controller
{
    public function invoice_list(Request $request)
    {
        // DB::enableQueryLog(); // Enable query log
        $invoice = CancelInvoiceModel::where(function($query){
                                            $query->where('ptom_invoice_headers.program_code','OMP0033');
                                            $query->orWhere('ptom_invoice_headers.program_code','OMP0034');
                                            $query->orWhere('ptom_invoice_headers.program_code','OMP0052');
                                        })
                                        ->where(function($query) use ($request){
                                            if(!empty($request->pay_invoice)){
                                                $date_ep    = \explode('/',$request->pay_invoice);
                                                $year       = $date_ep[2] - 543;
                                                $date       = $year.'-'.$date_ep[1].'-'.$date_ep[0];

                                                $query->whereDate('ptom_invoice_headers.invoice_date', $date);
                                            }

                                            if (!empty($request->invoice)) {
                                                $query->where('ptom_invoice_headers.invoice_headers_number', $request->invoice);
                                            }

                                        })
                                        ->where('ptom_invoice_headers.invoice_status','Confirm')
                                        ->leftJoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_invoice_headers.customer_id')
                                        ->orderBy('ptom_invoice_headers.creation_date','desc')
                                        ->get();
                                        // dd(DB::getQueryLog()); // Show results of log
                                        // exit;
        $list_data = [];
        if (!empty($invoice)) {
            foreach ($invoice as $item_invoice) {
                $list_data[] = [
                    'invoice_number'    => $item_invoice->invoice_headers_number . '<br> <input type="hidden" name="invoice[' . $item_invoice->invoice_headers_id . ']"> ',
                    'invoice_date'      => !empty($item_invoice->invoice_date)? dateNoTimeNoSlad($item_invoice->invoice_date) : '',
                    'invoice_customer'  => $item_invoice->customer_name,
                    'invoice_amount'    => number_format($item_invoice->invoice_amount,2,'.',','),
                    'invoice_cancel'    => '<input type="checkbox" value="Cancelled"  name="cancel[' . $item_invoice->invoice_headers_id . ']" >',
                ];
            }
        } else {
            $list_data = [];
        }
        return response()->json(['data' => $list_data]);
    }

    public function invoice_save(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'cancel'                    => 'required|array',
            'cancel.*'                  => 'required'
        ], [
            'cancel.required'           => 'กรุณาเลือกรายการที่ต้องการยกเลิก',
        ]);

        if ($validate->fails()) {
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data' => $rest]);
        } else {
            DB::beginTransaction();
            try {
                foreach ($request->cancel as $key => $item) {
                    $update = [
                        'invoice_status'        => $item,
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s'),
                    ];

                    $data = CancelInvoiceModel::where('invoice_headers_id', $key)->update($update);
                    $data = CancelInvoiceModel::where('invoice_headers_id',$key )->first();

                    $updatePayment = [
                        'attribute1'           => 'C',
                        'last_updated_by'      => optional(auth()->user())->user_id,
                        'last_update_date'     => date('Y-m-d H:i:s')
                    ];
                    $paymentApply = PaymentDncnModel::where('invoice_header_id',$data->invoice_header_id)->update($updatePayment);

                    $line = RanchTransFerLineModel::where('invoice_headers_id',$data->invoice_headers_id)->first();
                    foreach($line as $line_item){
                        if(!empty($line_item->credit_group_code) && $line_item->credit_group_code != 0){
                            $ccg = CustomerContractGroupModel::where('customer_id',$data->customer_id)
                                                                ->where('credit_group_code',$line_item->credit_group_code)
                                                                ->first();
                            $ccg->remaining_amount = $ccg->remaining_amount - $line_item->invoice_amount;
                            $ccg->save();
                        }
                    }
                }

                $rest = [
                    'status'    => true,
                    'message'   => 'Success',
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
}
