<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirArInvoiceInterfaces extends Model
{
    use HasFactory;
    protected $table = "ptir_ar_invoice_interfaces";
    public $primaryKey = 'interface_id';

    protected $userId;

    public function __construct()
    {
       $this->userId = optional(auth()->user())->user_id ?? -1; 
    }

    public function scopeSearch($q, $param)
    {
        if ($param) {
            if ($param->claim_number) {
                $q->where('header_attribute9', 'like', '%'.$param->claim_number.'%');
                // $q->where('document_header_id', $param->claim_header_id);
            }

            if ($param->interface_type_code) {
                $q->where('from_program_code', $param->interface_type_code);
            }

            if ($param->status ) {
                $q->where('interface_status', $param->status);
            }else{
                $q;
            }

            if (isset($param->interface_year) && $param->from_program_code != 'IRP0005') {
                $q->where('interface_year', $param->interface_year);
            }

            // Add New Where by condition return interface
            if (isset($param->batch_no)) {
                $q->where('web_batch_no', $param->batch_no);
            }
        }
        return $q;
    }

    public function interfaceAr($interface_type_code, $documentNumber, $interfaceYear, $user) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_batch_no           varchar2(4000)  :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.AR_SEND_INTERFACE
            (
                I_USER_ID                 =>  :user
            , I_DOCUMENT_HEADER_ID        =>  :document_id
            , I_INTERFACE_TYPE_CODE       =>  :interface_type_code
            , I_YEAR                      =>  :interface_year
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
        logger($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':interface_type_code', $interface_type_code, \PDO::PARAM_STR);
        $stmt->bindParam(':document_id', $documentNumber, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        $stmt->bindParam(':interface_year', $interfaceYear, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function cancel($interface_type_code, $documentNumber, $user)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_batch_no           varchar2(4000)  :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.CANCEL_AR_INTERFACE
            (
                  I_USER_ID                   =>  :user
                , I_DOCUMENT_HEADER_ID        =>  :document_id
                , I_INTERFACE_TYPE_CODE       =>  :interface_type_code
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
        $stmt->bindParam(':interface_type_code', $interface_type_code, \PDO::PARAM_STR);
        $stmt->bindParam(':document_id', $documentNumber, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function report($interface_type_code, $documentNumber, $interfaceYear, $user) 
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_batch_no           varchar2(4000)  :=  NULL;
            BEGIN
            
                PTIR_WEB_UTILITIES_PKG.AR_REPORT_INTERFACE (
                    I_USER_ID                     =>  :user
                    , I_DOCUMENT_HEADER_ID        =>  :document_id
                    , I_INTERFACE_TYPE_CODE       =>  :interface_type_code
                    , I_YEAR                      =>  :interface_year
                    , O_BATCH_NO                  =>  :lv_batch_no
                    , O_RETURN_STATUS             =>  :lv_return_status
                    , O_RETURN_MSG                =>  :lv_return_msg
                );
                
                dbms_output.put_line('lv_return_status = '||lv_return_status);
                dbms_output.put_line('lv_return_msg = '||lv_return_msg);

            END; ";

        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':interface_type_code', $interface_type_code, \PDO::PARAM_STR);
        $stmt->bindParam(':document_id', $documentNumber, \PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        $stmt->bindParam(':interface_year', $interfaceYear, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_batch_no', $result['batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
