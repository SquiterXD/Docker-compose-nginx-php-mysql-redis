<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtpmPmp0052V extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PMP0052_V';
    public $timestamps = false;

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function uomCode()
    {
        return $this->belongsTo(PtInvUomV::class, 'uom_code', 'uom_code');
    }

    public static function callInsertLine($transferHeaderId, $transferInvItemLine, $toLocatorModel)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                    v_status            varchar2(50);
                    v_err_msg           varchar2(3000);
                    begin
                        ptpm_pmp0052_pkg.insert_line( p_transfer_header_id => '{$transferHeaderId}',
                                                    p_organization_id => '{$toLocatorModel->organization_id}',
                                                    p_subinv => '{$toLocatorModel->subinventory_code}',
                                                    p_locator_id => '{$toLocatorModel->inventory_location_id}',
                                                    p_item_id => '{$transferInvItemLine["inventory_item_id"]}',
                                                    p_qty => '{$transferInvItemLine["transaction_qty"]}',
                                                    p_uom_code => '{$transferInvItemLine["transaction_uom"]}',
                                                    p_status => :v_status,
                                                    p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || :v_status);
                        dbms_output.put_line('Error : ' || :v_err_msg);
                    end;";
        \Log::info('callInsertLine PMP0052', [$sql]);

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public static function callMainProcess($pWebBatchNo, $pUsername)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                    v_status            varchar2(50);
                    v_err_msg           varchar2(3000);
                    begin
                        ptpm_pmp0052_pkg.main_process( p_program_code => 'PMP0052',
                                                p_user_name => '{$pUsername}',
                                                p_web_batch_no => '{$pWebBatchNo}',
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || :v_status);
                        dbms_output.put_line('Error : ' || :v_err_msg);
                    end;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($sql, $result);

        return $result;
    }

    public static function subinvTransfer($pWebBatchNo, $pUsername)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                    v_status            varchar2(50);
                    v_err_msg           varchar2(3000);
                    begin
                        ptpm_pmp0052_pkg.subinv_transfer52( p_program_code => 'PMP0052',
                                                p_user_name => '{$pUsername}',
                                                p_web_batch_no => '{$pWebBatchNo}',
                                                p_cancel_flag => NULL,
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || :v_status);
                        dbms_output.put_line('Error : ' || :v_err_msg);
                    end;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($sql, $result);

        return $result;
    }

    public static function cancelSubinvTransfer($pWebBatchNo, $pUsername)
    {
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "declare
                    v_status            varchar2(50);
                    v_err_msg           varchar2(3000);
                    begin
                        ptpm_pmp0052_pkg.subinv_transfer52( p_program_code => 'PMP0052',
                                                p_user_name => '{$pUsername}',
                                                p_web_batch_no => '{$pWebBatchNo}',
                                                p_cancel_flag => 'Y',
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || :v_status);
                        dbms_output.put_line('Error : ' || :v_err_msg);
                    end;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info($sql, $result);

        return $result;
    }


}
