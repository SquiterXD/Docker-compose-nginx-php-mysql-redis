<?php
namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\PtpmTransferObjective;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\OrgOrganizationDefinition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpmWipRequestHeader extends Model
{
    use HasFactory, Notifiable;


    protected $table = 'PTPM_WIP_REQUEST_HEADERS';
    public $primaryKey = 'wip_req_header_id';
    public $timestamps = false;

    protected $dates = [ 'transaction_date', 'wip_request_date'];

    protected $appends = [
        'can', 'transaction_date_format', 'wip_request_date_format', 'organization'
    ];

    // public function objective()
    // {
    //     return $this->belongsTo(PtpmTransferObjective::class, 'transfer_objective','lookup_code');
    // }

    public function status()
    {
        return $this->belongsTo(PtpmCompleteStatus::class, 'wip_request_status','lookup_code');
    }

    public function scopeIsInfWipCompleted($q)
    {
        return $q->where('wip_request_status', 2);
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->edit = true;
        $can->transfer = false;
        $can->cancel_transfer = false;
        $can->cancel_doc = false;

        if ($this->wip_request_status) {

            // switch ($this->interface_status) {
            //     case 'S': // ยังไม่ส่งข้อมูล
            //         $can->edit = false;
            //         $can->transfer = false;
            //         $can->cancel_transfer = false;
            //         break;
            // }

            switch ($this->wip_request_status) {
                case '1': // ยังไม่ส่งข้อมูล
                    $can->edit = true;
                    $can->transfer = true && $this->wip_req_header_id;
                    $can->transfer = true && $this->wip_req_header_id;
                    $can->cancel_transfer = false;
                    $can->cancel_doc = true;
                    break;
                case '2': // บันทึกผลผลิตเข้าคลังเรียบร้อย
                    if ($this->interface_status) {
                        $can->edit = false;
                        $can->transfer = false;
                        $can->cancel_transfer = true;
                        break;
                    }
                case '3': // ยกเลิกการบันทึกผลผลิตเข้าคลัง
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    $can->cancel_doc = true;
                    break;
                case '4': // ยกเลิกใบส่งผลผลิตเข้าคลัง
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    $can->cancel_doc = true;
                    break;
            }
        }
        return $can;
    }

    function getOrganizationAttribute()
    {
        $organizationId = $this->organization_id ?? getDefaultData()->organization_id;
        $data = OrgOrganizationDefinition::find($organizationId);
        return $data;
    }

    function getTransactionDateFormatAttribute()
    {
        if ($this->transaction_date) {
            return parseToDateTh($this->transaction_date);
        }
        return '';
    }

    function getWipRequestDateFormatAttribute()
    {
        if ($this->wip_request_date) {
            return parseToDateTh($this->wip_request_date);
        }
        return '';
    }


    function infWipComplete()
    {
        $profile = getDefaultData('/pm/wip-requests');
        $header = $this;
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status            varchar2(20);
                v_err_msg           varchar2(2000);
            begin
                ptpm_main.mes_complete_qty(P_PROGRAM_CODE => '{$header->program_code}',
                                            P_WEB_BATCH_NO => '{$header->web_batch_no}',
                                            P_USER_NAME => '{$profile->fnd_user_name}',
                                            P_STATUS => :v_status,
                                            P_ERR_MSG => :v_err_msg);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error msg : ' || v_err_msg);
            end;
        ";

        $header->interfaced_msg = $sql;
        $header->save();
        
        \Log::info("{$header->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['msg'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$header->web_batch_no} INF", [$result]);

        return $result;

    }

    public function scopeSearch($query, $keywords)
    {

        // wip_request_no
        if (array_key_exists("wip_request_no", $keywords)) {
            if ($keywords['wip_request_no']) {
                $query->where(function ($q) use ($keywords) {
                    $q->where('wip_request_no', 'like', '%' . $keywords['wip_request_no'] . '%');
                });
            }
        }
        
        // transaction_type_id
        if (array_key_exists("transaction_type_id", $keywords)) {
            if ($keywords['transaction_type_id']) {
                $query->where('transaction_type_id', $keywords['transaction_type_id']);
            }
        }

        // transaction_date_from
        if (array_key_exists("transaction_date_from", $keywords)) {
            if ($keywords['transaction_date_from']) {
                $query->where('transaction_date', '>=', parseFromDateTh($keywords['transaction_date_from'])." 00:00:00");
            }
        }
        // transaction_date_to
        if (array_key_exists("transaction_date_to", $keywords)) {
            if ($keywords['transaction_date_to']) {
                $query->where('transaction_date', '<=', parseFromDateTh($keywords['transaction_date_to'])." 23:59:59");
            }
        }

        return $query;

    }

}
