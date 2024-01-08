<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtqmMain extends Model
{
    use HasFactory;

    public static function getOrganizationId($programCode)
    {
        $result = DB::select( DB::raw("SELECT ptqm_main.find_organization(p_program_code => '{$programCode}') as organization_id from dual") );
        $organizationId = $result ? $result[0]->organization_id : null;

        return $organizationId;
    }

    public static function getSampleStatusColor($sampleNo)
    {
        $result = DB::select( DB::raw("SELECT ptqm_main.check_web_sample_status(p_sample_no => '{$sampleNo}') as sample_status_color from dual") );
        $sampleStatusColor = $result ? $result[0]->sample_status_color : "#FFFFFF";

        return $sampleStatusColor;
    }

    public static function createSample($pWebBatchNo, $pUsername)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_status                varchar2(5);
                        v_err_msg               varchar2(2000);
                        begin
                            ptqm_main.create_sample(p_web_batch_no => '{$pWebBatchNo}',
                                                p_user_name => '{$pUsername}',
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                            dbms_output.put_line('Status : ' || :v_status);
                            dbms_output.put_line('Error : ' || :v_err_msg);
                        end;
                    ";
        \Log::info($sql);

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }

    public static function addResult($pWebBatchNo, $pUsername)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_status                varchar2(5);
                        v_err_msg               varchar2(2000);
                        begin
                            ptqm_main.add_result(p_web_batch_no => '{$pWebBatchNo}',
                                                    p_user_name => '{$pUsername}',
                                                    p_status => :v_status,
                                                    p_err_msg => :v_err_msg);
                                dbms_output.put_line('Status : ' || :v_status);
                                dbms_output.put_line('Error : ' || :v_err_msg);
                        end;";

        \Log::info($sql);

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }

    public static function deleteAttachment($attachmentId)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                    v_status        varchar2(200);
                    v_err_msg       varchar2(2000);
                    begin
                        ptweb_utilities.del_attachment(p_attachment_id => {$attachmentId},
                                                        p_status => :v_status,
                                                        p_error_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error : ' || v_err_msg);
                    end;
                    ";
        \Log::info($sql);

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }

    public static function changeSampleStatus($pSampleNo, $pSampleStatus)
    {
        // -- pSampleStatus : APPROVE, REJECT

        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_status                varchar2(20);
                        v_msg                   varchar2(2000);
                        v_update_disp_rec       GMD_samples_grp.update_disp_rec;
                        begin
                            ptqm_main.change_sample_status(p_sample_no => '{$pSampleNo}',
                                                p_to_sample_status => '{$pSampleStatus}',
                                                p_status => :v_status,
                                                p_err_msg => :v_msg);
                            dbms_output.put_line('Status : ' || :v_status);
                            dbms_output.put_line('Error : ' || :v_msg);
                        end;
                    ";
        \Log::info($sql);

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }

}
