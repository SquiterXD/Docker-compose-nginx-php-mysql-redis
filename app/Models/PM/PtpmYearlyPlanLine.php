<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmYearlyPlanLine extends Model
{
    use HasFactory;

    protected $table = 'PTPM_YEARLY_PLAN_LINE';
    public $primaryKey = 'yearly_line_id';
    public $timestamps = false;

    protected $fillable = [
        'yearly_header_id',
        'yearly_line_id',
        'organization_id',
        'inventory_item_id',
        'item_code',
        'description',
        'gain_loss_qty',
        'uom',
        'percent',
        'oct_req_qty',
        'oct_product_qty',
        'oct_buy_qty',
        'nov_req_qty',
        'nov_product_qty',
        'nov_buy_qty',
        'dec_req_qty',
        'dec_product_qty',
        'dec_buy_qty',
        'jan_req_qty',
        'jan_product_qty',
        'jan_buy_qty',
        'feb_req_qty',
        'feb_product_qty',
        'feb_buy_qty',
        'mar_req_qty',
        'mar_product_qty',
        'mar_buy_qty',
        'apr_req_qty',
        'apr_product_qty',
        'apr_buy_qty',
        'may_req_qty',
        'may_product_qty',
        'may_buy_qty',
        'jun_req_qty',
        'jun_product_qty',
        'jun_buy_qty',
        'jul_req_qty',
        'jul_product_qty',
        'jul_buy_qty',
        'aug_req_qty',
        'aug_product_qty',
        'aug_buy_qty',
        'sep_req_qty',
        'sep_product_qty',
        'sep_buy_qty',
        'total_qty',
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
        'interfac_msg'
    ];

    public function header()
    {
        return $this->belongsTo(PtpmYearlyPlanHeader::class, 'yearly_header_id', 'yearly_header_id');
    }


}