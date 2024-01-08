<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>มูลค่าการจำหน่ายบุหรี่</title>
</head>

<body>
    <table style="width:100%">
        <thead>
            {{-- <tr>
                <td colspan="{{$numberMonth + 3}}" align="center">ปี {{$dateFrom->format('Y') + 543}}</td>
            </tr> --}}
            <tr>
                <td colspan="{{ $numberMonth + 3 }}" align="center">มูลค่าการจำหน่ายบุหรี่ในประเทศและต่างประเทศปีงบประมาณ
                    {{ $dateTo->format('m') >= 10 ? $dateTo->format('Y') + 544 : $dateTo->format('Y') + 543 }} (บาท)
                </td>
            </tr>
            <tr>
                <td colspan="{{ $numberMonth + 3 }}" align="center">({{ @$months_th[$dateFrom->format('m')] }}
                    {{ $dateFrom->format('y') + 43 }} - {{ @$months_th[$dateTo->format('m')] }}
                    {{ $dateTo->format('y') + 43 }})</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                @php
                @endphp
                @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                    @php
                        $monthNumber = $i->format('m');
                    @endphp
                    <td align="right">{{ @$months_th[$monthNumber] }}
                        {{ $i->format('y') + 43 }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endfor
                <td align="right">สะสม &nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="">บุหรี่จำหน่ายในประเทศ (บาท)</td>
            </tr>
            @php
                $total = [];
                $summary = [];
            @endphp
            @foreach ($results['sheet1']['section1']['columns'] as $column)
                @php
                    $total_row = 0;
                    $sumPao2 = 0;
                @endphp
                <tr>
                    <td>{{ $column }}</td>

                    @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                        @php
                            $col5 = 0;
                            $col6 = 0;
                            $col7 = 0;
                            $itemAdjust = null;
                            $item = collect(@$results['sheet1-2']['section1'][$i->format('mY')]['data'])
                                ->where('report_item_display', $column)
                                ->first();
                            $adjust = collect(@$results['sheet1-2']['section1'][$i->format('mY')]['arInterface'])
                                ->where('item_code', $item->item_code)
                                ->first();
                            $glAdjust =
                                collect(@$results['sheet1-2']['section1'][$i->format('mY')]['gl_adjust'])
                                    ->where('item_code', $item->item_code)
                                    ->first() ?? false;
                            $apAdjust =
                                collect(@$results['sheet1-2']['section1'][$i->format('mY')]['apInterface'])
                                    ->where('item_code', $item->item_code)
                                    ->first() ?? false;
                            
                            if ($glAdjust) {
                                $valueAdjust = $glAdjust->dr - $glAdjust->cr;
                            } else {
                                $valueAdjust = 0;
                            }
                            if ($apAdjust) {
                                $apAdjustAmount = $apAdjust->ppt_adjust_amount;
                            } else {
                                $apAdjustAmount = $item->mt_pao_line_amount;
                            }
                            
                        @endphp
                        <td align="right">
                            @if ($adjust)
                                @php
                                    @$total[$i->format('mY')] += $adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust) - ($adjust->sum_pao_line_amount + $apAdjustAmount);
                                    $sumPao2 += $adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust) - ($adjust->sum_pao_line_amount + $apAdjustAmount);
                                @endphp
                                {{ number_format($adjust->sum_amount - ($adjust->sum_oaom_tax_adjust + $valueAdjust) - ($adjust->sum_pao_line_amount + $apAdjustAmount), 2) }}
                            @else
                                @php
                                    @$total[$i->format('mY')] += $item->all_amount - ($item->tax_amount + $valueAdjust) - ($item->pao_line_amount + $apAdjustAmount);
                                    $sumPao2 += $item->all_amount - ($item->tax_amount + $valueAdjust) - ($item->pao_line_amount + $apAdjustAmount);
                                @endphp
                                {{ number_format($item->all_amount - ($item->tax_amount + $valueAdjust) - ($item->pao_line_amount + $apAdjustAmount), 2) }}
                            @endif
                        </td>
                    @endfor
                    <td align="right">{{ number_Format($sumPao2, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">รวมในประเทศ (บาท)</td>
                @php
                    $total['row'] = 0;
                @endphp
               
                @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                    @php
                        $total['row'] += @$total[$i->format('mY')];
                        @$summary[$i->format('mY')] += @$total[$i->format('mY')];
                    @endphp
                    <td align="right">
                        {{ number_format(@$total[$i->format('mY')], 2) }}
                    </td>
                @endfor

                <td align="right">
                    {{ number_format(@$total['row'], 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="" style="font-weight: bold">บุหรี่จำหน่ายต่างประเทศ (บาท)</td>
            </tr>

            @php
                $total = [];
            @endphp
            @foreach ($results['sheet1']['section2']['columns'] as $column)
                @php
                    $total_row = 0;
                @endphp
                <tr>
                    <td>{{ $column }}</td>
                    @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                        @php
                            $item = collect(@$results['sheet1-2']['section2'][$i->format('mY')]['data'])->where('item_description', $column);
                            $amount =  @$item->sum(function($i) {
                                return $i->amount * $i->pick_exchange_rate;
                            });
                            if (!empty($total[$i->format('mY')])) {
                                $total[$i->format('mY')] += $amount;
                            } else {
                                $total[$i->format('mY')] = $amount;
                            }
                            
                            $total_row += $amount;
                            
                        @endphp
                        <td align="right">
                            {{ number_format($amount, 2) }}
                        </td>
                    @endfor

                    <td align="right">
                        {{ number_format($total_row, 2) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">รวมต่างประเทศ (บาท)</td>
                @php
                    $total['row'] = 0;
                @endphp
                @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                    @php
                        $total['row'] += $total[$i->format('mY')];
                        @$summary[$i->format('mY')] += $total[$i->format('mY')];
                        
                    @endphp
                    <td align="right">
                        {{ number_format($total[$i->format('mY')], 2) }}
                    </td>
                @endfor

                <td align="right">
                    {{ number_format($total['row'], 2) }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">รวมในประเทศ+ต่างประเทศ (บาท)</td>
                @php
                    $total['row'] = 0;
                @endphp
                @for ($i = $dateFrom->copy(); $dateTo >= $i; $i->addMonth(1))
                    @php
                        $total['row'] += $summary[$i->format('mY')];
                    @endphp
                    <td align="right">
                        {{ number_format($summary[$i->format('mY')], 2) }}
                    </td>
                @endfor

                <td align="right">
                    {{ number_format($total['row'], 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
