<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    <body>
        @for ($i = 0; $i < count($data); $i++)
            <div class="page-break">
                <div class="page-break"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <div class="row">
                                    <div style="width:20%;text-align:left" class="b">
                                        โปรแกรม : {{ $programCode }}<br>
                                        สั่งพิมพ์ : {{ optional(auth()->user())->username }} <br>
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
                                        {{ $groups[$i]->customer_name }}
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
                        <tr style="border-top: 1px solid #000;height:30px;">
                            <th rowspan=2 style="width:80px;text-align:left"><br></th>
                            <th rowspan=2 style="min-width:200px;text-align:left;padding-left:5px">รายการสินค้า<br></th>
                            <th rowspan=2 style="width:100px;text-align:right"> จำนวน<br>(พันมวน)</th>
                            <th colspan=2 style="text-align:center">ราคา 2</th>
                            <th colspan=2 style="text-align:center">ราคา 1</th>
                            <th rowspan=2 style="width:150px;text-align:right">ผลต่างราคา<br></th>
                        </tr>
                        <tr style="border-bottom: 1px solid #000;height:30px;">
                            <th rowspan style="width:120px;text-align:right">บาท/พันมวน</th>
                            <th rowspan style="width:150px;text-align:right">จำนวนเงิน</th>
                            <th rowspan style="width:120px;text-align:right">บาท/พันมวน</th>
                            <th rowspan style="width:150px;text-align:right">จำนวนเงิน</th>
                        </tr>
                        <tr style="height:30px;">
                            <td colspan="8"></td>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalQty = 0;
                        $totalQty1 = 0;
                        $totalAmt1 = 0;
                        $totalQty2 = 0;
                        $totalAmt2 = 0;
                        $totalDiff = 0;
                    @endphp
                    {{-- @foreach ($data->groupBy('item_type') as $group => $lines) --}}
                    {{-- @foreach ($data->groupBy('item_type') as $group => $lines) --}}
                    @foreach ($data[$i] as $key=>$group)
                        @php
                            $sumQty = 0;
                            $sumQty1 = 0;
                            $sumAmt1 = 0;
                            $sumQty2 = 0;
                            $sumAmt2 = 0;
                            $sumDiff = 0;
                            $dataCount = count($data[$i]);
                        @endphp
                        {{-- <tr style="height:30px;">
                            <th style="font-weight:bold;text-align:left;" colspan="8" ><br><br>{{ $group->item_description }}</th>
                        </tr> --}}
                        {{-- @foreach ($lines as $line ) --}}
                            @if($group->item_description<>"")
                                @php
                                    $totalQty += $group->qty;
                                    $totalAmt1 += $group->amt1;
                                    $totalAmt2 += $group->amt2;
                                    $totalDiff += $group->diff_amt;
                                    $sumQty += $group->qty;
                                    $sumAmt1 += $group->amt1;
                                    $sumAmt2 += $group->amt2;
                                    $sumDiff += $group->diff_amt;
                                @endphp
                            <tr style="height:23px;">
                                <td></td>
                                <td style="text-align: left;">{{ $group->item_description }}</td>
                                <td style="text-align: right;">{{ ($group->qty<>0)?number_format($group->qty,2):'0' }}</td>
                                <td style="text-align: right;">{{ ($group->price2<>0)?number_format($group->price2,2):'0' }}</td>
                                <td style="text-align: right;">{{ ($group->amt2<>0)?number_format($group->amt2,2):'0' }}</td>
                                <td style="text-align: right;">{{ ($group->price1<>0)?number_format($group->price1,2):'0' }}</td>
                                <td style="text-align: right;">{{ ($group->amt1<>0)?number_format($group->amt1,2):'0' }}</td>
                                <td style="text-align: right;">{{ ($group->diff_amt<>0)?number_format($group->diff_amt,2):'0' }}</td>
                            </tr>
                            @endif
                        {{-- @endforeach --}}
                        @if($dataCount <= $key)
                            <tr style="height:10px;">
                                <td colspan="9"></td>
                            </tr>
                            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:35px;">
                                <td colspan=2 style="text-align: left;">รวม</td>
                                <td style="text-align: right;">{{ number_format($sumQty,2) }}</td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;">{{ number_format($sumAmt2,2) }}</td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;">{{ number_format($sumAmt1,2) }}</td>
                                <td style="text-align: right;">{{ number_format($sumDiff,2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                        <tr style="height:20px;">
                            <td colspan="8"></td>
                        </tr>
                        <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:35px;">
                            <td colspan=2 style="text-align: left;">รวมทั้งสิ้น</td>
                            <td style="text-align: right;">{{ number_format($totalQty,2) }}</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">{{ number_format($totalAmt2,2) }}</td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">{{ number_format($totalAmt1,2) }}</td>
                            <td style="text-align: right;">{{ number_format($totalDiff,2) }}</td>
                        </tr>
                        <tr style="height:20px;">
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;">ค่าตอบแทน</td>
                            <td colspan=5 style="text-align: left;">= {{ number_format($totalDiff*95/100,2) }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;">VAT</td>
                            <td colspan=5 style="text-align: left;">= {{ number_format(($totalDiff*95/100)*(7/107),2) }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;">มูลค่า</td>
                            <td colspan=5 style="text-align: left;">= {{ number_format(($totalDiff*95/100)-(($totalDiff*95/100)*(7/107)),2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding-top:10px;">หมายเหตุรายการ : {{ $remark }}</div>
            </div>
        @endfor
    </body>
</html>
