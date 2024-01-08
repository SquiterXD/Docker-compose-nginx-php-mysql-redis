<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานส่งข้อมูลค่าเบี้ยประกันภัยรายเดือน </title>
    @include('ir.reports.irr8020._style')
</head>
<body>
    <?php
        $lineLimit = 15;
        $page = ceil(count($summaries) / $lineLimit);
        $dataChunk = array_chunk($summaries->toArray(), $lineLimit);
    ?>
    @foreach ($dataChunk as $key => $lines)
        @include('ir.reports.irr8020.header')
        @if ($loop->last)
            <div>
        @else
            <div style="page-break-after: always;">
        @endif
        <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
            <thead>
                <tr>
                    <th width="8%" class="report_header">
                        รหัสบัญชี
                    </th>
                    <th width="30%" class="report_header">
                        ชื่อบัญชี
                    </th>
                    <th width="8%" class="report_header">
                        DR Amount
                    </th>
                    <th width="8%" class="report_header">
                        CR Amount
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lines as $line)
                    <tr>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                            {{ $line['prepaid_account'] }}
                        </td>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;">
                            {{ $line['prepaid_account_desc'] }}
                        </td>
                        <td class="report_qty">
                            {{ number_format($line['net_amount'], 2) }}
                        </td>
                        <td class="report_qty">
                            {{ number_format($line['net_amount'], 2) }}
                        </td>
                    </tr>
                @endforeach
                @if ($loop->last)
                    <tr>
                        <th colspan="2" style="font-size: 16px; text-align: center; border: 0.5px solid #000000;">
                            รวมเดือน {{ $period_name_thai }}
                        </th>
                        <th class="report_qty">
                            {{ getSumDataFormat($summaries, 'net_amount', 2) }}
                        </th>
                        <th class="report_qty">
                            {{ getSumDataFormat($summaries, 'net_amount', 2) }}
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    @endforeach
</body>
</html>
