<?php
namespace App\Models\EAM;

use DB;
use PDO;

class WorkOrderMtUsedInterface
{
    public static function Import($batchNo, $organizationId, $wipEntityId, $operationSeqNum, $inventoryItemId)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE

                        V_STATUS    VARCHAR2(1);
                        V_MSG       VARCHAR2(4000);

                        BEGIN
                        PTEAM_MATERIAL_ISSUE_PKG.MATERIAL_ISSUE(P_WEB_BATCH_NO  => '{$batchNo}'
                            ,P_ORGANIZATION_ID   => {$organizationId}
                            ,P_WIP_ENTITY_ID  =>  {$wipEntityId}
                            ,P_OPERATION_SEQ_NUM  =>  '{$operationSeqNum}'
                            ,P_INVENTORY_ITEM_ID  => {$inventoryItemId}    
                            ,P_INF_STATUS  =>  :V_STATUS
                            ,P_INF_MSG     =>  :V_MSG  );    
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
