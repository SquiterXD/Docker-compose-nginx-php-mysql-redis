<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานรายละเอียดค่าเบี้ยประกันภัยสถานีน้ำมัน รายเดือน </title>
    @include('ir.reports.irr0006._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px;">
                @foreach ($data as $group => $lists)
                    <div class="flexrow">
                        <div style="font-size: 18px;">
                            <strong> 
                                กลุ่ม: {{ $group }}
                            </strong>
                        </div>
                    </div>
                    <table class="table" style="margin-top: 10px; margin-bottom: 10px; font-size: 14px">
                        <tr style="border: 0.5px solid #000; background-color: #e6e6e6;">
                            <td style="border: 0.5px solid #000; text-align: center; width: 95px;">
                                <strong>ประเภทสถานีน้ำมัน</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 135px;">
                                <strong>วันที่เริ่มต้น - สิ้นสุดคิคค่าเบี้ย</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 80px;">
                                <strong>มูลค่าทุนประกัน</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 80px;">
                                <strong>ค่าเบี้ยประกันภัย</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>พ.ย. {{substr($lastYear+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ธ.ค. {{substr($lastYear+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ม.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ก.พ. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>มี.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>เม.ย. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>พ.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>มิ.ย. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ก.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ส.ค.66
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ก.ย. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ต.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>พ.ย. {{substr($year+543, -2)}}</strong>
                            </td>
                            <td style="border: 0.5px solid #000; text-align: center; width: 40px;">
                                <strong>ธ.ค. {{substr($year+543, -2)}}</strong>
                            </td>
                        </tr>
                        <tbody>
                            @php
                                $totalInsurance = 0;
                                $coverageAmount = 0;
                                $totalNovLast   = 0;
                                $totalDecLast   = 0;

                                $totalJan       = 0;
                                $totalFeb       = 0;
                                $totalMar       = 0;
                                $totalApr       = 0;
                                $totalMay       = 0;
                                $totalJun       = 0;
                                $totalJul       = 0;
                                $totalAug       = 0;
                                $totalSep       = 0;
                                $totalOct       = 0;
                                $totalNov       = 0;
                                $totalDec       = 0;

                                $nov_last       = 0;
                                $dec_last       = 0;
                                $jan            = 0;
                                $feb            = 0;
                                $mar            = 0;
                                $apr            = 0;
                                $may            = 0;
                                $jun            = 0;
                                $jul            = 0;
                                $aug            = 0;
                                $sep            = 0;
                                $oct            = 0;
                                $nov            = 0;
                                $dec            = 0;

                                $sum11month     = 0;
                            @endphp
                            @foreach ($lists as $list)
                                @php
                                    $insurance = 0;

                                    if ($list->vat_refund == 'Y') {
                                        $insurance = ($list->insurance_amount - $list->discount) + $list->duty_amount;
                                    } elseif ($list->vat_refund == 'N') {
                                        $insurance = $list->net_amount;
                                    }
                                    $totalInsurance += $insurance;
                                    $coverageAmount += $list->coverage_amount;
                                    
                                    $datetime1 = new DateTime($list->start_date);
                                    $datetime2 = new DateTime($list->end_date);
                                    $interval  = $datetime1->diff($datetime2);
                                    $days      = $interval->format('%a');

                                    $start_date_last = new DateTime($list->start_date. ' - 1 years');
                                    $end_date_last   = new DateTime($list->end_date. ' - 1 years');
                                    $interval_last   = $start_date_last->diff($end_date_last);
                                    $days_last       = $interval_last->format('%a');

                                    $month           = date('m', strtotime($list->start_date));

                                    if ($days == 365) {
                                        $jan           = $list->end_month_31_365; //31
                                        $feb           = $list->end_month_28_365; //28
                                        $mar           = $list->end_month_31_365; //31
                                        $apr           = $list->end_month_30_365; //30
                                        $may           = $list->end_month_31_365; //31
                                        $jun           = $list->end_month_30_365; //30
                                        $jul           = $list->end_month_31_365; //31
                                        $aug           = $list->end_month_31_365; //31
                                        $sep           = $list->end_month_30_365; //30
                                        $oct           = $list->end_month_31_365; //31


                                        $totalJan      += $list->end_month_31_365; //31
                                        $totalFeb      += $list->end_month_28_365; //28
                                        $totalMar      += $list->end_month_31_365; //31
                                        $totalApr      += $list->end_month_30_365; //30
                                        $totalMay      += $list->end_month_31_365; //31
                                        $totalJun      += $list->end_month_30_365; //30
                                        $totalJul      += $list->end_month_31_365; //31
                                        $totalAug      += $list->end_month_31_365; //31
                                        $totalSep      += $list->end_month_30_365; //30
                                        $totalOct      += $list->end_month_31_365; //31

                                    } else {
                                        $jan           = $list->end_month_31_365; //31
                                        $feb           = $list->end_month_28_365; //28
                                        $mar           = $list->end_month_31_365; //31
                                        $apr           = $list->end_month_30_365; //30
                                        $may           = $list->end_month_31_365; //31
                                        $jun           = $list->end_month_30_365; //30
                                        $jul           = $list->end_month_31_365; //31
                                        $aug           = $list->end_month_31_365; //31
                                        $sep           = $list->end_month_30_365; //30
                                        $oct           = $list->end_month_31_365; //31

                                        
                                        $totalJan      += $list->end_month_31_366; //31
                                        $totalFeb      += $list->end_month_29_366; //29
                                        $totalMar      += $list->end_month_31_366; //31
                                        $totalApr      += $list->end_month_30_366; //30
                                        $totalMay      += $list->end_month_31_366; //31
                                        $totalJun      += $list->end_month_30_366; //30
                                        $totalJul      += $list->end_month_31_366; //31
                                        $totalAug      += $list->end_month_31_366; //31
                                        $totalSep      += $list->end_month_30_366; //30
                                        $totalOct      += $list->end_month_31_366; //31
                                    }

                                    $sum11month = $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct;  
                                    

                                @endphp
                                <tr style="font-size: 14px">
                                    <td style="border: 0.5px solid #000;">
                                        {{ $list->type_name }}
                                    </td>
                                    <td style="border: 0.05px solid #000; text-align: center;">
                                        {{ date('d/m/Y', strtotime($list->start_date. ' + 543 years')) }} - {{ date('d/m/Y', strtotime($list->end_date. ' + 543 years')) }}
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        {{ number_format($list->coverage_amount, 2) }}
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        {{ number_format($insurance, 2) }}
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($month == 11)
                                            @php
                                                $nov_day_of_month    = $list->year . '-11-30';
                                                $nov_end_of_month    = date_create(date('Y-m-d', strtotime($nov_day_of_month)));
                                                $nov_start_of_month  = date_create(date('Y-m-d', strtotime($list->end_date)));
                                                $nov_diff            = date_diff($nov_start_of_month, $nov_end_of_month);
                                                $nov_total_days      = $nov_diff->days+1;
                                            @endphp

                                            @if ($days_last == 365)
                                                @php
                                                    $nov_last     = $insurance * $nov_total_days / 365;
                                                    $totalNovLast += $nov_last; 
                                                @endphp

                                                {{ number_format($nov_last, 2) }}
                                            @else
                                                @php
                                                    $nov_last     = $insurance * $nov_total_days / 366;
                                                    $totalNovLast += $nov_last;
                                                @endphp

                                                {{ number_format($nov_last, 2) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($month == 12)
                                            @php
                                                $dec_day_of_month    = $list->year . '-12-31';
                                                $dec_end_of_month    = date_create(date('Y-m-d', strtotime($dec_day_of_month)));
                                                $dec_start_of_month  = date_create(date('Y-m-d', strtotime($list->end_date)));
                                                $dec_diff            = date_diff($dec_start_of_month, $dec_end_of_month);
                                                $dec_total_days      = $dec_diff->days+1;
                                            @endphp
                                            @if ($days_last == 365)
                                                @php
                                                    $dec_last     = $insurance * $dec_total_days / 365;
                                                    $totalDecLast += $dec_last;
                                                @endphp
                                                {{ number_format($dec_last, 2) }}
                                            @else
                                                @php
                                                    $dec_last     = $insurance * $dec_total_days / 366;
                                                    $totalDecLast += $dec_last;
                                                @endphp
                                                {{ number_format($dec_last, 2) }}
                                            @endif
                                        @else
                                            @if ($days_last == 365)
                                                @php
                                                    $dec_last = $list->end_month_31_365;
                                                @endphp
                                                {{ number_format($dec_last, 2) }}
                                            @else
                                                @php
                                                    $dec_last = $list->end_month_31_366;
                                                @endphp
                                                {{ number_format($dec_last, 2) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_28_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_29_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_30_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_30_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_30_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_30_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_30_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_30_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($days == 365)
                                            {{ number_format($list->end_month_31_365, 2) }}
                                        @else
                                            {{ number_format($list->end_month_31_366, 2) }}
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($month == 11)
                                            @php
                                                $sum11month += $nov_last;
                                                $sum11month += $dec_last;
                                                $nov         = $insurance - $sum11month;

                                                $totalNov   += $nov;
                                            @endphp

                                            {{ number_format($nov, 2) }}
                                        @else
                                            @if ($days == 365)
                                                @php
                                                    $nov      = $list->end_month_30_365;
                                                    $totalNov += $nov;
                                                @endphp

                                                {{ number_format($nov, 2) }}
                                            @else
                                                @php
                                                    $nov      = $list->end_month_30_366;
                                                    $totalNov += $nov;
                                                @endphp

                                                {{ number_format($nov, 2) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td style="border: 0.5px solid #000; text-align: right;">
                                        @if ($month == 12)
                                            @php
                                                $sum11month += $nov;
                                                $sum11month += $dec_last;
                                                $dec         = $insurance - $sum11month;

                                                $totalDec   += $dec;
                                            @endphp
                                            
                                            {{ number_format($dec, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #e6e6e6; font-size: 13px;">
                                <td style="text-align: center; border: 0.5px solid #000" colspan="2">
                                    <strong>รวมทั้งสิ้น</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($coverageAmount, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalInsurance, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalNovLast, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalDecLast, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalJan, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalFeb, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalMar, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalApr, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalMay, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalJun, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalJul, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalAug, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalSep, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalOct, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalNov, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000"> 
                                    <strong>{{ number_format($totalDec, 2) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
