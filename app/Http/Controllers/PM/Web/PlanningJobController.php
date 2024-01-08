<?php

namespace App\Http\Controllers\PM\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PM\PtmesBiWeeklyPlanJobV;

class PlanningJobController extends Controller
{
    public function index()
    {
        // $latestPlanningJob = PtmesBiWeeklyPlanJobV::query()
        //     ->orderBy('period_year', 'desc')
        //     ->orderBy('biweekly', 'desc')
        //     ->select('period_year', 'biweekly', 'eng_month', 'plan_revision_no')
        //     ->first();
        $latestPlanningJob = $requestStatusList = collect(\DB::select("
            SELECT
                pjh.period_year
                , pjh.biweekly
                , UPPER(to_char(bv.start_date, 'Month')) eng_month
                , plan_revision_no
            from ptpm_planning_job_headers pjh
                , pt_biweekly_v bv
            where 1=1
            and     pjh.period_year = bv.period_year
            and     pjh.biweekly = bv.biweekly
            and     pjh.interface_status = 'S'
            and     pjh.period_year =  TO_CHAR(sysdate, 'YYYY')
            order by pjh.period_year desc , pjh.biweekly desc
        "));

        if (count($latestPlanningJob)) {
            $latestPlanningJob = $latestPlanningJob->first();
        } else {
            $latestPlanningJob = collect([]);
        }

        return view("pm.planning-jobs.index", [
            'defaultSearch' =>  $latestPlanningJob,
        ]);
    }
}
