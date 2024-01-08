<?php

namespace App\Models\Planning\OverTimesPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPlanBudget extends Model
{
    use HasFactory;
    protected $table = "oapp.ptpp_overtime_budgets";

    public function getNextSeqResPlan()
    {
        $nextSeqBatches = \DB::select("select oapp.ptpp_overtime_budget_s.nextval from dual");
        return ['seqResPlan' => $nextSeqBatches[0]];
    }
}
