<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtglCoaDeptCodeV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.PTGL_COA_DEPT_CODE_V';
    public $timestamps = false;

    protected $guarded = [];
}
