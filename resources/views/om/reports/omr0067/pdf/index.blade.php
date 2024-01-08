<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
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
                    <!-- <th style="width:120px;text-align:center"> รหัสธนาคาร</th> -->
                    <th style="min-width:200px;text-align:left;"> ชื่อบัญชี</th>
                    <th style="width:250px;text-align:right"> จำนวนเงิน</th>
                    <th style="width:100px;text-align:right"> </th>
                </tr>
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $sum= 0;
                @endphp
            @foreach ($data as $line)
                @if($programCode == 'OMR0071')
                @if($line->currency == "THB")
                @php
                $sum += $line->amt;
                @endphp
                @else 
                @php
                $sum += $line->amt * $line->conversion_rate;
                @endphp
                @endif
                @else
                @php
                $sum += $line->amt;
                @endphp
                @endif
                <tr>
                    <!-- <td style="text-align: center;">{{ $line->bank_no }}</td> -->
                    <td style="text-align: left;">{{ $line->bank_name }}</td>
                    
                    <td style="text-align: right;">
                        @if($programCode == 'OMR0071')
                        @if($line->currency == "THB")
                        {{ ($line->amt<>0)?number_format($line->amt,2):'' }}
                        @else 
                        {{ ($line->amt<>0)?number_format($line->amt * $line->conversion_rate,2):'' }}
                        @endif
                        @else
                        {{ ($line->amt<>0)?number_format($line->amt,2):'' }}
                        @endif
                    </td>
                    <td style="text-align: right;"></td>
                </tr>
            @endforeach
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=1 style="text-align:right;">รวม</td>
                    <td style="text-align: right;">{{ ($sum<>0)?number_format($sum,2):'' }}</td>
                    <td style="text-align: right;"></td>
                </tr>
            </tbody>
        </table>

        <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div>
        <br>
        <table width="100%" style="padding-top:20px;">
            <tr>
                <td width="33%" style="text-align:center">ผู้ตรวจทาน ________________________________</td>
                <td width="33%" style="text-align:center">รับรองถูกต้อง ________________________________</td>
                <td width="33%" style="text-align:center">หัวหน้าส่วนงาน ________________________________</td>
            </tr>
        </table>
     
    </body>
</html>
