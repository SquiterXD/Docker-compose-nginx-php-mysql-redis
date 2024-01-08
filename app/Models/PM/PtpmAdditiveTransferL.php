<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmAdditiveTransferL extends Model
{
    use HasFactory;

    protected $table = 'ptpm_additive_transfer_l';

    protected $primaryKey = 'additive_line_id';

    protected $fillable = [
        'department_code',
        'department_desc',
        'transfer_number',
        'organization_id',
        'inventory_item_id',
        'item_code',
        'item_description',
        'lot_number',
        'onhand_qty',
        'qty',
        'uom',
        'origination_date',
        'expire_date',
        'program_id',
        'web_batch_no',
    ];

    public function header()
    {
        return $this->belongsTo(PtpdExpandedTobaccoH::class, 'additive_header_id', 'additive_header_id');
    }
}
