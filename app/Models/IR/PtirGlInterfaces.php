<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\IR\Views\PtirPolicySetHeadersView;

class PtirGlInterfaces extends Model
{
    use HasFactory;
    protected $table = "ptir_gl_interfaces";
    public $primaryKey = 'interface_id';

    // Add function search -- Piyawut A. 20211111
    public function policySetHeader()
    {
        return $this->hasOne(PtirPolicySetHeadersView::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function fndLookup()
    {
        return $this->hasOne(\App\Models\FndLookupValue::class, 'lookup_code', 'interface_type')->where('lookup_type', 'PTIR_GL_INTERFACE_TYPE');
    }

    public function scopeSearch($q, $param, $period_name, $status)
    {
        if ($param) {
            if ($param->period_name) {
                $q->whereRaw("UPPER(period_name) like '%".strtoupper($period_name)."%'");
            }

            if ($param->insurance_type) {
                $q->where('interface_type', $param->insurance_type);
            }

            if ($param->expense_type) {
                $q->where('group_code', $param->expense_type);
            }

            if ($status) {
                $q->where('interface_status', $status);
            }else{
                $q;
            }

            // Add New Where by condition return interface
            if (isset($param->batch_no)) {
                $q->where('web_batch_no', $param->batch_no);
            }
        }
        return $q;
    }

    public function interfaceGl($periodName, $type, $groupCode, $user) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            declare
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
                lv_batch_no           varchar2(4000)  :=  NULL;
            BEGIN
            
                PTIR_WEB_UTILITIES_PKG.GL_SEND_INTERFACE( I_USER_ID                   =>  :user
                                                        , I_PERIOD                    =>  :period_name
                                                        , I_GL_INTERFACE_TYPE_CODE    =>  :type
                                                        , I_GROUP_CODE                =>  :group_code
                                                        , O_BATCH_NO                  =>  :lv_batch_no
                                                        , O_RETURN_STATUS             =>  :lv_return_status
                                                        , O_RETURN_MSG                =>  :lv_return_msg
                                                    );
                
                dbms_output.put_line('lv_return_status = '||lv_return_status);
                dbms_output.put_line('lv_return_msg = '||lv_return_msg);
            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':period_name', $periodName, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $groupCode, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
    
    public function cancel($periodName, $type, $groupCode, $user) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_batch_no           varchar2(4000)  :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.CANCEL_GL_INTERFACE
            (
                  I_USER_ID                   =>  :user
                , I_PERIOD                    =>  :period_name
                , I_GL_INTERFACE_TYPE_CODE    =>  :type
                , I_POLICY_SET_HEADER_ID      =>   null
                , I_GROUP_CODE                =>  :group_code
                , O_BATCH_NO                  =>  :lv_batch_no
                , O_RETURN_STATUS             =>  :lv_return_status
                , O_RETURN_MSG                =>  :lv_return_msg
            );
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':period_name', $periodName, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $groupCode, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function report($periodName, $type, $groupCode, $user) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
        lv_return_status        varchar2(100)   :=  NULL;
        lv_return_msg           varchar2(4000)  :=  NULL;
        lv_batch_no             varchar2(4000)  :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.GL_REPORT_INTERFACE
            (
                I_USER_ID                     =>  :user
                , I_PERIOD                    =>  :period_name
                , I_GL_INTERFACE_TYPE_CODE    =>  :type
                , I_GROUP_CODE                =>  :group_code
                , O_BATCH_NO                  =>  :lv_batch_no
                , O_RETURN_STATUS             =>  :lv_return_status
                , O_RETURN_MSG                =>  :lv_return_msg
            );
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':period_name', $periodName, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':group_code', $groupCode, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
