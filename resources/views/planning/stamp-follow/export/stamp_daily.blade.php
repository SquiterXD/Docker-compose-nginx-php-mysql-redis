<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> ติดตามการใช้แสตมป์รายวันแยกตามกลุ่มราคา </title>
    @include('planning.stamp-follow.export._style')
</head>
<body>
    @foreach ($stampItems as $stampItem)
        <div style="page-break-before:always;"></div>
        <h3> ติดตามการใช้แสตมป์รายวันแยกตามกลุ่มราคา {{ $stampItem->stamp_description }}</h3>
        <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
            <thead>
                <tr>
                    <th width="8%" rowspan="2" class="stamp-header">
                        วันที่
                    </th>
                    <th width="5%" rowspan="2" class="stamp-header">
                        คงคลังเช้า <br> (ดวง)
                    </th>
                    <th width="5%" colspan="3" class="stamp-header">
                        รับเข้า
                    </th>
                    <th width="5%" rowspan="2" class="stamp-header">
                        ประมาณการใช้ <br> (ดวง)
                    </th>
                    <th width="5%" colspan="2" class="stamp-header">
                        คงคลังเย็น
                    </th>
                    <th width="5%" rowspan="2" class="stamp-header">
                        พอใช้ <br> (วัน)
                    </th>
                </tr>
                <tr>
                    <th width="5%" class="stamp-header">
                        ดวง
                    </th>
                    <th width="5%" class="stamp-header">
                        ม้วน
                    </th>
                    <th width="5%" class="stamp-header">
                        จำนวนเงิน
                    </th>
                    <th width="5%" class="stamp-header">
                        ดวง
                    </th>
                    <th width="5%" class="stamp-header">
                        ม้วน
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lines as $line)
                    @if ($stampItem->follow_stamp_id == $line->follow_stamp_id)
                        <tr style="{{ $line->holiday_flag == 'Y'? 'background-color: #cccccc;': ''}}">
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center; padding: 4px; height: 10px;">
                                {{ convertFormatDateToFullThai($line->follow_date, 'short_format') }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->onhand_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->weekly_receive_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->receive_roll_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->receipt_amount, 2) }}
                            </td>
                            <td class="stamp-qty" style="background-color: #f5cdda;">
                                {{ number_format($line->total_daily_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->total_bal_onhand_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->bal_onhand_qty, 2) }}
                            </td>
                            <td class="stamp-qty">
                                {{ number_format($line->bal_days, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if ($loop->last)
                        <tr>
                            <th colspan="2" style="font-size: 16px; text-align: center; border: 0.5px solid #000000; padding: 4px; background-color: #5edc96; height: 10px;">
                                รวมเดือน {{ $stampFollowMain->ppPeriod->thai_month.' '.$stampFollowMain->ppPeriod->period_year_thai }}
                            </th>
                            <th class="stamp-qty" style="background-color: #5edc96;">
                                {{ getSumStampDailyFormat($lines, $stampItem->follow_stamp_id, 'weekly_receive_qty', 2) }}
                            </th>
                            <th class="stamp-qty" style="background-color: #5edc96;">
                                {{ getSumStampDailyFormat($lines, $stampItem->follow_stamp_id, 'receive_roll_qty', 2) }}
                            </th>
                            <th class="stamp-qty" style="background-color: #5edc96;">
                                {{ getSumStampDailyFormat($lines, $stampItem->follow_stamp_id, 'receipt_amount', 2) }}
                            </th>
                            <th class="stamp-qty" style="background-color: #5edc96;">
                                {{ getSumStampDailyFormat($lines, $stampItem->follow_stamp_id, 'total_daily_qty', 2) }}
                            </th>
                            <th class="stamp-qty" colspan="3" style="background-color: #5edc96;"></th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @include('planning.stamp-follow.export.footer')
    @endforeach
</body>
</html>
