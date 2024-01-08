<div class="table-responsive m-t mb-3">
    <h2 class="mb-1 text-left">สรุปประมาณการผลิตทั้งปีงบประมาณ</h2>
    <br>
    <table class="table text-nowrap table-bordered" border="1">
        <thead>
            <tr>
                <th colspan="{{ count($periods)+2 }}" class="text-center"> ประมาณการผลิต </th>
            </tr>
            <tr>
                <th class=""> </th>
                @foreach ($periods as $period_no => $thai_month_arr)
                    <th class="text-center">{{ $thai_month_arr }}</th>
                @endforeach
                <th class="text-center"> รวม </th>
            </tr>
        </thead>
        <tbody>
            @if (count($estimateYearlies) <= 0)
                <tr>
                    <td colspan="{{ count($periods)+2 }}" class="text-center">
                        <h2> ไม่พบข้อมูลประมาณการผลิตทั้งปีงบประมาณ </h2>
                    </td>
                </tr>
            @else
                @foreach ($estimateYearlies as $col_desc => $est)
                    <tr>
                        <td class=""> {{ $col_desc }} </td>
                        @foreach ($est as $period_no => $value)
                            <td class="text-right"> {{ number_format($est[$period_no], 2) }} </td>
                            @if ($loop->last)
                                <td class="text-right tw-font-bold" style="color: white; background-color: #34d399;">
                                    {{ number_format(array_sum($est), 2) }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>