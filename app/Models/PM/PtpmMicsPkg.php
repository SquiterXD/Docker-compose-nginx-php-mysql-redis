<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtpmMicsPkg extends Model
{
    use HasFactory;

    public static function generateYearPlanLine($pYearlyHeaderId)
    {
        $db     = DB::connection('oracle')->getPdo();

        $sql    =   "declare
                        l_status        varchar2(100);
                        l_message       varchar2(1000);
                        begin
                            PTPM_MICS_PKG.genarate_year_plan_line(p_yearly_header_id => {$pYearlyHeaderId},
                                                            x_status => :l_status,
                                                            x_message => :l_message); 
                                    dbms_output.put_line(l_status); 
                                    dbms_output.put_line(l_message);
                            dbms_output.put_line('Status : ' || :l_status);
                            dbms_output.put_line('Error : ' || :l_message);
                        end;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':l_status', $result['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':l_message', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public static function generateMonthlyPlanLine($pMonthlyHeaderId)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        l_status        varchar2(100);
                        l_message       varchar2(1000);
                        begin
                            PTPM_MICS_PKG.genarate_monthly_plan_line(p_monthly_header_id => '{$pMonthlyHeaderId}',
                                                            x_status => :l_status,
                                                            x_message => :l_message); 
                                    dbms_output.put_line(l_status); 
                                    dbms_output.put_line(l_message);
                                    dbms_output.put_line('Status : ' || :l_status);
                                    dbms_output.put_line('Error : ' || :l_message);
                        end;
                    ";

        
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':l_status', $result['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':l_message', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public static function monthTxt($monthNumber, $monthlyHeaderId) {

        $result = [
            "status"    => "S",
            "message"   => "",
        ];

        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_msg           varchar2(2000);
                    begin
                        PTPM_MICS_PKG.month_txt({$monthNumber}, {$monthlyHeaderId}, :v_msg);
                        dbms_output.put_line('v_msg : ' || :v_msg);
                    end;
                ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':v_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;

    }

    // BIWEEKLY
    public static function generatePlanLine($pPlanHeaderId)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        l_status        varchar2(100);
                        l_message       varchar2(1000);
                        begin
                            PTPM_MICS_PKG.genarate_plan_line(p_plan_header_id => '{$pPlanHeaderId}',
                                                            x_status => :l_status,
                                                            x_message => :l_message); 
                                    dbms_output.put_line(l_status); 
                                    dbms_output.put_line(l_message);
                                    dbms_output.put_line('Status : ' || :l_status);
                                    dbms_output.put_line('Error : ' || :l_message);
                        end;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':l_status', $result['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':l_message', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;

    }
    

    // PRODUCT MACHINE REQUETS
    public static function generateProductMachineRequest($pDate, $pInventoryItemId, $pMachineName, $pObjectiveRequest)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "
                    declare
                        v_status         varchar2(5);
                        v_err_msg        varchar2(2000);
                    begin
                        PTPM_MICS_PKG.product_machine_request( p_date  => TO_DATE('{$pDate}', 'YYYY-MM-DD'),
                                                p_inventory_item_id => {$pInventoryItemId},
                                                p_machine_number => '{$pMachineName}',
                                                p_objective_request => '{$pObjectiveRequest}',
                                                x_status => :v_status,
                                                x_message => :v_err_msg); 
                        dbms_output.put_line(v_status); 
                        dbms_output.put_line(v_err_msg);
                        dbms_output.put_line('Status : ' || :v_status);
                        dbms_output.put_line('Error : ' || :v_err_msg);
                    end;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;

    }

}
