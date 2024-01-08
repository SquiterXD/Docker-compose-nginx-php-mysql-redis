<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Exports\OM\OMR0036;
use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0036Controller extends Controller
{


    public function OMR0036($programcode, Request $request)
    {
        $promoHeaderId = OrderLines::where('promo_flag', 'Y')
                        ->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
                        ->whereRaw("trunc(ptom_order_headers.order_date) between to_date('{$request->date_from}', 'dd/mm/yyyy') and to_date('{$request->date_to}', 'dd/mm/yyyy')")
                        ->when(!empty($request->customer_number_from), function($q) use($request){
                            $q->where('ptom_order_headers.customer_id', $request->customer_number_from);
                        })
                        ->when(!empty($request->product_type), function($q) use($request){
                            $q->where('ptom_order_headers.product_type_code', $request->product_type);
                        })
                        ->groupBy('ptom_order_lines.order_header_id', 'ptom_order_headers.order_date', 'ptom_order_headers.customer_id')
                        ->get(['ptom_order_lines.order_header_id', 'ptom_order_headers.order_date' , 'ptom_order_headers.customer_id'])
                        
                        ->pluck('order_header_id')
                        ->toArray();
        // dd($promoHeaderId);
        $promoHeader = OrderHeader::with(['lines', 'customer'])->where('order_status', 'Confirm')->whereIn('order_header_id', $promoHeaderId)
                        ->get();

        $headerColumns = SequenceEcom::where('sale_type_code', 'DOMESTIC')
        ->orderBy('screen_number')
        ->get(['item_code', 'item_id', 'ecom_item_description', 'product_type_code']);
        $compact = compact('promoHeader', 'headerColumns');
        // dd($headerColumns);
        return Excel::download(new OMR0036($compact), 'OMR0036.xlsx');
        return view('om.Reports.omr0036.excel.index', $compact);
        $pdf = PDF::loadView(
            'om.Reports.omr0036.pdf.index', $compact
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 430)
            ->setOption('header-right', '[page]                                           ');

        return $pdf->stream($programcode . '.pdf');
    }
}
