<?php

namespace App\Models\pm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\GmeBatchHeader;

class PtpmSummaryBatch1V extends Model
{
    use HasFactory;

    protected $table = 'ptpm_summary_batch1_v';

    public function gmeBatchHeader()
    {
        return $this->belongsTo(GmeBatchHeader::class, 'batch_no', 'batch_no');
    }


}
