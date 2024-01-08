<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class PtirApInvoiceInterfaces extends Model
{
    use HasFactory;
    protected $table = "ptir_ap_invoice_interfaces";
    public $primaryKey = 'interface_id';

    public function scopeSearch($q, $param, $invoiceDate, $status)
    {
        if ($param) {
            if ($param->year) {
                $q->where('policy_group_year', $param->year);
            }

            if ($param->type) {
                $q->where('from_program_code', $param->type);
            }

            if ($param->date) {
                $date = date('m-d-Y', strtotime($param->date));
                $q->whereRaw("trunc(invoice_date) >= TO_DATE('{$date}','DD-MM-YYYY')");
            }

            if ($param->invoice_batch) {
                $q->where('invoice_batch', $param->invoice_batch);
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

    public function interfaceAp($year, $type, $date, $user, $invoiceBatch) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                    lv_return_status      varchar2(100)   :=  NULL;
                    lv_return_msg         varchar2(4000)  :=  NULL;
                    lv_batch_no           varchar2(4000)  :=  NULL;
                BEGIN
                
                    PTIR_WEB_UTILITIES_PKG.AP_SEND_INTERFACE
                    (
                      I_USER_ID                   =>  :user
                    , I_YEAR                      =>  :year
                    , I_INTERFACE_TYPE_CODE       =>  :type 
                    , I_INVOICE_DATE              =>  to_char(to_date(:date, 'dd/mm/yyyy'), 'DD-MON-YYYY')
                    , I_INVOICE_BATCH             =>  :invoice_batch
                    , O_BATCH_NO                  =>  :lv_batch_no
                    , O_RETURN_STATUS             =>  :lv_return_status
                    , O_RETURN_MSG                =>  :lv_return_msg
                    );

                    dbms_output.put_line('lv_return_status = '||lv_return_status);
                    dbms_output.put_line('lv_return_msg = '||lv_return_msg);
                    commit;
                END; ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, \PDO::PARAM_STR);
        $stmt->bindParam(':invoice_batch', $invoiceBatch, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function cancel($year, $type, $date, $user, $group_id)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_batch_no           varchar2(4000)  :=  NULL;
        BEGIN

            PTIR_WEB_UTILITIES_PKG.CANCEL_AP_INTERFACE
            (
              I_USER_ID                   =>  :user
            , I_YEAR                      =>  :year
            , I_INTERFACE_TYPE_CODE       =>  :type
            , I_GROUP_ID                  =>  :group_id
            , I_INVOICE_DATE              =>  to_char(to_date(:date, 'dd/mm/yyyy'), 'DD-MON-YYYY')
            , O_BATCH_NO                  =>  :lv_batch_no
            , O_RETURN_STATUS             =>  :lv_return_status
            , O_RETURN_MSG                =>  :lv_return_msg
            );
            
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);
            commit;
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        logger($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        $stmt->bindParam(':group_id', $group_id, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function report($year, $type, $date, $user, $invoiceBatch) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
        lv_return_status      varchar2(100)   :=  NULL;
        lv_return_msg         varchar2(4000)  :=  NULL;
        lv_batch_no           varchar2(4000)  :=  NULL;
        BEGIN
            PTIR_WEB_UTILITIES_PKG.AP_REPORT_INTERFACE
            (
                I_USER_ID                   =>  :user
                , I_YEAR                    =>  :year
                , I_INTERFACE_TYPE_CODE     =>  :type
                , I_INVOICE_DATE            =>  to_char(to_date(:date, 'dd/mm/yyyy'), 'DD-MON-YYYY')
                , I_INVOICE_BATCH           =>  :invoice_batch
                , O_BATCH_NO                =>  :lv_batch_no
                , O_RETURN_STATUS           =>  :lv_return_status
                , O_RETURN_MSG              =>  :lv_return_msg
            );
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, \PDO::PARAM_STR);
        $stmt->bindParam(':invoice_batch', $invoiceBatch, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);

        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function apBatch($programCode, $invoiceDate) 
    {
        $userId = \Auth::user()->user_id;
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            declare
                v_invoice_batch  varchar2(1000) ;
                lv_return_status      varchar2(100)   :=  NULL;
                lv_return_msg         varchar2(4000)  :=  NULL;
                begin
                    :v_invoice_batch := ptir_web_utilities_pkg.get_invoice_batch(
                                                        p_user_id => {$userId}
                                                        , p_program_code => '{$programCode}'
                                                        , p_invoice_date => '{$invoiceDate}'
                                                        , O_RETURN_STATUS => :lv_return_status
                                                        , O_RETURN_MSG   => :lv_return_msg
                                                    );
                    dbms_output.put_line('v_invoice_batch = '|| :v_invoice_batch);
                end;
        ";
        // logger($sql);
        $result = [];
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_invoice_batch', $result['v_invoice_batch'], \PDO::PARAM_STR, 1000);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
