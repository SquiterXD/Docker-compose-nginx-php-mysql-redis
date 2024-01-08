<?php


namespace App\Models\PM;

use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\Lookup\PtpmItemNumberVLookup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class PtpmIngredientRequestL extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_ingredient_request_l';
    public $primaryKey = 'ingreq_line_id';
    public $timestamps = false;

    protected $fillable = [
        'ingreq_header_id',
        'ingreq_line_id',
        'request_item_id',
        'request_item',
        'description',
        'max_stock',
        'primary_uom',
        'request_qty',
        'secondary_uom',
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
        'program_id',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'tran_id',
        'stg_no',
        'file_name',
        'record_status',
        'interfac_msg',
    ];

    public function ptpmItemNumberV(): BelongsTo
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class, 'request_item', 'item_number');
    }

    public function ptpmItemConvUomV(): BelongsTo
    {
        return $this->belongsTo(PtpmItemConvUomVLookup::class, 'secondary_uom', 'uom_code');
    }

    protected $casts = [
    ];
}
