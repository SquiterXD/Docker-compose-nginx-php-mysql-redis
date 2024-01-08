<?php


namespace App\Models\PM\Settings;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\ItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RequestHeader extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_REQUEST_HEADERS';
    public $primaryKey = 'request_header_id';
    public $timestamps = false;

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

    protected $casts = [
        'request_date' => DateCast::class,
        'send_date' => DateCast::class,
    ];

    public function ingredientGroup()
    {
        return $this
            ->hasMany(ItemcatMatgroupV::class, 'type_code', 'ingedient_group');
    }
}
