<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="vertical-align: middle; width: 3%;">
               <div> ลำดับ </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 5%;">
               <div> รหัสพัสดุ </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 20%;">
               <div> ชื่อพัสดุ </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 10%;">
               <div> ราคาต่อหน่อย <br> (บาท) </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 10%;">
               <div> จำนวน </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 5%;">
               <div> หน่วยนับ </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 10%;">
               <div> จำนวนเงิน <br> (บาท) </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 5%;">
               <div> วันที่ต้องการ </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($stampSummary) == 0)
            <tr>
                <td colspan="8" class="text-center" style="vertical-align: middle;">
                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                </td>
            </tr>
        @else
            @foreach ($stampSummary as $stamp)
                <tr>
                    <td class="text-center"> {{ $loop->iteration }} </td>
                    <td class="text-center"> {{ $stamp->stamp_code }} </td>
                    <td class="text-left"> {{ $stamp->stamp_description }} </td>
                    <td class="text-right"> {{ $stamp->item->unit_price }} </td>
                    <td class="text-right"> {{ number_format($stamp->weekly_receive_qty, 2) }} </td>
                    <td class="text-center"> ดวง </td>
                    <td class="text-right"> {{ number_format($stamp->weekly_receive_qty * $stamp->item->unit_price, 2) }} </td>
                    <td class="text-center"> {{ $stamp->follow_date_format }} </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>