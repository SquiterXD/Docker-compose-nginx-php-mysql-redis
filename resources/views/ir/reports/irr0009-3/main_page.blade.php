<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานดุลค่าเบี้ยประกันภัยสถานีน้ำมัน ประจำเดือน </title>
    @include('ir.reports.irr0009-3._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px; margin-bottom: 20px;">
                <div style="margin-left: 10px; margin-bottom: 10px;">
                    <strong>กลุ่ม : {{ $groupCodeDesc }} </strong>
                </div>
                <table class="table table-test">
                    <thead>
                        <tr style="background-color: #dcdfdb;">
                            @php
                                $lm      = date("m",strtotime("-1 months",strtotime($month)));
                                $last    = date('Y', strtotime($month)) . '-' . $lm . '-' . '01';
                                $lastDay = date("t", strtotime($last));
                            @endphp
                            <th rowspan="2" style="width: 300px; height: 10px;">
                                ประเภทสถานีน้ำมัน
                            </th>
                            <th rowspan="2" style="width: 250px; height: 10px;">
                                รหัสบัญชี
                            </th>
                            <th rowspan="2" style="width: 80px; height: 10px;">
                                ดุล 
                                <br>
                                {{ $lastDay }} {{ $thaishortmonths[$lm]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                            <th colspan="2" style="height: 10px;">
                                {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                            <th rowspan="2" style="width: 80px; height: 10px;">
                                ดุล 
                                <br>
                                {{ date("t", strtotime($month)) }} {{ $thaishortmonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                        </tr>
                        <tr style="background-color: #dcdfdb;">
                            <th style="width: 80px; height: 10px;">ลูกหนี้</th>
                            <th style="width: 80px; height: 10px;">เจ้าหนี้</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $location => $dataLists)
                            @php
                                $sumInsuranceExpense = 0;
                            @endphp
                            <tr>
                                <td style="border-bottom: 0.5px solid #fff"><strong>{{ $location }}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($dataLists as $list)
                                <tr>
                                    <td style="{{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        <div style="margin-left: 10px;">
                                            {{ $list->gas_station_type_name }}
                                        </div>
                                    </td>
                                    <td style="text-align: center; {{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        {{ $list->expense_account }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        {{ number_format($list->beginning_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        {{ number_format($list->activity_ap_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        {{ number_format($list->net_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border: 0.5px solid #000;' : ''}}">
                                        {{ number_format($list->ending_amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr style="background-color: #e6e6e6;">
                            <td style="text-align: center; border: 0.5px solid #000;" colspan="2">
                                <strong>รวมทั้งสิ้น</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalBeginning, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalActivity, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalNetAmount, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalEnding, 2) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
