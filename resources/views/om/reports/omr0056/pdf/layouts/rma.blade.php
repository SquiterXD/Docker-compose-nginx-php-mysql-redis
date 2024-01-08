@if ($rma)
    <tr>
        <td colspan="{{ count($items[$count_s]) * 2 + 1 }}">ใบลดหนี้</td>
    </tr>
    @php
        $rmaLines = collect([]);
        foreach ($rma->pluck('lines') as $p) {
            $rmaLines = $rmaLines->merge($p);
        }
        $rmaLinesGroup = $rmaLines->groupBy('orderLine.item_id');
    @endphp
    @foreach ($rmaLinesGroup as $rmaLine)
        <tr style="">
            <td style="text-align: left;">{{ $rmaLine->first()->orderLine->item_description }}</td>
            @switch($count_s)
                @case(1)
                @break

                @case(5)
                    <td style="text-align: right;">({{ number_format($rmaLine->sum('rma_quantity'), 2) }})</td>
                    <td style="text-align: right;">
                        @php
                            $sumRmaCol1 = $rmaLine->sum(function ($i) {
                                return $i->rma_quantity * $i->orderLine->unit_price;
                            });
                        @endphp
                        ({{ number_format($sumRmaCol1, 2) }})
                    </td>
                    <td style="text-align: right;">({{ number_format($rmaLine->sum('rma_quantity'), 2) }})</td>
                    <td style="text-align: right;">({{ number_format($sumRmaCol1, 2) }})</td>
                    <td style="text-align: right;">
                        ({{ number_format($rmaLine->where('orderLine.product_type_code', 10)->sum('rma_quantity'), 2) }})</td>
                    <td style="text-align: right;">
                        @php
                            $sumRmaColCigarate = $rmaLine->where('orderLine.product_type_code', 10)->sum(function ($i) {
                                return $i->rma_quantity * $i->orderLine->unit_price;
                            });
                        @endphp
                        ({{ number_format($sumRmaColCigarate, 2) }})
                    </td>
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
                <td style="text-align: right;">{{ number_format($sum["qty_0"] - $rmaLines->sum('rma_quantity'), 2) }}</td>
                <td style="text-align: right;">
                    @php
                        $sumRmaCol1Total = $rmaLines->sum(function ($i) {
                            return $i->rma_quantity * $i->orderLine->unit_price;
                        });
                    @endphp
                    {{ number_format($sum["total_0"] -$sumRmaCol1Total, 2) }}</td>
                <td style="text-align: right;">{{ number_format($sum["qty_1"] -$rmaLines->sum('rma_quantity'), 2) }}</td>
                <td style="text-align: right;">{{ number_format($sum["total_1"] -$sumRmaCol1Total, 2) }}</td>
                <td style="text-align: right;">
                    {{ number_format($sum["qty_2"] -$rmaLines->where('orderLine.product_type_code', 10)->sum('rma_quantity'), 2) }}</td>
                <td style="text-align: right;">
                    @php
                        $sumRmaColCigarateTotal = $rmaLines->where('orderLine.product_type_code', 10)->sum(function ($i) {
                            return $i->rma_quantity * $i->orderLine->unit_price;
                        });
                    @endphp
                    {{ number_format($sum["total_2"] -$sumRmaColCigarateTotal, 2) }}
                </td>
            @break

            @default
        @endswitch
    </tr>
@endif
