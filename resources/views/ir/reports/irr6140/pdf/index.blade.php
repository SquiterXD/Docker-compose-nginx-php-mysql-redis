<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports.irr6140._style')
    </head>
    <body>
        @php
        $colspan=3;
        $total=0;
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
                                สั่งพิมพ์ : {{ optional(auth()->user())->user_id }}<br>
                                <br>
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

                        <div class="row">
                            <div style="width:60%;text-align:left" class="b">
                                @php
                                    foreach($headLeft as $title){
                                        echo $title."<br>";
                                    }
                                @endphp

                            </div>
                            <div style="width:40%;text-align:right;" class="b">
                                @php
                                    foreach($headRight as $title){
                                        echo $title."<br>";
                                    }
                                @endphp
                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;font-weight:bold;height:30px;">
                    <th style="border-right:1px solid #000;border-left:1px solid #000;width:30px;text-align:center">ลำดับ<br></th>
                    <th style="border-right:1px solid #000;min-width:300px;text-align:left;padding-left:5px">รายการ<br></th>
                    <th style="border-right:1px solid #000;width:150px;text-align:right">ค่าเบี้ยประกัน (บาท)</th>
                </tr>
            </thead>
            <tbody>
            @php  $i=0;  @endphp
            @foreach ($data->groupBy('group_01') as $group => $cats)
                @php
                    $i++;
                    $ii=0;
                @endphp
                <tr>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:center">{{ $i }}.<br></td>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;font-weight:bold;text-align:left;"><b>{{ $group }}</b><br></td>
                    <th style="border-right:1px solid #000;width:150px;text-align:right"></th>
                </tr>
                @foreach ($cats->groupBy('group_02') as $cat => $lines)
                    @php $ii++;  @endphp
                <tr>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;width:80px;text-align:center">{{ $i }}.{{ $ii }}<br></td>
                    <td style="border-right:1px solid #000;font-weight:bold;text-align:left;"><b>{{ $cat }}</b><br></td>
                    <th style="border-right:1px solid #000;width:150px;text-align:right"></th>
                </tr>
                    @foreach ($lines as $line )
                        <tr>
                            <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:center"></td>
                            <td style="border-right:1px solid #000;text-align: left;padding-left:20px;">{{ $line->cat_title }}</td>
                            <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_insure,2)  }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:left;"></td>
                        <td style="border-right:1px solid #000;text-align: right;padding-right:5px;"></td>
                        <td style="border-right:1px solid #000;text-align: right;border-top:1px solid #000;border-bottom:1px solid #000;">{{ number_format($lines->sum('amt_insure'),2) }}</td>
                    </tr>
                    @php
                        $total +=$lines->sum('amt_insure');
                    @endphp
                @endforeach
                <tr>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:left;"></td>
                    <td style="border-right:1px solid #000;text-align: right;padding-right:5px;"></td>
                    <td style="border-right:1px solid #000;text-align: right;border-top:1px solid #000;border-bottom:1px solid #000;">{{ number_format($total,2) }}</td>
                </tr>
                @php
                    $total =0;
                @endphp
            @endforeach
                <tr style="border-top:1px solid #000;border-bottom: 1px solid #000;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:left;"></td>
                    <td style="border-right:1px solid #000;text-align:right;padding-right:5px;">รวมทั้งสิ้น </td>
                    <td style="border-right:1px solid #000;text-align:right;">{{ number_format($data->sum('amt_insure'),2) }}</td>
                </tr>
            </tbody>
        </table>

        @if(count($data)==0)
            <div style="padding-top:10px;text-align:center"> ไม่มีข้อมูลตามเงื่อนไขที่ท่านเลือก </div>
        @endif

     </div>
    </body>
</html>
