<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode->program_code }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
    </head>
    <body>
    @php
        $colspan=7;
    @endphp
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left" class="b">
                                โปรแกรม : {{ $programCode->program_code }}<br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                            </div>
                            <div style="width:60%;text-align:center" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                @php 
                                $date = explode('-', $month);
                                @endphp
                                ประจำเดือน {{ $thaimonths[sprintf('%02d', $date[1])]}}  {{ $date[0]+543 }} 
                                
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
                    <th style="text-align:center"> วันที่</th>
                    <th style="text-align:right; padding-right:15px"> ขายเงินสด</th>
                    <th style="text-align:right; padding-right:15px"> ขายเงินสดบุหรี่</th>
                    <th style="text-align:right; padding-right:15px"> ขายเงินสดยาเส้น</th>
                    <th style="text-align:right; padding-right:15px"> เงินเชื่อ 7 วัน</th>
                    <th style="text-align:right; padding-right:15px"> เงินเชื่อ 28 วัน</th>
                    <th style="text-align:right; padding-right:15px"> รวมหนี้</th>
                </tr>
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">ร้านค้าทั่วไป</td>
                </tr>
                @php 
                    $totalLine = 0;
                    $sumary = 0;
                @endphp
                @foreach($storeTypeGE->groupBy('day') as  $day => $item)
                @php 
                    $cash = $item
                    ->whereNotIn('customer_type', ['30', '80', '40'])
                    ->where('credit_group_code', '0')
                    // ->where('product_type_code', '10')
                    ->sum('payment_amount');
                    // + 
                    // $item->where('credit_group_code', '0')
                    // ->where('product_type_code', '20')
                    // ->sum('payment_amount'); 
                    $totalLine = 
                    $item->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount') +
                    $item->whereNotIn('customer_type', ['30', '80'])->where('credit_group_code', '0')->where('product_type_code', '20')->sum('payment_amount') +
                    $item->whereNotIn('customer_type', ['30', '80', '40'])->where('credit_group_code', '3')->sum('payment_amount') +
                    $item->where('credit_group_code', '2')->sum('payment_amount');
                    $sumary += $totalLine;
                
                @endphp
                <tr>
                    <td>{{ $day }}</td>
                    <td style="text-align: right">{{ number_format($cash, 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->whereNotIn('customer_type', ['30', '80'])->where('credit_group_code', '0')->where('product_type_code', '20')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->whereNotIn('customer_type', ['30', '80', '40'])->where('credit_group_code', '3')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '2')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($totalLine, 2) }}</td>
                </tr>
                @endforeach
                @php 
                $column1 = $storeTypeGE->whereNotIn('customer_type', ['30', '80', '40'])->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount') + $storeTypeGE->where('credit_group_code', '0')->where('product_type_code', '20')->sum('payment_amount');
                $column2 = $storeTypeGE->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount');
                $column3 = $storeTypeGE->whereNotIn('customer_type', ['30', '80'])->where('credit_group_code', '0')->where('product_type_code', '20')->sum('payment_amount');
                $column4 = $storeTypeGE->whereNotIn('customer_type', ['30', '80', '40'])->where('credit_group_code', '3')->sum('payment_amount');
                $column5 = $storeTypeGE->where('credit_group_code', '2')->sum('payment_amount');
                $column6 = $sumary;
                @endphp
                <tr style="border-top:1px solid #000;border-bottom: 1px solid #000">
                    <td>รวมร้านค้าทั่วไป</td>
                    <td style="text-align: right">{{ number_format($column1, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column2, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column3, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column4, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column5, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column6, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="6">สโมสร กทม.</td>
                </tr>
                @php 
                    $sumary = 0;
                @endphp
                @php
                $items = $storeTypeC->groupBy('day');
                @endphp
                @foreach($storeTypeGE->groupBy('day') as  $day => $item)
                
                @php 
                    $item = collect(@$items[$day]);
                    $totalLine = 0;
                    $totalLine += 
                    $item->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount') + 
                    $item->where('credit_group_code', '0')->where('p_product_type_code', '20')->sum('payment_amount') + 
                    $item->where('credit_group_code', '3')->sum('payment_amount') + 
                    $item->where('credit_group_code', '2')->sum('payment_amount');
                    
                    $sumary += $totalLine;
                @endphp
                <tr>
                    <td>{{ $day }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '0')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '0')->where('p_product_type_code', '20')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '3')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($item->where('credit_group_code', '2')->sum('payment_amount'), 2) }}</td>
                    <td style="text-align: right">{{ number_format($totalLine, 2) }}</td>
                </tr>
                @endforeach
                @php 
                $scolumn1 = $storeTypeC->where('credit_group_code', '0')->sum('payment_amount');
                $scolumn2 = $storeTypeC->where('credit_group_code', '0')->where('product_type_code', '10')->sum('payment_amount');
                $scolumn3 = $storeTypeC->where('credit_group_code', '0')->where('p_product_type_code', '20')->sum('payment_amount');
                $scolumn4 = $storeTypeC->where('credit_group_code', '3')->sum('payment_amount');
                $scolumn5 = $storeTypeC->where('credit_group_code', '2')->sum('payment_amount');
                $scolumn6 = $sumary;
                @endphp
                <tr style="border-top:1px solid #000;border-bottom: 1px solid #000">
                    <td>รวมสโมสร กทม.</td>
                    <td style="text-align: right">{{ number_format($scolumn1, 2) }}</td>
                    <td style="text-align: right">{{ number_format($scolumn2, 2) }}</td>
                    <td style="text-align: right">{{ number_format($scolumn3, 2) }}</td>
                    <td style="text-align: right">{{ number_format($scolumn4, 2) }}</td>
                    <td style="text-align: right">{{ number_format($scolumn5, 2) }}</td>
                    <td style="text-align: right">{{ number_format($scolumn6, 2) }}</td>
                </tr>
                <tr style="border-top:1px solid #000;border-bottom: 1px solid #000">
                    <td>รวมทั้งสิ้น</td>
                    <td style="text-align: right">{{ number_format($column1 + $scolumn1, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column2 + $scolumn2, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column3 + $scolumn3, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column4 + $scolumn4, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column5 + $scolumn5, 2) }}</td>
                    <td style="text-align: right">{{ number_format($column6 + $scolumn6, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="7">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <table style="width:100%">
                            <tr>
                                <td style="text-align: center">ผู้จัดทำ..............................................</td>
                                <td style="text-align: center">หัวหน้ากอง..............................................</td>
                                <td style="text-align: center">หัวหน้าส่วนงาน..............................................</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="padding-top:10px;">หมายเหตุรายการ :  {{ $remark }}</div>
        {{-- <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div> --}}

        {{-- <div style="padding-top:2px;text-align:right">
                <div>ผู้จัดทำ ________________________________ </div><br>
                <div>ผู้ตรวจสอบ ________________________________</div><br>
        </div> --}}
    </body>
</html>
