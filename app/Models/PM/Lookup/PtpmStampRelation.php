<?php


namespace App\Models\PM\Lookup;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmStampRelation extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Stamp_Relation';
    public $timestamps = false;

    protected $guarded = [];
}
