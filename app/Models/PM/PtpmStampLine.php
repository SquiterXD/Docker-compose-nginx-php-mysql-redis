<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmStampLine extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_STAMP_LINE';
//    protected $primaryKey = ['USED_DATE', 'MACHINE_GROUP', 'DESCRIPTION1', 'LAST_NUMBER'];
    protected $primaryKey = 'stamp_line_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'used_date',
        'machine_group',
        'description1',
        'roll_num',
        'core_code',
        'last_number',
        'current_number',
        'empty',
        'not_used',
        'remaining',
        'created_at',
        'updated_at',
        'created_by_id',
        'updated_by_id',
        'stamp_header_id',
        'inventory_item_id',
    ];

//    protected $casts = [
//        'used_date' => DateCast::class,
//    ];
}
