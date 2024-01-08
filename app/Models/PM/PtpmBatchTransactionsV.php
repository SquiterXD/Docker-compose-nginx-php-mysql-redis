<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmBatchTransactionsV extends Model
{
    use HasFactory;

    protected $table = 'PTPM_BATCH_TRANSACTIONS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function uomCode()
    {
        return $this->belongsTo(PtInvUomV::class, 'transaction_uom', 'uom_code');
    }
    
}
