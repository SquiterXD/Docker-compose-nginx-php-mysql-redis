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
        $count_s=0;
        $colspan=8;
    @endphp
    <div class="page-break">
        @php
            $count_s++;
        @endphp
        <div class="page-break"></div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{$colspan}}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}<br>
                                <br>

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
                                 <br>
                            </div>
                        </div>

                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <th style="width:40px;text-align:left;"> ลำดับ</th>
                    <th style="width:50px;text-align:left;">วันที่สั่ง</th>
                    <th style="width:60px;text-align:left;">รหัสร้านค้า</th>
                    <th style="min-width:200px;text-align:left;"> ชื่อร้านค้า</th>
                    <th style="width:150px;text-align:left;"> จังหวัด</th>
                    <th style="width:80px;text-align:left;"> บัญชีเลขที่</th>
                    <th style="width:200px;text-align:left;"> ชื่อธนาคาร</th>
                    <th style="width:150px;text-align:left;"> สาขา</th>
                </tr>
                <tr style="height:10px;">
                    <th colspan="{{$colspan}}"></th>
                </tr>
            </thead>
            <tbody>

            @php
                $ii=1;
            @endphp
            @foreach ($data as $line)
                <tr style="height:25px;">
                    <td>{{ $ii++ }}</td>
                    <td>{{ $line->delivery_date }}</td>
                    <td>{{ $line->customer_number }}</td>
                    <td>{{ $line->customer_name }}</td>
                    <td>{{ $line->province_name }}</td>
                    <td>{{ $line->account_number }}</td>
                    <td>{{ $line->bank_name }}</td>
                    <td>{{ $line->branch_name }}</td>
                </tr>
            @endforeach
            @if(count($data)==0)
                <tr>
                    <td colspan="{{$colspan}}" style="text-align:center;height:40px;"> ไม่พบข้อมูล </td>
                </tr>
            @endif
                <tr style="border-top: 1px solid #000;height:10px;">
                    <td colspan="{{$colspan}}"></td>
                </tr>
            </tbody>
        </table>
        <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>

     </div>
    </body>
</html>
