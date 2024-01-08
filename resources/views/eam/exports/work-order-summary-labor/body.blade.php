<html>
    <head>
        <title>รายงานสรุปการบันทึกค่าแรงงานซ่อม</title>
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

            .col-1  { width: 80px; }
            .col-2  { width: 60px; }
            .col-3  { width: 130px; }
            .col-4  { width: 140px; }
            .col-5  { width: 80px; }
            .col-6  { width: 70px; }
            .col-7  { width: 100px; }
            .col-8  { width: 130px; }
            .col-9  { width: 80px; }
            .col-10  { width: 80px; }
            .col-11  { width: 80px; }


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

            .break-word {
                max-width: 200px;
                word-wrap: break-word;
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
                    <td class="col-1">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-2">ประเภท</td>
                    <td class="col-3">รายละเอียด</td>
                    <td class="col-4">Asset Number</td>
                    <td class="col-5">รหัสกลุ่มช่าง</td>
                    <td class="col-6">ช่างปฎิบัติงาน</td>
                    <td class="col-7">วันที่ทำงาน</td>
                    <td class="col-8">ช่วงเวลาที่ทำงาน</td>
                    <td class="col-9">จำนวน(ชม.)</td>
                    <td class="col-10">ค่าแรง</td>
                    <td class="col-11">ส่งเข้าระบบ EAM/ส่งเข้าระบบบัญชี</td>
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
                    <td>{{ $data->wip_entity_name }}</td>
                    <td class="text-center">{{ $data->meaning }}</td>
                    <td class="break-word">{{ $data->wip_entity_desc }}</td>
                    <td>{{ $data->asset_number }}</td>
                    <td>{{ $data->resource_code }}</td>
                    <td>{{ $data->employee }}</td>
                    @if(isset($data->transaction_date))
                        <td class="text-center">{{ $data->transaction_date->format('d-M-y') }}</td>
                    @else
                        <td class="text-center"></td>
                    @endif
                    <td>{{ $data->reason_name }}</td>		
                    <td class="text-center">{{ $data->working_hour }}</td>		
                    <td class="text-center">{{ number_format($data->wage_hour, 2) }}</td>		
                    <td class="text-center">{{ $data->transfer_flag }}/{{ $data->flag }}</td>		
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table-footer">
            <tr>
                <td colspan="11">
                ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                </td>
            </tr>
            <tr style="text-align: right;">
                <td style="width: 50%;" colspan="6"></td>
                <td colspan="5">
                --------------------------------------------------------------------
                </td>
            </tr>
            <tr>
                <td style="width: 90%;" colspan="7"></td>
                <td style="width: 5%; text-align: left;" >รวม     </td>
                <td style="width: 5%; text-align: right;" >  {{ number_format($costs['total'], 2) }}</td>
            </tr>
            <tr style="text-align: right;">
                <td style="width: 50%;" colspan="6"></td>
                <td colspan="5">
                ======================================
                </td>
            </tr>            
        </table>
    </body>
</html>
