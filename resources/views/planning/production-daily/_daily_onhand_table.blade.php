<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="vertical-align: middle;">
               <div>  </div>
            </th>
            @foreach ($planDates as $res_plan_date => $working)
                <th class="text-center" style="vertical-align: middle;">
                    <div class="mb-2">
                        <small style="color: #000" class="mb-2 tw-font-bold">
                            {{ convertFormatDateToThai(date('Y-M-d', strtotime($res_plan_date))) }} <br>
                        </small>
                    </div>
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if (count($onhands) == 0)
            <tr>
                <td colspan="1" class="text-center" style="vertical-align: middle;">
                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                </td>
            </tr>
        @else
                <tr>
                    <td class="text-right">
                        <div class="tw-font-bold" style="width: 125px;"> คงคลังเช้า (ล้านมวน) </div>
                    </td>
                    @foreach ($onhands as $line)
                        @foreach ($planDates as $res_plan_date => $working)
                            @if($res_plan_date == $line->daily_date && $holidays[$res_plan_date][$res_plan_date] == 'Y')
                                <td class="text-right" style="background-color: #cccccc;" >
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date
                                && $holidays[$res_plan_date][$res_plan_date] != 'Y')
                                <td>
                                    <div class="text-right" style="width: 80px;"> 
                                        {{ number_format($currentOnhand[$res_plan_date][0], 2) }}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    <td class="text-right">
                        <div class="tw-font-bold" style="width: 120px;"> เฉลี่ยขาย (ล้านมวน) </div>
                    </td>
                    @foreach ($onhands as $line)
                        @foreach ($planDates as $res_plan_date => $working)
                            @if($res_plan_date == $line->daily_date && $holidays[$res_plan_date][$res_plan_date] == 'Y')
                                <td class="text-right" style="background-color: #cccccc;" >
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date
                                && $holidays[$res_plan_date][$res_plan_date] != 'Y')
                                <td>
                                    <div class="text-right" style="width: 80px;"> 
                                        {{ number_format($avgSale[$res_plan_date][0], 2) }}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    <td class="text-right">
                        <div class="tw-font-bold" style="width: 120px;"> ผลิต (ล้านมวน) </div>
                    </td>
                    @foreach ($onhands as $line)
                        @foreach ($planDates as $res_plan_date => $working)
                            @if($res_plan_date == $line->daily_date && $holidays[$res_plan_date][$res_plan_date] == 'Y')
                                <td class="text-right" style="background-color: #cccccc;" >
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date
                                && $holidays[$res_plan_date][$res_plan_date] != 'Y')
                                <td>
                                    <div class="text-right" style="width: 80px;"> 
                                        {{ number_format($totalQuantity[$res_plan_date][0], 2) }}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    <td class="text-right">
                        <div class="tw-font-bold" title="(คลังเช้า + ผลิต - เฉลี่ยขาย) / เฉลี่ยขาย" style="width: 120px;"> พอขาย (วัน) </div>
                    </td>
                    @foreach ($onhands as $line)
                        @foreach ($planDates as $res_plan_date => $working)
                            @if($res_plan_date == $line->daily_date && $holidays[$res_plan_date][$res_plan_date] == 'Y')
                                <td class="text-right" style="background-color: #cccccc;" >
                                    <div style="width: 70px;"> 0.00 </div>
                                </td>
                            @elseif($res_plan_date == $line->daily_date
                                && $holidays[$res_plan_date][$res_plan_date] != 'Y')
                                <td>
                                    <div class="text-right" style="width: 80px; color: {{ colorTotalForSale($line->item_id, $totalSale[$res_plan_date][0]) }};"> 
                                        {{ number_format($totalSale[$res_plan_date][0], 2) }}
                                    </div>
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
        @endif
    </tbody>
</table>