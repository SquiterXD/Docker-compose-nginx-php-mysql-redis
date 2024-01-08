<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdFormulaWrap extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPD.PTPD_FORMULA_WRAP';
    public $primaryKey = 'wrap_id';
    public $timestamps = false;

    protected $fillable = [
        'wrap_id',
        'blend_id',
        'wrap_no',
        'description',
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
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'web_batch_no',
        'interfaced_msg',
        'interface_status',
    ];

    protected $casts = [
        'wrap_id' => 'integer',
        'blend_id' => 'integer',
        'wrap_no' => 'integer',
        'created_by_id' => 'integer',
        'updated_by_id' => 'integer',
    ];
}
