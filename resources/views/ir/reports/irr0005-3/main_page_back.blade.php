<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานการแจ้งเหตุเคลมประกันภัย </title>
    @include('ir.reports.irr9130._style')
</head>
<body>
    @php
        $page_no = 0;
    @endphp
    {{-- @foreach ($claims as $lines) --}}
        @php
            $lineLimit = 5;
            $dataChunk = array_chunk($claims->toArray(), $lineLimit);
            $page = count($dataChunk);
            // Date
            $startDate = $request['accident_start_date']? date('Y-m-d', strtotime(convertDateFormatToQuery($request['accident_start_date']))): $period->start_date;
            $endDate = $request['accident_end_date']? date('Y-m-d', strtotime(convertDateFormatToQuery($request['accident_end_date']))): $period->end_date;
        @endphp
        @foreach ($dataChunk as $index => $line)
        @php
            $page_no++;
        @endphp
        <div style="page-break-after: always;"> </div>
            {{-- @include('ir.reports.irr9130.header') --}}
            <br>
            <table class="table" style="border-color: #fff; border: 0.5px solid #fff; padding: 0px; margin: 0px;">
                <thead>
                    <tr style="">
                        <th width="7.5%" class="report_header" style="border: 0.5px solid #fff">
                            เลขที่เอกสาร
                        </th>
                        <th width="10%" class="report_header" style="border: 0.5px solid #fff">
                            หัวข้อการเกิดเหตุ
                        </th>
                        <th width="7%" class="report_header" style="border: 0.5px solid #fff">
                            วัน-เวลา<br>เกิดเหตุ
                        </th>
                        <th width="10%" class="report_header" style="border: 0.5px solid #fff">
                            สถานที่เกิดเหตุ
                        </th>
                        {{-- <th width="10%" class="report_header" style="page-break-inside: avoid; ">
                            รายละเอียดเหตุการณ์
                        </th> --}}
                        <th width="7%" class="report_header" style="border: 0.5px solid #fff">
                            จำนวนเงิน<br>เรียกชดใช้โดยประมาณ
                        </th>
                        <th width="8%" class="report_header" style="border: 0.5px solid #fff">
                            จำนวนเงิน<br>เรียกชดใช้รวม
                        </th>
                        <th width="8%" class="report_header" style="border: 0.5px solid #fff">
                            หน่วยงาน<br>ผู้แจ้งเหตุ
                        </th>
                        <th width="8%" class="report_header" style="border: 0.5px solid #fff">
                            ผู้แจ้งเหตุ
                        </th>
                        <th width="8%" class="report_header" style="border: 0.5px solid #fff">
                            เบอร์โทร<br>ผู้แจ้งเหตุ
                        </th>
                        <th width="7%" class="report_header" style="border: 0.5px solid #fff">
                            สถานะปัจจุบัน
                        </th>
                        <th width="10%" class="report_header" style="border: 0.5px solid #fff">
                            เหตุผลในการยกเลิก
                        </th>
                        <th width="8%" class="report_header" style="border: 0.5px solid #fff">
                            วันที่แจ้ง<br>บริษัทประกันภัย
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($line as $no => $value)
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ $value['document_number'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: left;">
                                {{ $value['claim_title'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ parseToDateTh(date('d-m-Y', strtotime($value['accident_date']))) }} {{ date('H:i', strtotime($value['accident_time'])) }} น.
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: left;">
                                {{ $value['location_name'] }}
                            </td>
                            {{-- <td style="font-size: 14px; border: 0.5px solid #fff; text-align: left; page-break-inside: avoid;">
                                {{ $value['remarks'] }}
                            </td> --}}
                            <td class="report_qty" style="font-size: 14px; border: 0.5px solid #fff;">
                                {{ number_format($value['claim_amount'], 2) }}
                            </td>
                            <td class="report_qty" style="font-size: 14px; border: 0.5px solid #fff;">
                                {{ number_format($value['total_claim_amount'], 2) }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: left;">
                                {{ $value['department_name'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ $value['requestor_name'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ $value['requestor_tel'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ $value['insurance_status'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: left;">
                                {{ $value['cancelled_reason'] }}
                            </td>
                            <td style="font-size: 14px; border: 0.5px solid #fff; text-align: center;">
                                {{ $value['confirmed_date']? parseToDateTh(date('d-m-Y', strtotime($value['confirmed_date']))): '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" style="font-size: 14px; border: 0.5px solid #fff; text-align: left; page-break-inside: avoid;">
                                <strong> รายละเอียดเหตุการณ์ </strong>
                                <div> {{ $value['remarks'] }} </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" style="border-left: solid #fff; border-right: solid #fff; border-top: solid #fff; border-bottom: thin solid; height: 0px !important;"> </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        @endforeach
    {{-- @endforeach --}}
</body>
</html>
