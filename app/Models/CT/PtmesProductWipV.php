<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtmesProductWipV extends Model
{
    use HasFactory;
    protected $table = 'PTPM_WIP_STEP_BY_BATCH_V';

    protected $casts = [
        // 'transaction_quantity' => 'date:Y-m-d',

    ];

}
