<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMesReviewJobLinesLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Mes_Review_Job_Lines';
    public $timestamps = false;

    protected $fillable = [
    ];
}
