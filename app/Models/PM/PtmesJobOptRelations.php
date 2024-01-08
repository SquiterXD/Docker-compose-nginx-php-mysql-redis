<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtmesJobOptRelations extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAMES.ptmes_job_opt_relations';
    protected $primaryKey = 'batch_no';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'opt',
        'opt_status',
    ];

//    protected $casts = [
//        'used_date' => DateCast::class,
//    ];
}
