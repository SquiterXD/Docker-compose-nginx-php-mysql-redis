<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Consignment;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\Customers;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Customers\Domestics\PriceListLine;
use App\Models\OM\TransactionTypeAllV;
use App\Models\OM\AttachFiles;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\AttachmentRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConsignmentBkkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerLists = Customers::active()
        ->whereRaw("upper(sales_classification_code) = 'DOMESTIC'")
        ->whereIn('customer_type_id', [30])
        ->orderBy('customer_number')
        ->get();

        $convertLists = self::getConvertUom();

        return view('om.consignment-bkk.index', compact(
            'customerLists',
            'convertLists',
        ));
    }

    public function store(Request $request)
    {

        \DB::beginTransaction();
        try {

            $consignmentHeader = Consignment::find($request->consignment);
            $date = Carbon::createFromFormat('d/m/Y', $request->date)->subYear(543)->format('Y-m-d');
            $customer_id = $request->customer_id;
            $customer = Customers::find($customer_id);
            $data = json_decode($request->data);

            $orderHeaders = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30])
                    ->where('sales_classification_code', 'Domestic');
            })
            ->when($customer_id, function($q, $customer_id){
                return $q->where('customer_id', $customer_id);
            })
            ->whereIn('product_type_code', [10])
            ->where('pick_release_status', 'Confirm')
            ->where('pick_release_approve_flag', 'Y')
            ->with(['lines.consignmentLines' => function($q){
                return $q->whereHas('header', function ($p){
                    return $p->where('consignment_status', 'Confirm');
                });
            }])
            ->orderBy('pick_release_no')
            ->get();

            $remain_list = [];        
            foreach ($orderHeaders as $key => $header) {
                $has_remain_lines = $header->lines->where('remain_qty', '>', 0);
                if($has_remain_lines->count()){
                    $remain_list[] = $header->order_header_id;
                }
            }
            
            $item_id_list = [];
            $item_list = [];
            $insert_line_lists = [];
            $total_unit_price = $total_actual_qty = $total_actual_amount = 0;
            foreach ($data as $key => $item) {
                $item_id_list[] = $item->item_id;
                $item_list[$item->item_id] = $item->actual;
                $total_actual_qty += $item->actual;
            }

            $orderHeaders = $orderHeaders->whereIn('order_header_id', $remain_list)->values();
            $order_type_id = null;

            foreach ($orderHeaders as $header) {
                foreach ($header->lines as $line) {
                    $total_unit_price += $line->unit_price * $line->approve_quantity;

                    if( array_key_exists($line->item_id, $item_list) ){
                        $item_actual = $item_list[$line->item_id];

                        if(round($item_list[$line->item_id], 4) > 0 && round($line->remain_qty, 4) > 0){

                            $order_type_id = $header->order_type_id;
                            $insert_line_lists[$line->item_code]['lines'][$line->order_line_id]['line'] = $line;

                            if( $item_list[$line->item_id] > $line->remain_qty){
                                $insert_line_lists[$line->item_code]['lines'][$line->order_line_id]['actual'] = $line->remain_qty;
                                $total_actual_amount += $line->unit_price * $line->remain_qty;
                                $item_list[$line->item_id] = $item_list[$line->item_id] - $line->remain_qty;
                            }else {
                                $insert_line_lists[$line->item_code]['lines'][$line->order_line_id]['actual'] = $item_list[$line->item_id];
                                $total_actual_amount += $line->unit_price * $item_list[$line->item_id];
                                $item_list[$line->item_id] = $item_list[$line->item_id] - $item_list[$line->item_id];
                            }
                        }

                        if( array_key_exists($line->item_code, $insert_line_lists) ){

                            if( array_key_exists('qty', $insert_line_lists[$line->item_code]) ){
                                $insert_line_lists[$line->item_code]['qty'] += $line->approve_quantity;
                            }else {
                                $insert_line_lists[$line->item_code]['qty'] = $line->approve_quantity;
                            }

                            if( array_key_exists('previous', $insert_line_lists[$line->item_code]) ){
                                $insert_line_lists[$line->item_code]['previous'] += $line->remain_qty;
                            }else {
                                $insert_line_lists[$line->item_code]['previous'] = $line->remain_qty;
                            }

                            if( !array_key_exists('item_actual', $insert_line_lists[$line->item_code]) ){
                                $insert_line_lists[$line->item_code]['item_actual'] = $item_actual;
                            }
                        }
                    }
                }
            }
            ksort($insert_line_lists);

            $created_by = getDefaultData('/users')->user_id;
            $now = Carbon::now();

            if(!!$consignmentHeader){

                $consingment_no = $consignmentHeader->consignment_no;
                $consignmentHeader->consignment_date = $date;
                $consignmentHeader->total_unit_price_amount = round($total_unit_price, 2);
                $consignmentHeader->total_consignment_amount = round($total_actual_qty, 2);
                $consignmentHeader->total_amount =  round($total_actual_amount, 2);
                $consignmentHeader->last_updated_by = $created_by;
                $consignmentHeader->last_update_date = $now;
                $consignmentHeader->interface_status = null;
                $consignmentHeader->save();

                $consignmentLine = ConsignmentLines::where('consignment_header_id', $consignmentHeader->consignment_header_id)->delete();

            }else {

                $consingment_no = GenerateNumberRepo::generateConsignmentNo('OMP0038_F_NUM_DOM');

                $consignmentHeader = new Consignment;
                $consignmentHeader->consignment_no = $consingment_no;
                $consignmentHeader->consignment_date = $date;
                $consignmentHeader->consignment_status = 'Confirm';
                $consignmentHeader->customer_id = $customer_id;
                $consignmentHeader->customer_number = $customer->customer_number;
                $consignmentHeader->order_type_id = $order_type_id;
                $consignmentHeader->total_unit_price_amount = round($total_unit_price, 2);
                $consignmentHeader->total_consignment_amount = round($total_actual_qty, 2);
                $consignmentHeader->total_amount =  round($total_actual_amount, 2);
                $consignmentHeader->program_code = 'OMP0038';
                $consignmentHeader->created_by = $created_by;
                $consignmentHeader->created_by_id = $created_by;
                $consignmentHeader->creation_date = $now;
                $consignmentHeader->created_at = $now;
                $consignmentHeader->last_updated_by = $created_by;
                $consignmentHeader->last_update_date = $now;
                $consignmentHeader->save();
            }

            $vat_amount = 0;
            $total_commis_amount = 0;
            foreach ($insert_line_lists as $item) {
                $qty = $item['qty'];
                $previous = $item['previous'];
                $item_actual = $item['item_actual'];

                foreach ($item['lines'] as $value) {
                    $line = $value['line'];
                    $actual = $value['actual'];

                    $consignmentLine = new ConsignmentLines;
                    $consignmentLine->consignment_header_id = $consignmentHeader->consignment_header_id;
                    $consignmentLine->order_header_id = $line->order_header_id;
                    $consignmentLine->order_line_id = $line->order_line_id;
                    $consignmentLine->item_id = $line->item_id;
                    $consignmentLine->item_code = $line->item_code;
                    $consignmentLine->item_description = $line->item_description;
                    $consignmentLine->quantity = round($qty, 2);
                    $consignmentLine->previous_quantity = round($previous, 2);
                    $consignmentLine->remaining_quantity = round($previous - $item_actual, 2);
                    $consignmentLine->actual_quantity =  round($actual, 2);
                    $consignmentLine->attribute1 = optional($line->seqEcom)->product_type_code == '20' ? 'PTN' : 'CGK';
                    $consignmentLine->attribute2 = $line->promo_flag;
                    $consignmentLine->attribute3 = $line->attribute1;
                    $consignmentLine->program_code = 'OMP0038';
                    $consignmentLine->created_by = $created_by;
                    $consignmentLine->creation_date = $now;
                    $consignmentLine->last_updated_by = $created_by;
                    $consignmentLine->last_update_date = $now;
                    $consignmentLine->created_at = $now;
                    $consignmentLine->created_by_id = $created_by;

                    $operand = optional(PriceListLine::whereHas('priceList', function($q){
                        return $q->where('name', 'ราคาโรงงาน')
                            ->where('attribute1', 'DOMESTIC');
                    })
                    ->where('product_uom_code', $line->uom_code)
                    ->where('item_id', $line->item_id)
                    ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                    ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                    ->first())->operand ?? 0;

                    $price = optional(PriceListLine::whereHas('priceList', function($q){
                        return $q->where('name', 'ราคาขายปลีก')
                            ->where('attribute1', 'DOMESTIC');
                    })
                    ->where('product_uom_code', $line->uom_code)
                    ->where('item_id', $line->item_id)
                    ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                    ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                    ->first())->operand ?? 0;
                    $tranType = TransactionTypeAllV::where('order_type_id', $order_type_id)->first();

                    $vat_amount += $consignmentLine->actual_quantity * $price * $tranType->tax_rate/( 100+$tranType->tax_rate );
                    $commis_amount = $actual * ($line->unit_price - $operand) * 95/100;
                    $consignmentLine->line_commis_amount = round($commis_amount, 2);
                    $total_commis_amount += $commis_amount;

                    $tax_amount = ($consignmentLine->actual_quantity * $consignmentLine->attribute3) * $tranType->tax_rate/( 100+$tranType->tax_rate );
                    $consignmentLine->line_tax_amount = $tax_amount;
                    
                    $consignmentLine->save();
                }
            }

            $consignmentHeader->vat_amount = round($vat_amount, 2);
            $consignmentHeader->total_include_vat = round($total_actual_amount, 2);
            $consignmentHeader->commission_amount = round($total_commis_amount, 2);
            $consignmentHeader->save();

            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment, $consignmentHeader->consignment_header_id, 'OMP0038');
            }

            $result = GenerateNumberRepo::callWMSPackageConsignment($consignmentHeader->consignment_header_id, $consingment_no);

            if($result['o_result'] == 'Completed'){
                $data = [
                    'status' => 'S',
                    'msg' => 'success',
                    'consignment' => $consignmentHeader->consignment_header_id,
                ];
            }else {
                $consignmentHeader->consignment_status = 'Draft';
                $consignmentHeader->save();
                $data = [
                    'status' => 'E',
                    'msg' => 'Error Interface WMS',
                ];
            }

            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            \Log::error($e->getMessage());
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($data);
    }

    public function attach(Request $request)
    {
        $consignment = Consignment::with('attach')->find($request->consignment);
        $now = Carbon::now();

        if($request->has('check_attachment')){
            $attach_files = AttachFiles::where('header_id', $consignment->consignment_header_id)
                ->where('attachment_program_code', 'OMP0038')
                ->whereNotIn('attachment_id', $request->check_attachment)
                ->whereNull('deleted_at')
                ->get();

            foreach ($attach_files as $attach) {
                $attach->deleted_at = $now;
                $attach->save();
            }
        }else {
            $attach_files = AttachFiles::where('header_id', $consignment->consignment_header_id)
                ->where('attachment_program_code', 'OMP0038')
                ->whereNull('deleted_at')
                ->get();
            foreach ($attach_files as $attach) {
                $attach->deleted_at = $now;
                $attach->save();
            }
        }
        if($request->hasFile('attachment')) {
            $fileAttachment = $request->file('attachment');
            AttachmentRepo::uploadAttachmentMultiple($fileAttachment, $consignment->consignment_header_id, 'OMP0038');
        }

        $data = [
            'status' => 'S',
            'message' => 'success'
        ];
        return response()->json($data);
    }

    public function getOrderHeader(Request $request)
    {
        $orderHeaders = OrderHeader::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30])
                ->where('sales_classification_code', 'Domestic');
        })
        ->where('customer_id', $request->customer)
        ->whereIn('product_type_code', [10])
        ->whereRaw("UPPER(order_status) = 'CONFIRM'")
        ->whereRaw("UPPER(pick_release_status) = 'CONFIRM'")
        ->whereRaw("UPPER(pick_release_approve_flag) = 'Y'")
        ->with(['lines' => function($q){
            return $q->where(function ($p){
                return $p->whereNull('promo_flag')
                    ->orWhere('promo_flag', '!=', 'Y');
            })->with([
                'consignmentLines' => function($q){
                    return $q->whereHas('header', function ($p){
                        return $p->where('consignment_status', 'Confirm');
                    });
                }, 
                'seqEcom'
            ]);
        }])
        ->orderBy('pick_release_no')
        ->get();

        $remain_list = [];        
        foreach ($orderHeaders as $key => $header) {
            $has_remain_lines = $header->lines->where('remain_qty', '>', 0);
            if($has_remain_lines->count()){
                $remain_list[] = $header->order_header_id;
            }
        }

        $orderHeaders = $orderHeaders->whereIn('order_header_id', $remain_list)->values();

        return response()->json($orderHeaders);
    }

    public function getConsignment(Request $request)
    {
        $consignment_id = $request->consignment_id;
        $consignment_no = $request->consignment_no;

        $consignmentLists = Consignment::where(function ($q){
            return $q->whereHas('orderHeader.customer', function($p){
                return $p->whereIn('customer_type_id', [30])
                    ->where('sales_classification_code', 'Domestic');
            })
            ->orWhereHas('customer', function($p){
                return $p->whereIn('customer_type_id', [30])
                    ->where('sales_classification_code', 'Domestic');
            });
        })
        ->when($consignment_id, function($q, $consignment_id){
            return $q->where('consignment_header_id', $consignment_id);
        })
        ->when($consignment_no, function($q, $consignment_no){
            return $q->where('consignment_no', 'like', '%'.$consignment_no.'%');
        })
        ->orderBy('consignment_no', 'desc')
        ->with('orderHeader.customer', 'lines.uom', 'lines.orderLine', 'lines.seqEcom', 'customer', 'attach')
        ->limit(50)
        ->get();

        return response()->json($consignmentLists);
    }

    public function getCustomers(Request $request)
    {
        $customers = Customers::active()
        ->whereRaw("upper(sales_classification_code) = 'DOMESTIC'")
        ->whereIn('customer_type_id', [30])
        ->orderBy('customer_number')
        ->get();

        return response()->json($customers);
    }

    private static function getConvertUom()
    {
        $data = [
            collect([
                'product_type_code' => '10',
                'from_uom' => 'PTN',
                'to_uom' => 'CGK',
                'conversion_rate' => 0.20,
            ]),
            collect([
                'product_type_code' => '10',
                'from_uom' => 'CGK',
                'to_uom' => 'PTN',
                'conversion_rate' => 5,
            ]),
            collect([
                'product_type_code' => '20',
                'from_uom' => 'PTN',
                'to_uom' => 'CGK',
                'conversion_rate' => 12,
            ]),
            collect([
                'product_type_code' => '20',
                'from_uom' => 'CGK',
                'to_uom' => 'PTN',
                'conversion_rate' => 0.0833333333333333,
            ])
        ];

        return $data;
    }
}
