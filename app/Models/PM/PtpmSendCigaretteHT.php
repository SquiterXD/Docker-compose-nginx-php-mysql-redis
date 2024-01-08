<?php
namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\PtpmTransferObjective;
use App\Models\PM\PtpmTransferStatus;
use App\Models\OrgOrganizationDefinition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSendCigaretteHT extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPM_SEND_CIGARETTE_H_T';
    public $primaryKey = 'storage_header_id';
    public $timestamps = false;

    protected $dates = [ 'transaction_date'];

    protected $appends = [
        'can', 'transaction_date_format', 'organization'
    ];

    // public function objective()
    // {
    //     return $this->belongsTo(PtpmTransferObjective::class, 'transfer_objective','lookup_code');
    // }

    public function status()
    {
        return $this->belongsTo(PtpmSendCigaretteStatus::class, 'mfg_status','lookup_code');
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->edit = false;
        $can->transfer = false;
        $can->cancel_transfer = false;

        if ($this->interface_status != 'S') {
            $can->edit = true;
            $can->transfer = false;
            $can->cancel_transfer = false;
        }

        // if ($this->mfg_status) {

        //     switch ($this->mfg_status) {
        //         case '1': // ยังไม่ส่งข้อมูล
        //             $can->edit = true;
        //             $can->transfer = true;
        //             $can->cancel_transfer = true;
        //             break;
        //         case '2': // ส่งข้อมูลเรียบร้อย
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //         case '3': // WMS ยืนยันการดึงข้อมูล
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //         case '4': // ยกเลิกการขอเบิก
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //     }
        // }
        return $can;
    }

    function getOrganizationAttribute()
    {
        // $organizationId = $this->organization_id ?? getDefaultData()->organization_id;
        // $data = OrgOrganizationDefinition::find($organizationId);
        // return $data;
    }

    function getTransactionDateFormatAttribute()
    {
        if ($this->transaction_date) {
            return parseToDateTh($this->transaction_date);
        }
        return '';
    }
}
