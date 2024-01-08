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
        $colspan=9;
    @endphp
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->name }}
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
                    <th style="width:135px;text-align:left"> เลขที่ใบเสร็จรับเงิน</th>
                    <th style="width:90px;text-align:left;">รหัสร้านค้า</th>
                    <th style="min-width:200px;text-align:left;"> ชื่อร้านค้า</th>
                    <th style="width:120px;text-align:right"> ขายเงินสด<br>(บุหรี่) &nbsp;&nbsp; </th>
                    <th style="width:120px;text-align:right"> ขายเงินสด<br>(ยาเส้น)&nbsp;&nbsp; </th>
                    <th style="width:120px;text-align:right"> เงินเชื่อ 7 วัน</th>
                    <th style="width:120px;text-align:right"> เงินเชื่อ 28 วัน</th>
                    <th style="width:150px;text-align:right"> รวมหนี้</th>
                    <th style="width:150px;text-align:right"> ยอดเงินที่ชำระ</th>
                </tr>
                <tr style="height:10px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>

            </thead>
            <tbody>
                @php 
                $sumary1 = 0;
                $sumary2 = 0;
                $sumary3 = 0;
                $sumary4 = 0;
                $sumary5 = 0;
                $sumary6 = 0;
                @endphp
            @foreach ($data->sortBy(function($i) {
                if($i->g1 == 'ne') {
                    $i->g1 =1;
                } else {
                    $i->g1 =2;
                }
                return $i->g1. $i->payment_number;
            })->groupBy('g1') as $group => $lines)
                <tr style="height:10px;">
                    <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}" ></th>
                </tr>
                @php 
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total5 = 0;
                $total6 = 0;
                @endphp
                    @foreach ($lines->groupBy('payment_number') as $line )
                    @php 
                        
                        $cash1 = @$line->sum('col1');
                        $cash2 = @$line->sum('col2');
                        $cash3 = @$line->sum('credit_group_code_3');
                        $cash4 = @$line->sum('credit_group_code_2');
                        $cash6 = @$line->sum('pd_payment_amount');
                        $cash5 = $cash1 + $cash2 +$cash4 + $cash3;

                        $total1 += $cash1;
                        $total2 += $cash2;
                        $total3 += $cash3;
                        $total4 += $cash4;
                        $total5 += $cash5;
                        $total6 += $cash6;

                        $sumary1 += $cash1;
                        $sumary2 += $cash2;
                        $sumary3 += $cash3;
                        $sumary4 += $cash4;
                        $sumary5 += $cash5;
                        $sumary6 += $cash6;
                    @endphp
                    <tr>
                        <td style="text-align: left;">{{ @$line->first()->payment_number }}</td>
                        <td style="text-align: left;">{{ @$line->first()->customer_number }}</td>
                        <td style="text-align: left;">{{ @$line->first()->customer_name }}</td>
                        <td style="text-align: right;">{!! @$line->first()->payment_status =="Cancel" ? '<span>ยกเลิกใบเสร็จ</span>' : ($cash1 > 0 ? number_format($cash1, 2) : '0.00') !!}</td>
                        <td style="text-align: right;">{{ @$line->first()->payment_status =="Cancel" ? '' : ($cash2 > 0 ? number_format($cash2, 2) : '0.00') }}</td>
                        <td style="text-align: right;">{{ @$line->first()->payment_status =="Cancel" ? '' : ($cash3 > 0 ? number_format($cash3, 2) : '0.00') }}</td>
                        <td style="text-align: right;">{{ @$line->first()->payment_status =="Cancel" ? '' : ($cash4 > 0 ? number_format($cash4, 2) : '0.00') }}</td>
                        <td style="text-align: right;">{{ @$line->first()->payment_status =="Cancel" ? '' : ($cash5 > 0 ? number_format($cash5, 2) : '0.00') }}</td>
                        <td style="text-align: right;">{{ @$line->first()->payment_status =="Cancel" ? '' : ($cash6 > 0 ? number_format($cash6, 2) : '0.00') }}</td>
                    </tr>
                    @endforeach
                   
                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                        <td colspan=3 style="text-align: right;">รวม</td>
                        <td style="text-align: right;">{{ $total1 > 0 ? number_format($total1, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $total2 > 0 ? number_format($total2, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $total3 > 0 ? number_format($total3, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $total4 > 0 ? number_format($total4, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $total5 > 0 ? number_format($total5, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $total6 > 0 ? number_format($total6, 2) : '0.00' }}</td>
                    </tr>
                @endforeach
                @php 
                        $cash1 = @$data->where('credit_group_code', 0)->where('product_type_code', 10)->sum('debt_amount');
                        $cash2 = @$data->where('credit_group_code', 0)->where('product_type_code', 20)->sum('debt_amount');
                        $cash3 = @$data->where('credit_group_code', 3)->sum('debt_amount');
                        $cash4 = @$data->where('credit_group_code', 2)->sum('debt_amount');
                        $cash5 = @$data->sum('debt_amount');
                        $cash6 = @$data->sum('payment_amount');
                    @endphp
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:40px;">
                    <td colspan=3_ style="text-align: right;">รวมทั้งสิ้น</td>
                    <td style="text-align: right;">{{ $sumary1 > 0 ? number_format($sumary1, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $sumary2 > 0 ? number_format($sumary2, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $sumary3 > 0 ? number_format($sumary3, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $sumary4 > 0 ? number_format($sumary4, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $sumary5 > 0 ? number_format($sumary5, 2) : '0.00' }}</td>
                        <td style="text-align: right;">{{ $sumary6 > 0 ? number_format($sumary6, 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="{{$colspan}}">
                        <div style="padding-top:10px;">หมายเหตุรายการ :  {{ $remark }}</div>
                        <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="{{$colspan}}">
                        <div style="padding-top:30px;text-align:right">
                                <div>ผู้จัดทำ _____________________________</div><br>
                                <div>หัวหน้ากอง _____________________________</div><br>
                                <div>หัวหน้าส่วนงาน _____________________________</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%">
           
        </table>
        

       
    </body>
</html>
