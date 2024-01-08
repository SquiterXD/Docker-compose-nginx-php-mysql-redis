<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\PD\PtpdPd15RPT;
use App\Models\PD\PtpdSalesFiscalYearV;
use App\Models\PD\PtpdEstimateMtSaleHeader;
use App\Models\PD\PtpdEstimateMtSaleLine;
use App\Models\PD\PtdpItemEstimateMtSaleV;
use App\Models\PD\PtdpSpeciesForecastV;

class PD0015ApiController extends Controller
{
    public function getItems()
    {
        ini_set('max_execution_time', 1000);
        set_time_limit(1000);

        $request = (object)request();
        $data = [
            'medicinal_leaves'      => [],
            'mapLines'              => [],
            'medicinal_leaves_tr'   => [],
        ];

        $ptpd15 = PtpdPd15RPT::where('web_batch_no', $request->batch_no)
                            ->where('tobacco_type', $request->type)
                            ->when($request->type != '1004', function($q) use ($request) {
                                $q->where('species_type', $request->species_type);
                            })
                            ->orderby('item_att11')
                            ->orderby('item_att12')
                            ->get();

        if ($request->type == '1001') {
            $data = $this->dataGroup1001($ptpd15);
        } elseif($request->type == '1002') {
            $data = $this->dataGroup1002($request->batch_no, $request->type);
        } elseif($request->type == '1004'){
            $data = $this->dataGroup1004($ptpd15);
        }

        return response()->json([
            'batchNo' =>  $request->batch_no,
            'data'    => $data
        ]);
    }

    public function getHeader()
    {
        $request = request();
        $headers = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT    fiscal_year_vision, 
                                                                    fiscal_year_th, 
                                                                    web_h_id, 
                                                                    tran_approval_date, 
                                                                    tran_status, 
                                                                    sales_fiscal_year_revision,
                                                                    sales_fiscal_year_no,
                                                                    user_name")
                                            ->when($request->year, function($q) use($request){
                                                $q->where('fiscal_year_th', $request->year);
                                            })
                                            ->when($request->salesFiscalYearNo, function($q) use($request){
                                                $q->where('sales_fiscal_year_no', $request->salesFiscalYearNo);
                                            })
                                            ->when($request->salesFiscalYearRevision, function($q) use($request){
                                                $q->where('sales_fiscal_year_revision', $request->salesFiscalYearRevision);
                                            })
                                            ->when($request->fiscalYearVision, function($q) use($request){
                                                $q->where('fiscal_year_vision', $request->fiscalYearVision);
                                            })
                                            ->whereNotNull('fiscal_year_vision')
                                            ->orderBy('fiscal_year_th', 'desc')
                                            ->orderBy('fiscal_year_vision', 'desc')
                                            ->orderBy('sales_fiscal_year_revision', 'desc')
                                            ->get([ 'fiscal_year_th' , 
                                                    'fiscal_year_vision', 
                                                    'web_h_id',
                                                    'tran_approval_date',
                                                    'tran_status',
                                                    'sales_fiscal_year_revision',
                                                    'sales_fiscal_year_no',
                                                    'user_name']);

        return response()->json([
            'headers' =>  $headers,
        ]);
    }

    public function selectHeader($id)
    {
        $request    = request();
        $batchNo    ='web-'.uniqid();
        $header     = PtpdEstimateMtSaleHeader::where('web_h_id', $id)->first();

        $sql = "
            DECLARE
            V_STATUS VARCHAR2(1) ;
            BEGIN

            PTPD_PD15_RPT_PKG.MAIN(  ERRBUF                        => V_STATUS
                                    ,P_SALES_FISCAL_YEAR_TH        => '$header->sales_fiscal_year_th'
                                    ,P_SALES_FISCAL_YEAR_NO        => '$header->sales_fiscal_year_no'
                                    ,P_SALES_FISCAL_YEAR_REVISION  => '$header->sales_fiscal_year_revision'
                                    ,P_FISCAL_YEAR_VISION          => '$header->fiscal_year_vision'
                                    ,P_WEB_BATCH_NO                => '$batchNo'                                ) ;

            END ;
        ";

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->execute();

        return response()->json([
            'header' => $header,
            'batchNo' => $batchNo,
        ]);
    }

    public function getSpecies()
    {
        $request    = request();
        $species    = PtdpSpeciesForecastV::
                        when($request->type == '1001' , function($q) use($request){
                            $q->where('tobacco_type_code_1', $request->type);
                        })
                        ->when($request->type == '1002' , function($q) use($request){
                            $q->where('tobacco_type_code_2', $request->type);
                        })
                        ->get();

        return response()->json([
            'species' => $species,
        ]);
    }

    public function dataGroup1001($ptpd15)
    {
        $ptpd15     = $ptpd15->where('lot_number', '!=', null);
        $sum        = 0;
        $i          = 0;
        $tr         = [];
        $mapLines   = $ptpd15->mapWithKeys(function ($item, $key) {
            return [$item->medicinal_leaves.$item->shot_sub_inv.'_'.$item->lot_number => $item];
        });

        $medicinalLeaves = $ptpd15->groupBy('medicinal_leaves');

        foreach ($medicinalLeaves as $key => $arr) {
            $i++;
            $arr->map(function ($item, $key) use ($arr,  $i, $medicinalLeaves) {
                $item->sum_qty_use_month    = $arr->first()->qty_use_month;
                $item->seq                  = $i;
                $item->total_raw            = count($medicinalLeaves->sortBy('medicinal_leaves')->keys());
            });
        }   

        $medicinalLeavesTrShotSubInv = $ptpd15->where('shot_sub_inv', '!=', "")
                                              ->sortBy('shot_sub_inv')
                                              ->groupBy('shot_sub_inv');
        $dataX = [];
        foreach ($medicinalLeavesTrShotSubInv as $shotSubInv => $value) {
            $dataX[$shotSubInv] = [ 'colspan_shot_sub_inv'  =>count($value->where('lot_number', '!=', "")
                                                                        ->where('shot_sub_inv', '!=', "")                                                           
                                                                        ->groupBy('lot_number')
                                                                        ->sortBy('shot_sub_inv')),
                                    'name'                  =>$shotSubInv];
        }        
        
        foreach ($medicinalLeavesTrShotSubInv as $key => $value) {
            foreach ($value->where('lot_number', '!=', "")
                           ->sortBy('lot_number')
                           ->groupBy('lot_number') as $lot => $data) {
                $tr[$key.'_'.$lot] = $data;
                foreach ($data->groupBy('medicinal_leaves') as $index => $item) {
                    $mapLines[$item[0]['medicinal_leaves'].$key.'_'.$lot]['sum_qty'] = $item->sum('onhand_quantity');
                }
            }   
        }

        $data = [
            'medicinal_leaves'          => $medicinalLeaves->toArray(),
            'mapLines'                  => $mapLines->toArray(),
            'medicinal_leaves_tr'       => $tr,
            'items'                     => $ptpd15,
            'medicinalLeaves_tr_org'    => $dataX,
            'sum_medicinal_leaves'      => $sum
        ];

        return  $data;
    }

    public function dataGroup1002($batchNo, $type)
    {
        $ptpd15 = PtpdPd15RPT::where('web_batch_no', $batchNo)
                            ->where('tobacco_type', $type)
                            ->where(function ($query) {
                                $query->where('lot_number', '!=', null)
                                      ->orWhere('qty_use_month', '!=', null);
                            })
                            ->orderby('lot_number')
                            ->orderby('shot_sub_inv')
                            ->get();
                            
        $ptpd15Cla = PtpdPd15RPT::selectRaw("   medicinal_leaves, 
                                                sum(onhand_quantity)    sum_onhand, 
                                                sum(onhand_quantity) / min(qty_use_month) avaliable_qty ")
                            ->where('web_batch_no', $batchNo)
                            ->where('tobacco_type', $type)
                            ->where(function ($query) {
                                $query->where('lot_number', '!=', null)
                                      ->orWhere('qty_use_month', '!=', null);
                            })
                            ->groupBy('medicinal_leaves')
                            ->get();

        $mapLines = $ptpd15->mapWithKeys(function ($item, $key) {
            return [$item->medicinal_leaves . $item->lot_number  => $item];            
        });

        $medicinalLeaves = $ptpd15->sortBy('medicinal_leaves')
                                  ->groupBy('medicinal_leaves');

        $sum = 0;
        foreach ($medicinalLeaves as $key => $value) {
            $sum += $value[0]->qty_use_month;
        }
                                    
        $i = 0;
        foreach ($medicinalLeaves as $key => $values) {
            $i++;
            $values->map(function ($item, $key) use ($values,  $i, $medicinalLeaves) {
                $item->sum_qty          = $values->unique('lot_number')->sum('onhand_quantity');
                $item->seq              = $i;
                $item->total_raw        = count($medicinalLeaves->sortBy('medicinal_leaves')->keys());
                $item->avaliable_qty    = $item->sum_qty / ($values->first()->qty_use_month ?? 1);
            });
        }

        $total = [  'onhand'    => $ptpd15Cla->sum('sum_onhand'),
                    'avaliable' => $ptpd15Cla->sum('sum_onhand') / $sum ];     
        
        $medicinalLeavesTr = $ptpd15->where('lot_number', '!=', "")
                                    ->groupBy('lot_number')
                                    ->sortBy('lot_number');

        $data = [
            'medicinal_leaves'          => $medicinalLeaves->toArray(),
            'mapLines'                  => $mapLines->toArray(),
            'medicinal_leaves_tr'       => $medicinalLeavesTr,
            'items'                     => $ptpd15,
            'medicinalLeaves_tr_org'    => [],
            'sum_medicinal_leaves'      => $sum,
            'total'                     => $total
        ];
        return  $data;
    }

    public function dataGroup1004($ptpd15)
    {

        $mapLines =  $ptpd15->mapWithKeys(function ($item, $key) {
            return [$item->medicinal_leaves . $item->subinventory_code  => $item];
        });
        $medicinalLeaves    = $ptpd15->sortBy('medicinal_leaves')
                                     ->groupBy('medicinal_leaves');
        $sum = 0;
        foreach ($medicinalLeaves as $key => $value) {
            $sum += $value[0]->qty_use_month;
        }
                                        
        $i = 0;
        foreach ($medicinalLeaves as $key => $values) {
            $i++;
            $values->map(function ($item, $key) use ($values,  $i, $medicinalLeaves) {
                $item->sum_qty      = $values->unique('subinventory_code')->sum('onhand_quantity');
                $item->seq          = $i;
                $item->total_raw    = count($medicinalLeaves->sortBy('medicinal_leaves')->keys());
            });
        }

        $medicinalLeavesTr = $ptpd15->where('subinventory_code', '!=', "")
                                    ->groupBy('subinventory_code')
                                    ->sortBy('subinventory_code');

        $data = [
            'medicinal_leaves'          => $medicinalLeaves->toArray(),
            'mapLines'                  => $mapLines->toArray(),
            'medicinal_leaves_tr'       => $medicinalLeavesTr,
            'items'                     => $ptpd15,
            'medicinalLeaves_tr_org'    => [],
            'sum_medicinal_leaves'      => $sum
        ];

        return  $data;
    }

    public function getTempSalesFiscalYearTH()
    {
        $request = request()->all();
        $salesFiscalYearTHArr = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_th")
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->whereNotNull('sales_fiscal_year_th')
                                                            ->orderBy('sales_fiscal_year_th' , 'desc')
                                                            ->get();
        return response()->json([
            'salesFiscalYearTHArr' => $salesFiscalYearTHArr
        ]);
    }

    public function getTempSalesFiscalYearRevision()
    {
        $request = request()->all();
        $salesFiscalYearRevision = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT sales_fiscal_year_revision")
                                                            ->where('fiscal_year_th' , $request['year'])
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->whereNotNull('sales_fiscal_year_revision')
                                                            ->orderBy('sales_fiscal_year_revision' , 'desc')
                                                            ->get();
        return response()->json([
            'salesFiscalYearRevision' => $salesFiscalYearRevision
        ]);
    }

    public function getTempFiscalYearVision()
    {
        $request = request()->all();
        $fiscalYearVision = PtpdEstimateMtSaleHeader::selectRaw("DISTINCT fiscal_year_vision")
                                                            ->where('fiscal_year_th' , $request['year'])
                                                            ->where('sales_fiscal_year_no' , $request['salesFiscalYearNo'])
                                                            ->where('sales_fiscal_year_revision' , $request['salesFiscalYearRevision'])
                                                            ->whereNotNull('fiscal_year_vision')
                                                            ->orderBy('fiscal_year_vision' , 'desc')
                                                            ->get();
        return response()->json([
            'fiscalYearVision' => $fiscalYearVision
        ]);
    }
}
