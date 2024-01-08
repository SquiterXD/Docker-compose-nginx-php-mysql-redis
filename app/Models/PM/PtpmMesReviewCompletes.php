<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesReviewCompletes extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_MES_REVIEW_COMPLETES';
    protected $primaryKey = ['batch_no', 'opt'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "organization_id",
        "silo",
        "batch_id",
        "batch_no",
        "opt",
        "inventory_item_id",
        "subinventory_code",
        "locator_id",
        "product_quantity",
        "uom_code",
        "tobacco_issue_flag",
        "flavor_issue_flag",
        'review_product_quantity',
        'transaction_date',
        'remark_msg',
    ];

//    protected $fillable = [
//        'batch_no',
//        'opt',
//        'product_quantity',
//        'review_product_quantity',
//        'uom_code',
//        'transaction_date',
//        'silo',
//        'tobacco_issue_flag',
//        'flavor_issue_flag',
//        'record_complete_flag',
//        'remark_msg',
//    ];

    protected $casts = [
    ];

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function summaryBatchV()
    {
        return $this->belongsTo(PtpmSummaryBatchV::class, 'subinventory_code', 'subinventory');
    }
}
