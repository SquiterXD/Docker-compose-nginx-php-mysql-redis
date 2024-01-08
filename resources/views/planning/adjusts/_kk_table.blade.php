<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered">
        <thead>
            <tr>
                <th rowspan="2">ลำดับ</th>
                <th rowspan="2">รหัสก้นกรอง</th>
                <th rowspan="2">รายละเอียด</th>
                @foreach ($ppBiweekLists as $ppBiWeekly)
                    <th class="text-center" colspan="4">
                        ปักษ์ที่ {{ $ppBiWeekly->biweekly }}
                    </th>
                @endforeach
                @foreach ($ppBiweekLists as $ppBiWeekly)
                    <th class="text-center" colspan="4">
                        ปักษ์ที่ {{ $ppBiWeekly->biweekly }} (ปรับ)
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach ($ppBiweekLists as $ppBiWeekly)
                    <th class="text-center">คงคลังปัจจุบัน<br>(ล้านชิ้น)</th>
                    <th class="text-center">
                        เฉลี่ยใช้ต่อวัน<br>ย้อนหลัง<br>(ล้านชิ้น)
                    </th>
                    <th class="text-center">ประมาณการผลิต<br>(ล้านชิ้น)</th>
                    <th class="text-center">ประมาณการใช้<br>(ล้านชิ้น)</th>
                @endforeach
                @foreach ($ppBiweekLists as $ppBiWeekly)
                    <th class="text-center">เฉลี่ยใช้ต่อวันย้อนหลัง<br>(ล้านชิ้น)</th>
                    <th class="text-center">ประมาณการผลิต<br>(ล้านชิ้น)</th>
                    <th class="text-center">ประมาณการใช้<br>(ล้านชิ้น)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($adjKkGroup->first() ?? [] as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $item->item_code }}
                    </td>
                    <td>
                        {{ $item->item_description }}
                    </td>
                    @foreach ($ppBiweekLists as $ppBiWeekly)
                    @php
                        $itemByPpBiWeekly = false;
                        $itemByPpBiWeekly = $adjKkGroup[$ppBiWeekly->biweekly_id]->where('item_code', $item->item_code)->first();
                    @endphp
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->onhand_qty_format }}
                        </td>
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->def_estimate_product_format }}
                        </td>
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->def_estimate_used_format }}
                        </td>
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->def_average_used_format }}
                        </td>

                    @endforeach

                    @foreach ($ppBiweekLists as $ppBiWeekly)
                    @php
                        $itemByPpBiWeekly = false;
                        $itemByPpBiWeekly = $adjKkGroup[$ppBiWeekly->biweekly_id]->where('item_code', $item->item_code)->first();
                    @endphp
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->average_used_format }}
                        </td>
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->estimate_product_format }}
                        </td>
                        <td class="text-right">
                            {{ optional($itemByPpBiWeekly)->estimate_used_format }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            <tr >
                <th colspan="3" class="text-right">
                    <strong>รวม</strong>
                </th>
                @foreach ($ppBiweekLists ?? [] as $ppBiWeekly)
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'onhand_qty') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'def_estimate_product') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'def_estimate_used') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'def_average_used') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'average_used') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'estimate_product') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($adjKkGroup[$ppBiWeekly->biweekly_id], 'estimate_used') }}
                    </th>
                @endforeach

                {{-- @foreach ($ppBiweekLists ?? [] as $ppBiWeekly)
                    <th style="background-color: #34d399;" class="text-right text-white">
                        0
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        0
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        0
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        0
                    </th>
                @endforeach --}}
            </tr>
        </tbody>
    </table>
</div>