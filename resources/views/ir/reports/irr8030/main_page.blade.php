<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานส่งข้อมูลค่าเบี้ยประกันภัยจ่ายล่วงหน้า </title>
    @include('ir.reports.irr8010._style')
</head>
<body>
    @php
        $page_no = 0;
    @endphp
    @foreach ($invoices as $invoice_number => $lines)
        @php
            $lineLimit = 15;
            $page = getCountPageAll($invoices, $lineLimit);
            $dataChunk = array_chunk($lines, $lineLimit);
            $arHeader = getArHeaderOracle($lines[0]['invoice_number']);
        @endphp
        @foreach ($dataChunk as $index => $line)
        @php
            $page_no++;
            $totalByInv = 0;
        @endphp
        <div style="page-break-after: always;"> </div>
            <br>
            @php
                foreach ($line as $no => $value){
                    $totalByInv += str_replace(',', '', number_format($value['line_amount'], 2));
                }
            @endphp
            @include('ir.reports.irr8030.header')
            <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
                <thead>
                    <tr style="background-color: #C7CCC5;">
                        <th width="6%" class="report_header">
                            ประเภท
                        </th>
                        <th width="5%" class="report_header">
                            วันที่
                        </th>
                        <th width="10%" class="report_header">
                            Transaction Source
                        </th>
                        <th width="10%" class="report_header">
                            Transaction Type
                        </th>
                        <th width="15%" class="report_header">
                            ลูกหนี้
                        </th>
                        <th width="7%" class="report_header">
                            จำนวนเงินรวม
                        </th>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center; border-bottom-color: #fff;">
                            Invoice
                        </td>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                            {{ $lines[0]['invoice_date']? strtoupper(date('d-M-Y', strtotime($lines[0]['invoice_date']))): '' }}
                        </td>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                            {{ $lines[0]['batch_source_name'] }}
                        </td>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                            {{ $lines[0]['cust_trx_type_name'] }}
                        </td>
                        <td class="report_qty" style="text-align: center;">
                            {{ $lines[0]['customer_name'] }}
                        </td>
                        <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">
                            @if ($totalByInv < 0)
                                ({{ number_format(abs($totalByInv), 2) }})
                            @else
                                {{ number_format($totalByInv, 2) }}
                            @endif
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="1%" style="font-size: 16px; border: 0.5px solid #000000; text-align: center; border-top-color: #fff;border-bottom-color: #fff;"> </th>
                        <th width="3%" class="report_header">
                            ลำดับ
                        </th>
                        <th colspan="2" width="15%" class="report_header">
                            Description
                        </th>
                        <th width="7%" class="report_header">
                            Code Combination
                        </th>
                        <th width="8%" class="report_header">
                            จำนวนเงิน
                        </th>
                    </tr>
                    <tr>
                        <td rowspan="{{ count($lines) }}" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> </td>
                        @foreach ($line as $no => $value)
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                                {{ $value['line_number'] }}
                            </td>
                            <td colspan="2" style="font-size: 16px; border: 0.5px solid #000000; text-align: left;">
                                {{ $value['line_description'] }}
                            </td>
                            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
                                {{ $value['rev_account_combine'] }}
                            </td>
                            <td class="report_qty">
                                @if ($value['line_amount'] < 0)
                                    ({{ number_format(abs($value['line_amount']), 2) }})
                                @else
                                    {{ number_format($value['line_amount'], 2) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach
</body>
</html>
