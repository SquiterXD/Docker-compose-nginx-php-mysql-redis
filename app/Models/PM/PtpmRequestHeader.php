<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\Lookup\PtpmRequestTransferStatus;
use App\Models\OrgOrganizationDefinition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpmRequestHeader extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_REQUEST_HEADERS';
    public $primaryKey = 'request_header_id';
    public $timestamps = false;

    protected $casts = [
        'request_date' => DateCast::class,
        'send_date' => DateCast::class,
    ];

    protected $appends = [
        'can', 'case', 'request_date_format', 'send_date_format', 'is_other_objective', 'organization'
    ];

    protected $fillable = [
        'request_num',
        'request_number',
        'request_date',
        'request_status',
        'ingredient_group',
        'department_code',
        'send_date',
        'organization_id',
        'inventory_item_id',
        'work_step',
        'request_quantity',
        'maintenance_object_id',
        'attribute_category',
        'objective_code',
        'attribute1',
        'attribute2',
        'attribute3',
        'attribute4',
        'attribute5',
        'attribute6',
        'attribute7',
        'attribute8',
        'attribute9',
        'attribute10',
        'attribute11',
        'attribute12',
        'attribute13',
        'attribute14',
        'attribute15',
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'tran_id',
        'stg_no',
        'file_name',
        'record_status',
        'interfac_msg',
    ];

    public function ingredientGroup()
    {
        return $this
            ->hasMany(PtinvItemcatMatgroupV::class, 'type_code', 'ingedient_group');
    }

    public function status()
    {
        return $this->belongsTo(\App\Models\PM\Lookup\PtpmRequestTransferStatus::class, 'request_status','lookup_code');
    }

    public function getCaseAttribute()
    {
        return $this->attribute2 ?? 1;
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->save = true;
        $can->edit = true;
        $can->transfer = false;
        $can->cancel_transfer = false;

        if ($this->request_header_id) {

            switch ($this->request_status) {
                case '1': // ยังไม่ส่งข้อมูล
                    $can->save = true;
                    $can->edit = true;
                    $can->transfer = true;
                    $can->cancel_transfer = true;
                    break;
                case '2': // ส่งข้อมูลเรียบร้อย
                    $can->save = false;
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    break;
                case '3': // WMS ยืนยันการดึงข้อมูล
                    $can->save = false;
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    break;
                case '4': // ยกเลิกการขอเบิก
                    $can->save = false;
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
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

    function getRequestDateFormatAttribute()
    {
        if ($this->request_date) {
            return parseToDateTh($this->request_date);
        }
        return '';
    }

    function getSendDateFormatAttribute()
    {
        if ($this->send_date) {
            return parseToDateTh($this->send_date);
        }
        return '';
    }

    function getIsOtherObjectiveAttribute()
    {
        if ($this->objective_code) {
            return $this->objective_code == 3;
        }
        return false;
    }

    public function coaDeptCodeV(){
        return $this->belongsTo(PtglCoaDeptCodeV::class, 'department_code', 'department_code');
    }

    public function requestTransferStatus(){
        return $this->belongsTo(PtpmRequestTransferStatus::class, 'request_status', 'lookup_code');
    }

    function infWms()
    {
        $header = $this;
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTPM_WEB_PM_INF_WMS_PKG.main_process(
                    i_request_number     => '{$header->request_number}'
                    ,o_result            => :o_result
                );
                dbms_output.put_line(o_result);
            END;

        ";
        \Log::info('PMP0005 INF', [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['status'], PDO::PARAM_STR, 10);
        $stmt->execute();

        \Log::info('PMP0005 INF', [$result]);
        return $result;
    }
    
}
