<html>
    <head>
        <title>รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด)</title>
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

            .text-right {
                text-align: right;
            }

            .col-1  { min-width: 60px;}
            .col-2  { min-width: 100px; }
            .col-3  { min-width: 350px; }
            .col-4  { min-width: 120px; }
            .col-5  { min-width: 120px; }
            .col-6  { min-width: 120px; }
            .col-7  { min-width: 120px; }
            .col-8  { min-width: 70px; }


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
                    <td colspan="8">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ลำดับที่</td>
                    <td class="col-2">งานเลขที่</td>
                    <td class="col-3">รายละเอียด</td>
                    <td class="col-4">รวมค่าแรง</td>
                    <td class="col-5">รวมค่าอะไหล่</td>
                    <td class="col-6">รวมจัดซื้อ/จัดจ้าง</td>
                    <td class="col-7">รวมทั้งสิ้น</td>
                    <td class="col-8">บันทึก GL</td>
                </tr>
                <tr>
                    <td colspan="8">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($data ?? '' as $row => $dataRow)
                <tr>
                    <td class="text-center">{{ $row+1 }}</td>
                    <td>{{ $dataRow->job_no }}</td>
                    <td>{{ $dataRow->job_description }}</td>
                    <td class="text-right">{{ number_format($dataRow->actual_labor_cost, 2) }}</td>
                    <td class="text-right">{{ number_format($dataRow->actual_material_cost, 2) }}</td>
                    <td class="text-right">{{ number_format($dataRow->direct_items_cost, 2) }}</td>
                    <td class="text-right">{{ number_format($dataRow->total, 2) }}</td>
                    <td class="text-center">{{ Str::upper($dataRow->gl_transfer_status_code) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table-content" style="margin-top: 50px;">
            <thead>
                <tr>
                    <td colspan="8">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">รวม</td>
                    <td class="col-2"></td>
                    <td class="col-3"></td>
                    <td class="col-4 text-right">{{ number_format($costs['labor'], 2) }}</td>
                    <td class="col-5 text-right">{{ number_format($costs['material'], 2) }}</td>
                    <td class="col-6 text-right">{{ number_format($costs['direct_items'], 2) }}</td>
                    <td class="col-7 text-right">{{ number_format($costs['total'], 2) }}</td>
                    <td class="col-8"></td>
                </tr>
                <tr>
                    <td colspan="8">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
        </table>
    </body>
</html>
