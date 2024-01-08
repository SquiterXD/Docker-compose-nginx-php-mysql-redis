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
    @foreach($data->sortBy('group_product')->groupBy('group_product') as $k => $group)
    @if(!$loop->first)
    <div style="page-break-after: always;" ></div>
    @endif
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                               
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                ประจำวันที่ {{ parseToDateTh(date('Y-m-d', strtotime($date_from))) }} ถึงวันที่ {{ parseToDateTh(date('Y-m-d', strtotime($date_to))) }}
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
                    <th style="text-align:center"> ตราบุหรี่</th>
                    <th style="text-align:center"> 
                        @if($k == 1)
                            จำนวน (มวน)
                        @else 
                            จำนวน (กิโลกรัม)
                        @endif
                    </th>
                    <th style="text-align:center"> ราคา (บาท)</th>
                    <th style="text-align:center;"> ภาษีมูลค่าเพิ่ม (บาท)</th>
                    <th style="text-align:center"> ราคาขายหักภาษีฯ</th>
                    {{-- <th style="text-align:center"> รวม</th> --}}
                </tr>
                
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $approve_quantity = 0;
                    $grand_total = 0;
                    $tax = 0;
                    $sub_total = 0;
                    $sumary = 0;
                @endphp
                @foreach($group as $item)
                @php 
                    $approve_quantity += $item->approve_quantity;
                    $grand_total += $item->grand_total;
                    $tax += $item->tax;
                    $sub_total += $item->sub_total;

                    $lineSum = $item->approve_quantity + $item->grand_total + $item->tax + $item->sub_total;
                    $sumary += $lineSum;
                @endphp
                <tr>
                    <td > {{$item->item_description}}</td>
                    <td align="right"> {{ number_format($item->approve_quantity, 2) }}</td>
                    <td align="right" > {{ number_format($item->grand_total, 2) }}</td>
                    <td align="right" > {{ number_format($item->tax, 2) }}</td>
                    <td align="right" > {{ number_format($item->sub_total, 2) }}</td>
                    {{-- <td align="right" > {{ number_format($lineSum, 2) }}</td> --}}
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <th style="text-align:center"> รวม</th>
                    <th  align="right"> 
                        {{ number_format($approve_quantity, 2) }}
                    </th>
                    <th  align="right"> {{ number_format($grand_total, 2) }}</th>
                    <th align="right"> {{ number_format($tax, 2) }}</th>
                    <th  align="right"> {{ number_format($sub_total, 2) }}</th>
                    {{-- <th  align="right"> {{ number_format($sumary, 2) }}</th> --}}
                </tr>
            </tfoot>
        </table>
        @endforeach
        {{-- <div style="padding-top:2px;text-align:right">
                <div>ผู้จัดทำ ________________________________ </div><br>
                <div>ผู้ตรวจสอบ ________________________________</div><br>
        </div> --}}
    </body>
</html>
