<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMesReviewCompletesVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_MES_REVIEW_COMPLETES_V';
    public $incrementing = false;
    public $timestamps = false;
}
