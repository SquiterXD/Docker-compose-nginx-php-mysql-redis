<html>
    <head>
        <title>รายงานส่งค่าแรงระหว่างประกอบเข้าบัญชีแยกประเภท</title>
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
            .col-3  { width: 80px; }
            .col-4  { width: 60px; }
            .col-5  { width: 60px; }
            .col-6  { width: 80px; }
            .col-7  { width: 80px; }
            .col-8  { width: 100px; }

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

            td {
                padding: 0 5px;
            }

            .text-right {
                text-align: right;
            }

        </style>
    </head>
    <body>
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ลำดับที่</td>
                    <td class="col-2">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-3">เลขบัญชี</td>
                    <td class="col-4">ชื่อบัญชี</td>
                    <td class="col-5 text-right">เดบิต</td>
                    <td class="col-6 text-right">เครดิต</td>
                    <td class="col-7">รหัสผู้ส่งรายการ</td>
                    <td class="col-8">ส่งรายการแล้ว[Y/N]</td>
                </tr>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($workOrders ?? '' as $row => $data)
                    <tr>
                        <td class="text-center">{{ $row+1 }}</td>
                        <td class="text-center">{{ $data->h1_wip_entity_name }}</td>
                        <td class="text-center">{{ $data->h1_account }}</td>
                        <td>{{ $data->h1_account_desc	 }}</td>
                        <td class="text-right">{{ number_format($data->h1_debit, 2) }}</td>
                        <td class="text-right">{{ number_format($data->h1_credit, 2) }}</td>
                        <td class="text-center">{{ $data->h1_user_name	 }}</td>		
                        <td class="text-center">{{ $data->h1_status_flag	 }}</td>		
                    </tr>
                @endforeach
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr style="text-align: right;">
                    <td class="col-1"> </td>
                    <td class="col-2"> </td>
                    <td class="col-3">รวม</td>
                    <td class="col-4"> </td>
                    <td class="col-5 text-right">{{ number_format($costs['sumDebit'], 2) }}</td>
                    <td class="col-6 text-right">{{ number_format($costs['sumCredit'], 2) }}</td>
                    <td class="col-7"></td>
                    <td class="col-8"></td>
                </tr>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr>
                    <td colspan="11">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr style="text-align: right;">
                    <td class="col-1"></td>
                    <td class="col-2"></td>
                    <td class="col-3">รวมค่าแรงงานระหว่างประกอบ</td>
                    <td class="col-4"></td>
                    <td class="col-5 text-right">{{ number_format($costs['totalLabor'], 2) }}</td>
                    <td class="col-6 text-right"></td>
                    <td class="col-7"></td>
                    <td class="col-8"></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
