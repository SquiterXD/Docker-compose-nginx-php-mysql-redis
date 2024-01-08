<?php


namespace App\Models\PM\SprinkleTobaccos;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmSprinkleTobaccoHeader extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'oapm.ptpm_sprinkle_tobacco_headers';
    protected $primaryKey = 'sprinkle_header_id';
    public $timestamps = false;

    protected $appends = [
        'can', 'transaction_date_format', 'status_lable_html'
    ];

    public function lines()
    {
        return $this->hasMany(\App\Models\PM\PtpmSprinkleTobaccoLine::class, 'sprinkle_header_id', 'sprinkle_header_id');
    }

    function getTransactionDateFormatAttribute()
    {
        if ($this->transaction_date) {
            return parseToDateTh($this->transaction_date);
        }
        return '';
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->save = true;
        $can->transfer = false;
        $can->cancel_transfer = false;

        // if ($this->interface_status == 'S' && is_null($this->cancel_by_id)) {
        //     $can->cancel_misc_receipt = true;
        // }

        if ($this->sprinkle_header_id) {
            switch ($this->transfer_status) {
                case '1': // ยังไม่ส่งข้อมูลโรยยาเส้น
                    $can->save = true;
                    $can->transfer = true;
                    $can->cancel_transfer = true;
                    break;
                case '2': // ยืนยันการโรยยาเส้นเรียบร้อย
                    $can->save = false;
                    $can->transfer = false;
                    $can->cancel_transfer = true;
                    break;
                case '3': // ยกเลิกการโรยยาเส้น
                    $can->save = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    break;
            }
        }
        return $can;
    }

    function interface($header, $profile)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                v_status                varchar2(20);
                v_err_msg               varchar2(2000);
            BEGIN
                ptpm_main.pmp0055_process ( p_program_code => '{$header->program_code}',
                                        p_web_batch_no => '{$header->web_batch_no}',
                                        p_user_name => '{$profile->fnd_user_name}',
                                        p_status => :v_status,
                                        p_err_msg => :v_err_msg);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error : ' || v_err_msg);
            END;
        ";

        $header->description = $sql;
        $header->save();
        \Log::info("{$header->program_code} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$header->program_code} INF", [$result]);
        return $result;
    }


    public function getStatusLableHtmlAttribute()
    {
        $html = '';
        if (!is_null($this->cancel_by_id)) {
            $html = "<span class='label label-danger'>ยกเลิกรายการ</span>";
        }

        if ($this->interface_status == 'S' && is_null($this->cancel_by_id)) {
            $html = "<span class='label label-primary'>บันทึกรายการสำเร็จ</span>";
        }

        return $html;
    }

}
