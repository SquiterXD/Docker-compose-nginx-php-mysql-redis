<?php

namespace App\Http\Controllers\OM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OM\Customers;
use App\Models\OM\PaoBankAccountV;
use App\Models\OM\TranspotReportModel;
use App\Models\OM\PtomAllTaxRateV;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\PtomPaoTaxMt;
use App\Models\OM\PaoAccountNameV;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\HRLocationV;
use App\Models\OM\PtomPaoPercent;
use App\Models\OM\SoOutstandingV;

use Carbon\Carbon;
use FormatDate;
use PDF;
use Symfony\Component\VarDumper\Cloner\Data;
use Illuminate\Support\Facades\DB;

class TransferTxtToBankController extends Controller
{
    public function index()
    {
        $bankLists = PaoBankAccountV::all();

        return view('om.transfer_txt_to_bank.index', compact('bankLists'));
    }

    public function pdf(Request $request)
    {
        $bank = $request->bank;
        $customer_type = $request->customer_type;
        $customer_id = $request->customer_id;
        $check_date = Carbon::createFromFormat('d/m/Y', $request->check_date)->subYear(543)->format('Y-m-d');
        $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->subYear(543)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->subYear(543)->format('Y-m-d');

        $groupDatas = [];

        if($customer_type === 'p1'){

            $data = $this->composeDataP1($start_date, $end_date, $customer_id);

        }elseif($customer_type === 'mt'){

            $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);

            $data = $this->composeDataMt($start_date, $end_date, $customer_id);

        }else {
            return back()->withErrors('Customer type not valid.');
        }

        $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('d/m/Y');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('d/m/Y');

        $pdf = PDF::loadView('om.transfer_txt_to_bank.report.pdf._template',
            compact(
                'data',
                'bank',
                'customer_type',
                'customer_id',
                'check_date',
                'start_date',
                'end_date'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);

        return $pdf->stream('OMR0099.pdf');
    }

    public function txt(Request $request)
    {
        $bank = $request->bank;
        $customer_type = $request->customer_type;
        $customer_id = $request->customer_id;
        $customer = null;
        $check_date = Carbon::createFromFormat('d/m/Y', $request->check_date)->subYear(543)->format('dmY');
        $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->subYear(543)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->subYear(543)->format('Y-m-d');
        
        $end_month = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('n');
        $end_year = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y');
        $period_check_date = self::getMonthTh($end_month).' '.$end_year;

        $bankAccount = PaoBankAccountV::where('lookup_code', $bank)->first();
        $hrLocationV = HRLocationV::whereNotNull('attribute1')->where('attribute1', 'like', 'การยาสูบแห่งประเทศไทย%')->first();

        if($customer_type === 'p1'){

            $data = $this->composeDataP1($start_date, $end_date, $customer_id);

        }elseif($customer_type === 'mt'){

            $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);

            $data = $this->composeDataMt($start_date, $end_date, $customer_id);

        }else {
            return back()->withErrors('Customer type not valid.');
        }

        if($customer_id){
            $customer = Customers::find($customer_id);
        }

        // dd($data);

        $content = \View::make('om.transfer_txt_to_bank.report.txt._template')
        ->with([
            'bankAccount' => $bankAccount,
            'hrLocationV' => $hrLocationV,
            'check_date' => $check_date,
            'period_check_date' => $period_check_date,
            'data' => $data,
        ]);

        // Set the name of the text file
        $filename = ($customer_type === 'p1' ? 'DEBT_' : 'MT_').($customer_id ? $customer->customer_number.'_' : '').($check_date).'.txt';

        // Set headers necessary to initiate a download of the textfile, with the specified name
        $headers = array(
            'Content-Type' => 'plain/txt',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            'Content-Length' => strlen($content),
        );

        return \Response::make($content, 200, $headers);
    }

    public function getCustomer(Request $request)
    {
        $type = $request->type;
        $data = [];
        if($type == 'p1'){
            $data = Customers::active()
                ->whereNotIn('customer_type_id', [20, 30])
                ->whereRaw("upper(sales_classification_code) = 'DOMESTIC'")
                ->get();
        }
        if($type == 'mt'){
            $data = Customers::active()
            ->whereIn('customer_type_id', [20])
            ->whereRaw("upper(sales_classification_code) = 'DOMESTIC'")
            ->get();
        }

        return response()->json($data);
    }

    private function composeDataP1($start, $end, $customer_id)
    {
        $case_1 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคตะวันตก' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคเหนือ' then
                4
            when ptom_customers.region_code = 'ภาคใต้' then
                5
            else
                6
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_customers.attribute2) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->when($customer_id, function($q, $customer_id){
            return $q->where('ptom_so_outstanding_v.customer_id', $customer_id);
        })
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name = ptom_customers.attribute2
            and ptom_customers.province_name <> ptom_customers.attribute2
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity <= 10
        ");

        $case_2 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคตะวันตก' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคเหนือ' then
                4
            when ptom_customers.region_code = 'ภาคใต้' then
                5
            else
                6
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_customers.province_name) province_name,
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            (case when round(ptom_so_outstanding_v.approve_quantity * ptom_pao_percent_inv.tax_pao_percent / 100, -1) > ptom_so_outstanding_v.approve_quantity then 
                ptom_so_outstanding_v.approve_quantity 
            else 
                round(ptom_so_outstanding_v.approve_quantity * ptom_pao_percent_inv.tax_pao_percent / 100, -1) 
            end) as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->when($customer_id, function($q, $customer_id){
            return $q->where('ptom_so_outstanding_v.customer_id', $customer_id);
        })
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name = ptom_customers.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity > 10
        ");

        $case_3 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคตะวันตก' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคเหนือ' then
                4
            when ptom_customers.region_code = 'ภาคใต้' then
                5
            else
                6
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_pao_percent_inv.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            (case when ptom_so_outstanding_v.approve_quantity - round(ptom_so_outstanding_v.approve_quantity * (100 - ptom_pao_percent_inv.tax_pao_percent) / 100, -1) < 0 then 
                0 
            else ptom_so_outstanding_v.approve_quantity - round(ptom_so_outstanding_v.approve_quantity * (100 - ptom_pao_percent_inv.tax_pao_percent) / 100, -1) 
            end) as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->when($customer_id, function($q, $customer_id){
            return $q->where('ptom_so_outstanding_v.customer_id', $customer_id);
        })
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name <> ptom_customers.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity > 10
        ");

        $case_4 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคตะวันตก' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคเหนือ' then
                4
            when ptom_customers.region_code = 'ภาคใต้' then
                5
            else
                6
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            100 as tax_pao_percent,
            to_char(ptom_so_outstanding_v.province_code) province_code,
            to_char(ptom_customers.attribute2) province_name,
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity as p_qty
        ")
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->when($customer_id, function($q, $customer_id){
            return $q->where('ptom_so_outstanding_v.customer_id', $customer_id);
        })
        ->whereRaw("
            1=1
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and order_header_id not in (
                select distinct order_header_id  
                from ptom_pao_percent_inv 
            )
        ");

        $case_5 = SoOutstandingV::selectRaw("        
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคตะวันตก' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคเหนือ' then
                4
            when ptom_customers.region_code = 'ภาคใต้' then
                5
            else
                6
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_customers.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->when($customer_id, function($q, $customer_id){
            return $q->where('ptom_so_outstanding_v.customer_id', $customer_id);
        })
        ->whereRaw("
            1=1
            and ptom_customers.attribute2 = ptom_customers.province_name
            and ptom_customers.attribute2 = ptom_pao_percent_inv.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity <= 10
        ");

        $province_orders = $case_1->union($case_2)
            ->union($case_3)
            ->union($case_4)
            ->union($case_5)
            ->orderByRaw("region_order asc, province_name asc, customer_name asc")
            ->get();

        $tax = PtomAllTaxRateV::whereDate('start_date_active', '<=', $start)
            ->where(function ($q) use ($end) {
                $q->whereDate('end_date_active', '>=', $end);
                $q->orWhereNull('end_date_active');
            })->first();

        $tax_rate = $tax->tag == null || $tax->tag == 0 ? 1 : $tax->tag;

        $groupProvinceDatas = $province_orders->groupBy([
        function ($item) {
            return $item->province_name ?? '';
        },
        function ($item) {
            return $item->customer_id ?? '';
        },
        ]);

        // dd( $groupProvinceDatas);

        $data = collect();

        foreach ($groupProvinceDatas as $province_name => $groupCustomer) {
            foreach ($groupCustomer as $customer_id => $items) {

                $customer = Customers::find($customer_id);
                $ship = optional(DB::table('ptom_customer_ship_sites')->where('customer_id', $customer->customer_id)->where('ship_to_site_name', 'อบจ')->first());
                $district = ($ship->address_line1 ?? $customer->address_line1).' '.($ship->alley ?? $customer->alley).' '.($ship->district ?? $customer->district);
                $postal = ($ship->city ?? $customer->city).' '.($ship->province_name ?? $customer->province_name).' '.($ship->postal_code ?? $customer->postal_code);

                $qty = $items->sum(function ($item) {
                    return $item->p_qty;
                });

                if(round($qty, 2) == 0){
                    continue;
                }

                $amount = $qty * $tax_rate;

                $pao_account = PaoAccountNameV::where('description', $province_name)->first();

                $data->push([
                    'type' => 'p1',
                    'customer_name' => $customer->customer_name,
                    'customer_id' => $customer_id,
                    'pao_account_name' => optional($pao_account)->meaning,
                    'payee_address1' => ($ship->address_line1 ?? $customer->address_line1),
                    'payee_address2' => ($ship->alley ?? $customer->alley).' '.($ship->district ?? $customer->district),
                    'payee_address3' => ($ship->city ?? $customer->city).' '.($ship->province_name ?? $customer->province_name),
                    'post_code' => ($ship->postal_code ?? $customer->postal_code),
                    'district' => $district,
                    'postal' => $postal,
                    'quantity' => $qty,
                    'pao_tax_amount' => $amount,
                ]);
            }
        }

        return $data;
    }

    private static function composeDataMt($start_date, $end_date, $customer_id)
    {
        $year_start_date = $start_date->subYear(543)->format('Y');
        $month_no_start_date = $start_date->subYear(543)->format('m');
        $year_end_date = $end_date->subYear(543)->format('Y');
        $month_no_end_date = $end_date->subYear(543)->format('m');

        $groupDatas = PtomPaoTaxMt::selectRaw("
            item_id,
            quantity_cg,
            uom_code,
            adjust_amount,
            customer_id,
            province_id,
            (select distinct customer_name from ptom_customers where ptom_customers.customer_id = ptom_pao_tax_mt.customer_id and rownum = 1) as customer_name,
            (select distinct meaning from ptom_pao_account_name_v where ptom_pao_account_name_v.tag = ptom_pao_tax_mt.province_id and rownum = 1) as pao_account_name 
        ")
        ->whereBetween('year', [$year_start_date, $year_end_date])
        ->whereBetween('month_no', [$month_no_start_date, $month_no_end_date])
        ->when($customer_id, function($q, $customer_id){
            return $q->where('customer_id', $customer_id);
        })
        ->orderByRaw("NLSSORT(customer_name, 'NLS_SORT = THAI_DICTIONARY'), NLSSORT(pao_account_name, 'NLS_SORT = THAI_DICTIONARY')")
        ->get()
        ->groupBy([function ($item) {
            return $item->customer_id;
        }, function ($item) {
            return $item->pao_account_name;
        }]);

        $data = collect();

        foreach ($groupDatas as $customer_id => $groupCustomer) {
            foreach ($groupCustomer as $province_name => $items) {
                $customer = Customers::find($customer_id);
                $district = $customer->alley.' '.$customer->district;
                $postal = $customer->city.' '.$customer->province_name.' '.$customer->postal_code;
                $qty = 0;
                $tax = 0;
                foreach ($items as $key => $item) {
                    $qty += (float)convertUom($item->item_id, $item->quantity_cg, $item->uom_code, 'CGK');
                    $tax += $item->adjust_amount;
                }

                $data->push([
                    'type' => 'mt',
                    'customer_id' => $customer_id,
                    'customer_name' => $customer->customer_name,
                    'pao_account_name' => $province_name,
                    'payee_address1' => $customer->address_line1,
                    'payee_address2' => $customer->alley.' '.$customer->district,
                    'payee_address3' => $customer->city.' '.$customer->province_name,
                    'post_code' => $customer->postal_code,
                    'district' => $district,
                    'postal' => $postal,
                    'quantity' => $qty,
                    'pao_tax_amount' => $tax,
                ]);
            }
        }

        return $data;
    }

    private static function getMonthTh($month_num)
    {
        $month = [
            '1' => 'มกราคม',
            '2' => 'กุมภาพันธ์',
            '3' => 'มีนาคม',
            '4' => 'เมษายน',
            '5' => 'พฤษภาคม',
            '6' => 'มิถุนายน',
            '7' => 'กรกฎาคม',
            '8' => 'สิงหาคม',
            '9' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม'
        ];
        return $month[$month_num];
    }
}