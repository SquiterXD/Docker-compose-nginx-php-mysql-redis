@if ($rma)
    <tr>
        <td colspan="{{ count($items[$count_s]) * 2 + 1 }}">ใบลดหนี้</td>
    </tr>
    @php
        $rmaYearLines = collect([]);
        $rmaMonthLines = collect([]);
        $rmaLines = collect([]);
        
        foreach ($rmaYear->pluck('lines') as $p) {
            $rmaYearLines = $rmaYearLines->merge($p);
        }
        foreach ($rmaMonth->pluck('lines') as $p) {
            $rmaMonthLines = $rmaMonthLines->merge($p);
        }
        foreach ($rma->pluck('lines') as $p) {
            $rmaLines = $rmaLines->merge($p);
        }
        $rmaYearLinesGroup = $rmaYearLines->groupBy('orderLine.item_id');
        $rmaMonthLinesGroup = $rmaMonthLines->groupBy('orderLine.item_id');
        $rmaLinesGroup = $rmaLines->groupBy('orderLine.item_id');
    @endphp
    @foreach ($rmaYearLinesGroup as $rmaYearLine)
        @php
            $itemId = $rmaYearLine->first()->orderLine->item_id;
            $itemMonth = $rmaMonthLinesGroup[$itemId] ?? collect();
            $itemAt = $rmaLinesGroup[$itemId] ?? collect();
        @endphp
        <tr style="">
            <td style="text-align: left;">{{ $rmaYearLine->first()->orderLine->item_description }}</td>
            @switch($count_s)
                @case(1)
                @break

                @case(5)
                @php
                    $totalQty = $itemAt->sum(function ($i) {
                        return $i->rma_quantity;
                    });
                    $totalRma = $itemAt->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                    <td style="text-align: right;">
                        @if($totalQty > 0)
                        ({{ number_format($totalQty, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalRma > 0)
                        ({{ number_format($totalRma, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalQty > 0)
                        ({{ number_format($totalQty, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalRma > 0)
                        ({{ number_format($totalRma, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalQty > 0)
                        ({{ number_format($totalQty, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalRma > 0)
                        ({{ number_format($totalRma, 2) }})
                        @endif
                    </td>
                    
                    @php
                        $totalQtyMonth = $itemMonth->sum(function ($i) {
                            return $i->rma_quantity;
                        });
                        $totalMonth = $itemMonth->sum(function ($i) {
                            return $i->rma_quantity * $i->orderLine->unit_price;
                        });
                    @endphp
                    <td style="text-align: right;">
                        @if($totalQtyMonth> 0)
                        ({{ number_format($totalQtyMonth, 2) }})
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($totalMonth> 0)
                        ({{ number_format($totalMonth, 2) }})
                        @endif
                    </td>
                    @php
                        $totalQtyYear = $rmaYearLine->sum(function ($i) {
                            return $i->rma_quantity;
                        });
                        $totalYear = $rmaYearLine->sum(function ($i) {
                            return $i->rma_quantity * $i->orderLine->unit_price;
                        });
                    @endphp
                    <td style="text-align: right;">
                        @if($totalQtyYear> 0)
                        ({{ number_format($totalQtyYear, 2) }})
                        @endif
                    </td>
                    {{-- พันมวน	/ รวม ตั้งแต่วันที่ 1/10/2565 --}}
                    <td style="text-align: right;">
                        @if($totalYear> 0)
                        ({{ number_format($totalYear, 2) }})
                        @endif
                    </td>
                    {{-- บาท/ รวม ตั้งแต่วันที่ 1/10/2565 --}}
                @break

                @default
            @endswitch
        </tr>
    @endforeach
    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:14px;">
        <td style="text-align: left;">รวม</td>
        @switch($count_s)
            @case(1)
            @break

            @case(5)
            <td style="text-align: right;">({{ number_format($rmaLines->sum('rma_quantity'), 2) }})</td>
            <td style="text-align: right;">
                @php
                    $sumRmaCol1Total = $rmaLines->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                ({{ number_format($sumRmaCol1Total, 2) }})</td>
            <td style="text-align: right;">({{ number_format($rmaLines->sum('rma_quantity'), 2) }})</td>
            <td style="text-align: right;">({{ number_format($sumRmaCol1Total, 2) }})</td>
            <td style="text-align: right;">
                ({{ number_format($rmaLines->where('orderLine.product_type_code', 10)->sum('rma_quantity'), 2) }})</td>
            <td style="text-align: right;">
                @php
                    $sumRmaColCigarateTotal = $rmaLines->where('orderLine.product_type_code', 10)->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                ({{ number_format($sumRmaColCigarateTotal, 2) }})
            </td>

            <td style="text-align: right;">
                ({{ number_format($rmaMonthLines->sum('rma_quantity'), 2) }})</td>
            <td style="text-align: right;">
                @php
                    $sumRmaColCigarateTotal = $rmaMonthLines->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                ({{ number_format($sumRmaColCigarateTotal, 2) }})
            </td>

            @php
                $sumRmaColCigarateTotal = $rmaYearLines->sum(function ($i) {
                    return $i->rma_quantity * $i->orderLine->unit_price;
                });
                // dd($rmaYearLine);
            @endphp
            <td style="text-align: right;">
                ({{ number_format($rmaYearLines->sum('rma_quantity'), 2) }})</td>
            <td style="text-align: right;">
                ({{ number_format($sumRmaColCigarateTotal, 2) }})
            </td>
            
            @break
            @default
        @endswitch
    </tr>
    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:14px;">
        <td style="text-align: left;">รวมทั้งสิ้น</td>
        @switch($count_s)
            @case(1)
            @break

            @case(5)
            <td style="text-align: right;">{{ number_format( $sum["qty_0"] - $rmaLines->sum('rma_quantity'), 2) }}</td>
            <td style="text-align: right;">
                @php
                    $sumRmaCol1Total = $rmaLines->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                {{ number_format( $sum["total_0"] - $sumRmaCol1Total, 2) }}</td>
            <td style="text-align: right;">{{ number_format( $sum["qty_1"] - $rmaLines->sum('rma_quantity'), 2) }}</td>
            <td style="text-align: right;">{{ number_format( $sum["total_1"] - $sumRmaCol1Total, 2) }}</td>
            <td style="text-align: right;">
                {{ number_format($sum["qty_2"] - $rmaLines->where('orderLine.product_type_code', 10)->sum('rma_quantity') , 2) }}</td>
            <td style="text-align: right;">
                @php
                    $sumRmaColCigarateTotal = $rmaLines->where('orderLine.product_type_code', 10)->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                {{ number_format($sum["total_2"] - $sumRmaColCigarateTotal, 2) }}
            </td>

            <td style="text-align: right;">
                {{ number_format($sum["qty_3"] - $rmaMonthLines->sum('rma_quantity'), 2) }}</td>
            <td style="text-align: right;">
                @php
                    $sumRmaColCigarateTotal = $rmaMonthLines->sum(function ($i) {
                        return $i->rma_quantity * $i->orderLine->unit_price;
                    });
                @endphp
                {{ number_format($sum["total_3"] - $sumRmaColCigarateTotal, 2) }}
            </td>

            @php
                $sumRmaColCigarateTotal = $rmaYearLines->sum(function ($i) {
                    return $i->rma_quantity * $i->orderLine->unit_price;
                });
                // dd($rmaYearLine);
            @endphp
            <td style="text-align: right;">
                {{ number_format($sum["qty_4"] - $rmaYearLines->sum('rma_quantity'), 2) }}</td>
            <td style="text-align: right;">
                {{ number_format($sum["total_4"] - $sumRmaColCigarateTotal, 2) }}
            </td>
            @break

            @default
        @endswitch
    </tr>
@endif
