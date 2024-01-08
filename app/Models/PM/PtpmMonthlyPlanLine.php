<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmMonthlyPlanLine extends Model
{
    use HasFactory;

    protected $table = 'PTPM_MONTHLY_PLAN_LINE';
    public $primaryKey = 'monthly_line_id';
    public $timestamps = false;

    protected $fillable = [
        'monthly_header_id',
        'monthly_line_id',
        'organization_id',
        'product_item_id',
        'product_require_qty',
        'inventory_item_id',
        'weekly_used',
        'remaining',
        'request_onhand',
        'product_onhand',
        'print_onhand',
        'monthly_used',
        'onhand_uom',
        'ingredient_require_qty',
        'ingredient_request_qty',
        'ingredient_request_uom',
        'product_uom_qty',
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
        'item_system',
        'item_type',
        'total_onhand',
        'onhand_01',
        'subinventory_01',
        'onhand_02',
        'subinventory_02',
        'onhand_03',
        'subinventory_03',
        'onhand_04',
        'subinventory_04',
        'onhand_05',
        'subinventory_05',
        'onhand_06',
        'subinventory_06',
        'onhand_07',
        'subinventory_07',
        'onhand_08',
        'subinventory_08',
        'onhand_09',
        'subinventory_09',
        'onhand_10',
        'subinventory_10'
    ];

    public function header()
    {
        return $this->belongsTo(PtpmMonthlyPlanHeader::class, 'monthly_header_id', 'monthly_header_id');
    }

    public function productItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'product_item_id', 'inventory_item_id');
    }

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

}
