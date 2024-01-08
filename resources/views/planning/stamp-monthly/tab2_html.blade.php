<table  class="table text-nowrap table-bordered table-hover">
    <thead>
    <tr>
        <th></th>
        {{-- @foreach ($itemList as $itemCode => $itemDesc)
            <th class="text-center">{{ $itemDesc }}</th>
        @endforeach --}}
        @foreach ($dailyList as $dateTh => $dateUs)
            <th class="text-center">{{ $dateTh }}</th>
        @endforeach
        <th class="text-center">รวม</th>
    </tr>
    </thead>
    <tbody>

        @foreach ($itemList as $itemCode => $itemDesc)
        <tr>
            <td class="text-center">
                {{ $itemDesc }}
            </td>
            @foreach ($dailyList as $dateTh => $dateUs)
                <td class="text-right" style="background-color: {{ (\Arr::get($holidayFlag, $dateTh) == 'Y') ? '#c0c4cc': '' }}">
                    {{ number_format($summary->where('plan_date', $dateUs)->where('cigarettes_code', $itemCode)->sum('weekly_receive_qty') ?? 0) }}
                </td>
            @endforeach
            <td class="text-right">
                {{ number_format($summary->where('cigarettes_code', $itemCode)->sum('weekly_receive_qty') ?? 0) }}
            </td>
        </tr>
        @endforeach
        <tr >
            <th colspan="1" class="text-right">
                <strong>รวม</strong>
            </th>
            @foreach ($dailyList as $dateTh => $dateUs)
                <td style="background-color: #34d399;" class="text-right text-white">
                    {{ number_format($summary->where('plan_date', $dateUs)->sum('weekly_receive_qty') ?? 0) }}
                </td>
            @endforeach
            <td style="background-color: #34d399;" class="text-right text-white">
                {{ number_format($summary->sum('weekly_receive_qty') ?? 0) }}
            </td>
        </tr>

        {{-- @foreach ($dailyList as $dateTh => $dateUs)
        <tr style="background-color: {{ (\Arr::get($holidayFlag, $dateTh) == 'Y') ? '#c0c4cc': '' }}">
            <td class="text-center">
                {{ $dateTh }}
            </td>
            @foreach ($itemList as $itemCode => $itemDesc)
                <td class="text-right">
                    {{ number_format($summary->where('plan_date', $dateUs)->where('cigarettes_code', $itemCode)->sum('weekly_receive_qty') ?? 0, 3) }}
                </td>
            @endforeach
            <td class="text-right">
                {{ number_format($summary->where('plan_date', $dateUs)->sum('weekly_receive_qty') ?? 0, 3) }}
            </td>
        </tr>
        @endforeach
        <tr >
            <th colspan="1" class="text-right">
                <strong>รวม</strong>
            </th>
            @foreach ($itemList as $itemCode => $itemDesc)
                <td style="background-color: #34d399;" class="text-right text-white">
                    {{ number_format($summary->where('cigarettes_code', $itemCode)->sum('weekly_receive_qty') ?? 0, 3) }}
                </td>
            @endforeach
            <td style="background-color: #34d399;" class="text-right text-white">
                {{ number_format($summary->sum('weekly_receive_qty') ?? 0, 3) }}
            </td>
        </tr> --}}
    </tbody>
