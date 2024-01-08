<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirWebUtilitiesPkg extends Model
{
    use HasFactory;

    public function genDocumentNumber($programCode, $headerId) {

        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_document_number    varchar2(100)   :=  NULL;
        BEGIN
        
            PTIR_WEB_UTILITIES_PKG.GENERATE_DOC_NUMBER
            (
              i_program_code          => :program_code                       
            , i_header_id             => :header_id                     
            , i_manual_prefix         =>  NULL
            , o_document_number       => :lv_document_number
            , O_RETURN_STATUS         => :lv_return_status 
            , O_RETURN_MSG            => :lv_return_msg 
            );
            
            dbms_output.put_line('lv_document_number = '||lv_document_number);
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':program_code', $programCode, \PDO::PARAM_STR);
        $stmt->bindParam(':header_id', $headerId, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_document_number', $result['document_number'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }

    public function getAccountId($accountCombine) {

        $db = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE
            lv_return_status      varchar2(100)   :=  NULL;
            lv_return_msg         varchar2(4000)  :=  NULL;
            lv_code_combination_id    varchar2(100)   :=  NULL;
            BEGIN
        
             PTIR_WEB_UTILITIES_PKG.GET_ACCOUNT_ID
            (
                 i_account_combine       => :account_combine
            ,    o_code_combination_id   => :lv_code_combination_id
            ,    O_RETURN_STATUS         => :lv_return_status 
            ,    O_RETURN_MSG            => :lv_return_msg
            );    
            
            dbms_output.put_line('lv_code_combination_id = '||lv_code_combination_id);
            dbms_output.put_line('lv_return_status = '||lv_return_status);
            dbms_output.put_line('lv_return_msg = '||lv_return_msg);
        END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':account_combine', $accountCombine, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_code_combination_id', $result['account_id'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }
}
