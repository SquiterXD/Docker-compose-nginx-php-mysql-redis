<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmProductTransferL extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'PTPM_PRODUCT_TRANSFER_L';
    public $primaryKey = 'transfer_line_id';
    public $timestamps = false;

    protected $fillable = [
        'organization_id_to', 'subinventory_to', 'locator_id_to', 'created_by', 'created_by_id', 'created_at', 'creation_date', 'program_code'
    ];

    protected $casts = [
    ];

    public function header()
    {
        return $this->belongsTo(\App\Models\PM\PtpmProductTransferH::class, 'transfer_header_id','transfer_header_id');
    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function uomCode()
    {
        return $this->belongsTo(PtInvUomV::class, 'transaction_uom', 'uom_code');
    }

}
