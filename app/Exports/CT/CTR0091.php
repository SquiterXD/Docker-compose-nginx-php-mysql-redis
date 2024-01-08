<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
class CTR0091  extends DefaultValueBinder implements WithCustomValueBinder , FromView, WithColumnWidths, WithColumnFormatting
{
    public function view(): View
    {
        $request = request();
        $apIn  = PtctMfgBatchGenWipend::where('ct_product_code', 100600098)->limit(10)->get();
        $apIn= PtctMfgBatchGenWipend::where('ct_product_code', $request->CT_PRODUCT_CODE)
        ->where('ct_dept_code', $request->ct_dept_code)
        ->whereNotNull('ct_dm_group')
        ->where('ct_cc_code', $request->ct_cc_code);

        if($request->startdate != 'Invalid date' && $request->enddate != 'enddate')
        $apIn->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN
        to_date('".$request->startdate."', 'DD/MM/YY')  AND to_date('".$request->enddate."', 'DD/MM/YY')");

        $apIn =  $apIn->get();
        $apIn = $apIn->map(function($item){
            // dd($item);
            $item->ct_dm_aq_inwip  = (int)str_replace(',','',$item->ct_dm_aq_inwip);
            $item->ct_dm_ap_inwip = (int)str_replace(',','',$item->ct_dm_ap_inwip);
            $item->ct_dm_aqsp_inwip = (int)str_replace(',','',$item->ct_dm_aqsp_inwip);
            $item->ct_dm_aqap_inwip = (int)str_replace(',','',$item->ct_dm_aqap_inwip);
            return $item;
        });
        $dm_group = $apIn->groupBy('ct_dm_group');
        $dm_group = $dm_group->sortKeys();
        $dm_group = $dm_group->map(function($item){

            $vh = $item->first();
            $result = new  \stdClass;
            $result->ct_dm_group = $vh->ct_dm_group;
            $result->ct_dm_group_name = $vh->ct_dm_group_name;
            $result->ct_dm_aq_inwip = $item->sum('ct_dm_aq_inwip');
            $result->ct_dm_aqap_inwip = $item->sum('ct_dm_aqap_inwip');
            return $result;

        });

        //////////////////////////////////////////////////////////////////////////////////

        $dept_code= PtctMfgBatchGenWipend::
        whereNotNull('ct_dm_group')
        ->where('ct_cc_code', $request->ct_cc_code);

        if($request->startdate != 'Invalid date' && $request->enddate != 'enddate')
        $dept_code->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN
        to_date('".$request->startdate."', 'DD/MM/YY')  AND to_date('".$request->enddate."', 'DD/MM/YY')");

        $dept_code =  $dept_code->get();

        $dept_code = $dept_code->map(function($item){
            // dd($item);
            $item->ct_dm_aq_inwip  = (int)str_replace(',','',$item->ct_dm_aq_inwip);
            $item->ct_dm_ap_inwip = (int)str_replace(',','',$item->ct_dm_ap_inwip);
            $item->ct_dm_aqsp_inwip = (int)str_replace(',','',$item->ct_dm_aqsp_inwip);
            $item->ct_dm_aqap_inwip = (int)str_replace(',','',$item->ct_dm_aqap_inwip);
            return $item;
        });

        $dm_group_dept = $dept_code->groupBy('ct_dm_group');
        $dm_group_dept = $dm_group_dept->sortKeys();
        $dm_group_dept = $dm_group_dept->map(function($item){

            $vh = $item->first();
            $result = new  \stdClass;
            $result->ct_dm_group = $vh->ct_dm_group;
            $result->ct_dm_group_name = $vh->ct_dm_group_name;
            $result->ct_dm_aq_inwip = $item->sum('ct_dm_aq_inwip');
            $result->ct_dm_aqap_inwip = $item->sum('ct_dm_aqap_inwip');
            // $result->ct_prd_aqsp_wipcomplete = $item->sum('ct_prd_aqsp_wipcomplete');
            return $result;

        });

        return view('ct.reports.ctr0091.excel', compact('apIn','dm_group','dept_code','dm_group_dept'));
    }
    public function columnWidths(): array
    {
        return [
            'B' => 40,
            'C' => 15,
            'D' => 30,
            'E' => 14,
            'F' => 18,
            'G' => 18,
            'H' => 18,
            'I' => 18,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0.000000',
            'F' => '#,##0.000000',
            'G' => '#,##0.000000000',
            'H' => '#,##0.00',
        ];
    }

}

