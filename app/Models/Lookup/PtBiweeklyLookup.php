<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtBiweeklyLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.pt_biweekly';
    public $timestamps = false;
    protected $fillable = [
    ];

    protected $appends = [
        'start_date_format', 'end_date_format'
    ];

    function getStartDateFormatAttribute()
    {
        if ($this->start_date) {
            return parseToDateTh($this->start_date);
        }
        return '';
    }

    function getEndDateFormatAttribute()
    {
        if ($this->end_date) {
            return parseToDateTh($this->end_date);
        }
        return '';
    }
}
