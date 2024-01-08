<?php

namespace App\Http\Controllers\OM\Customers\Domestics;

use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\Territory;
use App\Models\OM\Customers\Domestics\typeDomestic;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\Customers\Domestics\CustomerPrevious;
use App\Models\OM\Customers\Domestics\CustomerOwners;
use App\Models\OM\Customers\Domestics\ShipmentBy;
use App\Models\OM\Customers\Domestics\PaymentMethod;
use App\Models\OM\Customers\Domestics\TaxAccountModel;
use App\Models\OM\Customers\Domestics\CustomerContracts;
use App\Models\OM\Customers\Domestics\CustomerContractBooks;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\CustomerQuotaHeaders;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\CustomerAgents;
use App\Models\OM\Customers\Domestics\ProductTypeDomestic;
use App\Models\OM\Customers\Domestics\SalesChannel;
use App\Models\OM\Customers\Domestics\AccountMapping;
use App\Models\OM\Customers\Domestics\TransactionType;
use App\Models\OM\Customers\Domestics\Country;
use App\Models\OM\Customers\Domestics\CreditGroup;
use App\Models\OM\Customers\Domestics\TitleModel;
use App\Models\OM\Customers\Domestics\DayModel;
use App\Models\OM\Customers\Domestics\PaymentType;
use App\Models\OM\Customers\Domestics\AgentVendorModel;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers\Domestics\AgentVendors;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomesticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // GET CUSTOMER TYPE
        $customerType = typeDomestic::select('customer_type', 'meaning')->get();
        $paymentType = PaymentType::get();

        // ภูมิภาค
        $regionColumnes = ['region_id', 'region_thai'];
        $regionList = Territory::select($regionColumnes)
                            ->groupBy($regionColumnes)
                            ->orderBy('region_thai', 'asc')
                            ->get();

        // จังหวัด
        $provinceColumnes = ['province_id', 'province_thai'];
        $provinceList = Territory::select($provinceColumnes)
                            ->groupBy($provinceColumnes)
                            ->orderBy('province_thai', 'asc')
                            ->get();

        // อำเภอ
        $cityColumnes = ['city_code', 'city_thai', 'city_thai_short'];
        $cityList = Territory::select($cityColumnes)
                            ->groupBy($cityColumnes)
                            ->orderBy('city_thai', 'asc')
                            ->get();

        // GET SHIPMENT BY
        $shipmentBy = ShipmentBy::where('tag', 'D')->get();

        // GET PAYMENT METHOD
        $paymentMethod = PaymentMethod::get();

        // GET CUSTOMER
        $search = $request->all();

        // echo '<pre>';
        // print_r($search);
        // echo '</pre>';
        // exit();

        if (empty($search)) {
            $search = [
                'sales_classification_code' => 'Domestic'
            ];
        }

        $whereColumns = [
            'customer_type_id',
            'sales_classification_code',
            'city_code',
            'region_code',
            'province_code',
            'status'
        ];

        $likeColumns = [
            'customer_name',
            'customer_number',
            'customer_code_tm',
            'taxpayer_id',
            'tax_register_number',
            'address_line1',
            'alley',
            'payment_method_id',
            'shipment_by_id',
            'payment_type_id',
        ];

        if (!empty($request->all())) {
            $customers = Customer::search($search, $whereColumns, $likeColumns)->orderBy('CREATED_AT','DESC')->whereNull('deleted_at')->orderBy('customer_number', 'DESC')->get();

            foreach ($customers as $key => $value) {
                $customers[$key]->meaning = typeDomestic::where('customer_type', '=', $value->customer_type_id)->pluck('meaning')->first();
                $customers[$key]->province_thai = Territory::where('province_id', '=', $value->province_code)->pluck('province_thai')->first();
                $customers[$key]->created_name = DB::table('ptw_users')->where('user_id', '=', $value->created_by)->pluck('name')->first();
                $customers[$key]->updated_name = DB::table('ptw_users')->where('user_id', '=', $value->last_updated_by)->pluck('name')->first();
            }
        }else{
            $customers = [];
        }

        $compact_data = array(
            'customers',
            'customerType',
            'regionList',
            'provinceList',
            'cityList',
            'shipmentBy',
            'paymentMethod',
            'paymentType'
        );

        return view('om.customers.domestics.index', compact($compact_data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // GET PAYMENT METHOD วิธีการชำระเงิน
        $paymentMethod = PaymentMethod::get();

        // GET SHIPMENT BY วิธีการขนส่ง
        $shipmentBy = ShipmentBy::where('tag', 'D')->get();

        // GET SHIPMENT BY ประเภทออเดอร์
        $transactionType = TransactionType::where('sales_type', 'DOMESTIC')->get();

        $productTypeDomestic = ProductTypeDomestic::select('lookup_code', 'meaning')->get();

        $typeDomestic = typeDomestic::select('customer_type', 'meaning')->get();

        $salesChannel = SalesChannel::select('lookup_code', 'description', 'meaning')->get();

        $priceList = PriceList::select('price_list_id', 'list_header_id', 'name')
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                    ->where('active_flag', 'Y')
                                    ->where('attribute1', 'DOMESTIC')
                                    ->orderBy('name')->get();

        $dayList = DayModel::select('lookup_code', 'meaning')->get();

        // ภูมิภาค
        $regionColumnes = ['region_id', 'region_thai'];
        $regionList = Territory::select($regionColumnes)
                            ->groupBy($regionColumnes)
                            ->orderBy('region_thai', 'asc')
                            ->get();

        // จังหวัด
        $provinceColumnes = ['province_id', 'province_thai'];
        $provinceList = Territory::select($provinceColumnes)
                            ->groupBy($provinceColumnes)
                            ->orderBy('province_thai', 'asc')
                            ->get();

        $paymentType = PaymentType::get();

        $marketList = DB::table('ptom_market_list_v')
                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                    ->where('enabled_flag', 'Y')
                    ->orderBy('meaning','asc')->get();

        $nodeList = DB::table('ptom_node_headers')
                    ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                    ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                    ->orderBy('node_name','asc')->get();

        $data_compact = array(
            'paymentMethod',
            'shipmentBy',
            'transactionType',
            'productTypeDomestic',
            'salesChannel',
            'priceList',
            'regionList',
            'provinceList',
            'dayList',
            'typeDomestic',
            'paymentType',
            'marketList',
            'nodeList'
        );

        return view('om.customers.domestics.create', compact($data_compact));
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
        $customerType = typeDomestic::select('customer_type', 'meaning')->get();
        $productTypeDomestic = ProductTypeDomestic::select('lookup_code', 'meaning')->get();
        $salesChannel = SalesChannel::select('lookup_code', 'description', 'meaning')->get();
        $titlePrefix = TitleModel::select('lookup_code', 'title')->get();

        $country = Country::where('status', '=', 'Active')->get();

        $territory = Territory::get();
        foreach($territory as $items){

            // ตำบล
            $tambonList[$items->tambon_id] = [
                'tambon_id'         => $items->tambon_id,
                'tambon_thai'       => $items->tambon_thai,
                'tambon_thai_short' => $items->tambon_thai_short,
            ];
        }

        // ภูมิภาค
        $regionColumnes = ['region_id', 'region_thai'];
        $regionList = Territory::select($regionColumnes)
                            ->groupBy($regionColumnes)
                            ->orderBy('region_thai', 'asc')
                            ->get();

        // จังหวัด
        $provinceColumnes = ['province_id', 'province_thai'];
        $provinceList = Territory::select($provinceColumnes)
                            ->groupBy($provinceColumnes)
                            ->orderBy('province_thai', 'asc')
                            ->get();

        // อำเภอ
        $cityColumnes = ['city_code', 'city_thai', 'city_thai_short'];
        $cityList = Territory::select($cityColumnes)
                            ->groupBy($cityColumnes)
                            ->orderBy('city_thai', 'asc')
                            ->get();

        // ตำบล
        $tambonColumnes = ['tambon_id', 'tambon_thai', 'tambon_thai_short'];
        $districtList = Territory::select($tambonColumnes)
                            ->groupBy($tambonColumnes)
                            ->orderBy('tambon_thai', 'asc')
                            ->get();


        $priceList = PriceList::select('price_list_id', 'list_header_id', 'name')
                            ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                            ->where('active_flag', 'Y')
                            ->where('attribute1', 'DOMESTIC')
                            ->orderBy('name')->get();

        $dayList = DayModel::select('lookup_code', 'meaning')->get();

        // GET CONTRACT HEADER สัญญาค้ำประกันและวงเงินเชื่อ
        $customerContracts = CustomerContracts::where('customer_id', '=', $id)->whereNull('DELETED_AT')->orderBy('contract_id', 'asc')->get();

        if (!empty($customerContracts)) {
            foreach ($customerContracts as $key => $value) {

                $customerContracts[$key]->color_button      = '';
                if ($customerContracts[$key]->end_date != '') {
                    $strNow = new DateTime();
                    $dateEnd = new DateTime($customerContracts[$key]->end_date);
                    $dateEnd->setTime(23, 59, 59);
                    if ($strNow >= $dateEnd) {
                        $customerContracts[$key]->color_button = 'text-danger';
                    }
                }

                $customerContracts[$key]->guarantee_amount  =  number_format($value->guarantee_amount, 2);
                $customerContracts[$key]->start_date        = !empty($value->start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->start_date))) : $value->start_date;
                $customerContracts[$key]->end_date          = !empty($value->end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->end_date))) : $value->end_date;
            }
        }

        $customerContractBooks = CustomerContractBooks::where('customer_id', '=', $id)->whereNull('DELETED_AT')->get();
        if (!empty($customerContractBooks)) {
            foreach ($customerContractBooks as $key => $value) {

                $customerContractBooks[$key]->color_button      = '';
                if ($customerContractBooks[$key]->book_end_date != '') {
                    $strNow = new DateTime();
                    $dateEnd = new DateTime($customerContractBooks[$key]->book_end_date);
                    $dateEnd->setTime(23, 59, 59);
                    if ($strNow >= $dateEnd) {
                        $customerContractBooks[$key]->color_button = 'text-danger';
                    }
                }

                $customerContractBooks[$key]->credit_limit      =  number_format($value->credit_limit, 2);
                $customerContractBooks[$key]->book_start_date   = !empty($value->book_start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_start_date))) : $value->book_start_date;
                $customerContractBooks[$key]->book_end_date     = !empty($value->book_end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_end_date))) : $value->book_end_date;
            }
        }

        $contractGroupCount = 0;
        $customerContractGroups = CustomerContractGroups::where('customer_id', '=', $id)->whereNull('DELETED_AT')->get();
        if (!empty($customerContractGroups)) {
            foreach ($customerContractGroups as $key => $value) {
                $contractGroupCount = $contractGroupCount + $value->credit_amount;
                $customerContractGroups[$key]->credit_amount =  number_format($value->credit_amount,2);
            }
        }
        $contractGroupCount = number_format($contractGroupCount,2);
        $creditGroup = CreditGroup::orderBy('lookup_code', 'ASC')->get();

        // GET CUSTOMER QUOTA HEADER โควต้าสั่งซื้อ
        $customerQuotaHeaders = CustomerQuotaHeaders::where('customer_id', '=', $id)->whereNull('DELETED_AT')->orderBy('start_date', 'desc')->get();

        if (!empty($customerQuotaHeaders)) {
            foreach ($customerQuotaHeaders as $key => $value) {
                $customerQuotaHeaders[$key]->start_date = !empty($value->start_date) ? dateFormatThaiString($value->start_date) : '';
                $customerQuotaHeaders[$key]->end_date = !empty($value->end_date) ? dateFormatThaiString($value->end_date) : '';
            }
        }

        // GET CUSTOMER SHIP SITES สถานที่จัดส่ง
        $customerShipSites = CustomerShipSites::where('customer_id', '=', $id)->whereNull('DELETED_AT')->orderBy('site_no', 'asc')->get();

        // GET CUSTOMER AGENTS นายหน้า
        $customerAgents = CustomerAgents::where('customer_id', '=', $id)->whereNull('DELETED_AT')->first();

        if (!empty($customerAgents)) {
            $accountMapping = AccountMapping::where('account_id', '=', $customerAgents->account_id)->first();
            $agentVendor    = AgentVendors::where('vendor_id', $customerAgents->agent_code)->first();
        }else{
            $accountMapping = [];
            $agentVendor    = [];
        }



        // GET PAYMENT METHOD วิธีการชำระเงิน
        $paymentMethod = PaymentMethod::get();

        // GET SHIPMENT BY วิธีการขนส่ง
        $shipmentBy = ShipmentBy::where('tag', 'D')->get();

        // GET SHIPMENT BY ประเภทออเดอร์
        $transactionType = TransactionType::where('sales_type', 'DOMESTIC')->get();

        $customers = Customer::where('customer_id', '=', $id)->first();

        // echo '<pre>';
        // echo print_r($accountMapping);
        // echo '</pre>';
        // exit();

        if (empty($customers)) {
            echo 'Empty Data';
            exit();
        }

        $customers->meaning = typeDomestic::where('customer_type', '=', $customers->customer_type_id)->pluck('meaning')->first();
        $customers->province_thai = Territory::where('province_id', '=', $customers->province_code)->pluck('province_thai')->first();

        if (is_numeric($customers->region_code)) {
            $customers->region_thai = Territory::where('region_id', '=', $customers->region_code)->pluck('region_thai')->first();
        }else{
            $customers->region_thai = Territory::where('region_thai', '=', $customers->region_code)->pluck('region_thai')->first();
        }

        $customers->test_date = !empty($customers->test_date) ? dateFormatDMY(date('m/d/Y',strtotime($customers->test_date))) : $customers->test_date;
        $customers->begin_date = !empty($customers->begin_date) ? dateFormatDMY(date('m/d/Y',strtotime($customers->begin_date))) : $customers->begin_date;
        $customers->accepted_date = !empty($customers->accepted_date) ? dateFormatDMY(date('m/d/Y',strtotime($customers->accepted_date))) : $customers->accepted_date;
        $customers->book_date = !empty($customers->book_date) ? dateFormatDMY(date('m/d/Y',strtotime($customers->book_date))) : $customers->book_date;
        $customers->cancelled_date = !empty($customers->cancelled_date) ? dateFormatDMY(date('m/d/Y',strtotime($customers->cancelled_date))) : $customers->cancelled_date;

        $customers->credit_limit = !empty($customers->credit_limit) ? number_format((float)$customers->credit_limit, 2, '.', '') : '0.00';
        $customers->capital = !empty($customers->capital) ? number_format((float)$customers->capital, 2, '.', '') : '0.00';

        $customersPrevious = CustomerPrevious::where('customer_id', '=', $id)->whereNull('DELETED_AT')->orderBy('previous_no', 'asc')->get();

        // echo '<pre>';
        // echo print_r($customers);
        // echo '</pre>';
        // exit();

        if (!empty($customersPrevious)) {
            foreach ($customersPrevious as $key => $value) {
                $customersPrevious[$key]->start_change_date = !empty($value->start_change_date) ? dateFormatThaiString($value->start_change_date) : '';
                $customersPrevious[$key]->end_change_date = !empty($value->end_change_date) ? dateFormatThaiString($value->end_change_date) : '';
                $customersPrevious[$key]->cancel_date = !empty($value->cancel_date) ? dateFormatThaiString($value->cancel_date) : '';
            }
        }

        $customersOwners = CustomerOwners::where('customer_id', '=', $id)->whereNull('DELETED_AT')->orderBy('owner_no', 'asc')->get();

        $typeDomestic = typeDomestic::select('customer_type', 'meaning')->get();

        $paymentType = PaymentType::get();

        $sequenceEcoms = SequenceEcom::where('sale_type_code', 'DOMESTIC')
                                    ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                    ->whereNull('deleted_at')
                                    ->orderBy('sequence_ecom_id','asc')->get();

        $marketList = DB::table('ptom_market_list_v')
                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                    ->where('enabled_flag', 'Y')
                    ->orderBy('meaning','asc')->get();

        $nodeList = DB::table('ptom_node_headers')
                    ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                    ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                    ->orderBy('node_name','asc')->get();

        // echo '<pre>';
        // echo print_r($customerContracts);
        // echo '</pre>';
        // exit();

        $data_compact = array(
            'customerType',
            'productTypeDomestic',
            'salesChannel',
            'customers',
            'customersPrevious',
            'customersOwners',
            'customerContracts',
            'customerContractBooks',
            'customerContractGroups',
            'customerQuotaHeaders',
            'customerShipSites',
            'customerAgents',
            'accountMapping',
            'agentVendor',
            'paymentMethod',
            'shipmentBy',
            'transactionType',
            'country',
            'regionList',
            'provinceList',
            'districtList',
            'tambonList',
            'creditGroup',
            'contractGroupCount',
            'titlePrefix',
            'priceList',
            'typeDomestic',
            'paymentType',
            'sequenceEcoms',
            'dayList',
            'marketList',
            'nodeList'

        );

        return view('om.customers.domestics.show', compact($data_compact));
    }

    public function Broker()
    {
        if(!canEnter('/om/customers/domestics/broker') || !canView('/om/customers/domestics/broker')){
            return \redirect()->back()->withError(trans('403'));
        }
        $agentvendor = AgentVendorModel::get();

        $taxaccount = TaxAccountModel::where('active_flag','Y')
                                        ->where('start_date','<=',date('Y-m-d'))
                                        ->where(function($query){
                                            $query->where('end_date','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date');
                                        })
                                        ->get();
        return view('om.customers.domestics.broker',compact('taxaccount','agentvendor'));
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
