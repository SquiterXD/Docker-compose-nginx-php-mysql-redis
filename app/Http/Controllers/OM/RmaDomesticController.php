<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Rma\Domestic\PtomOrderHeaders;
use App\Models\OM\Rma\Domestic\PtomClaimHeaders;
use App\Models\OM\Rma\Customers;
use App\Models\OM\Rma\PtomUomV;

class RmaDomesticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = PtomClaimHeaders::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','DOMESTIC')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->limit(300)
            ->get([
                'pch.*'
                ,'pcss.ship_to_site_name'
                ,'pcss.province_name'
            ]);

        $invoices = PtomOrderHeaders::from('PTOM_ORDER_HEADERS POH')
            ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'POH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
            ->join('PTOM_CUSTOMERS PC','POH.CUSTOMER_ID','PC.CUSTOMER_ID')
            ->where('POH.PICK_RELEASE_STATUS','Confirm')
//            ->whereNotIn('PC.CUSTOMER_TYPE_ID',[30,40])
            ->whereNotNull('POH.PICK_RELEASE_NO')
            ->orderBy('POH.PICK_RELEASE_NO','desc')
            ->limit(300)
            ->get([
                'POH.ORDER_HEADER_ID'
                ,'POH.CUSTOMER_ID'
                ,'POH.ORG_ID'
                ,'POH.PRODUCT_TYPE_CODE'
                ,'POH.PICK_RELEASE_NO'
                ,'POH.PICK_RELEASE_APPROVE_DATE'
                ,'POH.PICK_RELEASE_STATUS'
                ,'POH.DELIVERY_DATE'
                ,'POH.TERM_ID'
                ,'POH.SOURCE_SYSTEM'
                ,'POH.REMARK_SOURCE_SYSTEM'
                ,'POH.SHIP_TO_SITE_ID'
                ,'PCSS.SHIP_TO_SITE_NAME'
                ,'PCSS.PROVINCE_NAME'
            ]);
//        dd('Invoice',$invoices);
        $customers = Customers::where('SALES_CLASSIFICATION_CODE','Domestic')
            ->whereNotNull('CUSTOMER_NUMBER')
            ->orderBy('CUSTOMER_NUMBER')
            ->get();

        $uomlist = PtomUomV::where('DOMESTIC','Y')
//            ->whereNotIn('UOM_CLASS',['บุหรี่'])
            ->orderBy('UOM_CODE')
            ->get();


        $url = (object)[];
        $url->ajax_get_by_number = route('om.ajax.rma.domestic.get-by-number');
        $url->ajax_get_by_invoice = route('om.ajax.rma.domestic.get-by-invoice');
        $url->ajax_get_by_customer = route('om.ajax.rma.domestic.get-by-customer');
        $url->ajax_get_number_only = route('om.ajax.rma.domestic.get-number-only');
//        $url->ajax_get_invoice_only = route('om.ajax.rma.domestic.get-invioce-only');
//        $url->ajax_get_customer_only = route('om.ajax.rma.domestic.get-customer-only');
        $url->ajax_get_new_number = route('om.ajax.rma.domestic.get-new-number');
        $url->ajax_get_lines = route('om.ajax.rma.domestic.get-lines');
        $url->ajax_get_number_list = route('om.ajax.rma.domestic.get-number-list');
        $url->ajax_get_invoice_list = route('om.ajax.rma.domestic.get-invoice-list');
        $url->ajax_get_invoice_lines = route('om.ajax.rma.domestic.get-invoice-lines');
        $url->ajax_get_previous_rma = route('om.ajax.rma.domestic.get-previous-rma');
        $url->ajax_convert_unit = route('om.ajax.rma.domestic.convert-unit');
        $url->ajax_create_rma = route('om.ajax.rma.domestic.create-rma');
        $url->ajax_update_rma = route('om.ajax.rma.domestic.update-rma');
        $url->ajax_confirm_rma = route('om.ajax.rma.domestic.confirm-rma');
        $url->ajax_cancel_rma = route('om.ajax.rma.domestic.cancel-rma');

        return view('om.rma_domestic.index',compact('numbers','invoices','customers','url','uomlist'));
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
        //
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
    public function update(Request $request, $id)
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
