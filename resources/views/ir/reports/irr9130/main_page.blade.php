<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <title> รายงานการแจ้งเหตุเคลมประกันภัย </title>
    @include('ir.reports.irr9130._style')
    {{-- <style type="text/css">
        @media print {
            @page {
                size: letter;
                margin: 5px;
            }
        }

        * {
            font-family: Helvetica, Arial, sans-serif;
            font-size: small;
            font-size: 10px !important;
        }

        caption {
            background-color: #F7F7F7;
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }

        .bordered td {
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }

        table {
            border-collapse: collapse;
        }
    </style> --}}
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" style="width: 100%; page-break-before: always;">
                        <thead>
                            <tr>
                                <th width="7.5%" class="report_header" style="border: 1px solid #FFF;">
                                    เลขที่เอกสาร
                                </th>
                                <th width="10%" class="report_header" style="border: 1px solid #FFF;">
                                    หัวข้อการเกิดเหตุ
                                </th>
                                <th width="7%" class="report_header" style="border: 1px solid #FFF;">
                                    วัน-เวลา<br>เกิดเหตุ
                                </th>
                                <th width="12%" class="report_header" style="border: 1px solid #FFF;">
                                    สถานที่เกิดเหตุ
                                </th>
                                <th width="7%" class="report_header" style="border: 1px solid #FFF;">
                                    จำนวนเงิน<br>เรียกชดใช้โดยประมาณ
                                </th>
                                <th width="8%" class="report_header" style="border: 1px solid #FFF;">
                                    จำนวนเงิน<br>เรียกชดใช้รวม
                                </th>
                                <th width="10%" class="report_header" style="border: 1px solid #FFF;">
                                    จำนวนเงิน<br>เรียกเก็บ(ตั้งหนี้)
                                </th>
                                <th width="8%" class="report_header" style="border: 1px solid #FFF;">
                                    หน่วยงาน<br>ผู้แจ้งเหตุ
                                </th>
                                <th width="8%" class="report_header" style="border: 1px solid #FFF;">
                                    ผู้แจ้งเหตุ
                                </th>
                                <th width="8%" class="report_header" style="border: 1px solid #FFF;">
                                    เบอร์โทร<br>ผู้แจ้งเหตุ
                                </th>
                                <th width="7%" class="report_header" style="border: 1px solid #FFF;">
                                    สถานะปัจจุบัน
                                </th>
                                <th width="8%" class="report_header" style="border: 1px solid #FFF;">
                                    วันที่แจ้ง<br>บริษัทประกันภัย
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claims as $claim)
                                {{-- <tr style="page-break-before: always; height: 10px;"> --}}
                                    <tr>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $claim->document_number }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: left;">
                                            {{ $claim->claim_title }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ parseToDateTh(date('d-m-Y', strtotime($claim->accident_date))) }} {{ date('H:i', strtotime($claim->accident_time)) }} น.
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: left;">
                                            {{ $claim->location_name }}
                                        </td>
                                        <td class="report_qty" style="font-size: 14px; border: 1px solid #fff;">
                                            {{ number_format($claim->claim_amount, 2) }}
                                        </td>
                                        <td class="report_qty" style="font-size: 14px; border: 1px solid #fff;">
                                            {{ number_format($claim->total_claim_amount, 2) }}
                                        </td>
                                        <td class="report_qty" style="font-size: 14px; border: 1px solid #fff;">
                                            {{ $claim->insurance_status == 'NEW' || $claim->insurance_status == 'แจ้งบริษัทประกันแล้ว'
                                                ? number_format(0, 2)
                                                : number_format($claim->ar_invoice_amount, 2)
                                            }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: left;">
                                            {{ $claim->department_name }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $claim->requestor_name }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $claim->requestor_tel }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $claim->insurance_status }}
                                        </td>
                                        <td style="font-size: 14px; border: 1px solid #fff; text-align: center;">
                                            {{ $claim->confirmed_date? parseToDateTh(date('d-m-Y', strtotime($claim->confirmed_date))): '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="font-size: 14px; text-align: left; border-left: solid #fff; border-right: solid #fff; border-top: solid #fff; border-bottom: 1px solid #ddd;">
                                            <strong> รายละเอียดเหตุการณ์ </strong>
                                            <div> {{ $claim->remarks }} </div>
                                        </td>
                                    </tr>
                                    @if ($claim->cancelled_reason)
                                        <tr>
                                            <td colspan="12" style="font-size: 14px; text-align: left; border-left: solid #fff; border-right: solid #fff; border-top: solid #fff; border-bottom: 1px solid #ddd;">
                                                <strong> เหตุผลในการยกเลิก </strong>
                                                <div> {{ $claim->cancelled_reason }} </div>
                                            </td>
                                        </tr>
                                    @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
