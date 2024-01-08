<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานบันทึกบัญชีค่าเบี้ยประกันภัยยานพาหนะ ประจำเดือน </title>
    @include('ir.reports.irr0009-1._style')
</head>
<body> 
    {{-- <div class="row">
        <div class="col-md-12"> --}}
            <div> <strong> <u>Debit</u> </strong> </div>
            <div style="margin-top: 15px; margin-bottom: 20px;">
                <table class="table table-test">
                    <thead>
                        <tr style="background-color: #dcdfdb;">
                            <th  style="width: 250px;">
                                สถานที่ - ยี่ห้อ
                            </th>
                            <th  style="width: 80px;">
                                ทะเบียน
                            </th>
                            <th >
                                รหัสบัญชี
                            </th>
                            <th >
                                ชื่อบัญชี
                            </th>
                            <th style="width: 130px;">
                                ค่าเบี้ยประกันภัย (บาท)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataDebit as $location => $carLists)
                            <tr>
                                <td><strong>{{ $location }}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($carLists as $car => $lists)
                                <tr>
                                    <td>
                                        <div style="margin-left: 10px;"><u>{{ $car }}</u></div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($lists->sortBy('vehicle_brand_name') as $list)
                                    <tr>
                                        <td>
                                            <div style="margin-left: 10px;">{{ $loop->iteration . '. ' . $list->vehicle_brand_name }}</div>
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $list->license_plate }}
                                        </td>
                                        <td>
                                            {{ $list->expense_account }}
                                        </td>
                                        <td>
                                            {{ $list->expense_account_desc }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($list->net_amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}">
                                    <strong>รวม {{ $location }}</strong>
                                </td>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                <td style="{{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"></td>
                                <td style="text-align: right; {{ $loop->last ? 'border-bottom: 0.5px solid #000' : '' }}"> 
                                    @php
                                        $sum = 0;
                                        foreach ($carLists as $lists) {
                                            foreach ($lists as $value) {
                                                $sum += $value->net_amount;
                                            }
                                        }
                                    @endphp
                                    <strong>{{ number_format($sum, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="text-align: center; border-bottom: 0.5px solid #000" colspan="4">
                                <strong>รวมทั้งสิ้น</strong>
                            </td>
                            <td style="text-align: right; border-bottom: 0.5px solid #000"> 
                                <strong>{{ number_format($totalDebit, 2) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="page-break"></div>
            <div style="margin-top: 10px;"> <strong> <u>Credit</u> </strong> </div>
            <div style="margin-top: 10px; margin-bottom: 20px;">
                <table class="table table-test">
                    <thead>
                        <tr style="background-color: #dcdfdb;">
                            <th  style="width: 300px;">
                                ประเภทค่าใช้จ่าย
                            </th>
                            <th >
                                รหัสบัญชี
                            </th>
                            <th >
                                ชื่อบัญชี
                            </th>
                            <th style="width: 130px;">
                                ค่าเบี้ยประกันภัย (บาท)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataCredit as $list)
                            <tr>
                                <td style="{{$loop->last ? 'border-bottom: 0.5px solid #000' : ''}}">
                                    {{ expenseType($list->prepaid_account) }}
                                </td>
                                <td style="text-align: center; {{$loop->last ? 'border-bottom: 0.5px solid #000' : ''}}">
                                    {{ $list->prepaid_account }}
                                </td>
                                <td style="{{$loop->last ? 'border-bottom: 0.5px solid #000' : ''}}">
                                    {{ $list->prepaid_account_desc }}
                                </td>
                                <td style="text-align: right; {{$loop->last ? 'border-bottom: 0.5px solid #000' : ''}}">
                                    @php
                                        $sum = amountByExpenseType($list->prepaid_account, $renewType, $groupCode, $monthText, null);
                                    @endphp
                                    {{ $sum ? number_format($sum, 2) : '' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            @php
                                $total = amountByExpenseType($dataCredit, $renewType, $groupCode, $monthText, 'total');
                            @endphp
                            <td style="text-align: center; border: 0.5px solid #000;" colspan="3">
                                <strong>รวมทั้งสิ้น</strong>
                            </td>
                            <td style="text-align: right; border: 0.5px solid #000;">
                                <strong>{{ $total ? number_format($total, 2) : '' }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        {{-- </div>
    </div> --}}
</body>
</html>
