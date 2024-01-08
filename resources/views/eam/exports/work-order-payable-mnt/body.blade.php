<html>
    <head>
        <title>รายงานข้อมูลระบบเจ้าหนี้เข้าระบบบำรุงรักษาเครื่องจักร</title>
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
            .col-2  { width: 60px; }
            .col-3  { width: 60px; }
            .col-4  { width: 80px; }
            .col-5  { width: 60px; }
            .col-6  { width: 200px; }
            .col-7  { width: 200px; }
            .col-8  { width: 100px; }
            .col-9  { width: 80px; }


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
                text-align: center;
                margin-top: 15px;
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
                    <td class="col-2">วันที่ทำรายการ</td>
                    <td class="col-3">เลขที่ Invoice</td>
                    <td class="col-4">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-5">ประเภท</td>
                    <td class="col-6">รายละเอียดใบสั่งซ่อม</td>
                    <td class="col-7">รายละเอียด Invoice</td>
                    <td class="col-8">จำนวนเงิน</td>
                    <td class="col-9">นำข้อมูลเข้า Job</td>
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
                    <td>{{ $data->h1_date->format('d-M-y') }}</td>
                    <td>{{ $data->h1_invoice_number }}</td>
                    <td>{{ $data->h1_work_order }}</td>
                    <td>{{ $data->h1_meaning }}</td>
                    <td class="text-center">{{ $data->h1_descriptions }}</td>
                    <td class="text-center">{{ $data->h1_inv_description }}</td>
                    <td class="text-center">{{ number_format($data->h1_current_cost,2) }}</td>		
                    <td class="text-center">{{ $data->h1_status_flag }}</td>		
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table-footer">
            <tr>
                <td colspan="10">
                ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                </td>
            </tr>
            <tr style="text-align: right;">
                <td colspan="10">รวม {{ number_format($costs['total'],2) }} บาท</td>
            </tr>
        </table>
    </body>
</html>
