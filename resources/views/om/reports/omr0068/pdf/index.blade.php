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
        $colspan=4;
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
                                หน่วย : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; บาท<br>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                    <th style="width:120px;text-align:left"> รหัสธนาคาร</th>
                    <th style="min-width:200px;text-align:left;"> ชื่อบัญชี</th>
                    <th style="width:250px;text-align:right"> จำนวนเงิน</th>
                    <!-- <th style="width:100px;text-align:right"> </th> -->
                </tr>
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $line)
                <tr>
                    <td style="text-align: left;">{{ $line->bank_no }}</td>
                    <td style="text-align: left;">{{ $line->bank_name }}</td>
                    <td style="text-align: right;">{{ ($line->amt<>0)?number_format($line->amt,2):'' }}</td>
                    <!-- <td style="text-align: right;"></td> -->
                </tr>
            @endforeach
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=2 style="text-align:right;">รวม</td>
                    <td style="text-align: right;">{{ ($data->sum('amt')<>0)?number_format($data->sum('amt'),2):'' }}</td>
                    <!-- <td style="text-align: right;"></td> -->
                </tr>
            </tbody>
        </table>
        <div style="padding-top:10px;">หมายเหตุรายการ :  {{ $remark }}</div>
        <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div>

        <!-- <div style="padding-top:2px;text-align:right">
                <div>ผู้ตรวจทาน ________________________________ </div><br>
                <div>รับรองถูกต้อง ________________________________</div><br>
                <div>หัวหน้าส่วนงาน ________________________________</div>
        </div> -->
                                    <br>
        <table width="100%" style="padding-top30px;">
            <tr>
                <td width="33%" style="text-align:center">ผู้ตรวจทาน ________________________________</td>
                <td width="33%" style="text-align:center">รับรองถูกต้อง ________________________________</td>
                <td width="33%" style="text-align:center">หัวหน้าส่วนงาน ________________________________</td>
            </tr>
        </table>
    </body>
</html>
