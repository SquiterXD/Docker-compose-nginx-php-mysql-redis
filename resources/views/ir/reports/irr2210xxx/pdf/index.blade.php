<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports.irr2210._style')
    </head>
    <body>
        @php
            $colspan=7;

        @endphp
    <div class="page-break">
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ &nbsp; : {{ optional(auth()->user())->username }}
                                @php
                                    foreach($headLeft as $title){
                                        echo "<br>".$title;
                                    }
                                @endphp

                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}
                                @php
                                    foreach($progPara as $para){
                                        echo "<br>".$para;
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
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <th rowspan=2 style="border-right:1px solid #000;border-left:1px solid #000;min-width:120px;text-align:center;padding-left:5px">รายการ</th>
                    <th rowspan=2 style="border-right:1px solid #000;text-align:center">รหัสบัญชี</th>
                    <th rowspan=2 style="border-right:1px solid #000;text-align:center">ดุล<br>{{ $periods->month_pre }}</th>
                    <th colspan=2 style="border-right:1px solid #000;text-align:center">{{ $periods->month_cur }}</th>
                    <th rowspan=2 style="border-right:1px solid #000;text-align:center">ดุล<br>{{ $periods->month_end }}<br>รับคืน</th>
                    <th rowspan=2 style="border-right:1px solid #000;width:150px;text-align:center">ค้างจ่าย</th>
                </tr>
                <tr style="border-bottom: 1px solid #000;height:30px;">
                    <th style="border-right:1px solid #000;width:150px;text-align:center">ลูกหนี้</th>
                    <th style="border-right:1px solid #000;width:150px;text-align:center">เจ้าหนี้</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data->groupBy('policy_no') as $cat => $lines)
                <tr style="height:30px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;font-weight:bold;text-align:left;">{{ $cat }}<br></td>
                    @for($j=0;$j<$colspan-1;$j++)
                    <td style="border-right:1px solid #000;"><br></td>
                    @endfor
                </tr>
                @foreach ($lines as $line )
                <tr style="height:25px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align: left;">{{ $line->cat_title }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ $line->acc }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->balance_1,2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_ar,2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_ap,2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->balance_2,2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->pending,2) }}</td>
                </tr>
                @endforeach

                <tr  style="border-bottom:1px solid #000;border-top:1px solid #000;height:30px;font-weight:bold;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align: center;">รวมทั้งสิ้น</td>
                    <td style="border-right:1px solid #000;text-align: left;"></td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($lines->sum("balance_1"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($lines->sum("amt_ar"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($lines->sum("amt_ap"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($lines->sum("balance_2"),2) }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($lines->sum("pending"),2) }}</td>
                </tr>
            @endforeach
            @if(count($data)==0)
                <tr style="height:100px;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;font-weight:bold;text-align:center;"> <br></td>
                    @for($j=0;$j<$colspan-1;$j++)
                    <td style="border-right:1px solid #000;text-align:center;"> - </td>
                    @endfor
                </tr>
                <tr  style="border-bottom:1px solid #000;border-top:1px solid #000;height:30px;font-weight:bold;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align: center;">รวมทั้งสิ้น</td>
                    <td style="border-right:1px solid #000;text-align: left;"></td>
                    <td style="border-right:1px solid #000;text-align: right;">0.00</td>
                    <td style="border-right:1px solid #000;text-align: right;">0.00</td>
                    <td style="border-right:1px solid #000;text-align: right;">0.00</td>
                    <td style="border-right:1px solid #000;text-align: right;">0.00</td>
                    <td style="border-right:1px solid #000;text-align: right;">0.00</td>
                </tr>
            @endif
            </tbody>
        </table>
     </div>
    </body>
</html>
