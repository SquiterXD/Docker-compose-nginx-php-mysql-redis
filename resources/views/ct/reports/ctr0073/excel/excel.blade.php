
    <tr>
        <th colspan="7" style="text-align: center">การยาสูบแห่งประเทศไทย</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center">รายงานบัตรต้นทุนประจำวัน : 30 มวน</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center">ประจำวันที่</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center">วันที่ผลิตเสร็จ</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center">สถานะ</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center">หน่วยงาน</th>
    </tr>

@foreach ($apIn->groupBy('ct_accounting_date') as $date => $dateDetail)
    <table style="border: 1px solid #000000;">
        <tr>
            <td colspan="7" style="font-size: 16px">
                {{ parseToDateTh($date) }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;"></td>
            <td style="border: 1px solid #000000;" colspan="5"></td>
        </tr>
        <tr>
            <td style="text-align: center; border: 1px solid #000000;">รายการ</td>
            <td style="border: 1px solid #000000;">ปริมาณ 1000 มวน</td>
            <td style="border: 1px solid #000000;">วัตถุดิบ</td>
            <td style="border: 1px solid #000000;">ค่าแรง</td>
            <td style="border: 1px solid #000000;">ค่าใช้จ่ายผันแปร</td>
            <td style="border: 1px solid #000000;">ค่าใช้จ่ายคงที่</td>
            <td style="border: 1px solid #000000;">รวมต้นทุนคิดเข้างาน</td>
        </tr>
        <tbody>
            <?php
                $array = [];
            ?>
            @foreach ($dateDetail->groupBy('ct_wip_code')  as $key => $wipDetail)
                @php
                    $firstWipDetail = $wipDetail->first();
                    $array[$loop->iteration] = $wipDetail;
                @endphp
                <tr>
                    <td style="border: 1px solid #000000;">
                        <strong><u>ขั้นตอน</u></strong>
                        {{ $firstWipDetail->ct_wip_code }}
                        {{ $firstWipDetail->ct_wip_name }}
                    </td>
                    <td style="border: 1px solid #000000;">
                    </td>
                    <td style="border: 1px solid #000000;">
                    </td>
                    <td style="border: 1px solid #000000;">
                        {{ $firstWipDetail->ct_percent_finish_dl }} %
                        ({{ $firstWipDetail->ct_percent_finish_dl_rate }})
                    </td>
                    <td style="border: 1px solid #000000;">
                        {{ $firstWipDetail->ct_percent_finish_voh }} %
                        ({{ $firstWipDetail->ct_percent_finish_voh_rate}})
                    </td>
                    <td style="border: 1px solid #000000;">
                        {{ $firstWipDetail->ct_percent_finish_foh }} %
                        ({{ $firstWipDetail->ct_percent_finish_foh_rate}})
                    </td>
                    <td style="border: 1px solid #000000;">

                    </td>
                </tr>

                @if ($loop->iteration != 1)
                    <tr>
                        <td style="border: 1px solid #000000; ">
                            รับมาจากขั้นตอน
                                {{$array[$loop->iteration][0]->ct_wip_code}}
                                {{$array[$loop->iteration][0]->ct_wip_name}}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_prev_wip_prd_aq_issue, 6 ) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_prev_wip_dm_aqsp_issue, 2 ) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_prev_wip_dl_aqsp_issue, 2 ) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_prev_wip_voh_aqsp_issue, 2 ) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_prev_wip_foh_aqsp_issue, 2 ) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                        </td>
                    </tr>
                @endif

                <tr>
                    <td style="border: 1px solid #000000;">
                        วัตถุดิบใช้ไประหว่างงวด
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                </tr>

                @foreach ($wipDetail as $line)
                    <tr>
                        <td style="border: 1px solid #000000;">
                            {{ $line->ct_dm_code }}
                            {{ $line->ct_dm_name }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($line->ct_dm_aq_inwip, 6) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($line->ct_dm_aqsp_inwip, 2) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">

                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="border: 1px solid #000000;">
                        รวมต้นทุนวัตถุดิบใช้ไปในงวด
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($wipDetail->sum('ct_dm_aqsp_inwip'), 2)  }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000;">
                        สูญเสีย
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_pro_aq_loss, 6)  }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;" >

                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">

                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000;">
                        ยอดผลิตได้ระหว่างงวด
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_prd_aq_inwip, 6) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($wipDetail->sum('ct_dm_aqsp_inwip'),2)  }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_dl_aqsp_inwip, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_voh_aqsp_inwip, 2)  }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_foh_aqsp_inwip, 2 ) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        <?php
                            $sumtotal = $firstWipDetail->ct_prd_aq_inwip + $wipDetail->sum('ct_dm_aqsp_inwip') +
                            $firstWipDetail->ct_dl_aqsp_inwip + $firstWipDetail->ct_voh_aqsp_inwip + $firstWipDetail->ct_foh_aqsp_inwip
                        ?>
                        {{ number_format($sumtotal, 2) }}

                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000;">
                        คลังเช้า
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        {{ number_format($firstWipDetail->ct_prd_aq_wipbegin, 6) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        {{ number_format($firstWipDetail->ct_dm_aqsp_wipbegin, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        {{ number_format($firstWipDetail->ct_dl_aqsp_wipbegin, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        {{ number_format($firstWipDetail->ct_voh_aqsp_wipbegin, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        {{ number_format($firstWipDetail->ct_foh_aqsp_wipbegin, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        <?php
                        $sumtotal =  $firstWipDetail->ct_prd_aq_wipbegin + $firstWipDetail->ct_dm_aqsp_wipbegin+
                        $firstWipDetail->ct_dl_aqsp_wipbegin + $firstWipDetail->ct_voh_aqsp_wipbegin + $firstWipDetail->ct_foh_aqsp_wipbegin;
                        ?>
                        {{ number_format($sumtotal, 2) }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000;">
                        รวมต้นทุนทั้งสิ้น
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_prd_aq_total, 6) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_dm_aqsp_total, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_dl_aqsp_total, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_voh_aqsp_total, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_foh_aqsp_total, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        <?php
                            $sumtotal = $firstWipDetail->ct_prd_aq_total + $firstWipDetail->ct_dm_aqsp_total +
                            $firstWipDetail->ct_dl_aqsp_total + $firstWipDetail->ct_voh_aqsp_total + $firstWipDetail->ct_foh_aqsp_total
                        ?>
                        {{ number_format($sumtotal, 2) }}
                    </td>
                </tr>

                @if ($loop->iteration)
                    <tr>
                        <td style="border: 1px solid #000000;">
                            โอนไปขั้นตอน
                                {{--  {{$array[$loop->iteration][0]->ct_wip_code}}
                                {{$array[$loop->iteration][0]->ct_wip_name}}  --}}

                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{  number_format($firstWipDetail->ct_prd_aq_issue, 6) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_dm_aqsp_issue, 2) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_dl_aqsp_issue, 2) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_voh_aqsp_issue, 2) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right; color:blue;">
                            {{ number_format($firstWipDetail->ct_foh_aqsp_issue, 2) }}
                        </td>
                        <td style="border: 1px solid #000000; text-align: right;">
                            <?php
                                $sumtotal = $firstWipDetail->ct_prd_aq_issue + $firstWipDetail->ct_dm_aqsp_issue +
                                $firstWipDetail->ct_dl_aqsp_issue + $firstWipDetail->ct_voh_aqsp_issue + $firstWipDetail->ct_foh_aqsp_issue
                            ?>
                            {{ number_format($sumtotal, 2) }}
                        </td>
                    </tr>
                @endif

                <tr>
                    <td style="border: 1px solid #000000;">
                        ยอดปลายงวด
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_prd_aq_wipend, 6) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_dm_aqsp_wipend, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_dl_aqsp_wipend, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_voh_aqsp_wipend, 2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right; color:blue;">
                        {{ number_format($firstWipDetail->ct_foh_aqsp_wipend,2) }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: right;">
                        <?php
                            $sumtotal = $firstWipDetail->ct_prd_aq_wipend + $firstWipDetail->ct_dm_aqsp_wipend +
                            $firstWipDetail->ct_dl_aqsp_wipend + $firstWipDetail->ct_voh_aqsp_wipend + $firstWipDetail->ct_foh_aqsp_wipend
                        ?>
                        {{ number_format($sumtotal, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endforeach

