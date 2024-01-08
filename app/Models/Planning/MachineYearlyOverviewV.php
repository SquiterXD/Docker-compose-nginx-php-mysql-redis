<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planning\SetupPPV;

class MachineYearlyOverviewV extends Model
{
    // PPP0001
    use HasFactory;
    protected $table = "oapp.ptpp_machine_yearly_overview_v";

    public function __construct()
    {
        $org = SetupPPV::where('program_code', 'PTPP')->where('col_name', 'DEFAULT_OM_ORG_ID')->first();
        $this->orgId = optional($org)->col_value ?? 121;
    }

}
