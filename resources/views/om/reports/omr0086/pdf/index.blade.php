<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    <body>
    @php
        $colspan=7;
    @endphp
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                @php
                                    foreach($progPara as $para){
                                        echo $para."<br>";
                                    }
                                @endphp
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>

                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <th style="width:50px;text-align:center"> ลำดับ</th>
                    <th style="width:180px;text-align:left"> เลขที่ใบลดหนี้เงินโอนไร่</th>
                    <th style="width:120px;text-align:left"> รหัสร้านค้า</th>
                    <th style="min-width:200px;text-align:left;"> ชื่อร้านค้า</th>
                    <th style="width:120px;text-align:center"> รหัสสำนักงาน</th>
                    <th style="width:150px;text-align:right"> จำนวนเงิน</th>
                    <th style="width:180px;text-align:right"> วันที่ชำระผ่าน สนย.</th>
                </tr>
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
            @php $i=0; @endphp
            @foreach ($data as $line)
                @php $i++; @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: left;">{{ $line->doc_no }}</td>
                    <td style="text-align: left;">{{ $line->cus_no }}</td>
                    <td style="text-align: left;">{{ $line->cus_name }}</td>
                    <td style="text-align: center;">{{ $line->office_no }}</td>
                    <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                    <td style="text-align: right;">{{ $line->pay_date }}</td>
                </tr>
            @endforeach
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;height:40px;">
                    <td colspan=5 style="text-align:right;">รวมจำนวนใบลดหนี้ทั้งหมด {{ $i }} ใบ </td>
                    <td style="text-align: right;border-bottom: 3px double #000;">{{ ($data->sum('amt')<>0)?number_format($data->sum('amt'),2):'' }}</td>
                    <td style="text-align: right;"></td>
                </tr>

                <tr style="height:40px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;height:30px;">
                    <th colspan=2 style="text-align:left"><b>สรุป</b> รับเงินผ่านสำนักงานยาสูบ</th>
                    <th style="text-align:center"> รหัสสำนักงาน</th>
                    <th style="text-align:left;"></th>
                    <th style="text-align:right"></th>
                    <th style="text-align:right"></th>
                    <th style="text-align:right"> </th>
                </tr>
                @foreach ($sum as $line)
                <tr>
                    <td style="text-align: center;"></td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: center;">{{ $line->office_no }}</td>
                    <td style="text-align: left;">{{ $line->office_name }}</td>
                    <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                    <td style="text-align: left;"> บาท </td>
                    <td style="text-align: left;"></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan=4 style="text-align:right;">รวม</td>
                    <td style="text-align: right;border-bottom: 3px double #000;">{{ ($sum->sum('amt')<>0)?number_format($sum->sum('amt'),2):'' }}</td>
                    <td style="text-align: left;"> บาท </td>
                    <td style="text-align: left;"> </td>
                </tr>
                <tr style="height:30px;border-bottom: 1px solid #000;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>

            </tbody>
        </table>
        <div style="padding-top:10px;">หมายเหตุรายการ :  {{ $remark }}</div>
        <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div>

        <div style="padding-top:2px;text-align:right">
                <div>ผู้จัดทำ ________________________________ </div><br>
                <div>ผู้ตรวจสอบ ________________________________</div><br>
        </div>
    </body>
</html>
