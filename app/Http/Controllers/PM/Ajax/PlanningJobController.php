<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PM\PtmesBiWeeklyPlanJobV;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanningJobController extends Controller
{
    public function index()
    {
        $profile = getDefaultData('/pm/planning-jobs');
        $planningJobs = PtmesBiWeeklyPlanJobV::query()
            ->when(request()->year, function ($q) {
                $q->where('period_year', request()->year);
            })
            ->when(request()->month, function ($q) {
                //  $q->where('eng_month', request()->month);
            })
            ->when(request()->biweekly, function ($q) {
                $q->where('plan_biweekly', request()->biweekly);
            })
            ->when(request()->rev, function ($q) {
                $q->where('plan_revision_no', request()->rev);
            })
            ->when($profile->organization_id, function ($q) use ($profile) {
                $q->where('organization_id', $profile->organization_id);
            })
            ->orderBy('plan_date')
            ->get();

        $planningJob = $planningJobs->first();
        if (!$planningJob) {
            return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
        }

        $formattedDateRange = $this->_getMonthPeriod($planningJob);


        return response()->json([
            "dateRange" => $formattedDateRange,
            "groupBydates" => $planningJobs->groupBy(['plan_date']),
            "groupByMachineAndDates" => $planningJobs->groupBy(['machine', 'feeder', 'plan_date']),
        ]);
    }

    public function maxRev()
    {
        $profile = getDefaultData('/pm/planning-jobs');
        $biweekly =  \App\Models\PM\PtBiweeklyV::where('biweekly', request()->biweekly)
                        ->where('period_year', request()->year)
                        ->first();
        $data = PtmesBiWeeklyPlanJobV::query()
            ->when(request()->year, function ($q) {
                $q->where('period_year', request()->year);
            })
            ->when(request()->month, function ($q) {
                //  $q->where('eng_month', request()->month);
            })
            ->when(request()->biweekly, function ($q) {
                $q->where('plan_biweekly', request()->biweekly);
            })
            ->when($profile->organization_id, function ($q) use ($profile) {
                $q->where('organization_id', $profile->organization_id);
            })
            ->selectRaw("distinct thai_combine_date, plan_revision_no")
            ->orderBy("plan_revision_no", 'desc')
            ->first();

        return [
            'max_rev' => optional($data)->plan_revision_no ?? '',
            'thai_combine_date' => optional($biweekly)->thai_combine_date ?? '',
        ];

        return PtmesBiWeeklyPlanJobV::query()
            ->when(request()->year, function ($q) {
                $q->where('period_year', request()->year);
            })
            ->when(request()->month, function ($q) {
                //  $q->where('eng_month', request()->month);
            })
            ->when(request()->biweekly, function ($q) {
                $q->where('biweekly', request()->biweekly);
            })
            ->when($profile->organization_id, function ($q) use ($profile) {
                $q->where('organization_id', $profile->organization_id);
            })
            ->selectRaw("max(plan_revision_no) as max_rev")->first();
    }

    private function _getMonthPeriod($planningJob) {
        $biweekly =  \App\Models\Lookup\PtBiweeklyLookup::where('biweekly', $planningJob->plan_biweekly)
                        ->where('period_year', $planningJob->period_year)
                        ->first();
        $date = \Carbon\Carbon::parse($biweekly->start_date);

        $initDate = \Carbon\CarbonImmutable::today('UTC')
            // ->year($planningJob->period_year)
            // ->month($planningJob->month_number)
            // ->subYear()
            ->year($date->format('Y'))
            ->month($date->format('m'))
            ->day(1);

        if ($planningJob->plan_biweekly % 2 == 1) {
            // 1 - 15
            $firstDay = $initDate;
            $lastDay = $firstDay->day(15);
            $period = $firstDay->toPeriod($lastDay)->toArray();
        } else {
            // 16 - end of month
            $firstDay = $initDate->day(16);
            $lastDay = $firstDay->endOfMonth();

            $period = $firstDay->toPeriod($lastDay)->toArray();
        }

        // format dateRange
        $formattedDateRange = [];
        foreach ($period as $date) {
            $formattedDateRange[] = $date->toDateTimeString();
        }

        return $formattedDateRange;
    }
}
