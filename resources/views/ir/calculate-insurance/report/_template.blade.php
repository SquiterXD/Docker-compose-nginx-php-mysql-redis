<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @include('ir.calculate-insurance.report._style')
    </head>
    <body>

        @php
            $sumActualCoverageAmount = 0;
            $sumInsuranceAmount = 0;
            $sumPaidAmount = 0;
            $sumRemainAmount = 0;
            $sumPeriodName1 = 0;
            $sumPeriodName2 = 0;
            $sumPeriodName3 = 0;
            $sumPeriodName4 = 0;
            $sumPeriodName5 = 0;
            $sumPeriodName6 = 0;
            $sumPeriodName7 = 0;
            $sumPeriodName8 = 0;
            $sumPeriodName9 = 0;
            $sumPeriodName10 = 0;
            $sumPeriodName11 = 0;
            $sumPeriodName12 = 0;
            $sumAllPeriod = 0;
        @endphp

        @foreach ($groupDatas as $page => $assetGroups)

            <div style="margin-bottom: 1rem; font-size: 17.5px;">
                <div class="inline-block" style="width: 22%">
                    <div >
                        กรมธรรม์เลขที่ ชุด 
                        @foreach ($insuranceNos as $insuranceNo)
                            {{ $insuranceNo }}
                            {{ !$loop->last ? '-' : '' }}
                        @endforeach
                        ปี {{ $thYear }} 
                        @foreach ($companies as $company)
                            {{ $company->company_name }}
                            {{ !$loop->last ? 'และ' : '' }}
                        @endforeach
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 55%">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        รายงานทุนประกันแท้จริง และส่วนที่เหลือ (จ่ายเพิ่ม/รับคืน) 
                        @foreach ($stocks as $stock)
                            {{ $stock }}
                            {{ !$loop->last ? 'และ' : '' }}
                        @endforeach
                    </div>
                    <div>
                        ตั้งแต่วันที่ {{ $dateStart }} ถึงวันที่ {{ $dateEnd }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 22%">
                    <div>
                        วันที่ {{ date('d/m/').convertYearToBBE(date('Y')) }}
                    </div>
                    <div>
                        เวลา {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        หน้า {{ $page }}
                    </div>
                </div>
            </div>

            <table width="100%">
                <thead>
                    <tr>
                        <th rowspan="3" class="text-center" style="width:10%">
                            สถานที่/ทรัพย์สินที่เอาประกัน
                        </th>
                        <th rowspan="3" class="text-center">
                            ทุนประกัน <br> แท้จริง
                        </th>
                        <th colspan="16" class="text-center">
                            ค่าเบี้ยประกัน (อัตราเบี้ยประกัน {{ array_key_exists(0, $premiumRate) ? $premiumRate[0] : 0 }}%)
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="text-center">
                            แท้จริง
                        </th>
                        <th rowspan="2" class="text-center">
                            จ่ายแล้ว <br> 50%
                        </th>
                        <th rowspan="2" class="text-center">
                            ส่วนที่เหลือ <br> จ่ายเพิ่ม(รับคืน)
                        </th>
                        <th colspan="12" class="text-center">
                            งวดบัญชี
                        </th>
                        <th rowspan="2" class="text-center">
                            รวม <br> ต.ค. {{ (int)substr($thYear, -2)-1 }} - ก.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center">
                            ต.ค. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            พ.ย. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            ธ.ค. {{ (int)substr($thYear, -2)-1 }}
                        </th>
                        <th class="text-center">
                            ม.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.พ. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            มี.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            เม.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            พ.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            มิ.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ส.ค. {{ (int)substr($thYear, -2)}}
                        </th>
                        <th class="text-center">
                            ก.ย. {{ (int)substr($thYear, -2)}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assetGroups as $groupAsset => $groupDescriptions)
                        <tr>
                            <td style="font-weight: bold;">
                                {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                                {{ $groupAsset }}
                            </td>
                            <td>
                                {{-- ทุนประกันแท้จริง --}}
                            </td>
                            <td>
                                {{-- แท้จริง --}}
                            </td>
                            <td>
                                {{-- จ่ายแล้ว 50% --}}
                            </td>
                            <td>
                                {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                            </td>
                            <td>
                                {{-- ต.ค. 60 --}}
                            </td>
                            <td>
                                {{-- พ.ย. 60 --}}
                            </td>
                            <td>
                                {{-- ธ.ค. 60 --}}
                            </td>
                            <td>
                                {{-- ม.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ก.พ. 61 --}}
                            </td>
                            <td>
                                {{-- มี.ค. 61 --}}
                            </td>
                            <td>
                                {{-- เม.ย. 61 --}}
                            </td>
                            <td>
                                {{-- พ.ค. 61 --}}
                            </td>
                            <td>
                                {{-- มิ.ย. 61 --}}
                            </td>
                            <td>
                                {{-- ก.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ส.ค. 61 --}}
                            </td>
                            <td>
                                {{-- ก.ย. 61 --}}
                            </td>
                            <td>
                                {{-- รวม --}}
                            </td>
                        </tr>
                        @foreach ($groupDescriptions as $groupDescription => $lines)

                            @php
                                $sumActualCoverageAmount += $actualCoverageAmount = $lines->sum('actual_coverage_amount') * $rate;
                                $sumPeriodName1 += $periodName1 = round($lines->sum('period_name_1') * $rate, 2);
                                $sumPeriodName2 += $periodName2 = round($lines->sum('period_name_2') * $rate, 2);
                                $sumPeriodName3 += $periodName3 = round($lines->sum('period_name_3') * $rate, 2);
                                $sumPeriodName4 += $periodName4 = round($lines->sum('period_name_4') * $rate, 2);
                                $sumPeriodName5 += $periodName5 = round($lines->sum('period_name_5') * $rate, 2);
                                $sumPeriodName6 += $periodName6 = round($lines->sum('period_name_6') * $rate, 2);
                                $sumPeriodName7 += $periodName7 = round($lines->sum('period_name_7') * $rate, 2);
                                $sumPeriodName8 += $periodName8 = round($lines->sum('period_name_8') * $rate, 2);
                                $sumPeriodName9 += $periodName9 = round($lines->sum('period_name_9') * $rate, 2);
                                $sumPeriodName10 += $periodName10 = round($lines->sum('period_name_10') * $rate, 2);
                                $sumPeriodName11 += $periodName11 = round($lines->sum('period_name_11') * $rate, 2);
                                $sumPeriodName12 += $periodName12 = round($lines->sum('period_name_12') * $rate, 2);
                                $sumAllPeriod += $allPeriod = (
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

                                $sumInsuranceAmount += $insuranceAmount = $allPeriod; // $lines->sum('insurance_amount') * $rate;
                                $sumPaidAmount += $paidAmount = $policyHeaderId === '1' ? round($lines->sum('paid_amount'), 2) : $lines->sum('paid_amount');
                                $sumRemainAmount += $remainAmount = $insuranceAmount - $paidAmount;
                            @endphp
                
                            <tr>
                                <td>
                                    {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                                    &nbsp; {{ $groupDescription }}
                                </td>
                                <td class="text-right">
                                    {{-- ทุนประกันแท้จริง --}}
                                    {{ number_format($actualCoverageAmount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- แท้จริง --}}
                                    {{ number_format($insuranceAmount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- จ่ายแล้ว 50% --}}
                                    {{ number_format($paidAmount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                                    {{ number_format($remainAmount, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ต.ค. 60 --}}
                                    {{ number_format($periodName1, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- พ.ย. 60 --}}
                                    {{ number_format($periodName2, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ธ.ค. 60 --}}
                                    {{ number_format($periodName3, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ม.ค. 61 --}}
                                    {{ number_format($periodName4, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.พ. 61 --}}
                                    {{ number_format($periodName5, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- มี.ค. 61 --}}
                                    {{ number_format($periodName6, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- เม.ย. 61 --}}
                                    {{ number_format($periodName7, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- พ.ค. 61 --}}
                                    {{ number_format($periodName8, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- มิ.ย. 61 --}}
                                    {{ number_format($periodName9, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.ค. 61 --}}
                                    {{ number_format($periodName10, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ส.ค. 61 --}}
                                    {{ number_format($periodName11, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- ก.ย. 61 --}}
                                    {{ number_format($periodName12, 2) }}
                                </td>
                                <td class="text-right">
                                    {{-- รวม --}}
                                    {{ number_format($allPeriod, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    
                    @if ($loop->last)
                        <tr>
                            <td>
                                {{-- สถานที่/ทรัพย์สินที่เอาประกัน --}}
                            </td>
                            <td class="text-right">
                                {{-- ทุนประกันแท้จริง --}}
                                {{ number_format($sumActualCoverageAmount, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- แท้จริง --}}
                                {{ number_format($sumInsuranceAmount, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- จ่ายแล้ว 50% --}}
                                {{ number_format($sumPaidAmount, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ส่วนที่เหลือ จ่ายเพิ่ม(รับคืน) --}}
                                {{ number_format($sumInsuranceAmount - $sumPaidAmount, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ต.ค. 60 --}}
                                {{ number_format($balance[1] ?: $sumPeriodName1, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- พ.ย. 60 --}}
                                {{ number_format($balance[2] ?: $sumPeriodName2, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ธ.ค. 60 --}}
                                {{ number_format($balance[3] ?: $sumPeriodName3, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ม.ค. 61 --}}
                                {{ number_format($balance[4] ?: $sumPeriodName4, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.พ. 61 --}}
                                {{ number_format($balance[5] ?: $sumPeriodName5, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- มี.ค. 61 --}}
                                {{ number_format($balance[6] ?: $sumPeriodName6, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- เม.ย. 61 --}}
                                {{ number_format($balance[7] ?: $sumPeriodName7, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- พ.ค. 61 --}}
                                {{ number_format($balance[8] ?: $sumPeriodName8, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- มิ.ย. 61 --}}
                                {{ number_format($balance[9] ?: $sumPeriodName9, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.ค. 61 --}}
                                {{ number_format($balance[10] ?: $sumPeriodName10, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ส.ค. 61 --}}
                                {{ number_format($balance[11] ?: $sumPeriodName11, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- ก.ย. 61 --}}
                                {{ number_format($balance[12] ?: $sumPeriodName12, 2) }}
                            </td>
                            <td class="text-right">
                                {{-- รวม --}}
                                {{ number_format($sumAllPeriod, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach

    </body>
</html>