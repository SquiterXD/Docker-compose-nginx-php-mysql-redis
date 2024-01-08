<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampAdjustGLINT extends Model
{
    use HasFactory;
    protected $table = "OAPM.PTPM_STAMP_GL_INT_WEB";
    public $primaryKey = 'stamp_gl_id';
    public $timestamps = false;

    public function callCreateStampGLINT($periodName)
    {
        $batchNo = date('YmdHis');
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    return_status  varchar2(1)      :=  NULL;
                    return_msg     varchar2(4000)   :=  NULL;
                begin
                    ptom_web_utilities_pkg.CREATE_GL_STAMP( P_BATCH_NO      => '{$batchNo}'
                                                        , P_DATE_FROM       => to_date('{$periodName}','MON-RR')
                                                        , P_DATE_TO         => to_date('{$periodName}','MON-RR')
                                                        , o_return_status   => :return_status
                                                        , o_return_msg      => :return_msg
                                                    );
                    end;
                ";

        \Log::info($sql);
        $result = [];
        $sql = preg_replace("/[\r\n]*/","", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }

    public function callUpdateStampGLINT($batchNo)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_return_status   varchar2(10);
                    v_return_msg      varchar2(4000);
                    begin
                        ptom_web_utilities_pkg.update_gl_stamp( P_BATCH_NO      => '{$batchNo}'
                                                            , o_return_status   => :v_return_status
                                                            , o_return_msg      => :v_return_msg
                                                        );
                    end;
                ";

        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callStampInterfaceGL($batchNo, $accountingDate)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_return_status        VARCHAR2(2000);
                    v_return_message       VARCHAR2(4000);
                    begin
                        ptom_web_utilities_pkg.create_interface_gl_stamp( P_BATCH_NO        => '{$batchNo}' 
                                                                       , P_ACCOUNTING_DATE  => to_date('$accountingDate','DD/MM/YYYY')
                                                                       , P_TYPE             => 'IMPORT'
                                                                       , o_return_status    => :v_return_status
                                                                       , o_return_msg       => :v_return_message 
                                                                    );
                    end ;
                ";

        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_message', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callStampCancelInterfaceGL($batchNo, $accountingDate)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_return_status        VARCHAR2(2000);
                    v_return_message       VARCHAR2(4000);
                    begin
                        ptom_web_utilities_pkg.create_interface_gl_stamp( P_BATCH_NO        => '{$batchNo}' 
                                                                       , P_ACCOUNTING_DATE  => to_date('$accountingDate','DD/MM/YYYY')
                                                                       , P_TYPE             => 'REVERSE'
                                                                       , o_return_status    => :v_return_status
                                                                       , o_return_msg       => :v_return_message 
                                                                    );
                    end ;
                ";

        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_message', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
