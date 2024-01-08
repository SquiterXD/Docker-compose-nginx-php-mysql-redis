<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานบัตรต้นทุนประจำวัน : 30 มวน </title>
    @include('ct.reports.ctr0073.style')

</head>
<body>
        @foreach ($apIn->groupBy('ct_accounting_date') as $date => $dateDetail)
            <div style="page-break-after: always;"> </div>
            @include('ct.reports.ctr0073.header')
            <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
                <thead style=" display: table-header-group; background-color:#edf2f7;">
                    <tr style="background-color: #C7CCC5;">
                        <th width="auto" class="report_header">
                            รายการ
                        </th>
                        <th width="auto" class="report_header">
                            ปริมาณ 1000 มวน
                        </th>
                        <th width="auto" class="report_header">
                            วัตถุดิบ
                        </th>
                        <th width="auto" class="report_header">
                            ค่าแรง
                        </th>
                        <th width="auto" class="report_header">
                            ค่าใช้จ่ายผันแปร
                        </th>
                        <th width="auto" class="report_header">
                            ค่าใช้จ่ายคงที่
                        </th>
                        <th width="auto" class="report_header">
                            รวมต้นทุนคิดเข้างาน
                        </th>
                    </tr>
                </thead>
                <tbody>
                        <tr style="page-break-inside: avoid;">
                            <td style="font-size: 14px; border: 0.5px solid #000000; "  colspan="7">
                                {{ parseToDateTh($date) }}
                            </td>
                        </tr>
                        <?php
                            $array = [];
                        ?>
                        @foreach ($dateDetail->groupBy('ct_wip_code')  as $key => $wipDetail)

                        @php
                            $firstWipDetail = $wipDetail->first();
                            $array[$loop->iteration] = $wipDetail;
                        @endphp
                        <tr>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                <strong><u>ขั้นตอน</u></strong>
                                {{ $firstWipDetail->ct_wip_code }}
                                {{ $firstWipDetail->ct_wip_name }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">
                                {{ $firstWipDetail->ct_percent_finish_dl }} %
                                ({{ $firstWipDetail->ct_percent_finish_dl_rate }})
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">
                                {{ $firstWipDetail->ct_percent_finish_voh }} %
                                ({{ $firstWipDetail->ct_percent_finish_voh_rate}})
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">
                                {{ $firstWipDetail->ct_percent_finish_foh }} %
                                ({{ $firstWipDetail->ct_percent_finish_foh_rate}})
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                            </td>
                        </tr>

                        @if ($loop->iteration!= 1)
                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>รับมาจากขั้นตอน
                                        {{$array[$loop->iteration][0]->ct_wip_code}}
                                        {{$array[$loop->iteration][0]->ct_wip_name}}
                                    </strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_prev_wip_prd_aq_issue, 6 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_prev_wip_dm_aqsp_issue, 2 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_prev_wip_dl_aqsp_issue, 2 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_prev_wip_voh_aqsp_issue, 2 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_prev_wip_foh_aqsp_issue, 2 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                                </td>
                            </tr>
                        @endif



                        <tr>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                <strong>วัตถุดิบใช้ไประหว่างงวด</strong>
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000;" class="text-right">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">

                            </td>
                            <td class="report_qty">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: left;">

                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                            </td>
                        </tr>
                            @foreach ($wipDetail as $line)
                                <tr>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-left">
                                        {{ $line->ct_dm_code }}
                                        {{ $line->ct_dm_name }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; font-weight:bold; color:blue">
                                        {{ number_format($line->ct_dm_aq_inwip, 6) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue" class="text-right">
                                        {{ number_format($line->ct_dm_aqsp_inwip, 2) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: left;">

                                    </td>
                                    <td class="report_qty">

                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: left;">

                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>รวมต้นทุนวัตถุดิบใช้ไปในงวด</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue" class="text-right">
                                    {{ number_format($wipDetail->sum('ct_dm_aqsp_inwip'), 2)  }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">

                                </td>
                                <td class="report_qty">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: left;">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                                </td>
                            </tr>

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>สูญเสีย</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; font-weight:bold; color:blue">
                                    {{ number_format($firstWipDetail->ct_pro_aq_loss, 6)  }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000;" class="text-right">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">

                                </td>
                                <td class="report_qty">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: left;">

                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: center;">

                                </td>
                            </tr>

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>ยอดผลิตได้ระหว่างงวด</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; font-weight:bold; color:blue">
                                    {{ number_format($firstWipDetail->ct_prd_aq_inwip, 6) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue" class="text-right">
                                    {{ number_format($wipDetail->sum('ct_dm_aqsp_inwip'),2)  }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dl_aqsp_inwip, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_voh_aqsp_inwip, 2)  }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; font-weight:bold; color:blue; text-align: right;">
                                    {{ number_format($firstWipDetail->ct_foh_aqsp_inwip, 2 ) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    <?php
                                        $sumtotal = $wipDetail->sum('ct_dm_aqsp_inwip') +
                                        $firstWipDetail->ct_dl_aqsp_inwip + $firstWipDetail->ct_voh_aqsp_inwip + $firstWipDetail->ct_foh_aqsp_inwip
                                    ?>
                                    {{ number_format($sumtotal, 2) }}

                                </td>
                            </tr>

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>คลังเช้า</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    {{ number_format($firstWipDetail->ct_prd_aq_wipbegin, 6) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000;" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dm_aqsp_wipbegin, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " class="text-right">
                                    {{ number_format($firstWipDetail->ct_dl_aqsp_wipbegin, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    {{ number_format($firstWipDetail->ct_voh_aqsp_wipbegin, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    {{ number_format($firstWipDetail->ct_foh_aqsp_wipbegin, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    <?php
                                    $sumtotal =  $firstWipDetail->ct_dm_aqsp_wipbegin+
                                    $firstWipDetail->ct_dl_aqsp_wipbegin + $firstWipDetail->ct_voh_aqsp_wipbegin + $firstWipDetail->ct_foh_aqsp_wipbegin;
                                    ?>
                                    {{ number_format($sumtotal, 2) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>รวมต้นทุนทั้งสิ้น</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_prd_aq_total, 6) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dm_aqsp_total, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dm_aqsp_issue, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_voh_aqsp_total, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_foh_aqsp_total, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    <?php
                                        $sumtotal = $firstWipDetail->ct_dm_aqsp_total +
                                        $firstWipDetail->ct_dl_aqsp_total + $firstWipDetail->ct_voh_aqsp_total + $firstWipDetail->ct_foh_aqsp_total
                                    ?>
                                    {{ number_format($sumtotal, 2) }}
                                </td>
                            </tr>

                            @if ($loop->iteration)
                                <tr>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                        <strong>โอนไปขั้นตอน
                                            {{--  {{$array[$loop->iteration][0]->ct_wip_code}}
                                            {{$array[$loop->iteration][0]->ct_wip_name}}  --}}
                                        </strong>
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                        {{  number_format($firstWipDetail->ct_prd_aq_issue, 6) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                        {{ number_format($firstWipDetail->ct_dm_aqsp_issue, 2) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                        {{ number_format($firstWipDetail->ct_dl_aqsp_issue, 2) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                        {{ number_format($firstWipDetail->ct_voh_aqsp_issue, 2) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                        {{ number_format($firstWipDetail->ct_foh_aqsp_issue, 2) }}
                                    </td>
                                    <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                        <?php
                                            $sumtotal = $firstWipDetail->ct_dm_aqsp_issue +
                                            $firstWipDetail->ct_dl_aqsp_issue + $firstWipDetail->ct_voh_aqsp_issue + $firstWipDetail->ct_foh_aqsp_issue
                                        ?>
                                        {{ number_format($sumtotal, 2) }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 14px; border: 0.5px solid #000000; " >
                                    <strong>ยอดปลายงวด</strong>
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_prd_aq_wipend, 6) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dm_aqsp_wipend, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; color:blue" class="text-right">
                                    {{ number_format($firstWipDetail->ct_dl_aqsp_wipend, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_voh_aqsp_wipend, 2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right; color:blue">
                                    {{ number_format($firstWipDetail->ct_foh_aqsp_wipend,2) }}
                                </td>
                                <td style="font-size: 14px; border: 0.5px solid #000000; text-align: right;">
                                    <?php
                                        $sumtotal = $firstWipDetail->ct_dm_aqsp_wipend +
                                        $firstWipDetail->ct_dl_aqsp_wipend + $firstWipDetail->ct_voh_aqsp_wipend + $firstWipDetail->ct_foh_aqsp_wipend
                                    ?>
                                    {{ number_format($sumtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        {{-- {{ dd($array)}} --}}
                    </tbody>
            </table>
        @endforeach
</body>
</html>
