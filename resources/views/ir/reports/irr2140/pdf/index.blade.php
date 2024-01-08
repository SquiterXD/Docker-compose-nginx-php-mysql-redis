<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    <body>
    @php $colspan=2; @endphp
    @foreach ($data->groupBy('company_title') as $company_name => $company)
        @php
            $row=$company->first();
            $headLeft[0] = "ผู้รับประกันภัย : $row->company_title <br>";
            $headLeft[1] = "สถานะ : {$status} ";

            $headRight[0] = "เลขที่กรมธรรม์ : $row->policy_no";
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
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
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
                                        echo $title;
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

            @foreach ($company->groupBy('type_title') as $type => $types)
                <tr>
                    <th colspan=2 style="text-align:left">ประเภท : {{ $type }}</th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;font-weight:bold;height:30px;">
                    <th style="border-right:1px solid #000;border-left:1px solid #000;text-align:center">รายการ<br></th>
                    <th style="border-right:1px solid #000;width:150px;text-align:right">ค่าเบี้ยประกันภัย (บาท)</th>
                </tr>
            </thead>
            <tbody>
            @php  $i=0;  @endphp
            @foreach ($types->groupBy('group_title') as $group => $lines)
                @php
                    $i++;
                    $ii=0;
                @endphp
                <tr>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;font-weight:bold;text-align:left;padding-left:5px;">{{ $i }} <b>{{ $group }}</b><br></td>
                    <th style="border-right:1px solid #000;width:150px;text-align:right"></th>
                </tr>
                @foreach ($lines as $line)
                    @php $ii++;  @endphp
                <tr>
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:left;padding-left:25px;">{{ $i }}.{{ $ii }} <b>{{ $line->item_title }}</td>
                    <td style="border-right:1px solid #000;text-align: right;">{{ number_format($line->amt_insure,2)  }}</td>
                </tr>
                @endforeach
                <tr style="">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:center;padding-right:5px;">รวม </td>
                    <td style="border-right:1px solid #000;text-align: right;border-top:1px solid #000;border-bottom: 1px solid #000;">{{ number_format($lines->sum('amt_insure'),2) }}</td>
                </tr>
            @endforeach
                <tr style="border-top:1px solid #000;border-bottom: 1px solid #000;">
                    <td style="border-right:1px solid #000;border-left:1px solid #000;text-align:center;padding-right:5px;">รวม{{ $type }}</td>
                    <td style="border-right:1px solid #000;text-align:right;">{{ number_format($types->sum('amt_insure'),2) }}</td>
                </tr>
                <tr>
                    <th colspan=2 style="text-align:left;height:30px;"></th>
                </tr>
        @endforeach
            </tbody>
        </table>

     </div>
    @endforeach
    </body>
</html>
