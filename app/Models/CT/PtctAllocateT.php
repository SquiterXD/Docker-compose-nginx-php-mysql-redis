<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;

class PtctAllocateT extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_T';
    protected $primaryKey = ['web_batch_no', 'allocate_year_id', 'allocate_group_code', 'target_code'];
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'web_batch_no'
        ,'allocate_year_id'
        ,'allocate_group'
        ,'allocate_group_code'
        ,'target_account_code'
        ,'target_code'
        ,'target_dept_code'
        ,'target_cc_code'
        ,'target_product_group'
        ,'quantity'
        ,'ratio_rate'
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
        ,'target_account_code_from'
        ,'target_account_code_to'
    ];

    public static function buildAllocateTarget($webBatchNo) {

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
                        
                        PTCT_M008_PKG.BUILD_TARGET(  P_WEB_BATCH_NO         => '{$webBatchNo}'
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

    public static function copyNewVersion($fromAllocateYearId, $toAllocateYearId) {

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
                        
                        PTCT_M008_PKG.COPY_NEW_VERSION( P_FROM_ALLOCATE_YEAR_ID => {$fromAllocateYearId}
                                                , P_TO_ALLOCATE_YEAR_ID         => {$toAllocateYearId}
                                                , P_RETURN_STATUS               => :R_RETURN_STATUS  
                                                , P_RETURN_MESSAGE              => :R_RETURN_MESSAGE ) ;
                        
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

}
