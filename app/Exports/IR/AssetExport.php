<?php

namespace App\Exports\IR;

use App\Models\IR\Views\PtirAssetHeadersView;
use App\Models\IR\Views\PtirAssetLinesView;
use App\Models\IR\Views\PtirAssetAdjustHeadersView;
use App\Models\IR\Views\PtirAssetAdjustLinesView;
// use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AssetExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function view(): View
    {
        if (request()->program_code == 'IRP0003') {
            
            $header = PtirAssetHeadersView::find(request()->id);
            $datas  = PtirAssetLinesView::where('header_id', request()->id)->get();
    
            return view('ir.assets.plan.export', compact('header', 'datas'));

        }elseif (request()->program_code == 'IRP0004') {

            $header = PtirAssetAdjustHeadersView::find(request()->id);
            $datas  = PtirAssetAdjustLinesView::where('header_id', request()->id)->orderBy('line_number')->get();
    
            return view('ir.assets.increase.export', compact('header', 'datas'));
        }
    }

    public function columnFormats(): array
    {
        return [
            'Q' => '#,##0.00',
            'R' => '#,##0.00',
            'S' => '#,##0.00',
            'T' => '#,##0.00',
            'U' => '#,##0.00',
            'V' => '#,##0.00',
        ];
    }
}
