<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>รหัสบุหรี่</th>
                <th>ตราบุหรี่</th>
                <th class="text-center">คงคลังบุหรี่<br>ระบบ AS/RS<br>(ล้านมวน)</th>
                <th class="text-center">เฉลี่ยต่อวัน<br>ย้อนหลัง 10 วันขาย<br>(ล้านมวน)</th>
                <th class="text-center">สั่งผลิตทั้งปักษ์<br>(ล้านมวน)</th>
                <th class="text-center">ผลผลิตจริง<br>สะสมทั้งปักษ์<br>(ล้านมวน)</th>
                <th class="text-center">ค้างผลิตในปักษ์<br>(ล้านมวน)</th>
                <th class="text-center">คาดว่าจะได้ผลผลิต<br>ที่เหลือในปักษ์(ล้านมวน)</th>
                <th class="text-center">ประมาณการจำหน่าย<br>ที่เหลือในปักษ์(ล้านมวน)</th>
                <th class="text-center">คาดว่าคงคลังคงเหลือ<br>(ล้านมวน)</th>
                <th class="text-center">คาดว่าคงคลังคงเหลือ<br>(วัน)</th>
            </tr>
        <tbody>
            @if (count($data))
                @foreach ($data as $item)
                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td class="text-right">{{ $item->curr_onhnad_qty_format }}</td>
                        <td class="text-right">{{ $item->forcast_qty_format }}</td>
                        <td class="text-right">{{ $item->planning_qty_format }}</td>
                        <td class="text-right">{{ $item->sum_prev_wip_qty_format }}</td>
                        <td class="text-right">{{ $item->remaining_onhand_qty_format }}</td>
                        <td class="text-right">{{ $item->total_daily_qty_format }}</td>
                        <td class="text-right">{{ $item->plan_fbal_or_sale_format }}</td>
                        <td class="text-right">{{ $item->plan_bal_onhand_qty_format }}</td>
                        <td class="text-right">{{ $item->plan_bal_day_format }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">รวม</th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'curr_onhnad_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'forcast_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'planning_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'sum_prev_wip_qty_format', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'remaining_onhand_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'total_daily_qty', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'plan_fbal_or_sale', 2) }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($data, 'plan_bal_onhand_qty', 2) }}
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








