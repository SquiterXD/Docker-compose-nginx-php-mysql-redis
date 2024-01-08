<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBalanceReport extends Model
{
    use HasFactory;

    protected $table = "oair.ptir_car_balance_report";

    public function vehicle()
    {
        return $this->belongsTo('App\Models\IR\Views\PtirVehiclesView', 'license_plate', 'license_plate');
    }
}
