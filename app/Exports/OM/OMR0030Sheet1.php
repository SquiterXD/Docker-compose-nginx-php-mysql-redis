<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Illuminate\Support\Facades\DB;

class OMR0030Sheet1  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
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
                ,retail_price
                ,item_code
                ,item_description
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
                ,round(sum(tax_amount), 2) as tax_amount
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
                ,so.customer_id
                ,item_code
                ,item_id
                ,item_description
                ,retail_price
                ,cus.attribute3
            order by retail_price asc, customer_type_id asc, item_code asc
        ";

        // dd($sql);
        $data =  DB::select($sql);
        $data = collect($data)->groupBy([
            function($item){
                return (int)((float)$item->retail_price * 0.02);
            },
            'item_code'
        ]);
        // dd($data);
        $taxAdjust = collect(DB::select("
            select
                nvl(sum(oaom_tax_adjust), 0) total
                ,item_code
            from ptom_ar_interfaces
            where
                interface_type = 'Invoice'
                and group_id not in (SELECT group_id FROM ptom_ar_interfaces WHERE interface_status = 'E' GROUP BY GROUP_ID)
                and interface_status = 'C'
                and trunc(invoice_date) between to_date('$request->from_date', 'dd/mm/yyyy') and to_date('$request->to_date', 'dd/mm/yyyy')
            group by item_code
        "));

        $adjust = collect(DB::select("
            select
                item_id,
                item_code,
                segment9,
                segment10,
                sum(entered_dr) as Dr,
                sum(accounted_cr) as Cr
            from
                ptom_gl_interfaces GL,
                ptom_sequence_ecoms ITEM
            where
                segment9 = main_account_code
                and segment10 = sub_account_code
                and currency_code = 'THB'
                AND trunc(accounting_date) between to_date('$request->from_date', 'dd/mm/yyyy') and to_date('$request->to_date', 'dd/mm/yyyy')
                and segment9 = '411100'
                and GL.program_code = 'OMP0043'
            group by
                item_id,
                item_code,
                segment9,
                segment10
        "));

        $pao = collect(DB::select("
            select 
                cust.customer_id
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
                cust.customer_id
                ,mt.item_code
        "));

        $stamp = collect(DB::select("select * from ptpp_formula_stamp_v"));

        // dd($taxAdjust, $adjust);
        // dd($data, $sql);
        // $group_list_price = collect($data)->groupBy('attribute1');
        // $group_mt = collect($data)->where('customer_type_id','20')->groupBy('customer_type_id ');
        // $group_p1 = collect($data)->where('customer_type_id','10')->groupBy('customer_type_id ');

        // dd($group_list_price, $group_mt, $request->all(),$data);
        // dd($group_mt);

        return view('om.reports.omr0030.sheet1', compact('user', 'request', 'data', 'taxAdjust', 'adjust', 'stamp', 'pao'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 22,
            'C' => 22,
            'D' => 22,
            'E' => 22,
            'F' => 22,
            'G' => 22,
            'H' => 22,
            'I' => 22,
            'J' => 22,
            'K' => 22,
            'L' => 22,
            'M' => 22,
            'N' => 22,
            'O' => 22,
            'P' => 22,
            'Q' => 22,
            'R' => 22,
            'S' => 22,
            'T' => 22,
            'U' => 22,
            'V' => 22,
            'W' => 22,
            'X' => 22,
            'Y' => 22,
            'Z' => 22,
            'AA' => 22,
            'AB' => 22,
            'AC' => 22,
            'AD' => 22,
            'AE' => 22,
            'AF' => 22,
            'AG' => 22,
            'AH' => 22,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#,##0.00',
            'C' => '#,##0.00',
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.00',
            'G' => '#,##0.00',
            'H' => '#,##0.00',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'O' => '#,##0.00',
            'P' => '#,##0.00',
            'Q' => '#,##0.00',
            'R' => '#,##0.00',
            'S' => '#,##0.00',
            'T' => '#,##0.00',
            'U' => '#,##0.00',
            'V' => '#,##0.00',
            'W' => '#,##0.00',
            'X' => '#,##0.00',
            'Y' => '#,##0.00',
            'Z' => '#,##0.00',
            'AA' => '#,##0.00',
            'AB' => '#,##0.00',
            'AC' => '#,##0.00',
            'AD' => '#,##0.00',
            'AE' => '#,##0.00',
            'AF' => '#,##0.00',
            'AG' => '#,##0.00',
            'AH' => '#,##0.00',
        ];
    }

}

