<?php

namespace App\Exports\IR;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use App\Models\IR\Cars;
use App\Models\IR\PtirCars;

class CarExport implements FromView, ShouldAutoSize, WithColumnFormatting
{

    public function view(): View
    {
        $carIds = explode(',' , request()->data_table);

        $datas  = PtirCars::whereIn('car_id', $carIds)->orderBy('document_number', 'desc')->get();
        // dd(request()->all(), $carIds, $datas);

        return view('ir.cars.export', compact('datas'));
    }

    public function columnFormats(): array
    {
        return [
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
            'P' => '#,##0.00',
        ];
    }
}
