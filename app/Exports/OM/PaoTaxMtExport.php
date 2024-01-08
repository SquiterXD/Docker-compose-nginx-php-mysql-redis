<?php

namespace App\Exports\OM;

use App\Models\OM\PtomPaoTaxMt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PaoTaxMtExport implements FromView, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    public function __construct($year, $monthNo, $customer, $data, $defaultItems)
    {
        $this->year = $year;
        $this->monthNo = $monthNo;
        $this->customer = $customer;
        $this->data = $data;
        $this->defaultItems = $defaultItems;
    }

    public function view(): View
    {
        return view('om.pao_tax_mt._example_template', [
            'year' => $this->year,
            'monthNo' => $this->monthNo,
            'customer' => $this->customer,
            'data' => $this->data,
            'defaultItems' => $this->defaultItems,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet
                ->getPageSetup()
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }
}
