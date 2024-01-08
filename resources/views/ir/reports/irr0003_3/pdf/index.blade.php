<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $programCode }} - {{ $progTitle }}</title>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    @include('ir.reports.irr0003_3._style')
</head>
@php
$c = 0;
$progType = '';
$progType_tmp = '';
$comp_percent = '';
$progTitle = '';
$progPara = [];
$headLeft = [];
$progTitle = '';
@endphp

<body>
    {{-- @php
        dd($GroupSet);
    @endphp --}}
    @foreach ($GroupSet as $key => $items)
        @php
            $comp_percent = (isset($items['data']->first()->comp_percent)) ? $items['data']->first()->comp_percent : "100";
            $progTitle = $items['progTitle'];
            $progPara = $items['progPara'] ;
            $headLeft = $items['headLeft'] ;
            $diff_value = $items['diff_value'] ;

        @endphp
        @foreach ($items['data']->groupBy('receivable_name') as $receivable => $groups)
                @php
                $c += 3;
                $progType = $receivable;
                @endphp
            @php
                $colspan = 3;
                $total = 0;
                if ($items['progType'] == $progType && $items['progType'] == $progType_tmp) {
                    $progType = $items['progType'];
                } elseif ($items['progType'] != $progType && $items['progType'] == $progType_tmp) {
                    $progType_tmp = $items['progType'];
                } elseif ($items['progType'] != $progType && $items['progType'] != $progType_tmp) {
                    $progType = $items['progType'];
                    $progType_tmp = $items['progType'];
                }
            @endphp
            <div class="page-break">
                {{-- @if (!$loop->last) --}}
                    @if (!empty($items['data']))
                        <div class="page-break"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="{{ $colspan }}">
                                        <div class="row" style="margin-top: 16px;">
                                            <div style="width:20%;text-align:left;font-weight: normal;">
                                                <span class='b'>โปรแกรม : </span>{{ $programCode }}<br>
                                                <span class='b'>สั่งพิมพ์ :
                                                </span>{{ optional(auth()->user())->name }}<br>
                                                <br>
                                            </div>
                                            <div style="width:60%;text-align:center;border:1px">
                                                <span style="font-size: 18px;"
                                                    class="b">การยาสูบแห่งประเทศไทย</span><br>
                                                    <span style='font-size: 16px;'  class='b'>{{ $progTitle }}</span>
                                                @php
                                                    foreach ($progPara as $para) {
                                                        echo '<br>' . $para;
                                                    }
                                                @endphp
                                            </div>
                                            <div style="width:20%;text-align:right;font-weight: normal;">
                                                <span class='b'>วันที่ : </span>{{ parseToDateTh(now()) }}<br>
                                                <span class='b'>เวลา : </span> &nbsp; &nbsp; &nbsp; &nbsp;
                                                {{ date('H:i', strtotime(now())) }}<br>
                                                <span class='b'>หน้า : </span><span
                                                    class="pagenum">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div style="width:100%;text-align:left;font-weight: normal;">
                                                @php
                                                    foreach ($headLeft as $title) {
                                                        echo $title . '<br>';
                                                    }

                                                @endphp
                                                <span class='b'>ประเภท : </span> : {{$progType}}<br>
                                            </div>
                                            {{-- <div style="width:40%;text-align:right;" class="b">
                                    @php
                                        foreach($headRight as $title){
                                            echo $title."<br>";
                                        }
                                    @endphp
                                </div> --}}
                                        </div>
                                    </th>
                                </tr>
                                <tr
                                    style="border-top: 0.5px solid #000;border-bottom: 0.5px solid #000;font-weight:bold;height:30px;background-color: rgb(200, 200, 200);">
                                    <th
                                        style="border-right:0.5px solid #000;border-left:0.5px solid #000;width:30px;text-align:center;">
                                        ลำดับ<br></th>
                                    <th
                                        style="border-right:0.5px solid #000;min-width:300px;text-align:center;padding-left:5px">
                                        รายการ<br></th>
                                    <th style="border-right:0.5px solid #000;width:150px;text-align:center;">ค่าเบี้ยประกัน
                                        (บาท)({{ $comp_percent }}%)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $c=0; @endphp
                                @php  $i=0; @endphp
                                @foreach ($groups->groupBy('group_01') as $group => $cats)
                                    @php
                                        $i++;
                                        $ii = 0;
                                        $c++;
                                    @endphp
                                    @if ($c % 40 == 0)
                                        <tr style="border-bottom: 0.5px solid #000;">
                                        @else
                                        <tr>
                                    @endif
                                    <td
                                        style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center">
                                        {{ $i }}.<br></td>
                                    <td
                                        style="border-right:0.5px solid #000;border-left:0.5px solid #000;font-weight:bold;text-align:left;">
                                        <b>{{ $group }}</b><br>
                                    </td>
                                    <th style="border-right:0.5px solid #000;width:150px;text-align:right"></th>
                                    </tr>
                                    @foreach ($cats->groupBy('group_02') as $cat => $lines)
                                        @php
                                            $ii++;
                                            $c++;
                                        @endphp
                                        @if ($c % 40 == 0)
                                            <tr style="border-bottom: 0.5px solid #000;">
                                            @else
                                            <tr>
                                        @endif
                                        <td
                                            style="border-right:0.5px solid #000;border-left:0.5px solid #000;width:80px;text-align:center">
                                            {{ $i }}.{{ $ii }}<br></td>
                                        <td style="border-right:0.5px solid #000;font-weight:bold;text-align:left;">
                                            <b>{{ $cat }}</b><br>
                                        </td>
                                        <th style="border-right:0.5px solid #000;width:150px;text-align:right"></th>
                                        </tr>
                                        @foreach ($lines as $line)
                                            @php $c++; @endphp
                                            @if ($c % 40 == 0)
                                                <tr style="border-bottom: 0.5px solid #000;">
                                                @else
                                                <tr>
                                            @endif
                                            <td
                                                style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center">
                                            </td>
                                            <td style="border-right:0.5px solid #000;text-align: left;padding-left:20px;">
                                                {{ $line->cat_title }}</td>
                                            <td style="border-right:0.5px solid #000;text-align: right;">
                                                {{ number_format($line->amt_insure, 2)  }}</td>
                                            </tr>
                                        @endforeach
                                        @php $c++; @endphp
                                        @if ($c % 40 == 0)
                                            <tr style="border-bottom: 0.5px solid #000;">
                                            @else
                                            <tr>
                                        @endif
                                        <td
                                            style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:left;">
                                        </td>
                                        <td style="border-right:0.5px solid #000;text-align: right;padding-right:5px;"></td>
                                        <td
                                            style="border-right:0.5px solid #000;text-align: right;border-top:0.5px solid #000;border-bottom:0.5px solid #000;background-color: rgb(240, 240, 240); font-weight: bold;">
                                            {{ number_format($lines->sum('amt_insure'), 2) }}</td>
                                        </tr>
                                        @php
                                            $total += $lines->sum('amt_insure');
                                        @endphp
                                    @endforeach
                                    @php $c++; @endphp
                                    <tr
                                        style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: rgb(240, 240, 240);">
                                        <td style="border-right:none;border-left:0.5px solid #000;text-align:left;"></td>
                                        <td style="border-right:0.5px solid #000;text-align: center;padding-right:5px; font-weight: bold;">รวม
                                            :
                                            {{ $line->group_01 }}</td>
                                        <td
                                            style="border-right:0.5px solid #000;text-align: right;border-top:0.5px solid #000;border-bottom:0.5px solid #000; font-weight: bold;">
                                            {{ number_format($total, 2) }}</td>
                                    </tr>
                                    @php
                                        $total = 0;
                                    @endphp
                                @endforeach
                                @php $c++; @endphp
                                <tr
                                    style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: rgb(240, 240, 240);">
                                    <td
                                        style="border-right:none;border-left:0.5px solid #000;border-right:none;text-align:left;">
                                    </td>
                                    <td style="border-right:0.5px solid #000;text-align:center;padding-right:5px; font-weight: bold;">รวม :
                                        {{ $progType }}</td>
                                    <td style="border-right:0.5px solid #000;text-align:right; font-weight: bold;">
                                        {{ number_format( $groups->sum('amt_insure'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- @else
                        <div style="padding-top:10px;text-align:center"> ไม่มีข้อมูลตามเงื่อนไขที่ท่านเลือก </div> --}}
                    @endif
                @if ($loop->last)
                        @php
                        $c += 3;
                        $progType = 'อากรแสตมป์';
                        @endphp
                        <div class="page-break"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="{{ $colspan }}">
                                        <div class="row" style="margin-top: 16px;">
                                            <div style="width:20%;text-align:left;font-weight: normal;">
                                                <span class='b'>โปรแกรม : </span>{{ $programCode }}<br>
                                                <span class='b'>สั่งพิมพ์ :
                                                </span>{{ optional(auth()->user())->name }}<br>
                                                <br>
                                            </div>
                                            <div style="width:60%;text-align:center">
                                                <span style="font-size: 18px;"
                                                    class="b">การยาสูบแห่งประเทศไทย</span><br>
                                                {{ $progTitle }}
                                                @php
                                                    foreach ($progPara as $para) {
                                                        echo '<br>' . $para;
                                                    }
                                                @endphp
                                            </div>
                                            <div style="width:20%;text-align:right;font-weight: normal;">
                                                <span class='b'>วันที่ : </span>{{ parseToDateTh(now()) }}<br>
                                                <span class='b'>เวลา : </span> &nbsp; &nbsp; &nbsp; &nbsp;
                                                {{ date('H:i', strtotime(now())) }}<br>
                                                <span class='b'>หน้า : </span><span
                                                class="pagenum">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div style="width:100%;text-align:left;font-weight: normal;">
                                                @php
                                                    foreach ($headLeft as $title) {
                                                        echo $title . '<br>';
                                                    }

                                                @endphp
                                                <span class='b'>ประเภท : </span> : {{$progType}}<br>
                                            </div>
                                            {{-- <div style="width:40%;text-align:right;" class="b">
                                    @php
                                        foreach($headRight as $title){
                                            echo $title."<br>";
                                        }
                                    @endphp
                                </div> --}}
                                        </div>
                                    </th>
                                </tr>
                                <tr
                                    style="border-top: 0.5px solid #000;border-bottom: 0.5px solid #000;font-weight:bold;height:30px;background-color: rgb(200, 200, 200);">
                                    <th
                                        style="border-right:0.5px solid #000;border-left:0.5px solid #000;width:30px;text-align:center;">
                                        ลำดับ<br></th>
                                    <th
                                        style="border-right:0.5px solid #000;min-width:300px;text-align:center;padding-left:5px">
                                        รายการ<br></th>
                                    <th style="border-right:0.5px solid #000;width:150px;text-align:center;">อากรแสตมป์
                                        (บาท)({{ $comp_percent }}%)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @php  $i=0; @endphp
                            @foreach ($items['data_duty_vat'] as $receivable => $groups)
                                <tr>
                                    <td
                                    style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center">{{ ($i+1) }}</td>
                                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:left;">อากรแสตมป์ - {{ $groups->receivable_name }}</td>
                                    <td style="border-right:0.5px solid #000;text-align: right;">{{ number_format($groups->duty_amount,2) }}</td>
                                </tr>
                                @if ($loop->last)
                                    @php $c++; @endphp
                                    <tr
                                        style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: rgb(240, 240, 240);">
                                        <td
                                            style="border-right:none;border-left:0.5px solid #000;border-right:none;text-align:left;">
                                        </td>
                                        <td style="border-right:0.5px solid #000;text-align:center;padding-right:5px;">รวม :
                                            {{ $progType }}</td>
                                        <td style="border-right:0.5px solid #000;text-align:right;">
                                            {{ number_format($items['data_duty_vat']->sum('duty_amount'), 2) }}</td>
                                    </tr>
                                @endif
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>

                        @php
                        $c += 3;
                        $progType = 'ภาษีซื้อไม่ถึงกำหนด';
                        @endphp
                        <div class="page-break"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="{{ $colspan }}">
                                        <div class="row" style="margin-top: 16px;">
                                            <div style="width:20%;text-align:left;font-weight: normal;">
                                                <span class='b'>โปรแกรม : </span>{{ $programCode }}<br>
                                                <span class='b'>สั่งพิมพ์ :
                                                </span>{{ optional(auth()->user())->username }}<br>
                                                <br>
                                            </div>
                                            <div style="width:60%;text-align:center">
                                                <span style="font-size: 18px;"
                                                    class="b">การยาสูบแห่งประเทศไทย</span><br>
                                                {{ $progTitle }}
                                                @php
                                                    foreach ($progPara as $para) {
                                                        echo '<br>' . $para;
                                                    }
                                                @endphp
                                            </div>
                                            <div style="width:20%;text-align:right;font-weight: normal;">
                                                <span class='b'>วันที่ : </span>{{ parseToDateTh(now()) }}<br>
                                                <span class='b'>เวลา : </span> &nbsp; &nbsp; &nbsp; &nbsp;
                                                {{ date('H:i', strtotime(now())) }}<br>
                                                <span class='b'>หน้า : </span><span
                                                class="pagenum">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div style="width:100%;text-align:left;font-weight: normal;">
                                                @php
                                                    foreach ($headLeft as $title) {
                                                        echo $title . '<br>';
                                                    }

                                                @endphp
                                                <span class='b'>ประเภท : </span> : {{$progType}}<br>
                                            </div>
                                            {{-- <div style="width:40%;text-align:right;" class="b">
                                    @php
                                        foreach($headRight as $title){
                                            echo $title."<br>";
                                        }
                                    @endphp
                                </div> --}}
                                        </div>
                                    </th>
                                </tr>
                                <tr
                                    style="border-top: 0.5px solid #000;border-bottom: 0.5px solid #000;font-weight:bold;height:30px;background-color: rgb(200, 200, 200);">
                                    <th
                                        style="border-right:0.5px solid #000;border-left:0.5px solid #000;width:30px;text-align:center;">
                                        ลำดับ<br></th>
                                    <th
                                        style="border-right:0.5px solid #000;min-width:300px;text-align:center;padding-left:5px">
                                        รายการ<br></th>
                                    <th style="border-right:0.5px solid #000;width:150px;text-align:center;">ภาษีซื้อไม่ถึงกำหนด
                                        (บาท)({{ $comp_percent }}%)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php  $i=0; @endphp
                                @foreach ($items['data_duty_vat'] as $receivable => $groups)
                                <tr>
                                    <td
                                    style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:center">{{ ($i+1) }}</td>
                                    <td style="border-right:0.5px solid #000;border-left:0.5px solid #000;text-align:left;">ภาษีซื้อไม่ถึงกำหนด - {{ $groups->receivable_name }}</td>
                                    <td style="border-right:0.5px solid #000;text-align: right;">{{ number_format($groups->vat_amount,2) }}</td>
                                </tr>
                                @if ($loop->last)
                                    @php $c++; @endphp
                                    <tr
                                        style="border-top:0.5px solid #000;border-bottom: 0.5px solid #000;background-color: rgb(240, 240, 240);">
                                        <td
                                            style="border-right:none;border-left:0.5px solid #000;border-right:none;text-align:left;">
                                        </td>
                                        <td style="border-right:0.5px solid #000;text-align:center;padding-right:5px;">รวม :
                                            {{ $progType }}</td>
                                        <td style="border-right:0.5px solid #000;text-align:right;">
                                            {{ number_format($items['data_duty_vat']->sum('vat_amount'), 2) }}</td>
                                    </tr>
                                @endif
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                @endif
            </div>
        @endforeach
    @endforeach
</body>

</html>
