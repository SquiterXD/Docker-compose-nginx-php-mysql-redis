<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;

class GLCodeCombination extends Model
{
    //
    protected $table = 'ptie_gl_code_combinations_v';

    // public static function autoCombine($concatSegment,$orgId)
    // {
	// 	$result = DB::select(
    //         DB::raw("SELECT  XXAP_UTILITIES.AUTO_COMBINE_ACCOUNT(
    //         						P_I_CONCAT_SEGMENT => :concatSegment, 
    //         						P_ORG_ID => :orgId ) ccid
    //         						FROM DUAL" ),
    //     [
    //         'concatSegment' => $concatSegment,
    //         'orgId' => $orgId
    //     ]);

	// 	return $result;
    // }

    public static function callCheckGLValidationRule($data)
    {
        try {

            $db = DB::connection()->getPdo();

            $sql = "declare
                    v_status    varchar2(5);
                    v_err_msg   varchar2(2000);
                    begin
                     
                     xxweb_utilities.check_gl_rule( 
                            p_org_id                => :org_id,
                            p_concatenated_segments => :concatenated_segments,
                            p_segment1              => :segment1,
                            p_segment2              => :segment2,
                            p_segment3              => :segment3,
                            p_segment4              => :segment4,
                            p_segment5              => :segment5,
                            p_segment6              => :segment6,
                            p_segment7              => :segment7,
                            p_segment8              => :segment8,
                            p_segment9              => :segment9,
                            p_segment10             => :segment10,
                            p_segment11             => :segment11,
                            p_segment12             => :segment12,
                            p_status                => :v_status,
                            p_err_msg               => :v_err_msg);

                        dbms_output.put_line(v_status);
                        dbms_output.put_line(v_err_msg);

                    end;";

            $sql = preg_replace("/[\r\n]*/","",$sql);

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':org_id',$data['org_id'], PDO::PARAM_STR);
            $stmt->bindParam(':concatenated_segments',$data['concatenated_segments'], PDO::PARAM_STR);
            $stmt->bindParam(':segment1',$data['segment1'], PDO::PARAM_STR);
            $stmt->bindParam(':segment2',$data['segment2'], PDO::PARAM_STR);
            $stmt->bindParam(':segment3',$data['segment3'], PDO::PARAM_STR);
            $stmt->bindParam(':segment4',$data['segment4'], PDO::PARAM_STR);
            $stmt->bindParam(':segment5',$data['segment5'], PDO::PARAM_STR);
            $stmt->bindParam(':segment6',$data['segment6'], PDO::PARAM_STR);
            $stmt->bindParam(':segment7',$data['segment7'], PDO::PARAM_STR);
            $stmt->bindParam(':segment8',$data['segment8'], PDO::PARAM_STR);
            $stmt->bindParam(':segment9',$data['segment9'], PDO::PARAM_STR);
            $stmt->bindParam(':segment10',$data['segment10'], PDO::PARAM_STR);
            $stmt->bindParam(':segment11',$data['segment11'], PDO::PARAM_STR);
            $stmt->bindParam(':segment12',$data['segment12'], PDO::PARAM_STR);

            $stmt->bindParam(':v_status',$result['status'], PDO::PARAM_STR);
            $stmt->bindParam(':v_err_msg',$result['err_msg'], PDO::PARAM_STR, 2000);

            $stmt->execute();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    public static function autoCombine($concatSegment, $orgId)
    {
        try {

            $db = DB::connection()->getPdo();

            $sql = "DECLARE
                        lv_return_status          varchar2(100);
                        lv_return_msg             varchar2(4000);
                        lv_code_combination_id    varchar2(100);
                    BEGIN

                        PTIE_WEB_INF_APINVOICE_PKG.GET_ACCOUNT_ID(
                            i_org_id                    =>  :org_id
                            , i_account_combine         =>  :concatenated_segments
                            , o_code_combination_id     =>  :lv_code_combination_id
                            , O_RETURN_STATUS           =>  :lv_return_status
                            , O_RETURN_MSG              =>  :lv_return_msg
                        );    
                        
                        dbms_output.put_line('lv_code_combination_id = '||lv_code_combination_id);
                        dbms_output.put_line('lv_return_status = '||lv_return_status);
                        dbms_output.put_line('lv_return_msg = '||lv_return_msg);
                    END;";

            $sql = preg_replace("/[\r\n]*/","",$sql);

            $stmt = $db->prepare($sql);
            $result = [];
            $stmt->bindParam(':org_id', $orgId, PDO::PARAM_STR);
            $stmt->bindParam(':concatenated_segments', $concatSegment, PDO::PARAM_STR);

            $stmt->bindParam(':lv_return_status', $result['status'], PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_msg', $result['err_msg'], PDO::PARAM_STR, 4000);
            $stmt->bindParam(':lv_code_combination_id', $result['combination_id'], PDO::PARAM_STR, 100);

            $stmt->execute();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

}
