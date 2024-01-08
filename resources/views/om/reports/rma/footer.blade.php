@if (gettype($rma) == 'object')
    @if (count($rma) > 0)
    @php 
        $footer_sum[1] = 0;
        $footer_sum[2] = 0;
    @endphp
        <table style="width:100%">
            <tr>
                <td>ลำดับ</td>
                <td>เลขที่ใบลดหนี้</td>
                <td>วันที่สร้างรายการลดหนี้</td>
                <td>เลขที่ใบ Invoice</td>
                <td>วันที่ Invoice</td>
                <td>ชื่อรายค้า</td>
                <td>สินค้า</td>
                <td>จำนวน บุหรี่(พันมวน)/ยาเส้น(หีบ)</td>
                <td>มูลค่า</td>
            </tr>
            @foreach($rma as $k => $item)
            <tr>
                <td>{{$k + 1}}</td>
                <td>{{$item->credit_note_number}}</td>
                <td>{{ Carbon\Carbon::parse($item->rma_date)->addYears(543)->format('d/m/Y')}}</td>
                <td>{{$item->ref_invoice_number}}</td>
                <td>{{ Carbon\Carbon::parse($item->invoice_date)->addYears(543)->format('d/m/Y') }}</td>
                <td>{{$item->customer->customer_name}}</td>
                <td>{{$item->lines->first()->orderLine->item_description}}</td>
                <td>
                    @php 
                        $footer_sum[1] += $item->lines->first()->rma_quantity;
                    @endphp
                    {{number_format($item->lines->first()->rma_quantity, 2) }}
                </td>
                <td>
                    @php 
                        $footer_sum[2] += $item->lines->first()->rma_quantity  * $item->lines->first()->orderLine->unit_price;
                    @endphp
                    {{ number_format($item->lines->first()->rma_quantity  * $item->lines->first()->orderLine->unit_price, 2) }}</td>
            </tr>
            @foreach ($item->lines as $c => $line)
            @if($c == 0) 
            @continue
            @endif
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    
                    {{ $line->orderLine->item_description }}</td>
                <td>
                    @php 
                        $footer_sum[1] += $line->rma_quantity;
                    @endphp
                    {{ number_format($line->rma_quantity, 2) }}</td>
                <td>
                    @php 
                        $footer_sum[2] += $line->rma_quantity * $line->orderLine->unit_price;
                    @endphp
                    {{ number_format($line->rma_quantity * $line->orderLine->unit_price, 2) }}</td>
            </tr>
            @endforeach
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>รวมทั้งสิ้น</td>
                <td>{{  number_format($footer_sum[1], 2) }}</td>
                <td>{{ number_format($footer_sum[2], 2) }}</td>
            </tr>
        </table>
    @endif
@endif
