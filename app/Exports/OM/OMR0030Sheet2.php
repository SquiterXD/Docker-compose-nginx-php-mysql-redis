<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Illuminate\Support\Facades\DB;

class OMR0030Sheet2  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
{
    public function view(): View
    {
        $request = request();
        $user = auth()->user();

        $sql = "
            select 
                (case when so.customer_type_id = '60' then 
                    'ป.1'
                when so.customer_type_id in ('10','20') then
                    customer_type_meaning
                when so.customer_type_id in ('30','40') then
                    customer_type_desc
                end) as customer_group 
                ,(case when so.customer_type_id = '60' then 
                    '10'
                when so.customer_type_id in ('10','20') then
                    so.customer_type_id
                when so.customer_type_id in ('30','40') then
                    so.customer_type_id
                end) customer_type_id
                ,so.customer_number
                ,so.customer_name
                ,item_code
                ,item_id
                ,(case when so.customer_type_id = '60' then 
                    sum(approve_quantity) 
                when so.customer_type_id in ('10','20') then
                    sum(approve_quantity) 
                when so.customer_type_id in ('30','40') then
                    sum(consignment_quantity)
                end) qty
                ,sum(
                    case
                    when so.customer_type_id not in (30,40,80)
                    then amount
                        else 0
                    end + case 
                    when so.customer_type_id in (30,40)
                    then consignment_amount
                        else 0
                    end
                ) as amount
                ,sum(retail_amount) as retail_amount
                ,round(sum(tax_amount), 2) as tax
                ,sum(pao_amount) as pao_amount
                ,cus.attribute3
            from ptom_so_outstanding_v so
                ,ptom_customers cus
            where 1=1
            and pick_release_status = 'Confirm'
            and cus.customer_id = so.customer_id
            and so.customer_type_id not in ('80')
            and product_type_code = '10'
            and nvl(consignment_date ,trunc(pick_release_approve_date)) between to_date('$request->from_date', 'dd/mm/yyyy') and to_date('$request->to_date', 'dd/mm/yyyy')
            group by 
                customer_type_desc
                ,customer_type_meaning
                ,so.customer_type_id
                ,so.customer_number
                ,so.customer_name
                ,item_code
                ,item_id
                ,cus.attribute3
            order by attribute3 asc nulls last, customer_type_id asc, customer_number asc
        ";

        $data =  DB::select($sql);
        $data = collect($data)->groupBy([
            function($item){
                return $item->attribute3 ?? $item->customer_group;
            }, 
            "customer_number"
        ])
        ->sortKeys();

        //// get tax
        $taxAdjust = collect(DB::select("
            select
                nvl(sum(oaom_tax_adjust), 0) total
                ,customer_number
            from ptom_ar_interfaces
            where
                interface_type = 'Invoice'
                and group_id not in (SELECT group_id FROM ptom_ar_interfaces WHERE interface_status = 'E' GROUP BY GROUP_ID)
                and interface_status = 'C'
                and trunc(invoice_date) between to_date('$request->from_date', 'dd/mm/yyyy') and to_date('$request->to_date', 'dd/mm/yyyy')
            group by customer_number
        "));

        //// get adjust tax
        //// find all customer_id
        $customers = DB::select("
            SELECT 
            PTOM_CUSTOMERS.CUSTOMER_ID 
                ,PTOM_CUSTOMERS.CUSTOMER_NUMBER
                ,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID
            FROM PTOM_CONSIGNMENT_HEADERS
                ,PTOM_CUSTOMERS
            WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
            AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID 
            AND TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')
            GROUP BY 
                PTOM_CUSTOMERS.CUSTOMER_ID 
                ,PTOM_CUSTOMERS.CUSTOMER_NUMBER
                ,PTOM_CUSTOMERS.CUSTOMER_TYPE_ID
            ORDER BY PTOM_CUSTOMERS.CUSTOMER_ID
        ");

        $adjust = collect();
        //// loop by customer_id
        foreach ($customers as $key => $customer) {

            //// get last consignment_date by customer
            if ($customer->customer_type_id == 30) {
                $last_date = DB::table('ptom_consignment_headers')
                ->where('ptom_consignment_headers.customer_id', $customer->customer_id)
                ->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')")
                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                ->first();
            } else {
                $last_date = DB::table('ptom_consignment_headers')
                ->where('ptom_consignment_headers.customer_id', $customer->customer_id)
                ->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')")
                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                ->first();
            }

            //// check has adjust
            $check_adjust = DB::table('ptom_tax_adjustments')->where('document_number', $last_date->consignment_no)->first();
            if(!$check_adjust){
                $adjust_amount = 0;
            }else {

                if ($customer->customer_type_id == 30) {

                    $vat_ad = DB::table('ptom_consignment_headers')
                    ->where('ptom_consignment_headers.customer_id', $customer->customer_id)
                    ->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')")
                    ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                    ->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT') ?? 0;

                    $vatr = DB::table('ptom_consignment_headers')
                    ->leftJoin('PTOM_TAX_ADJUSTMENTS_BKK', 'PTOM_TAX_ADJUSTMENTS_BKK.TAX_ADJUSTMENT_NO', 'PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO')
                    ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                    ->where('PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID', $customer->customer_id)
                    ->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')")
                    ->sum(DB::raw('nvl(PTOM_TAX_ADJUSTMENTS_BKK.TAX_ADJUST_AMOUNT, PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT)')) ?? 0;

                } else {

                    $vatt = DB::table('ptom_consignment_headers')
                    ->leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')
                    ->where('ptom_order_headers.customer_id', $customer->customer_id)
                    ->whereRaw("TRUNC(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) BETWEEN TO_DATE('$request->from_date', 'DD/MM/YYYY') AND TO_DATE('$request->to_date', 'DD/MM/YYYY')")
                    ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                    ->where('consignment_no', $last_date->consignment_no)
                    ->orderBy('ptom_consignment_headers.consignment_date', 'DESC')
                    ->first();

                    $vat_ad = optional($vatt)->vat_amount ?? 0;
                    $vatr = optional($check_adjust)->adjust_vat ?? 0;
                }

                $adjust_amount = round($vatr - $vat_ad, 2);
            }

            $adjust->push([
                'customer_id' => $customer->customer_id,
                'customer_number' => $customer->customer_number,
                'adjust_amount' => $adjust_amount
            ]);
        }

        $pao = collect(DB::select("
            select 
                cust.customer_number
                ,mt.item_code
                ,nvl(sum(pao_amount), 0) pao_amount
            from ptom_pao_tax_mt mt
                ,ptom_customers cust
            where 1=1
                and mt.customer_id = cust.customer_id
                and cust.customer_type_id = '20'
                and year >= to_number(to_char(to_date('$request->from_date', 'dd/mm/yyyy'), 'yyyy'))
                and year <= to_number(to_char(to_date('$request->to_date', 'dd/mm/yyyy'), 'yyyy'))
                and month_no >= to_number(to_char(to_date('$request->from_date', 'dd/mm/yyyy'), 'mm'))
                and month_no <= to_number(to_char(to_date('$request->to_date', 'dd/mm/yyyy'), 'mm'))
            group by 
                cust.customer_number
                ,mt.item_code
        "));
        
        $stamp = collect(DB::select("select * from ptpp_formula_stamp_v"));
        // dd($data, $sql, $pao);
        // $group_list_price = collect($data)->groupBy('attribute1');
        // $group_mt = collect($data)->where('customer_type_id','20')->groupBy('customer_type_id ');
        // $group_p1 = collect($data)->where('customer_type_id','10')->groupBy('customer_type_id ');

        // dd($group_list_price, $group_mt, $request->all(),$data);
        // dd($group_mt);

        return view('om.reports.omr0030.sheet2', compact('user', 'request', 'data', 'taxAdjust', 'adjust', 'pao', 'stamp'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 40,
            'C' => 10,
            'D' => 22,
            'E' => 22,
            'F' => 22,
            'G' => 22,
            'H' => 22,
            'I' => 22,
            'J' => 22,
            'K' => 25,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
        ];
    }

}

