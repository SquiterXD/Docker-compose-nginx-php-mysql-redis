<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\OM\OMR0062;
use App\Http\Controllers\Controller;
use App\Models\OM\APInterface;
use App\Models\OM\GLInterfaceModel;
use App\Models\OM\ARInterface;
use App\Models\Planning\GLPeriodV;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0004Controller extends Controller
{
    protected $titleReport;
    protected $view = 'om.reports.omr0004.pdf.index';
    protected $program;
    protected $dateFormat = 'd/m/Y';

    public function getMonthTh($month)
    {
        $toInt = (int)($month);
        $months_th = ['', "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months_th[$toInt];
    }
    public function __construct()
    {

        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }
    public function dumpCustomer($cusId, $data)
    {
        $shipTo = (DB::table('ptom_customer_ship_sites')->whereIn('ship_to_site_id', $data->pluck('order.ship_to_site_id')->toArray())->whereIn('customer_id', $cusId)->get());
        $customers = DB::table('ptom_customers')
            ->select(
                'customer_id',
                'branch',
                'customer_name',
                'taxpayer_id',
                'customer_type_id',
                'address_line1',
                'address_line2',
                'address_line3',
                'alley',
                'district',
                'city',
                'province_name',
                'postal_code'
            )
            ->whereIn('customer_id', $cusId)
            ->get();

        return $data->map(function ($i) use ($customers, $shipTo) {
            $i->customer = $customers->where('customer_id', $i->customer_id)->first();
            $i->customer->shipTo = $shipTo->where('ship_to_site_id', $i->order->ship_to_site_id)->first();
            return $i;
        });
    }
    public function dumpClaim($ihn, $data)
    {
        $claims = DB::table('ptom_claim_headers')
            ->select(
                'claim_header_id',
                'credit_note_number',
                'invoice_date',
                'symptom_description'
            )
            ->whereIn('credit_note_number', $ihn)
            ->get();

        $lines = DB::table('ptom_claim_lines')
            ->select(
                'claim_header_id',
                'item_id',
                'order_line_id',
                'item_code',
                'item_description',
                'order_quantity',
                'uom_code',
                'rma_quantity',
                'rma_uom_code',
                'rma_quantity_cbb'
            )
            ->whereIn('claim_header_id', collect($claims)->pluck('claim_header_id')->toArray())
            ->get();
        return $data->map(function ($i) use ($claims, $lines) {
            $i->claim = $claims->where('credit_note_number', $i->invoice_headers_number)->first();
            $i->claim->lines = $lines->where('claim_header_id', $i->claim->claim_header_id);
            return $i;
        });
    }


    public function dumpOrders($prn, $data)
    {
        $orders = DB::table('ptom_order_headers')
            ->select(
                'pick_release_no',
                'order_header_id',
                'product_type_code',
                'ship_to_site_id',
                'grand_total'
            )
            ->whereIn('pick_release_no', $prn)
            ->get();

        $lines = DB::table('ptom_order_lines')
            ->select(
                'order_header_id',
                'item_id',
                'item_code',
                'unit_price',
                'order_line_id',
                'attribute1',
                'approve_quantity'
            )
            ->whereIn('order_header_id', $orders->pluck('order_header_id')->toArray())
            ->get();
        return $data->map(function ($i) use ($orders, $lines) {
            $i->order = $orders->where('pick_release_no', $i->ref_invoice_number)->first();
            $i->order->lines = $lines->where('order_header_id', $i->order->order_header_id);
            return $i;
        });
    }

    public function OMR0004($programcode, Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $query = DB::table('ptom_invoice_headers')
            ->select(
                'customer_id',
                'invoice_headers_number',
                'invoice_date',
                'ref_invoice_number'
            )
            ->where('invoice_type', 'CN_OTHER')
            ->whereNotNull('ref_invoice_number')
            ->whereRaw("TRUNC(invoice_date) BETWEEN to_date('{$dateFrom}','dd/mm/yyyy') AND to_date('{$dateTo}','dd/mm/yyyy')")
            ->when($request->cn_no != '', function ($q) {
                $q->where('invoice_headers_number', request()->cn_no);
            });
        $data = collect($query->get());

        if ($data->count() == 0) {
            echo "<h1 style='color:red'>Data not found</h1>";
            exit;
        }


        $data = $this->dumpOrders($data->pluck('ref_invoice_number')->toArray(), $data);
        $data = $this->dumpCustomer($data->pluck('customer_id')->toArray(), $data);

        $data = $this->dumpClaim($data->pluck('invoice_headers_number')->toArray(), $data);


        $arrData['data'] = $data;
        // return view($this->view, $arrData ?? []);
        $pdf = PDF::loadView($this->view, $arrData ?? [])
            // ->setPaper('a4', 'landscape')
            // ->setOption('header-right', "\n\n\n\n[page]/[topage] ")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', 3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode . '.pdf');
    }
}
