<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PM\PtmesProductDistribution;
use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductHeaderv;
use App\Models\PM\PtpmWipStep;
use Illuminate\Http\Request;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtBiweekly;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConfirmLossOrderController extends Controller
{
    public function fetchLovNew(Request $request) {
        $organization_id = auth()->user()->organization_id;
        $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->addYears('-543')->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->addYears('-543')->format('Y-m-d');

        $sql = "SELECT DISTINCT ppl.inventory_item_id
        ,               (SELECT BATCH_NO
                        FROM GME_BATCH_HEADER GBH
                        WHERE GBH.BATCH_ID = PPL.BATCH_ID) BATCH_NO
        ,               (SELECT BATCH_ID
                        FROM GME_BATCH_HEADER GBH
                        WHERE GBH.BATCH_ID = PPL.BATCH_ID) BATCH_ID
        ,               (SELECT MSI.DESCRIPTION
                        FROM MTL_SYSTEM_ITEMS MSI
                        WHERE    PPL.ORGANIZATION_ID = MSI.ORGANIZATION_ID
                        AND     PPL.INVENTORY_ITEM_ID = MSI.INVENTORY_ITEM_ID) DESCRIPTION
        ,               (SELECT MSI.SEGMENT1
                        FROM MTL_SYSTEM_ITEMS MSI
                        WHERE    PPL.ORGANIZATION_ID = MSI.ORGANIZATION_ID
                        AND     PPL.INVENTORY_ITEM_ID = MSI.INVENTORY_ITEM_ID) SEGMENT1
        FROM PTMES_PRODUCT_LINE PPL
        WHERE PPL.ORGANIZATION_ID = '{$organization_id}'
        AND 
        -- PPL.PRODUCT_DATE BETWEEN '". $startDate ."' AND '". $endDate ."'
        PPL.PRODUCT_DATE BETWEEN TRUNC(TO_DATE('{$startDate}','YYYY-MM-DD')) AND TRUNC(TO_DATE('{$endDate}','YYYY-MM-DD'))
        
        ORDER BY SEGMENT1";
       
        $result = \DB::select($sql);
        return response()->json($result);
    }
    public function getLine()
    {
        $startDate = parseFromDateTh(request()->startDate);
        $endDate = parseFromDateTh(request()->endDate);

        $lines = PtmesProductLine::where('WIP_STEP', request()->wip_step)
            ->where('BATCH_ID', request()->batch_id)
            ->whereBetween('PRODUCT_DATE', [$startDate, $endDate])
            ->orderBy('product_date')
            ->get();
        $curWipStep = \request()->wip_step;
        $wip = intval(trim($curWipStep,"WIP"));
        $wip += 1;
        $nextWip = "WIP0".strval($wip);
        $nextWipStep = PtmesProductLine::where('WIP_STEP', $nextWip)
            ->where('BATCH_ID', request()->batch_id)
            ->whereBetween('PRODUCT_DATE', [$startDate, $endDate])
            ->get();
        foreach ($nextWipStep as $key => $line) {
            $line->has_distribution = $this->getDistData($line->wip_step, $line->product_date, $line->batch_id, true);
        }

       return response()->json(['data' => $lines,'nextWip'=>$nextWipStep]);
    }

    public function getHeaderByDate()
    {
        $userProfile = getDefaultData('/pm/confirm-order');
        $organization_id = $userProfile->organization_id;
        $startDate = parseFromDateTh(request()->startDate);
        $endDate = parseFromDateTh(request()->endDate);
//        dd($startDate,$endDate,\request()->departmentCode);

        $headers = PtmesProductHeader::whereBetween('START_DATE',[$startDate,$endDate])
//            ->where('DEPARTMENT_CODE',request()->departmentCode)
            ->where('organization_id',$organization_id)
            ->get();

        return response()->json(['data' => $headers]);
    }

    public function getSearch()
    {

        $startDate = parseFromDateTh(request()->startDate);
        $endDate = parseFromDateTh(request()->endDate);
        $result = DB::table('PTMES_PRODUCT_HEADER_V')
            ->join('PTMES_PRODUCT_LINE','PTMES_PRODUCT_HEADER_V.BATCH_ID','=','PTMES_PRODUCT_LINE.BATCH_ID')
            ->select(
                'PTMES_PRODUCT_HEADER_V.BATCH_ID',
                'PTMES_PRODUCT_HEADER_V.BATCH_NO',
                'PTMES_PRODUCT_HEADER_V.ITEM_CODE',
                'PTMES_PRODUCT_HEADER_V.ITEM_DESC',
                'PTMES_PRODUCT_LINE.BATCH_ID',
                'PTMES_PRODUCT_LINE.attribute2',
                'PTMES_PRODUCT_LINE.WIP_STEP',
                'PTMES_PRODUCT_LINE.PRODUCT_DATE',
                'PTMES_PRODUCT_LINE.PRODUCT_LINE_ID',
                'PTMES_PRODUCT_LINE.TRANSACTION_FLAG'
            )->where('PTMES_PRODUCT_LINE.BATCH_ID','=',request()->batch_id)
            ->where('PTMES_PRODUCT_LINE.WIP_STEP','=',request()->wip_step)
            ->whereBetween('PRODUCT_DATE', [$startDate, $endDate])->get();

        return response()->json(['data'=>$result]);
    }

    public function getDistribution()
    {
        $line = PtmesProductLine::where('product_line_id', request()->product_line_id)
                    ->where('WIP_STEP', request()->wip_step)
                    ->first();

        // WIP03
        // $distributions = PtmesProductDistribution::where('WIP_STEP', request()->wip_step)
        //     ->whereDate('product_date', $line->product_date)
        //     ->where('batch_id',request()->batch_id)
        //     ->orderBy('machine_set')
        //     ->get();
        $distributions = $this->getDistData(request()->wip_step, $line->product_date, request()->batch_id);
        if (count($distributions)) {
            foreach ($distributions as $key => $dis) {
                if (is_null($dis->attribute2)) {
                    foreach (range(1, 10) as $key => $period) {
                        $period = str_pad($period, 2, '0', STR_PAD_LEFT);
                        $mesQty = data_get($dis, "qty_$period", null);
                        if (!is_null($mesQty)) {
                            $mesQty = $mesQty ? $mesQty : 0;
                            data_set($dis, "result_qty_$period", $mesQty);
                        }
                    }
                }
            }
        }

        // return $distributions;
       return response()->json(['data' => $distributions]);
    }

    public function getDistData($wip, $productDate, $batchId, $countData = false)
    {
        $distributions = PtmesProductDistribution::where('WIP_STEP', $wip)
            ->whereDate('product_date', $productDate)
            ->where('batch_id', $batchId)
            ->orderBy('machine_set');
        if ($countData) {
            $distributions = $distributions->count();
        } else {
            $distributions = $distributions->get();
        }

       return $distributions;
    }
    // public function getWipStep($batch,$date)

    public function getWipStep(Request $request)
    {
        $inventory_item_id = $request->inventory_item_id;

        // $sql = "SELECT  GR.RECIPE_NO
        // ,       GR.RECIPE_DESCRIPTION
        // ,       FMD.FORMULA_ID
        // ,       FMD.INVENTORY_ITEM_ID
        // ,       FRH.ROUTING_ID
        // ,       GMO.OPRN_CLASS
        // ,       GMO.OPRN_DESC
        // FROM    GMD_RECIPES GR
        // ,       FM_MATL_DTL FMD
        // ,       FM_ROUT_HDR FRH
        // ,       FM_ROUT_DTL  FRD
        // ,       GMD_OPERATIONS_VL  GMO
        // WHERE 1=1
        //     AND GR.FORMULA_ID = FMD.FORMULA_ID
        //     AND GR.ROUTING_ID = FRH.ROUTING_ID
        //     AND FRH.ROUTING_ID = FRD.ROUTING_ID
        //     AND FRD.OPRN_ID = GMO.OPRN_ID
        //     AND GR.OWNER_ORGANIZATION_ID = 186
        //     AND GR.ATTRIBUTE7 = 'Y'
        //     AND GR.RECIPE_STATUS = 700
        //     AND GR.DELETE_MARK = 0 
        //     AND FMD.LINE_TYPE = '1'
        //     AND GR.RECIPE_VERSION =
        //         (SELECT MAX (GR1.RECIPE_VERSION)
        //         FROM APPS.GMD_RECIPES_B GR1
        //         WHERE     GR1.RECIPE_STATUS = 700
        //         AND GR1.DELETE_MARK = 0
        //         AND GR1.RECIPE_NO = GR.RECIPE_NO)
        //         AND FMD.INVENTORY_ITEM_ID = {$inventory_item_id}
        // ORDER BY GR.RECIPE_NO, GMO.OPRN_CLASS";
        $sql = "SELECT  GR.RECIPE_NO
        ,       GR.RECIPE_DESCRIPTION
        ,       FMD.FORMULA_ID
        ,       FMD.INVENTORY_ITEM_ID
        ,       FRH.ROUTING_ID
        ,       FOC.OPRN_CLASS_DESC
        ,       GMO.OPRN_DESC
        FROM    GMD_RECIPES GR
        ,       FM_MATL_DTL FMD
        ,       FM_ROUT_HDR FRH
        ,       FM_ROUT_DTL  FRD
        ,       GMD_OPERATIONS_VL  GMO
        ,       FM_OPRN_CLS FOC 
        WHERE 1=1
            AND GR.FORMULA_ID = FMD.FORMULA_ID
            AND GR.ROUTING_ID = FRH.ROUTING_ID
            AND FRH.ROUTING_ID = FRD.ROUTING_ID
            AND FRD.OPRN_ID = GMO.OPRN_ID
            AND GMO.OPRN_CLASS = FOC.OPRN_CLASS
            AND GR.ATTRIBUTE7 = 'Y'
            AND GR.RECIPE_STATUS = 700
            AND GR.DELETE_MARK = 0 
            AND FMD.LINE_TYPE = '1'
            AND FMD.INVENTORY_ITEM_ID = {$inventory_item_id}
            AND GR.RECIPE_VERSION =
                (SELECT MAX (GR1.RECIPE_VERSION)
                FROM APPS.GMD_RECIPES_B GR1
                WHERE     GR1.RECIPE_STATUS = 700
                AND GR1.DELETE_MARK = 0
                AND GR1.RECIPE_NO = GR.RECIPE_NO)
        ORDER BY GR.RECIPE_NO, GMO.OPRN_CLASS";
        $result = DB::select($sql);
        return $result;
        
    }

    public function update(Request $request)
    {
        $requestData = $request->all();
        // Update Lines data
        $master = collect($request->lines)->filter(function($item){
            return !empty($item['batch_id']);
        })->first();
        foreach ($requestData['lines'] as $key => $item){
            if(@$item['is_new']){
                if(!empty($item['product_date_format'])) {
                    $insertData = array(
                        'batch_id' => $request->val['batch_id'],
                        'department_code' => $request->organizationCode,
                        'organization_id' => $request->orgId,
                        'inventory_item_id' => $master['inventory_item_id'],
                        'wip_step' => $request->wip['wip_step'],
                        'receive_wip' => '0',
                        'attribute2' => 'Y',
                        'transfer_qty' => $item['transfer_qty'],
                        'transfer_wip' => $item['transfer_wip'],
                        'uom' => 'CG',
                        'example_qty' => '0',
                        'product_date' => Carbon::createFromFormat('d/m/Y',$item['product_date_format'])->addYears('-543')->format('Y-m-d')  . " 00:00:00",
                        'creation_date' => now()->format('Y-m-d H:i:s'),
                        'product_line_id' =>  PtmesProductLine::max('product_line_id') + 1,
                        'wip_step_desc' => $master['wip_step_desc'],
                        'unit_of_measure' => 'มวน',
                        'transaction_flag' => 'Y'
                    );
                    if (session('organization_code') == "M05") {
                        $insertData['uom'] = "CG";
                        $insertData['unit_of_measure'] = "มวน";
                    } else {
                        $insertData['uom'] = "PG.";
                        $insertData['unit_of_measure'] = "ชิ้น.";
                    }
                    PtmesProductLine::insert($insertData);
                }
            } else {
                $updateLine=array(
                    'receive_wip'=>$item['receive_wip'],
                    'product_qty'=>$item['product_qty'],
                    'loss_qty'=>$item['loss_qty'],
                    'transfer_qty'=>(int)$item['transfer_qty'],
                    'transfer_wip'=>$item['transfer_wip'],
                    'example_qty'=>$item['example_qty'],
                    'attribute2'=>$item['attribute2']
                );
    
                PtmesProductLine::where('BATCH_ID',$item['batch_id'])
                    ->whereDate('PRODUCT_DATE','like',$item['product_date_original'].'%')
                    ->where('WIP_STEP',$item['wip_step'])
                    ->update($updateLine);
            }
        }

        // Update Distribution data
        foreach($requestData['distributions'] as $key => $item) {
            $updateDist=array(
                'result_qty_01'=>$item['result_qty_01'],
                'result_qty_02'=>$item['result_qty_02'],
                'result_qty_03'=>$item['result_qty_03'],
                'result_qty_04'=>$item['result_qty_04'],
                'result_loss_qty'=>$item['result_loss_qty'],
                'product_qty'=>$item['product_qty'],
                'sample_qty'=>$item['sample_qty'],
                'attribute2' => 'Y',
            );
            PtmesProductDistribution::where('BATCH_ID',$item['batch_id'])
                    ->whereDate('PRODUCT_DATE','like',$item['product_date_original'].'%')
                    ->where('WIP_STEP',$item['wip_step'])
                    ->where('MACHINE_SET',$item['machine_set'])
                    ->update($updateDist);
        }

        return 'Done!';
    }
}
