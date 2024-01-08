<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdFormulaBlendD extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPD.PTPD_FORMULA_BLEND_D';
    public $primaryKey = 'blend_detail_id';
    public $timestamps = false;

    protected $fillable = [
        'blend_detail_id',
        'blend_line_id',
        'inventory_item_id',
        'lot_number',
        'item_ratio',
        'adjust_cost_percent',
        'adjust_cost_bath',
        'after_adjust_cost',
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
}
