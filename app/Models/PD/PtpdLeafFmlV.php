<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpdLeafFmlV extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPD_LEAF_FML_V';
}
