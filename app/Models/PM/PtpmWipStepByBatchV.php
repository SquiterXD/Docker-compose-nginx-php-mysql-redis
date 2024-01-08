<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmWipStepByBatchV extends Model
{

    protected $table = 'oapm.ptpm_wip_step_by_batch_v';
    public $timestamps = false;

    protected $casts = [
        'transaction_date' => DateCast::class,
    ];

    protected $guarded = [
    ];
}
