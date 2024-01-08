<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmConvertTransaction extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'ptpm_convert_transactions';
    public $primaryKey = 'convert_tran_id';
    public $timestamps = false;


    public function interface($profile, $batchNo)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status            varchar2(10);
                v_err_msg            varchar2(2000);
            begin
                ptpm_pmp0060_pkg.main_process(  p_program_code => 'PMP0060',
                                                p_user_name => '{$profile->fnd_user_name}',
                                                p_web_batch_no => '{$batchNo}',
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error : ' || v_err_msg);
            end;
        ";

        \Log::info("PMP0060 : {$batchNo} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("PMP0060 : {$batchNo} INF", [$result]);

        return $result;
    }

    public function insertCancelTrans($lineTrans, PtpmWipRequestHeader $header)
    {
        $sysdate = now();
        foreach ($lineTrans as $key => $lineTran) {
            $newLine = $lineTran->replicate();
            $newLine->transaction_quantity     = $lineTran->transaction_quantity ? $lineTran->transaction_quantity * -1 : 0;
            $newLine->created_at               = $sysdate;
            $newLine->creation_date            = $sysdate;
            $newLine->updated_at               = $sysdate;
            $newLine->last_update_date         = $sysdate;
            $newLine->web_batch_no             = $header->web_batch_no;

            $newLine->transaction_header_id     = null;
            $newLine->interface_status          = null;
            $newLine->interface_msg             = null;
            $newLine->save();
        }

    }
}
