<?php

namespace App\Models\PM;

use \App\Models\PM\PtpmWipStepByBatchV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductLine extends Model
{
    use HasFactory;
    protected $table = 'ptmes_product_line';
    // protected $primaryKey = ['wip_step', 'product_date'];
    // protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    // protected $primaryKey ='WIP_STEP';
    protected $primaryKey = null;
    // protected $fillable = ['transfer_qty','transfer_wip','receive_wip'];


    protected $appends =[
        'product_date_format',
        'product_date_original'
    ];
    protected $casts = ['product_date' => 'datetime:d/m/Y'];


    protected $fillable = [
        'batch_id',
        'department_code',
        'organization_id',
        'inventory_item_id',
        'wip_step',
        'product_qty',
        'loss_qty',
        'transfer_qty',
        'uom',
        'transaction_flag',
        'product_date',
        'program_id',
        'transfer_wip',
        'receive_wip',
        'example_qty',
        'attribute2',
        'attribute12'
    ];

    //TODO: pls do not add Accessors & Mutators to model. because can affected other page logic
//    public function getTransferQtyAttribute($value)
//    {
//        return ($this->transaction_flag == 'Y' || $this->transaction_flag == true) ? $value : 0;
//    }
//
//    public function getTransactionFlagAttribute($value)
//    {
//        return $value === 'Y';
//    }

    function getProductDateFormatAttribute()
    {
        if($this->product_date){
            return parseToDateTh($this->product_date);
        }
        return '';
    }

    function getProductDateOriginalAttribute()
    {
        if($this->product_date){
            return $this->product_date->format('Y-m-d');
        }
        return '';
    }

    function getReceiveWipAttribute($value)
    {
        $data = PtpmWipStepByBatchV::selectRaw("
                        sum(nvl(confirm_qty, 0)) - sum(nvl(confirm_issue_qty, 0)) beginning_qty
                    ")
                    ->where('wip_step', $this->wip_step)
                    ->where('organization_id', $this->organization_id)
                    ->where('batch_id', $this->batch_id)
                    ->whereDate('transaction_date', '<', $this->product_date)
                    ->first();

        if ($data) {
            return $data->beginning_qty ?? 0;
        }
        return 0;
    }

    public function ptmes_product_distributions()
    {
        return $this->hasMany(PtmesProductDistribution::class,'BATCH_ID');
    }

    public function ptmes_product_header()
    {
        return $this->belongsTo(PtmesProductHeader::class,'BATCH_ID','BATCH_ID');
    }
}
