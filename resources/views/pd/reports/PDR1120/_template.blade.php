<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('pd.reports.PDR1120._style')
    </head>
    <body>
        @php
            $old_batch = null;
        @endphp
        @foreach ($data as $page => $items)
            <div style="width: 100%">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    <div>
                        รหัสโปรแกรม : PDR1120
                    </div>
                    <div>
                        {{-- สั่งพิมพ์ : {{ str_pad($attempt, 6, "0", STR_PAD_LEFT); }} --}}
                        สั่งพิมพ์ : {{ \Auth::user()->username }}
                    </div>
                    <div>
                        เรียงลำดับข้อมูล : {{ $order_type == 'PM' ? 'ตามระบบผลิต' : 'ตามระบบต้นทุน' }}
                    </div>
                </div>
                <div class="text-center inline-block align-top" style="width:46%; padding:0; margin:0;">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        รายงานการพิมพ์ (รหัสสิ่งพิมพ์) ฝ่ายการพิมพ์ กองพิมพ์
                    </div>
                    <div>
                        ประจำวันที่ {{ dateFormatThaiString($start_date) }} - {{ dateFormatThaiString($end_date) }}
                    </div>
                </div>
                <div class="text-right inline-block align-top" style="width:26%; padding:0; margin:0;">
                    <div>
                        วันที่ : {{ date('d/n/Y', strtotime(convertYearToBBE(date('Y')))) }}
                    </div>
                    <div>
                        เวลา {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        หน้า {{$loop->iteration}} / {{$loop->count}}
                    </div>
                </div>
            </div>
            <table class="table" style="margin-top: 5px;">
                <thead>
                    <tr>
                        <td class="text-center" rowspan="2" width="20px">
                            เลขที่<br>
                            คำสั่งผลิต
                        </td>
                        <td class="text-center" rowspan="2" width="20px">
                            รหัส<br>
                            หมวด
                        </td>
                        <td class="text-center" rowspan="2" width="40px">
                            รหัส<br>
                            สิ่งพิมพ์
                        </td>
                        <td class="text-center" rowspan="2" width="14%">
                            ชื่อ<br>
                            สิ่งพิมพ์
                        </td>
                        <td class="text-center" rowspan="2" width="2%">
                            WIP
                        </td>
                        <td class="text-center" colspan="2" width="21%">
                            จำนวนกระดาษที่เบิก
                        </td>
                        <td class="text-center" colspan="2" width="14%">
                            จำนวนพิมพ์ต่อวัน
                        </td>
                        <td class="text-center" rowspan="2" width="7%">
                            ยอดยกมา
                        </td>
                        <td class="text-center" rowspan="2" width="7%">
                            รวม
                        </td>
                        <td class="text-center" rowspan="2" width="7%">
                            ส่งพิมพ์<br>
                            สีต่อไป
                        </td>
                        <td class="text-center" rowspan="2" width="7%">
                            ส่ง<br>
                            เครื่องตัด<br>
                            แผ่น
                        </td>
                        <td class="text-center" rowspan="2" width="7%">
                            คงเหลือ<br>
                            ยอดยกไป<br>
                            แผ่น
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" width="15%">
                            ชนิดกระดาษ
                        </td>
                        <td class="text-center">
                            จำนวน<br>
                            แผ่น (กก.)
                        </td>
                        <td class="text-center">
                            พิมพ์ได้<br>
                            แผ่น
                        </td>
                        <td class="text-center">
                            เสีย<br>
                            แผ่น
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $batch => $item)
                        @php
                            $groupHeader = collect($item['groupHeader']);
                            $head = $item['head'];
                            $start = $item['start'];
                            $end = $item['end'];
                            $groupDesc = collect($item['gropDesc']);
                            $sum_product = (float)$groupHeader->sum('product_qty');
                            $sum_loss = (float)$groupHeader->sum('loss_qty');
                            $receive_wip = (float)$start->receive_wip;
                            $sum_total = $sum_product - $sum_loss + $receive_wip;
                        @endphp
                        @forelse ($groupDesc as $desc => $lines)
                            @if($loop->first && $old_batch != $batch)
                                @php
                                    $old_batch = $batch;
                                @endphp
                                <tr>
                                    <td>
                                        {{ $head['batch_no'] }}
                                    </td>
                                    <td>
                                        {{ $head['product_group'] }}
                                    </td>
                                    <td>
                                        {{ $head['item_product'] }}
                                    </td>
                                    <td>
                                        {{ $head['item_desc'] }}
                                    </td>
                                    <td>
                                        {{ $head['wip_step'] }}
                                    </td>
                                    <td>
                                        {{ $desc }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber(collect($lines)->sum('confirm_qty')) : numberFormatDisplayNotRound(collect($lines)->sum('confirm_qty'), 3) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($sum_product) : numberFormatDisplayNotRound($sum_product) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($sum_loss) : numberFormatDisplayNotRound($sum_loss) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($receive_wip) : numberFormatDisplayNotRound($receive_wip) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($sum_total) : numberFormatDisplayNotRound($sum_total) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber(0) : numberFormatDisplayNotRound(0) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($groupHeader->sum('transfer_qty')) : numberFormatDisplayNotRound($groupHeader->sum('transfer_qty')) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber($end['transfer_wip']) : numberFormatDisplayNotRound($end['transfer_wip']) }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>
                                        {{-- {{ $batch }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $head->product_group }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $head->item_product }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $head->item_desc }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $head->wip_step }} --}}
                                    </td>
                                    <td>
                                        {{ $desc }}
                                    </td>
                                    <td class="text-right">
                                        {{ $order_type == 'PM' ? showNumber(collect($lines)->sum('confirm_qty')) : numberFormatDisplayNotRound(collect($lines)->sum('confirm_qty'), 3) }}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($groupHeader->sum('product_qty')) : numberFormatDisplayNotRound($groupHeader->sum('product_qty')) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($groupHeader->sum('loss_qty')) : numberFormatDisplayNotRound($groupHeader->sum('loss_qty')) }} --}}
                                        {{ collect($lines)->first()->uom_code }}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($start->receive_wip) : numberFormatDisplayNotRound($start->receive_wip) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($groupHeader->sum('product_qty')) : numberFormatDisplayNotRound($groupHeader->sum('product_qty')) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber(0) : numberFormatDisplayNotRound(0) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($groupHeader->sum('transfer_qty')) : numberFormatDisplayNotRound($groupHeader->sum('transfer_qty')) }} --}}
                                    </td>
                                    <td class="text-right">
                                        {{-- {{ $order_type == 'PM' ? showNumber($end->transfer_qty) : numberFormatDisplayNotRound($end->transfer_qty) }} --}}
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td>
                                    {{ $head['batch_no'] }}
                                </td>
                                <td>
                                    {{ $head['product_group'] }}
                                </td>
                                <td>
                                    {{ $head['item_product'] }}
                                </td>
                                <td>
                                    {{ $head['item_desc'] }}
                                </td>
                                <td>
                                    {{ $head['wip_step'] }}
                                </td>
                                <td>
                                    -
                                </td>
                                <td class="text-right">
                                    
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($sum_product) : numberFormatDisplayNotRound($sum_product) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($sum_loss) : numberFormatDisplayNotRound($sum_loss) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($receive_wip) : numberFormatDisplayNotRound($receive_wip) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($sum_total) : numberFormatDisplayNotRound($sum_total) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber(0) : numberFormatDisplayNotRound(0) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($groupHeader->sum('transfer_qty')) : numberFormatDisplayNotRound($groupHeader->sum('transfer_qty')) }}
                                </td>
                                <td class="text-right">
                                    {{ $order_type == 'PM' ? showNumber($end['transfer_wip']) : numberFormatDisplayNotRound($end['transfer_wip']) }}
                                </td>
                            </tr>
                        @endforelse
                    @endforeach
                    @if ($loop->last)
                        <tr style="border-top: 0.5px solid black">
                            <td colspan="99" class="text-center">
                                จบรายงาน
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="page-break"></div>
        @endforeach
    </body>
</html>