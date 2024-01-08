<?php
namespace App\Models\EAM;

use DB;
use PDO;

class AssetInterface
{
    public static function Import($batchNo)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE

                        V_STATUS    VARCHAR2(100);
                        V_MSG       VARCHAR2(4000);

                        BEGIN
                        PTEAM_RESOURCE_ASSET_PKG.MAIN(P_WEB_BATCH_NO  => '{$batchNo}'
                                , P_INTERFACE_STATUS   => :V_STATUS                            
                                , P_INTERFACE_MSG      => :V_MSG);           
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
