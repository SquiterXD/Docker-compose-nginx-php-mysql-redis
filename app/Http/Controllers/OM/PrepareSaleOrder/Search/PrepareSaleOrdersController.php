<?php

namespace App\Http\Controllers\OM\PrepareSaleOrder\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\PeriodV;
use App\Models\OM\Customers;
use App\Models\OM\OrderType;
use App\Models\OM\OrderHeaders;
use App\Models\OM\Payment\PaymentType;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\ApproveSaleOrder\AdditionQuotaHeaderModel;

class PrepareSaleOrdersController extends Controller
{
    public function index(Request $request)
    {
        // domestic, export
        $search = $request->search;
        $type = $request->type ?? $search['type'];
        if ($type == 'domestic') {
            $title = 'ค้นหาใบเตรียมการขาย สำหรับขายในประเทศ';
            $urlText = '/om/prepare-sale-orders/search?type=domestic';
        }elseif ($type == 'export') {
            $title = 'ค้นหา Sale Order สำหรับขายต่างประเทศ';
            $urlText = '/om/prepare-sale-orders/search?type=export';
        }
        $paymentTypes = PaymentType::get();
        $status = ['' => '', 'Draft' => 'Draft', ' Confirm' => 'Confirm', 'Reject' => 'Reject', 'Cancel' => 'Cancel'];
        $url = (object)[];
        $url->search = route('om.prepare-sale-orders.search');
        $url->ajax_get_period = route('om.prepare-sale-orders.ajax.get-period-lists');
        $url->ajax_get_pi= route('om.prepare-sale-orders.ajax.get-pi-lists');
        $url->ajax_get_invoice = route('om.prepare-sale-orders.ajax.get-invoice-lists');
        $url->ajax_get_customer = route('om.prepare-sale-orders.ajax.get-customer-lists');
        $url->ajax_get_order_type = route('om.prepare-sale-orders.ajax.get-order-type-lists');
        $url->ajax_get_so = route('om.prepare-sale-orders.ajax.get-so-lists');
        $url->ajax_get_prepare_so = route('om.prepare-sale-orders.ajax.get-prepare-so-lists');
        $btnTrans = trans('btn');
        $orderLists = [];
        if ($search) {
            if(@$search['prepare_so_status'] === "Cancel")$search['prepare_so_status'] = "Cancelled";
            // 30112021 -- เพิ่มเงื่อนไขใหม่สำหรับในประเทศโดยเปลี่ยน link ใช้งาน 'OMP0019', 'OMP0020', 'OMP0003'
            $orderLists = OrderHeaders::search($search, $type)
                        ->with(['producttype'])
                        ->whereNotNull('prepare_order_number')
                        ->orderBy('prepare_order_number')
                        ->get();
            foreach($orderLists as $item) {
                $item->is_over_quota = false;
                $quota = AdditionQuotaHeaderModel::where('order_header_id', $item->order_header_id)->first();
                if(empty($quota)){
                    $item->is_over_quota = false;
                }else{
                    $item->is_over_quota = true;
                }
            }
        }else{
            // 24062022 -- เพิ่มเงื่อนไข search default
            $date = date('Y-m-d');
            $orderLists = OrderHeaders::search($search, $type)
                                    ->with(['producttype'])
                                    ->whereRaw("to_date('{$date}', 'RRRR-MM-DD') between trunc(delivery_date) and trunc(delivery_date)")
                                    ->where('order_status', 'Draft')
                                    ->whereNotNull('prepare_order_number')
                                    ->orderBy('prepare_order_number')
                                    ->get();
            foreach($orderLists as $item) {
                $quota = AdditionQuotaHeaderModel::where('order_header_id', $item->order_header_id)->first();
                if(empty($quota)){
                    $item->is_over_quota = false;
                }else{
                    $item->is_over_quota = true;
                }
            }
        }
        $deliveryDate = [''=>'', 'ทุกวัน'=>'ทุกวัน', 'จันทร์'=>'จันทร์', 'อังคาร'=>'อังคาร', 'พุธ'=>'พุธ', 'พฤหัสบดี'=>'พฤหัสบดี', 'ศุกร์'=>'ศุกร์', 'เสาร์'=>'เสาร์', 'อาทิตย์'=>'อาทิตย์'];
        return view('om.prepare-sale-order.index', compact('type', 'paymentTypes', 'status', 'orderLists', 'title', 'urlText', 'url', 'search', 'btnTrans', 'deliveryDate'));
    }
}
