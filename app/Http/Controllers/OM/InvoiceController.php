<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\PtomCustomer;
use App\Models\OM\PtomOrderLine;

use App\Models\Ptom\PtomInvoiceHeader;
use App\Models\Ptom\PtomPrintHistory;
use Carbon\Carbon;
use App\Models\OM\Api\Customer;
use App\Models\OM\OrderHeaders;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\Ptom\PtomOrderHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoiceHeader(Request $request)
    {
        $sendDate = !empty($request->sendDate) ? Carbon::parse($request->sendDate)->format('Y-m-d') : null;
        $arrivalDate = !empty($request->arrivalDate) ? Carbon::parse($request->arrivalDate)->format('Y-m-d') : null;
        $invoiceNo = !empty($request->invoiceNo) ? $request->invoiceNo : null;
        $orderNo = !empty($request->orderNo) ? $request->orderNo : null;
        $printStatus = !empty($request->printStatus) ? $request->printStatus : null;
        $customerName = !empty($request->customerName) ? $request->customerName : null;

        $invoices = $this->searchInvoice($sendDate, $arrivalDate, $invoiceNo, $orderNo, $printStatus, $customerName);

        foreach ($invoices as $invoice) {
            $invoice['customer_promo'] = $this->getPromo($invoice->customer_id);
        }

        return view('om.exports.invoice', compact('invoices'));
    }

    public function searchInvoice($sendDate, $arrivalDate, $invoiceNo, $orderNo, $printStatus, $customerName)
    {
        $base = PtomInvoiceHeader::join('ptom_order_headers', 'ptom_order_headers.order_header_id', 'ptom_invoice_headers.document_id')
            ->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id');

        if (!empty($sendDate)) {
            $base->whereDate('ptom_order_headers.delivery_date', $sendDate);
        }
        if (!empty($arrivalDate)) {
            $base->whereDate('ptom_order_headers.delivery_date', $arrivalDate);
        }
        if (!empty($invoiceNo)) {
            $base->where('ptom_order_headers.pick_release_no', $invoiceNo);
        }
        if (!empty($orderNo)) {
            $base->where('ptom_order_headers.prepare_order_number', $orderNo);
        }
        if (!empty($printStatus)) {
            if ($printStatus == "N") {
                $base->where(function ($q) use ($printStatus) {
                    $q->whereNull('ptom_order_headers.pick_release_print_flag');
                    $q->orWhere('ptom_order_headers.pick_release_print_flag', $printStatus);
                });
            } else {
                $base->where('ptom_order_headers.pick_release_print_flag', $printStatus);
            }
        }
        if (!empty($customerName)) {
            $base->where('ptom_customer.name', $customerName);
        }

        return $base->get();
    }

    public function printInvoice(Request $request)
    {

        $pages = $request->checkPrint;

        if (!empty($pages) && count($pages) > 0) {
            $pages = array_map('intval', $pages);
            $invoices = $this->findInvoiceList($pages);

            foreach ($pages as $page) {
                $this->updateOrCreatePrintHistory($page);
            }

            return view('om.exports.print', compact('invoices'));
        } else {
            return redirect()->back();
        }
    }

    public function findInvoiceList($list)
    {
        $invoices = PtomInvoiceHeader::whereIn('invoice_header_id', $list)
            ->join('ptom_order_headers', 'ptom_order_headers.order_header_id', 'ptom_invoice_headers.document_id')
            ->join('ptom_customers', 'ptom_order_headers.customer_id', 'ptom_customers.customer_id')
            ->leftJoin('ptom_period_v', 'ptom_period_v.period_id', 'ptom_order_headers.period_id')
            ->leftJoin('ptom_customer_ship_sites', 'ptom_customer_ship_sites.ship_to_site_id', 'ptom_order_headers.ship_to_site_id')->get();

        foreach ($invoices as $invoice) {
            $invoice['order_line'] = $this->getOrderLine($invoice->order_header_id) ?? null;
            if ($invoice->sale_classification_code == "DOMESTIC") {
                $invoice['product_type'] = DB::table("ptom_product_type_domestic")->where("ptom_product_type_domestic.lookup_code = $invoice->product_type_code")->limit(1)->get();
            } else {
                $invoice['product_type'] = DB::table("ptom_product_type_export")->where("ptom_product_type_export.lookup_code = $invoice->product_type_code")->limit(1)->get();
            }
        }

        return $invoices;
    }

    public function getOrderLine($orderHeaderId)
    {

        $orderLines = PtomOrderLine::join('ptom_uom_conversions_v', 'ptom_uom_conversions_v.uom_code', 'ptom_order_lines.uom_code')
            ->leftJoin('ptom_price_list_line_v', 'ptom_price_list_line_v.ITEM_ID', 'ptom_order_lines.item_id')
            ->leftJoin('ptom_price_list_head_v', 'ptom_price_list_line_v.LIST_HEADER_ID', 'ptom_price_list_head_v.list_header_id')
            ->where('ptom_order_lines.order_header_id', $orderHeaderId)->get();

        $groupCredit = $orderLines->pluck('credit_group_code');
        $orderLines['credit_note'] = count($groupCredit) > 0 ? $this->getCreditNote($groupCredit) : null;
        return $orderLines;
    }

    public function getCreditNote($creditGroupCode)
    {
        $creditGroupCode = DB::table("PTOM_QUOTA_AND_CREDIT_GROUP")->whereIn("PTOM_QUOTA_AND_CREDIT_GROUP.QUOTA_CREDIT_ID", $creditGroupCode)->get();
        return $creditGroupCode;
    }


    public function updateOrCreatePrintHistory(
        $docId,
        $from_program_code = '',
        $program_code = ''
    ) {
        $revision = PtomPrintHistory::where('document_id', $docId)->first();
        $dataDetail = [
            'from_program_code' => $revision->from_program_code ?? $from_program_code,
            'document_id' => $docId,
            'print_revision' => !empty($revision->print_revision) ? $revision->print_revision + 1 : 1,
            'print_date'    => Carbon::today(),
            'print_by'  => Auth::user()->id ?? 20,
            'program_code' => $revision->program_code ?? $program_code,
            'create_by' => $revision->create_by ?? (Auth::user()->id ?? 20),
            'creation_date' => $revision->creation_date ?? Carbon::today(),
            'last_updated_by' => Auth::user()->id ?? 20,
            'last_update_date' => Carbon::today()
        ];
        PtomPrintHistory::updateOrCreate(['document_id' => $docId], $dataDetail);
    }


    public function cancel()
    {
        // $lists = new PtomOrderHeader();
        // $condition = array();
        // $condition[] = ['pick_release_status', '!=', 'Cancel'];
        // $lists = $lists->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id');
        // $lists = $lists->where($condition);
        // $lists = $lists->select(
        //     'ptom_order_headers.pick_release_no',
        //     'ptom_order_headers.pick_release_status',
        //     'ptom_order_headers.pick_release_approve_date',
        //     'ptom_order_headers.issue_date',
        //     'ptom_customers.customer_name',
        //     'ptom_order_headers.grand_total'
        // )->paginate(5);
        // ->whereNull('ptom_order_t_wms.oaom_wms6_inven')
        // ->where('ptom_order_headers.close_sale_flag', '!=', 'y')

        // $queryLists = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')->join('ptom_order_t_wms', 'ptom_order_t_wms.oaom_invoice_no', '=', 'ptom_order_headers.pick_release_no')
        //     ->whereNull('ptom_order_headers.close_sale_flag')
        //     ->whereRaw("lower(ptom_order_headers.pick_release_status) = 'confirm'")
        //     ->whereRaw("ptom_order_t_wms.oaom_wms6_inven != 'y'")
        //     ->orwhereNull('ptom_order_t_wms.oaom_wms6_inven');

        $queryLists = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id','left')
        // ->where('ptom_order_headers.pick_release_status','Confirm')
        ->whereNull('ptom_order_headers.close_sale_flag');

        $lists = $queryLists;

        $selectLists = $queryLists->whereNotNull('ptom_order_headers.pick_release_no')
            ->orderBy('ptom_order_headers.pick_release_no', 'DESC')
            ->when(!empty(request()->pick_release_status), function($q) {
                $prs = request()->pick_release_status;
                if($prs != 'ALL') $q->where('pick_release_status', $prs);
            })
            ->get();


        if (empty(request()->all())){
            $lists = [];
        } else{

            if (!empty(request()->pick_release_no)) {
                $lists = $lists->where('ptom_order_headers.pick_release_no', request()->pick_release_no);
                $params['pick_release_no'] = trim(request()->pick_release_no);
            }
            if (!empty(request()->pick_release_date)) {
                $keyword_pick_release_date = parseFromDateTh(request()->pick_release_date);
                $lists = $lists->whereDate('ptom_order_headers.pick_release_approve_date', $keyword_pick_release_date);
                $params['pick_release_date'] = $keyword_pick_release_date;
            }

            if (!empty(request()->pick_release_no) || !empty(request()->pick_release_date)) {
                $lists = $lists->paginate(15);
            }

            if (empty(request()->pick_release_no) && empty(request()->pick_release_date)) {
                $lists = $lists->paginate(15);
            }
        }
        $params['selectLists'] = $selectLists;
        $params['lists'] = $lists;

        return view('om.invoice.cancel', $params);
    }

    // public function getAjaxListCancelInvoice()
    // {
    //     $lists = new PtomOrderHeader();
    //     $params = array();
    //     $condition = array();
    //     $condition[] = ['pick_release_status', '!=', 'Cancel'];
    //     $lists = $lists->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id');
    //     $lists = $lists->where($condition);
    //     if (!empty(request()->pick_release_no)) {
    //         $lists = $lists->where('ptom_order_headers.pick_release_no', request()->pick_release_no);
    //         $params['pick_release_no'] = trim(request()->pick_release_no);
    //     }
    //     if (!empty(request()->pick_release_date)) {
    //         $lists = $lists->whereDate('ptom_order_headers.issue_date', date_format(date_create(request()->pick_release_date), 'Y-m-d'));
    //         $params['pick_release_date'] = trim(request()->pick_release_date);
    //     }
    //     $lists = $lists->select(
    //         'ptom_order_headers.pick_release_no',
    //         'ptom_order_headers.pick_release_status',
    //         'ptom_order_headers.pick_release_approve_date',
    //         'ptom_order_headers.issue_date',
    //         'ptom_customers.customer_name',
    //         'ptom_order_headers.grand_total'
    //     )->paginate(5);
    //     return response()->json(['data' => $lists]);
    // }

    public function actionCancel(Request $request)
    {
        $responseJson = [
            'status'    => '',
            'message'   => '',
        ];
        if (is_null($request->input('pick_invoice_cancel'))) {
            $responseJson = [
                'status'    => 'EMPTY',
                'message'   => 'กรุณาเลือกรายการที่ต้องการยกเลิก',
            ];
        } else {
            $lists = OrderHeaders::whereIn('pick_release_no', $request->pick_invoice_cancel)->get();
            foreach ($lists as $orderHeader) {
                // $orderHeader = OrderHeaders::find($list->order_header_id);
                // $orderHeader->last_updated_by = auth()->user()->user_id;
                // $orderHeader->last_update_date = now();

                // Case 1 PTOM_ORDER_T_WMS.OAOM_WMS6_INVEN = Y หรือไม่ ถ้าเป็น Y ระบบจะต้องไม่ยอมให้ยกเลิกรายการ
                $checkWMS = DB::table('PTOM_ORDER_T_WMS')->where('OAOM_INVOICE_NO', $orderHeader->pick_release_no)->first();
                if ($checkWMS) {
                    if (strtolower($checkWMS->oaom_wms6_inven) == 'y') {
                        $responseJson = [
                            'status'    => "ERR01",
                            'message'   => 'ไม่สามารถยกเลิก Invoice/ใบขนได้ เนื่องจาก มีการตัดของออกจากระบบเรียบร้อยแล้ว',
                            'lists'     => []
                        ];
                    } else {
                        // Case 3 หากมีการ Matching Invoice กับใบเสร็จรับเงิน ต้องทำการยกเลิกการ Matching ก่อนถึงจะสามารถยกเลิก Invoice ได้ (ต้องเช็คว่ามี record ที่ PTOM_PAYMENT_MATCH_INVOICES.MATCH_FLAG = 'Y' หรือไม่ ถ้ามีแสดงว่ามีการ Matching Invoice กับใบเสร็จรับเงินอยู่)
                        $prepareOrderNumber = $orderHeader->prepare_order_number;
                        $checkMatchInvoice = PaymentMatchInvoice::where('prepare_order_number', $prepareOrderNumber)->where('match_flag', 'Y')->first();
                        if ($checkMatchInvoice) {
                            $responseJson = [
                                'status'    => "ERR01",
                                'message'   => 'ไม่สามารถยกเลิก Invoice ได้ กรุณาแจ้งทางผู้ที่เกี่ยวข้อง ให้ทำการยกเลิก Matching Invoice กับ ใบเสร็จรับเงินก่อน',
                                'lists'     => []
                            ];
                        } else {
                            // Case 2 ทำการปิดการขายประจำวันของรายการนั้นไปหรือยัง ถ้าปิดการขายประจำวันไปแล้วจะไม่สามารถยกเลิกรายการนั้นที่หน้าจอได้ (รายการที่ถูกปิดการขายประจำวันแล้ว PTOM_ORDER_HEADERS.CLOSE_SALE_FLAG จะเป็น Y)
                            if (strtolower($orderHeader->close_sale_flag) == "y") {
                                $responseJson = [
                                    'status'    => "ERR01",
                                    'message'   => 'ไม่สามารถยกเลิก Invoice/ใบขนได้ เนื่องจาก ทำการปิดการขายประจำวันเรียบร้อยแล้ว',
                                    'lists'     => []
                                ];
                            } else {
                                $wms_update = [
                                    'record_status' => 'C'
                                ];
                                DB::table('PTOM_ORDER_T_WMS')->where('OAOM_INVOICE_NO', $orderHeader->pick_release_no)->update($wms_update);
                                $orderHeader->pick_release_status = 'Cancelled';
                                
                                DB::table('ptom_consignment_headers')->where("order_header_id", $orderHeader->order_header_id)->update([
                                    'consignment_status' => 'Cancelled'
                                ]);
                                $orderHeader->save();
                                $responseJson = [
                                    'status'    => 'SUCCESS',
                                    'message'   => 'ดำเนินการเรียบร้อยแล้ว',
                                    'lists'     => $request->input('pick_invoice_cancel'),
                                ];
                            }
                        }
                    }
                } else {
                    $responseJson = [
                        'status'    => "ERR01",
                        'message'   => 'ไม่พบข้อมูลใน WMS',
                        'lists'     => $request->input('pick_invoice_cancel'),
                    ];
                }
            }
        }
        return response()->json(['data' => $responseJson]);
    }





    public function getPromo($customerId)
    {
        $customer = PtomCustomer::where('customer_id', $customerId)->first();

        $customerData = null;
        if (count($customer->toArray()) > 0 && $customer->sale_classification_code == "DOMESTIC") {
            $customerData = PtomCustomer::where('customer_id', $customerId);
            $customerData = $customerData->join('ptom_customer_type_domestic', 'ptom_customer_type_domestic.customer_type', 'ptom_customers.customer_type_id')
                ->where('ptom_customer_type_domestic.meaning', 'like', '%ส่งเสริม%')->first();
        } else {
            $customerData = PtomCustomer::where('customer_id', $customerId);
            $customerData = $customerData->join('ptom_customer_type_export', 'ptom_customer_type_export.customer_type', 'ptom_customers.customer_type_id')
                ->where('ptom_customer_type_export.meaning', 'like', '%ส่งเสริม%')->first();
        }

        return $customerData;
    }
}
