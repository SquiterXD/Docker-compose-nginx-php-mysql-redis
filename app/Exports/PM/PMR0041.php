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


use FormatDate;
use Carbon\Carbon;

class PMR0041 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        return [
            // 'C' => NumberFormat::FORMAT_NUMBER,
            'H' => '#,##0.00',
        ];
    }


    public function view(): View
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        return view('pm.reports.pmr0041.excel.index', compact('reportData', 'profile', 'datas'));
    }

    public function pdf()
    {
        $findData   = $this->findData();
        $reportData = $findData->reportData;
        $profile    = $findData->profile;
        $datas      = $findData->datas;
        $programCode = request()->program_code;
        $pdf = \PDF::loadView('pm.reports.pmr0041.pdf.index', compact('reportData', 'profile', 'datas'))
            ->setOption('header-html', view('pm.reports.pmr0041.pdf.header', compact('reportData', 'profile'))->render())
            ->setPaper('a4','landscape')
            // ->setOption('header-right',"\n\n\n\n[page]/[topage] ")
            // ->setOption('header-font-name',"THSarabunNew")
            ->setOption('margin-top', 25)
            // ->setOption('header-font-size',13)
            // ->setOption('header-spacing', 5)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode .'.pdf');
    }

    public function findData()
    {
        $productDateFrom    = Carbon::createFromFormat('d/m/Y', request()->product_date_from)->format('Y-m-d');
        $productDateTo      = Carbon::createFromFormat('d/m/Y', request()->product_date_to)->format('Y-m-d');
        $organizationId     = session('organization_id');
        $programCode        = request()->program_code;

        $datas = collect(\DB::select("
            SELECT
                h.product_date
                , h.transfer_date
                , l.subinventory_to
                , to_char(h.product_date, 'DD/MM/YYYY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') product_date_th
                , to_char(h.transfer_date, 'DD/MM/YYYY', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai') transfer_date_th
                , h.transfer_number
                , msi.segment1                  item_number
                , msi.description               item_desc
                , l.lot_number
                , l.web_qty                     qty
                , iu.unit_of_measure            uom
                --, h.*
                --, l.*
            FROM OAPM.PTPM_PRODUCT_TRANSFER_H h
                , OAPM.PTPM_PRODUCT_TRANSFER_L l
                , mtl_system_items_b msi
                , PTINV_UOM_V iu
            WHERE   1=1
            and     h.transfer_header_id = l.transfer_header_id
            AND     h.organization_id = msi.organization_id
            AND     l.inventory_item_id = msi.inventory_item_id
            and     l.web_uom = iu.uom_code
            and     h.program_code = 'PMP0041'
            and     transfer_status = 2
            and     h.organization_id = $organizationId
            and     TRUNC(product_date) >= to_date('$productDateFrom', 'YYYY-MM-DD')
            and     TRUNC(product_date) <= to_date('$productDateTo', 'YYYY-MM-DD')
            order by h.product_date, h.transfer_number
        "));

        $profile = getDefaultData();
        $departmentdesc = '';
        $org = \App\Models\MtlParameter::where('organization_id', $profile->organization_id)->first();
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $departmentdesc = $dept->description;
            }
        }

        $reportData = (object) [
            'name' => 'รายงานสรุปประจำวัน บุหรี่รับเข้าคลัง',
            'organization_name' => session()->get('organization_name', ''),
            'department_desc'   => $departmentdesc,
            'date'              => Carbon::now()->addYear(543)->format('d/m/Y'),
            'time'              => Carbon::now()->addYear(543)->format('H:i'),
        ];

        return (object)[
            'reportData' => $reportData,
            'profile' => $profile,
            'datas' => $datas,
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
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 10,
            'E' => 20,
            'F' => 30,
            'G' => 30,
            'H' => 15,
            'I' => 10,
        ];
    }

}

