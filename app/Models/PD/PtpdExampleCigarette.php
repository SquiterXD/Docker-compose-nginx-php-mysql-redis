<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\PD\Cast\DateCast;

class PtpdExampleCigarette extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapd.ptpd_example_cigarette';

    public $primaryKey = 'ex_cigarette_id';
    public $timestamps = false;

    protected $fillable = [
        'ex_cigarette_num',
        'description',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];

    protected $casts = [
        'creation_date' => DateCast::class,
    ];
}
