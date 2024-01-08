<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\Consignment;
use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\ConsignmentClub\ConsignmentLines;
use App\Models\OM\Customers;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsignmentClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0038')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }

    public function index()
    {
        $program_code = 'OMP0038';

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

        $orderHeadersList = [];
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

                $actual     = ConsignmentLines::join('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', '=', 'ptom_consignment_headers.consignment_header_id')
                                            ->where('ptom_consignment_lines.order_header_id', $value->order_header_id)
                                            ->where('ptom_consignment_headers.consignment_status', '!=', 'Cancelled')
                                            ->sum('ptom_consignment_lines.actual_quantity');
                $remaining  = $previous - $actual;
                // $remaining  = 5;

                // if ($remaining <= 0) {
                    // unset($orderHeadersList[$key]);
                // }else{
                    $orderHeadersList[$key] = [
                        'order_header_id'               => $value->order_header_id,
                        'pick_release_no'               => $value->pick_release_no,
                        'pick_release_status'           => $value->pick_release_status,
                        'pick_release_approve_date'     => !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date,
                        'customer_number'               => $value->customer_number,
                        'customer_name'                 => $value->customer_name,
                        'customer_id'                   => $value->customer_id,
                        'remaining_quantity'            => $remaining,
                        'consignment_status'            => !empty($value->consignment_status) ? $value->consignment_status : 'Draft'
                    ];
                // }
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
                                                    ->where('consignment_status', 'Draft')
                                                    ->where('ptom_customers.customer_type_id', 40)
                                                    ->whereNull('ptom_consignment_headers.deleted_at')->orderBy('consignment_no', 'asc')->get();


        if (!empty($consignmentNoList)) {
            foreach ($consignmentNoList as $key => $value) {

                // $previous   = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('previous_quantity');
                // $actual     = ConsignmentLines::where('order_header_id', $value->order_header_id)->sum('actual_quantity');
                // $remaining  = $previous - $actual;

                $consignmentNoList[$key]->consignment_date          = !empty($value->consignment_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->consignment_date))) : $value->consignment_date;
                $consignmentNoList[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->pick_release_approve_date))) : $value->pick_release_approve_date;
            }
        }

        $customerList           = Customers::where('status', 'Active')
                                        ->where('sales_classification_code', 'Domestic')
                                        ->where('customer_type_id', 40)
                                        // ->Where(function($query) {
                                        //     $query->where('customer_type_id', 30)
                                        //         ->orWhere('customer_type_id', 40);
                                        // })
                                        ->whereNull('deleted_at')
                                        ->orderBy('customer_number')
                                        ->get();

        $attachmentFile = [];

        $dataCompact = [
            'orderHeadersList',
            'consignmentNoList',
            'customerList',
            'program_code',
            'attachmentFile'
        ];

        // echo '<pre>';
        // print_r($orderHeadersList);
        // echo '</pre>';
        // exit();

        return view('om.consignment_club/index', compact($dataCompact));
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
