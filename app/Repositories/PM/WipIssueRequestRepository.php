<?php

namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtmpMesReviewIssueV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtpmManufactureStep;
use App\Models\PM\PtmpProductBatchV;
use App\Models\PM\PtctMfgFormulaV;
use App\Models\PM\PtmpPmp00070And048V;
use \Illuminate\Database\Eloquent\Builder;

use App\Models\PM\PtBiweeklyV;
use Illuminate\Support\Str;
use Carbon\Carbon;


use DB;
use PDO;

class WipIssueRequestRepository
{

    public function setData()
    {
    }

    public function setHeader($headersV)
    {
        logger('1');
        $headers = [];
        $org = auth()->user()->organization_id;

        foreach ($headersV->sortBy('created_at') as $header) {
            logger('2');
            // dd(getDefaultData('/pm/wip-issue')->organization_code);
            $wip = PtpmManufactureStep::where('owner_organization',  getDefaultData('/pm/wip-issue')->organization_code)
                ->where('wip_step', $header->mesReviewIssueView->wip_step)
                ->first();

                $formYear = Carbon::parse($header->issue_date)->format('Y');
                $formDate = Carbon::parse($header->issue_date)->format('d-m');

                $year = (int) $formYear + 543;
                $date = (string) $formDate . "-" . $year;
                $date = date('d-m-Y', strtotime($date));
                $wipStepDesc = null;
            logger('3');
                if($header->program_code == 'PMP0051'){
                    $batchV = PtmpProductBatchV::where('organization_id', auth()->user()->organization_id)
                    // ->where('wip_step', $issueV->wip_step)
                                ->where('batch_no', $header->batch_no)
                                ->whereDate('transaction_date', $header->issue_date)
                                ->with('manufactureStep')
                                ->first();
                    $wipStepDesc = $batchV->manufactureStep->wip_step_desc;
                }

            logger('4');
                $blendNo    = $header->mesReviewIssueView->blend_no;
                $blend      = $header->mesReviewIssueView;
                $blendUom   = $header->mesReviewIssueView->uom;
                $itemNumber = $header->mesReviewIssueView->item_number;
            logger('5');
                if (getDefaultData('/pm/wip-issue')->organization_code == 'M02') {
                    $blendNo    = $header->mesReviewIssueVHasBlend->blend_no;
                    $blend      = $header->mesReviewIssueVHasBlend;
                    $blendUom   = $header->mesReviewIssueVHasBlend->uom;
                    $itemNumber = $header->mesReviewIssueVHasBlend->item_number;
                }
            logger('6');
            $headers[] = [
                'request_number'    => $header->request_number,
                'issue_header_id'   => $header->issue_header_id,
                'status'            => $header->issueStatus->description,
                'department_code'   => $header->department_code,
                'batch_no'          => $header->batch_no,
                'issue_date'        => date('d/m/Y', strtotime($header->issue_date)),
                'complete_date'     => date('d/m/Y', strtotime($header->complete_date)),
                'report_date'       => date('Y-m-d', strtotime($header->complete_date)),
                'show_date_th'      => $date,
                'blend_no'          => $blendNo,
                'blend'             => $blend,
                'blend_uom'         => $blendUom,
                'wip'               => $wip ?? "",
                'opt_plan_qty'      => $header->opt_plan_qty,
                'total_qty'         => $header->childHeaders
                                        ? $header->childHeaders->sum('opt_plan_qty') + $header->opt_plan_qty
                                        : $header->opt_plan_qty,
                'opt'               => $header->opt,
                'interface_status'  => $header->interface_status,
                'child_headers'     => $header->childHeaders,
                'all_opt'           => $header->childHeaders->count() > 0
                                        ? true
                                        : false,
                'badge_status'      => $header->badgeStatus(),
                'item_number'       => $itemNumber,
                'wip_step'          => $header->wip_step,
                'wip_step_desc'     => $wipStepDesc,
                'issue_status'      => $header->issue_status,

            ];
            logger('7');
        }

        return $headers;
    }

    public function setFormula($formulas, $request, $program_code = null, $costValidate=null)
    {
        $arr  = [];
        $all = [];
        $onhandByItem =  $formulas->groupBy('item_number');

        foreach ($formulas as $key => $formula) {

            $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');
            $year =(int) $formYear-543;
            $date = (string) $formDate."-".$year;
            $date = date('Y-m-d', strtotime($date));
            $period = PtBiweeklyV::whereRaw("TRUNC(to_date('$date', 'YYYY-MM-DD')) between start_date and end_date")->first();
            $costValidate = (new CommonRepository)->costValidate(
                $formula->inventory_item_id,
                $formula->setupMfgDeptVLByUserOrg->from_organization_id,
                $period->period_year );
                $costValidate = (object)$costValidate;


            $originOnhand = $formula->getOnhand();
            // dd($formulas);
            // if($key ==1){
            //     dd('xxx');
            // }
            // dd($formula->getOnhand()->count());
            if ($formula->getOnhand()->count() != 0) {

                // dd($formula->getOnhand()->count());
                if ($formula->getOnhand()->count() > 1) {

                    // $sumQty = 0;
                    $last = false;
                    $totalQty =  (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
                    $require =   (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
                    // dd( $totalQty );
                    $sumOnhands = 0;
                    // dd('xxxxxxxx');
                    foreach ($formula->getOnhand() as $keyOn => $onhand) {
                        $summaryUseOnhand =  collect($arr)
                                            ->where('item_number',$formula->item_number)
                                            // ->where('default_lot_no', $onhand->lot_number)
                                            ->sum('input_quantity_summary');
                        
                        $last =  collect($arr)
                                    ->where('item_number',$formula->item_number)
                                    ->where('default_lot_no', $onhand->lot_number)
                                    ->last();


                        $sumQty =  $totalQty -  $summaryUseOnhand;


                        if ($sumQty >= 0) {
                            $sumOnhands += (float)$onhand->onhand_quantity;
                        }

                        // if ($sumQty <= 0 && $program_code != 'PMP0048') { 
                        //     continue;
                        // }

                        if ($summaryUseOnhand >=  (float)$onhand->onhand_quantity) {
                            // dd('xxxxxx');
                            $requireQty =  (float)$onhand->onhand_quantity + $sumQty;
                            $sumQty =  $totalQty - $sumOnhands;
                            // dd($sumQty);
                            $arr[] =  $this->setArray($formula, $onhand, $request, (float)$sumQty, $formula->getOnhand(), true, $program_code,  $arr, $originOnhand, $costValidate);
                            break;
                        } else {
                            // dd('==');
                            $arrLot =  collect($arr)->where('item_number',$formula->item_number);
                            $sumLot = count($arrLot->pluck('default_lot_no'));
                            $onhandAvailable = (float)$onhand->onhand_quantity - $summaryUseOnhand;

                            $qty = $onhand->onhand_quantity;

                            if (!!$arrLot && $sumLot ==1) {
                                if ((float)$onhand->onhand_quantity > $totalQty) {
                                    $qty = $totalQty;
                                }
                            }

                            if ($onhandAvailable > $totalQty) {
                                $qty = $totalQty;
                            }

                            $arr[] = $this->setArray($formula, $onhand, $request,(float)$qty, $formula->getOnhand(), $last, $program_code,  $arr, $originOnhand, $costValidate);
                            // dd($totalQty, (float)$onhand->onhand_quantity);
                            // dd((float)$onhand->onhand_quantity , (float)$totalQty);

                            // dd($onhand->onhand_quantity , $totalQty);
                            if((float)$onhand->onhand_quantity  >= (float)$totalQty) {
                                // dd('xxx');
                                break;
                            }
                        }

                    }
                }else{

                    $summaryUseOnhand =  collect($arr)
                                        ->where('item_number',$formula->item_number)
                                        ->where('default_lot_no', $formula->lot_number)
                                        ->sum('input_quantity_summary');


                    $arr[] = $this->set($request, $formula, $formula->getOnhand(), $program_code, $arr, $originOnhand, $costValidate);
                }

            } else {

                $sumRatioQty    = number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', '');
                $sumQty         = number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', '');


                $productDetailUom           = $formula->itemConvUom()
                                                ? $formula->itemConvUom()->toUom->unit_of_measure
                                                : $formula->product_detail_uom;
                $productUnitOfMeasure       = $formula->itemConvUom()
                                                ? $formula->itemConvUom()->toUom->unit_of_measure
                                                : $formula->primary_unit_of_measure;
                $sumTotalQty                =  $formula->itemConvUom()
                                                ? (float)$sumQty * $formula->itemConvUom()->conversion_rate
                                                : $sumQty;

                // dd($productUnitOfMeasure ,$productDetailUom);
                $arr[] =                   [
                    'casting_flavor_name'       => $formula->casting_flavor_name,
                    'uuid'                      => Str::uuid(),
                    'lot_key'                   => '#####',
                    'formulaline_id'            => $formula->formulaline_id,
                    'leaf_formula'              => $formula->leaf_formula ?? $formula->leaf_fomula,
                    'used_leaf_formula'         => $formula->used_leaf_formula,
                    'item_number'               => $formula->item_number,
                    'item_desc'                 => $formula->item_desc,
                    'product_detail_uom'        => $productDetailUom ?? $formula->product_detail_uom,
                    'product_unit_of_measure'   => $productUnitOfMeasure ?? $formula->uom->unit_of_measure,
                    'from_subinventory'         => $formula->setupMfgDeptVLByUserOrg->from_subinventory,
                    'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
                    'default_lot_no'            => "",
                    'expiration_date'           => "",
                    'onhand_quantity'           => 0,
                    'quantity_summary'          => $sumTotalQty,
                    'input_quantity_summary'    => $sumTotalQty,

                    'interface_status'          => null,
                    'onhand_lists'              => [],
                    'line_disabled'             => true,
                    'last_line'                 => false,
                    'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                    'new_key'                   => 0,
                    'group_line'                => $formula->formulaline_id . $formula->used_leaf_formula.$formula->casting_flavor_name,
                    'onhand_quantity_display'   => 0,
                ];
            }

        }
        // dd(
        //     // $arr,
        //     collect($arr)->where('item_number',100700001)
        //         ->where('default_lot_no', 9999)
        //     // ->sum('input_quantity_summary')
        // );
        // dd($arr);
        return $arr;
    }


    public function setFormulaByPMP0049($formulas, $request, $program_code = null)
    {

        $arr  = [];

        $formYear = Carbon::createFromFormat('d/m/Y', $request['date'])->format('Y');
        $formDate = Carbon::createFromFormat('d/m/Y', $request['date'])->format('d-m');

        $year = (int) $formYear - 543;
        $date = (string) $formDate . "-" . $year;
        $date = date('d-M-Y', strtotime($date));

        $lineNo = 1;
        $dataSummaryQty = collect([]);


        foreach ($formulas->where('item_number')->groupBy('item_number') as $key => $formulaByItem) {
            $formula = $formulaByItem->first();
            $originOnhand = $formula->getOnhand();

            if($program_code  == 'PMP0051'){
                $totalQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
            } else {
                if ($lineNo == 1) {
                    $dataSummaryQty = $this->getReqFml($request, $date);
                    $lineNo = $lineNo + 1;
                }
                $totalQty = (float)$this->summaryQty($request, $formula, $date, $dataSummaryQty);
            }

                
            if ($formula->getOnhand() && $formula->getOnhand()->count() != 0) {
                foreach ($formula->getOnhand() as $onHandKey => $onhand) {
                    $summaryUseOnhand =  collect($arr)
                                            ->where('item_number',$formula->item_number)
                                            ->sum('input_quantity_summary');
                    

                    if(((float)$onhand->onhand_quantity < (float)$totalQty)  && $summaryUseOnhand < (float)$totalQty){
                        $amount = (object)[
                            'require_qty' => $totalQty,
                            'input'       => $onhand->onhand_quantity
                        ];

                        $arr[] = $this->setArrayPMP0049($formula, $onhand, $request,(float) $totalQty, $formula->getOnhand(), true, $program_code, $arr, $originOnhand, $amount);
                        $summaryUseOnhand =  collect($arr)
                                    ->where('item_number',$formula->item_number)
                                    ->sum('input_quantity_summary');

                        // if( $onHandKey ==1 ){
                        //     dd( $summaryUseOnhand,  (float)$totalQty);
                        // }
                        // count($summaryUseOnhand);
                        if($program_code  == 'PMP0051'){
                            if((float)$summaryUseOnhand  > (float)$totalQty){
                                break;
                            }
    
                        }
                    
                    }else{


                        $summaryUseOnhand =  collect($arr)
                                            ->where('item_number',$formula->item_number)
                                            ->sum('input_quantity_summary');
                        $amount = (object)[
                            'require_qty' => $totalQty,
                            'input'       =>  $totalQty - $summaryUseOnhand

                        ];
                        $arr[] = $this->setArrayPMP0049($formula, $onhand, $request,(float)$totalQty, $formula->getOnhand(), true, $program_code, $arr, $originOnhand, $amount);

                        break;
                    }
                }


            } else {
                $lineNo = 1;
                if ($lineNo == 1) {
                    $dataSummaryQty = $this->getReqFml($request, $date);
                    $lineNo = $lineNo + 1;
                }
                $sumQty = (float)$this->summaryQty($request, $formula, $date, $dataSummaryQty);

                $oprn = $request['oprn_no'];
                $blendNo = $request['blend_no'];
                // $sumQty = $this->summaryQty($request, $formula, $date);

                logger($formula->formulaline_id);
                logger(' ===================================================== ');
                $sumRatioQty =(float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;

                $arr[] =                   [
                    'casting_flavor_name'       => $formula->casting_flavor_name,
                    'uuid'                      => Str::uuid(),
                    'lot_key'                   => '#00000',
                    'formulaline_id'            => $formula->formulaline_id,
                    'leaf_formula'              => $formula->leaf_formula,
                    'used_leaf_formula'         => $formula->used_leaf_formula,
                    'item_number'               => $formula->item_number,
                    'item_desc'                 => $formula->item_desc,
                    'product_detail_uom'        => $formula->detail_uom,
                    'product_unit_of_measure'   => $formula->uom->unit_of_measure_tl,
                    'from_subinventory'         => "",
                    'from_location_code'        => "",
                    'default_lot_no'            => "",
                    'expiration_date'           => "",
                    'onhand_quantity'           => 0,
                    'quantity_summary'          =>  $sumRatioQty,
                    'input_quantity_summary'    =>  0,

                    'interface_status'          => null,
                    'onhand_lists'              => [],
                    'line_disabled'             => true,
                    'last_line'                 => false,
                    'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                    'new_key'                   => 0,
                ];
            }
        }

        return $arr;
    }

    public function setFormulaByPMP0059($formulas, $request, $program_code = null)
    {

        $arr  = [];

        $formYear = Carbon::createFromFormat('d/m/Y', $request['date'])->format('Y');
        $formDate = Carbon::createFromFormat('d/m/Y', $request['date'])->format('d-m');

        $year = (int) $formYear - 543;
        $date = (string) $formDate . "-" . $year;
        $date = date('d-M-Y', strtotime($date));

        $lineNo = 1;
        $dataSummaryQty = collect([]);


        foreach ($formulas->where('item_number')->groupBy('item_number') as $key => $formulaByItem) {
            $formula = $formulaByItem->first();
            $originOnhand = $formula->getOnhand();

            if($program_code  == 'PMP0051'){
                $totalQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
            } else {
                if ($lineNo == 1) {
                    $dataSummaryQty = $this->getReqFml($request, $date);
                    $lineNo = $lineNo + 1;
                }
                $totalQty = (float)$this->summaryQty($request, $formula, $date, $dataSummaryQty);
                // $totalQty = (float)$this->summaryQty($request, $formula, $date);
            }

                
            if ($formula->getOnhand() && $formula->getOnhand()->count() != 0) {
                foreach ($formula->getOnhand() as $onHandKey => $onhand) {
                    $summaryUseOnhand =  collect($arr)
                                            ->where('item_number',$formula->item_number)
                                            ->sum('input_quantity_summary');
                    

                    if(((float)$onhand->onhand_quantity < (float)$totalQty)  && $summaryUseOnhand < (float)$totalQty){
                        $amount = (object)[
                            'require_qty' => $totalQty,
                            'input'       => $onhand->onhand_quantity
                        ];

                        $arr[] = $this->setArrayPMP0059($formula, $onhand, $request,(float) $totalQty, $formula->getOnhand(), true, $program_code, $arr, $originOnhand, $amount);
                        $summaryUseOnhand =  collect($arr)
                                    ->where('item_number',$formula->item_number)
                                    ->sum('input_quantity_summary');

                        // if( $onHandKey ==1 ){
                        //     dd( $summaryUseOnhand,  (float)$totalQty);
                        // }
                        // count($summaryUseOnhand);
                        if($program_code  == 'PMP0051'){
                            if((float)$summaryUseOnhand  > (float)$totalQty){
                                break;
                            }
    
                        }
                    
                    }else{


                        $summaryUseOnhand =  collect($arr)
                                            ->where('item_number',$formula->item_number)
                                            ->sum('input_quantity_summary');
                        $amount = (object)[
                            'require_qty' => $totalQty,
                            'input'       =>  $totalQty - $summaryUseOnhand

                        ];
                        $arr[] = $this->setArrayPMP0059($formula, $onhand, $request,(float)$totalQty, $formula->getOnhand(), true, $program_code, $arr, $originOnhand, $amount);

                        break;
                    }
                }


            } else {

                $oprn = $request['oprn_no'];
                $blendNo = $request['blend_no'];
                $sumQty = $this->summaryQty($request, $formula, $date);

                logger($formula->formulaline_id);
                logger(' ===================================================== ');
                $sumRatioQty =(float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;

                $arr[] =                   [
                    'casting_flavor_name'       => $formula->casting_flavor_name,
                    'uuid'                      => Str::uuid(),
                    'lot_key'                   => '#00000',
                    'formulaline_id'            => $formula->formulaline_id,
                    'leaf_formula'              => $formula->leaf_formula,
                    'used_leaf_formula'         => $formula->used_leaf_formula,
                    'item_number'               => $formula->item_number,
                    'item_desc'                 => $formula->item_desc,
                    'product_detail_uom'        => $formula->detail_uom,
                    'product_unit_of_measure'   => $formula->uom->unit_of_measure_tl,
                    'from_subinventory'         => "",
                    'from_location_code'        => "",
                    'default_lot_no'            => "",
                    'expiration_date'           => "",
                    'onhand_quantity'           => 0,
                    'quantity_summary'          =>  $sumRatioQty,
                    'input_quantity_summary'    =>  0,

                    'interface_status'          => null,
                    'onhand_lists'              => [],
                    'line_disabled'             => true,
                    'last_line'                 => false,
                    'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                    'new_key'                   => 0,
                ];
            }
        }

        return $arr;
    }

    public function set($request, $formula, $onhands, $program_code, $arr, $originOnhand=null, $costValidate=null)
    {


        $last =  collect($arr)->where('item_number',$formula->item_number )->last();

        $summaryUseOnhand =  $onhands->first()->onhand_quantity - collect($arr)
                                                                    ->where('item_number',$formula->item_number)
                                                                    ->sum('input_quantity_summary');

        if ($last != null &&  $summaryUseOnhand <= 0 && $program_code == null) {
            return $this->setNoOnhand($request, $formula, $onhands, $program_code, $arr, $originOnhand);
        }

        $sumQty = [];
        $last = false;
        $totalQty =  number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', '');
        $totalQty = $totalQty;

        $formulasVV  = [];
        foreach ($onhands as $key =>  $onhand) {

            $summaryUseOnhand =  collect($arr)
                    ->where('item_number',$formula->item_number)
                    ->where('default_lot_no', $onhand->lot_number)
                    ->sum('input_quantity_summary');
            // $onhand->onhand_quantity = $onhand->onhand_quantity - $summaryUseOnhand;

            $qty = $totalQty  <= $onhand->onhand_quantity
                                ? $totalQty
                                : $onhand->onhand_quantity ;


            $formulasVV = $this->setArray($formula, $onhand, $request,  (float)$qty , $onhands, $last, $program_code, $arr, $originOnhand , $costValidate);

        }

        return $formulasVV;
    }

    public function setNoOnhand($request, $formula, $onhands, $program_code, $arr, $originOnhand)
    {

        $sumRatioQty    = number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', '');
        $sumQty         = number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', '');
        if($program_code == 'PMP0051'){
            $sumQty  = (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;
        }
        $summaryUseOnhand =  collect($arr)
                            ->where('item_number',$formula->item_number)
                            ->where('default_lot_no', $onhands[0]->lot_number)
                            ->sum('input_quantity_summary');

        // $onhands[0]->onhand_quantity  = $onhands[0]->onhand_quantity -$summaryUseOnhand;
        $productDetailUom           = $formula->itemConvUom()
                                        ? $formula->itemConvUom()->toUom->unit_of_measure
                                        : $formula->product_detail_uom;
        $productUnitOfMeasure       = $formula->itemConvUom()
                                        ? $formula->itemConvUom()->toUom->unit_of_measure
                                        : $formula->product_unit_of_measure;
        $sumTotalQty                =  $formula->itemConvUom()
                                        ? $sumQty * $formula->itemConvUom()->conversion_rate
                                        : $sumQty;

        $available              =   collect($arr)
                                        ->where('item_number',$formula->item_number )
                                        ->where('default_lot_no',  $onhands[0]->lot_number)
                                        ->sum('input_quantity_summary');

        // $flavorGroup = $formula->formulaline_id . $formula->used_leaf_formula;
        // if($program_code == 'PMP0048'){
        //     $flavorGroup  = $formula->item_number;
        // }
        return                 [
            'casting_flavor_name'       => $formula->casting_flavor_name,
            'uuid'                      => Str::uuid(),
            'lot_key'                   => '#',
            'formulaline_id'            => $formula->formulaline_id,
            'leaf_formula'              => $formula->leaf_formula ?? $formula->leaf_fomula,
            'used_leaf_formula'         => $formula->used_leaf_formula,
            'item_number'               => $formula->item_number,
            'item_desc'                 => $formula->item_desc,
            'product_detail_uom'        => $productDetailUom,
            'product_unit_of_measure'   => $productUnitOfMeasure,
            'from_subinventory'         => $formula->setupMfgDeptVLByUserOrg->from_subinventory,
            'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
            'default_lot_no'            => $onhands->last()->lot_number,
            'expiration_date'           => "",
            'onhand_quantity'           => $onhands[0]->onhand_quantity <= 0
                                            ?  0
                                            : $onhands[0]->onhand_quantity ,
            'onhand_available'           => $onhands[0]->onhand_quantity -  $summaryUseOnhand,

            'quantity_summary'          => $sumTotalQty,
            'input_quantity_summary'    => 0,

            'interface_status'          => null,
            'onhand_lists'              => [],
            'line_disabled'             => true,
            'last_line'                 => false,
            'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
            'new_key'                   => 0,
            'group_line'                => $formula->formulaline_id . $formula->used_leaf_formula.$formula->casting_flavor_name,
            'onhand_quantity_display'   =>  $originOnhand->where('lot_number', $onhands[0]->lot_number)->first()
                                            ? (float)$originOnhand->where('lot_number', $onhands[0]->lot_number)->first()->onhand_quantity
                                            : (float)$onhands[0]->onhand_quantity,
        ];

    }

    public function setArray($formula, $onhand, $request, $requireQty, $onhands, $last, $program_code, $arr=[],$originOnhand=null,$costValidate=null)
    {

        $sumRatioQty =  (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;
        $qty =          (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;

        $onhandUsed              =   collect($arr)
                                    ->where('item_number',$formula->item_number )
                                    ->where('default_lot_no',  $onhand->lot_number)
                                    ->sum('input_quantity_summary');

        $oprn = $request['oprn_no'];
        $blendNo = $request['blend_no'];
        $blendNo = $request['blend_no'];
        $sumQty  = 0;
        if ($program_code  == 'PMP0049' || $program_code  == 'PMP0059') {
            $sumQty = $requireQty;
        }

        // $inputQty = $program_code  == 'PMP0049'
        //                 ? $sumQty
        //                 :  $requireQty
        //                     ? number_format((float)$requireQty, 6, '.', '')
        //                     : number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 6, '.', '');
        if ($program_code  == 'PMP0049' || $program_code  == 'PMP0059') {
            $inputQty = $sumQty;
        
        } else{
            if($requireQty){
                $inputQty =  (float)$requireQty;
            }else{
                $inputQty = (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;
            }
        }

        $totalQuantity =  ($program_code  == 'PMP0049' || $program_code  == 'PMP0059')
                            ? $inputQty
                            : (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;


        if($program_code  == 'PMP0051'){
            $inputQty = (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;
        }
        $productDetailUom = "";
        $productUnitOfMeasure = "";
        $onHandQty = "";

        if ($program_code != 'PMP0049' && $program_code != 'PMP0059') {

            $productDetailUom       = $onhand->itemConvUom()
                                        ? $formula->itemConvUom()->toUom->uom_code
                                        : $onhand->primary_uom_code;
            $productUnitOfMeasure   = $onhand->itemConvUom()
                                        ? $onhand->itemConvUom()->toUom->unit_of_measure
                                        : $onhand->primary_unit_of_measure;
            $onHandQty              =  $formula->itemConvUom()
                                        ? $onhand->onhand_quantity * $formula->itemConvUom()->conversion_rate
                                        : $onhand->onhand_quantity;
            $inputQty               =  $formula->itemConvUom()
                                        ? $formula->itemConvUom()->conversion_rate * ($request['total_opt_quantity'] * $formula->ratio_qty_per_unit)
                                        : $inputQty;

            // dd($formula->itemConvUom() , $formula->detail_uom , $formula);                  
            // dd($inputQty);
        }


        // $checkFormula =                 
        $parentFormula = PtctMfgFormulaV::where('product_item_number' , $formula->product_item_number)
                        ->where('organization_code', $formula->organization_code)
                        ->where('item_classification_code', $formula->item_classification_code)
                        ->where('reference_item_number', $formula->item_number)
                        ->where('recipe_version', $formula->recipe_version)
                        ->first();
        $taxOnhand = "";
        if($parentFormula){
            if(count($parentFormula->getOnhand()) >0){
                $checkOnhand =  $parentFormula->getOnhand()->where('lot_number', $onhand->lot_number)->first();
                if(!$checkOnhand){
                    $taxOnhand =  $parentFormula->item_number.' : '. $parentFormula->item_desc . ' lot '.  $onhand->lot_number. ' : ไม่พบ onhand';
                }
            }
        }
        // dd($formula->group_line);
        // $taxOnhand = '';
        // dd($program_code, $inputQty);
        // dd($formula->casting_flavor_name);
        return  [
            'casting_flavor_name'       => $formula->casting_flavor_name,
            'uuid'                      => Str::uuid(),
            'lot_key'                   => $formula->formulaline_id . $onhand->lot_number,
            // 'group_line'                => $program_code  == 'PMP0007' 
            //                                     ? $formula->formulaline_id .$formula->leaf_formula ?? $formula->leaf_fomula 
            //                                     : $formula->used_leaf_formula.$formula->casting_flavor_name.$formula->formulaline_id ,
            'group_line'                => $program_code  == 'PMP0007' 
                                            ? $formula->formulaline_id .$formula->leaf_formula ?? $formula->leaf_fomula 
                                            : $formula->group_line,
            'formulaline_id'            => $formula->formulaline_id,
            'leaf_formula'              => $formula->leaf_formula ?? $formula->leaf_fomula,
            'used_leaf_formula'         => $formula->used_leaf_formula,
            'item_number'               => $formula->item_number,
            'item_desc'                 => $formula->item_desc,
            'product_detail_uom'        => ($program_code  == 'PMP0049' || $program_code  == 'PMP0059')
                                            ? $onhand->primary_uom_code
                                            : $productDetailUom,
            'product_unit_of_measure'   => ($program_code  == 'PMP0049' || $program_code  == 'PMP0059')
                                            ? $formula->uom->unit_of_measure
                                            : $productUnitOfMeasure,
            'item_desc'                 => $formula->item_desc,
            'from_subinventory'         => $onhand->subinventory_code,
            'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
            'default_lot_no'            => $onhand->lot_number,
            'expiration_date'           => $onhand->expiration_date,
            'onhand_quantity'           => $originOnhand->where('lot_number', $onhand->lot_number)->first()
                                            ? (float)$originOnhand->where('lot_number', $onhand->lot_number)->first()->onhand_quantity
                                            : (float)$onhand->onhand_quantity,
            'onhand_quantity_display'   =>  $originOnhand->where('lot_number', $onhand->lot_number)->first()
                                            ? (float)$originOnhand->where('lot_number', $onhand->lot_number)->first()->onhand_quantity
                                            : (float)$onhand->onhand_quantity,
            'quantity_summary'          => ($program_code == 'PMP0049' || $program_code == 'PMP0051' || $program_code == 'PMP0059')
                                            ? $inputQty
                                            : $inputQty,
            'input_quantity_summary'    => $inputQty,
            'onhand_available'          => $onhand->onhand_quantity - $onhandUsed,
            'item_desc'                 => $onhand->item_desc,
            'interface_status'          => null,
            'onhand_lists'              => $onhands,
            'line_disabled'             => $sumRatioQty == null
                                            ? (float) $sumRatioQty > (float) $onhand->onhand_quantity
                                                ? true
                                                : false
                                            : false,
            'last_line'                 => $last,
            'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
            'new_key'                   => 0,
            'f_uom'                     => $formula->detail_uom,
            'cost_validate_msg'         => $costValidate->msg ?? "",
            'cost_validate_status'      => $costValidate->status ?? "",
            'line_id'                   => null,
            'msg_onhand_tax'            => $taxOnhand,

        ];
    }


    public function setArrayPMP0049($formula, $onhand, $request, $requireQty, $onhands, $last, $program_code, $arr=[],$originOnhand=null , $amount = null)
    {

        $sumRatioQty =  (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
        $qty =          (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;

        $onhandUsed              =   collect($arr)
                                    ->where('item_number',$formula->item_number )
                                    // ->where('default_lot_no',  $onhand->lot_number)
                                    ->sum('input_quantity_summary');

        $oprn = $request['oprn_no'];
        $blendNo = $request['blend_no'];
        $blendNo = $request['blend_no'];
        $sumQty  = 0;
        if ($program_code  == 'PMP0049') {
            $sumQty = $requireQty;
        }


        if ($program_code  == 'PMP0049') {
            $inputQty = $sumQty;
        }else{
            //PMP0051
            if($requireQty){
                $inputQty =(float)$requireQty;
            }else{
                $inputQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
            }
        }


        $totalQuantity =  $program_code  == 'PMP0049'
                            ? $inputQty
                            : (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;


        if($program_code  == 'PMP0051'){
            $inputQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
        }

        $productDetailUom = "";
        $productUnitOfMeasure = "";
        $onHandQty = "";


        if ($program_code != 'PMP0049') {

            $productDetailUom       = $onhand->itemConvUom()
                                        ? $onhand->itemConvUom()->toUom->uom_code
                                        : $onhand->primary_uom_code;
            $productUnitOfMeasure   = $onhand->itemConvUom()
                                        ? $onhand->itemConvUom()->toUom->unit_of_measure
                                        : $onhand->primary_unit_of_measure;
            $onHandQty              =  $onhand->itemConvUom()
                                        ? $onhand->onhand_quantity * $onhand->itemConvUom()->conversion_rate
                                        : $onhand->onhand_quantity;
        }

        return  [
            'casting_flavor_name'       => $formula->casting_flavor_name,
            'uuid'                      => Str::uuid(),
            'lot_key'                   => $formula->formulaline_id . $onhand->lot_number,
            'group_line'                => $formula->formulaline_id . $formula->used_leaf_formula.$formula->casting_flavor_name,
            'formulaline_id'            => $formula->formulaline_id,
            'leaf_formula'              => $formula->leaf_formula,
            'used_leaf_formula'         => $formula->used_leaf_formula,
            'item_number'               => $formula->item_number,
            'item_desc'                 => $formula->item_desc,
            'product_detail_uom'        => $program_code  == 'PMP0049'
                                            ? $onhand->primary_uom_code
                                            : $productDetailUom,
            'product_unit_of_measure'   => $program_code  == 'PMP0049'
                                            ? $formula->uom->unit_of_measure
                                            : $productUnitOfMeasure,
            'item_desc'                 => $formula->item_desc,
            'from_subinventory'         => $onhand->subinventory_code,
            'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
            'default_lot_no'            => $onhand->lot_number,
            'expiration_date'           => $onhand->expiration_date,
            'onhand_quantity'           => $onhand->onhand_quantity,
            'onhand_quantity_display'   =>  $originOnhand->where('lot_number', $onhand->lot_number)->first()
                                            ? $originOnhand->where('lot_number', $onhand->lot_number)->first()->onhand_quantity
                                            : $onhand->onhand_quantity,
            'quantity_summary'          => $program_code == 'PMP0049' || $program_code == 'PMP0051'
                                            ? $inputQty
                                            : number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', ''),
            'input_quantity_summary'    =>  $amount->input,
            'onhand_available'          => $onhand->onhand_quantity,
            'item_desc'                 => $onhand->item_desc,
            'interface_status'          => null,
            'onhand_lists'              => $onhands,
            'line_disabled'             => $sumRatioQty == null
                                            ? (float) $sumRatioQty > (float) $onhand->onhand_quantity
                                                ? true
                                                : false
                                            : false,
            'last_line'                 => $last,
            'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
            'new_key'                   => 0,
            'line_id'                   => null,
        ];
    }

    public function setArrayPMP0059($formula, $onhand, $request, $requireQty, $onhands, $last, $program_code, $arr=[],$originOnhand=null , $amount = null)
    {

        $sumRatioQty =  (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
        $qty =          (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;

        $onhandUsed              =   collect($arr)
                                    ->where('item_number',$formula->item_number )
                                    // ->where('default_lot_no',  $onhand->lot_number)
                                    ->sum('input_quantity_summary');

        $oprn = $request['oprn_no'];
        $blendNo = $request['blend_no'];
        $blendNo = $request['blend_no'];
        $sumQty  = 0;
        if ($program_code  == 'PMP0059') {
            $sumQty = $requireQty;
        }


        if ($program_code  == 'PMP0059') {
            $inputQty = $sumQty;
        }else{
            //PMP0051
            if($requireQty){
                $inputQty =(float)$requireQty;
            }else{
                $inputQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
            }
        }


        $totalQuantity =  $program_code  == 'PMP0059'
                            ? $inputQty
                            : (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;


        if($program_code  == 'PMP0051'){
            $inputQty = (float)$request['total_opt_quantity'] * (float)$formula->ratio_qty_per_unit;
        }

        $productDetailUom = "";
        $productUnitOfMeasure = "";
        $onHandQty = "";


        if ($program_code != 'PMP0059') {

            $productDetailUom       = $onhand->itemConvUom()
                                        ? $onhand->itemConvUom()->toUom->uom_code
                                        : $onhand->primary_uom_code;
            $productUnitOfMeasure   = $onhand->itemConvUom()
                                        ? $onhand->itemConvUom()->toUom->unit_of_measure
                                        : $onhand->primary_unit_of_measure;
            $onHandQty              =  $onhand->itemConvUom()
                                        ? $onhand->onhand_quantity * $onhand->itemConvUom()->conversion_rate
                                        : $onhand->onhand_quantity;
        }

        return  [
            'casting_flavor_name'       => $formula->casting_flavor_name,
            'uuid'                      => Str::uuid(),
            'lot_key'                   => $formula->formulaline_id . $onhand->lot_number,
            'group_line'                => $formula->formulaline_id . $formula->used_leaf_formula.$formula->casting_flavor_name,
            'formulaline_id'            => $formula->formulaline_id,
            'leaf_formula'              => $formula->leaf_formula,
            'used_leaf_formula'         => $formula->used_leaf_formula,
            'item_number'               => $formula->item_number,
            'item_desc'                 => $formula->item_desc,
            'product_detail_uom'        => $program_code  == 'PMP0059'
                                            ? $onhand->primary_uom_code
                                            : $productDetailUom,
            'product_unit_of_measure'   => $program_code  == 'PMP0059'
                                            ? $formula->uom->unit_of_measure
                                            : $productUnitOfMeasure,
            'item_desc'                 => $formula->item_desc,
            'from_subinventory'         => $onhand->subinventory_code,
            'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
            'default_lot_no'            => $onhand->lot_number,
            'expiration_date'           => $onhand->expiration_date,
            'onhand_quantity'           => $onhand->onhand_quantity,
            'onhand_quantity_display'   =>  $originOnhand->where('lot_number', $onhand->lot_number)->first()
                                            ? $originOnhand->where('lot_number', $onhand->lot_number)->first()->onhand_quantity
                                            : $onhand->onhand_quantity,
            'quantity_summary'          => $program_code == 'PMP0059' || $program_code == 'PMP0051'
                                            ? $inputQty
                                            : number_format((float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit, 5, '.', ''),
            'input_quantity_summary'    =>  $amount->input,
            'onhand_available'          => $onhand->onhand_quantity,
            'item_desc'                 => $onhand->item_desc,
            'interface_status'          => null,
            'onhand_lists'              => $onhands,
            'line_disabled'             => $sumRatioQty == null
                                            ? (float) $sumRatioQty > (float) $onhand->onhand_quantity
                                                ? true
                                                : false
                                            : false,
            'last_line'                 => $last,
            'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
            'new_key'                   => 0,
            'line_id'                   => null,
        ];
    }


    public function setFormulaLine($formulalineId, $onhand, $request, $qty = null, $lists, $last = true)
    {
        $sumRatioQty = number_format((float)$request['total_opt_quantity'] * $onhand->formulaFromInvItem->ratio_qty_per_unit, 5, '.', '');

        return $formulalineId = [
            'casting_flavor_name'       => $onhand->formulaFromInvItem->casting_flavor_name,
            'uuid'                      => Str::uuid(),
            'lot_key'                   => $onhand->formulaFromInvItem->formulaline_id . $onhand->lot_number,
            'formulaline_id'            => $onhand->formulaFromInvItem->formulaline_id,
            'leaf_formula'              => $onhand->formulaFromInvItem->leaf_formula,
            'used_leaf_formula'         => $onhand->formulaFromInvItem->used_leaf_formula,
            'item_number'               => $onhand->formulaFromInvItem->item_number,
            'item_desc'                 => $onhand->formulaFromInvItem->item_desc,
            'product_detail_uom'        => $onhand->formulaFromInvItem->product_detail_uom,
            'item_desc'                 => $onhand->formulaFromInvItem->item_desc,
            'from_subinventory'         => $onhand->subinventory_code,
            'from_location_code'        => $onhand->organization_code,
            'default_lot_no'            => $onhand->lot_number,
            'expiration_date'           => $onhand->expiration_date,
            'onhand_quantity'           => number_format((float)$onhand->onhand_quantity, 5, '.', ''),
            'quantity_summary'          => number_format((float)$request['total_opt_quantity'] * $onhand->formulaFromInvItem->ratio_qty_per_unit, 5, '.', ''),
            'input_quantity_summary'    => $qty
                                            ? number_format((float)$qty, 5, '.', '')
                                            : number_format((float)$request['total_opt_quantity'] * $onhand->formulaFromInvItem->ratio_qty_per_unit, 5, '.', ''),
            'item_desc'                 => $onhand->formulaFromInvItem->item_desc,
            'interface_status'          => null,
            'onhand_lists'              => $lists,
            'line_disabled'             => $qty == null
                                            ? (float) $sumRatioQty > (float) $onhand->onhand_quantity
                                                ? true
                                                : false
                                            : false,
            'last_line'                 => $last,
            'tobacco_ingrident_type'    => $onhand->formulaFromInvItem->tobacco_ingrident_type,
            'new_key'                   => 0,
            'line_id'                   => null,

        ];
    }

    public function save($request)
    {
        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;

        $profile        =  getDefaultData(\Request::path());
        $completeDate   = $this->formatDate($request->date);
        $issueDate      = $this->formatDate($request->issue_date);
        $date           = date('Y/m/d', strtotime($completeDate));

        if($casePmp0007) {
            if ($profile->organization_code == 'M03') {
                $blend = PtmpPmp00070And048V::whereDate('transaction_date', $date)
                        ->getBlend($profile, request()->program_code)
                        ->where('organization_id', auth()->user()->organization_id)
                        ->where('item_number', $request->item_id)
                        ->where('batch_no', $request->job_no)
                        ->first();
            }elseif($profile->organization_code == 'MP2'){
                $blend =    PtmpMesReviewIssueV::where('batch_id', $request->blend_no)
                                ->whereDate('transaction_date', $date)
                                ->where('item_number', $request->item_id)
                                ->where('organization_id', auth()->user()->organization_id)
                                ->with(['uom'])
                                ->first();
            }else {    
                $blend = PtmpPmp00070And048V::where('batch_id', $request->blend_no)
                                            ->whereDate('transaction_date', $date)
                                            ->where('organization_id', auth()->user()->organization_id)
                                            ->where('item_number', $request->item_id)
                                            ->first();  
            }
        }

        if($casePmp0048){
            $blend = PtmpPmp00070And048V::where('batch_id', $request->blend_no)
                    ->whereDate('transaction_date', $date)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('item_number', $request->item_id)
                    ->first();

        }

        if($casePmp0049){
            $blend = PtmpMesReviewIssueV::where('blend_no', $request->blend_no)
                    ->whereDate('transaction_date', $date)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('item_number', $request->item_id)
                    ->first();

        }

        if($casePmp0059){
            $blend = PtmpMesReviewIssueV::where('blend_no', $request->blend_no)
                    ->whereDate('transaction_date', $date)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('item_number', $request->item_id)
                    ->hasStampItem()
                    ->first();

        }

        if($casePmp0051){
            $blend = PtmpMesReviewIssueV::where('blend_no', $request->blend_no)
                    ->whereDate('transaction_date', $date)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('item_number', $request->item_id)
                    ->first();
        }

        $batchNo = uniqid();
        $mesReviewIssueHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', $request->issue_header_id)
                                                        ->first();

        if ($request->program_code == 'PMP0049' || 
            $request->program_code  == 'PMP0051' || 
            $request->program_code  == 'PMP0059') {
            $blend = PtmpMesReviewIssueV::where('batch_no', $request->blend_no)->first();
            $mesReviewIssueHeaderParent = $this->saveHeader($request, $batchNo, $blend, $issueDate, $completeDate, null, null, $request['total_quantity_from_wip']);
            $this->saveLine($request, $mesReviewIssueHeaderParent, $batchNo);

            return $mesReviewIssueHeaderParent;
        }

        if (!$mesReviewIssueHeader) {
            if (!$request->opt) {
                $mesReviewIssueHeader = $this->saveHeaderByOpts($request, $batchNo, $blend, $issueDate, $completeDate);
            } else {
                $mesReviewIssueHeader = $this->saveHeader($request, $batchNo, $blend, $issueDate, $completeDate);
                $this->saveLine($request, $mesReviewIssueHeader, $batchNo, null , null , $blend->batch_no);
            }
        } else {
            $this->updateLine($request,  $mesReviewIssueHeader);
        }
        return $mesReviewIssueHeader;
    }


    public function formatDate($date)
    {
        $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
        $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

        $year = (int) $formYear - 543;
        $date = (string) $formDate . "-" . $year;

        return $date;
    }

    public function saveHeaderByOpts($request, $batchNo, $blend, $issueDate, $completeDate)
    {
        $mesReviewIssueHeaderParent = (object)[];
        $lineParent     = null;
        $optGroup       = collect($request->opts)->groupBy('opt');

        $i = 1;
        foreach ($optGroup as $opt => $opts) {

            $parentIssueID = null;

            if ($i == 1) {
                $mesReviewIssueHeaderParent = $this->saveHeader($request, $batchNo, $blend, $issueDate, $completeDate, $parentIssueID,  $opt, $opts[0]['transaction_quantity']);
                $lineParent =  $this->saveLine($request, $mesReviewIssueHeaderParent, $batchNo, null, count($optGroup), $blend->batch_no);
            }
            $parentId = $parentIssueID;
            if ($i != 1) {
                $header = $this->saveHeader($request, $batchNo, $blend, $issueDate, $completeDate, $mesReviewIssueHeaderParent->issue_header_id,  $opt, $opts[0]['transaction_quantity']);
            }

            $i++;
        }

        return $mesReviewIssueHeaderParent;
    }
    public function saveHeader($request, $batchNo, $blend, $issueDate, $completeDate, $parentIssueID = null, $opt = null, $qty = null)
    {
        $sysdate = now();
        $mesReviewIssueHeader                   = new PtpmMesReviewIssueHeaders;
        $mesReviewIssueHeader->department_code  = getDefaultData('/pm/wip-issue')->department_code;
        $mesReviewIssueHeader->organization_id  = auth()->user()->organization_id;
        $mesReviewIssueHeader->batch_no         = $blend->batch_no;
        $mesReviewIssueHeader->opt              = $opt
            ? $opt
            : $request->opt;
        $mesReviewIssueHeader->inventory_item_id = $blend->inventory_item_id;
        $mesReviewIssueHeader->ingridient_group_code =  ($request->program_code == 'PMP0049' ||  $request->program_code  == 'PMP0051' || $request->program_code  == 'PMP0059')
            ? null
            : $request->item_classification_code;

        $mesReviewIssueHeader->opt_plan_qty = $qty
            ? $qty
            : $request->total_opt_quantity;

        $mesReviewIssueHeader->job_type_code = $blend->job_type_code;
        $mesReviewIssueHeader->wip_step = $request->oprn;
        $mesReviewIssueHeader->machine_set = 1;
        $mesReviewIssueHeader->issue_date = Carbon::parse($completeDate);
        $mesReviewIssueHeader->complete_date =  Carbon::parse($completeDate);
        $mesReviewIssueHeader->created_by = auth()->user()->user_id;
        $mesReviewIssueHeader->created_at = Carbon::parse($completeDate);
        $mesReviewIssueHeader->record_status = "INSERT";
        $mesReviewIssueHeader->trial_flag = 'N';
        $mesReviewIssueHeader->batch_id = $blend->batch_id;
        $mesReviewIssueHeader->created_by  = auth()->user()->user_id;
        $mesReviewIssueHeader->web_batch_no = $batchNo;
        $mesReviewIssueHeader->attribute15 = $parentIssueID;
        $mesReviewIssueHeader->program_code = $request->program_code;

        if ($mesReviewIssueHeader->program_code == 'PMP0051') {
            $findQty = PtmpProductBatchV::where('organization_id', $mesReviewIssueHeader->organization_id)
                        ->where('batch_id', $mesReviewIssueHeader->batch_id)
                        ->where('wip_step', $mesReviewIssueHeader->wip_step)
                        ->whereDate('transaction_date', $mesReviewIssueHeader->complete_date)
                        ->first();
            $mesReviewIssueHeader->opt_plan_qty = $findQty->confirm_qty ?? $request->total_opt_quantity;
        }

        if ($mesReviewIssueHeader->attribute15) {
            $findParentIssue = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->attribute15)->first();
            if ($findParentIssue) {
                $mesReviewIssueHeader->request_number = $findParentIssue->request_number;
            }
        }

        $mesReviewIssueHeader->created_at = $sysdate;
        $mesReviewIssueHeader->updated_at = $sysdate;
        $mesReviewIssueHeader->save();
        return $mesReviewIssueHeader;
    }

    public function saveHeaderProgramPMP0049($request, $batchNo, $blend, $issueDate, $completeDate, $parentIssueID = null, $opt = null, $qty = null)
    {

        $mesReviewIssueHeader                   = new PtpmMesReviewIssueHeaders;
        $mesReviewIssueHeader->department_code  = getDefaultData('/pm/wip-issue')->department_code;
        $mesReviewIssueHeader->organization_id  = auth()->user()->organization_id;
        $mesReviewIssueHeader->batch_no         = $blend->batch_no;
        $mesReviewIssueHeader->opt              = $opt
                                                    ? $opt
                                                    : $request->opt;
        $mesReviewIssueHeader->inventory_item_id = $blend->inventory_item_id;
        $mesReviewIssueHeader->ingridient_group_code =  $request->program_code == 'PMP0049' || $request->program_code  == 'PMP0051'
                                                    ? null
                                                    : $request->item_classification_code;
        $mesReviewIssueHeader->opt_plan_qty = $qty
                                                    ? $qty
                                                    : $request->total_opt_quantity;
        $mesReviewIssueHeader->job_type_code = $blend->job_type_code;
        $mesReviewIssueHeader->wip_step = $request->oprn;
        $mesReviewIssueHeader->machine_set = 1;
        $mesReviewIssueHeader->issue_date = Carbon::parse($completeDate);
        $mesReviewIssueHeader->complete_date =  Carbon::parse($completeDate);
        $mesReviewIssueHeader->created_by = auth()->user()->user_id;
        $mesReviewIssueHeader->created_at = Carbon::parse($completeDate);
        $mesReviewIssueHeader->record_status = "INSERT";
        $mesReviewIssueHeader->trial_flag = 'N';
        $mesReviewIssueHeader->batch_id = $blend->batch_id;
        $mesReviewIssueHeader->created_by  = auth()->user()->user_id;
        $mesReviewIssueHeader->web_batch_no = $batchNo;
        $mesReviewIssueHeader->attribute15 = $parentIssueID;
        $mesReviewIssueHeader->program_code = $request->program_code;

        if ($mesReviewIssueHeader->attribute15) {
            $findParentIssue = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->attribute15)->first();
            if ($findParentIssue) {
                $mesReviewIssueHeader->request_number = $findParentIssue->request_number;
            }
        }

        $mesReviewIssueHeader->save();
        return $mesReviewIssueHeader;
    }

    public function saveHeaderProgramPMP0059($request, $batchNo, $blend, $issueDate, $completeDate, $parentIssueID = null, $opt = null, $qty = null)
    {

        $mesReviewIssueHeader                   = new PtpmMesReviewIssueHeaders;
        $mesReviewIssueHeader->department_code  = getDefaultData('/pm/wip-issue')->department_code;
        $mesReviewIssueHeader->organization_id  = auth()->user()->organization_id;
        $mesReviewIssueHeader->batch_no         = $blend->batch_no;
        $mesReviewIssueHeader->opt              = $opt
                                                    ? $opt
                                                    : $request->opt;
        $mesReviewIssueHeader->inventory_item_id = $blend->inventory_item_id;
        $mesReviewIssueHeader->ingridient_group_code =  ($request->program_code == 'PMP0049' || $request->program_code  == 'PMP0051' || $request->program_code  == 'PMP0059')
                                                    ? null
                                                    : $request->item_classification_code;
        $mesReviewIssueHeader->opt_plan_qty = $qty
                                                    ? $qty
                                                    : $request->total_opt_quantity;
        $mesReviewIssueHeader->job_type_code = $blend->job_type_code;
        $mesReviewIssueHeader->wip_step = $request->oprn;
        $mesReviewIssueHeader->machine_set = 1;
        $mesReviewIssueHeader->issue_date = Carbon::parse($completeDate);
        $mesReviewIssueHeader->complete_date =  Carbon::parse($completeDate);
        $mesReviewIssueHeader->created_by = auth()->user()->user_id;
        $mesReviewIssueHeader->created_at = Carbon::parse($completeDate);
        $mesReviewIssueHeader->record_status = "INSERT";
        $mesReviewIssueHeader->trial_flag = 'N';
        $mesReviewIssueHeader->batch_id = $blend->batch_id;
        $mesReviewIssueHeader->created_by  = auth()->user()->user_id;
        $mesReviewIssueHeader->web_batch_no = $batchNo;
        $mesReviewIssueHeader->attribute15 = $parentIssueID;
        $mesReviewIssueHeader->program_code = $request->program_code;

        if ($mesReviewIssueHeader->attribute15) {
            $findParentIssue = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->attribute15)->first();
            if ($findParentIssue) {
                $mesReviewIssueHeader->request_number = $findParentIssue->request_number;
            }
        }

        $mesReviewIssueHeader->save();
        return $mesReviewIssueHeader;
    }


    public function saveLine($request, $mesReviewIssueHeader, $webBatchNo=null, $parentLineId=null, $countOpt=null, $batchNo=null)
    {   
        foreach ($request->lines as $key => $line) {
            if($request->program_code == 'PMP0051' || $request->program_code == 'PMP0007' || $request->program_code == 'PMP0048'){
                $formula = PtctMfgFormulaV::has('setupMfgDeptVLByUserOrg')
                            ->where('formulaline_id', $line['formulaline_id'])
                            ->first();
            } else {
                $formula = PtpmMfgFormulaV::has('setupMfgDeptVLByUserOrg')
                            ->where('formulaline_id', $line['formulaline_id'])
                            ->first();
            }

            $profile =  getDefaultData(\Request::path());

            $mfg = $formula->setupMfgDeptVLByUserOrg;
            if ($profile->organization_code == 'M12') {
                $itemType =  $formula->mtlSystemItem->item_type;
                $mfg          = $formula->setupMfgDeptVLByMultiUserOrg
                                        ->where('inv_item_type', $itemType)
                                        ->first();
            }

            if(!$formula['reference_item_number']){
                $mesReviewIssueLine                         = new PtpmMesReviewIssueLines;
                $mesReviewIssueLine->issue_header_id        = $mesReviewIssueHeader->issue_header_id;
                $mesReviewIssueLine->organization_id        = $profile->organization_code == 'M12'
                                                                ? $mfg->from_organization_id
                                                                : $formula->setupMfgDeptVLByUserOrg->from_organization_id;
                $mesReviewIssueLine->subinventory_code      = $profile->organization_code == 'M12'
                                                                ? $mfg->from_subinventory
                                                                : $formula->setupMfgDeptVLByUserOrg->from_subinventory;
                $mesReviewIssueLine->line_num               = $formula->line_no;
                $mesReviewIssueLine->formula_id             = $formula->formula_id;
                $mesReviewIssueLine->formulaline_id         = $formula->formulaline_id;
                $mesReviewIssueLine->inventory_item_id      = $formula->inventory_item_id;
                $mesReviewIssueLine->lot_number             = data_get($line, 'default_lot_no');
                $mesReviewIssueLine->program_code           = $request->program_code;
                $mesReviewIssueLine->confirm_qty            = data_get($line, 'input_quantity_summary');
                $mesReviewIssueLine->web_batch_no           = $webBatchNo;
                $mesReviewIssueLine->created_by             = auth()->user()->user_id;
                $mesReviewIssueLine->created_at             = now();
                $mesReviewIssueLine->record_status          = "INSERT";
                $mesReviewIssueLine->leaf_formula           = $formula->leaf_fomula ?? data_get($line, 'used_leaf_formula');
                $mesReviewIssueLine->transaction_type_id    = $profile->organization_code == 'M12'
                                                                ? $mfg->transaction_type_id
                                                                : $formula->setupMfgDeptVLByUserOrg->transaction_type_id;
                $mesReviewIssueLine->confirm_uom_code       = data_get($line, 'product_detail_uom');
                $mesReviewIssueLine->locator_id             = $profile->organization_code == 'M12'
                                                                ? $mfg->from_locator_id
                                                                : $formula->setupMfgDeptVLByUserOrg->from_locator_id;
                $mesReviewIssueLine->attribute2             = $formula->casting_flavor_name;                                   
                $mesReviewIssueLine->attribute15            = data_get($line, 'onhand_quantity');
                $mesReviewIssueLine->attribute14            = $mesReviewIssueHeader->ingridient_group_code;
                $mesReviewIssueLine->attribute13            = $parentLineId;
                $mesReviewIssueLine->attribute12            = data_get($line, 'quantity_summary');
                $mesReviewIssueLine->attribute11            = $formula->tobacco_ingrident_type;
    
                $mesReviewIssueLine->created_at             = $mesReviewIssueHeader->created_at;
                $mesReviewIssueLine->updated_at             = $mesReviewIssueHeader->updated_at;
                $mesReviewIssueLine->save();
            }
        }

        $itemClassificationCode = null;
        if($request->program_code == 'PMP0007'){
            $itemClassificationCode = '01';
        } elseif($request->program_code == 'PMP0048'){
            $itemClassificationCode = '02';
        }
        
        $formulasV =  PtctMfgFormulaV::where('product_item_id', $formula->product_item_id)
                                    ->where('formula_id', $formula->formula_id)
                                    ->where('receipe_type_code', 1)
                                    ->when($itemClassificationCode, function($q) use ($itemClassificationCode){
                                        $q->where('item_classification_code', $itemClassificationCode);
                                    })
                                    ->where('organization_id', auth()->user()->organization_id)
                                    ->where('reference_item_number', '!=' , null)
                                    ->get();

        $max            = $formulasV->max('recipe_version');
        $formulasLastV  = $formulasV->where('recipe_version', $max);
        $profile        =  getDefaultData(\Request::path());
        if(count($formulasLastV) != 0){
            foreach ($formulasLastV as $formula) {
                $lines = PtpmMesReviewIssueLines::where('formulaline_id', $formula->taxItem->formulaline_id)
                                                ->where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                                                ->get();

                $mfg = $formula->setupMfgDeptVLByUserOrg;
                foreach ($lines as $line) {
                    $newMesReviewIssueLine                         = new PtpmMesReviewIssueLines;
                    $newMesReviewIssueLine->issue_header_id        = $mesReviewIssueHeader->issue_header_id;
                    $newMesReviewIssueLine->organization_id        = $profile->organization_code == 'M12'
                                                                    ? $mfg->from_organization_id
                                                                    : $formula->setupMfgDeptVLByUserOrg->from_organization_id;
                    $newMesReviewIssueLine->subinventory_code      = $profile->organization_code == 'M12'
                                                                        ? $mfg->from_subinventory
                                                                        : $formula->setupMfgDeptVLByUserOrg->from_subinventory;
                    $newMesReviewIssueLine->line_num               = $formula->line_no;
                    $newMesReviewIssueLine->formula_id             = $formula->formula_id;
                    $newMesReviewIssueLine->formulaline_id         = $formula->formulaline_id;
                    $newMesReviewIssueLine->inventory_item_id      = $formula->inventory_item_id;
                    $newMesReviewIssueLine->lot_number             = $line->lot_number;
                    $newMesReviewIssueLine->program_code           = $request->program_code;
                    $newMesReviewIssueLine->confirm_qty            = $line->confirm_qty;
                    $newMesReviewIssueLine->web_batch_no           = $webBatchNo;
                    $newMesReviewIssueLine->created_by             = auth()->user()->user_id;
                    $newMesReviewIssueLine->created_at             = now();
                    $newMesReviewIssueLine->record_status          = "INSERT";
                    $newMesReviewIssueLine->leaf_formula           = $formula->taxItem->leaf_fomula;
                    $newMesReviewIssueLine->transaction_type_id    = $profile->organization_code == 'M12'
                                                                    ? $mfg->transaction_type_id
                                                                    : $formula->setupMfgDeptVLByUserOrg->transaction_type_id;
                    $newMesReviewIssueLine->confirm_uom_code       = $line->confirm_uom_code;
                    $newMesReviewIssueLine->locator_id             = $profile->organization_code == 'M12'
                                                                    ? $mfg->from_locator_id
                                                                    : $formula->setupMfgDeptVLByUserOrg->from_locator_id;
                    $newMesReviewIssueLine->attribute15            = $line['onhand_quantity'];
                    $newMesReviewIssueLine->attribute14            = $mesReviewIssueHeader->ingridient_group_code;
                    $newMesReviewIssueLine->attribute13            = $parentLineId;
                    $newMesReviewIssueLine->attribute12            = $formula->attribute12;
                    $newMesReviewIssueLine->attribute11            = $formula->taxItem->tobacco_ingrident_type;
                    $newMesReviewIssueLine->attribute10            = $formula->taxItem->formulaline_id;
                    $newMesReviewIssueLine->created_at              = $mesReviewIssueHeader->created_at;
                    $newMesReviewIssueLine->updated_at              = $mesReviewIssueHeader->updated_at;

                    $newMesReviewIssueLine->ref_issue_line_id       = $line->issue_line_id;
                    $newMesReviewIssueLine->save();
                }
                
            }
        }
        
        return $mesReviewIssueLine;
    }


    public function updateLine($request,  $mesReviewIssueHeader)
    {
        foreach ($request->lines as $line) {
            $mesReviewIssueLine = PtpmMesReviewIssueLines::where('formulaline_id', $line['formulaline_id'])
                                    ->where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                                    ->where('lot_number', $line['default_lot_no'])
                                    ->first();

                $mesReviewIssueLine->confirm_qty        = $line['input_quantity_summary'];
                $mesReviewIssueLine->attribute15        = $line['onhand_quantity'];
                $mesReviewIssueLine->updated_at         = now();
                $mesReviewIssueLine->updated_by_id      = auth()->user()->user_id;
                $mesReviewIssueLine->last_updated_by    = auth()->user()->user_id;
                $mesReviewIssueLine->last_update_date   = now();
                $mesReviewIssueLine->creation_date      = auth()->user()->user_id;
                $mesReviewIssueLine->save();

        }

        return;
    }

    public function updateLineCasingFlavor($request,  $mesReviewIssueHeader)
    {
        try {
            $mesReviewIssueHeader->mesReviewIssueLines()->delete();
            $this->saveLine($request, 
                            $mesReviewIssueHeader, 
                            $mesReviewIssueHeader->web_batch_no, 
                            null, 
                            null, 
                            $mesReviewIssueHeader->btach_id);
        } catch (\Exception $e) {
            $result = ['status' => 'E',
                        'msg'   =>  $e->getMessage()];

            return response()->json([
                'result' => $result,
            ]);
        }

        return;
    }


    public function updateLinePmp007($request,  $mesReviewIssueHeader)
    {
        $this->saveLine($request, $mesReviewIssueHeader, $mesReviewIssueHeader->web_batch_no, null , null , $mesReviewIssueHeader->btach_id);
    }

    public function updateRequestNumber($mesReviewIssueHeader)
    {
        if (!$mesReviewIssueHeader->childHeaders) {
            return $mesReviewIssueHeader;
        }


        $mesReviewIssueHeader->childHeaders()
            ->update([
                'request_number' => $mesReviewIssueHeader->request_number
            ]);

        return $mesReviewIssueHeader;
    }

    public function submit($batchNo = null ,$programCode)
    {
        logger("submit start");
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();

        $sql    =   "
            declare
            v_status            varchar2(10);
            v_err_msg            varchar2(2000);
            begin
                ptpm_main.mes_issue_qty(p_program_code => '$programCode',
                                    p_web_batch_no => '$batchNo',
                                    p_user_name => 'MERCURY',
                                    p_status => v_status,
                                    p_err_msg => v_err_msg)   ;

                dbms_output.put_line('Status : ' || :v_status);
                dbms_output.put_line('Error : ' || :v_err_msg);
            end;
                        ";
        logger($sql);
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);


        // $stmt->bindParam(':lv_data', $result['data'], PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        logger("submit end");
        logger($result);
        return $result;
    }

    public function summaryQty($request, $formula, $dateX = null, $dataSummaryQty = [])
    {
        $sumQty = 0;
        if (count($dataSummaryQty) > 0) {
            $dataSummaryQty = $dataSummaryQty->where('item_number', $formula->item_number);
            foreach ($dataSummaryQty as $key => $item) {
                $sumQty +=  $item->ratio_qty_per_unit * $item->product_qty;
            };
        }
        return round($sumQty, 5);


        $oprn = $request['oprn_no'];
        $blendNo = $request['blend_no'];

        if ($dateX == null) {
            $formYear = Carbon::createFromFormat('d/m/Y', $request['date'])->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', $request['date'])->format('d-m');

            $year = (int) $formYear - 543;
            $dateR = (string) $formDate . "-" . $year;
            $dateR = date('d-M-Y', strtotime($dateR));


            // $blendNo = $request['blend_no'];
            $blend = PtmpMesReviewIssueV::where('batch_no', $blendNo)->first();
            $date = date('d-M-Y', strtotime($blend->transaction_date));


            $date = $dateR;
        }

        if ($dateX) {
            $date = $dateX;
        }

        $sumQty = 0;
        if ($formula->item_number) {

            $data = collect(DB::select("
            SELECT  sum(ratio_qty_per_unit * PPD.product_qty) qty
                    FROM    PTMES_PRODUCT_DISTRIBUTION PPD
                    ,       ptpm_machine_relations_v PMr
                    --,       ptct_summary_batch_v psb
                    ,       ptpm_summary_batch_v psb
                    -- ,ptpm_mfg_formula_v pmf
                    ,ptct_mfg_formula_v pmf
                    WHERE   1=1
                    --AND     PPD.ORGANIZATION_ID = PMR.ORGANIZATION_ID
                    AND     PPD.MACHINE_SET = PMR.MACHINE_SET
                    AND     PPD.WIP_STEP = PMR.STEP_NUM
                    AND     PPD.batch_no = '$blendNo'
                    AND PPD.wip_step = '$oprn'
                    and psb.batch_id = ppd.batch_id
                    and psb.organization_id = ppd.organization_id
                    and psb.inventory_item_id = pmf.product_item_id
                    and psb.organization_id = pmf.organization_id
                    and pmf.machine_type_code = pMR.MACHINE_TYPE
                    and to_char (product_date, 'DD-Mon-YYYY') = '$date'
                    and pmf.item_number = '$formula->item_number'
                    and PMr.PM_ENABLE_FLAG = 'Y'
                    and pmf.formula_status = 700
                    and pmf.recipe_status = 700
            "));
            if ($data) {
                $sumQty = $data->first()->qty;
            }
        }
        return round($sumQty, 5);
    }

    public function getReqFml($request, $dateX = null)
    {
        $oprn = $request['oprn_no'];
        $blendNo = $request['blend_no'];
        if ($dateX == null) {
            $formYear = Carbon::createFromFormat('d/m/Y', $request['date'])->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', $request['date'])->format('d-m');

            $year = (int) $formYear - 543;
            $dateR = (string) $formDate . "-" . $year;
            $dateR = date('d-M-Y', strtotime($dateR));

            $blend = PtmpMesReviewIssueV::where('batch_no', $blendNo)->first();
            $date = date('d-M-Y', strtotime($blend->transaction_date));


            $date = $dateR;
        }

        if ($dateX) {
            $date = $dateX;
        }

        $data = collect(
            DB::select("
                SELECT  PPD.product_qty
                    , PMR.MACHINE_TYPE,pmf.item_number,pmf.ratio_qty_per_unit
                FROM    PTMES_PRODUCT_DISTRIBUTION PPD
                ,       ptpm_machine_relations_v PMr
                --,       ptct_summary_batch_v psb
                ,       ptpm_summary_batch_v psb
                -- ,ptpm_mfg_formula_v pmf
                ,ptct_mfg_formula_v pmf
                WHERE   1=1
                --AND     PPD.ORGANIZATION_ID = PMR.ORGANIZATION_ID
                AND     PPD.MACHINE_SET = PMR.MACHINE_SET
                AND     PPD.WIP_STEP = PMR.STEP_NUM
                AND     PPD.batch_no = '$blendNo'
                AND PPD.wip_step = '$oprn'
                and psb.batch_id = ppd.batch_id
                and psb.organization_id = ppd.organization_id
                and psb.inventory_item_id = pmf.product_item_id
                and psb.organization_id = pmf.organization_id
                and pmf.machine_type_code = pMR.MACHINE_TYPE
                and to_char (product_date, 'DD-Mon-YYYY') = '$date'
                and PMr.PM_ENABLE_FLAG = 'Y'
                and pmf.formula_status = 700
                and pmf.recipe_status = 700
            ")
        );

        return $data;
    }

    public function composOnhand($arr,$onhand , $formula)
    {

        $last =  collect($arr)
                ->where('item_number',$formula->item_number)
                ->where('default_lot_no', $onhand->lot_number)
                ->last();


        if ($last == null) {
            return $onhand->onhand_quantity;
        }

        $summaryUseOnhand =  collect($arr)
                            ->where('item_number',$formula->item_number)
                            ->where('default_lot_no', $onhand->lot_number)
                            ->sum('input_quantity_summary');

        return $onhand->onhand_quantity - $summaryUseOnhand;
        // dd($onhand->onhand_quantity - $summaryUseOnhand);
    }

    public function qtyByLot($arr,$onhand , $formula)
    {
        $last =  collect($arr)
                    ->where('item_number',$formula->item_number)
                    ->where('default_lot_no', $onhand->lot_number)
                    ->last();


        if ($last == null) {
            return $onhand->onhand_quantity;
        }

        $summaryUseOnhand =  collect($arr)
                ->where('item_number',$formula->item_number)
                ->where('default_lot_no', $onhand->lot_number)
                ->sum('input_quantity_summary');

        return $summaryUseOnhand;
    }
}
