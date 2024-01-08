<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\ConsignmentClub\ConsignmentLines;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\Customers\Domestics\PriceListLine;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Repositories\OM\AttachmentRepo;
use App\Models\OM\AttachFiles;
use App\Models\OM\Consignment;
use App\Repositories\OM\GenerateNumberRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsignmentClubAjaxController extends Controller
{
    public function createConsignment(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $rest = [];
        $orderHeadersData = [];
        $orderLinesData = [];

        $orderHeaderQuery       = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->where('ptom_order_headers.pick_release_no', $request->pick_release_num)
                                                ->whereNull('ptom_order_headers.deleted_at')
                                                ->first();

        if (!empty($orderHeaderQuery->order_header_id)) {

            $orderHeadersData   = [
                'order_header_id'           => $orderHeaderQuery->order_header_id,
                'pick_release_no'           => $orderHeaderQuery->pick_release_no,
                'pick_release_status'       => $orderHeaderQuery->pick_release_status,
                'pick_release_approve_date' => !empty($orderHeaderQuery->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($orderHeaderQuery->pick_release_approve_date))) : $orderHeaderQuery->pick_release_approve_date,
                'customer_id'               => $orderHeaderQuery->customer_id,
                'customer_number'           => $orderHeaderQuery->customer_number,
                'customer_name'             => $orderHeaderQuery->customer_name,
                'total_unit_price_amount'   => $orderHeaderQuery->grand_total,
                'total_consignment_amount'  => 0,
                'total_amount'              => 0
            ];


            $orderLinesQuery    = OrderLines::where('order_header_id', $orderHeaderQuery->order_header_id)
                                            ->Where(function($query) {
                                                $query->whereNull('promo_flag')
                                                    ->orWhere('promo_flag', '!=', 'Y');
                                            })
                                            ->whereNull('deleted_at')
                                            ->get();

            if(!empty($orderLinesQuery)){
                foreach ($orderLinesQuery as $key => $value) {

                    // $orderLinesQuery    = OrderLines::select('uom', 'total_amount')->where('order_line_id', $value->order_line_id)->first();

                    // $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                    //                             ->select('ptom_price_list_line_v.operand')
                    //                             ->where('ptom_price_list_line_v.item_id', $value->item_id)
                    //                             ->where('ptom_price_list_line_v.product_uom_code', $value->uom_code)
                    //                             ->where('ptom_price_list_head_v.attribute1', 'DOMESTIC')
                    //                             ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                    //                             ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                    //                             ->where(function($query){
                    //                                 $query->where('ptom_price_list_head_v.name', 'ราคาขายปลีก');
                    //                                     // ->orWhere('ptom_price_list_head_v.name', 'ราคาโรงงาน');
                    //                             })
                    //                             ->first();

                    // $newOperand         = !empty($priceListQuery->operand) ? $priceListQuery->operand : 0;

                    $sumActual          = ConsignmentLines::where('order_header_id', $orderHeaderQuery->order_header_id)->where('item_id', $value->item_id)->whereNull('deleted_at')->sum('actual_quantity');

                    // $sumActual          = ConsignmentLines::join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', '=', 'ptom_consignment_headers.consignment_header_id')
                    //                                     ->where('ptom_consignment_lines.order_header_id', $orderHeaderQuery->order_header_id)
                    //                                     ->where('ptom_consignment_lines.item_id', $value->item_id)
                    //                                     ->where('ptom_consignment_headers.consignment_status', '!=', 'Cancelled')
                    //                                     ->whereNull('ptom_consignment_lines.deleted_at')
                    //                                     ->sum('ptom_consignment_lines.actual_quantity');

                    $cancelledActual    = ConsignmentLines::join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', '=', 'ptom_consignment_headers.consignment_header_id')
                                            ->where('ptom_consignment_lines.order_header_id', $orderHeaderQuery->order_header_id)
                                            ->where('ptom_consignment_lines.item_id', $value->item_id)
                                            ->where('ptom_consignment_headers.consignment_status', '=', 'Cancelled')
                                            ->sum('ptom_consignment_lines.actual_quantity');

                    // $sumActual  = (float)$sumActual - (float)$cancelledActual;

                    $approveQuantity    = !empty($value->approve_quantity) ? $value->approve_quantity : 0;
                    $resultRemaining    = ((float)$approveQuantity - (float)$sumActual) + (float)$cancelledActual;

                    // echo '<pre>';
                    // print_r($priceListQuery->operand);
                    // echo '<pre>';
                    // exit();

                    $orderLinesData[] = [
                        'consignment_line_id'       => $value->order_line_id,
                        'line_number'               => $key+1,
                        'item_id'                   => $value->item_id,
                        'item_code'                 => $value->item_code,
                        'item_description'          => $value->item_description,
                        'uom'                       => !empty($value->uom) ? $value->uom : '',
                        'quantity'                  => $approveQuantity,
                        'total_amount'              => !empty($value->total_amount) ? $value->total_amount : 0,
                        'previous_quantity'         => $resultRemaining,
                        'remaining_quantity'        => $resultRemaining,
                        'unit_price'                => !empty($value->unit_price) ? $value->unit_price : 0,
                        'actual_quantity'           => '0.00',
                    ];
                }
            }

            // echo '<pre>';
            // print_r($sumActual);
            // echo '<pre>';
            // exit();



            $rest = [
                'status'                    => 'success',
                'data'                      => $orderHeadersData,
                'orderLinesData'            => $orderLinesData,
            ];

        }else{
            $rest = [
                'status'                    => 'fail',
                'data'                      => $orderHeadersData,
                'orderLinesData'            => $orderLinesData,
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function getOrderLines($orderHeaderID)
    {
        $getOrderLine = OrderLines::where('order_header_id', $orderHeaderID)->Where(function($query) {
                                $query->whereNull('promo_flag')
                                    ->orWhere('promo_flag', '!=', 'Y');
                            })->whereNull('deleted_at')->orderBy('line_number')->get();

        $orderLineList              = [];
        $totalUnitPriceAmount       = 0.00;
        $totalConsignmentAmount     = 0.00;
        $totalAmount                = 0.00;

        if (!empty($getOrderLine)) {
            foreach ($getOrderLine as $key => $value) {
                $orderLineList[] = [
                    'order_line_id'         => $value->order_line_id,
                    'line_number'           => $key+1,
                    'item_id'               => $value->item_id,
                    'item_code'             => $value->item_code,
                    'item_description'      => $value->item_description,
                    'uom'                   => $value->uom,
                    'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                    'total_amount'          => $value->total_amount,
                ];

                $totalUnitPriceAmount       = (float)$totalUnitPriceAmount + (float)$value->total_amount;
                $totalAmount                = (float)$totalAmount + (float)$value->total_amount;
            }
        }

        $rest = [
            'status'                    => 'success',
            'data'                      => $orderLineList,
            'totalUnitPriceAmount'      => (float)$totalUnitPriceAmount,
            'totalConsignmentAmount'    => (float)$totalConsignmentAmount,
            'totalAmount'               => (float)$totalAmount
        ];

        return response()->json(['data' => $rest]);
    }

    public function searConsignment(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $rest = [];
        $consignmentData = [];
        $consignmentLines = [];
        $attachmentFile = [];

        $getConsignmentQuery = ConsignmentHeader::where(function($query) use($request) {
                                                    if(!empty($request->consignment_header_id)) {
                                                        $query->where('consignment_header_id', $request->consignment_header_id);
                                                    }
                                                    if(!empty($request->consignment_no)) {
                                                        $query->where('consignment_no', $request->consignment_no);
                                                    }
                                                    if(!empty($request->customer_id)) {
                                                        $query->where('customer_id', $request->customer_id);
                                                    }
                                                    if(!empty($request->pick_release_num)) {
                                                        $query->where('pick_release_num', $request->pick_release_num);
                                                    }
                                                })
                                                ->whereNull('deleted_at')->first();


        if(!empty($getConsignmentQuery->consignment_no)){
            $orderHeaderQuery    = OrderHeaders::select('customer_id', 'order_header_id')->where('pick_release_no', $getConsignmentQuery->pick_release_num)->first();
            $customersQuery      = Customers::select('customer_number', 'customer_name')->where('customer_id', $orderHeaderQuery->customer_id)->first();

            $loopcheck = true;
            $dateConsignment = Carbon::createFromFormat('Y-m-d H:i:s', $getConsignmentQuery->consignment_date)->addDay('-2');
            do {
                if($dateConsignment->format('D') == 'Sat' || $dateConsignment->format('D') == "Sun") {
                    $dateConsignment->addDay(1);
                    continue;
                }
                
                $checkDateHoliday = DB::table('PTPP_HOLIDAY_V')->whereRaw("TRUNC(hol_date) = TO_DATE('{$dateConsignment->format('m/d/Y')}', 'MM/DD/YYYY')")->first();
                if($checkDateHoliday)  {
                    $dateConsignment->addDay(1);
                    continue;
                }
                $loopcheck = false;
            }while($loopcheck);


            $consignmentData = [
                'consignment_header_id'     => $getConsignmentQuery->consignment_header_id,
                'consignment_no'            => $getConsignmentQuery->consignment_no,
                'consignment_date'          => $dateConsignment->addYears(543)->format('d/m/Y'),
                'consignment_status'        => $getConsignmentQuery->consignment_status,
                'pick_release_num'          => $getConsignmentQuery->pick_release_num,
                'pick_release_date'         => !empty($getConsignmentQuery->pick_release_date) ? date('m/d/Y',strtotime($getConsignmentQuery->pick_release_date)) : $getConsignmentQuery->pick_release_date,
                'customer_number'           => !empty($customersQuery->customer_number) ? $customersQuery->customer_number : '',
                'customer_name'             => !empty($customersQuery->customer_name) ? $customersQuery->customer_name : '',
                'total_unit_price_amount'   => number_format((float)$getConsignmentQuery->total_unit_price_amount, 2, '.', ''),
                'total_consignment_amount'  => number_format((float)$getConsignmentQuery->total_consignment_amount, 1, '.', ''),
                'total_amount'              => number_format((float)$getConsignmentQuery->total_amount, 2, '.', ''),
            ];

            $consignmentLinesQuery  = ConsignmentLines::where('consignment_header_id', $getConsignmentQuery->consignment_header_id)->whereNull('deleted_at')->get();

            $totalUnitPriceAmount   = 0;
            $totalAmount            = 0;

            if(!empty($consignmentLinesQuery)){
                foreach ($consignmentLinesQuery as $key => $value) {

                    $orderLinesQuery    = OrderLines::select('item_id', 'uom', 'uom_code', 'total_amount', 'unit_price')->where('order_line_id', $value->order_line_id)->Where(function($query) {
                                                    $query->whereNull('promo_flag')
                                                        ->orWhere('promo_flag', '!=', 'Y');
                                                })->first();

                    $lineTotalAmount    = !empty($orderLinesQuery->total_amount) ? $orderLinesQuery->total_amount : 0;
                    $unitPrice          = !empty($orderLinesQuery->unit_price) ? $orderLinesQuery->unit_price : 0;

                    if ($unitPrice == 0) {
                        $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                    ->select('ptom_price_list_line_v.operand')
                                                    ->where('ptom_price_list_line_v.item_id', $orderLinesQuery->item_id)
                                                    ->where('ptom_price_list_line_v.product_uom_code', $orderLinesQuery->uom_code)
                                                    ->where('ptom_price_list_head_v.attribute1', 'DOMESTIC')
                                                    ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                                    ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                                    ->where(function($query){
                                                        $query->where('ptom_price_list_head_v.name', 'ราคาขายปลีก');
                                                            // ->orWhere('ptom_price_list_head_v.name', 'ราคาโรงงาน');
                                                    })
                                                    ->first();

                        $unitPrice         = !empty($priceListQuery->operand) ? $priceListQuery->operand : 0;
                    }

                    // $sumActual          = ConsignmentLines::where('order_header_id', $getConsignmentQuery->order_header_id)->where('item_id', $value->item_id)->whereNull('deleted_at')->sum('actual_quantity');
                    // $previousQuantity   = !empty($value->previous_quantity) ? number_format((float)$value->previous_quantity, 1, '.', '') : 0;
                    // $actualQuantity     = !empty($value->actual_quantity) ? number_format((float)$value->actual_quantity, 1, '.', '') : 0;
                    // $resultRemaining    = ((float)$previousQuantity - (float)$sumActual);

                    $sumActual          = ConsignmentLines::where('order_header_id', $orderHeaderQuery->order_header_id)->where('item_id', $value->item_id)->whereNull('deleted_at')->sum('actual_quantity');
                    $approveQuantity    = !empty($value->quantity) ? $value->quantity : 0;
                    $resultRemaining    = (float)$approveQuantity;

                    $cancelledActual    = ConsignmentLines::join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', '=', 'ptom_consignment_headers.consignment_header_id')
                                            ->where('ptom_consignment_lines.order_header_id', $orderHeaderQuery->order_header_id)
                                            ->where('ptom_consignment_lines.item_id', $value->item_id)
                                            ->where('ptom_consignment_headers.consignment_status', '=', 'Cancelled')
                                            ->sum('ptom_consignment_lines.actual_quantity');

                    $sumActual  = (float)$sumActual - (float)$cancelledActual;

                    $newPrevious        = (float)$resultRemaining - (float)$sumActual;

                    $consignmentLines[] = [
                        'consignment_line_id'       => $value->consignment_line_id,
                        'line_number'               => $key+1,
                        'item_id'                   => $value->item_id,
                        'item_code'                 => $value->item_code,
                        'item_description'          => $value->item_description,
                        'uom'                       => !empty($orderLinesQuery->uom) ? $orderLinesQuery->uom : '',
                        'quantity'                  => $value->quantity,
                        'total_amount'              => $lineTotalAmount,
                        'previous_quantity'         => number_format($value->previous_quantity, 1, '.', ''),
                        'remaining_quantity'        => number_format((float)$value->remaining_quantity, 1, '.', ''),
                        'actual_quantity'           => number_format((float)$value->actual_quantity, 1, '.', ''),
                        'unit_price'                => $unitPrice
                    ];

                    $totalUnitPriceAmount   = $totalUnitPriceAmount + $lineTotalAmount;
                    $totalAmount            = $totalAmount + ($unitPrice * $value->actual_quantity);
                }

                $attachmentFile = AttachFiles::where('attachment_program_code','OMP0038')->where('header_id',$getConsignmentQuery->consignment_header_id)->whereNull('deleted_at')->get();
            }

            $consignmentData['total_unit_price_amount'] = $totalUnitPriceAmount;
            $consignmentData['total_amount']            = $totalAmount;



            $rest = [
                'status'                    => 'success',
                'data'                      => $consignmentData,
                'consignmentLines'          => $consignmentLines,
                'attachmentFile'            => $attachmentFile
            ];

        }else{
            $rest = [
                'status'                    => 'false',
                'data'                      => $consignmentData,
                'consignmentLines'          => $consignmentLines,
                'attachmentFile'            => $attachmentFile
            ];
        }

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        return response()->json(['data' => $rest]);
    }

    public function updateConsignment(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if(!empty($request->consignment_no)){

            $newConsingmentNo = $request->consignment_no;

            $consignmentQuery = ConsignmentHeader::where('consignment_no', $request->consignment_no)->where('consignment_status','Draft')->whereNull('deleted_at')->first();

            // วันที่บันทึก
            if(!empty($request->consignment_date)){
                $dateArr    = explode('/', $request->consignment_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $consignmentTime = strtotime($newDate);
                $consignmentDate = date('Y-m-d H:i:s',$consignmentTime);
            }else{
                $consignmentDate = '';
            }

            // วันที่ขน
            if(!empty($request->pick_release_date_input)){
                $dateArr    = explode('/', $request->pick_release_date_input);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $releaseTime = strtotime($newDate);
                $releaseDate = date('Y-m-d H:i:s',$releaseTime);
            }else{
                $releaseDate = '';
            }

            $orderHeaderQuery   = OrderHeaders::where('pick_release_no', $request->pick_release_num)->whereNull('deleted_at')->first();

            $customerID         = $orderHeaderQuery->customer_id;
            $customersQuery     = Customers::where('customer_id', $customerID)->first();
            $customersVat       = $customersQuery->vat_code;

            if ($customersVat != '') {
                $taxCodeQuery   = TaxCode::select('percentage_rate')->where('tax_rate_code', $customersVat)->first();
                $percentageRate = $taxCodeQuery->percentage_rate;
            }else{
                $percentageRate = 7;
            }

            // $vatAmount          = str_replace(',', '',$request->total_amount) * $percentageRate / 107;
            $totalIncludeVat    = str_replace(',', '',$request->total_amount);
            $commissionAmount   = 0;

            // $vatAmount          = number_format((float)$vatAmount, 2, '.', '');
            $totalIncludeVat    = number_format((float)$totalIncludeVat, 2, '.', '');

            $totalAmountForcalVat   = 0;
            if (!empty($request->consignment_line_id)) {
                foreach ($request->consignment_line_id as $key => $value) {
                    $itemQuery      = SequenceEcom::where('item_code', $request->item_code[$key])->first();
                    $itemID         = $itemQuery->item_id;

                    $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                ->select('operand')
                                                ->where('item_id', $itemID)
                                                ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                                ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                                ->where(function($query){
                                                    $query->where('name', 'ราคาขายส่ง')
                                                        ->orWhere('name', 'ราคาโรงงาน');
                                                })->orderBy('name', 'DESC')->get();

                    $priceList1 = !empty($priceListQuery[0]->operand) ? $priceListQuery[0]->operand : 0;
                    $priceList2 = !empty($priceListQuery[1]->operand) ? $priceListQuery[1]->operand : 0;

                    $commissionAmount       = (float)$commissionAmount + ((((floatval(str_replace(',', '',$request->actual_quantity[$key])) * ($priceList2 - $priceList1)) * 95) * 0.01 ));
                    $commissionAmount       = number_format((float)$commissionAmount, 2, '.', '');

                    // Cal vat
                    $getOperand = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                ->select('ptom_price_list_line_v.operand')
                                                ->where('ptom_price_list_line_v.item_id', $itemID)
                                                ->where('ptom_price_list_head_v.name', 'ราคาขายปลีก')
                                                ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                                ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                                ->first();

                    $vatOperand             = !empty($getOperand->operand) ? $getOperand->operand : 0;
                    $vatActual              = floatval(str_replace(',', '',$request->actual_quantity[$key])) * $vatOperand;
                    $totalAmountForcalVat   = $totalAmountForcalVat + $vatActual;

                }
            }

            $vatAmount  = $totalAmountForcalVat * $percentageRate / 107;
            $vatAmount  = number_format((float)$vatAmount, 2, '.', '');

            // print_r($vatAmount);exit();

            $update = [
                'customer_id'               => $orderHeaderQuery->customer_id,
                'customer_number'           => $customersQuery->customer_number,
                'order_type_id'             => $orderHeaderQuery->order_type_id,
                'consignment_date'          => $consignmentDate,
                'pick_release_num'          => $request->pick_release_num,
                'pick_release_date'         => $releaseDate,
                'order_header_id'           => $orderHeaderQuery->order_header_id,
                'consignment_status'        => $request->consignment_status,
                'total_unit_price_amount'   => str_replace(',', '',$request->total_unit_price_amount),
                'total_consignment_amount'  => str_replace(',', '',$request->total_consignment_amount),
                'total_amount'              => str_replace(',', '',$request->total_amount),
                'vat_amount'                => $vatAmount,
                'total_include_vat'         => str_replace(',', '',$totalIncludeVat),
                'commission_amount'         => $commissionAmount > 0 ? number_format((float)$commissionAmount, 2, '.', '') : 0,
                'program_code'              => 'OMP0038',
                'updated_by_id'             => optional(auth()->user())->user_id,
                'updated_at'                => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s')
            ];

            // echo '<pre>';
            // print_r($update);
            // echo '<pre>';
            // exit();

            try {
                ConsignmentHeader::where('consignment_no', $request->consignment_no)->update($update);

                if ($request->consignment_status == 'Confirm') {
                    $interface = GenerateNumberRepo::callWMSPackageConsignment($consignmentQuery->consignment_header_id, $request->consignment_no);
                    if($interface['o_result'] != 'Completed') {
                      abort(500, 'Interface WMS ไม่ผ่าน กรุณาตรวจสอบแล้วลองใหม่อีกใครภายหลัง');
                    }
                }
            } catch (\Throwable $th) {
                $update = [
                    'consignment_status'        => 'Draft',
                ];
                ConsignmentHeader::where('consignment_no', $request->consignment_no)->update($update);
                return response()->json(['status' => false,'message' => $th->getMessage()], 500);
            }
            
            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$consignmentQuery->consignment_header_id,'OMP0038');
            }



            if (!empty($request->consignment_line_id)) {
                foreach ($request->consignment_line_id as $key => $valueLine) {

                    // Remainign Quantity
                    if (!empty($request->remaining_quantity[$key])) {
                        $remainingReplace    = str_replace(',', '', $request->remaining_quantity[$key]);
                        // $remainingExplode    = explode('.', $remainingReplace);
                        $remaining           = !empty($remainingReplace) ? $remainingReplace : 0;
                    }else{
                        $remaining           = 0;
                    }

                    // Actual Quantity
                    if (!empty($request->actual_quantity[$key])) {
                        $actualReplace    = str_replace(',', '', $request->actual_quantity[$key]);
                        // $actualExplode    = explode('.', $actualReplace);
                        $actual           = !empty($actualReplace) ? $actualReplace : 0;
                    }else{
                        $actual           = 0;
                    }

                    // if ($request->consignment_status == 'Confirm') {
                    //     $resultRemaining = (float)$remaining;
                    // }else{
                    //     $resultRemaining = (float)$remaining;
                    // }

                    $orderLineID    = ConsignmentLines::where('consignment_line_id', $key)->pluck('order_line_id')->first();
                    $promoFlag      = OrderLines::where('order_line_id', $orderLineID)->pluck('promo_flag')->first();

                    $updateLine = [
                        'remaining_quantity'        => $remaining,
                        'actual_quantity'           => $actual,
                        'attribute1'                => 'CGK',
                        'attribute2'                => $promoFlag,
                        'program_code'              => 'OMP0038',
                        'updated_by_id'             => optional(auth()->user())->user_id,
                        'updated_at'                => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];

                    // echo '<pre>';
                    // print_r($updateLine);
                    // echo '<pre>';

                    ConsignmentLines::where('consignment_line_id', $key)->update($updateLine);
                }
            }

            $consignmentNoList      = ConsignmentHeader::join('ptom_order_headers', 'ptom_consignment_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                                    ->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                    ->select(
                                                        'ptom_consignment_headers.consignment_header_id',
                                                        'ptom_consignment_headers.consignment_no',
                                                        'ptom_consignment_headers.consignment_status',
                                                        'ptom_consignment_headers.pick_release_num',
                                                        'ptom_consignment_headers.consignment_date',
                                                        'ptom_order_headers.pick_release_approve_date',
                                                        'ptom_customers.customer_number',
                                                        'ptom_customers.customer_name'
                                                    )
                                                    ->where('ptom_customers.customer_type_id', 40)
                                                    ->whereNull('ptom_consignment_headers.deleted_at')->orderBy('consignment_no', 'desc')->get();



            if (!empty($consignmentNoList)) {
                foreach ($consignmentNoList as $key => $value) {

                    // $previous   = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('previous_quantity');
                    // $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                    // $remaining  = $previous - $actual;

                    $consignmentNoList[$key]->consignment_date          = !empty($value->consignment_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->consignment_date))) : $value->consignment_date;
                    $consignmentNoList[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date;
                }
            }

            // NEW PICK RELEASE NO
            $orderHeadersQuery       = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->where('ptom_order_headers.pick_release_status', 'Confirm')
                                                ->where('ptom_order_headers.pick_release_approve_flag', 'Y')
                                                ->where('ptom_order_headers.product_type_code', 10)
                                                ->where('ptom_customers.customer_type_id', 40)
                                                // ->Where(function($query) {
                                                //     $query->where('ptom_customers.customer_type_id', 30)
                                                //         ->orWhere('ptom_customers.customer_type_id', 40);
                                                // })
                                                ->where('ptom_customers.sales_classification_code', 'Domestic')
                                                ->select(
                                                    'ptom_order_headers.order_header_id',
                                                    'ptom_order_headers.pick_release_no',
                                                    'ptom_order_headers.pick_release_approve_date',
                                                    'ptom_order_headers.pick_release_status',
                                                    'ptom_order_headers.customer_id',
                                                    'ptom_customers.customer_number',
                                                    'ptom_customers.customer_name',
                                                )
                                                ->orderBy('ptom_order_headers.pick_release_no', 'desc')->get();

            if (!empty($orderHeadersQuery)) {
                foreach ($orderHeadersQuery as $key => $value) {

                    // $consignmentLineQuery   = ConsignmentLines::where('order_header_id', $value->order_header_id)->get();

                    // $previous = 0;

                    // if (!empty($consignmentLineQuery)) {
                    //     foreach ($consignmentLineQuery as $key => $conline) {
                    //         if ($key == 0) {
                    //             $previous   = $conline->previous_quantity;
                    //         }

                    //         $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                    //     }
                    // }



                    $previous   = OrderLines::where('order_header_id', $value->order_header_id)->Where(function($query) {
                                            $query->whereNull('promo_flag')
                                                ->orWhere('promo_flag', '!=', 'Y');
                                        })->sum('approve_quantity');
                    $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                    $remaining  = $previous - $actual;
                    // $remaining  = 5;

                    if ($remaining <= 0) {
                        unset($orderHeadersQuery[$key]);
                    }else{

                        $orderHeadersQuery[$key]->order_header_id           = $value->order_header_id;
                        $orderHeadersQuery[$key]->pick_release_no           = $value->pick_release_no;
                        $orderHeadersQuery[$key]->pick_release_status       = $value->pick_release_status;
                        $orderHeadersQuery[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date;
                        $orderHeadersQuery[$key]->customer_number           = $value->customer_number;
                        $orderHeadersQuery[$key]->customer_name             = $value->customer_name;
                        $orderHeadersQuery[$key]->customer_id               = $value->customer_id;
                        $orderHeadersQuery[$key]->remaining_quantity        = $remaining;
                        $orderHeadersQuery[$key]->consignment_status        = $value->consignment_status;

                    }
                }
            }

            $rest = [
                'orderHeadersQuery'     => $orderHeadersQuery,
                'consignmentQuery'      => $consignmentNoList,
                'consignmentNo'         => $newConsingmentNo,
                'consigmentHeaderID'    => $consignmentQuery->consignment_header_id,
                'status'                => 'success',
                'data'                  => 'Success',
            ];
        }else{

            // วันที่บันทึก
            if(!empty($request->consignment_date)){
                $dateArr    = explode('/', $request->consignment_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $consignmentTime = strtotime($newDate);
                $consignmentDate = date('Y-m-d H:i:s',$consignmentTime);
            }else{
                $consignmentDate = '';
            }

            // วันที่ขน
            if(!empty($request->pick_release_date_input)){
                $dateArr    = explode('/', $request->pick_release_date_input);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $releaseTime = strtotime($newDate);
                $releaseDate = date('Y-m-d H:i:s',$releaseTime);
            }else{
                $releaseDate = '';
            }

            $orderHeaderQuery   = OrderHeaders::where('pick_release_no', $request->pick_release_num)->whereNull('deleted_at')->first();

            $customerID         = $orderHeaderQuery->customer_id;
            $customersQuery     = Customers::where('customer_id', $customerID)->first();
            $customersVat       = $customersQuery->vat_code;

            if ($customersVat != '') {
                $taxCodeQuery   = TaxCode::select('percentage_rate')->where('tax_rate_code', $customersVat)->first();
                $percentageRate = $taxCodeQuery->percentage_rate;
            }else{
                $percentageRate = 7;
            }

            // $vatAmount          = str_replace(',', '',$request->total_amount) * $percentageRate / 107;
            $totalIncludeVat    = str_replace(',', '',$request->total_amount);
            $commissionAmount   = 0;

            // $vatAmount          = number_format((float)$vatAmount, 2, '.', '');
            $totalIncludeVat    = number_format((float)$totalIncludeVat, 2, '.', '');

            $totalAmountForcalVat   = 0;

            if (!empty($request->consignment_line_id)) {
                foreach ($request->consignment_line_id as $key => $value) {
                    $itemQuery      = SequenceEcom::where('item_code', $request->item_code[$key])->first();
                    $itemID         = $itemQuery->item_id;

                    $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                ->select('operand')
                                                ->where('item_id', $itemID)
                                                ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                                ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                                ->where(function($query){
                                                    $query->where('name', 'ราคาขายส่ง')
                                                        ->orWhere('name', 'ราคาโรงงาน');
                                                })->orderBy('name', 'DESC')->get();

                    $priceList1 = !empty($priceListQuery[0]->operand) ? $priceListQuery[0]->operand : 0;
                    $priceList2 = !empty($priceListQuery[1]->operand) ? $priceListQuery[1]->operand : 0;

                    $orderLinesUnitPrice = OrderLines::where('order_line_id', $key)->pluck('unit_price')->first();

                    $commissionAmount       = (float)$commissionAmount + ((((floatval(str_replace(',', '',$request->actual_quantity[$key])) * ($orderLinesUnitPrice - $priceList1)) * 95) * 0.01 ));
                    $commissionAmount       = number_format((float)$commissionAmount, 2, '.', '');

                    // Cal vat
                    $getOperand = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                ->select('ptom_price_list_line_v.operand')
                                                ->where('ptom_price_list_line_v.item_id', $itemID)
                                                ->where('ptom_price_list_head_v.name', 'ราคาขายปลีก')
                                                ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                                ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                                ->first();

                    $vatOperand             = !empty($getOperand->operand) ? $getOperand->operand : 0;
                    $vatActual              = floatval(str_replace(',', '',$request->actual_quantity[$key])) * $vatOperand;
                    $totalAmountForcalVat   = $totalAmountForcalVat + $vatActual;

                }
            }

            $vatAmount  = $totalAmountForcalVat * $percentageRate / 107;
            $vatAmount  = number_format((float)$vatAmount, 2, '.', '');

            // print_r($vatAmount);exit();

            $newConsingmentNo = GenerateNumberRepo::generateConsignmentNo('OMP0038_F_NUM_DOM');

            $insert = [
                'customer_id'               => $orderHeaderQuery->customer_id,
                'customer_number'           => $customersQuery->customer_number,
                'order_type_id'             => $orderHeaderQuery->order_type_id,
                'consignment_no'            => $newConsingmentNo,
                'consignment_date'          => $consignmentDate,
                'pick_release_num'          => $request->pick_release_num,
                'pick_release_date'         => $releaseDate,
                'order_header_id'           => $orderHeaderQuery->order_header_id,
                'consignment_status'        => $request->consignment_status,
                'total_unit_price_amount'   => str_replace(',', '',$request->total_unit_price_amount),
                'total_consignment_amount'  => str_replace(',', '',$request->total_consignment_amount),
                'total_amount'              => str_replace(',', '',$request->total_amount),
                'vat_amount'                => $vatAmount,
                'total_include_vat'         => str_replace(',', '',$totalIncludeVat),
                'commission_amount'         => $commissionAmount > 0 ? number_format((float)$commissionAmount, 2, '.', '') : 0,
                'program_code'              => 'OMP0038',
                'created_by'                => optional(auth()->user())->user_id,
                'created_by_id'             => optional(auth()->user())->user_id,
                'created_at'                => date('Y-m-d H:i:s'),
                'creation_date'             => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s')
            ];

            // echo '<pre>';
            // print_r($insert);
            // echo '<pre>';
            // exit();

            ConsignmentHeader::insert($insert);

            if ($request->consignment_status == 'Confirm') {
                $consigmentHeaderID = ConsignmentHeader::orderBy('consignment_header_id', 'DESC')->pluck('consignment_header_id')->first();
                GenerateNumberRepo::callWMSPackageConsignment($consigmentHeaderID, $newConsingmentNo);
            }

            if (!empty($request->consignment_line_id)) {
                $consignmentLastQuery = ConsignmentHeader::select('consignment_header_id', 'order_type_id')->orderBy('consignment_header_id', 'desc')->first();

                foreach ($request->consignment_line_id as $key => $valueLine) {

                    $checkActual    = str_replace(',', '', $request->actual_quantity[$key]);

                    if ($checkActual > 0) {
                        $orderLinesQuery = OrderLines::where('order_line_id', $key)->first();

                        // Previous Quantity
                        if (!empty($request->previous_quantity[$key])) {
                            $previousReplace    = str_replace(',', '', $request->previous_quantity[$key]);
                            // $previousExplode    = explode('.', $previousReplace);
                            $previous           = !empty($previousReplace) ? $previousReplace : 0;
                        }else{
                            $previous           = 0;
                        }

                        // Remainign Quantity
                        if (!empty($request->remaining_quantity[$key])) {
                            $remainingReplace    = str_replace(',', '', $request->remaining_quantity[$key]);
                            // $remainingExplode    = explode('.', $remainingReplace);
                            $remaining           = !empty($remainingReplace) ? $remainingReplace : 0;
                        }else{
                            $remaining           = 0;
                        }

                        // Actual Quantity
                        if (!empty($request->actual_quantity[$key])) {
                            $actualReplace    = str_replace(',', '', $request->actual_quantity[$key]);
                            // $actualExplode    = explode('.', $actualReplace);
                            $actual           = !empty($actualReplace) ? $actualReplace : 0;
                        }else{
                            $actual           = 0;
                        }

                        // if ($request->consignment_status == 'Confirm') {
                        //     $resultRemaining = (float)$remaining - (float)$actual;
                        // }else{
                        //     $resultRemaining = (float)$remaining;
                        // }

                        $itemQuery      = SequenceEcom::where('item_code', $request->item_code[$key])->first();
                        $itemID         = $itemQuery->item_id;

                        $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                    ->select('operand')
                                                    ->where('item_id', $itemID)
                                                    ->where(function($query){
                                                        $query->where('name', 'ราคาขายส่ง')
                                                            ->orWhere('name', 'ราคาโรงงาน');
                                                    })->orderBy('name', 'DESC')->get();

                        $priceList1 = !empty($priceListQuery[0]->operand) ? $priceListQuery[0]->operand : 0;
                        $priceList2 = !empty($priceListQuery[1]->operand) ? $priceListQuery[1]->operand : 0;

                        $lineCommisAmount   = 0.00;
                        $CommisAmount       = ((float)$actual * ($orderLinesQuery->unit_price - $priceList1)) * 95;
                        $CommisAmount       = $CommisAmount * 0.01;
                        $lineCommisAmount   = number_format((float)$CommisAmount, 2, '.', '');

                        $transactionTaxRate = DB::table('ptom_transaction_types_v')->select('tax_rate')->where('order_type_id', $consignmentLastQuery->order_type_id)->pluck('tax_rate')->first();
                        $transactionTaxRate = !empty($transactionTaxRate) ? $transactionTaxRate : 0;
                        $lineTaxAmount      = (($actual * $orderLinesQuery->attribute1) * $transactionTaxRate / (100 + $transactionTaxRate));

                        $insertLine = [
                            'consignment_header_id'     => !empty($consignmentLastQuery->consignment_header_id) ? $consignmentLastQuery->consignment_header_id : 0,
                            'order_header_id'           => $orderHeaderQuery->order_header_id,
                            'order_line_id'             => $request->consignment_line_id[$key],
                            'item_id'                   => $orderLinesQuery->item_id,
                            'item_code'                 => $orderLinesQuery->item_code,
                            'item_description'          => $orderLinesQuery->item_description,
                            'quantity'                  => !empty($orderLinesQuery->approve_quantity) ? $orderLinesQuery->approve_quantity : 0,
                            'previous_quantity'         => $previous,
                            'remaining_quantity'        => $remaining,
                            'actual_quantity'           => $actual,
                            'line_commis_amount'        => $lineCommisAmount > 0 ? $lineCommisAmount : 0,
                            'attribute1'                => 'CGK',
                            'attribute2'                => $orderLinesQuery->promo_flag,
                            'attribute3'                => $orderLinesQuery->attribute1,
                            'line_tax_amount'           => $lineTaxAmount,
                            'program_code'              => 'OMP0038',
                            'created_by'                => optional(auth()->user())->user_id,
                            'created_by_id'             => optional(auth()->user())->user_id,
                            'created_at'                => date('Y-m-d H:i:s'),
                            'creation_date'             => date('Y-m-d H:i:s'),
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s')
                        ];

                        // echo '<pre>';
                        // print_r($insertLine);
                        // echo '<pre>';

                        ConsignmentLines::insert($insertLine);
                    }

                }

                if($request->hasFile('attachment')) {
                    $fileAttachment = $request->file('attachment');
                    AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$consignmentLastQuery->consignment_header_id,'OMP0038');
                }
            }

            $consignmentNoList      = ConsignmentHeader::join('ptom_order_headers', 'ptom_consignment_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                                    ->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                    ->select(
                                                        'ptom_consignment_headers.consignment_header_id',
                                                        'ptom_consignment_headers.consignment_no',
                                                        'ptom_consignment_headers.consignment_status',
                                                        'ptom_consignment_headers.pick_release_num',
                                                        'ptom_consignment_headers.consignment_date',
                                                        'ptom_order_headers.pick_release_approve_date',
                                                        'ptom_customers.customer_number',
                                                        'ptom_customers.customer_name'
                                                    )
                                                    ->where('ptom_customers.customer_type_id', 40)
                                                    ->whereNull('ptom_consignment_headers.deleted_at')->orderBy('consignment_no', 'desc')->get();



            if (!empty($consignmentNoList)) {
                foreach ($consignmentNoList as $key => $value) {

                    // $previous   = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('previous_quantity');
                    // $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                    // $remaining  = $previous - $actual;

                    $consignmentNoList[$key]->consignment_date          = !empty($value->consignment_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->consignment_date))) : $value->consignment_date;
                    $consignmentNoList[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date;
                }
            }

            // NEW PICK RELEASE NO
            $orderHeadersQuery       = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->where('ptom_order_headers.pick_release_status', 'Confirm')
                                                ->where('ptom_order_headers.pick_release_approve_flag', 'Y')
                                                ->where('ptom_order_headers.product_type_code', 10)
                                                ->where('ptom_customers.customer_type_id', 40)
                                                // ->Where(function($query) {
                                                //     $query->where('ptom_customers.customer_type_id', 30)
                                                //         ->orWhere('ptom_customers.customer_type_id', 40);
                                                // })
                                                ->where('ptom_customers.sales_classification_code', 'Domestic')
                                                ->select(
                                                    'ptom_order_headers.order_header_id',
                                                    'ptom_order_headers.pick_release_no',
                                                    'ptom_order_headers.pick_release_approve_date',
                                                    'ptom_order_headers.pick_release_status',
                                                    'ptom_order_headers.customer_id',
                                                    'ptom_customers.customer_number',
                                                    'ptom_customers.customer_name',
                                                )
                                                ->orderBy('ptom_order_headers.pick_release_no', 'desc')->get();

            if (!empty($orderHeadersQuery)) {
                foreach ($orderHeadersQuery as $key => $value) {

                    // $consignmentLineQuery   = ConsignmentLines::where('order_header_id', $value->order_header_id)->get();

                    // $previous = 0;

                    // if (!empty($consignmentLineQuery)) {
                    //     foreach ($consignmentLineQuery as $key => $conline) {
                    //         if ($key == 0) {
                    //             $previous   = $conline->previous_quantity;
                    //         }

                    //         $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                    //     }
                    // }



                    $previous   = OrderLines::where('order_header_id', $value->order_header_id)->Where(function($query) {
                                            $query->whereNull('promo_flag')
                                                ->orWhere('promo_flag', '!=', 'Y');
                                        })->sum('approve_quantity');
                    $actual     = ConsignmentLines::join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', 'ptom_consignment_headers.consignment_header_id')
                                                    ->where('ptom_consignment_lines.order_header_id', $value->order_header_id)
                                                    ->where('ptom_consignment_headers.consignment_status', 'Confirm')
                                                    ->sum('ptom_consignment_lines.actual_quantity');
                    $remaining  = $previous - $actual;
                    // $remaining  = 5;

                    if ($remaining <= 0) {
                        unset($orderHeadersQuery[$key]);
                    }else{

                        $orderHeadersQuery[$key]->order_header_id           = $value->order_header_id;
                        $orderHeadersQuery[$key]->pick_release_no           = $value->pick_release_no;
                        $orderHeadersQuery[$key]->pick_release_status       = $value->pick_release_status;
                        $orderHeadersQuery[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date;
                        $orderHeadersQuery[$key]->customer_number           = $value->customer_number;
                        $orderHeadersQuery[$key]->customer_name             = $value->customer_name;
                        $orderHeadersQuery[$key]->customer_id               = $value->customer_id;
                        $orderHeadersQuery[$key]->remaining_quantity        = $remaining;
                        $orderHeadersQuery[$key]->consignment_status        = $value->consignment_status;

                    }
                }
            }

            $rest = [
                'orderHeadersQuery'     => $orderHeadersQuery,
                'consignmentQuery'      => $consignmentNoList,
                'consignmentNo'         => $newConsingmentNo,
                'consigmentHeaderID'    => $consignmentLastQuery->consignment_header_id,
                'status'                => 'success',
                'data'                  => 'Success',
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function getDeliveryPeriodTag($pickReleaseNum, $customerNumber)
    {
        $deliveryDate = OrderHeaders::select('delivery_date')->where('pick_release_no', $pickReleaseNum)->pluck('delivery_date')->first();
        $deliDate = !empty($deliveryDate) ? $deliveryDate : '';

        $tag = DB::table('PTOM_DELIVERY_PERIOD_V')->select('tag')->where('MEANING', $customerNumber)->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->pluck('tag')->first();
        $result = !empty($tag) ? $tag : 0;


        return response()->json(['date' => $deliDate,'tag' => $result]);
    }
}
