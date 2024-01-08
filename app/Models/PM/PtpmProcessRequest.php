<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProcessRequest extends Model
{
    use HasFactory;

    protected $table = 'PTPM_PROCESS_REQUESTS';
    public $primaryKey = 'request_process_id';
    public $timestamps = false;

    public function ptpmItemNumberV()
    {
        return $this->belongsTo(Lookup\PtpmItemNumberV::class, 'inventory_item_id','inventory_item_id');
    }

    public function ptpmBatchStatus()
    {
        return $this->belongsTo(Lookup\PtpmBatchStatus::class, 'request_status','lookup_code');
    }

    public function ptpmItemConvUomV()
    {
        return $this->belongsTo(Lookup\PtpmItemConvUomV::class, 'request_uom','uom_code');
    }
}
