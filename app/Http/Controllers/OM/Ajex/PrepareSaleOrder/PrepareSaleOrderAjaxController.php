<?php

namespace App\Http\Controllers\OM\Ajex\PrepareSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\OM\PrepareSaleOrder\CustomerModel;
use App\Models\OM\PrepareSaleOrder\PrepareSaleOrderModel;
use App\Models\OM\PrepareSaleOrder\PriceListHeadModel;
use App\Models\OM\PrepareSaleOrder\PeriodModel;
use App\Models\OM\PrepareSaleOrder\ShipSiteCustomerModel;
use App\Models\OM\PrepareSaleOrder\OrderLineModel;
use App\Models\OM\PrepareSaleOrder\OrderLotModel;
use App\Models\OM\PrepareSaleOrder\QuotaHeaderModel;
use App\Models\OM\PrepareSaleOrder\ItemWeightModel;
use App\Models\OM\PrepareSaleOrder\OnhandModel;
use App\Models\OM\PrepareSaleOrder\TransactionTypeModel;
use App\Models\OM\PrepareSaleOrder\RequestorModel;
use App\Models\OM\PrepareSaleOrder\OperationUnitsModel;
use App\Models\OM\PrepareSaleOrder\UomListModel;
use App\Models\OM\PrepareSaleOrder\UomConversionModel;

use App\Repositories\OM\AttachmentRepo;
use App\Models\OM\AttachFiles;
use Illuminate\Support\Facades\DB;

use App\Repositories\OM\OrderRepo;
use App\Repositories\OM\GenerateNumberRepo;

class PrepareSaleOrderAjaxController extends Controller
{
    public function genPoNumber(Request $request)
    {

        // $year = date('Y') + 543;
        // $year_thai = \substr($year,'-2');
        // $order = PrepareSaleOrderModel::where('prepare_order_number','like', $year_thai.'O%')->orderBy('prepare_order_number','desc')->first();
        // if($order->count() > 0){
        //     $last_nummber = \explode('O',$order->prepare_order_number);
        //     if(is_numeric($last_nummber[1])){
        //         $newnumber = sprintf('%05d', $last_nummber[1]+1);
        //     }else{
        //         $newnumber = sprintf('%05d', 1);
        //     }
        //     $new_preparenumber = $year_thai.'O'.$newnumber;
        // }else{
        //     $new_preparenumber =  $year_thai.'O00001';
        // }

        // $result = GenerateNumberRepo::getOrderNumberPrepareSaleOrder();
        // $result['sequence_number'] = 'test';
        // $result['status'] = 'S';
        $order_year = date('Y') + 543;
        $order_date = date('d/m').'/'.$order_year;

        $rest = [
            'status'    => true,
            'data'      => ''/*$result['sequence_number']*/,
            'date'      => $order_date,
            // 'result'    => $result
        ];

        return response()->json(['data' => $rest]);
    }

    public function getUomList()
    {
        $list = UomListModel::leftJoin('ptom_uom_conversions_v','ptom_uom_conversions_v.uom_code','=','ptom_uom_v.uom_code')
                                ->where('ptom_uom_v.uom_class','ทั่วไป')
                                ->where('ptom_uom_v.domestic','Y')
                                ->get();
        $rest = [
            'status'    => true,
            'data'      => $list,
        ];

        return response()->json(['data' => $rest]);
    }

    public function getOrderList(Request $request)
    {
        // $year = date('Y') + 543;
        // $year_thai = \substr($year,'-2');
        
        $order = PrepareSaleOrderModel::whereNotNull('ptom_order_headers.prepare_order_number')
                                        ->join('ptom_customers','ptom_customers.customer_id','=','ptom_order_headers.customer_id')
                                        // ->where('ptom_order_headers.prepare_order_number','like', $year_thai.'O%')
                                        ->where('ptom_customers.customer_type_id',80)
                                        ->where('ptom_order_headers.program_code','OMP0020')
                                        ->where(function($query) use ($request){
                                            if(!empty($request->customer_id)){
                                                $query->where('ptom_order_headers.customer_id',$request->customer_id);
                                            }
                                        })
                                        ->orderBy('ptom_order_headers.order_date','desc')
                                        ->get();
        $datalist = [];
        foreach($order as $list_item){
            $date_nt    = \explode(' ',$list_item->order_date);
            $date_n     = \explode('-',$date_nt[0]);
            $year       = $date_n[0] + 543;
            $date       = $date_n[2].'/'.$date_n[1].'/'.$year;

            $datalist[] = [
                'prepare_order_number'      => $list_item->prepare_order_number,
                'order_date'                => $date,
                'customer_name'             => $list_item->customer_name
            ];
        }

        $rest = [
            'status'    => true,
            'data'      => $datalist
        ];

        return response()->json(['data' => $rest]);
    }

    public function getShipSite(Request $request)
    {
        $site = ShipSiteCustomerModel::where('customer_id',$request->id)->where('status','Active')->whereNull('deleted_at')->orderBy('site_no')->get();

        if($site->count() > 0){
            $rest = [
                'status'    => true,
                'data'      => $site,
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'ไม่พบข้อมูล',
            ];
        }
        return response()->json(['data' => $rest]);
    }

    public function getDelivary(Request $request)
    {
        $customer   = CustomerModel::where('customer_id',$request->id)->first();
        // $date       = compareDaysTH($customer->delivery_date);
        // $day        = nextDaysOfWeek($date);

        // $exday      = \explode('-',$day);
        // $yearth     = $exday[0]+543;
        // $dayth      = $exday[2].'/'.$exday[1].'/'.$yearth;

        $order_year = date('Y') + 543;
        $order_date = date('d/m').'/'.$order_year;

        $rest   = [
            'status'    => true,
            'data'      => [
                'date'          => $order_date,
                // 'day'           => $day,
                'order_type'    => $customer->order_type_id,
                'price_list'    => $customer->price_list_id
            ],
        ];

        return response()->json(['data' => $rest]);
    }

    public function SaveDraft(Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'prepare_number_data'       => 'required|string',
            'order_status'              => 'required|string',
            'customer_id'               => 'required|string',
            'province_name'             => 'required|string',
            'order_by'                  => 'required|string',
            'request_by'                => 'required|string',
            'shipment_by'               => 'required|string',
            'order_date'                => 'required|string',
            'delivary_date'             => 'required|string',
            'transaction_id'            => 'required|string',
            'price_list'                => 'required|string',
            'ship_to_site'              => 'required|string',
            'remark_list'               => 'required|string',
        ],[
            'order_status.required'     => 'กรุณากรอกสถานะ',
            'customer_id.required'      => 'กรณาเลือกรหัสลูกค้า',
            'province_name.required'    => 'กรณาเลือกรหัสลูกค้า',
            'order_by.required'         => 'กรณาเลือกสั่งทาง',
            'request_by.required'       => 'กรณาเลือกผู้ร้องขอ',
            'shipment_by.required'      => 'กรณาเลือกส่งโดย',
            'order_date.required'       => 'กรณาเลือกวันที่สั่ง',
            'delivary_date.required'    => 'กรณาเลือกวันที่ส่ง',
            'transaction_id.required'   => 'กรณาเลือกประเภทการขาย',
            'price_list.required'       => 'กรณาเลือกราคาขาย',
            'ship_to_site.required'     => 'กรณาเลือกสถานที่จัดส่งสินค้า',
            'remark_list.required'      => 'กรณากรอกหมายเหตุรายการ',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data' => $rest]);
        }else{
            DB::beginTransaction();
            try {
                $header_id      = '';
                $header_status  = '';
                $line_id        = [];
                $lot_id         = [];

                $order_date = \explode('/',$request->order_date);
                $year_order = $order_date[2] - 543;
                $new_order_date = $year_order.'-'.$order_date[1].'-'.$order_date[0];

                $delivary_date = \explode('/',$request->delivary_date);
                $year_delivary = $delivary_date[2] - 543;
                $new_delivary_date = $year_delivary.'-'.$delivary_date[1].'-'.$delivary_date[0];

                $customer   = CustomerModel::where('customer_id',$request->customer_id)->first();
                $transact   = TransactionTypeModel::where('order_type_id',$request->transaction_id)->first();
                if($transact){
                    $tax = $transact->tax_rate;
                }else{
                    $tax = 0;
                }
                $period     = PeriodModel::whereDate('start_buget_year','<=',$new_order_date)
                                            ->where(function($query) use ($new_order_date){
                                                $query->whereDate('end_period','>=',$new_order_date);
                                                $query->orwhereDate('end_period','>=',$new_order_date);
                                            })
                                            ->first();

                if(empty($request->order_id)){
                    $org                                    = OperationUnitsModel::where('short_code','TOAT')->first();
                    if($org){
                        $org_id = $org->organization_id;
                    }else{
                        $org_id = '81';
                    }
                    if ( $request->product_type_code == 10) {
                        $result = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM','prepare_order_number');
                    }else if( $request->product_type_code == 20){
                        $result = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_L_DOM','prepare_order_number');
                    }else{
                        $result = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_O_DOM','prepare_order_number');
                    }
                    $prepareorder                           = new PrepareSaleOrderModel;
                    $prepareorder->org_id                   = $org_id;
                    $prepareorder->prepare_order_number     = $result;               //เลขที่ใบเตรียมขาย
                    $prepareorder->customer_id              = $request->customer_id;                    //ลูกค้า
                    $prepareorder->payment_type_code        = $customer->payment_type_id;               //ประเภทการชำระ
                    $prepareorder->product_type_code        = $request->product_type_code;             //ประเภทบุหรา
                    $prepareorder->payment_method_code      = $customer->payment_method_id;             //เงื่อนไงการชำระ
                    $prepareorder->period_id                = $period->period_line_id;                  //งวดที่สั้งซื้อ
                    $prepareorder->bill_to_site_id          = $customer->bill_to_site_id;               //ที่ส่งใบเสร็จ
                    $prepareorder->ship_to_site_id          = $request->ship_to_site;                   //ที่อยู่จัดส่ง
                    $prepareorder->currency                 = $customer->currency;                      //สกุลเงิน
                    $prepareorder->source_system            = $request->order_by;                       //สั่งทาง
                    $prepareorder->requestor_code           = $request->request_by;                     //ผู้ร้องขอ
                    $prepareorder->transport_type_code      = $request->shipment_by;                    //สั่งทาง
                    $prepareorder->order_date               = $new_order_date;                          //วันที่สั่ง
                    $prepareorder->delivery_date            = $new_delivary_date;                       //วันที่ส่ง
                    $prepareorder->order_type_id            = $request->transaction_id;                 //ประเภทสั้งซื้อ
                    $prepareorder->price_list_id            = $request->price_list;                     // ราคาขาย
                    $prepareorder->remark_source_system     = $request->remark_order;                   //หมายเหตุสั่งทาง
                    $prepareorder->remark                   = $request->remark_list;                    //หมายเหตุ
                    $prepareorder->order_status             = $request->order_status;                   //สถานะ
                    $prepareorder->attribute2               = !empty($request->not_deli_price)? 'Y' : 'N'; //ไม่คิดค่าขนส่ง
                    // $prepareorder->pick_release_print_flag  = 'Y';
                    $prepareorder->unlock_print_flag        = 'Y';
                    if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                        if(!empty($request->total_amount)){
                            $prepareorder->sub_total            = $request->total_amount;                   //ราคาสินค้าทั้งหมด
                            $prepareorder->cash_amount          = round($request->total_amount, 2);                   //ราคาสินค้าทั้งหมด
                            $prepareorder->grand_total          = round($request->total_amount, 2);                   //ราคาสินค้าทั้งหมด
                        }
                    }else{
                        if(!empty($request->total_amount_tobac)){
                            $prepareorder->sub_total            = $request->total_amount_tobac;                   //ราคาสินค้าทั้งหมด
                            $prepareorder->cash_amount          = round($request->total_amount_tobac, 2);                   //ราคาสินค้าทั้งหมด
                            $prepareorder->grand_total          = round($request->total_amount_tobac, 2);                   //ราคาสินค้าทั้งหมด
                        }
                    }
                    $prepareorder->order_source             = 'WEB';
                    $prepareorder->program_code             = 'OMP0020';
                    $prepareorder->created_by               = optional(auth()->user())->user_id;
                    $prepareorder->creation_date            = date('Y-m-d H:i:s');
                    $prepareorder->last_updated_by          = optional(auth()->user())->user_id;
                    $prepareorder->last_update_date         = date('Y-m-d H:i:s');
                    $prepareorder->save();

                    $header_id      = $prepareorder->order_header_id;
                    $header_status  = $prepareorder->order_status;
                    $order_number   =  $prepareorder->prepare_order_number;
                    if($request->hasFile('attachment')) {
                        $fileAttachment = $request->file('attachment');
                        AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$prepareorder->order_header_id,'OMP0020');
                    }
                    $total_tax = 0;
                    if(!empty($request->product_code)){
                        foreach($request->product_code as $key_line => $item_line){
                            $price = PriceListHeadModel::where('name','ราคาขายปลีก')
                                                            ->join('ptom_price_list_line_v','ptom_price_list_line_v.list_header_id','=','ptom_price_list_head_v.list_header_id')
                                                            ->where('ptom_price_list_line_v.start_date_active','<=',date('Y-m-d'))
                                                            ->where(function ($query) {
                                                                $query->where('ptom_price_list_line_v.end_date_active','>=',date('Y-m-d'));
                                                                $query->orWhereNull('ptom_price_list_line_v.end_date_active');
                                                            })
                                                            ->where('ptom_price_list_line_v.item_id',$request->item_id[$key_line])
                                                            ->first();

                            $tax_amount = 0;
                            $tax_amount = ($request->input_unit_total[$key_line] * $price->operand) * $tax/107;
                            $total_tax += $tax_amount;
                            // $quota = QuotaHeaderModel::leftJoin('ptom_customer_quota_lines','ptom_customer_quota_lines.quota_header_id','=','ptom_customer_quota_headers.quota_header_id')
                            //                             ->where('ptom_customer_quota_headers.customer_id',$request->customer_id) //where customer
                            //                             ->where('ptom_customer_quota_lines.item_code',$item_line) //where product code
                            //                             ->whereNull('ptom_customer_quota_headers.deleted_at') //cehck not delete
                            //                             ->where('ptom_customer_quota_headers.start_date','<=',$new_order_date) //check date
                            //                             ->where('ptom_customer_quota_headers.end_date','>=',$new_order_date) //check date
                            //                             ->where('ptom_customer_quota_headers.status','Active') // check active
                            //                             ->first();


                            $orderline                          = new OrderLineModel();
                            $orderline->order_header_id         = $prepareorder->order_header_id;
                            $orderline->line_number             = $request->number_list[$key_line];
                            $orderline->item_id                 = $request->item_id[$key_line];
                            $orderline->item_code               = $item_line;
                            $orderline->tax_amount              = round($tax_amount, 5);
                            $orderline->item_description        = $request->item_description[$key_line];
                            $orderline->order_quantity          = round($request->input_unit_total[$key_line], 2);
                            if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                $orderline->order_cardboardbox      = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                $orderline->order_carton            = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                            }
                            $orderline->approve_quantity        = round($request->input_unit_total[$key_line], 2);
                            if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                $orderline->approve_cardboardbox    = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                $orderline->approve_carton          = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                            }
                            $orderline->amount                  = round($request->input_price_total[$key_line], 2);
                            $orderline->total_amount            = round($request->input_price_total[$key_line], 2);
                            $orderline->unit_price              = $request->price_unit[$key_line];
                            $orderline->attribute1              = $price->operand;
                            $orderline->quota_line_id           = 0;
                            if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                $orderline->uom_code                = 'CGK';
                                $orderline->uom                     = 'พันมวน';
                            }else{
                                $orderline->uom_code                = $request->uom_type[$key_line];
                                $orderline->uom                     = $request->uom_name[$key_line];
                            }
                            $orderline->program_code            = 'OMP0020';
                            $orderline->created_by              = optional(auth()->user())->user_id;
                            $orderline->creation_date           = date('Y-m-d H:i:s');
                            $orderline->last_updated_by         = optional(auth()->user())->user_id;
                            $orderline->last_update_date        = date('Y-m-d H:i:s');
                            $orderline->save();

                            $line_id[$key_line]     = $orderline->order_line_id;
                            $lot_id[$key_line]      = [];
                            if(!empty($request->lot[$key_line])){
                                foreach($request->lot[$key_line] as $key_lot => $item_lot){
                                    $orderlot                           = new OrderLotModel();
                                    $orderlot->order_line_id            = $orderline->order_line_id;
                                    $orderlot->item_id                  = $request->item_id[$key_line];
                                    $orderlot->item_code                = $item_line;
                                    $orderlot->item_description         = $request->item_description[$key_line];
                                    $orderlot->inv_org_id               = $request->lot[$key_line][$key_lot]['org'];
                                    $orderlot->inv_org_name             = $request->lot[$key_line][$key_lot]['org_name'];
                                    $orderlot->lot_number               = $request->lot[$key_line][$key_lot]['lot_number'];
                                    $orderlot->onhand_quantity          = $request->lot[$key_line][$key_lot]['on_hand'];
                                    $orderlot->inv_uom_code             = $request->lot[$key_line][$key_lot]['lot_uom'];
                                    $orderlot->onhand_conv_qty          = $request->lot[$key_line][$key_lot]['onhand_qunty'];
                                    $orderlot->subinventory_code        = !empty($request->lot[$key_line][$key_lot]['subinventory_code'])? $request->lot[$key_line][$key_lot]['subinventory_code']:'';
                                    $orderlot->inventory_location_id    = !empty($request->lot[$key_line][$key_lot]['inventory_location_id'])? $request->lot[$key_line][$key_lot]['inventory_location_id'] : '';
                                    $orderlot->order_quantity           = $request->input_unit_total[$key_line];
                                    $orderlot->program_code             = 'OMP0020';
                                    $orderlot->created_by               = optional(auth()->user())->user_id;
                                    $orderlot->creation_date            = date('Y-m-d H:i:s');
                                    $orderlot->last_updated_by          = optional(auth()->user())->user_id;
                                    $orderlot->last_update_date         = date('Y-m-d H:i:s');
                                    $orderlot->save();

                                    $lot_id[$key_line][$key_lot]    =  $orderlot->order_lot_id;
                                }
                            }
                        }
                    }
                    $prepareorder->tax = number_format($total_tax,2,'.','');
                    if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                        if(!empty($request->total_amount)){
                            $sub_total = $request->total_amount - $total_tax;
                            $prepareorder->sub_total            = number_format($sub_total,2,'.','');                   //ราคาสินค้าทั้งหมด
                        }
                    }else{
                        if(!empty($request->total_amount_tobac)){
                            $sub_total = $request->total_amount_tobac - $total_tax;
                            $prepareorder->sub_total            = number_format($sub_total,2,'.','');                   //ราคาสินค้าทั้งหมด
                        }
                    }
                    $prepareorder->save();
                    if($prepareorder->order_status == 'Confirm'){
                        GenerateNumberRepo::callWMSPackagePrepareSaleOrder($prepareorder->order_header_id,$prepareorder->prepare_order_number);
                        OrderRepo::insertOrdersHistoryv2( $prepareorder,'Inprocess');
                    }
                }else{
                    $prepareorder                           = PrepareSaleOrderModel::where('order_header_id',$request->order_id)->first();
                    // $prepareorder->org_id                   = '81';
                    // $prepareorder->prepare_order_number     = $request->prepare_number_data;            //เลขที่ใบเตรียมขาย
                    $prepareorder->customer_id              = $request->customer_id;                    //ลูกค้า
                    $prepareorder->payment_type_code        = $customer->payment_type_id;               //ประเภทการชำระ
                    $prepareorder->product_type_code        = $request->product_type_code;             //ประเภทบุหรา
                    $prepareorder->payment_method_code      = $customer->payment_method_id;             //เงื่อนไงการชำระ
                    $prepareorder->period_id                = $period->period_line_id;                  //งวดที่สั้งซื้อ
                    $prepareorder->bill_to_site_id          = $customer->bill_to_site_id;               //ที่ส่งใบเสร็จ
                    $prepareorder->ship_to_site_id          = $request->ship_to_site;                   //ที่อยู่จัดส่ง
                    $prepareorder->currency                 = $customer->currency;                      //สกุลเงิน
                    $prepareorder->source_system            = $request->order_by;                       //สั่งทาง
                    $prepareorder->requestor_code           = $request->request_by;                     //ผู้ร้องขอ
                    $prepareorder->transport_type_code      = $request->shipment_by;                    //สั่งทาง
                    $prepareorder->order_date               = $new_order_date;                          //วันที่สั่ง
                    $prepareorder->delivery_date            = $new_delivary_date;                       //วันที่ส่ง
                    $prepareorder->order_type_id            = $request->transaction_id;                 //ประเภทสั้งซื้อ
                    $prepareorder->price_list_id            = $request->price_list;                     // ราคาขาย
                    $prepareorder->remark_source_system     = $request->remark_order;                   //หมายเหตุสั่งทาง
                    $prepareorder->remark                   = $request->remark_list;                    //หมายเหตุ
                    $prepareorder->order_status             = $request->order_status;                   //สถานะ
                    $prepareorder->attribute2               = !empty($request->not_deli_price)? 'Y' : 'N'; //ไม่คิดค่าขนส่ง
                    if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                        if(!empty($request->total_amount)){
                            $prepareorder->sub_total            = $request->total_amount;                   //ราคาสินค้าทั้งหมด
                            $prepareorder->cash_amount          = round($request->total_amount, 2);                   //ราคาสินค้าทั้งหมด
                            $prepareorder->grand_total          = round($request->total_amount, 2);                   //ราคาสินค้าทั้งหมด
                        }
                    }else{
                        if(!empty($request->total_amount_tobac)){
                            $prepareorder->sub_total            = $request->total_amount_tobac;                   //ราคาสินค้าทั้งหมด
                            $prepareorder->cash_amount          = round($request->total_amount_tobac, 2);                   //ราคาสินค้าทั้งหมด
                            $prepareorder->grand_total          = round($request->total_amount_tobac, 2);                   //ราคาสินค้าทั้งหมด
                        }
                    }

                    $prepareorder->last_updated_by          = optional(auth()->user())->user_id;
                    $prepareorder->last_update_date         = date('Y-m-d H:i:s');
                    $prepareorder->save();

                    $header_id      = $prepareorder->order_header_id;
                    $header_status  = $prepareorder->order_status;
                    $order_number   =  $prepareorder->prepare_order_number;

                    if($request->hasFile('attachment')) {
                        $fileAttachment = $request->file('attachment');
                        AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$prepareorder->order_header_id,'OMP0020');
                    }

                    if(!empty($request->remove_line)){
                        foreach($request->remove_line as $item_line){
                            $line                          = OrderLineModel::where('order_line_id',$request->remove_line)->first();
                            $line->last_updated_by         = optional(auth()->user())->user_id;
                            $line->last_update_date        = date('Y-m-d H:i:s');
                            $line->deleted_by_id           = optional(auth()->user())->user_id;
                            $line->deleted_at              = date('Y-m-d H:i:s');
                            $line->save();
                        }
                    }
                    $total_tax = 0;
                    if(!empty($request->product_code)){
                        foreach($request->product_code as $key_line => $item_line){
                            $price = PriceListHeadModel::where('name','ราคาขายปลีก')
                                                            ->join('ptom_price_list_line_v','ptom_price_list_line_v.list_header_id','=','ptom_price_list_head_v.list_header_id')
                                                            ->where('ptom_price_list_line_v.start_date_active','<=',date('Y-m-d'))
                                                            ->where(function ($query) {
                                                                $query->where('ptom_price_list_line_v.end_date_active','>=',date('Y-m-d'));
                                                                $query->orWhereNull('ptom_price_list_line_v.end_date_active');
                                                            })
                                                            ->where('ptom_price_list_line_v.item_id',$request->item_id[$key_line])
                                                            ->first();

                            $tax_amount = 0;
                            $tax_amount = ($request->input_unit_total[$key_line] * $price->operand) * $tax/107;
                            $total_tax += $tax_amount;
                            // $quota      = QuotaHeaderModel::leftJoin('ptom_customer_quota_lines','ptom_customer_quota_lines.quota_header_id','=','ptom_customer_quota_headers.quota_header_id')
                            //                             ->where('ptom_customer_quota_headers.customer_id',$request->customer_id) //where customer
                            //                             ->where('ptom_customer_quota_lines.item_code',$item_line) //where product code
                            //                             ->whereNull('ptom_customer_quota_headers.deleted_at') //cehck not delete
                            //                             ->whereDate('ptom_customer_quota_headers.start_date','<=',$new_order_date) //check date
                            //                             ->whereDate('ptom_customer_quota_headers.end_date','>=',$new_order_date) //check date
                            //                             ->where('ptom_customer_quota_headers.status','Active') // check active
                            //                             ->first();

                            if(isset($request->line_id[$key_line])){
                                $orderline  = OrderLineModel::where('order_header_id',$request->order_id)
                                                            ->where('order_line_id',$request->line_id[$key_line])
                                                            ->first();
                                $orderline->line_number             = $request->number_list[$key_line];
                                $orderline->item_id                 = $request->item_id[$key_line];
                                $orderline->item_code               = $item_line;
                                $orderline->item_description        = $request->item_description[$key_line];
                                $orderline->tax_amount              = round($tax_amount,5);
                                $orderline->order_quantity          = round($request->input_unit_total[$key_line], 2);
                                if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                    $orderline->order_cardboardbox      = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                    $orderline->order_carton            = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                                }
                                $orderline->approve_quantity        = round($request->input_unit_total[$key_line], 2);
                                if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                    $orderline->approve_cardboardbox    = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                    $orderline->approve_carton          = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                                }
                                $orderline->amount                  = round($request->input_price_total[$key_line], 2);
                                $orderline->total_amount            = round($request->input_price_total[$key_line], 2);
                                $orderline->unit_price              = $request->price_unit[$key_line];
                                $orderline->attribute1              = $price->operand;
                                if($request->transaction_type_premium == 'ยาเส้นไม่ปรุง'){
                                    $orderline->uom_code                = $request->uom_type[$key_line];
                                    $orderline->uom                     = $request->uom_name[$key_line];
                                }
                                $orderline->quota_line_id           = 0;
                                $orderline->last_updated_by         = optional(auth()->user())->user_id;
                                $orderline->last_update_date        = date('Y-m-d H:i:s');
                                $orderline->save();

                                $line_id[$key_line]             = $orderline->order_line_id;
                                $lot_id[$key_line]              = [];
                                if(!empty($request->lot[$key_line])){
                                    foreach($request->lot[$key_line] as $key_lot => $item_lot){
                                        if(!empty($request->lot[$key_line][$key_lot]['lot_id'])){
                                            $orderlot                           = OrderLotModel::where('order_lot_id',$request->lot[$key_line][$key_lot]['lot_id'])->first();
                                            $orderlot->item_id                  = $request->item_id[$key_line];
                                            $orderlot->item_code                = $item_line;
                                            $orderlot->item_description         = $request->item_description[$key_line];
                                            $orderlot->inv_org_id               = $request->lot[$key_line][$key_lot]['org'];
                                            $orderlot->inv_org_name             = $request->lot[$key_line][$key_lot]['org_name'];
                                            $orderlot->lot_number               = $request->lot[$key_line][$key_lot]['lot_number'];
                                            $orderlot->onhand_quantity          = $request->lot[$key_line][$key_lot]['on_hand'];
                                            $orderlot->inv_uom_code             = $request->lot[$key_line][$key_lot]['lot_uom'];
                                            $orderlot->onhand_conv_qty          = $request->lot[$key_line][$key_lot]['onhand_qunty'];
                                            $orderlot->inventory_location_id    = $request->lot[$key_line][$key_lot]['inventory_location_id'];
                                            $orderlot->locator                  = $request->lot[$key_line][$key_lot]['locator'];
                                            $orderlot->subinventory_code        = $request->lot[$key_line][$key_lot]['subinventory_code'];
                                            $orderlot->order_quantity           = $request->input_unit_total[$key_line];
                                            $orderlot->last_updated_by          = optional(auth()->user())->user_id;
                                            $orderlot->last_update_date         = date('Y-m-d H:i:s');
                                            $orderlot->save();

                                            $lot_id[$key_line][$key_lot]    =  $orderlot->order_lot_id;
                                        }else{
                                            $orderlot                           = new OrderLotModel();
                                            $orderlot->order_line_id            = $orderline->order_line_id;
                                            $orderlot->item_id                  = $request->item_id[$key_line];
                                            $orderlot->item_code                = $item_line;
                                            $orderlot->item_description         = $request->item_description[$key_line];
                                            $orderlot->inv_org_id               = $request->lot[$key_line][$key_lot]['org'];
                                            $orderlot->inv_org_name             = $request->lot[$key_line][$key_lot]['org_name'];
                                            $orderlot->lot_number               = $request->lot[$key_line][$key_lot]['lot_number'];
                                            $orderlot->onhand_quantity          = $request->lot[$key_line][$key_lot]['on_hand'];
                                            $orderlot->inv_uom_code             = $request->lot[$key_line][$key_lot]['lot_uom'];
                                            $orderlot->onhand_conv_qty          = $request->lot[$key_line][$key_lot]['onhand_qunty'];
                                            $orderlot->inventory_location_id    = $request->lot[$key_line][$key_lot]['inventory_location_id'];
                                            $orderlot->locator                  = $request->lot[$key_line][$key_lot]['locator'];
                                            $orderlot->subinventory_code        = $request->lot[$key_line][$key_lot]['subinventory_code'];
                                            $orderlot->order_quantity           = $request->input_unit_total[$key_line];
                                            $orderlot->program_code             = 'OMP0020';
                                            $orderlot->created_by               = optional(auth()->user())->user_id;
                                            $orderlot->creation_date            = date('Y-m-d H:i:s');
                                            $orderlot->last_updated_by          = optional(auth()->user())->user_id;
                                            $orderlot->last_update_date         = date('Y-m-d H:i:s');
                                            $orderlot->save();

                                            $lot_id[$key_line][$key_lot]    =  $orderlot->order_lot_id;
                                        }
                                    }
                                }
                            }else{
                                $orderline                          = new OrderLineModel();
                                $orderline->order_header_id         = $request->order_id;
                                $orderline->line_number             = $request->number_list[$key_line];
                                $orderline->item_id                 = $request->item_id[$key_line];
                                $orderline->item_code               = $item_line;
                                $orderline->item_description        = $request->item_description[$key_line];
                                $orderline->tax_amount              = round($tax_amount, 5);
                                if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                    $orderline->order_cardboardbox      = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                    $orderline->order_carton            = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                                }
                                $orderline->approve_quantity        = round($request->input_unit_total[$key_line], 2);
                                if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                    $orderline->approve_cardboardbox    = !empty($request->box[$key_line])?$request->box[$key_line] : '0';
                                    $orderline->approve_carton          = !empty($request->pack[$key_line])?$request->pack[$key_line] : '0';
                                }
                                $orderline->amount                  = round($request->input_price_total[$key_line], 2);
                                $orderline->unit_price              = $request->price_unit[$key_line];
                                $orderline->attribute1              = $price->operand;
                                // $orderline->quota_line_id           = !empty($quota->order_line_id)?$quota->order_line_id : 0;
                                $orderline->quota_line_id           = 0;
                                if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                                    $orderline->uom_code                = 'CGK';
                                    $orderline->uom                     = 'พันมวน';
                                }else{
                                    $orderline->uom_code                = $request->uom_type[$key_line];
                                    $orderline->uom                     = $request->uom_name[$key_line];
                                }
                                $orderline->total_amount            = round($request->input_price_total[$key_line], 2);
                                $orderline->program_code            = 'OMP0020';
                                $orderline->created_by              = optional(auth()->user())->user_id;
                                $orderline->creation_date           = date('Y-m-d H:i:s');
                                $orderline->last_updated_by         = optional(auth()->user())->user_id;
                                $orderline->last_update_date        = date('Y-m-d H:i:s');
                                $orderline->save();

                                $line_id[$key_line]     = $orderline->order_line_id;
                                $lot_id[$key_line]      = [];
                                if(!empty($request->lot[$key_line])){
                                    foreach($request->lot[$key_line] as $key_lot => $item_lot){
                                        $orderlot                           = new OrderLotModel();
                                        $orderlot->order_line_id            = $orderline->order_line_id;
                                        $orderlot->item_id                  = $request->item_id[$key_line];
                                        $orderlot->item_code                = $item_line;
                                        $orderlot->item_description         = $request->item_description[$key_line];
                                        $orderlot->inv_org_id               = $request->lot[$key_line][$key_lot]['org'];
                                        $orderlot->inv_org_name             = $request->lot[$key_line][$key_lot]['org_name'];
                                        $orderlot->lot_number               = $request->lot[$key_line][$key_lot]['lot_number'];
                                        $orderlot->onhand_quantity          = $request->lot[$key_line][$key_lot]['on_hand'];
                                        $orderlot->inv_uom_code             = $request->lot[$key_line][$key_lot]['lot_uom'];
                                        $orderlot->onhand_conv_qty          = $request->lot[$key_line][$key_lot]['onhand_qunty'];
                                        $orderlot->order_quantity           = $request->input_unit_total[$key_line];
                                        $orderlot->inventory_location_id    = $request->lot[$key_line][$key_lot]['inventory_location_id'];
                                        $orderlot->locator                  = $request->lot[$key_line][$key_lot]['locator'];
                                        $orderlot->subinventory_code        = $request->lot[$key_line][$key_lot]['subinventory_code'];
                                        $orderlot->program_code             = 'OMP0020';
                                        $orderlot->created_by               = optional(auth()->user())->user_id;
                                        $orderlot->creation_date            = date('Y-m-d H:i:s');
                                        $orderlot->last_updated_by          = optional(auth()->user())->user_id;
                                        $orderlot->last_update_date         = date('Y-m-d H:i:s');
                                        $orderlot->save();

                                        $lot_id[$key_line][$key_lot]    =  $orderlot->order_lot_id;
                                    }
                                }
                            }
                        }
                    }
                    $prepareorder->tax = number_format($total_tax,2,'.','');
                    if ($request->transaction_type_premium != 'ยาเส้นไม่ปรุง') {
                        if(!empty($request->total_amount)){
                            $sub_total = $request->total_amount - $total_tax;
                            $prepareorder->sub_total            = number_format($sub_total,2,'.','');                   //ราคาสินค้าทั้งหมด
                        }
                    }else{
                        if(!empty($request->total_amount_tobac)){
                            $sub_total = $request->total_amount_tobac - $total_tax;
                            $prepareorder->sub_total            = number_format($sub_total,2,'.','');                   //ราคาสินค้าทั้งหมด
                        }
                    }
                    $prepareorder->save();
                    if($prepareorder->order_status == 'Confirm'){
                        GenerateNumberRepo::callWMSPackagePrepareSaleOrder($prepareorder->order_header_id,$prepareorder->prepare_order_number);
                        OrderRepo::insertOrdersHistoryv2( $prepareorder,'Inprocess');
                    }
                }

                $rest = [
                    'status'        => true,
                    'data_id'       => 'success',
                    'head_id'       => $header_id,
                    'line_id'       => $line_id,
                    // 'lot_id'        => $lot_id,
                    'status_order'  => $header_status,
                    'order_number'  => $order_number
                    // 'test'          => $test
                ];

            } catch (\Exception $e) {
                DB::rollBack();
                $rest = [
                    'status'    => false,
                    'data'      => 'มีบางอย่างผิดพลาด',
                    'message'   => $e->getMessage().' Line:'.$e->getLine(),
                ];
            }
            DB::commit();

            return response()->json(['data' => $rest]);
        }
    }

    public function searchPrepareSaleOrder(Request $request)
    {
        $order   =   PrepareSaleOrderModel::where('prepare_order_number',$request->prepare_number)->where('program_code' , 'OMP0020')->first();
        $attachmentFile = [];
        if(!empty($order)){
            $line   =   OrderLineModel::where('order_header_id',$order->order_header_id)->whereNull('deleted_at')->get();
            $req    =   RequestorModel::where('lookup_code',$order->requestor_code)->first();
            $custo  =   CustomerModel::where('customer_id',$order->customer_id)->first();
            $history =   DB::table('ptom_order_history')->where('order_header_id',$order->order_header_id)->where('order_status','Inprocess')->whereNull('ptom_order_history.deleted_at')->first();
            $output['header'] = [
                'id'                => $order->order_header_id,                     //รหัส primary
                'prepare_number'    => $order->prepare_order_number,                //เลขที่ใบเตรียมขาย
                'order_status'      => $order->order_status,                        //สถานะ
                'customer_id'       => $order->customer_id,                         //ลูกค้า
                'customer_num'      => $custo->customer_number,                     //ลูกค้า
                'ship_to_site'      => $order->ship_to_site_id,                     //ที่อยู่จัดส่ง
                'order_by'          => $order->source_system,                       // สั่งทาง
                'order_remark'      => $order->remark_source_system,                //หมายเหตุสั่งทาง
                'remark'            => $order->remark,                              //หมายเหตุ
                'request_id'        => $order->requestor_code,                      //ผู้ร้องขอ
                'request_meaning'   => $req? $req->meaning : '',                               //ผู้ร้องขอ
                'delivary_by'       => $order->transport_type_code,                 // ส่งโดย
                'order_date'        => dateThaiNumberSlad($order->order_date),      // วันที่สั่ง
                'delivary_date'     => dateThaiNumberSlad($order->delivery_date),   //วันที่ส่ง
                'order_type'        => $order->order_type_id,                       //ประเภทสั้งซื้อ
                'product_type_code' => $order->product_type_code,                  //ประเภทบุหรี่
                'sale_price'        => $order->price_list_id,                       // ราคาขาย
                'sub_total'         => $order->sub_total,                           // ราคาท้งหมด
                'approve_flag'      => $order->payment_approve_flag,                 // อนุมัติ
                'his'               => !empty($history)? 'Y':'N',                    // ส่งอนุมัติ
                'not_deli_price'    => $order->attribute2                           //ไม่คิดค่าขนส่ง
            ];

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0020')->where('header_id',$order->order_header_id)->whereNull('deleted_at')->get();
            $sub_total = 0;
            foreach($line as $line_item){
                // $approve_cardbox = !empty($line_item->approve_cardboardbox)? $line_item->approve_cardboardbox : 0;
                $lot        = OrderLotModel::where('order_line_id',$line_item->order_line_id)->first();
                $item_sum   = OnhandModel::where('item_code',$line_item->item_code)->sum('onhand_quantity');
                if(!empty($lot)){
                    $org_code   = OnhandModel::where('organization_id',$lot->inv_org_id)->first();
                }
                $sub_total += $line_item->amount;
                $output['order_line'][] = [
                    'id'                            => $line_item->order_line_id,
                    'number'                        => (int) $line_item->line_number,
                    'product_id'                    => $line_item->item_id,
                    'product_code'                  => $line_item->item_code,
                    'product_description'           => $line_item->item_description,
                    'order_cardboardbox'            => $line_item->order_cardboardbox,
                    'order_carton'                  => $line_item->order_carton,
                    'order_cardboardbox_approve'    => $line_item->approve_cardboardbox,
                    'order_carton_approve'          => $line_item->approve_carton,
                    'order_total'                   => ($line_item->order_cardboardbox /0.1) + ($line_item->order_carton * 0.2),
                    'order_total_approve'           => $line_item->approve_quantity,
                    'price_unit'                    => $line_item->unit_price,
                    'total_price'                   => $line_item->amount,
                    'onhand'                        => number_format($item_sum,2,'.',','),
                    'org_id'                        => !empty($lot) ? $org_code->organization_id : '',
                    'org_code'                      => !empty($lot) ? $org_code->organization_code : '',
                    'lot_number'                    => !empty($lot) ? $lot->lot_number : '',
                    'org_name'                      => !empty($lot) ? $lot->inv_org_name : '',
                    'onhand_quantity'               => !empty($lot) ? $lot->onhand_quantity : '',
                    'order_quantity'                => !empty($lot) ? $lot->order_quantity : '',
                    'inv_uom_code'                  => !empty($lot) ? $lot->inv_uom_code : '',
                    'onhand_conv_qty'               => !empty($lot) ? $lot->onhand_conv_qty : '',
                ];
            }
            $output['header']['sub_total'] = $sub_total;
            $rest = [
                'status'            => true,
                'data'              => $output,
                'attachmentFile'    => $attachmentFile
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'ไม่พบข้อมูล',
                'attachmentFile'    => []
            ];
        }

        return \response()->json(['data'=>$rest]);
    }

    public function getProductItem(Request $request)
    {
        if($request->type == 'ยาเส้นไม่ปรุง'){
            $p_type = 20;
        }else{
            $p_type = 10;
        }
        $data = PriceListHeadModel::where('ptom_price_list_head_v.list_header_id',$request->price_list_id)
                                        ->join('ptom_price_list_line_v','ptom_price_list_line_v.list_header_id','=','ptom_price_list_head_v.list_header_id')
                                        ->join('ptom_sequence_ecoms','ptom_sequence_ecoms.item_id','=','ptom_price_list_line_v.item_id')
                                        ->where('ptom_price_list_line_v.start_date_active','<=',date('Y-m-d'))
                                        ->where('ptom_sequence_ecoms.product_type_code',$p_type)
                                        ->where(function ($query) {
                                            $query->where('ptom_price_list_line_v.end_date_active','>=',date('Y-m-d'));
                                            $query->orWhereNull('ptom_price_list_line_v.end_date_active');
                                        })
                                        ->get();

        // $data = OrderRepo::getCustomerQuotaHeaders($request->customer_id);

        if($data->count() > 0){
            foreach($data as $data_item){
                $item_quantity = OnhandModel::where('item_code',$data_item->item_code)->get();
                $onhand = [];
                if($item_quantity->count() > 0){
                    $total = 0;
                    foreach($item_quantity as $item_q){
                        if($item_q->transaction_uom_code == 'CGK'){
                            $total += $item_q->onhand_quantity;
                        }else if($item_q->transaction_uom_code == 'CG'){
                            $change = $item_q->onhand_quantity / 1000;
                            $total += $change;
                        }else{
                            $total += $item_q->onhand_quantity;
                        }
                    }
                }else{
                    $total = 0;
                    $onhand[$data_item->item_code][] = '';
                }

                $item[$data_item->item_code] = [
                    'item_id'               =>  $data_item->item_id,
                    'item_code'             =>  $data_item->item_code,
                    'item_description'      =>  $data_item->ecom_item_description,
                    'price_unit'            =>  $data_item->operand,
                    'type_code'             =>  $data_item->product_type_code,
                    'onhand'                =>  number_format($total,2,'.',','),
                    'uom_code'              =>  $data_item->product_uom_code
                ];
            }

            if(!empty($request->header_id)){
                $line       = OrderLineModel::where('order_header_id',$request->header_id)->orderBy('line_number','asc')->get();
                foreach($line as $line_item){
                    $item_quantity = OnhandModel::where('item_code',$line_item->item_code)->get();
                    $onhand = [];
                    if($item_quantity->count() > 0){
                        $total = 0;
                        foreach($item_quantity as $item_q){
                            if($item_q->transaction_uom_code == 'CGK'){
                                $total += $item_q->onhand_quantity;
                            }else if($item_q->transaction_uom_code == 'CG'){
                                $change = $item_q->onhand_quantity / 1000;
                                $total += $change;
                            }else{
                                $total += $item_q->onhand_quantity;
                            }
                        }
                    }else{
                        $total = 0;
                    }
                    // $lot        = OrderLotModel::where('order_line_id',$line_item->order_line_id)->first();
                    // $item_sum   = OnhandModel::where('item_code',$line_item->item_code)->sum('onhand_quantity');
                    // if(!empty($lot)){
                    //     $org_code   = OnhandModel::where('organization_id',$lot->inv_org_id)->first();
                    // }

                    $order_line[] = [
                        'id'                            => $line_item->order_line_id,
                        'number'                        => (int) $line_item->line_number,
                        'product_id'                    => $line_item->item_id,
                        'product_code'                  => $line_item->item_code,
                        'product_description'           => $line_item->item_description,
                        'product_type'                  => $item[$line_item->item_code]['type_code'],
                        'order_cardboardbox'            => number_format($line_item->order_cardboardbox,0,'',''),
                        'order_carton'                  => number_format($line_item->order_carton,1,'.',''),
                        'order_cardboardbox_approve'    => number_format($line_item->approve_cardboardbox,0,'',''),
                        'order_carton_approve'          => number_format($line_item->approve_carton,1,'.',''),
                        'order_total'                   => $line_item->order_cardboardbox + $line_item->order_carton,
                        'order_total_approve'           => $line_item->approve_quantity,
                        'price_unit'                    => $line_item->unit_price,
                        'total_price'                   => $line_item->amount,
                        'uom_code'                      => $line_item->uom_code,
                        'onhand'                        =>  number_format($total,2,'.',','),
                        // 'org_id'                        => !empty($lot) ? $org_code->organization_id : '',
                        // 'org_code'                      => !empty($lot) ? $org_code->organization_code : '',
                        // 'lot_number'                    => !empty($lot) ? $lot->lot_number : '',
                        // 'org_name'                      => !empty($lot) ? $lot->inv_org_name : '',
                        // 'onhand_quantity'               => !empty($lot) ? $lot->onhand_quantity : '',
                        // 'order_quantity'                => !empty($lot) ? $lot->order_quantity : '',
                        // 'inv_uom_code'                  => !empty($lot) ? $lot->inv_uom_code : '',
                        // 'onhand_conv_qty'               => !empty($lot) ? $lot->onhand_conv_qty : '',
                    ];
                }
            }else{
                $order_line = false;
            }

            $rest = [
                'status'    => true,
                'data'      => !empty($item)? $item : [],
                'line'      => $order_line
            ];
        }else{
            $rest = [
                'status'    => false,
                'message'   => 'ไม่พบข้อมูล'
            ];
        }

        return \response()->json(['data'=>$rest]);
    }

    public function getUomListProduct(Request $request)
    {
        $list = OrderRepo::getProductListTypeCodePriceList($request->customer_id,$request->product_type,$request->price_list);

        foreach($list as $list_item){
            $item_quantity = OnhandModel::where('item_code',$list_item->item_code)->get();
            if($item_quantity->count() > 0){
                $total = 0;
                foreach($item_quantity as $item_q){
                    if($item_q->transaction_uom_code == 'CGK'){
                        $total += $item_q->onhand_quantity;
                    }else if($item_q->transaction_uom_code == 'CG'){
                        $change = $item_q->onhand_quantity / 1000;
                        $total += $change;
                    }else{
                        $total += $item_q->onhand_quantity;
                    }
                }
            }else{
                $total = 0;
            }

            $list_item->onhand = number_format($total,2,'.',',');
        }

        if(!empty($request->header_id)){
            $line       = OrderLineModel::where('order_header_id',$request->header_id)->orderBy('line_number','asc')->get();
            foreach($line as $line_item){
                $item_quantity = OnhandModel::where('item_code',$line_item->item_code)->get();
                $onhand = [];
                if($item_quantity->count() > 0){
                    $total = 0;
                    foreach($item_quantity as $item_q){
                        if($item_q->transaction_uom_code == 'CGK'){
                            $total += $item_q->onhand_quantity;
                        }else if($item_q->transaction_uom_code == 'CG'){
                            $change = $item_q->onhand_quantity / 1000;
                            $total += $change;
                        }else{
                            $total += $item_q->onhand_quantity;
                        }
                    }
                }else{
                    $total = 0;
                }
                // $lot        = OrderLotModel::where('order_line_id',$line_item->order_line_id)->first();
                // $item_sum   = OnhandModel::where('item_code',$line_item->item_code)->sum('onhand_quantity');
                // if(!empty($lot)){
                //     $org_code   = OnhandModel::where('organization_id',$lot->inv_org_id)->first();
                // }

                $order_line[] = [
                    'id'                            => $line_item->order_line_id,
                    'number'                        => (int) $line_item->line_number,
                    'product_id'                    => $line_item->item_id,
                    'product_code'                  => $line_item->item_code,
                    'product_description'           => $line_item->item_description,
                    'product_type'                  => $request->product_type,
                    'order_cardboardbox'            => number_format($line_item->order_cardboardbox,0,'',''),
                    'order_carton'                  => number_format($line_item->order_carton,1,'.',''),
                    'order_cardboardbox_approve'    => number_format($line_item->approve_cardboardbox,0,'',''),
                    'order_carton_approve'          => number_format($line_item->approve_carton,1,'.',''),
                    'order_total'                   => $line_item->order_cardboardbox + $line_item->order_carton,
                    'order_total_approve'           => $line_item->approve_quantity,
                    'price_unit'                    => $line_item->unit_price,
                    'total_price'                   => $line_item->amount,
                    'uom_code'                      => $line_item->uom_code,
                    'onhand'                        =>  number_format($total,2,'.',','),
                    // 'org_id'                        => !empty($lot) ? $org_code->organization_id : '',
                    // 'org_code'                      => !empty($lot) ? $org_code->organization_code : '',
                    // 'lot_number'                    => !empty($lot) ? $lot->lot_number : '',
                    // 'org_name'                      => !empty($lot) ? $lot->inv_org_name : '',
                    // 'onhand_quantity'               => !empty($lot) ? $lot->onhand_quantity : '',
                    // 'order_quantity'                => !empty($lot) ? $lot->order_quantity : '',
                    // 'inv_uom_code'                  => !empty($lot) ? $lot->inv_uom_code : '',
                    // 'onhand_conv_qty'               => !empty($lot) ? $lot->onhand_conv_qty : '',
                ];
            }
        }else{
            $order_line = false;
        }

        $rest = [
            'status'    => true,
            'data'      => $list,
            'line'      => $order_line
        ];

        return response()->json(['data' => $rest]);
    }


    public function getLotData(Request $request)
    {
        $onhand         = OnhandModel::where('item_code',$request->code)->get();

        if($onhand->count() > 0){
            // $i          = 1;
            // $total      = $request->total;
            // $find       = false;
            // do{
            //     $sum = $total / $i;
            //     if(OnhandModel::where('item_code',$request->code)->where('onhand_quantity','>=',$total)->count() > 0){
            //         if($i == 1){
            //             $onhand_one = OnhandModel::where('item_code',$request->code)->where('onhand_quantity','>=',$total)->first();
            //             $data['lot'][$onhand_one->lot_number] = $onhand_one->lot_number;
            //         }else{
            //             $onhand_for = OnhandModel::where('item_code',$request->code)->where('onhand_quantity','>=',$total)->get();
            //             foreach($onhand_for as $item_onhand){
            //                 $data['lot'][$item_onhand->lot_number] = $item_onhand->lot_number;
            //             }
            //         }
            //         $find = true;
            //     }else{
            //         $i += 1;
            //         $total = $sum;
            //     }

            //     if($i > $onhand->count()){
            //         $data['lot'] = [];
            //         break;
            //     }

            // }while($find = false);

            $data['total_onhand'] = $onhand->sum('onhand_quantity');

            foreach($onhand as $item){
                $list_org[$item->organization_id] = $item->organization_code;
                $data['data'][$item->organization_code]['id']   = $item->organization_id;
                $data['data'][$item->organization_code]['code'] = $item->organization_code;
                $data['data'][$item->organization_code]['name'] = $item->organization_name;
                $data['data'][$item->organization_code]['list'][$item->lot_number] = [
                    'inventory_id'  => $item->inventory_item_id,
                    'org_id'        => $item->organization_id,
                    'org_code'      => $item->organization_code,
                    'org_name'      => $item->organization_name,
                    'lot_number'    => $item->lot_number,
                    'quantity'      => $item->onhand_quantity,
                    'tran_uom'      => $item->transaction_uom_code,
                ];
                $data['data'][$item->organization_code]['subinvt'][$item->subinventory_code] = [
                    'subinventory'  => $item->subinventory_code
                ];
                $data['data'][$item->organization_code]['locator'][$item->locator] = [
                    'locator'       => $item->locator
                ];
            }

            $orderlot       = OrderLotModel::where('order_line_id',$request->line_id)->where('item_code',$request->code)->get();
            if($orderlot->count() > 0){
                $lot_line = 1;
                foreach($orderlot as $item_lot){
                    if($item_lot->inventory_location_id){
                        $invent = OnhandModel::where('item_code',$request->code)->where('inventory_location_id',$item_lot->inventory_location_id)->first();
                    }else{
                        $invent = '';
                    }

                    $data['data_lot'][$list_org[$item_lot->inv_org_id]][$lot_line] = [
                        'id'                    =>  $item_lot->order_lot_id,
                        'lot_number'            =>  $item_lot->lot_number,
                        'inv_org_id'            =>  $item_lot->inv_org_id,
                        'inv_org_code'          =>  $list_org[$item_lot->inv_org_id],
                        'inv_org_name'          =>  $item_lot->inv_org_name,
                        'onhand_quantity'       =>  $item_lot->onhand_quantity,
                        'order_quantity'        =>  $item_lot->order_quantity,
                        'inv_uom_code'          =>  $item_lot->inv_uom_code,
                        'onhand_conv_qty'       =>  $item_lot->onhand_conv_qty,
                        'subinventory_code'     => $item_lot->subinventory_code,
                        'inventory_location_id' => $item_lot->inventory_location_id,
                        'locators'              => !empty($invent)? $invent->locators : ''
                    ];
                    $lot_line++;
                }
            }else{
                $data['data_lot'] = '';
            }

            $data['total'] = count($data['data']);
            // $data['lot_total'] = $i;
            $rest = [
                'status'    => true,
                'data'      => $data,
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'ไม่พบข้อมูล',
            ];
        }
        return \response()->json(['data'=>$rest]);
    }

    public function selectOrgData(Request $request)
    {
        $lot         = OnhandModel::where('item_code',$request->code)
                                    ->where('organization_code',$request->org_code)
                                    ->get();
        if($lot->count() > 0){
            $data = [];
            foreach($lot as $lot_item){
                if(!empty($lot_item->subinventory_code)){
                    $data['subinventory'][$lot_item->subinventory_code] = [
                        'inventory_id'  => $lot_item->inventory_item_id,
                        'org_id'        => $lot_item->organization_id,
                        'org_code'      => $lot_item->organization_code,
                        'org_name'      => $lot_item->organization_name,
                        'lot_number'    => $lot_item->lot_number,
                        'quantity'      => $lot_item->onhand_quantity,
                        'tran_uom'      => $lot_item->transaction_uom_code,
                        'location'      => $lot_item->locators,
                        'subinventory'  => $lot_item->subinventory_code,
                        'locator_id'    => $lot_item->locator_id
                    ];
                }

                if(!empty($lot_item->locators)){
                    $data['locator'][$lot_item->locators] = [
                        'inventory_id'  => $lot_item->inventory_item_id,
                        'org_id'        => $lot_item->organization_id,
                        'org_code'      => $lot_item->organization_code,
                        'org_name'      => $lot_item->organization_name,
                        'lot_number'    => $lot_item->lot_number,
                        'quantity'      => $lot_item->onhand_quantity,
                        'tran_uom'      => $lot_item->transaction_uom_code,
                        'location'      => $lot_item->locators,
                        'subinventory'  => $lot_item->subinventory_code,
                        'locator_id'    => $lot_item->locator_id
                    ];
                }

                if(!empty($lot_item->lot_number)){
                    $data['lot_number'][$lot_item->lot_number] = [
                        'inventory_id'  => $lot_item->inventory_item_id,
                        'org_id'        => $lot_item->organization_id,
                        'org_code'      => $lot_item->organization_code,
                        'org_name'      => $lot_item->organization_name,
                        'lot_number'    => $lot_item->lot_number,
                        'quantity'      => $lot_item->onhand_quantity,
                        'tran_uom'      => $lot_item->transaction_uom_code,
                        'location'      => $lot_item->locators,
                        'subinventory'  => $lot_item->subinventory_code,
                        'locator_id'    => $lot_item->locator_id
                    ];
                }
            }
    
            $rest = [
                'status' => true,
                'data'   => $data 
            ];
        }else{
            $rest = [
                'status' => false,
                'data'   => 'No DAta' 
            ];
        }
      

        return response()->json(['data'=>$rest]);
    }

    public function getDataLotOnhand(Request $request)
    {
        $lot         = OnhandModel::where('item_code',$request->code)
                                    ->where('organization_code',$request->org_code)
                                    ->where(function($query) use($request){
                                        if(!empty($request->subinv)){
                                            $query->where('subinventory_code',$request->subinv);
                                        }
                                        if(!empty($request->locator)){
                                            $query->where('locators',$request->locator);
                                        }
                                        if(!empty($request->lot_number)){
                                            $query->where('lot_number',$request->lot_number);
                                        }
                                    })
                                    ->get();

        if($lot->count() > 0){
            if($lot->count() > 1){
                $total = 0;
                foreach($lot as $lotitem){
                    $total += $lotitem->onhand_quantity;
                }
                $rest = [
                    'status' => true,
                    'data'   => $total
                ];
            }else{
                $rest = [
                    'status' => true,
                    'data'   => $lot[0]->onhand_quantity
                ];
            }
        }else{
            $rest = [
                'status' => false,
                'data'   => 0
            ];
        }

        return response()->json(['data'=>$rest]);

    }

    public function copyDataSaleOrder(Request $request)
    {
        // $year = date('Y') + 543;
        // $year_thai = \substr($year,'-2');
        // $order = PrepareSaleOrderModel::where('prepare_order_number','like', $year_thai.'O%')->orderBy('prepare_order_number','desc')->first();
        // if($order->count() > 0){
        //     $last_nummber = \explode('O',$order->prepare_order_number);
        //     if(is_numeric($last_nummber[1])){
        //         $newnumber = sprintf('%05d', $last_nummber[1]+1);
        //     }else{
        //         $newnumber = sprintf('%05d', 1);
        //     }
        //     $new_preparenumber = $year_thai.'O'.$newnumber;
        // }else{
        //     $new_preparenumber =  $year_thai.'O00001';
        // }

        $result = GenerateNumberRepo::getOrderNumberPrepareSaleOrder();

        if($result['status'] == 'S'){
            $new_preparenumber = $result['sequence_number'];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'มีบางอย่างผิดพลาด',
                'message'   => 'โปรดลองอีกครั้ง'
            ];

            return \response()->json(['data'=>$rest]);
        }


        DB::beginTransaction();
        try{
            $copy                               = PrepareSaleOrderModel::where('order_header_id', $request->header_id)->first();
            $newData                            = $copy->replicate();
            $newData->prepare_order_number      = $new_preparenumber;
            $newData->order_status              = 'Draft';
            $newData->created_by                = optional(auth()->user())->user_id;
            $newData->creation_date             = date('Y-m-d H:i:s');
            $newData->last_updated_by           = optional(auth()->user())->user_id;
            $newData->last_update_date          = date('Y-m-d H:i:s');
            $newData->save();

            $copy_line          = OrderLineModel::where('order_header_id', $request->header_id)->get();

            if($copy_line->count() > 0){
                foreach($copy_line as $copy_line_item){
                    $newLineData                        = $copy_line_item->replicate();
                    $newLineData->order_header_id       = $newData->order_header_id;
                    $newLineData->created_by            = optional(auth()->user())->user_id;
                    $newLineData->creation_date         = date('Y-m-d H:i:s');
                    $newLineData->last_updated_by       = optional(auth()->user())->user_id;
                    $newLineData->last_update_date      = date('Y-m-d H:i:s');
                    $newLineData->save();

                    $copyLot                            = OrderLotModel::where('order_line_id',$copy_line_item->order_line_id)->first();
                    if(!empty($copyLot)){
                        $newLotData                         = $copyLot->replicate();
                        $newLotData->order_line_id          = $newLineData->order_line_id;
                        $newLotData->created_by             = optional(auth()->user())->user_id;
                        $newLotData->creation_date          = date('Y-m-d H:i:s');
                        $newLotData->last_updated_by        = optional(auth()->user())->user_id;
                        $newLotData->last_update_date       = date('Y-m-d H:i:s');
                        $newLotData->save();
                    }
                }
            }

            $rest = [
                'status'    => true,
                'data'      => $newData->prepare_order_number,
            ];

        }catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'มีบางอย่างผิดพลาด',
                'message'   => $e->getMessage()
            ];
        }
        DB::commit();

        return \response()->json(['data'=>$rest]);
    }

    public function sendApprove(Request $request)
    {
        DB::beginTransaction();
        try{
            $prepareorder                           = PrepareSaleOrderModel::where('order_header_id',$request->order_id)->first();
            $prepareorder->payment_approve_flag     = '';
            $prepareorder->order_status             = 'Confirm';
            $prepareorder->last_updated_by          = optional(auth()->user())->user_id;
            $prepareorder->last_update_date         = date('Y-m-d H:i:s');
            $prepareorder->save();

            $test = OrderRepo::insertOrdersHistoryv2( $prepareorder,'Inprocess');

            $rest = [
                'status'        => true,
                'data'          => 'success',
                'status_order'  => 'Confirm',
                'dd'            => $test
            ];
        }catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'มีบางอย่างผิดพลาด',
                'message'   => $e->getMessage()
            ];
        }
        DB::commit();

        return \response()->json(['data'=>$rest]);
    }

    public function orderCanceller(Request $request)
    {
        DB::beginTransaction();
        try{
            $check                  = DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$request->order_id)->first();
            $prepareorder           = PrepareSaleOrderModel::where('order_header_id',$request->order_id)->first();
            if($check){
                if($check->oaom_wms6_inven != 'Y' && $prepareorder->pick_release_status != 'Confirm'){
                    $datatoup = [
                        'so_cancel_reason'  => $request->remarkcancel,
                        'remark'            => $request->remark_list,
                        'order_status'      => 'Cancelled',
                        'last_updated_by'   => optional(auth()->user())->user_id,
                        'last_update_date'  => date('Y-m-d H:i:s'),
                    ];
                    PrepareSaleOrderModel::where('order_header_id',$request->order_id)->update($datatoup);
                    $wms_update = [
                        'record_status' => 'C'
                    ];
                    DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$request->order_id)->update($wms_update);
                    $rest = [
                        'status'        => true,
                        'data'          => 'สำเร็จ',
                        'status_order'  => 'Cancelled'
                    ];
                }else{
                    $rest = [
                        'status'        => false,
                        'data'          => 'ไม่สามารถยกเลิกใบสังซื้อได้',
                    ];
                }
            }else{
                if($prepareorder->pick_release_status != 'Confirm'){
                    $datatoup = [
                        'so_cancel_reason'  => $request->remarkcancel,
                        'remark'            => $request->remark_list,
                        'order_status'      => 'Cancelled',
                        'last_updated_by'   => optional(auth()->user())->user_id,
                        'last_update_date'  => date('Y-m-d H:i:s'),
                    ];
                    PrepareSaleOrderModel::where('order_header_id',$request->order_id)->update($datatoup);

                    $rest = [
                        'status'        => true,
                        'data'          => 'สำเร็จ',
                        'status_order'  => 'Cancelled'
                    ];
                }else{
                    $rest = [
                        'status'        => false,
                        'data'          => 'ไม่สามารถยกเลิกใบสังซื้อได้',
                    ];
                }
            }
            DB::commit();
            return \response()->json(['data'=>$rest]);
        }catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'มีบางอย่างผิดพลาด',
                'message'   => $e->getMessage()
            ];
        }
    }

    public function testcallWMS(Request $request)
    {
        DB::beginTransaction();
        try {
            // pr($request->all());
            $test = GenerateNumberRepo::callWMSPackagePrepareSaleOrder($request->order_header_id,$request->prepare_order_number);

            DB::commit();
            return \response()->json(['data'=>$test]);
        }catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'มีบางอย่างผิดพลาด',
                'message'   => $e->getMessage()
            ];
        }
    }
}
