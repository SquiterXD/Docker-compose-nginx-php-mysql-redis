<?php

namespace App\Exports\PM;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Models\CT\PtctCostTransactionsV;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


use App\Models\PM\PtBiweekly;
use App\Models\ProgramInfo;
use App\Models\PM\Settings\WipStepV;


use FormatDate;
use Carbon\Carbon;

class PMR0180 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        // return [
        //     // 'C' => NumberFormat::FORMAT_NUMBER,
        //     'H' => '#,##0.00',
        // ];
    }


    public function view(): View
    {
        // $findData   = $this->findData();
        // $reportData = $findData->reportData;
        // $profile    = $findData->profile;
        // $datas      = $findData->datas;
        // return view('pm.reports.pmr0041.excel.index', compact('reportData', 'profile', 'datas'));
    }

    public function pdf()
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        $summary   = $findData->summary;
        $wipStep    = $findData->wipStep;
        $programCode = request()->program_code;

        $pdf = \PDF::loadView('pm.reports.pmr0180.pdf.index', compact('reportData', 'profile', 'datas', 'summary', 'wipStep'))
            ->setOption('header-html', view('pm.reports.pmr0180.pdf.header', compact('reportData', 'profile', 'wipStep'))->render())
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-top', 25)
            // ->setOption('margin-top', 50)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode .'.pdf');
    }

    public function findData()
    {
        $organizationId = session('organization_id');
        $organizationCode = session('organization_code');
        $wipStep = request()->wip_step;

        $biweekly = PtBiweekly::selectRaw("
                PT_BIWEEKLY.*
                , 'ที่ ' || biweekly
                    || ' วันที่ ' || to_char(PT_BIWEEKLY.start_date, 'DD', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai')
                    || ' - ' || to_char(PT_BIWEEKLY.end_date,'DD ','nls_calendar=''Thai Buddha''nls_date_language = Thai')
                    || TRIM(to_char(PT_BIWEEKLY.end_date,'MONTH','nls_calendar=''Thai Buddha''nls_date_language = Thai'))
                    || ' ' || to_char(PT_BIWEEKLY.end_date,'YYYY','nls_calendar=''Thai Buddha''nls_date_language = Thai')
                    biweekly_desc
            ")
            ->where('biweekly_id', request()->biweekly_id)
            ->first();
        // dd('xx', $biweekly);


        $startDate = Carbon::parse($biweekly->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($biweekly->end_date)->format('Y-m-d');
        $datas = collect(\DB::select("
            SELECT
               ppp.*
               , to_char(ppp.product_date, 'YYYY-MM-DD') product_date_char
            FROM PTPM_PRODUCT_PDR0180_V ppp
            WHERE   1=1
            and     organization_id = $organizationId
            and     wip_step = '$wipStep'
            and     TRUNC(product_date) >= to_date('$startDate', 'YYYY-MM-DD')
            and     TRUNC(product_date) <= to_date('$endDate', 'YYYY-MM-DD')
            order by product_date, item_code
        "));


        $summary = collect(\DB::select("
            SELECT
                item_code
                , item_desc
                , sum(t0730_1130) as t0730_1130
                , sum(t1230_1630) as t1230_1630
                , sum(t1130_1230) as t1130_1230
                , sum(t1630_2030) as t1630_2030
                , sum(regular) as regular
                , sum(ot) as ot
                , sum(total) as total
            FROM PTPM_PRODUCT_PDR0180_V ppp
            WHERE   1=1
            and     organization_id = $organizationId
            and     wip_step = '$wipStep'
            and     TRUNC(product_date) >= to_date('$startDate', 'YYYY-MM-DD')
            and     TRUNC(product_date) <= to_date('$endDate', 'YYYY-MM-DD')
            group by item_code, item_desc
            order by item_code, item_desc
        "));



        $program = ProgramInfo::where('program_code', request()->program_code)->first();
        $profile = getDefaultData();
        $departmentdesc = '';
        $sysdate = now();
        $org = \App\Models\MtlParameter::where('organization_id', $profile->organization_id)->first();
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $departmentdesc = $dept->description;
            }
        }

        $reportData = (object) [
            'name'              => optional($program)->description . $biweekly->biweekly_desc,
            'organization_name' => session()->get('organization_name', ''),
            'department_desc'   => 'ฝ่ายผลิตภัณฑ์สำเร็จรูป ' . $departmentdesc,
            'date'              => $sysdate->addYear(543)->format('d/m/Y'),
            'time'              => $sysdate->addYear(543)->format('H:i'),
        ];


        $wipStep = WipStepV::where('organization_code', $organizationCode)
                    ->where('wip_step', $wipStep)
                    ->orderByRaw("wip_step, wip_step_desc")
                    ->first();
        return (object)[
            'reportData' => $reportData,
            'profile' => $profile,
            'datas' => $datas,
            'summary' => $summary,
            'wipStep' => $wipStep,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // $sheet->setShowGridlines(false);
        // $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

    public function columnWidths(): array
    {
        // return [
        //     'A' => 20,
        //     'B' => 20,
        //     'C' => 20,
        //     'D' => 10,
        //     'E' => 20,
        //     'F' => 30,
        //     'G' => 30,
        //     'H' => 15,
        //     'I' => 10,
        // ];
    }

}

