<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtieWebInfApInvoicePkg extends Model
{
    use HasFactory;
    
    public function getAccountId($accountCombine, $orgId = 81) {
	$db = DB::connection('oracle')->getPdo();
        $sql = "
		DECLARE
				lv_return_status          varchar2(100);
				lv_return_msg             varchar2(4000);
				lv_code_combination_id    varchar2(100);
			BEGIN

				PTIE_WEB_INF_APINVOICE_PKG.GET_ACCOUNT_ID(
				i_org_id                    =>  nvl(:org_id, 81)
				, i_account_combine         =>  :concatenated_segments
				, o_code_combination_id     =>  :lv_code_combination_id
				, O_RETURN_STATUS           =>  :lv_return_status
				, O_RETURN_MSG              =>  :lv_return_msg
				);    
				
				dbms_output.put_line('lv_code_combination_id = '||lv_code_combination_id);
				dbms_output.put_line('lv_return_status = '||lv_return_status);
				dbms_output.put_line('lv_return_msg = '||lv_return_msg);
			END;
        ";
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':org_id', $orgId, \PDO::PARAM_STR);
        $stmt->bindParam(':concatenated_segments', $accountCombine, \PDO::PARAM_STR);
        
        $stmt->bindParam(':lv_code_combination_id', $result['account_id'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }
    
}