<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemWeight extends Model
{
    use HasFactory;

    protected $table = 'ptom_item_weights';
    protected $primaryKey = 'weight_id';

    protected $dates = ['start_date', 'end_date'];

    protected $appends = [
        'start_date_format',
        'end_date_format',
    ];

    public function uomV()
    {
        return $this->belongsTo(UOMV::class, 'uom', 'uom_code');
    }

    public function getStartDateFormatAttribute()
    {
        if (!$this->start_date) {
            return;
        }
        return ($this->start_date->format(trans('date.format-date')));
    }

    public function getEndDateFormatAttribute()
    {
        if (!$this->end_date) {
            return;
        }
        return ($this->end_date->format(trans('date.format-date')));
    }
}
