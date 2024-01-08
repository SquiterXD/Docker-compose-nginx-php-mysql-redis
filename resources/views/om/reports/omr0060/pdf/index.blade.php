<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $programCode }} - {{ $progTitle }}</title>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    @include('om.reports._style')
</head>
</head>

<body>

    @php
        $colspan = 9;
        $total_qty_10 = 0;
        $total_rma = [
            'credit_group_code_2' => 0,
            'credit_group_code_3' => 0,
            'credit_group_code_0' => 0,
            'cigarate' => 0,
            'cash' => 0,
            'tobacco' => 0,
        ];
        function getRMAByCreditGroup($creditGroup, $itemLine)
        {
            return optional($itemLine->where('orderLine.credit_group_code', $creditGroup))->sum(function ($i) {
                return -1 * $i->rma_quantity * $i->orderLine->unit_price;
            });
        }
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
                                foreach ($progPara as $para) {
                                    echo $para . '<br>';
                                }
                            @endphp
                        </div>
                        <div style="width:20%;text-align:right;" class="b">
                            วันที่ : {{ parseToDateTh(now()) }}<br>
                            เวลา : &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                            หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            </span><br>

                        </div>
                    </div>
                </th>
            </tr>
            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:50px;">
                <th style="width:100px;text-align:left"> ใบกำกับสินค้า<br>เลขที่</th>
                <th style="min-width:220px;text-align:left;">ร้านค้า</th>
                <th style="width:140px;text-align:right"> กลุ่มเงินเชื่อ 2</th>
                <th style="width:140px;text-align:right"> กลุ่มเงินเชื่อ 3</th>
                <th style="width:140px;text-align:right"> วงเงินเชื่อที่กำหนด</th>
                <th style="width:140px;text-align:right"> เงินสด</th>
                <th style="width:150px;text-align:right"> รวมเงิน</th>
                <th style="width:100px;text-align:center"> บุหรี่<br>(พันมวน)</th>
                <th style="width:80px;text-align:center"> ยาเส้น<br>(หีบ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->groupBy('zone_name') as $group => $lines)
                <tr style="height:20px;">
                    <th colspan="{{ $colspan }}"></th>
                </tr>
                <tr style="height:25px;">
                    <th style="font-weight:bold;text-align:left;" colspan="{{ $colspan }}">{{ $group }}
                    </th>
                </tr>
                @php
                    $sum_qty_10 = 0;
                    $sum_rma = [
                        'credit_group_code_2' => 0,
                        'credit_group_code_3' => 0,
                        'credit_group_code_0' => 0,
                        'cigarate' => 0,
                        'tobacco' => 0,
                    ];
                @endphp
                @foreach ($lines->groupBy('so_no') as $keyc => $line)
                    {{-- @php
                        $sum=$line->amt2+$line->amt3+$line->amt5;
                    @endphp
                <tr>
                    <td>{{ $line->so_no }}</td>
                    <td style="text-align: left;">{{ $line->cus_name }}</td>
                    <td style="text-align: right;">{{ ($line->amt2<>0)?number_format($line->amt2,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->amt3<>0)?number_format($line->amt3,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->amt4<>0)?number_format($line->amt4,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->amt5<>0)?number_format($line->amt5,2):'' }}</td>
                    <td style="text-align: right;">{{ ($sum<>0)?number_format($sum,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->qty_10<>0)?number_format($line->qty_10,2):'' }}</td>
                    <td style="text-align: right;">{{ ($line->qty_20<>0)?number_format($line->qty_20,2):'' }}</td>
                </tr> --}}
                    @php
                        $linesAmt2 = $line->sum('amt2');
                        $linesAmt3 = $line->sum('amt3');
                        $linesAmt4 = $line->sum('amt4');
                        $linesAmt5 = $line->sum('amt5');
                        $rmaMarket = $rma->where('customer_id', $line->first()->customer_id);
                        $linesSum = $line->sum('amt2') + $line->sum('amt3') + $line->sum('amt5');
                        $linesQty_10 = $line->sum('qty_10');
                        $linesQty_20 = $line->sum('qty_20');
                        $actualTarget = $actual_quantity->where('consignment_no', $line->first()->so_no);
                        if (count($actualTarget) > 0) {
                            $linesQty_10 = $actualTarget->first()->actual_quantity;
                        }
                        $sum_qty_10 += $linesQty_10;
                        $total_qty_10 += $linesQty_10;
                    @endphp
                    <tr>
                        <td>{{ $line->first() ? $line->first()->so_no : '' }}</td>
                        <td style="text-align: left;">{{ $line->first() ? $line->first()->cus_name : '' }}</td>
                        <td style="text-align: right;">
                            {{ $linesAmt2 != 0 ? number_format($linesAmt2, 2) : '' }}</td>
                        <td style="text-align: right;">
                            {{ $linesAmt3 != 0 ? number_format($linesAmt3, 2) : '' }}</td>
                        <td style="text-align: right;">
                            {{ $linesAmt4 != 0 ? number_format($linesAmt4, 2) : '' }}</td>
                        <td style="text-align: right;">
                            {{ $linesAmt5 != 0 ? number_format($linesAmt5, 2) : '' }}</td>
                        <td style="text-align: right;">{{ $linesSum != 0 ? number_format($linesSum, 2) : '' }}
                        </td>
                        <td style="text-align: right;">{{ $linesQty_10 != 0 ? number_format($linesQty_10, 2) : '' }}
                        </td>
                        <td style="text-align: right;">{{ $linesQty_20 != 0 ? number_format($linesQty_20, 2) : '' }}
                        </td>
                    </tr>
                    @php
                        $sumRMA = 0;
                    @endphp
                    
                @endforeach
                @php
                    $sum = $lines->sum('amt2') + $lines->sum('amt3') + $lines->sum('amt5') + ($sum_rma['credit_group_code_2'] + $sum_rma['credit_group_code_3'] + $sum_rma['credit_group_code_0']);
                @endphp
                <tr style="height:5px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                    <td></td>
                    <td style="text-align: left;">ยอดรวม</td>
                    <td style="text-align: right;">
                        {{ $lines->sum('amt2') + $sum_rma['credit_group_code_2'] != 0 ? number_format($lines->sum('amt2') + $sum_rma['credit_group_code_2'], 2) : '' }}
                    </td>
                    <td style="text-align: right;">
                        {{ $lines->sum('amt3') + $sum_rma['credit_group_code_3'] != 0 ? number_format($lines->sum('amt3') + $sum_rma['credit_group_code_3'], 2) : '' }}
                    </td>
                    {{-- <td style="text-align: right;">{{ ($lines->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4')<>0)?number_format($lines->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4'),2):'' }}</td> --}}
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;">
                        {{ $lines->sum('amt5') + $sum_rma['credit_group_code_0'] != 0 ? number_format($lines->sum('amt5') + $sum_rma['credit_group_code_0'], 2) : '' }}
                    </td>
                    <td style="text-align: right;">{{ $sum != 0 ? number_format($sum, 2) : '' }}</td>
                    <td style="text-align: right;">
                        {{ $sum_qty_10 + $sum_rma['cigarate'] != 0 ? number_format($sum_qty_10 + $sum_rma['cigarate'], 2) : '' }}
                    </td>
                    <td style="text-align: right;">
                        {{ $lines->sum('qty_20') + $sum_rma['tobacco'] != 0 ? number_format($lines->sum('qty_20') + $sum_rma['tobacco'], 2) : '' }}
                    </td>
                </tr>
            @endforeach
            @php
                $sumall = $data->sum('amt2') + $data->sum('amt3') + $data->sum('amt5');
            @endphp
            <tr style="height:10px;">
                <td colspan="{{ $colspan }}"></td>
            </tr>
            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                <td></td>
                <td style="text-align: left;">รวมทั้งสิ้น</td>
                <td style="text-align: right;">
                    {{ $data->sum('amt2') + $total_rma['credit_group_code_2'] != 0 ? number_format($data->sum('amt2') + $total_rma['credit_group_code_2'], 2) : '' }}
                </td>
                <td style="text-align: right;">
                    {{ $data->sum('amt3') + $total_rma['credit_group_code_3'] != 0 ? number_format($data->sum('amt3') + $total_rma['credit_group_code_3'], 2) : '' }}
                </td>
                {{-- <td style="text-align: right;">{{ ($data->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4')<>0)?number_format($data->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4'),2):'' }}</td> --}}
                <td style="text-align: right;"></td>
                <td style="text-align: right;">
                    {{ $data->sum('amt5') + $total_rma['credit_group_code_0'] != 0 ? number_format($data->sum('amt5') + $total_rma['credit_group_code_0'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $sumall != 0 ? number_format($sumall, 2) : '' }}</td>
                <td style="text-align: right;">
                    {{ $total_qty_10 + $total_rma['cigarate'] != 0 ? number_format($total_qty_10 + $total_rma['cigarate'], 2) : '' }}
                </td>
                <td style="text-align: right;">
                    {{ $data->sum('qty_20') + $total_rma['tobacco'] != 0 ? number_format($data->sum('qty_20') + $total_rma['tobacco'], 2) : '' }}
                </td>
            </tr>

            <tr style="height:20px;">
                <td colspan="{{ $colspan }}"></td>
            </tr>
            {{-- <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">=</td>
                    <td style="text-align: right;">{{ ($sumall<>0)?number_format($sumall*95/100,2):'' }}</td>
                    <td colspan=2 style="text-align: right;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">=</td>
                    <td style="text-align: right;">{{ ($sumall<>0)?number_format(($sumall*95/100)*7/107,2):'' }}</td>
                    <td colspan=2 style="text-align: right;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">=</td>
                    <td style="text-align: right;">{{ ($sumall<>0)?number_format(($sumall*95/100)-(($sumall*95/100)*7/107),2):'' }}</td>
                    <td colspan=2 style="text-align: right;"></td>
                </tr> --}}
            @if (gettype($rma) == 'object')
                @if (count($rma) > 0)
                @foreach($rma as $k => $item)
                @php
                $itemLine = $item->lines;
                $rmaAmountCG2 = ($item->paymentApply->attribute1 == 'Y' && $item->paymentApply->credit_group_code == '2') ? $item->paymentApply->invoice_amount * -1: 0;
                $rmaAmountCG3 = ($item->paymentApply->attribute1 == 'Y' && $item->paymentApply->credit_group_code == '3') ? $item->paymentApply->invoice_amount * -1: 0;
                $sum_rma['credit_group_code_2'] += $rmaAmountCG2;
                $sum_rma['credit_group_code_3'] += $rmaAmountCG3;
                $sum_rma['credit_group_code_0'] += getRMAByCreditGroup(0, $itemLine);
                
                $total_rma['credit_group_code_2'] += $rmaAmountCG2;
                $total_rma['credit_group_code_3'] += $rmaAmountCG3;
                $total_rma['credit_group_code_0'] += getRMAByCreditGroup(0, $itemLine);
                if ($item->orderHeader->product_type_code == 10) {
                    $sum_rma['cigarate'] += -1 * $item->lines->sum('rma_quantity');
                    $total_rma['cigarate'] += -1 * $item->lines->sum('rma_quantity');
                }
                $sumRMA += $rmaAmountCG2 + $rmaAmountCG3 + getRMAByCreditGroup(0, $itemLine);
                $total_rma['cash'] += $item->paymentApply->invoice_amount * (-1);
            @endphp
            <tr>
                <td>{{ $item->credit_note_number }}</td>
                <td style="text-align: left;">{{ $item->customer->customer_name }}</td>
                <td style="text-align: right;">

                    {{ $rmaAmountCG2 ? "(". number_format(abs($rmaAmountCG2), 2).")" : '' }}
                </td>
                <td style="text-align: right;">
                    {{ $rmaAmountCG3 ? "(".number_format(abs($rmaAmountCG3), 2).")" : '' }}
                </td>
                <td style="text-align: right;">
                </td>
                <td style="text-align: right;">
                    {{ getRMAByCreditGroup(0, $itemLine) ? "(".number_format(abs(getRMAByCreditGroup(0, $itemLine)), 2).")" : '' }}
                </td>

                <td style="text-align: right;">
                   ({{ number_format(abs($item->paymentApply->invoice_amount), 2) }})
                </td>
                <td style="text-align: right;">
                    @if ($item->orderHeader->product_type_code == 10)
                        ({{ number_format($item->lines->sum('rma_quantity'), 2) }})
                    @endif
                </td>
                <td style="text-align: right;">
                    @if ($item->orderHeader->product_type_code == 20)
                    @endif
                </td>
            </tr>
                @endforeach
                @endif
            @endif
            <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                <td></td>
                <td style="text-align: left;">รวมทั้งสิ้น(ไม่รวม ยสท, บุหรีไม่คิดมูลค่า)</td>
                <td style="text-align: right;">
                    {{ $data->sum('amt2') + $total_rma['credit_group_code_2'] != 0 ? number_format($data->sum('amt2') + $total_rma['credit_group_code_2'], 2) : '' }}
                </td>
                <td style="text-align: right;">
                    {{ $data->sum('amt3') + $total_rma['credit_group_code_3'] != 0 ? number_format($data->sum('amt3') + $total_rma['credit_group_code_3'], 2) : '' }}
                </td>
                {{-- <td style="text-align: right;">{{ ($data->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4')<>0)?number_format($data->where('zone_name', '!=', '*** ยอดขายกทม. ***')->sum('amt4'),2):'' }}</td> --}}
                <td style="text-align: right;"></td>
                <td style="text-align: right;">
                    {{ $data->sum('amt5') + $total_rma['credit_group_code_0'] != 0 ? number_format($data->sum('amt5') + $total_rma['credit_group_code_0'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $sumall != 0 ? number_format($sumall + $total_rma['cash'], 2) : '' }}</td>
                <td style="text-align: right;">
                    {{ $total_qty_10 + $total_rma['cigarate'] != 0 ? number_format($total_qty_10 + $total_rma['cigarate'], 2) : '' }}
                </td>
                <td style="text-align: right;">
                    {{ $data->sum('qty_20') + $total_rma['tobacco'] != 0 ? number_format($data->sum('qty_20') + $total_rma['tobacco'], 2) : '' }}
                </td>
            </tr>
        </tbody>

    </table>
    {{-- @include('om.reports.rma.footer') --}}
    <div style="padding-top:10px;">หมายเหตุรายการ :
        @if(count($rma) > 0)
         เลขที่ใบลดหนี้ {{ ($rma->pluck('credit_note_number')->join(',')) }}
        @endif
        {{ $remark }}</div>
    <div style="margin-top: 5rem;">
        <div class="inline-block" style="width: 5%">
            <div>
            </div>
        </div>
        <div class="inline-block text-center" style="width: 40%">
            <div class="b">
                ผู้จัดทำ __________________________________________
            </div>
        </div>
        <div class="inline-block text-right" style="width: 40%">
            <div class="b">
                หัวหน้ากองบริหารขาย __________________________________________
            </div>
        </div>
    </div>
    </div>
</body>

</html>
