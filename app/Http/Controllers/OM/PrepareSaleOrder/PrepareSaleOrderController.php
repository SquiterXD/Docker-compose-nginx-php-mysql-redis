<?php

namespace App\Http\Controllers\OM\PrepareSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

use App\Models\OM\PrepareSaleOrder\CustomerModel;
use App\Models\OM\PrepareSaleOrder\SaleChannelModel;
use App\Models\OM\PrepareSaleOrder\RequestorModel;
use App\Models\OM\PrepareSaleOrder\ShipmentModel;
use App\Models\OM\PrepareSaleOrder\TransactionTypeModel;
use App\Models\OM\PrepareSaleOrder\PriceListHeadModel;
use App\Models\OM\PrepareSaleOrder\PrepareSaleOrderModel;
use App\Models\OM\PrepareSaleOrder\PeriodModel;
use App\Models\OM\PrepareSaleOrder\ShipSiteCustomerModel;
use App\Models\OM\PrepareSaleOrder\OrderLineModel;
use App\Models\OM\PrepareSaleOrder\OrderLotModel;
use App\Models\OM\PrepareSaleOrder\QuotaHeaderModel;
use App\Models\OM\PrepareSaleOrder\ItemWeightModel;
use App\Models\OM\PrepareSaleOrder\OnhandModel;
use App\Models\OM\PrepareSaleOrder\CustomerTyprModel;
use App\Models\OM\PrepareSaleOrder\CustomerShipSiteModel;
use App\Models\OM\PrepareSaleOrder\PtwUserModel;
use Illuminate\Support\Facades\DB;

class PrepareSaleOrderController extends Controller
{
    public function index($number = '')
    {
        $customer       = CustomerModel::with('Province')->ActiveDomestic()->where('customer_type_id',80)->orderBy('customer_number')->get(); //ลูกค้า
        $salechannel    = SaleChannelModel::where('enabled_flag','Y') //สั่งทา่ง
                                        ->where('start_date_active','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date_active');
                                        })
                                        ->orderBy('lookup_code')->get();
        $shipment       = ShipmentModel::where('tag','D') //ส่งโดย
                                        ->where('enabled_flag','Y')
                                        ->where('start_date_active','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date_active');
                                        })
                                        ->orderBy('lookup_code')->get();
        $requestor      = RequestorModel::where('enabled_flag','Y') //ผู้ร้องขอ
                                        ->where('start_date_active','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date_active');
                                        })
                                        ->orderBy('lookup_code')->get();
        $transaction    = TransactionTypeModel::where('sales_type','DOMESTIC') // order type
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->where(function ($query) {
                                                    $query->where('end_date_active','>=',date('Y-m-d'));
                                                    $query->orWhereNull('end_date_active');
                                                })
                                                ->orderBy('order_type_id')->get();
        $pricelist      = PriceListHeadModel::where('active_flag','Y') // ราคาขาย
                                                ->where('start_date_active','<=',date('Y-m-d'))
                                                ->where('attribute1','DOMESTIC')
                                                ->where(function ($query) {
                                                    $query->where('end_date_active','>=',date('Y-m-d'));
                                                    $query->orWhereNull('end_date_active');
                                                })
                                                ->orderBy('list_header_id')->get();
        $attachmentFile = [];
        $program_code = 'OMP0020';

        return view('om/preparesaleorder/index',\compact(   'customer',
                                                            'salechannel',
                                                            'shipment',
                                                            'requestor',
                                                            'transaction',
                                                            'pricelist',
                                                            'attachmentFile',
                                                            'program_code',
                                                            'number' ));
    }

    public function printReport(Request $request)
    {
        // dd($request->all());
        $order      = PrepareSaleOrderModel::where('order_header_id',$request->order)->first();
        $order_line = OrderLineModel::where('order_header_id',$request->order)->get();
        $customer   = CustomerModel::where('customer_id',$order->customer_id)->first();
        $saletype   = SaleChannelModel::where('lookup_code',$order->source_system)->first();
        $shipping   = ShipmentModel::where('lookup_code',$order->transport_type_code)->first();
        $custype    = CustomerTyprModel::where('customer_type', $customer->customer_type_id)->first();
        $period     = PeriodModel::where('period_line_id', $order->period_id)->first();
        $shipsite   = CustomerShipSiteModel::where('customer_id',$order->customer_id)->where('status','Active')->orderBy('site_no','asc')->first();
        $user       = PtwUserModel::where('user_id',$order->created_by)->first();
        $customerTypeDomestic = DB::table('ptom_customer_type_domestic')->where('customer_type',$customer->customer_type_id)->first();

        $order_total    = 0;
        $approve_total  = 0;

        foreach($order_line as $item_line){
            $last =   PrepareSaleOrderModel::join('ptom_order_lines','ptom_order_lines.order_header_id','=','ptom_order_headers.order_header_id')
                                            ->where('ptom_order_lines.item_code',$item_line->item_code)
                                            ->where('ptom_order_headers.order_header_id','!=',$request->order)
                                            ->where('ptom_order_headers.pick_release_status','Confirm')
                                            ->where('ptom_order_headers.customer_id',$customer->customer_id)
                                            ->orderBy('ptom_order_headers.delivery_date','desc')
                                            ->first();
                                            
            $item_line->lastOrderDate       = !empty($last->order_date)? dateThaiNumberSlad($last->order_date) : '';
            $item_line->lastOrderQuantity   = !empty($last->order_quantity)? $last->order_quantity :'';
            $item_line->lastOrderApprove    = !empty($last->approve_quantity)? $last->approve_quantity : '';

            $order_total    += $item_line->order_quantity;
            $approve_total  += $item_line->approve_quantity;
        }

        $order->saleType      = $saletype->description;                     //รายการสั่งทาง
        $order->shipType      = $shipping->description;                     //จัดส่งบุหรี่โดย
        $order->deliDate      = dateThaiNumberSlad($order->delivery_date);  //วันที่ส่ง
        $order->prepareDate   = dateThaiNumberSlad($order->order_date);     //วันที่สั่งซื้อ
        $order->dateName      = dayEngtoThaiName(date('l',strtotime($order->delivery_date))); //วันที่ส่ง
        $order->custoType     = $custype->description;                      //ประเภทลูกค้า
        $order->periodData    = $period->period_no;                         //งวดที่
        $order->custoShip     = $shipsite->ship_to_site_name;               //ส่งที่
        $order->orderTotal    = $order_total;
        $order->approveTotal  = $approve_total;

        $requestor            = RequestorModel::where('lookup_code', $order->requestor_code)->first();

        $order->requestor     = $requestor ? $requestor->description : '';
        
        // return view('om.preparesaleorder.report',compact('order','customer','order_line','user'));
        $pdf = PDF::loadView('om.preparesaleorder.report', compact('order','customer','order_line','user', 'customerTypeDomestic'));

        $pdf->setOption('margin-left','0')
            ->setOption('margin-right','0')
            ->setOption('margin-top','0')
            ->setOption('margin-bottom','0')
            ->setPaper('a4')
            ->setOrientation('landscape');

        return $pdf->stream('print.pdf');
    }
}
