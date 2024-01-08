<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdBlendHistory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_BLEND_HISTORY';
    public $primaryKey = 'blend_history_id';
    public $timestamps = false;

}
