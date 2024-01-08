<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmConfirmBatchLossV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_confirm_batch_loss_v';
    public $timestamps = false;
    protected $casts = [
        'transaction_date' => DateCast::class,
    ];
}
