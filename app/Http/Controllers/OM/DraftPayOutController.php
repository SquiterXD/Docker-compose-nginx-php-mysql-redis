<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\DraftPayoutHeader;
use App\Models\OM\DraftPayoutLine;
use App\Models\OM\SaleConfirmation\OrderLines;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Exception;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DraftPayOutController extends Controller
{
    public function index()
    {
        if (request()->all()) {
            $draftOrders = DraftPayoutHeader::query()->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')->when(request()->delivery_date, function ($q) {
                return $q->whereDate('ptom_order_headers.delivery_date', parseFromDateTh(request()->delivery_date));
            })->when(request()->time_select && request()->time_select != '*', function ($q) {
                return $q->join('ptom_transport_routes', 'ptom_customers.customer_id', '=', 'ptom_transport_routes.customer_id', 'left')->where('ptom_transport_routes.time_of_day', '=', request()->time_select);
            })->when(request()->type_customer, function ($q) {
                if (request()->type_customer != '*') {
                    if (request()->type_customer != 'Modern Trade') {
                        $id = DB::table('ptom_customer_type_domestic')->select('customer_type')->where('meaning', '<>', 'Modern trade')->get();
                    } else {
                        $id = DB::table('ptom_customer_type_domestic')->select('customer_type')->where('meaning', '=', 'Modern trade')->get();
                    }
                    $array_data = [];
                    foreach ($id as $array_id) {
                        array_push($array_data, $array_id->customer_type);
                    }
                    return $q->whereIn('ptom_customers.customer_type_id', $array_data);
                }
            })->where(function ($query) {
                $query->whereNull('ptom_order_headers.attribute2');
                $query->orWhere('ptom_order_headers.attribute2', '!=', 'Y');
            })->whereNotNull('ptom_order_headers.prepare_order_number')->Statusnotconfirm()->Domestic()->get();
        } else {
            $draftOrders = [];
        }

        $listIssue = DraftPayoutHeader::whereNotNull('issue_number')->orderByDesc('issue_date')->get(['issue_number', 'issue_date']);

        return view('om.draft_payout.index', compact('draftOrders', 'listIssue'));
    }

    public function listProduct(Request $request)
    {
        if ($request->ajax()) {
            $number1 = 0;
            $number2 = 0;
            $html = '';
            if ($request->number_id) {
                $number = DraftPayoutHeader::where('issue_number', $request->number_id)->first();
                $listOrders = DraftPayoutLine::where('order_header_id', $number->order_header_id)
                            ->groupBy(['item_id', 'item_code', 'item_description', 'uom_code', 'promo_flag'])
                            ->orderBy('item_code', 'ASC')
                            ->get(['item_id', 'item_code', 'item_description', 'promo_flag', 'uom_code', DB::raw("SUM(approve_quantity) approve_quantity"), DB::raw("SUM(approve_cardboardbox) approve_cardboardbox"), DB::raw("SUM(approve_carton) approve_carton")]);
                            // ->get(['item_id', 'item_code', 'item_description', 'uom_code', 'approve_quantity', 'approve_cardboardbox', 'approve_carton']);
                $time = FormatDate::datetimethaitoomp0040($number->issue_date);
            } else {
                $listOrders = DraftPayoutLine::whereIn('order_header_id', $request->array_id)
                    ->groupBy(['item_id', 'item_code', 'item_description', 'uom_code', 'promo_flag'])
                    ->orderBy('item_code', 'ASC')
                    ->get(['item_id', 'item_code', 'item_description', 'promo_flag', 'uom_code', DB::raw("SUM(approve_quantity) approve_quantity"), DB::raw("SUM(approve_cardboardbox) approve_cardboardbox"), DB::raw("SUM(approve_carton) approve_carton")]);
                $time = '';
            }
            foreach ($listOrders->where('promo_flag', null) as $item) {
                $type_code = SequenceEcom::where('item_code', $item->item_code)->first();
                if($type_code->product_type_code == 20){
                    if($item->uom_code == 'CS1'){
                        $html .= '<tr>
                        <td>' . $item->item_code . '</td>
                        <td class="text-left">' . $item->item_description . '</td>
                        <td>' . number_format($item->approve_quantity, 2) . '</td>
                        <td>' . number_format(0, 2) . '</td>
                    </tr>';
                        $number1 += $item->approve_quantity == '' ? 0 : $item->approve_quantity;
                        $number2 += 0;
                    } else {
                        $html .= '<tr>
                        <td>' . $item->item_code . '</td>
                        <td class="text-left">' . $item->item_description . '</td>
                        <td>' . number_format(0, 2) . '</td>
                        <td>' . number_format($item->approve_quantity, 2) . '</td>
                    </tr>';
                        $number1 += 0;
                        $number2 += $item->approve_quantity == '' ? 0 : $item->approve_quantity;
                    }
                } else {
                    $html .= '<tr>
                    <td>' . $item->item_code . '</td>
                    <td class="text-left">' . $item->item_description . '</td>
                    <td>' . number_format($item->approve_cardboardbox, 2) . '</td>
                    <td>' . number_format($item->approve_carton, 2) . '</td>
                </tr>';
                    $number1 += $item->approve_cardboardbox == '' ? 0 : $item->approve_cardboardbox;
                    $number2 += $item->approve_carton == '' ? 0 : $item->approve_carton;
                }
            }
            $html .= '<tr class="align-middle">
            <td colspan="2" class="text-right">
                <strong>รวม</strong>
            </td>
            <td>
                <input type="text" class="form-control md text-center" name="" value="' . number_format($number1, 2) . '" readonly>
            </td>
            <td>
                <input type="text" class="form-control md text-center" name="" value="' . number_format($number2, 2) . '" readonly>
            </td>
        </tr>';

        $htmlFree = '';
        $number1 = 0;
        $number2 = 0;
        foreach ($listOrders->where('promo_flag', '!=', null) as $item) {
            $type_code = SequenceEcom::where('item_code', $item->item_code)->first();
            if($type_code->product_type_code == 20){
                if($item->uom_code == 'CS1'){
                    $htmlFree .= '<tr>
                    <td>' . $item->item_code . '</td>
                    <td class="text-left">' . $item->item_description . '</td>
                    <td>' . number_format($item->approve_quantity, 2) . '</td>
                    <td>' . number_format(0, 2) . '</td>
                </tr>';
                    $number1 += $item->approve_quantity == '' ? 0 : $item->approve_quantity;
                    $number2 += 0;
                } else {
                    $htmlFree .= '<tr>
                    <td>' . $item->item_code . '</td>
                    <td class="text-left">' . $item->item_description . '</td>
                    <td>' . number_format(0, 2) . '</td>
                    <td>' . number_format((float)$item->approve_quantity, 2) . '</td>
                </tr>';
                    $number1 += (float)0;
                    $number2 += (float)$item->approve_quantity == '' ? 0 : (float)$item->approve_quantity;
                }
            } else {
                $htmlFree .= '<tr>
                <td>' . $item->item_code . '</td>
                <td class="text-left">' . $item->item_description . '</td>
                <td>' . number_format($item->approve_cardboardbox, 2) . '</td>
                <td>' . number_format($item->approve_carton, 2) . '</td>
            </tr>';
                $number1 += $item->approve_cardboardbox == '' ? 0 : $item->approve_cardboardbox;
                $number2 += $item->approve_carton == '' ? 0 : $item->approve_carton;
            }
        }
        $htmlFree .= '<tr class="align-middle">
            <td colspan="2" class="text-right">
                <strong>รวม</strong>
            </td>
            <td>
                <input type="text" class="form-control md text-center" name="" value="' . number_format($number1, 2) . '" readonly>
            </td>
            <td>
                <input type="text" class="form-control md text-center" name="" value="' . number_format($number2, 2) . '" readonly>
            </td>
        </tr>';
            return response()->json(['html' => $html,'has_free'=>($listOrders->where('promo_flag', '!=', null)->count() > 0), 'html_free'=>$htmlFree, 'time' => $time], 200);
        }
    }

    public function printwith($id)
    {
        if ($id) {
            $array_sequences = [];
            $array_sequences2 = [];
            $item_code = [];

            $lines = DB::select("SELECT * FROM PTOM_ORDER_LINES WHERE ORDER_HEADER_ID IN ($id)");
            // $lines = OrderLines::whereIn('order_header_id', $header_id)->get();
            foreach ($lines as $line) {
                if (!array_search($line->item_code, $item_code)) {
                    array_push($item_code, $line->item_code);
                }
            }

            $sequences = SequenceEcom::whereRaw("UPPER(sale_type_code) = 'DOMESTIC'")->where('product_type_code', 10)->orderBy('screen_number', 'ASC')->get(['item_code', 'report_item_display']);
            foreach ($sequences as $sequence) {
                array_push($array_sequences, [$sequence->item_code, $sequence->report_item_display]);
            }

            $sequences2 = SequenceEcom::whereRaw("UPPER(sale_type_code) = 'DOMESTIC'")->where('product_type_code', 20)->orderBy('screen_number', 'ASC')->get(['item_code', 'report_item_display']);
            foreach ($sequences2 as $sequence2) {
                array_push($array_sequences2, [$sequence2->item_code, $sequence2->report_item_display]);
            }

            $querys = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_ORDER_LINES ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_LINES.ORDER_HEADER_ID
            WHERE PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = 10 AND PTOM_ORDER_HEADERS.ORDER_HEADER_ID IN ($id)  GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG ORDER BY PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER");

            $querys20 = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_ORDER_LINES ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_LINES.ORDER_HEADER_ID WHERE PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = 20 AND PTOM_ORDER_HEADERS.ORDER_HEADER_ID IN ($id) GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG");
            $dataCompact = [
                'id',
                'array_sequences',
                'array_sequences2',
                'querys',
                'querys20'
            ];

            // dd($querys);
            // return view('om.draft_payout.print', compact($dataCompact));
            $pdf = SnappyPdf::loadView('om.draft_payout.print', compact($dataCompact));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        } else {
            return 'Data invalid';
        }
    }

    public function print($number_id)
    {
        $header_id = [];
        $array_sequences = [];
        $array_sequences2 = [];
        $item_code = [];
        if ($number_id) {
            $number = DraftPayoutHeader::where('issue_number', $number_id)->get();
            foreach ($number as $n) {
                if (!array_search($n->order_header_id, $header_id)) {
                    array_push($header_id, $n->order_header_id);
                }
            }

            $lines = OrderLines::whereIn('order_header_id', $header_id)->get();
            foreach ($lines as $line) {
                if (!array_search($line->item_code, $item_code)) {
                    array_push($item_code, $line->item_code);
                }
            }

            // $sequences = SequenceEcom::whereRaw("UPPER(sale_type_code) = 'DOMESTIC'")->where('product_type_code', 10)->whereIn('item_code', $item_code)->orderBy('screen_number', 'ASC')->get(['item_code', 'item_description']);
            $sequences = SequenceEcom::whereRaw("UPPER(sale_type_code) = 'DOMESTIC'")->where('product_type_code', 10)->orderBy('screen_number', 'ASC')->get(['item_code', 'item_description']);
            foreach ($sequences as $sequence) {
                array_push($array_sequences, [$sequence->item_code, $sequence->item_description]);
            }

            $sequences2 = SequenceEcom::whereRaw("UPPER(sale_type_code) = 'DOMESTIC'")->where('product_type_code', 20)->orderBy('screen_number', 'ASC')->get(['item_code', 'item_description']);
            foreach ($sequences2 as $sequence2) {
                array_push($array_sequences2, [$sequence2->item_code, $sequence2->item_description]);
            }

            $querys = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_ORDER_LINES ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_LINES.ORDER_HEADER_ID
            WHERE PTOM_ORDER_HEADERS.ISSUE_FLAG = 'Y' AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = 10 AND PTOM_ORDER_HEADERS.ISSUE_NUMBER = '" . $number_id . "' GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG");

            $querys20 = DB::select("SELECT PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG FROM PTOM_ORDER_HEADERS LEFT JOIN PTOM_CUSTOMERS ON PTOM_ORDER_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID LEFT JOIN PTOM_ORDER_LINES ON PTOM_ORDER_HEADERS.ORDER_HEADER_ID = PTOM_ORDER_LINES.ORDER_HEADER_ID WHERE PTOM_ORDER_HEADERS.ISSUE_FLAG = 'Y' AND PTOM_ORDER_HEADERS.PRODUCT_TYPE_CODE = 20 AND PTOM_ORDER_HEADERS.ISSUE_NUMBER = '" . $number_id . "' GROUP BY PTOM_ORDER_HEADERS.ORDER_HEADER_ID,PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER,PTOM_CUSTOMERS.CUSTOMER_NAME,PTOM_ORDER_LINES.PROMO_FLAG");

            $dataCompact = [
                'number',
                'array_sequences',
                'array_sequences2',
                'querys',
                'querys20'
            ];
            // return view('om.draft_payout.print', compact($dataCompact));
            $pdf = SnappyPdf::loadView('om.draft_payout.print', compact($dataCompact));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-left', '1')->setOption('margin-right', '1')->setOption('margin-top', '1')->setOption('margin-bottom', '1')->setTimeout(300);

            return $pdf->inline();
        } else {
            return 'Data invalid';
        }
    }

    public function storeDraft(Request $request)
    {
        if ($request->ajax()) {
            $number = autoNumberDraftOMP0040('OMP0040_PS_NUM_DOM', 'issue_number');
            $time = Carbon::now('Asia/Bangkok');
            try {
                DraftPayoutHeader::whereIn('order_header_id', $request->array_id)->update([
                    'issue_flag' => 'Y',
                    'ready_for_issue_flag' => 'Y',
                    'issue_number' => '' . $number . '',
                    'issue_date' => DB::raw("TO_DATE('" . $time . "', 'YYYY-MM-DD hh24:mi:ss')"),
                    'last_updated_by' => getDefaultData('/users')->user_id,
                    'last_update_date' => DB::raw("TO_DATE('" . $time . "', 'YYYY-MM-DD hh24:mi:ss')"),
                ]);

                return response()->json(['issue_number' => $number, 'time' => FormatDate::datetimethaitoomp0040($time), 'status' => 'success', 'msg' => ''], 200);
            } catch (Exception $e) {
                return response()->json(['issue_number' => '', 'time' => '', 'status' => 'fails', 'msg' => $e->getMessage()], 200);
            }
        }
    }
}
