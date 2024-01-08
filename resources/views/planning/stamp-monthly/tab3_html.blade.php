<table  class="table text-nowrap table-bordered table-hover">
    <thead>
    <tr>
        <th rowspan="2" class="text-center">วันที่</th>
        <th rowspan="2" class="text-center">คงคลังเช้า (ดวง)</th>
        <th colspan="3" class="text-center">รับเข้า</th>
        <th rowspan="2" class="text-center">ประมาณการใช้(ดวง)</th>
        <th colspan="2" class="text-center">คงคลังเย็น</th>
        <th rowspan="2" class="text-center">พอใช้(วัน)</th>
    </tr>
    <tr>
        <th class="text-center">ดวง</th>
        <th class="text-center">ม้วน</th>
        <th class="text-center">จำนวนเงิน</th>
        <th class="text-center">ดวง</th>
        <th class="text-center">ม้วน</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($summary as $item)
        <tr style="background-color: {{ (\Arr::get($holidayFlag, $item->plan_date_format) == 'Y') ? '#c0c4cc': '' }}">
            <td class="text-center">{{ $item->plan_date_thai }}</td>
            <td class="text-right">{{ number_format($item->onhand_qty ?? 0) }}</td>
            <td class="text-right">
                {{ number_format($item->weekly_receive_qty ?? 0) }}
            </td>
            <td class="text-right">
                {{ number_format($item->receive_roll_qty ?? 0, 2) }}
            </td>
            <td class="text-right">{{ number_format($item->receipt_amount ?? 0, 3) }}</td>
            <td class="text-right">{{ number_format($item->total_daily_qty ?? 0) }}</td>
            <td class="text-right">
                @if ($item->bal_onhand_qty < 0)
                    <span class="text-danger"> {{ number_format($item->bal_onhand_qty ?? 0) }} </span>
                @else
                    {{ number_format($item->bal_onhand_qty ?? 0) }}
                @endif
            </td>
            <td class="text-right">{{ number_format($item->bal_onhand_roll_qty ?? 0, 2) }}</td>
            <td class="text-right">{{ number_format($item->bal_days ?? 0, 2) }}</td>
        </tr>
    @endforeach
    <tr >
        <th colspan="2" class="text-right">
            <strong>รวม</strong>
        </th>
        <td style="background-color: #34d399;" class="text-right text-white">
            {{ number_format($summary->sum('weekly_receive_qty') ?? 0) }}
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
            {{ number_format($summary->sum('receive_roll_qty') ?? 0, 2) }}
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
            {{ number_format($summary->sum('receipt_amount') ?? 0, 3) }}
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
            {{ number_format($summary->sum('total_daily_qty') ?? 0) }}
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
        </td>
        <td style="background-color: #34d399;" class="text-right text-white">
        </td>
    </tr>
    </tbody>
</table>