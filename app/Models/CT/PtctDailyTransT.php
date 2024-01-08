<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctDailyTransT extends Model
{
    use HasFactory;
    protected $table = 'PTCT_DAILY_TRANS_T';
    
    public $primaryKey = 'param_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'param_id'
        ,'tran_date'
        ,'tran_flag'
        ,'process_step'
        ,'period_year'
        ,'period_name'
        ,'period_number'
        ,'cost_code'
        ,'dept_code'
        ,'account_code'
        ,'sub_account_code'
        ,'budget_year'
        ,'complete_date'
        ,'batch_no'
        ,'batch_status'
        ,'product_item_number'
        ,'complete_qty'
        ,'remain_quantity'
        ,'uom_code'
        ,'freeze_flag'
        ,'closed_date'
        ,'work_order_status'
        ,'work_order_number'
        ,'gl_posting_status'
        ,'gl_ref_doc_no'
        ,'gl_ref_reversed'
        ,'organization_id'
        ,'inventory_item_id'
        ,'program_code'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
        ,'created_by_id'
        ,'updated_by_id'
        ,'deleted_by_id'
        ,'created_by'
        ,'creation_date'
        ,'last_update_date'
        ,'last_updated_by'
        ,'last_update_login'
        ,'last_process_number'
    ];

    

    public static function getSessionPtctWorkorderPkg()
    {
        $result = DB::select( DB::raw('SELECT  se.sid, se.serial# FROM v$access ac, v$session se WHERE ac.sid = se.sid AND ac.object like \'PTCT_WORKORDER_PKG%\'') );
        $session = $result ? $result[0]->sid : null;
        return $session;
    }

    public static function generateWorkorderProcesses($pParamId) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RETURN_STATUS         varchar2(1) := NULL;
                        R_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;     
                        BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        PTCT_WORKORDER_PKG.MAIN( P_PARAM_ID             => {$pParamId}
                                            , P_RETURN_STATUS           => :R_RETURN_STATUS  
                                            , P_RETURN_MESSAGE          => :R_RETURN_MESSAGE ) ;
                        
                        dbms_output.put_line('OUTPUT :' || :R_RETURN_STATUS || ' MSG :' || :R_RETURN_MESSAGE  );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':R_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $resResult;

    }

    public static function queryWorkorderProcesses($pParamId) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RETURN_STATUS         varchar2(1) := NULL;
                        R_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;     
                        BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        PTCT_WORKORDER_PKG.QUERY( P_PARAM_ID            => {$pParamId}
                                            , P_RETURN_STATUS           => :R_RETURN_STATUS  
                                            , P_RETURN_MESSAGE          => :R_RETURN_MESSAGE ) ;
                        
                        dbms_output.put_line('OUTPUT :' || :R_RETURN_STATUS || ' MSG :' || :R_RETURN_MESSAGE  );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':R_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $resResult;

    }

    public static function processWorkorderProcesses($pParamId) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RETURN_STATUS         varchar2(1) := NULL;
                        R_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;     
                        BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        PTCT_WORKORDER_PKG.PROCESS( P_PARAM_ID            => {$pParamId}
                                            , P_RETURN_STATUS           => :R_RETURN_STATUS  
                                            , P_RETURN_MESSAGE          => :R_RETURN_MESSAGE ) ;
                        
                        dbms_output.put_line('OUTPUT :' || :R_RETURN_STATUS || ' MSG :' || :R_RETURN_MESSAGE  );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':R_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $resResult;

    }

    
    public static function buildReport($pProgramCode, $pParamId) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RETURN_STATUS         varchar2(1) := NULL;
                        R_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;     
                        BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        PTCT_BUILD_RPT.MAIN( P_PARAM_ID                 => {$pParamId}
                                            , P_REPORT_CODE             => '{$pProgramCode}'
                                            , P_RETURN_STATUS           => :R_RETURN_STATUS  
                                            , P_RETURN_MESSAGE          => :R_RETURN_MESSAGE ) ;
                        
                        dbms_output.put_line('OUTPUT :' || :R_RETURN_STATUS || ' MSG :' || :R_RETURN_MESSAGE  );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':R_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $resResult;

    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function uomCode()
    {
        return $this->belongsTo(PtInvUomV::class, 'uom_code', 'uom_code');
    }

}
