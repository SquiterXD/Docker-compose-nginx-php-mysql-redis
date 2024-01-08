<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="2">ลำดับ</th>
                <th rowspan="2">รหัสก้นกรอง</th>
                <th rowspan="2">รายละเอียด</th>
                <th rowspan="2" class="text-center">คงคลังปัจจุบัน<br>(ล้านชิ้น)</th>
                @foreach ($ppBiWeeklies as $ppBiWeekly)
                    <th class="text-center" colspan="2">
                        ปักษ์ที่ {{ $ppBiWeekly->biweekly }}
                    </th>
                @endforeach
                <th rowspan="2" class="text-center">
                    เฉลี่ยใช้ต่อวัน<br>ย้อนหลัง 10 วัน<br>(ล้านชิ้น)
                </th>
            </tr>
            <tr>
                @foreach ($ppBiWeeklies as $ppBiWeekly)
                    <th class="text-center">ประมาณการผลิต<br>(ล้านชิ้น)</th>
                    <th class="text-center">ประมาณการใช้<br>(ล้านชิ้น)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($avgKkGroup->first() ?? [] as $item)
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
                    <td class="text-right">
                        {{ $item->onhand_qty_format }}
                    </td>
                    @foreach ($ppBiWeeklies as $ppBiWeekly)
                    @php
                        $itemByPpBiWeekly = false;
                        $itemByPpBiWeekly = $avgKkGroup[$ppBiWeekly->biweekly_id]->where('item_code', $item->item_code)->first();
                    @endphp
                    <td class="text-right">
                        {{ optional($itemByPpBiWeekly)->estimate_product_format }}
                    </td>
                    <td class="text-right">
                        {{ optional($itemByPpBiWeekly)->estimate_used_format }}
                    </td>
                    @endforeach
                    <td class="text-right">
                        {{ $item->average_used_format }}
                    </td>
                </tr>
            @endforeach
            <tr >
                <th colspan="3" class="text-right">
                    <strong>รวม</strong>
                </th>
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($avgKkGroup[$ppBiWeeklies->first()->biweekly_id], 'onhand_qty') }}
                </th>
                @foreach ($ppBiWeeklies as $ppBiWeekly)
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($avgKkGroup[$ppBiWeekly->biweekly_id], 'estimate_product') }}
                    </th>
                    <th style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($avgKkGroup[$ppBiWeekly->biweekly_id], 'estimate_used') }}
                    </th>
                @endforeach
                <th style="background-color: #34d399;" class="text-right text-white">
                    {{ getSumFormat($avgKkGroup[$ppBiWeeklies->first()->biweekly_id], 'average_used') }}
                </th>
            </tr>
        </tbody>
    </table>
</div>