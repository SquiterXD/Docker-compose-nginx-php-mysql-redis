<?php

namespace App\Exports\IR;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;

use App\Models\IR\Views\PtirReportStockV;
use App\Models\IR\Views\PtirReportAssetV;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;


use FormatDate;
use Carbon\Carbon;

class IRR6010 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            'C' => '#,##0.00',
            'D' => '#,##0.00',
            'E' => '#,##0.00',
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
        ];
    }
    // public function columnHi(): array
    // {
    //     return [
    //         'F' => '#,##0.0000',
    //         'G' => '#,##0.00',
    //         'H' => '#,##0.00',
    //         'I' => '#,##0.00',
    //         'J' => '#,##0.00',
    //         'K' => '#,##0.00',
    //         'L' => '#,##0.00',
    //         'M' => '#,##0.00',
    //         'N' => '#,##0.00',
    //         'O' => '#,##0.00',
    //         'P' => '#,##0.00',
    //         'Q' => '#,##0.00',
    //     ];
    // }

    public function view(): View
    {
        // dd(request()->all(),  $request);
        $data = [];
        $request            = (object)request()->all();
        // dd( $request );
        $hasCompanyAll      = $request->company_from    && $request->company_to;
        $noCompany          = !$request->company_from   && !$request->company_to;
        $startCompany       = $request->company_from    && !$request->company_to;
        $toCompany          = !$request->company_from    && $request->company_to;
        $hasCompany         = $request->company_from    || $request->company_to;

        // ini_set('max_execution_time', 1000);
        // set_time_limit(1000);
        // $date = [];
        // $start = date('Y-d-m', strtotime($request->from_month));

        // $yearFrom = date('Y', strtotime($request->from_month))+543;

        // $startMonth = Carbon::createFromDate($start)->format('M');
        // $backTOMonth    =  Carbon::createFromDate($start)->addMonths(-1)->format('M');

        // $periodName  = Carbon::createFromDate($start)->format('M-y');
        // $periodBackName  = Carbon::createFromDate($start)->format('M-y');

        // $fromMonth = FormatDate::Monthonly($startMonth);
        // $backMonth = FormatDate::Monthonly($backTOMonth);

        // $month = 'เดือนปิดบัญชี '. $fromMonth. ' '. $yearFrom;
        // $periodBackName =  'ข้อมูลคงคลังย้อนหลังของเดือน '.$backMonth.' '. $yearFrom;
        // $date['month'] = $month;
        // $date['month_off'] = $periodBackName;

        
    //         {#5736 ▼
    //   +"policy_set_header_from": "3"
    //   +"policy_set_header_to": "3"
    //   +"period_year": "2022"
    //   +"company_from": null
    //   +"company_to": null
    //   +"location_code_from": null
    //   +"location_code_to": null
    //   +"status": null
    //   +"program_code": "IRR6010"
    //   +"function_name": "IRR6010"
    //   +"output": "pdf"
    // }

        $assetsByPolicy = PtirReportAssetV::where('program_code','IRP0003')
                            ->whereBetween('policy_set_number', [(int)$request->policy_set_header_from, (int)$request->policy_set_header_to])
                            ->where('year_head' ,$request->period_year)
                            ->when($hasCompanyAll, function($q) use($request) {
                                $q->whereBetween('company_id', [(int)$request->company_from, (int)$request->company_to]);
                            })
                            ->when($startCompany, function($q) use($request) {
                                $q->where('company_id', '>=', $request->company_from);
                            })
                            ->when($toCompany, function($q) use($request) {
                                $q->where('company_id', '<=', $request->company_to);
                            })
                            ->when($request->status, function($q) use($request){
                                $q->where('status' , $request->status);
                            })
                            ->when($request->location_code_from ,function($q) use($request){
                                $q->where('location_code', '=>' ,  $request->location_code_from);
                            })
                            ->when($request->location_code_to ,function($q) use($request){
                                $q->where('location_code', '=>' ,  $request->location_code_to);
                            })
                            ->where('company_active_flag', 'Y')
                            ->orderBy('policy_set_number')
                            ->get() ;


        if(count($assetsByPolicy) == 0){
            return view('ir.reports.irr1010.not-found');
        }

        $strDate = FormatDate::DateThai($assetsByPolicy[0]->start_year_period);
        $endDate = FormatDate::DateThai($assetsByPolicy[0]->end_year_period);
        $dateDisplay =  $strDate. ' - ' . $endDate;

        if($hasCompany){
            $companies = $assetsByPolicy->unique('company_code');
            return view('ir.reports.irr6010.excel-company', compact('assetsByPolicy', 'companies', 'dateDisplay'));
        } else {
            return view('ir.reports.irr6010.excel', compact('assetsByPolicy', 'dateDisplay'));
        }

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);

        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $sheet->getStyle(0)->getAlignment()->getActiveSheet()->get
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');

        // getDefaultStyle
        // $sheet->setFontFamily('Comic Sans MS');
        // $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $sheet->getStyle('B2')->getFont()->setBold(true);
        // $sheet->getDefaultRowDimension()->setRowHeight(30, 'pt');
        // $sheet->getStyle('B1')->setFont();

    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 65,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 35,
        ];
    }


    // public function registerEvents(): array
    // {
    //     // return [
    //     //     AfterSheet::class    => function(AfterSheet $event) {
   
    //     //         $event->sheet->getDelegate()->getStyle(0)
    //     //                         ->getFont()
    //     //                         ->getColor()
    //     //                         ->setARGB('DD4B39');


    //     //         // $event->sheet->getDefaultRowDimension()->setRowHeight(30, 'pt');
   
    //     //     },
    //     // ];
    // }




}

//App\Models\IR\Views\PtirStockHeadersView
