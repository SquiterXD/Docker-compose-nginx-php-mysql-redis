<?php
namespace App\Models\EAM;

use DB;
use PDO;

class WorkOrderLbInterface
{
    public static function Import($batchNo)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE

                        V_STATUS    VARCHAR2(100);
                        V_MSG       VARCHAR2(4000);

                        BEGIN
                        PTEAM_LABOR_COST_PKG.IMPORT(P_WEB_BATCH_NO  => '{$batchNo}'
                                , P_INF_STATUS   => :V_STATUS                            
                                , P_INF_MSG      => :V_MSG);           
                        END ;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':V_STATUS', $result['status'], PDO::PARAM_STR, 100);
        $stmt->bindParam(':V_MSG', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
