<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMPlanV extends Model
{
    use HasFactory;
    protected $table = "PTPP_PM_PLAN_V";

    public function checkPmWipEntity($date, $machine)
    {
        $date = date('Y-m-d', strtotime($date));
        $data = self::selectRaw('distinct plan_id, year_plan, year_plan_en, status_plan, asset_number, asset_desc, scheduled_start_date, scheduled_completion_date, version_plan')
                    ->where('asset_number', $machine)
                    // ->where('status_plan', 'Confirm')
                    ->whereRaw("TO_DATE('{$date}', 'RRRR-MM-DD') BETWEEN trunc(scheduled_start_date) and trunc(scheduled_completion_date)")
                    ->orderBy('version_plan', 'desc')
                    ->first();
        return $data? $data: [];
    }

    public function checkPmWipEntityByBiweekly($date, $machine)
    {
        $date = date('d-M-Y', strtotime($date));
        $data = self::selectRaw('distinct year_plan, year_plan_en, status_plan, asset_number, asset_desc, scheduled_start_date, scheduled_completion_date, version_plan')
                    ->where('asset_number', $machine)
                    // ->where('status_plan', 'Confirm')
                    ->whereRaw("TO_DATE('{$date}', 'RRRR-MM-DD') BETWEEN trunc(scheduled_start_date) and trunc(scheduled_completion_date)")
                    ->orderBy('version_plan', 'desc')
                    ->first();
        return $data? $data: [];
    }
}
