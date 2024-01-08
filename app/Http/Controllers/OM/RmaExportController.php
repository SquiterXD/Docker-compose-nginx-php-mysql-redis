<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Rma\Customers;
use App\Models\OM\Rma\PtomUomV;

class RmaExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = PtomProformaInvoiceLines::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','EXPORT')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->get();
//        dd($numbers);

        $invoices = PtomProformaInvoiceHeadres::from('PTOM_PROFORMA_INVOICE_HEADERS PPIH')
            ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'PPIH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
//            ->join('PTOM_CUSTOMERS PC','PPIH.CUSTOMER_ID','PC.CUSTOMER_ID')
            ->where('PPIH.PICK_RELEASE_STATUS','Confirm')
//            ->whereNotIn('PC.CUSTOMER_TYPE_ID',[30,40])
            ->whereNotNull('PPIH.PICK_RELEASE_NO')
            ->orderBy('PPIH.PICK_RELEASE_NO','desc')
            ->get([
                'PPIH.PI_HEADER_ID'
                ,'PPIH.CUSTOMER_ID'
                ,'PPIH.ORG_ID'
                ,'PPIH.PRODUCT_TYPE_CODE'
                ,'PPIH.PICK_RELEASE_NO'
                ,'PPIH.PICK_RELEASE_APPROVE_DATE'
                ,'PPIH.PICK_RELEASE_STATUS'
                ,'PPIH.DELIVERY_DATE'
                ,'PPIH.CURRENCY'
                ,'PPIH.TERM_ID'
                ,'PPIH.SOURCE_SYSTEM'
                ,'PPIH.REMARK_SOURCE_SYSTEM'
                ,'PPIH.SHIP_TO_SITE_ID'
                ,'PCSS.SHIP_TO_SITE_NAME'
                ,'PCSS.PROVINCE_NAME'
            ]);
//        dd('Invoice',$invoices);
        $customers = Customers::where('SALES_CLASSIFICATION_CODE','Export')
            ->whereNotNull('CUSTOMER_NUMBER')
            ->orderBy('CUSTOMER_NUMBER')
            ->get();

        $uomlist = PtomUomV::where('EXPORT','Y')
            ->orderBy('UOM_CODE')
            ->get();

        $url = (object)[];
        $url->ajax_get_by_number = route('om.ajax.rma.export.get-by-number');
        $url->ajax_get_by_invoice = route('om.ajax.rma.export.get-by-invoice');
        $url->ajax_get_by_customer = route('om.ajax.rma.export.get-by-customer');
        $url->ajax_get_number_only = route('om.ajax.rma.export.get-number-only');
        $url->ajax_get_new_number = route('om.ajax.rma.export.get-new-number');
//        $url->ajax_get_invoice_only = route('om.ajax.rma.export.get-invioce-only');
//        $url->ajax_get_customer_only = route('om.ajax.rma.export.get-customer-only');
        $url->ajax_get_lines = route('om.ajax.rma.export.get-lines');
        $url->ajax_get_invoice_lines = route('om.ajax.rma.export.get-invoice-lines');
        $url->ajax_get_previous_rma = route('om.ajax.rma.export.get-previous-rma');
        $url->ajax_convert_unit = route('om.ajax.rma.export.convert-unit');
        $url->ajax_create_rma = route('om.ajax.rma.export.create-rma');
        $url->ajax_update_rma = route('om.ajax.rma.export.update-rma');
        $url->ajax_confirm_rma = route('om.ajax.rma.export.confirm-rma');
        $url->ajax_cancel_rma = route('om.ajax.rma.export.cancel-rma');

        return view('om.rma_export.index',compact('numbers','invoices','customers','url','uomlist'));
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
