<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;

class WebStationeryPackage extends Model
{
    public static function interface($issueHeader)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_return_status      varchar2(4000)  :=  NULL;
                            v_message            varchar2(4000)  :=  NULL;
                        BEGIN
                            PTINV_WEB_STATIONERY_PKG.UPLOAD_TO_MMT 
                            (   P_ISSUE_NUMBER      => :issue_number
                                ,P_ACTION_CODE      => 'ISSUE'
                                ,P_RETURN_STATUS    => :v_return_status
                                ,P_RETURN_MESSAGE   => :v_message
                            );

                            dbms_output.put_line ('***Error-'|| :v_return_status);
                            dbms_output.put_line ('***Error-'|| :v_message);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $issueNumber = $issueHeader->issue_number;
        
        $stmt->bindParam(':issue_number',  $issueNumber, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':v_return_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_message', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    
    }

    public static function returnIssueHeaderInterface($issueNumber)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_return_status      varchar2(4000)  :=  NULL;
                            v_message            varchar2(4000)  :=  NULL;
                        BEGIN
                            PTINV_WEB_STATIONERY_PKG.UPLOAD_TO_MMT 
                            (   P_ISSUE_NUMBER      => :issue_number
                                ,P_ACTION_CODE      => 'RECEIPT'
                                ,P_RETURN_STATUS    => :v_return_status
                                ,P_RETURN_MESSAGE   => :v_message
                            );

                            dbms_output.put_line ('***Error-'|| :v_return_status);
                            dbms_output.put_line ('***Error-'|| :v_message);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':issue_number',  $issueNumber, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':v_return_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_message', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    
    }
}
