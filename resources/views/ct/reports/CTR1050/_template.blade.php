<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ct.Reports.CTR1050._style')
    </head>
    <body>
        @foreach ($data as $page => $groupCost)
            <div style="width: 100%">
                <div class="inline-block align-top" style="width:26%; padding:0; margin:0;">
                    <div>
                        รหัสโปรแกรม : CTR1050
                    </div>
                    <div>
                        สั่งพิมพ์ : {{ auth()->user()->username }}
                    </div>
                </div>
                <div class="text-center inline-block align-top" style="width:46%; padding:0; margin:0;">
                    <div>
                        การยาสูบแห่งประเทศไทย
                    </div>
                    <div>
                        รายงานสูญเสียสิ่งพิมพ์
                    </div>
                    <div>
                        ประจำวันที่ {{ $oneDate ? dateFormatThaiString($date_from) : dateFormatThaiString($date_from) .' - '. dateFormatThaiString($date_to) }}
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
                        หน้า {{ $page+1 }} / {{ $loop->count }}
                    </div>
                </div>
            </div>
            {{-- <table class="table" style="margin-top: 5px;"> --}}
            <table class="table" style="margin-top: 2px; table-layout: auto;" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        @if ($product_type == 'N')
                            <th class="text-center" rowspan="2" width="50px">
                            </th>
                        @endif
                        <th class="text-center" rowspan="2" width="50px">
                            รหัส
                        </th>
                        <th class="text-center" rowspan="2" width="80px">
                            ชื่อ
                        </th>
                        <th class="text-center" colspan="4" >
                            ยอดยกมา
                        </th>
                        <th class="text-center" colspan="2" >
                            ปริมาณกระดาษที่เบิก
                        </th>
                        <th class="text-center">
                            สำเร็จรูป
                        </th>
                        <th class="text-center" colspan="2" >
                            เสีย
                        </th>
                        <th class="text-center" colspan="4" >
                            ยอดคงเหลือ
                        </th>
                        <th class="text-center" rowspan="2" width="20px">
                            layout
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center">
                            รพ 2 (แผ่น)
                        </th>
                        <th class="text-center">
                            รพ 2 (ชิ้น)
                        </th>
                        <th class="text-center">
                            รพ 3 (ชิ้น)
                        </th>
                        <th class="text-center">
                            รวม
                        </th>
                        <th class="text-center">
                            (แผ่น)
                        </th>
                        <th class="text-center">
                            (ชิ้น)
                        </th>
                        <th class="text-center">
                            (ชิ้น)
                        </th>
                        <th class="text-center">
                            (ชิ้น)
                        </th>
                        <th class="text-center">
                            (%)
                        </th>
                        <th class="text-center">
                            รพ 2 (แผ่น)
                        </th>
                        <th class="text-center">
                            รพ 2 (ชิ้น)
                        </th>
                        <th class="text-center">
                            รพ 3 (ชิ้น)
                        </th>
                        <th class="text-center">
                            รวม
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($groupCost['groupData'] as $cost => $groupItems)
                        @foreach ($groupItems as $desc => $lines)
                            @php
                                $items = isset($lines['lines'])? collect($lines['lines']): [];
                            @endphp
                            <tr>
                                <td colspan="99">
                                    {{ $desc }}
                                </td>
                            </tr>
                            @foreach ($items as $line)
                                <tr style="page-break-inside:avoid;">
                                    @if ($product_type == 'N')
                                        <td>
                                            {{ $line->batch_no }}
                                        </td>
                                    @endif
                                    <td>
                                        {{ $line->item_product }}
                                    </td>
                                    <td>
                                        {{ $line->item_desc }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->receive_wip_sheet) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->receive_wip_item) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->sum_receive_wip_234) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->sum_receive_wip_1234) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->product_qty_sheet) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->product_qty_item) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->transfer_qty_wip3) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->loss_qty) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->loss_percent, 3) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->transfer_wip_sheet) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->transfer_wip_item) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->transfer_wip_234) }}
                                    </td>
                                    <td class="text-right">
                                        {{ numberFormatDisplay($line->transfer_wip_1234) }}
                                    </td>
                                    <td class="text-right">
                                        {{ $line->layout }}
                                    </td>
                                </tr>
                            @endforeach
                            @if ($lines['end_flag'])
                                @php
                                    $data_sum = $groupCost['dataAll']->where('cost_code', $cost)->where('product_group_desc', $line->product_group_desc);
                                    $sum_receive_wip_1234 = $data_sum->sum('sum_receive_wip_1234'); // 3
                                    $product_qty_item = $data_sum->sum('product_qty_item'); // 2
                                    $loss_qty = $data_sum->sum('loss_qty'); // 1
                                    $loss_percent = $product_qty_item + $sum_receive_wip_1234 == 0? 0: $loss_qty / ($product_qty_item + $sum_receive_wip_1234) * 100; // 1 / (2 + 3) * 100
                                @endphp
                                <tr style="border: 0 !important; page-break-inside:avoid;">
                                    @if ($product_type == 'N')
                                        <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;">
                                            
                                        </td>
                                    @endif
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;">
                                        
                                    </td>
                                    <td class="text-right" style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;">
                                        รวม
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('receive_wip_sheet')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('receive_wip_item')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('sum_receive_wip_234')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($sum_receive_wip_1234) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('product_qty_sheet')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($product_qty_item) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('transfer_qty_wip3')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($loss_qty) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($loss_percent, 3) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('transfer_wip_sheet')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('transfer_wip_item')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('transfer_wip_234')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                        {{ numberFormatDisplay($data_sum->sum('transfer_wip_1234')) }}
                                    </td>
                                    <td style="border-top: 0.5px solid black !important; border-bottom: 0.5px solid black !important; border-left: 0 !important; border-right: 0 !important;" class="text-right">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    @if ($loop->last)
                        @php
                            $total_sum_receive_wip_1234 = $query->sum('sum_receive_wip_1234'); // 3
                            $total_product_qty_item = $query->sum('product_qty_item'); // 2
                            $total_loss_qty = $query->sum('loss_qty'); // 1
                            $total_loss_percent = $total_product_qty_item + $total_sum_receive_wip_1234 == 0? 0: $total_loss_qty / ($total_product_qty_item + $total_sum_receive_wip_1234) * 100; // 1 / (2 + 3) * 100
                        @endphp
                        <tr style="border: 0 !important; page-break-inside:avoid;">
                            @if ($product_type == 'N')
                                <td style="border: 0 !important">
                                    
                                </td>
                            @endif
                            <td style="border: 0 !important">
                                
                            </td>
                            <td style="border: 0 !important">
                                รวม
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('receive_wip_sheet')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('receive_wip_item')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('sum_receive_wip_234')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($total_sum_receive_wip_1234) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('product_qty_sheet')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($total_product_qty_item) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('transfer_qty_wip3')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($total_loss_qty) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($total_loss_percent, 3) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('transfer_wip_sheet')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('transfer_wip_item')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('transfer_wip_234')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                                {{ numberFormatDisplay($query->sum('transfer_wip_1234')) }}
                            </td>
                            <td style="border: 0 !important" class="text-right">
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="page-break"></div>
        @endforeach
    </body>
</html>