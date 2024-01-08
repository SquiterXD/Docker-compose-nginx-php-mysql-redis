<?php


namespace App\Models\PD;

use App\Models\PtwUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdFormulaBlendH extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPD.PTPD_FORMULA_BLEND_H';
    public $primaryKey = 'blend_id';
    public $timestamps = false;

    protected $fillable = [
        'blend_id',
        'blend_num',
        'blend_exemple_no',
        'flag_price',
        'price_date',
        'taste',
        'blend_qty',
        'blend_uom',
        'ref_cost_cigarette_id',
        'ref_cost_cigarette_num',
        'ref_cost_cigarette_desc',
        'description',
        'remark',
        'status',
        'formula_type',
        'product_status',
        'approved_date',
        'start_date',
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
        //'deleted_by_id',
        //'created_by',
        //'creation_date',
        //'last_updated_by',
        //'last_update_date',
        'web_batch_no',
        'interfaced_msg',
        'interface_status',
    ];

    protected $casts = [
        'blend_qty' => 'float',
        'created_by_id' => 'integer',
        'updated_by_id' => 'integer',
    ];

    public function updatedByUser()
    {
        return $this->belongsTo(PtwUsers::class, 'updated_by_id', 'user_id');
    }

    public function tasteInfo()
    {
        return $this->belongsTo(PtpdBlendFlavour::class, 'taste', 'meaning');
    }
}
