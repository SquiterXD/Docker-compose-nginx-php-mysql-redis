<?php

namespace App\Exports\IR;

use App\Models\IR\Views\PtirVehiclesView;
use App\Models\HrOperatingUnits;
// use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VehicleExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $dataList  = PtirVehiclesView::get();
        $org       = HrOperatingUnits::where('organization_id', '121')->first();
        $orgName   = $org ? $org->name : '';

        return view('ir.settings.vehicle.export.index', compact('dataList', 'orgName'));
    }
}
