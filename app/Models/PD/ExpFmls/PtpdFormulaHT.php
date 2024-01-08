<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdFormulaHT extends Model
{
    use HasFactory, Notifiable;


    protected $table = 'PTPD_FORMULA_H_T';
    public $primaryKey = 'fm_id';
    public $timestamps = false;

    protected $dates = [
        'formula_approval_date', 'formula_start_date',
        'formula_creation_date', 'formula_last_update_date'
    ];

    protected $appends = [
        'can',
        'formula_approval_date_format', 'formula_start_date_format',
        'formula_creation_date_format', 'formula_last_update_date_format'
    ];

    public function status()
    {
        return $this->belongsTo(PtpmCompleteStatus::class, 'wip_request_status','lookup_code');
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->edit = true;
        $can->transfer = true;
        $can->cancel_transfer = true;

        // if ($this->wip_request_status) {

        //     switch ($this->wip_request_status) {
        //         case '1': // ยังไม่ส่งข้อมูล
        //             $can->edit = true;
        //             $can->transfer = true;
        //             $can->cancel_transfer = true;
        //             break;
        //         case '2': // บันทึกผลผลิตเข้าคลังเรียบร้อย
        //             if ($this->interface_status) {
        //                 $can->edit = false;
        //                 $can->transfer = false;
        //                 $can->cancel_transfer = false;
        //                 break;
        //             }
        //         case '3': // ยกเลิกการบันทึกผลผลิตเข้าคลัง
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //         case '4': // ยกเลิกใบส่งผลผลิตเข้าคลัง
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
        $organizationId = $this->organization_id ?? getDefaultData()->organization_id;
        $data = OrgOrganizationDefinition::find($organizationId);
        return $data;
    }

    function getFormulaApprovalDateFormatAttribute()
    {
        if ($this->formula_approval_date) {
            return parseToDateTh($this->formula_approval_date);
        }
        return '';
    }


    function getFormulaStartDateFormatAttribute()
    {
        if ($this->formula_start_date) {
            return parseToDateTh($this->formula_start_date);
        }
        return '';
    }

    function getFormulaCreationDateFormatAttribute()
    {
        if ($this->formula_creation_date) {
            return parseToDateTh($this->formula_creation_date);
        }
        return '';
    }

    function getFormulaLastUpdateDateFormatAttribute()
    {
        if ($this->formula_last_update_date) {
            return parseToDateTh($this->formula_last_update_date);
        }
        return '';
    }
}
