<?php

namespace App\Models\PM;

use App\Models\PM\FndLookupValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmDailyPlanLine extends Model
{
    use HasFactory;

    protected $table = 'PTPM_DAILY_PLAN_LINE';
    public $primaryKey = 'daily_plan_line_id';
    public $timestamps = false;

    protected $fillable = [
        'daily_plan_line_id','daily_plan_header_id','machine_name','plan_date','plan_time',
        'request_number','inventory_item_id','brand','product','qty','colors','source_plan_line_id', 'mes_starttime', 'mes_endtime',
        'attribute1','attribute2','attribute3','attribute4','attribute5','attribute6','attribute7',
        'attribute8','attribute9','attribute10','attribute11','attribute12','attribute13','attribute14',
        'attribute15','program_id','created_by','creation_date','last_updated_by','last_update_date','created_at',
        'updated_at','deleted_at','created_by_id','updated_by_id','deleted_by_id','web_batch_no','interface_status',
        'interfaced_msg','tran_id','stg_no','file_name','record_status','interfac_msg','machine_group','remark'
    ];

    public function header()
    {
        return $this->belongsTo(PtpmMonthlyPlanHeader::class, 'daily_plan_header_id', 'daily_plan_header_id');
    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }


    public function planTime()
    {
        return $this->belongsTo(FndLookupValue::class, 'plan_time', 'lookup_code')->getPrintMachineTimes();
    }
}
