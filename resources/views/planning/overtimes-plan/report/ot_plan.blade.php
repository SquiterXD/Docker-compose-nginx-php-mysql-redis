<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์ </title>
    @include('planning.overtimes-plan.report._style')
</head>
<body>
    @php
        $page = 0;
        $pageFix = 0;
        $totalPage = count($departments)+1;
    @endphp
    @foreach ($departments as $department)
        @if (count($otPlanBiWeeklyTab1) > 0)
            @php
                $page++;
                $pageFix = $loop->last? $page+1: 0;
            @endphp
            <div style="page-break-after: always;"> </div>
            @include('planning.overtimes-plan.report.header')
            <div class="row col-12 text-center">
                <h3> ประมาณการงบค่าล่วงเวลา (เตรียมเครื่องจักร, กลางวัน, กลางคืน) {{ $department->department_name }} </h3>
            </div>
            {{-- <div class="table-responsive m-t"> --}}
                <table class="table table-bordered text-nowrap mt-3" style="border-collapse: collapse; border: 0.5px solid #000; padding: 0px; margin: 0px;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center stamp-header">
                                กลุ่ม / กองพนักงาน
                            </th>
                            <th rowspan="2" class="text-center stamp-header">
                                ประเภท
                            </th>
                            <th rowspan="2" class="text-center stamp-header">
                                จำนวน
                            </th>
                            <th rowspan="2" class="text-center stamp-header">
                                ค่าแรงต่อชั่วโมง<br>(ค่าแรง 100%)
                            </th>
                            <th colspan="2" class="text-center stamp-header">
                                เสาร์ / อาทิตย์ / นักขัตฤกษ์
                            </th>
                            @foreach ($otTimeDesc as $time)
                                <th colspan="5" class="text-center stamp-header">
                                    {{ $time }} น.
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="text-center stamp-header">
                                ชม.<br>ผลิตเพิ่ม
                            </th>
                            <th class="text-center stamp-header">
                                ค่าล่วงเวลา
                            </th>
                            @foreach ($otTimeDesc as $time)
                                <th class="text-center stamp-header">
                                    OT %
                                </th>
                                <th class="text-center stamp-header">
                                    ค่าแรง<br>OT/ชม.
                                </th>
                                <th class="text-center stamp-header">
                                    ชม.<br>ผลิตเพิ่ม
                                </th>
                                <th class="text-center stamp-header">
                                    คิด 1.5 เท่า
                                </th>
                                <th class="text-center stamp-header">
                                    ค่าล่วงเวลา
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($otPlanBiWeeklyTab1 as $dept_code => $otPlans)
                            @if ($department->department_code == $dept_code)
                                @foreach ($otPlans as $dept => $plans)
                                    <tr>
                                        <td rowspan="{{ count($plans) }}" class="text-left stamp-qty">
                                            <div> {{ getDepertmentGroup($dept) }} </div>
                                        </td>
                                        @foreach ($plans as $plan)
                                            <td class="text-center stamp-qty">
                                                {{ $plan->employee_type_name }}
                                            </td>
                                            <td class="text-center stamp-qty">
                                                {{ $plan->employee_qty }}
                                            </td>
                                            <td class="text-right stamp-qty">
                                                {{ number_format($plan->ot_perhour, 2) }}
                                            </td>
                                            <td class="text-center stamp-qty">
                                                {{ $plan->ot_hour }}
                                            </td>
                                            <td class="text-right stamp-qty">
                                                {{ number_format($plan->ot_holiday, 2) }}
                                            </td>
                                            @foreach ($otTimeDesc as $time)
                                                <td class="text-center stamp-qty">
                                                    {{ $otPercent[$time][$plan->department_code.'|'.$plan->employee_type] }}
                                                </td>
                                                <td class="text-right stamp-qty">
                                                    {{ number_format($hourlyWage[$time][$plan->department_code.'|'.$plan->employee_type], 2) }}
                                                </td>
                                                <td class="text-center stamp-qty">
                                                    {{ $hourIncrease[$time][$plan->department_code.'|'.$plan->employee_type] }}
                                                </td>
                                                <td class="text-center stamp-qty">
                                                    {{ $defaultRate[$time][$plan->department_code.'|'.$plan->employee_type] }}
                                                </td>
                                                <td class="text-right stamp-qty">
                                                    {{ number_format($otAmountTab1[$time][$plan->department_code.'|'.$plan->employee_type], 2) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        <tr>
                            <th colspan="6" class="text-right stamp-qty">
                                รวมหน่วยงาน : {{ $department->department_name }}
                            </th>
                            @foreach ($otTimeDesc as $time)
                                <th class="text-center stamp-qty">
                                    -
                                </th>
                                <th class="text-right stamp-qty">
                                    {{ number_format($summary[$department->department_code][$time][0]['hourly_wage'], 2) }}
                                </th>
                                <th class="text-center stamp-qty">
                                    {{ number_format($summary[$department->department_code][$time][0]['hour_increase'], 2) }}
                                </th>
                                <th class="text-center stamp-qty">
                                    -
                                </th>
                                <th class="text-right stamp-qty">
                                    {{ number_format($summary[$department->department_code][$time][0]['ot_amount'], 2) }}
                                </th>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            {{-- </div> --}}
        @endif
    @endforeach

    {{-- Last Page --}}
    <div style="page-break-after: always;"> </div>
    @include('planning.overtimes-plan.report.header_fix')
    <h3> งบประมาณค่าใช้จ่ายล่วงเวลาปีงบประมาณ {{ $otMain->ppBiWeekly->period_year_thai }}
        ปักษ์ที่ {{ $otMain->ppBiWeekly->biweekly }}
        ประจำวันที่ {{ $otMain->ppBiWeekly->thai_combine_date }}
    </h3>
    <table class="table table-bordered mt-3" style="border-collapse: collapse; border: 0.5px solid #000; padding: 0px; margin: 0px;">
        <thead>
            <tr>
                <th width="10%" class="stamp-header">
                    หน่วยงาน
                </th>
                <th width="10%" class="stamp-header">
                    ประเภทพนักงาน
                </th>
                <th width="15%" class="stamp-header">
                    กรอบงบประมาณค่าล่วงเวลา <br/> ที่ผ่านการกลั่นกรองปีงบประมาณ {{ $otMain->ppBiWeekly->period_year_thai }} <br/> (บาท)
                </th>
                <th width="15%" class="stamp-header">
                    @if ($otMain->ppBiWeekly->biweekly == 1)
                        ประมาณการใช้งบประมาณ <br/> ปักษ์ที่ 1 <br/> (บาท)
                    @else
                        ประมาณการใช้งบประมาณ <br/> ปักษ์ที่ 1 - {{ $otMain->ppBiWeekly->biweekly - 1 }} <br/> (บาท)
                    @endif
                </th>
                <th width="15%" class="stamp-header">
                    ประมาณการจ่ายค่าล่วงเวลาปักษ์ที่ {{ $otMain->ppBiWeekly->biweekly }} <br> ประจำวันที่ {{ $otMain->ppBiWeekly->thai_combine_date }} <br/> (บาท)
                </th>
                <th width="12%" class="stamp-header">
                    คงเหลืองบประมาณ <br> (บาท)
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $summaryOtAmount = 0;
                $summaryBudget = 0;
                $summaryBudgetBiWeekly = 0;
                $summaryBalance = 0;
            @endphp
            @foreach ($otPlanBiWeeklyTab2 as $department => $otPlans)
            @php
                $totalOtAmountByDept = 0;
                $totalBudgetByDept = 0;
                $totalBudgetBiWeeklyByDept = 0;
                $totalBalance = 0;
            @endphp
                <tr>
                    <td rowspan="{{ count($otPlans)+1 }}" style="font-size: 16px; border: 0.5px solid #000000; text-align: center; padding: 4px; height: 10px;">
                        {{ $otPlans[0]->division_name }}
                    </td>
                    @foreach ($otPlans as $index => $otPlan)
                        @php
                            // total
                            $totalBudgetByDept += $otBudget[$department][$otPlan->employee_type][0]['amount'];
                            $totalBudgetBiWeeklyByDept += $otBudget[$department][$otPlan->employee_type][1]['amount'];
                            $totalOtAmountByDept += getSumFormatP10($otAmountTab2[$department][$otPlan->employee_type]);
                            $totalBalance = ($totalBudgetByDept - $totalBudgetBiWeeklyByDept) - $totalOtAmountByDept;
                            // summary
                            $summaryBudget += $otBudget[$department][$otPlan->employee_type][0]['amount'];
                            $summaryBudgetBiWeekly += $otBudget[$department][$otPlan->employee_type][1]['amount'];
                            $summaryOtAmount += getSumFormatP10($otAmountTab2[$department][$otPlan->employee_type]);
                            $summaryBalance = ($summaryBudget - $summaryBudgetBiWeekly) - $summaryOtAmount;
                        @endphp
                        <td class="stamp-qty" style="{{ $otPlan->employee_type == '0'? 'border-bottom: 0.5px solid #FFF;': ''}}">
                            {{ $otPlan->employee_type_name }}
                        </td>
                        <td class="stamp-qty" style="{{ $otPlan->employee_type == '0'? 'border-bottom: 0.5px solid #FFF;': ''}}">
                            {{ number_format($otBudget[$department][$otPlan->employee_type][0]['amount'], 2) }}
                        </td>
                        <td class="stamp-qty" style="{{ $otPlan->employee_type == '0'? 'border-bottom: 0.5px solid #FFF;': ''}}">
                            {{ number_format($otBudget[$department][$otPlan->employee_type][1]['amount'], 2) }}
                        </td>
                        <td class="stamp-qty" style="{{ $otPlan->employee_type == '0'? 'border-bottom: 0.5px solid #FFF;': ''}}">
                            {{ number_format(getSumFormatP10($otAmountTab2[$department][$otPlan->employee_type]), 2) }}
                        </td>
                        <td class="stamp-qty" style="{{ $otPlan->employee_type == '0'? 'border-bottom: 0.5px solid #FFF;': ''}}">
                            {{ number_format( ($otBudget[$department][$otPlan->employee_type][0]['amount'] - $otBudget[$department][$otPlan->employee_type][1]['amount']) - getSumFormatP10($otAmountTab2[$department][$otPlan->employee_type] ), 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="stamp-qty">
                            รวม
                        </td>
                        <td class="stamp-qty">
                            {{ number_format($totalBudgetByDept, 2) }}
                        </td>
                        <td class="stamp-qty">
                            {{ number_format($totalBudgetBiWeeklyByDept, 2) }}
                        </td>
                        <td class="stamp-qty">
                            {{ number_format($totalOtAmountByDept, 2) }}
                        </td>
                        <td class="stamp-qty">
                            {{ number_format($totalBalance, 2) }}
                        </td>
                    </tr>
                </tr>
            @endforeach
            <tr>
                <th colspan="2" class="stamp-qty">
                    รวมทั้งสิ้น
                </th>
                <th class="stamp-qty">
                    {{ number_format($summaryBudget, 2) }}
                </th>
                <th class="stamp-qty">
                    {{ number_format($summaryBudgetBiWeekly, 2) }}
                </th>
                <th class="stamp-qty">
                    {{ number_format($summaryOtAmount, 2) }}
                </th>
                <th class="stamp-qty">
                    {{ number_format($summaryBalance, 2) }}
                </th>
            </tr>
        </tr>
        </tbody>
    </table>
</body>
</html>
