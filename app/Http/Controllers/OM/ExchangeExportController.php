<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\PaymentType;
use App\Models\OM\SaleConexchangetion\Currencies;
use App\Models\OM\SaleConfirmation\Incoterms;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\PaymentMethodExport;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\SalesChannel;
use App\Models\OM\SaleConfirmation\ShipmentBy;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\TransactionTypes;
use Illuminate\Http\Request;

class ExchangeExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
                                                        'ptom_proforma_invoice_headers.forward_flag',
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

        // echo '<pre>';
        // print_r($pickReleaseNoList);
        // echo '</pre>';
        // exit();

        $data_compact = array(
            'pickReleaseNoList'
        );

        return view('om.exchange_export.index', compact($data_compact));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
