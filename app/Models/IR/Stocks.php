<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stocks extends Model
{
    use HasFactory;

    public function checkDupStockYearly($year, $policyId, $status, $period_from, $period_to, $deptFrom, $deptTo)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
    
            PTIR_WEB_UTILITIES_PKG.GET_STOCK_YEARLY_CHECK_DUP
            (
                I_USER_ID                =>  25
                ,I_YEAR                  => :year
                ,I_POLICY_SET_HEADER_ID  => :policy_set_header_id
                ,I_STATUS                => :status
                ,I_DATE_FROM             => :period_from
                ,I_DATE_TO               => :period_to
                ,I_DEPT_CODE_FROM        => :dept_code_from
                ,I_DEPT_CODE_TO          => :dept_code_to
                ,O_RETURN_STATUS         => :lv_return_status
                ,O_RETURN_MSG            => :lv_return_msg
            );        
        
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id', $policyId, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->bindParam(':period_from', $period_from, \PDO::PARAM_STR);
        $stmt->bindParam(':period_to', $period_to, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callGetStockYearly($year, $policyId, $status, $period_from, $period_to, $deptFrom, $deptTo) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
    
            PTIR_WEB_UTILITIES_PKG.GET_STOCK_YEARLY
            (
                I_USER_ID                =>  25
                ,I_YEAR                  => :year
                ,I_POLICY_SET_HEADER_ID  => :policy_set_header_id
                ,I_STATUS                => :status
                ,I_DATE_FROM             => :period_from
                ,I_DATE_TO               => :period_to
                ,I_DEPT_CODE_FROM        => :dept_code_from
                ,I_DEPT_CODE_TO          => :dept_code_to
                ,O_RETURN_STATUS         => :lv_return_status
                ,O_RETURN_MSG            => :lv_return_msg
            );        
        
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id', $policyId, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->bindParam(':period_from', $period_from, \PDO::PARAM_STR);
        $stmt->bindParam(':period_to', $period_to, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function checkDupStockMonthly($year, $policyId, $data_month, $deptFrom, $deptTo)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN

            PTIR_WEB_UTILITIES_PKG.GET_STOCK_MONTHLY_CHECK_DUP
            (
                I_USER_ID                =>  25
                ,I_YEAR                  =>  :year
                ,I_POLICY_SET_HEADER_ID  =>  :policy_set_header_id
                ,I_DATE_MONTH            =>  :data_month
                ,I_DEPT_CODE_FROM        =>  :dept_code_from
                ,I_DEPT_CODE_TO          =>  :dept_code_to
                ,O_RETURN_STATUS         =>  :lv_return_status
                ,O_RETURN_MSG            =>  :lv_return_msg
            );        
        
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id', $policyId, \PDO::PARAM_STR);
        $stmt->bindParam(':data_month', $data_month, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callGetStockMonthly($year, $policyId, $data_month, $deptFrom, $deptTo) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
            BEGIN
    
            PTIR_WEB_UTILITIES_PKG.GET_STOCK_MONTHLY
            (
                I_USER_ID                =>  25
                ,I_YEAR                  =>  :year
                ,I_POLICY_SET_HEADER_ID  =>  :policy_set_header_id
                ,I_DATE_MONTH            =>  :data_month
                ,I_DEPT_CODE_FROM        =>  :dept_code_from
                ,I_DEPT_CODE_TO          =>  :dept_code_to
                ,O_RETURN_STATUS         =>  :lv_return_status
                ,O_RETURN_MSG            =>  :lv_return_msg
            );        
        
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            commit;

            END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':policy_set_header_id', $policyId, \PDO::PARAM_STR);
        $stmt->bindParam(':data_month', $data_month, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_from', $deptFrom, \PDO::PARAM_STR);
        $stmt->bindParam(':dept_code_to', $deptTo, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
