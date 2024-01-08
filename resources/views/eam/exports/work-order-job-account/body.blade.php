<html>
    <head>
        <title>รายงานบัญชีงานระหว่างประกอบ งวดเดือน ประเภท JOB สั่งผลิต</title>
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

            .col-1  { width: 30px; }
            .col-2  { width: 60px; }
            .col-3  { width: 80px; }
            .col-4  { width: 60px; }
            .col-5  { width: 60px; }
            .col-6  { width: 80px; }
            .col-7  { width: 80px; }
            .col-8  { width: 100px; }
            .col-9  { width: 80px; }
            .col-10  { width: 80px; }
            .col-11  { width: 100px; }


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
                vertical-align: top;
                padding: 0 5px;
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
                    <td class="col-2">จำนวนสั่งทำ</td>
                    <td class="col-3">รายการ</td>
                    <td class="col-4">จัดทำให้</td>
                    <td class="col-5">งานเลขที่</td>
                    @if(isset($headers['start']))
                    <td class="col-6 text-right">ณ {{$headers['start']->startofMonth()->subMonth()->endOfMonth()->format('d-M-y')}}</td>
                    @else
                        <td class="col-6 text-right">ณ          </td>
                    @endif
                    <td class="col-7 text-right">เพิ่มเติม</td>
                    <td class="col-8 text-right">รวม</td>
                    <td class="col-9 text-right">โอนเข้าบัญชี</td>
                    @if(isset($headers['close']))
                    <td class="col-10 text-right">ณ {{$headers['close']->format('d-M-y')}}</td>
                    @else
                        <td class="col-10 text-right">ณ         </td>
                    @endif
                    <td class="col-11">หมายเหตุ</td>
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
                    <td>{{ $data->h1_order_qty_02 }}</td>
                    <td>{{ $data->h1_asset_desc_03 }}</td>
                    <td>{{ $data->h1_owning_dept_04	 }}</td>
                    <td>{{ $data->h1_wip_entity_name_05	 }}</td>
                    <td class="text-right">{{ number_format($data->h1_current_cost_06, 2) }}</td>
                    <td class="text-right">{{ number_format($data->h1_extend_cost_07, 2) }}</td>		
                    <td class="text-right">{{ number_format($data->h1_total_cost_08, 2) }}</td>		
                    <td class="text-right">{{ number_format($data->h1_remittance_cost_09, 2) }}</td>		
                    <td class="text-right">{{ number_format($data->h1_sum_actual_total_cost_10, 2) }}</td>		
                    <td class="">{{ $data->h1_remark_11 }}</td>		
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
                    <td class="col-5"> </td>
                    <td class="col-6 text-text-right">{{ number_format($costs['sum1Current'], 2) }}</td>
                    <td class="col-7 text-text-right">{{ number_format($costs['sum2Extend'], 2) }}</td>
                    <td class="col-8 text-text-right">{{ number_format($costs['sum3TotalCost'], 2) }}</td>
                    <td class="col-9 text-text-right">{{ number_format($costs['sum4Remittance'], 2) }}</td>
                    <td class="col-10 text-text-right">{{ number_format($costs['sum5ActualTotal'], 2) }}</td>
                    <td class="col-11"></td>
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
            </tbody>
        </table>
    </body>
</html>
