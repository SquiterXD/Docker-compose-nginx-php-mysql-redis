<?php

namespace App\Repositories\Report\Traits;

use FormatDate;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDO;
use App\Models\CT\DailyTransT;
use App\Models\CT\PtctParamsT;

use App\Http\Controllers\IR\Reports\IRR2120Controller;
use App\Http\Controllers\IR\Reports\ReportPoomController;



trait Komsupanat
{

    ### Start CTR01012 ###
    public function CTR01012($programCode, $request)
    {
        // dd($request->all());
        // $userId = optional(auth()->user())->user_id ?? -1;
        $genId = collect(DB::select("
                                         select PTCT_PARAMS_T_S.nextval as param_id from dual
                                     "))->first();
        // \DB::beginTransaction();
        // try {

        //     $paramsT                         =  new PtctParamsT();		
        //     $paramsT->param_id        		 =	$genId->param_id;                             
        //     $paramsT->start_date        	 =	Carbon::createFromFormat('d/m/Y H:i:s',$request->start_date)->format('Y-m-d');       
        //     $paramsT->end_date          	 =	Carbon::createFromFormat('d/m/Y H:i:s',$request->end_date)->format('Y-m-d');
        //     $paramsT->cc_code           	 =	$request->cc_code;           
        //     $paramsT->dept_code_from    	 =	$request->dept_code_from;    
        //     $paramsT->dept_code_to      	 =	$request->dept_code_to;       
        //     $paramsT->program_code      	 =	$programCode;      
        //     $paramsT->created_at        	 =	now();        
        //     $paramsT->updated_at        	 =	$request->updated_at;        
        //     $paramsT->created_by_id     	 =	$userId;     
        //     $paramsT->updated_by_id     	 =	$userId;     
        //     $paramsT->created_by        	 =	$userId;        
        //     $paramsT->creation_date     	 =	now();     
        //     $paramsT->last_update_date  	 =	now();  
        //     $paramsT->last_updated_by   	 =	$userId;   

        //     //dd($paramsT,  $request->cc_code, $request->all());

        //     $paramsT->save();

        //     \DB::commit();

        // } catch (\Exception $e) {
        //     \DB::rollBack();
        //     if($request->ajax()){
        //         $result['status'] = 'ERROR';
        //         $result['err_msg'] = $e->getMessage();
        //         return $result;
        //     }else{
        //         \Log::error($e->getMessage());
        //         return abort('403');
        //     }  
        // }

        // $db = DB::connection('oracle')->getPdo();
        // $sql  = "
        //             DECLARE
        //             P_RETURN_STATUS         varchar2(1) := NULL;
        //             P_RETURN_MESSAGE        varchar2(1000) := NULL;
        //             v_debug                 NUMBER :=1;

        //             BEGIN
        //             dbms_output.put_line('---------------------  S T A R T. -------------------');

        //             PTCT_BUILD_RPT.MAIN( P_PARAM_ID                 => '{$genId->param_id}'
        //                                 , P_REPORT_CODE             => '{$programCode}'    
        //                                 , P_RETURN_STATUS           => :P_RETURN_STATUS  
        //                                 , P_RETURN_MESSAGE          => :P_RETURN_MESSAGE ) ;

        //             dbms_output.put_line('OUTPUT :'|| :P_RETURN_STATUS 
        //                                 ||' MSG :'||  :P_RETURN_MESSAGE  );


        //             dbms_output.put_line('---------------------  E N D. -------------------');
        //             EXCEPTION WHEN others THEN 
        //                 dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
        //             END ;
        //         ";
        // \Log::info($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        // $stmt = $db->prepare($sql);

        // $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
        // $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
        // $stmt->execute();

        // \Log::info('status', $result);

        // dd($result['P_RETURN_MESSAGE']);

        $G1 = DailyTransT::selectRaw("cc_code, dept_code")
            //  ->where('PARAM_ID',$genId->param_id)
            ->where('PARAM_ID', 1511)

            ->groupBy('cc_code', 'dept_code')
            ->get();

        $G2 = DailyTransT::selectRaw("dept_code, cat_segment1, cat_name")
            ->where('PARAM_ID', 1511)
            // ->where('CC_CODE',30)
            //->whereBetween('DEPT_CODE',[62000200, 62000200])

            ->groupBy('cat_segment1', 'dept_code', 'cat_name')
            ->get();

        $G3 = DailyTransT::selectRaw("dept_code, cat_segment1, cat_name,item_no,item_description,mmt_qty,mmt_unit_price,mmt_amount")
            ->where('PARAM_ID', 1511)
            //->where('CC_CODE',30)
            //->whereBetween('DEPT_CODE',[62000200, 62000200])
            // ->where('CAT_SEGMENT1',10)
            ->groupBy('cat_segment1', 'dept_code', 'cat_name', 'item_no', 'item_description', 'mmt_qty', 'mmt_unit_price', 'mmt_amount')
            ->get();

        // dd($G2);   ### log out put ###

        //C:.MCR.web-service.resources.views.ct.Komsupanat.index.blade.php
        ### Generate PDF ###
        $pdf = PDF::loadView('ct.Komsupanat.index', compact('G1', 'G2', 'G3'))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode . '.pdf');
    }   ### End CTR01012 ###


    public function IRR0081_2($programCode, $request)
    {
        //dd($programCode);
        // return (new ReportPoomController)->IRR2120PDF($programCode, $request);
        return (new ReportPoomController)->IRR0081_2PDF($programCode, $request);
    }

    // ### Report IR : IRR6120 ###
    // public function IRR6120($programCode, $request){
    //     return $pdf->stream($programCode. '.pdf');
    // }
//IRR6120
    public function IRR0082_2($programCode, $request)
    {
         //dd($programCode, $request);
        return (new ReportPoomController)->IRR0082_2PDF($programCode, $request);
    }

    public function IRR6210($programCode, $request)
    {
         //dd($programCode, $request);
        return (new ReportPoomController)->IRR6210PDF($programCode, $request);
    }

    public function IRR2210($programCode, $request)
    {
         //dd($programCode, $request);
        return (new ReportPoomController)->IRR2210PDF($programCode, $request);
    }
}
