<?php

namespace App\Exports\CT;

use App\Models\CT\MtlSystemItemsB;
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
use App\Models\PD\PtpdPd15RPT;
use FormatDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Models\PD\PtpdEstimateMtSaleHeader;
use App\Models\PD\PtdpTobaccoForecastV;
use App\Models\PD\PtdpSpeciesForecastV;

class PDR0008 implements FromView, WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }   

    public function columnFormats(): array
    {
        if($this->ingredienTobaccoType['ingredien_tobacco_type'] == '1004'){
            return [
                'C:ZZ' => '#,##0.000000',
            ];
        }else{
            return [
                'C:ZZ' => '#,##0.000',
            ];
        }
    }


    public function view(): View
    {
        $req = request()->all();
        $data = PtpdEstimateMtSaleHeader::find($req['id']);
        $ingredienTobaccoType = PtdpTobaccoForecastV::where('ingredien_tobacco_type', $req['ingredienTobaccoType'])->first();
        $this->ingredienTobaccoType = $ingredienTobaccoType;
        $ingredienSpeciesType = PtdpSpeciesForecastV::where('tobacco_type_meaning', $req['ingredienSpeciesType'])->first();

        if($req['ingredienTobaccoType'] == '1001') {
            $model  = PtpdPd15RPT::query()
                            ->where('sales_fiscal_year_th', $data['sales_fiscal_year_th'])
                            ->where('sales_fiscal_year_no', $data['sales_fiscal_year_no'])
                            ->where('sales_fiscal_year_revision', $data['sales_fiscal_year_revision'])
                            ->where('fiscal_year_no', $data['fiscal_year_vision'])
                            ->where('species_type', $req['ingredienSpeciesType'])
                            ->where('tobacco_type', $req['ingredienTobaccoType'])
                            ->whereNotNull('medicinal_leaves')
                            ->orderBy('item_att11', 'asc')
                            ->orderBy('item_att12', 'asc')
                            ->orderBy('medicinal_leaves', 'asc')                            
                            ->get();

            return view('ct.Reports.PDR0008.index', compact('model', 'ingredienTobaccoType', 'ingredienSpeciesType', 'data'));
        }   elseif ($req['ingredienTobaccoType'] == '1004'){
            $model  = PtpdPd15RPT::query()
                            ->where('sales_fiscal_year_th', $data['sales_fiscal_year_th'])
                            ->where('sales_fiscal_year_no', $data['sales_fiscal_year_no'])
                            ->where('sales_fiscal_year_revision', $data['sales_fiscal_year_revision'])
                            ->where('fiscal_year_no', $data['fiscal_year_vision'])
                            ->where('species_type', strtolower($req['ingredienSpeciesType']))
                            ->where('tobacco_type', $req['ingredienTobaccoType'])
                            ->whereNotNull('medicinal_leaves')
                            ->whereNotNull('subinventory_code')
                            ->orderBy('medicinal_leaves', 'asc')
                            ->get();
            
            $mapLines =  $model->mapWithKeys(function ($item, $key) {
                return [$item->medicinal_leaves.''.$item->subinventory_code => $item];
            });

            $mapLines->toArray();

            $subinventoryCodeTr = $model->where('subinventory_code', '!=', "")
                                        ->sortBy('subinventory_code')
                                        ->groupBy('subinventory_code');
                                        
            return view('ct.Reports.PDR0008.index-flavoring', compact('model', 'data', 'mapLines', 'subinventoryCodeTr'));
        }   else {
            $model  = PtpdPd15RPT::query()
                            ->where('sales_fiscal_year_th', $data['sales_fiscal_year_th'])
                            ->where('sales_fiscal_year_no', $data['sales_fiscal_year_no'])
                            ->where('sales_fiscal_year_revision', $data['sales_fiscal_year_revision'])
                            ->where('fiscal_year_no', $data['fiscal_year_vision'])
                            ->where('species_type', strtolower($req['ingredienSpeciesType']))
                            ->where('tobacco_type', $req['ingredienTobaccoType'])
                            ->whereNotNull('medicinal_leaves')
                            ->orderBy('medicinal_leaves', 'asc')
                            ->get();

            return view('ct.Reports.PDR0008.index-export', compact('model', 'data'));
        }
    }

    public function styles(Worksheet $sheet)
    {
    }

    public function columnWidths(): array
    {
        return [
            // 'A' => 20,
            // 'B' => 60,
        ];
    }
}
