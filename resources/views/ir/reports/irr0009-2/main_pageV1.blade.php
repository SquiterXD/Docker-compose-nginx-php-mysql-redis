<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานดุลค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน </title>
    @include('ir.reports.irr0009-2._style')
</head>
<body> 
    <div class="row">
        <div class="col-md-12">
            <div style="margin-top: 10px; margin-bottom: 20px;">
                <table class="table table-test">
                    <thead>
                        <tr style="background-color: #dcdfdb;">
                            @php
                                $m  = date('m', strtotime($month))-1;
                                $lm = '0'. strval($m);

                                $last    = date('Y', strtotime($month)) . '-' . $lm . '-' . '01';
                                $lastDay = date("t", strtotime($last));
                            @endphp
                            <th rowspan="2" style="width: 300px; height: 10px;">
                                สถานที่ - ยี่ห้อ
                            </th>
                            <th rowspan="2" style="width: 80px; height: 10px;">
                                ทะเบียน
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
                        @foreach ($data as $location => $carLists)
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
                                <td></td>
                            </tr>
                            @foreach ($carLists as $list)
                                @php
                                    $insuranceExpense = insuranceExpense($list, $month);
                                    $net = ( 0 + $insuranceExpense)  - $list->net_amount;

                                    $sumInsuranceExpense += $insuranceExpense;
                                @endphp
                                <tr>
                                    <td style="border-bottom: 0.5px solid #fff">
                                        <div style="margin-left: 10px;"><u>{{ $list->vehicle ? $list->vehicle->vehicle_type_name : '' }}</u></div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 0.5px solid #fff">
                                        <div style="margin-left: 10px;">
                                            {{ $list->vehicle ? $loop->iteration . '. ' . $list->vehicle->vehicle_brand_name : '' }}
                                            ( {{ parseToDateTh($list->start_date) }} - {{ parseToDateTh($list->end_date) }} )
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $list->license_plate }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $list->expense_account }}
                                    </td>
                                    <td style="text-align: right;">
                                        0.00
                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($insuranceExpense, 2) }}
                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($list->net_amount, 2) }}
                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($net, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                @php
                                    $sumNetAmount = $carLists->sum('net_amount');
                                    $sumNet       = (0 + $sumInsuranceExpense) - $sumNetAmount;
                                @endphp
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                    <strong>รวม {{ $location }}</strong>
                                </td>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"> 
                                    <strong>0.00</strong>
                                </td>
                                <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"> 
                                    <strong>{{ number_format($sumInsuranceExpense, 2) }}</strong>
                                </td>
                                <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"> 
                                    <strong>{{ number_format($sumNetAmount, 2) }}</strong>
                                </td>
                                <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"> 
                                    <strong>{{ number_format($sumNet, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            @php
                                $total = (0 + $totalInsuranceExpense) - $totalNetAmount;
                            @endphp
                            <td style="text-align: center; border-bottom: 0.5px solid #000" colspan="3">
                                <strong>รวมทั้งสิ้น</strong>
                            </td>
                            <td style="text-align: right; border-bottom: 0.5px solid #000"> 
                                <strong>0.00</strong>
                            </td>
                            <td style="text-align: right; border-bottom: 0.5px solid #000"> 
                                <strong>{{ number_format($totalInsuranceExpense, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border-bottom: 0.5px solid #000"> 
                                <strong>{{ number_format($totalNetAmount, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border-bottom: 0.5px solid #000"> 
                                <strong>{{ number_format($total, 2) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
