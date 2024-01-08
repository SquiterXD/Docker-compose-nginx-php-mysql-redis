<h4 class="text-center text-warning">
    แจ้งเตือนปัจจุบันปักษ์นี้มีการอนุมัตในระบบแล้ว
</h4>



{{-- {{ $productBiweekly->ppBiWeekly->stamp_desc }} --}}

<table class="table" >
    <thead>
        <tr>
            <th class="text-left">ตรา</th>
            <th class="text-left">รหัสบุหรี่</th>
            <th class="text-left">ตราบุหรี่</th>
            <th class="text-left">ประเภท</th>
            <th class="text-left">ปักษ์</th>
            <th class="text-center">การแก้ไข</th>
            <th class="text-center">สถานะการบันทึก</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $line)
            <tr>
                <td class="text-left">
                    {{ $line->stamp_desc }}
                </td>
                <td class="text-left">
                    {{ $line->item_code }}
                </td>
                <td class="text-left">
                    {{ $line->item_description }}
                </td>
                <td class="text-left">
                    {{ $productBiweekly->ppBiWeekly->biweekly }}
                </td>
                <td class="text-left">
                    {{ $productBiweekly->ppBiWeekly->biweekly }}
                </td>
                <td class="text-left">
                    {{ $productBiweekly->ppBiWeekly->biweekly }}
                </td>
                <td class="text-left">
                    {{ $productBiweekly->ppBiWeekly->biweekly }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
