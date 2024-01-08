<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PnHolidayModel extends Model
{
    use HasFactory;
    protected $table = "PN_HOLIDAY";
    public $primaryKey = 'pn_holiday_id';
    public $timestamps = false;
}
