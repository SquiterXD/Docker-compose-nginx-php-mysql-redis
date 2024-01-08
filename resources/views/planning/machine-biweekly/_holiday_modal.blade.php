<div class="table-responsive">
<table class="table table-bordered" style="max-height: 500px; display: block; overflow: auto; ">
    <thead>
        <tr>
            <th class="text-center" style="vertical-align: middle; width: 25%; min-width: 50px; position: sticky; top: 0;">
               <div> เดือน </div> 
            </th>
            <th class="text-center" style="vertical-align: middle; width: 25%; min-width: 50px; position: sticky; top: 0;">
               <div> วันที่ </div>
            </th>
            <th class="text-center" style="vertical-align: middle; width: 35%; min-width: 100px; position: sticky; top: 0;">
               <div> รายละเอียด </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($ppHolidays) <= 0)
           <tr>
                <td colspan="5" class="text-center" style="vertical-align: middle;">
                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                </td>
            </tr>
        @else
            @foreach ($ppHolidays as $index => $holiday)
                <tr>
                    <td class="text-center">
                        <div> {{ getMonthDescPlanning(date('m', strtotime($holiday->hol_date))) }} </div>
                    </td>
                    <td class="text-center">
                        <div> {{ convertFormatDateToThai(date('Y-M-d', strtotime($holiday->hol_date))) }} </div>
                    </td>
                    <td class="text-left">
                        <div> {{ $holiday->descripiton }} </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>