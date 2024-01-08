<html>
    <head>
        <title>รายงานส่งข้อมูลอะไหล่เข้าระบบสินค้าคงคลัง</title>
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

            .col-1  { min-width: 50px; }
            .col-2  { min-width: 90px; }
            .col-3  { min-width: 100px; }
            .col-4  { min-width: 150px; }
            .col-5  { min-width: 80px; }
            .col-6  { min-width: 70px; }
            .col-7  { min-width: 40px; }
            .col-8  { min-width: 90px; }
            .col-9  { min-width: 90px; }
            .col-10  { min-width: 90px; }
            .col-11  { min-width: 60px; }
            .col-12  { min-width: 50px; }

            .col-1  { max-width: 50px; }
            .col-2  { max-width: 90px; }
            .col-3  { max-width: 100px; }
            .col-4  { max-width: 150px; }
            .col-5  { max-width: 80px; }
            .col-6  { max-width: 70px; }
            .col-7  { max-width: 40px; }
            .col-8  { max-width: 90px; }
            .col-9  { max-width: 90px; }
            .col-10  { max-width: 90px; }
            .col-11  { max-width: 60px; }
            .col-12  { max-width: 50px; }

            td {
                word-wrap: break-word;
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
                    <td colspan="12">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1" style="text-align: center;">ลำดับที่</td>
                    <td class="col-2" style="text-align: left;">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-3" style="text-align: left;">รหัสอะไหล่</td>
                    <td class="col-4" style="text-align: left;">รายละเอียดอะไหล่</td>
                    <td class="col-5" style="text-align: left; padding-left: 10px;">คลังพัสดุ</td>
                    <td class="col-6" style="text-align: right;">จำนวน</td>
                    <td class="col-7" style="text-align: center; padding-left: 30px;">หน่วยนับ</td>
                    <td class="col-8" style="text-align: right;">ราคา/หน่วย</td>
                    <td class="col-9" style="text-align: right;">ราคารวม</td>
                    <td class="col-10" style="text-align: center;">วันที่ส่งรายการ</td>
                    <td class="col-11" style="text-align: center;">ผู้ส่งรายการ</td>
                    <td class="col-12" style="text-align: center;">เข้าคลัง</td>
                </tr>
                <tr>
                    <td colspan="12">
                    -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($workOrders ?? '' as $row => $data)
                <tr>
                    <td class="col-1" style="text-align: center;">{{ $row+1 }}</td>
                    <td class="col-2" style="text-align: left;">{{ $data->h1_wip_entity_name }}</td>
                    <td class="col-3" style="text-align: left;">{{ $data->h1_asset_id }}</td>
                    <td class="col-4" style="text-align: left;">{{ $data->h1_asset_description }}</td>
                    <td class="col-5" style="text-align: left; padding-left: 10px;">{{ $data->h1_inventory_locator }}</td>
                    <td class="col-6" style="text-align: right;">{{ $data->h1_qty }}</td>
                    <td class="col-7" style="text-align: center; padding-left: 30px;">{{ $data->h1_uom }}</td>
                    <td class="col-8" style="text-align: right;">{{ number_format($data->h1_unit_cost, 2) }}</td>
                    <td class="col-9" style="text-align: right;">{{ number_format($data->h1_actual_total_cost, 2) }}</td>
                    @if(isset($data->h1_date))
                        <td class="col-10" style="text-align: center;">{{ $data->h1_date->format('d-M-y') }}</td>
                    @else
                        <td class="col-10" style="text-align: center;"></td>
                    @endif
                    <td class="col-11" style="text-align: center;">{{ $data->h1_user_name }}</td>		
                    <td class="col-12" style="text-align: center;">{{ $data->h1_status_flag }}</td>		
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 10px;"> ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- </div>
        <div style="text-align: right">
            <label style="padding-right: 40px;"> รวม <label style="padding-left: 40px;"> {{ number_format($costs['total'], 2) }} </label></label>
        </div>
        <div style="text-align: center"> ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- </div>
        <div style="text-align: center">ผู้รับสินค้าเข้าคลัง {{ $costs['employee'] ? $costs['employee'] : ' .....................' }}</div>
    </body>
</html>
