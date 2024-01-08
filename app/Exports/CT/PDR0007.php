<?php

namespace App\Exports\CT;

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
use App\Models\CT\PtctTtctrp97;
use App\Models\CT\Ptpd14EstimateMtSaleRv;
use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Models\PD\PtpdEstimateMtSaleHeader;
use App\Models\PD\PtdpTobaccoForecastV;
use App\Models\PD\PtdpSpeciesForecastV;

class PDR0007 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    public function columnFormats(): array
    {
        // if($this->ingredienTobaccoType['ingredien_tobacco_type'] == '1004'){
        //     return [
        //         'C:ZZ' => '#,##0.000000',
        //     ];
        // }else{
        //     return [
        //         'C:ZZ' => '#,##0.000',
        //     ];
        // }
        return [
            'C:ZZ' => '#,##0.000',
        ];
    }

    public function view(): View
    {
        $data = PtpdEstimateMtSaleHeader::find(request()->id);
        $ingredienTobaccoType = PtdpTobaccoForecastV::where('ingredien_tobacco_type', request()->ingredienTobaccoType)->first();
        $this->ingredienTobaccoType = $ingredienTobaccoType;
        $ingredienSpeciesType = PtdpSpeciesForecastV::where('tobacco_type_meaning', request()->ingredienSpeciesType)->first();

        $model = Ptpd14EstimateMtSaleRv::query()
                                        ->where('sales_fiscal_year_th', $data['sales_fiscal_year_th'])
                                        ->where('sales_fiscal_year_no', $data['sales_fiscal_year_no'])
                                        ->where('sales_fiscal_year_revision', $data['sales_fiscal_year_revision'])
                                        ->where('fiscal_year_vision', $data['fiscal_year_vision'])
                                        ->where('ingredien_tobacco_type', request()->ingredienTobaccoType)
                                        ->where('ingredien_species_type', request()->ingredienSpeciesType)
                                        ->whereNotNull('medicinal_leaves')
                                        ->get();

        $master_medicinal_leaves = $model->sortBy('medicinal_leaves')->groupBy('medicinal_leaves');
        return  view('ct.Reports.PDR0007.index', 
                compact('model', 
                        'master_medicinal_leaves', 
                        'ingredienTobaccoType', 
                        'ingredienSpeciesType', 
                        'data'));
    }

    public function styles(Worksheet $sheet)
    {
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 15,
            'D' => 15,
            'E' => 15
        ];
    }
}
