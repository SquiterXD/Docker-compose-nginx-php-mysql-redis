<?php

namespace App\Http\Controllers\OM\Customers\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Customers\Export\ForeignCustomerModel;
use App\Models\OM\Customers\Export\CustomerTypeExportListModel;
use App\Models\OM\Customers\Export\CountryVModel;
use App\Models\OM\Customers\Export\ThailandTerritoryVModel;
use App\Models\OM\Customers\Export\VatCodeModel;
use App\Models\OM\Customers\Export\PaymentMethodExport;
use App\Models\OM\Customers\Export\PaymentTermsModel;
use App\Models\OM\Customers\Export\ShipmentByModel;
use App\Models\OM\Customers\Export\ProfitLossFormulaModel;
use App\Models\OM\Customers\Export\OrderTypeModel;
use App\Models\OM\Customers\Export\IncotermsModel;
use App\Models\OM\Customers\Export\PriceListModel;
use App\Models\OM\Customers\Export\PyamentTypeModel;
use App\Models\OM\Customers\Export\SalesChannelVModel;
use App\Models\OM\Customers\Export\CurrencyModel;
use App\Models\OM\Customers\Export\CustomerTitleModel;

class ExportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!canEnter('/om/customers/exports') ||  !canView('/om/customers/exports')){
            return \redirect()->back()->withError(trans('403'));
        }

       return view('om.customers.export.index');
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
        if(!canEnter('/om/customers/exports') ||  !canView('/om/customers/exports')){
            return \redirect()->back()->withError(trans('403'));
        }

        $customer = ForeignCustomerModel::where('CUSTOMER_ID',$id)->first();

        $list_territory = ThailandTerritoryVModel::get();
        foreach($list_territory as $item_province){ //จังหวัด
            $province_list[$item_province->province_id] = [
                'id'        => $item_province->province_id,
                'name_th'   => $item_province->province_thai,
                'name_en'   => $item_province->province_eng
            ];
        }

        foreach($list_territory as $item_district){ //อำเภอ
            $district_list[$item_district->district_id] = [
                'id'            => $item_district->district_id,
                'name_th'       => $item_district->district_thai,
                'name_en'       => $item_district->district_eng,
                'province_id'   => $item_district->province_id,
            ];
        }

        foreach($list_territory as $item_tambon){ //ตำบล
            $tambon_list[$item_tambon->tambon_id] = [
                'id'                    => $item_tambon->tambon_id,
                'name_th'               => $item_tambon->tambon_thai,
                'name_en'               => $item_tambon->tambon_eng,
                'postcode_main'         => $item_tambon->postcode_main,
                'postcode_all'          => $item_tambon->postcode_all,
                'postal_code_remark'    => $item_tambon->postal_code_remark,
                'province_id'           => $item_tambon->province_id,
                'district_id'           => $item_tambon->district_id,
            ];
        }

        $customer_type = CustomerTypeExportListModel::where('enabled_flag','Y')->get();
        if(!empty($customer_type)){
            foreach($customer_type as $type_item){
                $type_list[$type_item->customer_type] = [
                    'id'        => $type_item->customer_type,
                    'name'      => $type_item->description,
                    'meaning'   => $type_item->description
                ];
            }
        }else{
            $type_list = [];
        }

        $country_list = CountryVModel::get();
        if(!empty($country_list)){
            foreach($country_list as $item_geo){
                $list_country[$item_geo->country_code] = [
                    'id'                => $item_geo->country_code,
                    'geography_name'    => $item_geo->country_name
                ];
            }
        }else{
            $list_country = [];
        }

        $vatcode        = VatCodeModel::where('tax_regime_code','SVAT')->where('rate_type_code','PERCENTAGE')->where('active_flag','Y')->get();
        $paymethod      = PaymentMethodExport::where('enabled_flag','Y')->get();
        foreach($paymethod as $method_item){
            $paymethod_list[$method_item->term_id] = [
                'name'  => $method_item->description
            ];
        }
        $payterms       = PaymentTermsModel::where('sale_type','EXPORT')
                                            ->where('start_date_active','<=',date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('end_date_active','>=',date('Y-m-d'));
                                                $query->orWhereNull('end_date_active');
                                            })->get();
        foreach($payterms as $payterms_item){
            $payterms_list[$payterms_item->term_id] = [
                'name'  => $payterms_item->description
            ];
        }
        $shipment       = ShipmentByModel::where('tag','E')->where('enabled_flag','Y')->get();
        $formula        = ProfitLossFormulaModel::where('enabled_flag','Y')->get();
        $ordertyper     = OrderTypeModel::where('sales_type','EXPORT')
                                        ->where('start_date_active','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date_active');
                                        })
                                        ->get();

        $incoterms      = IncotermsModel::where('enabled_flag','Y')
                                            ->where('start_date_active','<=',date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('end_date_active','>=',date('Y-m-d'));
                                                $query->orWhereNull('end_date_active');
                                            })
                                            ->get();

        $incoterms_label      = IncotermsModel::where('lookup_code','30')->first();

        $pricelist      = PriceListModel::where('attribute1','EXPORT')
                                            ->where('active_flag','Y')
                                            ->where('start_date_active','<=',date('Y-m-d'))
                                            ->where(function ($query) {
                                                $query->where('end_date_active','>=',date('Y-m-d'));
                                                $query->orWhereNull('end_date_active');
                                            })
                                            ->get();
        $paymenttype    = PyamentTypeModel::where('enabled_flag','Y')->get();
        $salechannel    = SalesChannelVModel::where('enabled_flag','Y')->get();
        $customertitle  = CustomerTitleModel::where('enabled_flag','Y')->get();
        $currency_list  = CurrencyModel::get();
        foreach( $currency_list as $currency_item){
            $currency[$currency_item->currency_code] = [
                'currency_code'  => $currency_item->currency_code,
                'description'  => $currency_item->description
            ];
        }


        return view('om.customers.export.show',
            compact(
                'customer',
                'type_list',
                'list_country',
                'list_territory',
                'vatcode',
                'paymethod',
                'paymethod_list',
                'payterms',
                'shipment',
                'formula',
                'ordertyper',
                'incoterms',
                'pricelist',
                'paymenttype',
                'salechannel',
                'currency',
                'province_list',
                'payterms_list',
                'customertitle',
                'incoterms_label'
            )
        );
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
