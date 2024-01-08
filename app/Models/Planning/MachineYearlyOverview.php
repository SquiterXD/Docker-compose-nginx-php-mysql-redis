<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineYearlyOverview extends Model
{
    // PPP0001 overview
    use HasFactory;
    protected $table = "oapp.ptpp_machine_yearly_overviews";
    protected $primaryKey = "overview_id";
}
