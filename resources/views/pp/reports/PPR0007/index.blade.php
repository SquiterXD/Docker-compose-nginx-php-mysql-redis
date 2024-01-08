<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> งบเดือนการปิดแสตมป์ยาสูบ </title>
    @include('pp.reports.PPR0007._style')
</head>
<body>
    @php
        //
    @endphp

    @foreach ($sequnces as $group => $seqs)
        @php
            // dd($cigarettes->whereIn('item_id', array_values($seqs)), $seqs);
            $totalOnhand = 0;
            $totalReceiveMonth = 0;
            $totalReceive = 0;
            $totalUsedMonth = 0;
            $totalBalance = 0;
            $receive = 0;
            $balance = 0;

            $cigarettess = $cigarettes->whereIn('item_id', array_values($seqs));
        @endphp
        <div style="page-break-after: always;"> </div>
        {{-- HEADER --}}
        @include('pp.reports.PPR0007.header')
        <br><br>
        {{-- DATA STAMP PER MONTH --}}
        <table class="table table-bordered mt-3" style="border-collapse: collapse; border: 1px solid #ddd; padding: 0px; margin: 0px;">
            <thead>
                <tr>
                    <th width="15%" class="stamp-header">
                        รายการแสตมป์ยาสูบ
                    </th>
                    @foreach ($cigarettess as $index => $cigarett)
                        <th width="15%" class="stamp-header">
                            ตรา....<span style="font-size: 16px;">{{ thainumDigit($cigarett->cigarettes_description) }}</span>....
                        </th>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <th width="15%" class="stamp-header">
                            <strong>ตรา..........</strong>
                        </th>
                    @endif
                    <th width="12%" class="stamp-header">
                        รวมทั้งสิ้น
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="stamp-header">
                        คงเหลือยกมา
                    </td>
                    @foreach ($cigarettess as $index => $cigarett)
                        @php
                            $totalOnhand += $onhands[$cigarett->cigarettes_code][0];
                        @endphp
                        <td class="stamp-qty">
                            {{ thainumDigit(number_format($onhands[$cigarett->cigarettes_code][0])) }}
                        </td>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <td class="text-center stamp-qty">
                            -
                        </td>
                    @endif
                    <td class="stamp-qty">
                        {{ thainumDigit(number_format($totalOnhand)) }}
                    </td>
                </tr>

                <tr>
                    <td class="stamp-header">
                        รับเดือนนี้
                    </td>
                    @foreach ($cigarettess as $index => $cigarett)
                        @php
                            $totalReceiveMonth += array_sum($receives[$cigarett->cigarettes_code]);
                        @endphp
                        <td class="stamp-qty">
                            {{ thainumDigit(number_format(array_sum($receives[$cigarett->cigarettes_code]))) }}
                        </td>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <td class="text-center stamp-qty">
                            -
                        </td>
                    @endif
                    <td class="stamp-qty">
                        {{ thainumDigit(number_format($totalReceiveMonth)) }}
                    </td>
                </tr>

                <tr>
                    <td class="stamp-header">
                        รวมรับ
                    </td>
                    @foreach ($cigarettess as $index => $cigarett)
                        @php
                            $receive = $onhands[$cigarett->cigarettes_code][0] + array_sum($receives[$cigarett->cigarettes_code]);
                            $totalReceive += $receive;
                        @endphp
                        <td class="stamp-qty">
                            {{ thainumDigit(number_format($receive)) }}
                        </td>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <td class="text-center stamp-qty">
                            -
                        </td>
                    @endif
                    <td class="stamp-qty">
                        {{ thainumDigit(number_format($totalReceive)) }}
                    </td>
                </tr>

                <tr>
                    <td class="stamp-header">
                        ใช้เดือนนี้
                    </td>
                    @foreach ($cigarettess as $index => $cigarett)
                        @php
                            $usedMonth = array_sum($totalDaily[$cigarett->cigarettes_code]) + array_sum($damagedDaily[$cigarett->cigarettes_code]) + array_sum($lossDaily[$cigarett->cigarettes_code]) + array_sum($incomDaily[$cigarett->cigarettes_code]);
                            $totalUsedMonth += $usedMonth;
                        @endphp
                        <td class="stamp-qty">
                            {{ thainumDigit(number_format($usedMonth)) }}
                        </td>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <td class="text-center stamp-qty">
                            -
                        </td>
                    @endif
                    <td class="stamp-qty">
                        {{ thainumDigit(number_format($totalUsedMonth)) }}
                    </td>
                </tr>

                <tr>
                    <td class="stamp-header">
                        คงเหลือยกไป
                    </td>
                    @foreach ($cigarettess as $index => $cigarett)
                        @php
                            $balance = $onhands[$cigarett->cigarettes_code][0] + array_sum($receives[$cigarett->cigarettes_code]) - array_sum($totalDaily[$cigarett->cigarettes_code]) - array_sum($damagedDaily[$cigarett->cigarettes_code]) - array_sum($lossDaily[$cigarett->cigarettes_code]) - array_sum($incomDaily[$cigarett->cigarettes_code]);
                            $totalBalance += $balance;
                        @endphp
                        <td class="stamp-qty">
                            {{ thainumDigit(number_format($balance)) }}
                        </td>
                    @endforeach
                    @if (count($cigarettess) == 2)
                        <td class="text-center stamp-qty">
                            -
                        </td>
                    @endif
                    <td class="stamp-qty">
                        {{ thainumDigit(number_format($totalBalance)) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br>
        {{-- FOOTER --}}
        @include('pp.reports.PPR0007.footer')
    @endforeach


</body>
</html>
