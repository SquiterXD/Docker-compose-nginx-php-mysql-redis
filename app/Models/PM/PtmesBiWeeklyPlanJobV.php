<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtmesBiWeeklyPlanJobV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAMES.ptmes_biweekly_plan_jobs_v';
    // protected $primaryKey = 'batch_no';
    public $incrementing = false;
    public $timestamps = false;
    protected $appends = [
        'plan_quantity_format',
    ];


    public function getMonthNumberAttribute()
    {
        $months = [
            "JANUARY","FEBRUARY","MARCH",
            "APRIL","MAY","JUNE",
            "JULY","AUGUST","SEPTEMBER",
            "OCTOBER","NOVEMBER","DECEMBER",
        ];
        $key =  array_search($this->eng_month, $months);
        if($key == false) {
            throw new \Exception('Month not found');
        }

        return $key + 1;
    }

    public function getPlanQuantityFormatAttribute()
    {
        return number_format($this->plan_quantity ?? 0, 2);
    }
}
