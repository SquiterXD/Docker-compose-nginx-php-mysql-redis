<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Models\IR\PtirCalculateInsurances;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;
use App\Models\IR\Settings\PtirPolicyGroupSets;

use PDF;
use Carbon\Carbon;

class IRR0015Controller extends Controller
{
	public function export($programCode, $request)
    {
        $company = $request['company'];
        $policyHeaderId = $request['insuranceNo'];
        $thYear = (int)$request['year'] + 543;
        $year = $request['year'];

        $checkHasData = !!PtirCalculateInsurances::where('ptir_calculate_insurances.year', $year)->count();
        if(!$checkHasData){
            return "Warning : ไม่สามารถเรียกรายงานได้ เนื่องจากยังไม่มีการดึงข้อมูลที่หน้าจอ IRP0015 : คำนวณค่าเบี้ยประกันที่แท้จริง";
        }

        $queryDateStart = new Carbon(((int)$year - 1).'-09-30');
        $queryDateEnd = new Carbon($year.'-09-30');

        $companyCodes = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('company_code')
            ->groupBy('company_code')
            ->distinct()
            ->pluck('company_code')
            ->toArray();
        $companies = PtirCompanies::whereIn('company_number' , $companyCodes)->get();

        $rate = 100;
        if($companies->count() == 1){
            $rate = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->whereNotNull('company_code')
            ->first()
            ->percent_remaining;
        }
        $rate = ((int)$rate) / 100;

        $lineSet = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('line_id')
            ->groupBy('line_id')
            ->distinct()
            ->pluck('line_id')
            ->toArray();
        $premiumRate = PtirStockLines::select('premium_rate')->distinct()->whereIn('line_id', $lineSet)->pluck('premium_rate')->toArray();
        
        $dutyRate = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
        ->select('line_duty_percent')
        ->groupBy('line_duty_percent')
        ->distinct()
        ->pluck('line_duty_percent')
        ->first();

        $vatRate = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
        ->select('line_tax_percent')
        ->groupBy('line_tax_percent')
        ->distinct()
        ->pluck('line_tax_percent')
        ->first();

		$policyNumbers = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
        ->distinct()
        ->leftJoin('ptir_companies', 'ptir_companies.company_number', '=', 'ptir_calculate_insurances.company_code')
        ->leftJoin('ptir_policy_group_sets', 'ptir_policy_group_sets.policy_set_header_id', '=', 'ptir_calculate_insurances.policy_set_header_id')
        ->leftJoin('ptir_policy_group_headers', 'ptir_policy_group_headers.group_header_id', '=', 'ptir_policy_group_sets.group_header_id')
        ->leftJoin('ptir_policy_group_lines', 'ptir_policy_group_lines.group_header_id', '=', 'ptir_policy_group_headers.group_header_id')
        ->leftJoin('ptir_policy_group_dists', 'ptir_policy_group_dists.group_line_id', '=', 'ptir_policy_group_lines.group_line_id')
        ->whereNotNull('company_name')
        ->pluck('ptir_policy_group_dists.user_policy_number', 'ptir_companies.company_name');

        $insurances = self::getQueryMain($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId);

        $data = $insurances->where('ptir_calculate_insurances.type', 'IRP0002')
        ->get()
        ->groupBy([function ($item) {
            return $item->group_month;
        }, function ($item) {
            return $item->group_code;
        }, function ($item) {
            return $item->line_id;
        }]);

        $groupData = [];

        foreach ($data as $month => $groupPolicy) {
            foreach ($groupPolicy as $groupCode => $groupLine) {
                $groupData[$month][$groupCode] = collect();
                foreach ($groupLine as $lineId => $items) {
                    $groupData[$month][$groupCode]->push($items->first());
                }
            }
        }

        $insurances = self::getQueryMain($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId);

        $groupPolicy = $insurances->where('ptir_calculate_insurances.type', 'IRP0001')
        ->get()
        ->groupBy(function ($item) {
            return $item->group_code;
        });

        $paidData = [];
		$policyTaxFlag = [];

        foreach ($groupPolicy as $groupCode => $items) {
            $paidData[$groupCode] = $items;
			$policyTaxFlag[$groupCode] = $items->first()->include_tax_flag;
        }

        $insurances = self::getQueryMain($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId);

        $insuData = self::getQueryInsurance($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId, $rate);

        $insuAmount = $insuData['insurancePeriodAmount'];
        $paidAmount = $insuData['paidAmount'];

        $pdf = PDF::loadView('ir.reports.irr0015.index',
            compact(
                'year',
                'insurances',
                'insuAmount',
                'paidAmount',
                'groupData',
                'paidData',
                'rate',
                'premiumRate',
                'dutyRate',
                'vatRate',
				'policyTaxFlag',
				'policyNumbers'
            )
        )
        ->setPaper('a4')
        ->setOption('margin-bottom', 0);

        return $pdf->stream($programCode. '.pdf');
    }

    private static function getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
    {
        return PtirCalculateInsurances::where('ptir_calculate_insurances.year', $year)
        ->whereDate('ptir_calculate_insurances.insurance_start_date', '>=', $queryDateStart)
        ->whereDate('ptir_calculate_insurances.insurance_end_date', '<=', $queryDateEnd)
        ->when($company, function($q, $company) {
            $q->where(function($p) use ($company) {
                $p->where('ptir_calculate_insurances.company_code', $company)
                ->orWhereNull('ptir_calculate_insurances.company_code');
            });
        })
        ->when($policyHeaderId, function($q, $policyHeaderId){
            $q->where('ptir_calculate_insurances.policy_set_header_id', $policyHeaderId);
        });
    }

    private static function getQueryMain($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
    {
        return PtirCalculateInsurances::selectRaw("
            to_number(to_char(to_date( ptir_stock_lines.period_name, 'MON-YY'),'MM')) group_month,
            ptir_policy_set_headers.group_code,
            sum(ptir_stock_lines.coverage_amount) coverage_amount,
            sum(ptir_calculate_insurances.actual_coverage_amount) actual_coverage_amount,
            sum(ptir_calculate_insurances.insurance_amount) insurance_amount,
            sum(ptir_calculate_insurances.paid_amount) paid_amount,
            ptir_calculate_insurances.company_code,
            ptir_companies.company_name,
            ptir_calculate_insurances.percent_remaining,
            ptir_policy_set_headers.include_tax_flag
        ")
        ->leftJoin('ptir_stock_lines', 'ptir_stock_lines.line_id', '=', 'ptir_calculate_insurances.line_id')
        ->leftJoin('ptir_policy_set_headers', 'ptir_policy_set_headers.policy_set_header_id', '=', 'ptir_calculate_insurances.policy_set_header_id')
        ->leftJoin('ptir_companies', 'ptir_companies.company_number', '=', 'ptir_calculate_insurances.company_code')
        ->where('ptir_calculate_insurances.year', $year)
        ->whereDate('ptir_calculate_insurances.insurance_start_date', '>=', $queryDateStart)
        ->whereDate('ptir_calculate_insurances.insurance_end_date', '<=', $queryDateEnd)
        ->when($company, function($q, $company) {
            $q->where(function($p) use ($company) {
                $p->where('ptir_calculate_insurances.company_code', $company)
                ->orWhereNull('ptir_calculate_insurances.company_code');
            });
        })
        ->when($policyHeaderId, function($q, $policyHeaderId){
            $q->where('ptir_calculate_insurances.policy_set_header_id', $policyHeaderId);
        })
        ->groupByRaw("
            ptir_stock_lines.period_name
            ,ptir_policy_set_headers.group_code
            ,ptir_calculate_insurances.company_code
            ,ptir_companies.company_name
            ,ptir_calculate_insurances.percent_remaining
            ,ptir_policy_set_headers.include_tax_flag
        ")
        ->orderByRaw("group_month asc");
    }

    private function getQueryInsurance($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId, $rate)
    {
        $data = PtirCalculateInsurances::selectRaw("
                ptir_calculate_insurances.asset_group_code,
                ptir_calculate_insurances.stock_list_description,
                ptir_policy_set_headers.group_code,
                (select nvl(b.actual_coverage_amount, 0) 
                    from ptir_cal_actual_coverage_v b
                    where b.asset_group_code = ptir_calculate_insurances.asset_group_code
                    and b.stock_list_description = ptir_calculate_insurances.stock_list_description
                ) actual_coverage_amount,
                sum(ptir_calculate_insurances.insurance_amount) insurance_amount,
                sum(ptir_calculate_insurances.paid_amount) paid_amount,
                sum(ptir_calculate_insurances.period_name_1) period_name_1,
                sum(ptir_calculate_insurances.period_name_2) period_name_2,
                sum(ptir_calculate_insurances.period_name_3) period_name_3,
                sum(ptir_calculate_insurances.period_name_4) period_name_4,
                sum(ptir_calculate_insurances.period_name_5) period_name_5,
                sum(ptir_calculate_insurances.period_name_6) period_name_6,
                sum(ptir_calculate_insurances.period_name_7) period_name_7,
                sum(ptir_calculate_insurances.period_name_8) period_name_8,
                sum(ptir_calculate_insurances.period_name_9) period_name_9,
                sum(ptir_calculate_insurances.period_name_10) period_name_10,
                sum(ptir_calculate_insurances.period_name_11) period_name_11,
                sum(ptir_calculate_insurances.period_name_12) period_name_12
            ")
            ->leftJoin('ptir_policy_set_headers', 'ptir_policy_set_headers.policy_set_header_id', '=', 'ptir_calculate_insurances.policy_set_header_id')
            ->where('ptir_calculate_insurances.year', $year)
            ->whereDate('ptir_calculate_insurances.insurance_start_date', '>=', $queryDateStart)
            ->whereDate('ptir_calculate_insurances.insurance_end_date', '<=', $queryDateEnd)
            ->when($company, function($q, $company) {
                $q->where(function($p) use ($company) {
                    $p->where('ptir_calculate_insurances.company_code', $company)
                    ->orWhereNull('ptir_calculate_insurances.company_code');
                });
            })
            ->when($policyHeaderId, function($q, $policyHeaderId){
                $q->where('ptir_calculate_insurances.policy_set_header_id', $policyHeaderId);
            })
            ->orderBy('ptir_calculate_insurances.asset_group_code')
            ->orderBy('ptir_calculate_insurances.stock_list_description')
            ->groupBy('ptir_calculate_insurances.asset_group_code')
            ->groupBy('ptir_calculate_insurances.stock_list_description')
            ->groupBy('ptir_policy_set_headers.group_code')
            ->get()
            ->groupBy([function ($item) {
                return $item->group_code;
            }, function ($item) {
                return optional($item->assetGroup)->description;
            }, function ($item) {
                return $item->stock_list_description;
            }]);

        $sumAllPeriod = [
            'CENTRAL' => 0,
            'REGION' => 0
        ];

        $sumPaidAmount = [
            'CENTRAL' => 0,
            'REGION' => 0
        ];

        foreach ($data as $groupCode => $groupAsset) {
            foreach ($groupAsset as $assetGroup => $groupDescriptions) {
                foreach ($groupDescriptions as $groupDescription => $lines) {

                    $periodName1 = round($lines->sum('period_name_1') * $rate, 2);
                    $periodName2 = round($lines->sum('period_name_2') * $rate, 2);
                    $periodName3 = round($lines->sum('period_name_3') * $rate, 2);
                    $periodName4 = round($lines->sum('period_name_4') * $rate, 2);
                    $periodName5 = round($lines->sum('period_name_5') * $rate, 2);
                    $periodName6 = round($lines->sum('period_name_6') * $rate, 2);
                    $periodName7 = round($lines->sum('period_name_7') * $rate, 2);
                    $periodName8 = round($lines->sum('period_name_8') * $rate, 2);
                    $periodName9 = round($lines->sum('period_name_9') * $rate, 2);
                    $periodName10 = round($lines->sum('period_name_10') * $rate, 2);
                    $periodName11 = round($lines->sum('period_name_11') * $rate, 2);
                    $periodName12 = round($lines->sum('period_name_12') * $rate, 2);
                    $sumAllPeriod[$groupCode] += (
                        $periodName1
                        +$periodName2
                        +$periodName3
                        +$periodName4
                        +$periodName5
                        +$periodName6
                        +$periodName7
                        +$periodName8
                        +$periodName9
                        +$periodName10
                        +$periodName11
                        +$periodName12
                    );
                    $sumPaidAmount[$groupCode] += $groupCode === 'CENTRAL' ? round($lines->sum('paid_amount'), 2) : $lines->sum('paid_amount');
                }
            }
        }

        $data = collect();

        $data->put('insurancePeriodAmount', $sumAllPeriod);
        $data->put('paidAmount', $sumPaidAmount);

        return $data;
    }
}
