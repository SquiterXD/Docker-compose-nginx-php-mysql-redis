<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmSummaryBatchV extends Model
{
    use HasFactory;
    protected $table = 'PTPM_SUMMARY_BATCH_V';
    public $timestamps = false;

    protected $guarded = [];
    
}
