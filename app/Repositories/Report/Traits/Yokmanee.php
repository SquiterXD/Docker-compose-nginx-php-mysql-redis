<?php

namespace App\Repositories\Report\Traits;

use FormatDate;
use Carbon\Carbon;
use PDF;
use DB;
use PDO;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PD\PtpdPDR0001V;
use App\Models\PD\PtpdPDR0002V;
use App\Exports\PD\PDR1130;
use App\Models\PD\PtpdSimuAdditiveL;
use App\Models\PD\PtpdMixProcess;
use App\Models\PD\PtpdInstruction;
use App\Exports\OM\OMR0073;
use App\Exports\CT\CTR0016;
use App\Exports\CT\TTCTRP72;
use App\Exports\CT\TTCTRP85;
use App\Exports\CT\CTR0034;
use App\Exports\CT\CTR0036;
use App\Models\CT\PtpmStampGL;
use App\Models\CT\PtctCTR0016V;
use App\Models\OM\PtomOMR0073V; 

use App\Models\PM\PtpmPDR1130wip02V;
use App\Models\PM\PtpmPDR1130wip03V;
use App\Models\PM\PtpmPDR1130wip04V;

use App\Models\PM\PtpmPMR1130wip02T;
use App\Models\PM\PtpmPMR1130wip03T;
use App\Models\PM\PtpmPMR1130wip04T;

use App\Models\PP\PtppPPR0004V;
use App\Models\PP\PtppPPR0002HeadersV;
use App\Models\PP\BiweeklyV;
use App\Models\PP\PtppPPR0008V;
use App\Models\PP\PtppPeriodsV;
use App\Models\PP\PtppPPR0009V;
use App\Models\PP\PtppPPR0003V;
use App\Models\PP\PtppPPR0011V;
use App\Models\PP\ItemStampCigarettesV;

// Piyawut 12092022
use App\Models\PP\StampMonthly;
use App\Models\PP\StampDailyV;
use App\Models\PP\PMStampHeader;
use App\Models\PP\PMStampIncomV;
use App\Models\PP\StampSummaryDailyV;
use App\Models\PP\StampFollowSummaryDailyV;
use App\Models\PP\PPStampFollowBalance;

use App\Models\PP\PtppPpr0001YearlyTab1v;
use App\Models\Planning\ProductionYearly\ProductYearlyMain;
use App\Models\Planning\ProductionYearly\ProductYearlyTab3V;
use App\Models\Planning\ProductionYearly\ProductYearlyPlan;
use App\Models\Planning\ProductionYearly\MachineYearlyLinesV;
use App\Models\PP\ProductYearlyTab21V;
use App\Models\PP\ProductYearlyTab22V;
use App\Models\PP\ProductYearlyTab23V;
use App\Models\PP\ProductBiweeklyTab23V;
use App\Models\Lookup\ValueSetup;

use App\Http\Controllers\CT\Reports\CTR0037Controller;

use App\Models\CT\StampAdj;

trait Yokmanee {
    public function PDR0001($programCode, $request) {
    	
		$simuAdd = PtpdPDR0001V::where('simu_formula_no', '>=' , $request->casing_no_from)
					->where('simu_formula_no', '<='  ,$request->casing_no_to)
					->get()
					->groupBy('simu_formula_id');
    	$mixProceses  = PtpdMixProcess::orderBy('mix_no')->get();  
    	$instructions  = PtpdInstruction::orderBy('instruction_no')->get();  
    	

    	$ldate = date('d/m/Y');
    	$time = date('H:i');
		// dd($simuAdd[385], $request->casing_no_from, $request->casing_no_to);
    	

    	//$pdf = PDF::loadView('pd.reports.PDR0001.index', compact('SimuH','SimuL','Mix','Ins','ldate'))
    	$pdf = PDF::loadView('pd.reports.PDR0001.index', compact('simuAdd','ldate','time','mixProceses','instructions'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10);
                   // ->setOption('footer-center', 'Page [page] of [toPage]');

        return $pdf->stream($programCode. '.pdf');

    
    }

    public function PDR0002($programCode, $request) {
    	
		// dd($request,  $request->casing_no_from);
		$simuAdd = PtpdPDR0002V::where('simu_formula_no', '>=' , $request->flavor_no_from)
									->where('simu_formula_no', '<='  ,$request->flavor_no_to)
									->get()
									->groupBy('simu_formula_id');

    	$mixProceses  = PtpdMixProcess::orderBy('mix_no')->get();  
    	$instructions  = PtpdInstruction::orderBy('instruction_no')->get();  
    	

    	$ldate = date('d/m/Y');
    	$time = date('H:i');

		// dd($simuAdd);
    	//$pdf = PDF::loadView('pd.reports.PDR0001.index', compact('SimuH','SimuL','Mix','Ins','ldate'))
    	$pdf = PDF::loadView('pd.reports.PDR0002.index', compact('simuAdd','ldate','time','mixProceses','instructions'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10);
                   // ->setOption('footer-center', 'Page [page] of [toPage]');

        return $pdf->stream($programCode. '.pdf');

    
    }

    public function OMR0073($programCode, $request) {
    	
    	//dd($request->all());
 
    	return \Excel::download(new OMR0073, $programCode.'.xlsx');

    
    }

    public function CTR0016($programCode, $request) {
		
		return \Excel::download(new CTR0016, $programCode.'.xlsx');
    }

	public function PDR1130_BK($programCode, $request) {
		
		$dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        $Sysdate = date('d/m/Y');
    	$time = date('H:i');

        //get format Thai date parameter date----------------------------------
		$strMonthFull=  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
		$strDateThai =date("j",strtotime($dateFrom )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateFrom)))-1];
		$strYearThai =date("Y",strtotime($dateFrom))+543;
		$dateFromTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;

        $strDateThai =date("j",strtotime($dateTo )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateTo)))-1];
		$strYearThai =date("Y",strtotime($dateTo))+543;
		$dateToTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;
        // ----------------------------------------------------------------------
       

        $DATAsWip02  =  PtpmPDR1130wip02V::selectRaw(' batch_no    
                        ,product_group   
                        ,cost_code              
                        ,product_code                       
                        ,product_description                                 
                        ,sum(product_qty02setup)   product_qty02setup                       
                        ,sum(product_qty02)        product_qty02  
                        ,layout_qty  
                        ')
                ->whereBetween('product_date', [$dateFrom, $dateTo])
                ->when($request->cost_code, function($q) use($request){
                    $q->where('cost_code', $request->cost_code);
                })
                ->groupBy('batch_no','product_code','product_description','product_group','layout_qty','cost_code')
				->orderBy('cost_code')
				->orderBy('product_group')
				->orderBy('batch_no')
                ->get();
         // ----------------------------------------------------------------------
        $DATAsWip03  =  PtpmPDR1130wip03V::selectRaw('batch_no
                        ,product_code
                        ,layout_qty
                        ,sum(product_qty03)   product_qty03
                        ,min(product_date) min_date
                        ,max(product_date) max_date
                        ,sum(product_qty03+receive_wip03)   sum_qty03
                        ,sum(loss_qty03)   loss_qty03
                        ,sum(transfer_wip03)   transfer_wip03
                        ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->groupBy('batch_no','product_code','layout_qty')
        ->get();   
      
         $rec03 =  PtpmPDR1130wip03V::selectRaw('batch_no
                                                ,product_code
                                                ,layout_qty
                                                ,receive_wip03
                                                ,product_date
                                                     ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'receive_wip03'
                                ,'product_date')
                                ->get();   

        $tran03 =  PtpmPDR1130wip03V::selectRaw('batch_no
                                ,product_code
                                ,layout_qty
                                ,transfer_wip03
                                ,product_date
                                ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'transfer_wip03'
                                ,'product_date')
                                ->get();   
                      

   
      // ----------------------------------------------------------------------
        $DATAsWip04  =  PtpmPDR1130wip04V::selectRaw('batch_no
                        ,product_code
                        ,layout_qty
                        ,sum(product_qty04)   product_qty04
                        ,min(product_date) min_date
                        ,max(product_date) max_date
                        ,sum(transfer_qty04)   transfer_qty04
                        ,sum(transfer_wip04)   transfer_wip04
                        ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->groupBy('batch_no','product_code','layout_qty')
        ->get();   

        $rec04 =  PtpmPDR1130wip04V::selectRaw('batch_no
                                                ,product_code
                                                ,layout_qty
                                                ,receive_wip04
                                                ,product_date
                                                     ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'receive_wip04'
                                ,'product_date')
                                ->get();   

        $tran04 =  PtpmPDR1130wip04V::selectRaw('batch_no
                                ,product_code
                                ,layout_qty
                                ,transfer_wip04
                                ,product_date
                                ')
                                ->whereBetween('product_date', [$dateFrom, $dateTo])
                                ->groupBy('batch_no'
                                ,'product_code'
                                ,'layout_qty'
                                ,'transfer_wip04'
                                ,'product_date')
                                ->get();   
        
		$pdf = PDF::loadView('pd.reports.PDR1130.index', compact('DATAsWip02','DATAsWip03'
		,'DATAsWip04','Sysdate','time'
		,'dateFromTH','dateToTH',
		'rec03','tran03',
		'rec04','tran04'))

                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    
    }

    public function PDR1130_xx($programCode, $request) 
    {
        $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $Sysdate = date('d/m/Y');
    	$time = date('H:i');

        //get format Thai date parameter date----------------------------------
		$strMonthFull=  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
		$strDateThai =date("j",strtotime($dateFrom )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateFrom)))-1];
		$strYearThai =date("Y",strtotime($dateFrom))+543;
		$dateFromTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;

        $strDateThai =date("j",strtotime($dateTo )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateTo)))-1];
		$strYearThai =date("Y",strtotime($dateTo))+543;
		$dateToTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;
      
       
      
        $orderByInfo = collect(\DB::select("
            SELECT meaning 
            FROM FND_LOOKUP_VALUES
            WHERE LOOKUP_TYPE = 'PTPM_PDR1130_SEQUENCE'
            and lookup_code  = '{$request->order_by}'
        ")); 
        $orderHeader=$orderByInfo[0]->meaning ; 

        //-------------Get Header Data----------------------------
        $Wip02  =  PtpmPDR1130wip02V::selectRaw('batch_no,
        product_code,
        product_description,
        product_group
                ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->when($request->cost_code, function($q) use($request){
            $q->where('cost_code', $request->cost_code);
        });

        $Wip03  =  PtpmPDR1130wip03V::selectRaw('batch_no,
        product_code,
        product_description
        ,product_group
                 ')
        ->whereBetween('product_date', [$dateFrom, $dateTo])
        ->when($request->cost_code, function($q) use($request){
            $q->where('cost_code', $request->cost_code);
        })
        ->union($Wip02);

        if($request->order_by == 1) {
            $DataHeads  =  PtpmPDR1130wip04V::selectRaw('batch_no,
            product_code,
            product_description
            ,product_group
                    ')
            ->whereBetween('product_date', [$dateFrom, $dateTo])
            ->when($request->cost_code, function($q) use($request){
                $q->where('cost_code', $request->cost_code);
            })
            ->union($Wip03)
            ->orderBy('product_group')
            ->orderBy('product_code')
            ->orderBy('batch_no')
            ->get()
            ;
            
        } else {
                //cost
            $DataHeads  =  PtpmPDR1130wip04V::selectRaw('batch_no,
            product_code,
            product_description
            ,product_group
                    ')
            ->whereBetween('product_date', [$dateFrom, $dateTo])
            ->when($request->cost_code, function($q) use($request){
                $q->where('cost_code', $request->cost_code);
            })
            ->union($Wip03)
            ->orderBy('product_group')
            ->orderBy('product_code')
            ->get()
            ;
            
        }

       

        //---------------------------------------------------------WIP02
        $DATAsWip02  =  PtpmPDR1130wip02V::selectRaw('batch_no    
                        ,product_group   
                        ,cost_code              
                        ,product_code                       
                        ,product_description                                 
                        ,sum(product_qty02setup)   product_qty02setup                       
                        ,layout_qty  
                   ')
                ->whereBetween('product_date', [$dateFrom, $dateTo])
                ->when($request->cost_code, function($q) use($request){
                    $q->where('cost_code', $request->cost_code);
                })
                ->groupBy('batch_no','product_code','product_description','product_group','layout_qty','cost_code')
				->orderBy('cost_code')
				->orderBy('product_group')
				->orderBy('batch_no')
                ->get();
                
                $productQty02Layout = $DATAsWip02->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('product_qty02setup', 'product_code')->all()];
                    })->toArray();

               
                $LayoutQty02 = $DATAsWip02->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                    })->toArray();
        
         //---------------------------------------------------------WIP03
                $DATAsWip03  =  PtpmPDR1130wip03V::selectRaw('batch_no
                ,product_code
                ,sum(product_qty03)   product_qty03
                ,sum(loss_qty03)   loss_qty03
                ,layout_qty  
                ')
                    ->whereBetween('product_date', [$dateFrom, $dateTo])
                    ->when($request->cost_code, function($q) use($request){
                        $q->where('cost_code', $request->cost_code);
                    })
                    ->groupBy('batch_no','product_code','layout_qty')
                    ->get();  
                  
                   
                   
                $productQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('product_qty03', 'product_code')->all()];
                    })->toArray();
                $lossQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('loss_qty03', 'product_code')->all()];
                    })->toArray();
            
                   
                $LayoutQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                    })->toArray();


                    $rec03 = collect(\DB::select("select batch_no
                    ,product_code
                    ,receive_wip03
                    ,product_date
                       from  ptpm_pdr1130_wip03_v t
                       where 1=1
                       and product_date in (
                                                select min(product_date) 
                                                from ptpm_product_header
                                                where  batch_no =  t.batch_no
                                                and attribute10 = t.product_code
                                                and wip_step='WIP03'
                                                and product_date  >= '{$dateFrom}'

                                            )
                   "));  

          
                    $tran03 = collect(\DB::select("select batch_no
                    ,product_code
                    ,transfer_wip03
                    ,product_date
                       from  ptpm_pdr1130_wip03_v t
                       where 1=1
                       and product_date in (
                                                select max(product_date) 
                                                from ptpm_product_header
                                                where  batch_no =  t.batch_no
                                                and attribute10 = t.product_code
                                                and wip_step='WIP03'
                                                and product_date  <= '{$dateTo}'
                    
                                            )
                   "));  
                 
                    $rec03Receive = $rec03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                        $groupName = $item->first()->batch_no;
                        return [$groupName => $item->pluck('receive_wip03', 'product_code')->all()];
                        })->toArray();
                    
                    $tran03Tranfer = $tran03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                        $groupName = $item->first()->batch_no;
                        return [$groupName => $item->pluck('transfer_wip03', 'product_code')->all()];
                        })->toArray();
            //-------------------------------------------------------------WIP04
                    
                    $DATAsWip04  =  PtpmPDR1130wip04V::selectRaw('batch_no
                        ,product_code
                        ,sum(product_qty04)   product_qty04
                        ,sum(transfer_qty04)   transfer_qty04
                        ,layout_qty
                        ')
                        ->whereBetween('product_date', [$dateFrom, $dateTo])
                        ->when($request->cost_code, function($q) use($request){
                            $q->where('cost_code', $request->cost_code);
                        })
                        ->groupBy('batch_no','product_code','layout_qty')
                        ->get();  
                      
                    
                        $productQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('product_qty04', 'product_code')->all()];
                            })->toArray();

                        $TranferQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('transfer_qty04', 'product_code')->all()];
                            })->toArray();

                        $LayoutQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                            })->toArray();

                        
                         $rec04 = collect(\DB::select("select batch_no
                         ,product_code
                         ,receive_wip04
                         ,product_date
                            from  ptpm_pdr1130_wip04_v t
                            where 1=1
                            and product_date in (
                                                     select min(product_date) 
                                                     from ptpm_product_header
                                                     where  batch_no =  t.batch_no
                                                     and attribute10 = t.product_code
                                                     and wip_step='WIP04'
                                                     and product_date  >= '{$dateFrom}'
                                                                
                                            ) 
                        "));  


                    $tran04 = collect(\DB::select("select batch_no
                    ,product_code
                    ,transfer_wip04
                    ,product_date
                       from  ptpm_pdr1130_wip04_v t
                       where 1=1
                       and product_date in (
                                                select max(product_date) 
                                                from ptpm_product_header
                                                where  batch_no =  t.batch_no
                                                and attribute10 = t.product_code
                                                and wip_step='WIP04'
                                                and product_date  <= '{$dateTo}'
                    
                                            )
                   "));  
             
                    $rec04Receive = $rec04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                        $groupName = $item->first()->batch_no;
                        return [$groupName => $item->pluck('receive_wip04', 'product_code')->all()];
                        })->toArray();
                     
                    $tran04Tranfer = $tran04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                        $groupName = $item->first()->batch_no;
                        return [$groupName => $item->pluck('transfer_wip04', 'product_code')->all()];
                        })->toArray();

     
                // self::showNumber(790.99);

                
                if($request->order_by == 1) {
                               

                $pdf = PDF::loadView('pd.reports.PDR1130.pm',compact('DataHeads','dateFromTH','dateToTH',
                'productQty02Layout','LayoutQty02','LayoutQty03','LayoutQty04','productQty03','rec03Receive','tran03Tranfer',
                'productQty04','TranferQty04','rec04Receive','tran04Tranfer','lossQty03','orderHeader'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 10)
                            ;
                    
                } else {
        
                            
                $pdf = PDF::loadView('pd.reports.PDR1130.ct',compact('DataHeads','dateFromTH','dateToTH',
                'productQty02Layout','LayoutQty02','LayoutQty03','LayoutQty04','productQty03','rec03Receive','tran03Tranfer',
                'productQty04','TranferQty04','rec04Receive','tran04Tranfer','lossQty03','orderHeader'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 10);
                            
                        }

        return $pdf->stream($programCode. '.pdf');

    
    }

    public function PDR1130($programCode, $request) {

        $dateFrom = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $Sysdate = date('d/m/Y');
    	$time = date('H:i');

        //get format Thai date parameter date----------------------------------
		$strMonthFull=  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
		$strDateThai =date("j",strtotime($dateFrom )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateFrom)))-1];
		$strYearThai =date("Y",strtotime($dateFrom))+543;
		$dateFromTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;

        $strDateThai =date("j",strtotime($dateTo )) ;
		$strMonthThai=$strMonthFull[date( date("n",strtotime($dateTo)))-1];
		$strYearThai =date("Y",strtotime($dateTo))+543;
		$dateToTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;
        
        $Batch_no =  date('d/m/Y H:i:s');
        $cost_code = $request->cost_code ?? null;
        $orderByInfo = collect(\DB::select("
        SELECT meaning 
        FROM FND_LOOKUP_VALUES
        WHERE LOOKUP_TYPE = 'PTPM_PDR1130_SEQUENCE'
        and lookup_code  = '{$request->order_by}'
            ")); $orderHeader=$orderByInfo[0]->meaning ; 

        //----------------------------------------------------------------------------------------
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    o_cnt_trans             number ;
                    v_debug                 NUMBER :=1;
                    
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                   

                    ptpm_pmr1130_rpt.MAIN(  ERRBUF                   =>  :P_RETURN_MESSAGE
                                            ,RETCODE                  => :P_RETURN_STATUS
                                            ,I_DATE_FROM              => '{$request->date_from}'  
                                            ,I_DATE_TO                => '{$request->date_to}'  
                                            ,I_COST_CODE              => '{$cost_code}'
                                            ,batch_web_no             => '{$Batch_no}' );

                    
                    dbms_output.put_line('OUTPUT :'|| :P_RETURN_STATUS 
                                        ||' MSG :'||  :P_RETURN_MESSAGE  );
                                                
                    
                    dbms_output.put_line('---------------------  E N D. -------------------');
                    EXCEPTION WHEN others THEN 
                        dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                    END ;
                ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);
      

        //-------------Get Header Data----------------------------
        $Wip02  =  PtpmPMR1130wip02T::selectRaw('batch_no,
        product_code,
        product_description,
        product_group,
        cost_code
                ')
        ->where('batch_web_no', $Batch_no)
        ;

        $Wip03  =  PtpmPMR1130wip03T::selectRaw('batch_no,
        product_code,
        product_description
        ,product_group
        ,cost_code
                 ')
        ->where('batch_web_no', $Batch_no)
        ->union($Wip02);

        if($request->order_by == 1) {
            $DataHeads  =  PtpmPMR1130wip04T::selectRaw('batch_no,
            product_code,
            product_description
            ,product_group
            ,cost_code
                    ')
            ->where('batch_web_no', $Batch_no)
            ->union($Wip03)
            ->orderBy('product_group')
            ->orderBy('product_code')
            ->orderBy('batch_no')
            ->get()
            ;
            
        } else {

            $DataHeads  =  PtpmPMR1130wip04T::selectRaw('batch_no,
            product_code,
            product_description
            ,product_group
            ,cost_code
                    ')
            ->where('batch_web_no', $Batch_no)
            ->union($Wip03)
            ->orderBy('cost_code')
            ->orderBy('product_group')
            ->orderBy('product_code')
            ->get()
            ;
            
        }

        //---------------------------------------------------------WIP02
        $DATAsWip02  =  PtpmPMR1130wip02T::selectRaw('batch_no    
                        ,product_group   
                        ,cost_code              
                        ,product_code                       
                        ,product_description                                 
                        ,product_qty02_setup                   
                        ,layout_qty  
                   ')
                ->where('batch_web_no', $Batch_no)
                ->get();
                
                $productQty02Layout = $DATAsWip02->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('product_qty02_setup', 'product_code')->all()];
                    })->toArray();

               
                $LayoutQty02 = $DATAsWip02->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                    })->toArray();
        
         //---------------------------------------------------------WIP03
                $DATAsWip03  =  PtpmPMR1130wip03T::selectRaw('batch_no
                ,product_code
                ,product_qty03
                ,loss_qty03  
                ,receive_wip03
                ,transfer_wip03
                ,layout_qty
                ')
                ->where('batch_web_no', $Batch_no)
                ->get();  
                  
                $productQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('product_qty03', 'product_code')->all()];
                    })->toArray();
                $lossQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('loss_qty03', 'product_code')->all()];
                    })->toArray();
                $rec03Receive = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('receive_wip03', 'product_code')->all()];
                    })->toArray();
                $tran03Tranfer = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('transfer_wip03', 'product_code')->all()];
                    })->toArray();
                $LayoutQty03 = $DATAsWip03->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                    $groupName = $item->first()->batch_no;
                    return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                    })->toArray();
                 
                 
            //-------------------------------------------------------------WIP04
                    
                    $DATAsWip04  =  PtpmPMR1130wip04T::selectRaw('batch_no
                        ,product_code
                        ,receive_wip04  
                        ,product_qty04
                        ,transfer_qty04
                        ,transfer_wip04
                        ,layout_qty
                        ')
                        ->where('batch_web_no', $Batch_no)
                        ->get();  
                      
                    
                        $productQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('product_qty04', 'product_code')->all()];
                            })->toArray();

                        $TranferQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('transfer_qty04', 'product_code')->all()];
                            })->toArray();

                        $rec04Receive = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('receive_wip04', 'product_code')->all()];
                            })->toArray();

                        $tran04Tranfer = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('transfer_wip04', 'product_code')->all()];
                            })->toArray();

                        $LayoutQty04 = $DATAsWip04->groupBy('batch_no')->mapWithKeys(function ($item, $group) {
                            $groupName = $item->first()->batch_no;
                            return [$groupName => $item->pluck('layout_qty', 'product_code')->all()];
                            })->toArray();
                
                if($request->order_by == 1) {
                               

                $pdf = PDF::loadView('pd.reports.PDR1130.pm',compact('DataHeads','dateFromTH','dateToTH',
                'productQty02Layout','LayoutQty02','LayoutQty03','LayoutQty04','productQty03','rec03Receive','tran03Tranfer',
                'productQty04','TranferQty04','rec04Receive','tran04Tranfer','lossQty03','orderHeader'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 5)
                            ;
                    
                } else {
        
                            
                $pdf = PDF::loadView('pd.reports.PDR1130.ct',compact('DataHeads','dateFromTH','dateToTH',
                'productQty02Layout','LayoutQty02','LayoutQty03','LayoutQty04','productQty03','rec03Receive','tran03Tranfer',
                'productQty04','TranferQty04','rec04Receive','tran04Tranfer','lossQty03','orderHeader'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 5);
                            
                        }

        return $pdf->stream($programCode. '.pdf');

    
    }
    public function TTCTRP72($programCode, $request) {
        // dd($request->all());
		return \Excel::download(new TTCTRP72, $programCode.'.xlsx');
    }

    public function PPR0002($programCode, $request)
    {
        $biweekly = BiweeklyV::where('period_year', $request->year)
                            ->where('period_num', $request->month)
                            ->where('biweekly', $request->biweekly)
                            ->first();

        $WorkHour  =  PtppPPR0002HeadersV::selectRaw('distinct working_hour  working_hour')
                                        ->where('biweekly_id', $biweekly->biweekly_id)
                                        ->where('lookup_code', $request ->product_type)
                                        ->orderByRaw('to_number(working_hour)')
                                        ->get();
        //-----------------------------------------------------------------------------------------------
        $Data  =  PtppPPR0002HeadersV::where('biweekly_id', $biweekly->biweekly_id)
                                    ->where('lookup_code', $request->product_type)
                                    ->where('version_no', $request->version_no)
                                    ->orderByRaw('cast(machine_group as int) asc')
                                    ->get();
        $headReport = $Data->first();

        $WorkingHour = $Data->groupBy('machine_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_name;
            return [$groupName => $item->pluck('working_hour1', 'working_hour')->all()];
        })->toArray();

        $Efficiency = $Data->groupBy('machine_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_name;
            return [$groupName => $item->pluck('production_capacity', 'working_hour')->all()];
        })->toArray();

        $TotalDays = $Data->groupBy('machine_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_name;
            return [$groupName => $item->pluck('total_days', 'working_hour')->all()];
        })->toArray();

        $DatasHead  =  PtppPPR0002HeadersV::selectRaw('distinct biweekly
                            ,biweekly_id
                            ,period_year
                            ,period_year_thai
                            ,version_no
                            ,meaning
                            ,product_main_id
                            ,approved_status
                            ,machine_group_desc
                            ,machine_group
                            ,machine_name
                            ,machine_description
                            ,machine_speed
                            ,machine_eamperformance
                            ,total_efficiency_product'
                        )
                        ->where('biweekly_id', $biweekly->biweekly_id)
                        ->where('lookup_code', $request->product_type)
                        ->where('version_no', $request->version_no)
                        ->orderByRaw('cast(machine_group as int) asc, machine_name')
                        ->get()
                        ->groupBy('machine_group_desc');

    	$pdf = PDF::loadView('pp.reports.PPR0002.index',compact('DatasHead','WorkHour', 'programCode', 'WorkingHour', 'Efficiency', 'TotalDays','headReport'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }

    public function PPR0008($programCode, $request)
    {
        $Sysdate = date('d/m/Y');
    	$time = date('H:i');
        $version = $request->version_no;
        $planDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->plan_date)->format('Y-m-d');
        //get format Thai date parameter date----------------------------------
        $strMonthFull=  ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $strDateThai =date("j",strtotime($planDate )) ;
        $strMonthThai=$strMonthFull[date( date("n",strtotime($planDate)))-1];
        $strYearThai =date("Y",strtotime($planDate))+543;
        $planDateTH = $strDateThai . ' ' . $strMonthThai . ' ' . $strYearThai;

        $datas = PtppPPR0008V::where('period_year', $request->period_year)
                                ->where('period_name', $request->period_name)
                                ->where('version_no', $request->version_no)
                                // ->where('plan_date', $planDate)
                                ->orderBy('stamp_code','desc')
                                ->orderBy('type_stamp')
                                ->get()
                                ->groupBy('stamp_description');

        $headersRpt  =  PtppPeriodsV::selectRaw('period_year_thai,thai_month')
                            ->where('period_name', $request->period_name)
                            ->get();
 
    	$pdf = PDF::loadView('pp.reports.PPR0008.index', compact('datas','Sysdate', 'time','planDateTH', 'headersRpt','version'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }

    public function PPR0009($programCode, $request)
    {
        $Sysdate = date('d/m/Y');
    	$time = date('H:i');
        $cigarettes = PtppPPR0009V::selectRaw('distinct cigarettes_description ,cigarettes_code')
                                    ->where('period_name', $request->period_name)
                                    ->where('period_year', $request->period_year)
                                    ->where('version_no', $request->version)
                                    ->where('stamp_code', $request->stamp_group)
                                    ->orderBy('cigarettes_code')
                                    ->get();

        $cnt_ciga = PtppPPR0009V::selectRaw('count(distinct cigarettes_description) cnt_cig')
                                ->where('period_name', $request->period_name)
                                ->where('period_year', $request->period_year)
                                ->where('version_no', $request->version)
                                ->where('stamp_code', $request->stamp_group)
                                ->get();

        $cnt_cig = 100/($cnt_ciga[0]->cnt_cig + 2);
        $dataQuery = PtppPPR0009V::where('period_name', $request->period_name)
                                    ->where('period_year', $request->period_year)
                                    ->where('version_no', $request->version)
                                    ->where('stamp_code', $request->stamp_group)
                                    ->orderBy('plan_date')
                                    ->get();

        $headReport = $dataQuery->first();
        $stampQty = $dataQuery->groupBy('plan_date_text')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->plan_date_text;
            return [$groupName => $item->pluck('weekly_receive_qty', 'cigarettes_description')->all()];
        })->toArray();

        $sumQtyLvCiga = $dataQuery->groupBy('cigarettes_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_description;
            return [$groupName => $item->pluck('sum_qty_lv_ciga', 'cigarettes_description')->all()];
        })->toArray();

        $dataHeads  =  PtppPPR0009V::selectRaw('thai_month
                                                ,period_name
                                                ,period_year_thai
                                                ,version_no
                                                ,plan_date_text
                                                ,stamp_code
                                                ,stamp_description
                                                ,cigarettes_code
                                                ,cigarettes_description
                                                ,weekly_receive_qty
                                                ,sum_qty_lv_date
                                                ,short_format_thai
                                                ,sum_rpt'
                                            )
                                            ->where('period_name', $request->period_name)
                                            ->where('period_year', $request->period_year)
                                            ->where('version_no', $request->version)
                                            ->where('stamp_code', $request->stamp_group)
                                            ->orderBy('plan_date')
                                            ->get()
                                            ->groupBy('plan_date_text');

    	$pdf = PDF::loadView('pp.reports.PPR0009.index',compact('Sysdate','time'
                                                                ,'cigarettes','cnt_cig','dataQuery'
                                                                ,'stampQty','dataHeads','headReport','sumQtyLvCiga'))
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }

    public function PPR0003($programCode, $request)
    {
        $Sysdate = date('d/m/Y');
        $time = date('H:i');
        $biweeklyHead = PtppPPR0003V::selectRaw('distinct p_biweekly,thai_combine_date,curr_sale_days')
                                ->where('period_year',$request->period_year)
                                ->where('period_num',$request->month)
                                ->where('version_no',$request->version_no)
                                ->where('product_type',$request->product_type)
                                ->where('biweekly',$request->weekly)
                                ->orderBy('p_biweekly')
                                ->get();

        $cnt_weekly = PtppPPR0003V::selectRaw('count(distinct p_biweekly) cnt_week')
                                ->where('period_year',$request->period_year)
                                ->where('period_num',$request->month)
                                ->where('version_no',$request->version_no)
                                ->where('product_type',$request->product_type)
                                ->where('biweekly',$request->weekly)
                                ->get();

        $dataHeads = PtppPPR0003V::where('period_year',$request->period_year)
                                ->where('version_no',$request->version_no)
                                ->where('product_type',$request->product_type)
                                ->where('biweekly',$request->weekly)
                                ->orderBy('item_description')
                                ->get()
                                ->groupBy('item_description');

        $dataQuery = PtppPPR0003V::where('period_year', $request->period_year)
                                ->where('version_no', $request->version_no)
                                ->where('product_type', $request->product_type)
                                ->where('biweekly', $request->weekly)
                                ->orderBy('item_description')
                                ->get();

        $cnt_week = 100/($cnt_weekly[0]->cnt_week + 1);
        $headReport = $dataQuery->first();
        $CURR_ONHNAD_QTY = $dataQuery->groupBy('item_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_description;
            return [$groupName => $item->pluck('curr_onhnad_qty', 'p_biweekly')->all()];
        })->toArray();

        $PLANNING_QTY = $dataQuery->groupBy('item_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_description;
            return [$groupName => $item->pluck('planning_qty', 'p_biweekly')->all()];
        })->toArray();

        $FORCAST_QTY = $dataQuery->groupBy('item_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_description;
            return [$groupName => $item->pluck('forcast_qty', 'p_biweekly')->all()];
        })->toArray();

        $BAL_ONHAND_QTY = $dataQuery->groupBy('item_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_description;
            return [$groupName => $item->pluck('bal_onhand_qty', 'p_biweekly')->all()];
        })->toArray();

        $ENDING_SALE_DAY = $dataQuery->groupBy('item_description')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_description;
            return [$groupName => $item->pluck('ending_sale_day', 'p_biweekly')->all()];
        })->toArray();

        // ---------------sum
        $SUM_CURR_ONHNAD_QTY = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('sum_curr_onhnad_qty', 'p_biweekly')->all()];
        })->toArray();

        $SUM_PLANNING_QTY = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('sum_planing_qty', 'p_biweekly')->all()];
        })->toArray();

        $SUM_FORCAST_QTY = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('sum_forcast_qty', 'p_biweekly')->all()];
        })->toArray();

        $SUM_BAL_ONHAND_QTY = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('sum_bal_onhand_qty', 'p_biweekly')->all()];
        })->toArray();

        $SUM_ENDING_SALE_DAY = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('sum_ending_sale_day', 'p_biweekly')->all()];
        })->toArray();

        // ---------------------
        $total_wk_overtime_d = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('total_wk_overtime_d', 'p_biweekly')->all()];
        })->toArray();
    
        $efficiency_product_d = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('efficiency_product_d', 'p_biweekly')->all()];
        })->toArray();

        $total_wk_overtime_n = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('total_wk_overtime_n', 'p_biweekly')->all()];
        })->toArray();

        $efficiency_product_n = $dataQuery->groupBy('p_biweekly')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->p_biweekly;
            return [$groupName => $item->pluck('efficiency_product_n', 'p_biweekly')->all()];
        })->toArray();

       $pdf = PDF::loadView('pp.reports.PPR0003.index',compact('biweeklyHead','cnt_week','dataHeads'
       ,'CURR_ONHNAD_QTY','PLANNING_QTY','FORCAST_QTY','BAL_ONHAND_QTY','ENDING_SALE_DAY','headReport'
       ,'total_wk_overtime_d','efficiency_product_d','total_wk_overtime_n','efficiency_product_n'
       ,'SUM_CURR_ONHNAD_QTY','SUM_PLANNING_QTY','SUM_FORCAST_QTY','SUM_BAL_ONHAND_QTY','SUM_ENDING_SALE_DAY'))
               ->setPaper('a4')
               ->setOrientation('landscape')
               ->setOption('margin-bottom', 10);

       return $pdf->stream($programCode. '.pdf');
    }

   // Piyawut 12092022
    public function PPR0005($programCode, $request)
    {
        $biweekly = BiweeklyV::where('period_num', $request->month)
                            ->where('period_year', $request->budget_year)
                            ->first();

        $stampMonthly = StampMonthly::where('period_name', $biweekly->period_name)
                                    ->where('version_no', $request->version_no)
                                    ->first();
        $stampItems = [];
        if ($stampMonthly) {
            $stampItems = StampSummaryDailyV::where('monthly_id', $stampMonthly->monthly_id)
                                        ->where('stamp_code', $request->stamp_code)
                                        ->orderBy('plan_date')
                                        ->get();
        }

        $fileName = 'ประมาณการใช้แสตมป์รายเดือน_'. date('Ymdhms');
        $contentHtml = view('pp.reports.PPR0005.index', compact('stampMonthly', 'stampItems', 'biweekly', 'programCode'))->render();

        return \PDF::loadHtml($contentHtml)->stream($fileName.'.pdf');
    }

    public function PPR0006($programCode, $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $biweekly = BiweeklyV::whereRaw("to_date('{$date}', 'YYYY-MM-DD') BETWEEN START_DATE AND END_DATE")->first();
        $stampMonthly = StampMonthly::where('period_name', $biweekly->period_name)
                                    ->where('version_no', $request->version_no)
                                    ->first();
        $stampItems = StampSummaryDailyV::where('monthly_id', $stampMonthly->monthly_id)
                                    ->where('stamp_code', $request->stamp_code)
                                    ->whereRaw("trunc(plan_date) = to_date('{$date}', 'YYYY-MM-DD')")
                                    ->orderBy('plan_date')
                                    ->get();
        $setupStamp = StampAdj::where('stamp_type', 10)->get();

        $setupStamp = $setupStamp->groupBy('stamp_adj_id')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->stamp_adj_id;
            return [$groupName => $item->pluck('fund')->all()];
        })->toArray();

        $itemCigars = ItemStampCigarettesV::where('stamp_number', $request->stamp_code)->orderBy('cigarettes_number')->get();
        $items = $itemCigars->pluck('cigarettes_description')->toArray();
        $items = implode(', ', $items);

        $fileName = 'ใบแจ้งรายการสั่งซื้อแสตมป์แยกตามกลุ่มราคา_'. date('Ymdhms');
        $contentHtml = view('pp.reports.PPR0006.index', compact('stampMonthly', 'stampItems', 'biweekly', 'programCode', 'items', 'setupStamp'))->render();

        return \PDF::loadHtml($contentHtml)->stream($fileName.'.pdf');
    }
 
    public function PPR0001($programCode, $request)
    {
        $Sysdate = date('d/m/Y');
        $time = date('H:i');
        $main = ProductYearlyMain::where('period_year',$request->period_year)
        ->where('version_no',$request->version_no)
        ->get(); 

        $periods = PtppPeriodsV::where('period_year', $request->period_year)->orderBy('period_num')->get();
        $periods = $periods->pluck('thai_month_arr', 'period_no');
        $tab3 = ProductYearlyTab3V::where('yearly_main_id', $main[0]->yearly_main_id)
        ->where('product_type','78')
        ->orderBy('period_no', 'asc')
        ->get();

        $estimateYearlies = $tab3->groupBy('col_description')->mapWithKeys(function ($item) {
            $groupName = $item->first()->col_description;
            return [$groupName => $item->pluck('col_qty', 'period_no')->all()];
        })->toArray();

        $tab22 = ProductYearlyTab22V::selectRaw('distinct product_type 
        ,sum(forcast_qty) over (partition by product_type )         forcast_qty71
        ,sum(planning_qty) over (partition by product_type )        planning_qty71
        ,sum(forcast_qty) over (partition by yearly_main_id )       sum_forcast_qty
        ,sum(planning_qty) over (partition by yearly_main_id )      sum_planning_qty')
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->orderBy('product_type')
        ->get()
        ->where('product_type','71');

        //--------------layout2
        $tab1Yearly = PtppPpr0001YearlyTab1v::selectRaw('distinct product_type
                    ,meaning
                    ,machine_group_name
                    ,machine_group_desc
                    ,efficiency_product
                    ')
                    ->where('yearly_main_id', $main[0]->yearly_main_id)
                    ->orderBy('product_type')
                    ->get()
                    ->groupBy('meaning');

        $WorkHour  =  PtppPpr0001YearlyTab1v::selectRaw('distinct working_hour  working_hour')
                    ->where('yearly_main_id', $main[0]->yearly_main_id)
                    ->whereNotNull('working_hour')
                    ->orderByRaw('to_number(working_hour)')
                    ->get();
        $WorkHourOt  =  PtppPpr0001YearlyTab1v::selectRaw('distinct working_hour-9  working_hour_ot
        ,working_hour')
                    ->where('yearly_main_id', $main[0]->yearly_main_id)
                    ->whereNotNull('working_hour')
                    ->whereRaw('working_hour - 9 > 0')
                    ->orderByRaw('working_hour-9')
                    ->get();

        $datas1 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNotNull('working_hour')
        ->where('p02_ordy',1)
        ->get();
        $datas2 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNotNull('working_hour')
        ->where('p02_ordy',2)
        ->get();
        $datas3 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNotNull('working_hour')
        ->whereRaw('working_hour - 9 > 0')
        ->where('p02_ordy',3)
        ->get();

        $datas5 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->where('p02_ordy',5)
        ->get();
        $datas6 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->where('p02_ordy',6)
        ->get();
        $datas7 = PtppPpr0001YearlyTab1v::where('yearly_main_id', $main[0]->yearly_main_id)
        ->where('p02_ordy',7)
        ->get();
       
        $productionCapacity = $datas1->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group_name;
            return [$groupName => $item->pluck('production_capacity', 'working_hour')->all()];
            })->toArray(); 

        $efficiencyProduct = $datas2->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group_name;
            return [$groupName => $item->pluck('efficiency_product_t1', 'working_hour')->all()];
            })->toArray();

        $totalOtProduct = $datas3->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
                $groupName = $item->first()->machine_group_name;
                return [$groupName => $item->pluck('total_ot_product', 'working_hour')->all()];
                })->toArray();
             

        $PmEfficiency = $datas5->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group_name;
            return [$groupName => $item->pluck('pm_efficiency_product', 'machine_group_name')->all()];
            })->toArray();

        $DtEfficiency = $datas6->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group_name;
            return [$groupName => $item->pluck('dt_efficiency_product', 'machine_group_name')->all()];
            })->toArray();

        $TotalEfficiencyProduct = $datas7->groupBy('machine_group_name')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->machine_group_name;
            return [$groupName => $item->pluck('total_efficiency_product', 'machine_group_name')->all()];
            })->toArray();

        //--------------layout3

        $machineYearly = MachineYearlyLinesV::selectRaw('period_name,product_type_name,product_type
        , sum(eam_dt_eff_product) dt_eff_product
        , sum(eam_pm_eff_product) pm_eff_product')
        ->where('period_year',$request->period_year)
        ->groupBy('period_name','product_type_name','product_type')
        ->orderBy('product_type')
        ->get()
        ->groupBy('product_type_name');
    
       

        $months = PtppPeriodsV::selectRaw('period_name, period_num, period_year_thai, short_format_thai')
        ->where('period_year',$request->period_year )
        ->orderBy('period_num')
        ->get();

        $monthlists  = $months->pluck('short_format_thai', 'period_name')->all();
    
         
        $machineDt = $machineYearly->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->product_type_name;
            return [$groupName => $item->pluck('dt_eff_product', 'period_name')->all()];
            })->toArray();

        $machinePm = $machineYearly->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->product_type_name;
            return [$groupName => $item->pluck('pm_eff_product', 'period_name')->all()];
            })->toArray();
   
        //--------------layout4
        $YearlyTab21 = ProductYearlyTab21V::selectRaw("product_type,period_name
        ,period_no
        ,working_hour
        ,nvl(total_days,0)  total_days
        ,product_type_desc
        ,period_name||'|'||working_hour period")
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNotNull('working_hour')
        ->groupBy('period_name','product_type_desc','working_hour','total_days', 'period_no','product_type')
        ->orderBy('product_type')
        ->orderBy('period_no')
        ->orderBy('working_hour')
        ->get()
        ->groupBy('product_type_desc')
        ;

        $totalWkh = ProductYearlyTab21V::selectRaw('working_hour_normal
        ,pm_efficiency_product
        ,total_ot_hour
        ,period_name
        ,product_type_desc
        ,period_no
        ,working_hour_normal+pm_efficiency_product+total_ot_hour sum_wkh')
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNull('working_hour')
        ->orderBy('product_type')
        ->orderBy('period_no')
        ->get();

        
        $cnt_working_hour = ProductYearlyTab21V::selectRaw('count( distinct working_hour) OVER(PARTITION BY yearly_main_id)  cnt_working_hour 
        ,working_hour')
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->whereNotNull('working_hour')
        ->groupBy('working_hour','yearly_main_id')
        ->get();  
         $cntWorkHour = $cnt_working_hour[0]->cnt_working_hour;
        
        $totalDays = $YearlyTab21->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('total_days', 'period')->all()];
        })->toArray();

        $totalWkhNormal = $totalWkh->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('working_hour_normal', 'period_name')->all()];
        })->toArray();

        $totalPm = $totalWkh->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('pm_efficiency_product', 'period_name')->all()];
        })->toArray();
    
        $totalOt = $totalWkh->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('total_ot_hour', 'period_name')->all()];
        })->toArray();

        $sumWkh= $totalWkh->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('sum_wkh', 'period_name')->all()];
        })->toArray();

        //--------------layout5 
        // 7.1,7.4,kk
        $tab23Union = ProductYearlyTab23V::selectRaw(' distinct product_type
        ,product_type_desc
        ,item_description
        ,count(distinct item_description) over (partition by product_type )-1 cnt_item 
        ')
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->orderBy('product_type')
        ->get()
        ->groupBy('product_type_desc');

        $dataHeads = ProductYearlyTab22V::selectRaw(' distinct product_type
        ,product_type_desc
        ,item_description
        ,count(distinct item_description) over (partition by product_type )-1 cnt_item 
        ')
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->orderBy('product_type')
        ->get()
        ->groupBy('product_type_desc')
        ->union($tab23Union);

        

        $dataLines23 = ProductYearlyTab23V::selectRaw("period_name
        ,period_no
        ,item_description
        ,estimate_product   total_efficiency_product
        ,product_type
        ,product_type_desc
        ,period_name||'|'||item_description  period
        ,sum(estimate_product)  over (partition by period_no,product_type )  sumbypro
        ")
        ->where('yearly_main_id', $main[0]->yearly_main_id)
         ;

        $dataLines = ProductYearlyTab22V::selectRaw("period_name
        ,period_no
        ,item_description
        ,total_efficiency_product
        ,product_type
        ,product_type_desc
        ,period_name||'|'||item_description  period
        ,sum(total_efficiency_product)  over (partition by period_no,product_type )  sumbypro
        ")
        ->where('yearly_main_id', $main[0]->yearly_main_id)
        ->union($dataLines23)
        ->get();

            $sumByMonth = collect(\DB::select("
            select 
            period_name
            ,sum(sumbymonth)  sumbymonth
            ,yearly_main_id
            from
            (
            select 
            sum( total_efficiency_product)  over (partition by period_no )  sumbymonth 
            ,period_name
            ,yearly_main_id
            from PTPP_PRODUCT_YEARLY_TAB22_V
            where yearly_main_id='{$main[0]->yearly_main_id}'

            union

            select 
            sum( estimate_product)  over (partition by period_no )  sumbymonth 
            ,period_name
            ,yearly_main_id
            from PTPP_PRODUCT_YEARLY_TAB23_V
            where yearly_main_id='{$main[0]->yearly_main_id}'

            )
            group by period_name,yearly_main_id
        "));


        $totalEfficiency = $dataLines->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('total_efficiency_product', 'period')->all()];
        })->toArray();


        $sumByProduct = $dataLines->groupBy('product_type_desc')->mapWithKeys(function ($item) {
            $groupName = $item->first()->product_type_desc;
            return [$groupName => $item->pluck('sumbypro', 'period_name')->all()];
        })->toArray();

        $sumByMonth = $sumByMonth->groupBy('period_name')->mapWithKeys(function ($item) {
            $groupName = $item->first()->period_name;
            return [$groupName => $item->pluck('sumbymonth','period_name')->all()];
        })->toArray();
    


        $pdf = PDF::loadView('pp.reports.PPR0001.index',compact('main','periods','estimateYearlies','tab22','tab1Yearly','WorkHour',
        'productionCapacity','efficiencyProduct','PmEfficiency','DtEfficiency','TotalEfficiencyProduct',
        'machineYearly','months','monthlists','machineDt','machinePm','totalOtProduct','WorkHourOt','YearlyTab21','cntWorkHour','cnt_working_hour',
        'totalDays','months','totalWkhNormal','totalPm','totalOt','sumWkh','dataHeads','totalEfficiency','sumByProduct','sumByMonth'))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    
    }

    public function TTCTRP85($programCode, $request) {
		return \Excel::download(new TTCTRP85, $programCode.'.xlsx');
    }

    public function PPR0007($programCode, $request)
    {
        $biweekly = BiweeklyV::where('period_num', $request->month)
                            ->where('period_year', $request->budget_year)
                            ->first();
        $next = $request->month == 12? 1: $request->month+1;
        $nextBiweekly = BiweeklyV::where('period_num', $next)->first();
        $stamps = StampFollowSummaryDailyV::where('stamp_code', $request->stamp_group)
                                    ->where('period_name', $biweekly->period_name)
                                    ->orderBy('follow_date')
                                    ->get();

        $cigarettes = StampFollowSummaryDailyV::selectRaw('distinct cigarettes_code, cigarettes_description, cigarettes_inventory_item_id item_id, stamp_group, stamp_seq')
                                    ->where('stamp_code', $request->stamp_group)
                                    ->where('period_name', $biweekly->period_name)
                                    ->orderByRaw('stamp_group asc, stamp_seq asc')
                                    ->get();

        $itemId = $cigarettes->pluck('item_id')->toArray();
        $stSequnces = ValueSetup::selectRaw('attribute1, attribute2, attribute3')
                                ->where('lookup_type', 'PTPP_DEFINE_COLOR_OF_CIGARETTE')
                                ->whereIn('attribute1', $itemId)
                                ->orderBy('attribute2')
                                ->get();
        $sequnces = $stSequnces->groupBy('attribute2')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->attribute2;
            return [$groupName => $item->pluck('attribute1', 'attribute3')->all()];
        })->toArray();

        $sign = $request->sign;
        $year = $biweekly->thai_year;
        $month = $biweekly->thai_month;
        $nextMonth = $nextBiweekly->thai_month;
        $onhands = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('onhand_qty')->all()];
        })->toArray();

        $receives = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('weekly_receive_qty', 'follow_date')->all()];
        })->toArray();

        $totalDaily = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('issue_qty', 'follow_date')->all()];
        })->toArray();
        // -----------------------------------------------------------------------------------------
        $damagedDaily = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('damaged_qty', 'follow_date')->all()];
        })->toArray();

        $lossDaily = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('lost_qty', 'follow_date')->all()];
        })->toArray();

        $incomDaily = $stamps->groupBy('cigarettes_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->cigarettes_code;
            return [$groupName => $item->pluck('incompleted_qty', 'follow_date')->all()];
        })->toArray();

        $fileName = 'แบบงบเดือนการปิดแสตมป์ยาสูบ_'. date('Ymdhms');
        $contentHtml = view('pp.reports.PPR0007.index', compact('year', 'month', 'nextMonth', 'cigarettes', 'onhands', 'receives', 'totalDaily', 'sign', 'sequnces', 'damagedDaily', 'lossDaily', 'incomDaily'))->render();
        return \PDF::loadHtml($contentHtml)->stream($fileName.'.pdf');
    }

    public function PPR0010($programCode, $request)
    {
        $biweekly = BiweeklyV::where('period_num', $request->month)
                            ->where('period_year', $request->budget_year)
                            ->where('biweekly', $request->biweekly)
                            ->first();
        // P08
        $st = date('d-m-Y', strtotime($biweekly->start_date));
        $ed = date('d-m-Y', strtotime($biweekly->end_date));
        $monthly = StampMonthly::where('period_name', $biweekly->period_name)
                                ->where('approved_status', 'Approved')
                                ->first();

        $stampDaily = [];
        $receiveQtyP08 = [];
        if ($monthly) {
            $stampDaily = StampDailyV::where('period_name', $biweekly->period_name)
                                    ->whereRaw("trunc(plan_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                                    ->where('monthly_id', $monthly->monthly_id)
                                    ->orderBy('plan_date')
                                    ->get();
            $receiveQtyP08 = $stampDaily->groupBy('plan_date')->mapWithKeys(function ($item, $group) {
                $groupName = $item->first()->plan_date;
                return [$groupName => $item->pluck('weekly_receive_qty')->all()];
            })->toArray();
        }

        // P09
        $itemCigarettes = StampFollowSummaryDailyV::selectRaw("distinct cigarettes_code, cigarettes_description, stamp_code")
                                            ->where('period_name', $biweekly->period_name)
                                            ->whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                                            ->orderByRaw('stamp_code asc, cigarettes_code asc')
                                            ->get()
                                            ->groupBy('stamp_code');

        $stampFollows = StampFollowSummaryDailyV::selectRaw("distinct follow_date")
                                            ->where('period_name', $biweekly->period_name)
                                            ->whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                                            ->orderBy('follow_date')
                                            ->get();

        $datas = StampFollowSummaryDailyV::selectRaw("follow_date||'|'||cigarettes_code item, cigarettes_code, cigarettes_description, follow_date, weekly_receive_qty")
                                            ->where('period_name', $biweekly->period_name)
                                            ->whereRaw("trunc(follow_date) BETWEEN TO_DATE('{$st}','dd-mm-YYYY') AND TO_DATE('{$ed}','dd-mm-YYYY')")
                                            ->orderBy('follow_date')
                                            ->get();

        $receiveQtyP09 = $datas->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('weekly_receive_qty')->all()];
        })->toArray();

        $fileName = 'รายงานสูญเสียแสตมป์_'. date('Ymdhms');
        $contentHtml = view('pp.reports.PPR0010.index', compact('stampFollows', 'itemCigarettes', 'receiveQtyP08', 'receiveQtyP09', 'programCode', 'st', 'ed', 'biweekly'))->render();
        return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');
    }

    public function PPR0011($programCode, $request)
    {
        // Tab 22 71,78
        $mainID = 0;
        $mainAdjID =0;
        $headerReport = null;
        $efficiencyProduct = 0;
        $datas  =  PtppPPR0011V::where('period_year', $request->period_year)
                                ->where('biweekly', $request->biweekly)
                                ->where('adjust_no', $request->version_no)
                                ->orderBy('product_type')
                                ->orderBy('item_code')
                                ->get();

        if (!empty($datas[0]->period_year)) {
           $headerReport = $datas[0];
           $mainID = $headerReport->product_main_id;
           $mainAdjID = $headerReport->adj_product_main_id;
           $efficiencyProduct = $headerReport->efficiency_product / 100;
        }

        $dateInfo = collect(\DB::select("
            select 
            thai_combine_date
            ,thai_start_date
            ,(select thai_start_date from PTPP_BIWEEKLY_V where biweekly_id = v.biweekly_id+1) thai_start_date_next
            from PTPP_BIWEEKLY_V v
            where biweekly = '{$request->biweekly}'
            and period_year = '{$request->period_year}'
        "));

        if (!empty($dateInfo[0]->thai_combine_date)) {
            $dateInfo = $dateInfo[0];
        }
        // Tab 23
        $datas23Biweek  =  ProductBiweeklyTab23V::where('product_main_id',  $mainID)
                                               ->where('wk_weekly', $request->biweekly)
                                               ->orderBy('product_type')
                                               ->orderBy('item_code')
                                               ->get();

        $cntBi23 =0 ;
        if (!empty($datas23Biweek[0]->product_main_id)) {
            $cntBi23 = count($datas23Biweek);
        }

       $datas23Adj  =  ProductBiweeklyTab23V::where('product_main_id',  $mainAdjID)
                                           ->where('wk_weekly', $request->biweekly)
                                           ->orderBy('product_type')
                                           ->orderBy('item_code')
                                           ->get();

        $EstimateProduct = $datas23Biweek->groupBy('item_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_code;
            return [$groupName => $item->pluck('estimate_product')->all()];
        })->toArray(); 

        $DefEstimateProduct = $datas23Adj->groupBy('item_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_code;
            return [$groupName => $item->pluck('def_estimate_product')->all()];
        })->toArray(); 

        $cntTab22 = count($datas)%15 ;
        $cntTab23 = count($datas23Biweek)%15 ;
        $cntPageNo = 0;
        if ($cntTab22+$cntTab23 < 15) {
            $cntPageNo = 1;
        }

        $pdf = PDF::loadView('pp.reports.PPR0011.index',compact('headerReport','datas','dateInfo','EstimateProduct'
        ,'DefEstimateProduct','datas23Biweek','cntBi23','efficiencyProduct','cntPageNo'))
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }

    public function CTR0034($programCode, $request) {
		return \Excel::download(new CTR0034, $programCode.'.xlsx');
    }

    public function CTR0036 ($programCode, $request)
    {
        $fundLoca10  =  PtpmStampGL::selectRaw('distinct percent, fund_location, stamp_adj_id')
                                ->where('period_name', $request->period_name)
                                ->where('product_type', '10')
                                ->orderBy('stamp_adj_id')
                                ->get();

        $fundLoca20  =  PtpmStampGL::selectRaw('distinct percent, fund_location, stamp_adj_id')
                                ->where('period_name', $request->period_name)
                                ->where('product_type', '10')
                                ->orderBy('stamp_adj_id')
                                ->get();

        $items10  =  PtpmStampGL::selectRaw("distinct item_code, item_description, product_type, product_type_desc, item_code||'|'||item_description item")
                            ->where('period_name', $request->period_name)
                            ->where('product_type', '10')
                            ->orderBy('item_code')
                            ->get();

        $items20  =  PtpmStampGL::selectRaw("distinct item_code, item_description, product_type, product_type_desc, item_code||'|'||item_description item")
                            ->where('period_name', $request->period_name)
                            ->where('product_type','20')
                            ->orderByRaw('item_code asc, item_description asc')
                            ->get();

        $qtys  =  PtpmStampGL::selectRaw("distinct item_code
                                , item_description
                                , order_quantity_carton
                                , stamp_quantity
                                , unit_price
                                , product_type_desc
                                , item_code||'|'||item_description item
                            ")
                            ->where('period_name', $request->period_name)
                            ->get();

        $qtysPercent  =  PtpmStampGL::selectRaw("item_code
                                    , item_description
                                    , stamp_amount
                                    , percent
                                    , item_code||'|'||item_description item
                                ")
                                ->where('period_name', $request->period_name)
                                ->get();

        $qtySummary  =  PtpmStampGL::selectRaw("sum(stamp_amount) sum_stamp_amount
                                    , item_code
                                    , item_description
                                    , item_code||'|'||item_description item
                                ")
                                ->where('period_name', $request->period_name)
                                ->whereRaw(" stamp_adj_id not in (-1, 1, 8)")
                                ->groupBy('item_code','item_description')
                                ->get();

        $QuantityCarton = $qtys->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('order_quantity_carton')->all()];
        })->toArray();

        $StampQuantity = $qtys->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('stamp_quantity')->all()];
        })->toArray();

        $UnitPrice = $qtys->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('unit_price')->all()];
        })->toArray();

        $QtysAmount = $qtysPercent->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('stamp_amount','percent')->all()];
        })->toArray();

        $qtySum = $qtySummary->groupBy('item')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item;
            return [$groupName => $item->pluck('sum_stamp_amount')->all()];
        })->toArray();

        // Summary By Percent
        $SumQtyPercent  =  PtpmStampGL::selectRaw('sum(stamp_amount) sum_stamp_amount
                                        , percent
                                        , fund_location
                                        , product_type
                                    ')
                                    ->where('period_name', $request->period_name)
                                    ->groupBy('percent','fund_location', 'product_type')
                                    ->get();

        $SumQtysPercent = $SumQtyPercent->groupBy('product_type')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->product_type;
            return [$groupName => $item->pluck('sum_stamp_amount','percent')->all()];
        })->toArray();

        // Dr-Cr
        $DrCr10 = PtpmStampGL::selectRaw("
                                main_account_desc||'.'||sub_account_desc account_desc
                                ,main_account||'.'||sub_account  account
                                ,sum(stamp_amount)   stamp_amount
                                ,dr_cr
                            ")
                            ->where('period_name', $request->period_name)
                            ->where('product_type', '10')
                            ->groupBy('main_account_desc','sub_account_desc','main_account','sub_account','dr_cr')
                            ->orderBy('dr_cr','desc')
                            ->orderBy('sub_account')
                            ->get();

        $DrCr20 = PtpmStampGL::selectRaw("
                                main_account_desc||'.'||sub_account_desc account_desc
                                ,main_account||'.'||sub_account  account
                                ,sum(stamp_amount)   stamp_amount
                                ,dr_cr
                            ")
                            ->where('period_name', $request->period_name)
                            ->where('product_type', '20')
                            ->groupBy('main_account_desc','sub_account_desc','main_account','sub_account','dr_cr')
                            ->orderBy('dr_cr','desc')
                            ->orderBy('sub_account')
                            ->get();

        $pdf = PDF::loadView('ct.Reports.ctr0036.index',compact('fundLoca10', 'fundLoca20', 'items10','items20','request','QuantityCarton'
                        ,'StampQuantity','UnitPrice','QtysAmount','qtySum','SumQtysPercent'
                        ,'DrCr10','DrCr20'))
                        ->setPaper('a4')
                        ->setOrientation('landscape')
                        ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }

    public function CTR0037($programcode, $request) {
        return (new CTR0037Controller)->CTR0037Export($programcode, $request);
    }
}
