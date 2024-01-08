<table class="table">
    <thead>
        <tr style="background-color: gainsboro;">
            <th width="20%" class="text-center">
                <div> ปีงบประมาณ </div>
            </th>
            <th width="20%" class="text-center">
                <div> งวดที่ </div>
            </th>
            <th width="20%" class="text-right">
                <div> วันที่เริ่มต้น </div>
            </th>
            <th width="20%" class="text-right">
                <div> วันที่สิ้นสุด </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @if ($header)
            @foreach ($header->orderPeriodLines->sortBy('period_no') as $line)
                <tr>
                    <td class="text-center">{{ $header->budget_year + 543 }}</td>
                    <td class="text-center">
                        {{ $line->period_no }}
                    </td>
                    <td class="text-right">
                        {{ parseToDateTh($line->start_period) }}
                    </td>
                    <td class="text-right">
                        {{ parseToDateTh($line->end_period) }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="4">
                    No Data
                </td>
            </tr>
        @endif
        {{-- <template v-if="periodLists.length">
            <template v-for="list in sortArrays(periodLists)">
                <tr>
                    <td class="text-center">
                        @{{ budget_year }}
                    </td>
                    <td class="text-center">
                        @{{ list.period_no }}
                    </td>
                    <td class="text-right">
                        @{{ list.start_period }}
                    </td>
                    <td class="text-right">
                        @{{ list.end_period }}
                    </td>
                </tr>
            </template>
        </template>
        <template v-else>
            <tr>
                <td class="text-center" colspan="4">
                    No Data
                </td>
            </tr>
        </template> --}}
    </tbody>
</table>