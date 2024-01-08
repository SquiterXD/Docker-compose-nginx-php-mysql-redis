<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExchangeExportAjaxController extends Controller
{

    public function create($number)
    {
        $rest = [];

        return response()->json(['data' => $rest]);
    }

    public function search(Request $request)
    {
        $rest = [];

        echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit();

        return response()->json(['data' => $rest]);
    }

    public function update(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        if (!empty($request->pick_release_no)) {

            // วันที่ในใบขน
            if(!empty($request->pick_exchange_date)){
                $dateArr    = explode('/', $request->pick_exchange_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $exchangeTime = strtotime($newDate);
                $exchangeDate = date('Y-m-d H:i:s',$exchangeTime);
            }else{
                $exchangeDate = '';
            }
            // print_r($exchangeDate);
            // exit();

            // if(!empty($request->pick_exchange_date)){
            //     $exchangeTime = strtotime($request->pick_exchange_date);
            //     $exchangeDate = date('Y-m-d H:i:s',$exchangeTime);
            // }else{
            //     $exchangeDate = '';
            // }

            $update = [
                'pick_exchange_rate'    => $request->pick_exchange_rate,
                'pick_exchange_date'    => $exchangeDate,
                'program_code'          => 'OMP0075',
                'updated_by_id'         => optional(auth()->user())->user_id,
                'updated_at'            => date('Y-m-d H:i:s'),
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s')
            ];

            ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update);

            // $pickReleaseNoList  = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
            //                                             ->select(
            //                                                 'ptom_proforma_invoice_headers.pi_header_id',
            //                                                 'ptom_proforma_invoice_headers.pick_release_no',
            //                                                 'ptom_proforma_invoice_headers.pick_release_approve_date',
            //                                                 'ptom_proforma_invoice_headers.pick_release_status',
            //                                                 'ptom_proforma_invoice_headers.exchange_rate',
            //                                                 'ptom_proforma_invoice_headers.currency',
            //                                                 'ptom_proforma_invoice_headers.pick_exchange_rate',
            //                                                 'ptom_proforma_invoice_headers.pick_exchange_date',
            //                                                 'ptom_proforma_invoice_headers.customer_id',
            //                                                 'ptom_customers.customer_number',
            //                                                 'ptom_customers.customer_name'
            //                                             )
            //                                             ->where('ptom_proforma_invoice_headers.pick_release_status', 'Confirm')
            //                                             ->orderBy('ptom_proforma_invoice_headers.pick_release_no', 'desc')
            //                                             ->get();

            // foreach ($pickReleaseNoList as $key => $value) {
            //     $pickReleaseNoList[$key]->pick_release_approve_date = !empty($pickReleaseNoList[$key]->pick_release_approve_date) ?dateFormatDMYDefault(date('d/m/Y',strtotime($pickReleaseNoList[$key]->pick_release_approve_date))) : '';
            //     $pickReleaseNoList[$key]->pick_exchange_date        = !empty($pickReleaseNoList[$key]->pick_exchange_date) ?dateFormatDMYDefault(date('d/m/Y',strtotime($pickReleaseNoList[$key]->pick_exchange_date))) : '';
            // }

            $status = 'success';
        }else{
            $status = 'fail';
        }

        $pickReleaseNoList  = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                        ->select(
                                                            'ptom_proforma_invoice_headers.pi_header_id',
                                                            'ptom_proforma_invoice_headers.pick_release_no',
                                                            'ptom_proforma_invoice_headers.pick_release_approve_date',
                                                            'ptom_proforma_invoice_headers.pick_release_status',
                                                            'ptom_proforma_invoice_headers.exchange_rate',
                                                            'ptom_proforma_invoice_headers.currency',
                                                            'ptom_proforma_invoice_headers.pick_exchange_rate',
                                                            'ptom_proforma_invoice_headers.pick_exchange_date',
                                                            'ptom_proforma_invoice_headers.customer_id',
                                                            'ptom_customers.customer_number',
                                                            'ptom_customers.customer_name'
                                                        )
                                                        ->where('ptom_proforma_invoice_headers.pick_release_status', 'Confirm')
                                                        ->orderBy('ptom_proforma_invoice_headers.pick_release_no', 'desc')
                                                        ->get();

            foreach ($pickReleaseNoList as $key => $value) {
                $pickReleaseNoList[$key]->pick_release_approve_date = !empty($pickReleaseNoList[$key]->pick_release_approve_date) ? date('d/m/Y',strtotime($pickReleaseNoList[$key]->pick_release_approve_date)) : '';
                $pickReleaseNoList[$key]->pick_exchange_date        = !empty($pickReleaseNoList[$key]->pick_exchange_date) ? date('d/m/Y',strtotime($pickReleaseNoList[$key]->pick_exchange_date)) : '';
            }

        $rest = [
            'data'      => $pickReleaseNoList,
            'status'    => $status
        ];

        return response()->json(['data' => $rest]);
    }
}
