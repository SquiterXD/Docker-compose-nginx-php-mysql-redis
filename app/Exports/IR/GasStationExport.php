<?php

namespace App\Exports\IR;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use App\Models\IR\PtirExtendGasStations;

class GasStationExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function view(): View
    {
        // dd(request()->all());
        // $PtirExtendGasStations
        $GasStationIds = explode(',' , request()->data_table);

        $datas  = PtirExtendGasStations::whereIn('ex_gas_station_id', $GasStationIds)->orderBy('document_number', 'desc')->get();

        return view('ir.gas-stations.export', compact('datas'));
        
    }

    public function columnFormats(): array
    {
        return [
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.00',
        ];
    }
}
