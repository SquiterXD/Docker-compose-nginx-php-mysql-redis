<?php

namespace App\Exports\IR;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;

class StockExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function view(): View
    {
        // dd(request()->all());
        if (request()->program_code == 'IRP0001') {
            
            $header = PtirStockHeaders::find(request()->id);
            $datas  = PtirStockLines::where('header_id', request()->id)->orderBy('line_number')->get();

            return view('ir.stocks.yearly.export', compact('header', 'datas'));

        } elseif (request()->program_code == 'IRP0002') {
            
            $header = PtirStockHeaders::find(request()->id);
            $datas  = PtirStockLines::where('header_id', request()->id)->orderBy('line_number')->get();

            // dd('z', request()->all(), $datas);

            return view('ir.stocks.monthly.export', compact('header', 'datas'));
        }
        
    }

    public function columnFormats(): array
    {
        return [
            'O' => '#,##0.00',
            'P' => '#,##0.00',
            'Q' => '#,##0.00',
            'R' => '#,##0.00',
            'S' => '#,##0.00',
        ];
    }
}
