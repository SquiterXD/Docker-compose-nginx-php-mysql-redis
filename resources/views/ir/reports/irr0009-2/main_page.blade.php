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
            <div>
                <table class="table">
                    <thead>
                        <tr style="background-color: #c4c4c4; border-top: 1.5px solid #000; border-bottom: 0.5px solid #000;">
                            @php
                                $lm = date("m",strtotime("-1 months",strtotime($month)));

                                $last    = date('Y', strtotime($month)) . '-' . $lm . '-' . '01';
                                $lastDay = date("t", strtotime($last));
                            @endphp
                            <th rowspan="2" style="width: 300px; height: 5px; border-right:0.5px solid #000; border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;">
                                สถานที่ - ยี่ห้อ
                            </th>
                            <th rowspan="2" style="width: 80px; height: 5px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                ทะเบียน
                            </th>
                            <th rowspan="2" style="width: 250px; height: 5px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                รหัสบัญชี
                            </th>
                            <th rowspan="2" style="width: 80px; height: 5px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                ดุล 
                                <br>
                                {{ $lastDay }} {{ $thaishortmonths[$lm]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                            <th colspan="2" style="width: 80px; height: 5px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                ตัดค่าใช้จ่าย 
                                <br>
                                {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                            <th rowspan="2" style="width: 80px; height: 5px; border-right:0.5px solid #000;border-left:0.5px solid #000; border-top:0.5px solid #000; border-bottom:0.5px solid #000;"">
                                ดุล 
                                <br>
                                {{ date("t", strtotime($month)) }} {{ $thaishortmonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}
                            </th>
                        </tr>
                        <tr style="background-color: #c4c4c4;">
                            <th style="width: 80px; height: 5px; border:0.5px solid #000;">ลูกหนี้</th>
                            <th style="width: 80px; height: 5px; border:0.5px solid #000;">เจ้าหนี้</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $location => $vehicleLists)
                            @php
                            // dd($vehicleLists);
                                $sumInsuranceExpense = 0;
                                $sumActivityAP       = 0;
                                $sumBeginning        = 0;
                                $sumEnding           = 0;
                            @endphp
                            <tr>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"><strong>{{ $location }}</strong></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                            </tr>
                            @foreach ($vehicleLists as $type =>  $carLists)
                                
                                <tr>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;">
                                        <div style="margin-left: 10px;"><u>{{ getVehicleName($type) }}</u></div>
                                    </td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                    <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
                                </tr>
                                @foreach ($carLists as $list)
                                @php
                                    $insuranceExpense = insuranceExpense($list, $month);
                                    $net = ( 0 + $insuranceExpense)  - $list->net_amount;

                                    $sumInsuranceExpense += $insuranceExpense;
                                    $sumActivityAP       += $list->activity_ap_amount;
                                    $sumBeginning        += $list->beginning_amount;
                                    $sumEnding           += $list->ending_amount;
                                @endphp
                                <tr>
                                    <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000; border-left:0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}">
                                        <div style="margin-left: 20px;">
                                            {{ $list->vehicle ? $loop->iteration . '. ' . $list->vehicle->vehicle_brand_name : '' }}
                                            ( {{ parseToDateTh($list->start_date) }} - {{ parseToDateTh($list->end_date) }} )
                                        </div>
                                    </td>
                                    <td style="text-align: center; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}">
                                        {{ $list->license_plate }}
                                    </td>
                                    <td style="text-align: center; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}">
                                        {{ $list->expense_account }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->beginning_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->activity_ap_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->net_amount, 2) }}
                                    </td>
                                    <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000; border-right:0.5px solid #000;' : 'border-left:0.5px solid #000; border-right:0.5px solid #000;' }}"> 
                                        {{ number_format($list->ending_amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #e6e6e6;">
                                @php
                                    $sumNetAmount = $carLists->sum('net_amount');
                                    $sumNet       = (0 + $sumInsuranceExpense) - $sumNetAmount;
                                @endphp
                                <td style="text-align: center; border: 0.5px solid #000;" colspan="3">
                                    <strong>รวม {{ $location }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000;"> 
                                    <strong>{{ number_format($sumBeginning, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000;"> 
                                    <strong>{{ number_format($sumActivityAP, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000;"> 
                                    <strong>{{ number_format($sumNetAmount, 2) }}</strong>
                                </td>
                                <td style="text-align: right; border: 0.5px solid #000;"> 
                                    <strong>{{ number_format($sumEnding, 2) }}</strong>
                                </td>
                            </tr>
                            @endforeach
                            
                        @endforeach
                        <tr style="background-color: #e6e6e6;">
                            <td style="text-align: center; border: 0.5px solid #000" colspan="3">
                                <strong>รวมทั้งสิ้น</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalBeginning, 2) }}</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000"> 
                                <strong>{{ number_format($totalActivityAP, 2) }}</strong>
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
