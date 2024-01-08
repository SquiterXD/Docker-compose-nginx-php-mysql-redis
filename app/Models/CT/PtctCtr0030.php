<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtr0030 extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_CTR0030';
    public $timestamps = false;

    protected $guarded = [];

    public static function callPackage($pYear, $pCostCode, $pDateFrom, $pDateTo, $pBatchNoFrom, $pBatchNoTo, $pItemNoFrom, $pItemNoTo) {

        $resResult = [
            "rpt_id"    => null,
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RPT_ID                 NUMBER;     
                    BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');

                        PTCT_REPORT_PKG.CTR0030(P_YEAR          => '{$pYear}'	
                                            ,P_COST_CODE        => '{$pCostCode}'	
                                            ,P_DATE_FROM        => '{$pDateFrom}' 	
                                            ,P_DATE_TO          => '{$pDateTo}'	
                                            ,P_BATCH_NO_FROM    => '{$pBatchNoFrom}'
                                            ,P_BATCH_NO_TO      => '{$pBatchNoTo}'
                                            ,P_ITEM_FROM        => '{$pItemNoFrom}'
                                            ,P_ITEM_TO          => '{$pItemNoTo}'
                                            ,X_RPT_ID           => :R_RPT_ID );	
                        
                        dbms_output.put_line('OUTPUT :' || :R_RPT_ID );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                    EXCEPTION WHEN others THEN 
                        dbms_output.put_line('**call_error' || sqlerrm);            
                    END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RPT_ID', $resResult['rpt_id'], \PDO::PARAM_INT);
        $stmt->execute();

        return $resResult;

    }

}
