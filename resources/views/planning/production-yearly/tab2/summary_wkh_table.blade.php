{{-- TAB 2 (Table บน) --}}
<div class="table-responsive m-t mb-3">
    <table class="table text-nowrap table-bordered" border="1">
        <thead>
            <tr>
                @php
                    $i = -1;
                @endphp
                <th class="text-center"> วันทำงาน </th>
                @foreach ($periods as $period_no => $thai_month)
                    @php
                        $i = $i >= 4? 0: $i+1;
                    @endphp
                    <th class="text-center" style="background-color: {{ $yearlyColorCode[$i] }}">{{ $thai_month }}</th>
                @endforeach
                <th class="text-center"> รวมทั้งปี </th>
            </tr>
        </thead>
        <tbody>
            @if (count($summaries) <= 0)
                <tr>
                    <td colspan="{{ count($periods)+2 }}" class="text-center">
                        <h2> ไม่พบข้อมูลชั่วโมงการทำงานทั้งปีงบประมาณ </h2>
                    </td>
                </tr>
            @else
                @php
                    $totalWorkNormal = 0;
                    $totalPmEfficiency = 0;
                    $totalOtHour = 0;
                    $totalAllDays = 0;
                    $totalByWkh = 0;
                    $totalByHour = 0;
                    $totalByAllHours = 0;
                @endphp
                <tr>
                    @foreach ($workingHour as $value)
                        @php
                            $totalByWkh = 0;
                        @endphp
                        <td class="text-left"> {{ $value->meaning }} (วัน) </td>
                        @foreach ($totalDays as $day)
                            @php
                                $totalByWkh += number_format($day[$value->lookup_code], 2);
                            @endphp
                            <td class="text-right"> {{ number_format($day[$value->lookup_code], 2) }} </td>
                        @endforeach
                        <td class="text-right"> {{ number_format($totalByWkh, 2) }} </td>
                    </tr>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-center"> รวมวันทำงาน </td>
                    @foreach ($totalDays as $day)
                        @php
                            $totalAllDays += number_format(array_sum($day), 2);
                        @endphp
                        <td class="text-right tw-font-bold" style="color: white; background-color: #34d399;">
                            {{ number_format(array_sum($day), 2) }}
                        </td>
                    @endforeach
                    <td class="text-right tw-font-bold" style="color: white; background-color: #34d399;">
                        {{ number_format($totalAllDays, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"> ชั่วโมงทำงานปกติ (ชั่วโมง) </td>
                    @foreach ($totalWkhNormal as $wkh)
                        @php
                            $totalWorkNormal += number_format($wkh[0], 2);
                        @endphp
                        <td class="text-right"> {{ number_format($wkh[0], 2) }} </td>
                    @endforeach
                    <td class="text-right"> {{ number_format($totalWorkNormal, 2) }} </td>
                </tr>
                <tr>
                    <td class="text-left"> ชั่วโมงซ่อมบำรุงเครื่องจักร (ชั่วโมง) </td>
                    @foreach ($totalPm as $pm)
                        @php
                            $totalPmEfficiency += number_format($pm[0], 2);
                        @endphp
                        <td class="text-right"> {{ number_format($pm[0], 2) }} </td>
                    @endforeach
                    <td class="text-right"> {{ number_format($totalPmEfficiency, 2) }} </td>
                </tr>
                <tr>
                    <td class="text-left"> ชั่วโมงล่วงเวลา (ชั่วโมง) </td>
                    @foreach ($totalOt as $ot)
                        @php
                            $totalOtHour += number_format($ot[0], 2)
                        @endphp
                        <td class="text-right"> {{ number_format($ot[0], 2) }} </td>
                    @endforeach
                    <td class="text-right"> {{ number_format($totalOtHour, 2) }} </td>
                </tr>
                <tr>
                    <td class="text-center"> รวมชั่วโมงทำงาน </td>
                    @foreach ($periods as $period_no => $thai_month_arr)
                        @php
                            $totalByHour =  number_format(array_sum($totalWkhNormal[$period_no]) + array_sum($totalPm[$period_no])+ array_sum($totalOt[$period_no]), 2);
                            $totalByAllHours += $totalByHour;
                        @endphp
                        <td class="text-right tw-font-bold" style="color: white; background-color: #34d399;">
                            {{ number_format($totalByHour, 2) }}
                        </td>
                    @endforeach
                    <td class="text-right tw-font-bold" style="color: white; background-color: #34d399;">
                        {{ number_format($totalByAllHours, 2) }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>