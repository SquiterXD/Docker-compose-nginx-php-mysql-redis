<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานส่งข้อมูลค่าเบี้ยประกันภัยรายเดือน </title>
    @include('ir.reports.irr8020._style')
</head>
<body>
    @foreach ($summaries as $key => $glLine)
        <?php
            $key = 0;
            $lineLimit = 12;
            $page = ceil(count($glLine) / $lineLimit);
            $dataChunk = array_chunk($glLine->toArray(), $lineLimit);
        ?>
        @foreach ($dataChunk as $key => $lines)
            {{-- @if ($loop->last)
                <div>
            @else --}}
                <div style="page-break-after: always;">
            {{-- @endif --}}
        {{-- /*<div style="page-break-after: always;">*/ --}}
            @include('ir.reports.irr8020.header')
            <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
                <thead>
                    <tr style="background-color: #C7CCC5;">
                        <th width="8%" class="report_header">
                            รหัสบัญชี
                        </th>
                        <th width="30%" class="report_header">
                            ชื่อบัญชี
                        </th>
                        <th width="7%" class="report_header">
                            DR. Amount
                        </th>
                        <th width="7%" class="report_header">
                            CR. Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lines as $line)
                        <tr>
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                                {{ $line['account_code_combine'] }}
                            </td>
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: left;">
                                {!! getDescriptionAccount($line['account_code_combine']) !!}
                            </td>
                            <td class="report_qty">
                                {{ number_format($line['entered_dr'], 2) }}
                            </td>
                            <td class="report_qty">
                                {{ number_format($line['entered_cr'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                    @if ($loop->last)
                        <tr>
                            <th colspan="2" style="font-size: 16px; text-align: center; border: 0.5px solid #000000;">
                                รวมเดือน {{ $period_name_thai }}
                            </th>
                            <th class="report_qty">
                                {{ getSumDataFormat($glLine, 'entered_dr', 2) }}
                            </th>
                            <th class="report_qty">
                                {{ getSumDataFormat($glLine, 'entered_cr', 2) }}
                            </th>
                        </tr>
                    @endif
                </tbody>
            </table>
            </div>
        @endforeach
    @endforeach
            <div style="page-break-after: always;">
</body>
</html>
