<?php


namespace App\Models\PD\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpditemTobaccoTypeV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpd_item_tobacco_type_v';
    public $timestamps = false;

    protected $fillable = [
    ];
}
