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

class PMR1030 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        if (request()->report_type == "by_product_code") {
            return [
                'D' => '#,##0.00',
                'F' => '#,##0.000000000',
                'I' => '#,##0.000000',
                'K' => '#,##0.000000000',
                'L' => '#,##0.00',
            ];
        } else {
            return [
                'D' => '#,##0.00',
                'F' => '#,##0.000000000',
                'J' => '#,##0.000000',
                'L' => '#,##0.000000000',
                'M' => '#,##0.00',
            ];
        }
    }


    public function view(): View
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        // $summary   = $findData->summary;
        // $wipStep    = $findData->wipStep;
        $programCode = request()->program_code;

        if (request()->report_type == "by_product_code") {
            $viewName = 'pm.reports.pmr1030.excel.index';
        } else {
            // by_cat_mat ต้นทุน
            $viewName = 'pm.reports.pmr1030.excel.index_by_cat_mat';
        }
        return view($viewName, compact('reportData', 'profile', 'datas'));
    }

    public function pdf()
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        // $summary   = $findData->summary;
        // $wipStep    = $findData->wipStep;
        $programCode = request()->program_code;

        if (request()->report_type == "by_product_code") {
            $viewName = 'pm.reports.pmr1030.pdf.index';
        } else {
            // by_cat_mat ต้นทุน
            $viewName = 'pm.reports.pmr1030.pdf.index_by_cat_mat';
        }

        $pdf = \PDF::loadView($viewName, compact('reportData', 'profile', 'datas'))
            ->setOption('header-html', view('pm.reports.pmr1030.pdf.header', compact('reportData', 'profile'))->render())
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

        $startDate = Carbon::createFromFormat("d/m/Y", request()->date_from)->format('Y-m-d');
        $endDate = Carbon::createFromFormat("d/m/Y", request()->date_to)->format('Y-m-d');

        if (request()->report_type == "by_product_code") {
            $datas = collect(\DB::select("
                SELECT
                    TRUNC(TRANSACTION_DATE)  as TRANSACTION_DATE
                    , PRODUCT_CODE
                    , PRODUCT_DESC
                    , PRODUCT_QTY
                    , PRODUCT_UOM
                    , MAT_CODE
                    , MAT_DESC
                    , SUM(MAT_QTY)            as MAT_QTY
                    , MAT_UOM
                    , ACTUAL_COST
                    , SUM(TOTAL_COST)         as TOTAL_COST
                    , to_char(ppp.transaction_date, 'YYYY-MM-DD') transaction_date_char
                FROM    PTPM_ISSUE_CTR_1030_V ppp
                WHERE   1=1
                and     organization_id = $organizationId
                and     TRUNC(transaction_date) >= to_date('$startDate', 'YYYY-MM-DD')
                and     TRUNC(transaction_date) <= to_date('$endDate', 'YYYY-MM-DD')
                --and     PRODUCT_CODE = '15900001'
                group by
                        TRUNC(TRANSACTION_DATE)
                        , to_char(ppp.transaction_date, 'YYYY-MM-DD')
                        , PRODUCT_CODE
                        , PRODUCT_DESC
                        , PRODUCT_QTY
                        , PRODUCT_UOM
                        , MAT_CODE
                        , MAT_DESC
                        , MAT_UOM
                        , ACTUAL_COST
                order by transaction_date, product_code, mat_code
            "));
        } else {
            // by_cat_mat ต้นทุน
            $datas = collect(\DB::select("
                SELECT
                    TRUNC(TRANSACTION_DATE)  as TRANSACTION_DATE
                    , PRODUCT_CODE
                    , PRODUCT_DESC
                    , PRODUCT_QTY
                    , PRODUCT_UOM
                    , CAT_MAT
                    , MAT_CODE
                    , MAT_DESC
                    , SUM(MAT_QTY)            as MAT_QTY
                    , MAT_UOM
                    , ACTUAL_COST
                    , SUM(TOTAL_COST)         as TOTAL_COST
                    , to_char(ppp.transaction_date, 'YYYY-MM-DD') transaction_date_char
                FROM    PTPM_ISSUE_CTR_1030_V ppp
                WHERE   1=1
                and     organization_id = $organizationId
                and     TRUNC(transaction_date) >= to_date('$startDate', 'YYYY-MM-DD')
                and     TRUNC(transaction_date) <= to_date('$endDate', 'YYYY-MM-DD')
                --and     PRODUCT_CODE = '15900001'
                group by
                        TRUNC(TRANSACTION_DATE)
                        , to_char(ppp.transaction_date, 'YYYY-MM-DD')
                        , PRODUCT_CODE
                        , PRODUCT_DESC
                        , PRODUCT_QTY
                        , PRODUCT_UOM
                        , CAT_MAT
                        , MAT_CODE
                        , MAT_DESC
                        , MAT_UOM
                        , ACTUAL_COST
                order by transaction_date, product_code, cat_mat, mat_code
            "));
        }


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

        if ($departmentdesc && ($organizationCode == 'MG6')) {
            $departmentdesc = 'ฝ่ายผลิตภัณฑ์สำเร็จรูป ' . $departmentdesc;
        }

        $reportData = (object) [
            'name1'             => "การยาสูบแห่งประเทศไทย ". $departmentdesc,
            'name2'             => "รายงานผลผลิต(สารปรุง,สินค้าทดลอง)",
            'name3'             => "วันที่เบิกจ่าย ". parseToDateTh($startDate) ." ถึง " . parseToDateTh($endDate),
            'organization_name' => session()->get('organization_name', ''),
            'department_desc'   => $departmentdesc,
            'date'              => $sysdate->addYear(543)->format('d/m/Y'),
            'time'              => $sysdate->addYear(543)->format('H:i'),
        ];


        // $wipStep = WipStepV::where('organization_code', $organizationCode)
        //             ->where('wip_step', $wipStep)
        //             ->orderByRaw("wip_step, wip_step_desc")
        //             ->first();
        return (object)[
            'reportData' => $reportData,
            'profile' => $profile,
            'datas' => $datas,
            // 'summary' => $summary,
            // 'wipStep' => $wipStep,
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
        if (request()->report_type == "by_product_code") {
            return [
                'A' => 15,
                'B' => 20,
                'C' => 35,
                'D' => 15,
                'E' => 15,
                'F' => 20,
                'G' => 25,
                'H' => 90,
                'I' => 15,
                'J' => 10,
                'K' => 15,
                'L' => 15,
            ];
        } else {
            return [
                'A' => 15,
                'B' => 20,
                'C' => 35,
                'D' => 15,
                'E' => 15,
                'F' => 20,
                'G' => 20,
                'H' => 25,
                'I' => 90,
                'J' => 15,
                'K' => 10,
                'L' => 15,
                'M' => 15,
            ];
        }
    }

}

