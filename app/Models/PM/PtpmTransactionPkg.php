<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtpmTransactionPkg extends Model
{
    use HasFactory;

    public static function createRequest($pPlanHeaderId)
    {
        $db     = DB::connection('oracle')->getPdo();

        $sql    =   "declare
                        l_status        varchar2(100);
                        l_message       varchar2(1000);
                        begin

                        PTPM_TRANSACTION_PKG.CREATE_REQUEST( P_plan_header_id => {$pPlanHeaderId}
                                            ,V_MESSAGE  => :l_status
                                            ,V_STATUS  => :l_message); 
                            dbms_output.put_line('Status : ' || :l_status);
                            dbms_output.put_line('Error : ' || :l_message);
                        end;
                    ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':l_status', $result['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':l_message', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

}
