<html>
    <head>
        <title>รายงานสรุปใบรับงานประจำเดือน</title>
        <style type="text/css">
            @font-face{
                font-family: 'SarabunSans';
                font-style: 'normal';
                src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
            }

            body {
                font-family: 'SarabunSans';
                font-size: 10px;
            }

            .table-content {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }

            .table-header {
                text-align: center;
            }

            .table-content tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .text-center {
                text-align: center;
            }

            .col-1  { width: 30px; }
            .col-2  { width: 80px; }
            .col-3  { width: 80px; }
            .col-4  { width: 200px; }
            .col-5  { width: 200px; }
            .col-6  { width: 60px; }
            .col-7  { width: 60px; }
            .col-8  { width: 60px; }
            .col-9  { width: 200px; }
            .col-10  { width: 200px; }

            td {
                padding: 0 5px;
            }

            .break-text {
                word-wrap: break-word;
                max-width: 200px;
            }

            .table-main {
                border-collapse: collapse;
                font-size: 10px;
                page-break-inside:auto;
            }
            .table-main thead tr td {
                text-align: center;
            }
            .table-main tr {
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .table-footer {
                margin-top: 15px;
                margin-left: auto;
                margin-right: auto;
                font-family: 'SarabunSans';
                font-size: 10px;
            }

        </style>
    </head>
    <body>
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="10">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ลำดับที่</td>
                    <td class="col-2">เลขที่ใบสั่งงาน</td>
                    <td class="col-3">เลขที่ใบรับงาน</td>
                    <td class="col-4">รหัสสินทรัพย์/คำอธิบาย</td>
                    <td class="col-5">รายละเอียดงานซ่อม</td>
                    <!-- <td class="col-7">วันที่รับงาน</td> -->
                    <td class="col-8">วันที่เริ่มซ่อม</td>
                    <td class="col-9">หน่วยงานแจ้งงานซ่อม</td>
                    <td class="col-10">หน่วยงานรับงานซ่อม</td>
                    <td class="col-6">สถานะ</td>
                </tr>
                <tr>
                    <td colspan="10">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($workOrders ?? '' as $row => $data)
                <tr>
                    <td class="text-center">{{ $row+1 }}</td>
                    <td>{{ $data->work_request_number }}</td>
                    <td>{{ $data->wip_entity_name }}</td>
                    <td>{{ $data->asset_number }}: {{$data->asset_desc}}</td>
                    <td class="break-text">{{ $data->description }}</td>
                    <!-- <td class="text-center">{{ Str::upper($data->creation_date->format('d-M-y')) }}</td> -->
                    <td class="text-center">{{ Str::upper($data->scheduled_start_date->format('d-M-y')) }}</td>
                    <td>
                        @if ($data->inform_dept_code)
                            {{ $data->inform_dept_code }}: {{ $data->inform_dept_desc }}
                        @endif
                    </td>
                    <td>
                        @if ($data->owning_department_code)
                            {{ $data->owning_department_code }}: {{ $data->owning_department_desc }}
                        @endif
                    </td>
                    <td class="text-center">{{ $data->status_desc }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table-footer">
                <tr><td colspan="3" style="text-align: center;">รายงานสรุปใบรับงานประจำเดือน</td></tr>
                <tr>
                    <td style="width: 100px;">ยอดรวมค่าอะไหล่</td>
                    <td style="width: 100px; text-align: right;">{{ number_format($costs['material'],2) }}</td>
                    <td style="width: 30px; text-align: left;">บาท</td>
                </tr>
                <tr>
                    <td style="width: 100px;">ยอดรวมค่าแรง</td>
                    <td style="width: 100px; text-align: right">{{ number_format($costs['labor'],2) }}</td>
                    <td style="width: 30px; text-align: left;">บาท</td>
                </tr>
                <tr>
                    <td style="width: 100px;">ยอดรวมค่าใช้จ่าย (Complete)</td>
                    <td style="width: 100px; text-align: right">{{ number_format($costs['total'],2) }}</td>
                    <td style="width: 30px; text-align: left;">บาท</td>
                </tr>
                <tr>
                    <td style="width: 100px;">จำนวนงานที่ยังไม่ Close</td>
                    <td style="width: 100px; text-align: right">{{ number_format($costs['not_closed'],2) }}</td>
                    <td style="width: 30px; text-align: left;">งาน</td>
                </tr>
        </table>
    </body>
</html>
