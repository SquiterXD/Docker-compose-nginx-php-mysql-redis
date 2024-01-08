<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AAModelScaffold extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TABLE_NAME_GOES_HERE';
    public $timestamps = false;

    protected $fillable = [
        'field_date'
    ];


    protected $casts = [
        'field_date' => DateCast::class,
    ];
}
