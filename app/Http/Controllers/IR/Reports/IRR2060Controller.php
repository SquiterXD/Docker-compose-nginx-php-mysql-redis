<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Models\IR\PtirCalculateInsurances;
use App\Models\IR\Settings\PtirCompanies;

use PDF;
use Carbon\Carbon;

class IRR2060Controller extends Controller
{
    public function export($programCode, $request)
    {
        $company = $request['company'];
        $policyHeaderId = $request['insuranceNo'];
        $thYear = (int)$request['year'] + 543;
        $year = $request['year'];

        $queryDateStart = new Carbon(((int)$year - 1).'-09-30');
        $queryDateEnd = new Carbon($year.'-09-30');

        $insurances = PtirCalculateInsurances::where('year', $year)
            ->where('interface_status', 'S')
            ->where('insurance_start_date', '>=', $queryDateStart)
            ->where('insurance_end_date', '<=', $queryDateEnd)
            ->when($company, function($q, $company) {
                $q->where(function($p) use ($company) {
                    $p->where('company_code', $company)
                    ->orWhereNull('company_code');
                });
            })
            ->when($policyHeaderId, function($q, $policyHeaderId){
                $q->where('policy_set_header_id', $policyHeaderId);
            })
            ->with('header', 'line', 'company', 'assetGroup')
            ->orderBy('asset_group_code')
            ->orderBy('stock_list_description')
            ->get();

        $dateStart = '30 กันยายน '.((int)$year - 1 + 543);
        $dateEnd = '30 กันยายน '.((int)$year + 543);

        $insuranceNos = $insurances->map(function($item){
            return $item->policy ? $item->policy->policy_set_number : null;
        })->unique()->filter(function ($value, $key) {
            return $value != null;
        })->sort()->toArray();

        $companies = PtirCompanies::whereIn('company_number' , $insurances->pluck('company_code'))->get();

        $rate = 100;
        if($companies->count() == 1){
            $rate = $insurances->whereNotNull('company_code')->first()->percent_remaining;
        }
        $rate = ((int)$rate) / 100;

        $stocks = $insurances->map(function($item){
            return $item->header ? $item->header->policy_set_description : null;
        })->unique()->filter(function ($value, $key) {
            return $value != null;
        })->toArray();

        $premiumRate = $insurances->map(function($item){
            return $item->line ? (float)$item->line->premium_rate : null;
        })->unique()->filter(function ($value, $key) {
            return $value != null;
        })->toArray();
        
        $data = $insurances->groupBy([function ($item) {
            return $item->assetGroup ? $item->assetGroup->description : null;
        }, function ($item) {
            return $item->stock_list_description;
        }]);

        $groupDatas = [];
        $maxLine = 19;
        $page = 1;
        $lineNum = 0;

        foreach ($data as $assetGroup => $groupDescriptions) {
            if($lineNum >= $maxLine){
                $lineNum = 0;
                $page++;
            }
            $lineNum++;
            foreach ($groupDescriptions as $groupDescription => $lines) {
                if($lineNum >= $maxLine){
                    $lineNum = 1;
                    $page++;
                }
                $lineNum++;
                $groupDatas[$page][$assetGroup][$groupDescription] = $lines;
            }
        }

        $pdf = PDF::loadView('ir.reports.irr2060._template', 
            compact(
                'insurances',
                'groupDatas',
                'dateStart',
                'dateEnd',
                'thYear',
                'premiumRate',
                'insuranceNos',
                'stocks',
                'rate',
                'companies',
            ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream($programCode. '.pdf');
    }
}
