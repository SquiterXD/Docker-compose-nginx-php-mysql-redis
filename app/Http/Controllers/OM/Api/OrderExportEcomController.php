<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderDirectDebit;
use App\Models\OM\Api\OrderCreditGroup;
use App\Repositories\OM\OrderRepo;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\CreditAndQuotaRepo;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderExportEcomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function genNumber()
    {
        $data = GenerateNumberRepo::getByTypeCustomer(1);
        dd($data);
    }
    public function customerExport()
    {
        $customerExport = DB::table('ptom_customers')
        ->whereRaw("lower(sales_classification_code) = 'export' ")
        ->whereRaw("lower(status) = 'active' ")
        ->where('deleted_at',NULL)
        ->orderBy('customer_number','ASC')
        ->get(['customer_id','customer_name','customer_number']);
        return response()->json(['data' => $customerExport]);
    }


    public function orderDataCustomer($customer_id)
    {
        $data['customer'] = Customer::where('customer_id',$customer_id)->first();

        $data['paymentType'] = DB::table('ptom_payment_type')->get(['lookup_code','meaning','description']);

        $data['paymentMethodExport'] = DB::table('ptom_payment_method_export')->get(['lookup_code','meaning','description','tag']);

        $data['shipmentBy'] = DB::table('ptom_shipment_by')->where('tag','E')->get(['lookup_code','meaning','description','tag']);

        $productTypeExport = DB::table('ptom_product_type_export')->get(['lookup_code','meaning','description']);

        $data['productTypeExport'] = [];
        foreach ($productTypeExport as $key => $v) {

            $priceList = DB::table('ptom_price_list_head_v as plh')
            ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
            ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
            ->where('plh.list_header_id',$data['customer']->price_list_id)
            ->where('se.product_type_code',$v->lookup_code)
            ->first();

            if(!is_null($priceList)){
                $data['productTypeExport'][] = $v;
            }

        }

        $data['dataTest'] = 'dataTest';

        return response()->json(['data' => $data]);
    }

    public function productTypeExport()
    {
        $productTypeExport = DB::table('ptom_product_type_export')->get(['lookup_code','meaning','description']);
        return response()->json(['data' => $productTypeExport]);
    }

    public function uomConvert()
    {
        $uomConvert = DB::table('ptom_uom_conversions_v')->get(['uom_code','conversion_rate','unit_of_measure']);
        return response()->json(['data' => $uomConvert]);
    }

    public function paymentType()
    {
        $paymentType = DB::table('ptom_payment_type')->get(['lookup_code','meaning','description']);
        return response()->json(['data' => $paymentType]);
    }

    public function paymentMethodExport()
    {
        $paymentMethodExport = DB::table('ptom_payment_method_export')->get(['lookup_code','meaning','description','tag']);

        return response()->json(['data' => $paymentMethodExport]);
    }

    // public function directDebitExport($customer_id)
    // {
    //     $directDebitExport = DB::table('ptom_direct_debit')->get(['lookup_code','meaning','description']);

    //     return response()->json(['data' => $directDebitExport]);
    // }

    public function shipmentByExport()
    {
        $shipmentBy = DB::table('ptom_shipment_by')->where('tag','E')->get(['lookup_code','meaning','description','tag']);
        return response()->json(['data' => $shipmentBy]);
    }

    public function orderPurchaseByNumber($number)
    {
        $response = [];

        $response['order'] = OrderHeader::where('order_header_id',$number)->first();

        try {
            $response['orderLine'] = [];
            $orderLine = OrderLines::where('order_header_id',$response['order']->order_header_id)->whereNull('promo_flag')->get();
            foreach ($orderLine as $key => $item) {
                $response['orderLine'][$item->item_id] = $item;
            }
        } catch (\Exception $e) {
            $response['orderLine'] = [];
        }
        $response['order'] = OrderHeader::where('order_header_id',$number)->first();

        $customer_id = $response['order']->customer_id;
        $response['customer'] = Customer::byCustomerId($customer_id);

        $response['productTypeExport'] = DB::table('ptom_product_type_export')->get(['lookup_code','meaning','description']);

        $response['productType'] = OrderRepo::getProcutTypeDomesticLookup($response['order']->product_type_code);
        $response['paymentType'] = OrderRepo::getPaymentTypeLookup($response['order']->payment_type_code);
        $response['paymentMethod'] = OrderRepo::getPaymentMethodExportLookup($response['order']->payment_method_code);
        $response['shipmentBy'] = OrderRepo::getShipmentLookup($response['order']->transport_type_code);
        $response['shipSites'] = OrderRepo::shipSites($customer_id);

        $response['paymentTerm'] = OrderRepo::getPaymentTerm($response['customer']->payment_term_id);
        $response['headerPrice'] = OrderRepo::getHeaderPrice($response['customer']->price_list_id);

        $response['vatCode'] = null;
        if(!is_null($response['customer']->vat_code)){
            $response['vatCode'] = OrderRepo::getVatCode($response['customer']->vat_code);
        }

        $response['productList'] = OrderRepo::getProductListExportTypeCode($customer_id,$response['order']);
        $response['lastOrdersStatus'] = OrderRepo::lastOrdersStatus($response['order']->order_header_id)->order_status;
        // $response['uomConvert'] = OrderRepo::uomConvert();

        return response()->json(['data' => $response]);
    }

    public function store(Request $request)
    {
        $orderHeader = new OrderHeader();

        DB::beginTransaction();
        try {
            $customer = Customer::where('customer_id',$request->customer_id)->first();


            $shipSite = DB::table('ptom_customer_ship_sites')
            ->where('customer_id',$request->customer_id)
            ->whereRaw("lower(status) = 'active'")->first();

            // $getLastNum = OrderHeader::getLastOrderNumber();

            // $orderNumber = runOrderNumber($getLastNum);

            // $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0062_PO_NUM_EXP','order_number');

            $product_type = DB::table('ptom_product_type_export')
            ->where('lookup_code',$request->product_type_code)->first();

            $order_type = DB::table('ptom_transaction_types_v')
            ->where('sales_type','EXPORT')
            ->where('product_type',$product_type->description)->get();
            $orgId = DB::table('hr_organization_units_v')->select('organization_id')->where('name', 'การยาสูบแห่งประเทศไทย')->pluck('organization_id')->first();
            $defaultOrderType = $order_type->where('order_type_id', $customer->order_type_id )->first();
            if(!empty($defaultOrderType)) {
                $defaultOrderType = $defaultOrderType->order_type_id;
            } else {
                $defaultOrderType = $order_type->sortBy('order_type_id')->first()->order_type_id;
            }
            $orderHeader->org_id = !empty($orgId) ? $orgId : '';
            // $orderHeader->order_number = $orderNumber;
            $orderHeader->order_type_id = $defaultOrderType; 
            $orderHeader->customer_id = $request->customer_id;
            $orderHeader->bill_to_site_id = $request->customer_id;
            $orderHeader->ship_to_site_id = $shipSite->ship_to_site_id;
            $orderHeader->currency = 'THB';
            $orderHeader->source_system = 'E-Commerce';
            $orderHeader->product_type_code = $request->product_type_code;
            $orderHeader->period_id = 0;
            $orderHeader->installment_type_code = 0;
            if (isset($request->payment_direct_debit_code) && !empty($request->payment_direct_debit_code)) {
                $orderHeader->payment_direct_debit_code = $request->payment_direct_debit_code;
            }else{
                $orderHeader->payment_direct_debit_code = 0;
            }
            $orderHeader->order_source = $request->order_source;
            $orderHeader->cust_po_number = $request->cust_po_number;
            $orderHeader->payment_type_code = $request->payment_type_code;
            $orderHeader->payment_method_code = $request->payment_method_code;

            $orderHeader->transport_type_code = $request->transport_type_code;
            $orderHeader->order_date = $request->order_date;

            $orderHeader->order_status = '';
            $orderHeader->program_code = 'OMP0062';
            $orderHeader->created_by = 1;
            $orderHeader->last_updated_by = 1;

            $orderHeader->save();

            $response['order_number'] = $orderHeader->getKey();

            $orderHeaderData = OrderHeader::where('order_header_id',$orderHeader->getKey())->first();

            OrderRepo::insertOrdersHistoryv2($orderHeaderData,'Draft');

            DB::commit();

            return response()->json(['status'=>true,'data' => $response,'message'=>'']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }

    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->first();

            $response = [];

            if(is_null($orderHeader->order_number)){
                $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0062_PO_NUM_EXP','order_number');
                $orderHeader->order_number = $orderNumber;
            }

            $response['order_number'] = $orderHeader->order_number;

            $orderHeader->cust_po_number = $request->cust_po_number;
            $orderHeader->transport_detail = $request->shipment_other;
            $orderHeader->currency = $request->currency_code;
            $orderHeader->tax = $request->tax;
            $orderHeader->sub_total = $request->total_sum;
            $orderHeader->order_date = date('Y-m-d H:i:s', strtotime($request->order_date));

            $orderHeader->ship_to_site_id = $request->ship_to_site_id;

            if($request->status == 'Confirm'){
                $order_status = 'Release';
                $orderHeader->order_status = 'Draft';
            }else{
                $order_status = 'Draft';
                // $orderHeader->order_status = 'Draft';
            }

            $tax_amount = 0;

            $orderHeader->grand_total = $request->grand_total;
            $orderHeader->remark = $request->remark;

            $customer_id = $orderHeader->customer_id;


            $checked_product = $request->checked_product;

            $productList = OrderRepo::getProductListExportTypeCode($customer_id,$orderHeader);
            $vat_code = '';
            foreach($productList as $item){

                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_id',$item->item_id)->first();

                if(in_array($item->item_id,$checked_product)){

                    if (!isset($orderLine) || empty($orderLine)) {
                        $orderLine = new OrderLines();
                    }

                    $orderLine->line_number = 0;
                    $orderLine->order_header_id = $orderHeader->order_header_id;
                    $orderLine->item_id = $item->item_id;
                    $orderLine->item_code = $item->item_code;
                    $orderLine->item_description = $item->item_description;
                    $orderLine->unit_price = $item->price_unit;
                    $orderLine->uom_code = $request->items['uom_code'][$item->item_id];
                    $orderLine->uom = $request->items['uom'][$item->item_id];
                    $orderLine->order_quantity = $request->items['amount'][$item->item_id];

                    if (isset($request->promotion) && isset($request->promotion[$item->item_id])) {
                        $promotion = explode('_',$request->promotion[$item->item_id]);
                        $orderLine->promotion_id = $promotion[1];
                        $orderLine->promotion_product_id = $promotion[2];
                    }

                    $total_amount = $request->items['sum_amount'][$item->item_id];

                    $orderLine->diff_quantity = 0;
                    $orderLine->amount = $request->items['sum_amount'][$item->item_id];
                    $orderLine->total_amount = $request->items['sum_amount'][$item->item_id];

                    $calTax = OrderRepo::calTaxExport($orderLine->order_quantity,$orderLine->unit_price,$orderHeader->order_type_id,$orderHeader->customer_id);
                    $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                    $orderLine->vat_code = $calTax['vat_code'];
                    $vat_code = $calTax['vat_code'];
                    $tax_amount += $calTax['amount'];

                    $orderLine->program_code = 'OMP0062';
                    $orderLine->created_by = 1;
                    $orderLine->last_updated_by = 1;

                    $orderLine->save();

                    if ($request->status == 'Confirm') {

                        OrderRepo::amountCreditGroupCash(
                            $orderHeader->order_header_id,
                            $orderLine->getKey(),
                            $total_amount,
                            'OMP0003'
                        );
                    }

                }else{
                    if (isset($orderLine) && !empty($orderLine)) {
                        $orderLine->delete();
                    }
                }
            }

            $orderHeader->vat_code = $vat_code;
            // $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
            // $orderHeader->sub_total = $request->grand_total - number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->sub_total = $request->grand_total - $request->tax;
            $orderHeader->save();

            $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();

            CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,$request->grand_total,'OMP0062');

            OrderRepo::insertOrdersHistoryv2($orderHeader,$order_status);

            // $orderDirectDebit = OrderDirectDebit::where('order_header_id',$orderHeader->order_header_id)->first();

            // if (!isset($orderDirectDebit) || empty($orderDirectDebit)) {
            //     $orderDirectDebit = new OrderDirectDebit();

            //     $orderDirectDebit->order_line_id = 0;
            //     $orderDirectDebit->credit_group_code = 0;
            //     $orderDirectDebit->created_by = 1;
            //     $orderDirectDebit->last_updated_by = 1;
            //     $orderDirectDebit->program_code = 'OMP0062';
            // }

            // $orderDirectDebit->order_header_id = $orderHeader->order_header_id;
            // $orderDirectDebit->direct_debit_id = $orderHeader->payment_direct_debit_code;
            // $orderDirectDebit->direct_debit_amount = $orderHeader->grand_total;
            // $orderDirectDebit->save();

            DB::commit();

            return response()->json(['status'=>true,'data' =>$response,'message'=>'']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }

    public function cancel(Request $request)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->first();
            $orderHeader->order_status = 'Cancelled';
            $orderHeader->last_updated_by = 1;
            $orderHeader->last_update_date = now();
            $orderHeader->save();

            OrderRepo::insertOrdersHistoryv2($orderHeader,'Cancelled');

            DB::commit();


            return response()->json(['status'=>true,'data' =>[],'message'=>'']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }

}
