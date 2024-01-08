<?php

namespace App\Repositories\OM;

use DB;

class OracleCall
{
    public static function callpakcages($web_batch_no)
    {
        $result = [];

        $db     =   DB::connection('oracle')->getPdo();

        $sql    =   "
        DECLARE
 LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
 LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
BEGIN
 PTOM_WEB_UTILITIES_PKG.CREATE_AP_INTERFACE(
  P_BATCH_NO        =>  '{$web_batch_no}'
  ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
  ,O_RETURN_MSG     =>  :LV_RETURN_MSG 
 );
 
END;
            ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public static function callpakcagesOMP0043($web_batch_no)
    {
        $result = [];

        $db     =   DB::connection('oracle')->getPdo();

        $sql    =   "
        DECLARE
            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
        BEGIN


            PTOM_WEB_UTILITIES_PKG.CREATE_GL_INTERFACE
                            (P_BATCH_NO        => '{$web_batch_no}'
                            ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                            ,O_RETURN_MSG     =>  :LV_RETURN_MSG 
                            );
        

        END;
            ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
