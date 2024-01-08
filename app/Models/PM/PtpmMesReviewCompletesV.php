<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesReviewCompletesV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_MES_REVIEW_COMPLETES_V';
    public $incrementing = false;
    public $timestamps = false;

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id')
            ->select(['blend_no']);
    }
}
