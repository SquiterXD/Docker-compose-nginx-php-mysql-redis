<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover tab1">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>รหัสบุหรี่</th>
                <th>ตราบุหรี่</th>
                <th class="text-center">คงคลังบุหรี่<br>ระบบ AS/RS<br>(ล้านมวน)</th>
                <th class="text-center">
                    {{-- ผลิตส่ง<br>AS/RS วันก่อนหน้า<br>(ล้านมวน) --}}
                    {{-- <br><br><br> --}}
                    <div data-toggle="tooltip" data-placement="top" data-container="body"  title="{{ optional($followProduct)->previous_date_format }}">
                        โอนเข้าคงคลัง<br>กองผลิตภัณฑ์<br>(ล้านมวน)
                    </div>
                </th>
                <th class="text-center">
                    <div data-toggle="tooltip" data-placement="top" data-container="body"  title="{{ optional($followProduct)->previous_date_format }}">
                        ยอดจำหน่าย<br>วันที่ผลิต<br>(ล้านมวน)
                    </div>
                </th>
                <th class="text-center">เฉลี่ยต่อวัน<br>ย้อนหลัง 10 วันขาย<br>(ล้านมวน)</th>
                <th class="text-center">คงคลังในระบบ<br>AS/RS เพียงพอจำหน่าย<br>(วัน)</th>
                <th class="text-center">
                    <div data-toggle="tooltip" data-placement="top" data-container="body"  title="{{ optional($followProduct)->previous_date_format }}">
                        ผลิตได้ใน<br>วันที่ผลิต<br>(ล้านมวน)</th>
                    </div>
                <th class="text-center">
                    <div data-toggle="tooltip" data-placement="top" data-container="body"  title="{{ optional($followProduct)->previous_date_format }}">
                        ค้างส่งใน<br>วันที่ผลิต<br>(ล้านมวน)</th>
                    </div>
                <th class="text-center">ประมาณการ<br>จำหน่ายรายปักษ์<br>(ล้านมวน)</th>
                <th class="text-center">
                    {{-- คงคลังตามประมาณตลาด<br>(ล้านมวน) --}}
                    คงคลัง<br>ตามประมาณตลาด<br>(วัน)
                </th>
                <th class="text-center">วันที่บนซองบุหรี่</th>
            </tr>
        <tbody>
            @php
                $curr_onhnad = 0;
                $forcast_qty = 0;
                $average_forecast = 0;
            @endphp
            @if ($followProduct && count($data))
               @foreach ($data as $item)
                    @php
                        // Cal
                        $curr_onhnad += $item->curr_onhnad_qty;
                        $forcast_qty += $item->forcast_qty;
                        $average_forecast += $item->average_forecast_qty;
                    @endphp
                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td class="text-right">{{ ($item->curr_onhnad_qty_format) }}</td>
                        <td class="text-right">{{ ($item->prev_onhand_qty_format) }}</td>
                        <td class="text-right">{{ ($item->prev_sale_qty_format) }}</td>
                        <td class="text-right">{{ ($item->forcast_qty_format) }}</td>
                        <td class="text-right">{{ ($item->onhand_for_sale_format) }}</td>
                        <td class="text-right">{{ ($item->prev_wip_qty_format) }}</td>
                        <td class="text-right">{{ ($item->remaining_qty_format) }}</td>
                        <td class="text-right">{{ ($item->average_forecast_qty_format) }}</td>
                        <td class="text-right">{{ ($item->asrs_for_market_format) }}</td>
                        <td>
                            @if ($productType == 'all')
                                {{ $item->date_on_item }}
                            @else
                                <input type="text" name="dateItem[{{ $item->item_code }}]" value="{{ $item->date_on_item }}" class="form-control" style="width: 120px;">
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">รวม</th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'curr_onhnad_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'prev_onhand_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'prev_sale_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'forcast_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        @php
                            $col5 = (int)$forcast_qty <= 0 ? 0: $curr_onhnad / (int)$forcast_qty;
                        @endphp
                        {{ number_format($col5, 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'prev_wip_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'remaining_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'average_forecast_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        @php
                            $col9 = $average_forecast <= 0 ? 0: $curr_onhnad/$average_forecast;
                        @endphp
                        {{ number_format($col9, 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                    </th>
                </tr>
            @else
                <td class="text-center" colspan="13"> <h2> ไม่พบข้อมูลที่ค้นหา </h2> </td>
            @endif
        </tbody>
    </thead>
</table>