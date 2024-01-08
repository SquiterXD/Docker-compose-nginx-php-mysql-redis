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

class PMR3090 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }


    public function view(): View
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        $samples    = $findData->samples;
        $free       = $findData->free;

        return view('pm.reports.pmr3090.excel.index', compact('reportData', 'profile', 'datas', 'samples', 'free'));
    }

    public function findData()
    {
        $organizationId = session('organization_id');
        $organizationCode = session('organization_code');
        $wipStep = request()->wip_step;

        // $startDate = Carbon::parse($biweekly->start_date)->format('Y-m-d');
        // $endDate = Carbon::parse($biweekly->end_date)->format('Y-m-d');
        $startDate = Carbon::createFromFormat('d/m/Y', request()->date_from)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', request()->date_to)->format('Y-m-d');

        $datas = collect(\DB::select("
            SELECT
               item_code, item_desc, product_size, size_desc
                , sum(regular) regular
                , sum(ot) ot
                , sum(total) total
            FROM PTPM_PRODUCT_PDS0390_V ppp
            WHERE   1=1
            and     organization_id = $organizationId
            and     wip_step = '$wipStep'
            and     TRUNC(product_date) >= to_date('$startDate', 'YYYY-MM-DD')
            and     TRUNC(product_date) <= to_date('$endDate', 'YYYY-MM-DD')
            group by item_code, item_desc, product_size, size_desc
            order by product_size desc, item_code
        "));

        $samples = collect(\DB::select("
            SELECT
               item_code, item_desc
                , sum(sample_qty) sample_qty
            FROM PTPM_PRODUCT_PDS0390_V ppp
            WHERE   1=1
            and     organization_id = $organizationId
            and     wip_step = '$wipStep'
            and     TRUNC(product_date) >= to_date('$startDate', 'YYYY-MM-DD')
            and     TRUNC(product_date) <= to_date('$endDate', 'YYYY-MM-DD')
            and     nvl(sample_qty, 0) > 0
            group by item_code, item_desc
            order by  item_code
        "));

        $free = collect(\DB::select("
            SELECT
               item_number as item_code, item_desc
                , sum(transaction_qty) transaction_qty
            FROM ptpm_free_pdr0280_v ppp
            WHERE   1=1
            and     organization_id = $organizationId
            and     to_date(transaction_date, 'DD-MM-YYYY') >= to_date('$startDate', 'YYYY-MM-DD')
            and     to_date(transaction_date, 'DD-MM-YYYY') <= to_date('$endDate', 'YYYY-MM-DD')
            and     nvl(transaction_qty, 0) > 0
            group by item_number, item_desc
            order by  item_number
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

        $wipStep = WipStepV::where('organization_code', $organizationCode)
                    ->where('wip_step', $wipStep)
                    ->orderByRaw("wip_step, wip_step_desc")
                    ->first();

        $reportData = (object) [
            'name'              => "รายงานผลผลิตบุหรี่สำเร็จรูป ฝ่ายผลิตภัณฑ์สำเร็จรูป ". $departmentdesc,
            'organization_name' => session()->get('organization_name', ''),
            'department_desc'   => 'ฝ่ายผลิตภัณฑ์สำเร็จรูป ' . $departmentdesc,
            'wip_desc'          => $wipStep->wip_step_desc,
            'data_range_th'     => "ตั้งแต่วันที่ " . formatLongDateThai($startDate) . " ถึงวันที่ ". formatLongDateThai($endDate),
            'date'              => $sysdate->addYear(543)->format('d/m/Y'),
            'time'              => $sysdate->addYear(543)->format('H:i'),
        ];

        return (object)[
            'reportData' => $reportData,
            'profile' => $profile,
            'datas' => $datas,
            'samples' => $samples,
            'free' => $free,
            // 'summary' => $summary,
            'wipStep' => $wipStep,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 20,
            'F' => 25,
            'G' => 20,
        ];
    }

}

