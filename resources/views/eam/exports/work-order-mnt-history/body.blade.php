<html>
    <head>
        <title>รายงานประวัติการซ่อมบำรุงเครื่องจักร</title>
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

            .col-1  { min-width: 70px;}
            .col-2  { min-width: 130px; text-align: left; padding-left: 10px;}
            .col-3  { min-width: 110px; text-align: left; padding-left: 10px;}
            .col-4  { min-width: 100px; text-align: left; padding-left: 10px;}
            .col-5  { min-width: 80px; }
            .col-6  { min-width: 80px; }
            .col-7  { min-width: 200px; text-align: left;}
            .col-8  { min-width: 80px; }
            .col-9  { min-width: 80px; }
            .col-10  { min-width: 80px; }
            .col-11  { min-width: 80px; }
            .col-12  { min-width: 80px; }
            .col-13  { min-width: 80px; }
            .col-14  { min-width: 80px; }
            .col-15  { min-width: 80px; }

            .col-1  { max-width: 70px; }
            .col-2  { max-width: 130px; }
            .col-3  { max-width: 110px; }
            .col-4  { max-width: 100px; }
            .col-5  { max-width: 80px; }
            .col-6  { max-width: 80px; }
            .col-7  { max-width: 200px; }
            .col-8  { max-width: 80px; }
            .col-9  { max-width: 80px; }
            .col-10  { max-width: 80px; }
            .col-11  { max-width: 80px; }
            .col-12  { max-width: 80px; }
            .col-13  { max-width: 80px; }
            .col-14  { max-width: 80px; }
            .col-15  { max-width: 80px; }

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
        @foreach($departments ?? '' as $row => $department)
            @if($row==0)
                --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            @endif
        <div style="margin: 3px;">หน่วยงานเจ้าของทรัพย์สิน  : {{$department->owning_department_code}} {{$department->owning_department_code ? ' : ' : ''}} {{$department->owning_department_desc}}</div>
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="15">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ประเภทการซ่อม</td>
                    <td class="col-2">รหัสสินทรัพย์</td>
                    <td class="col-3">Asset Serial No.</td>
                    <td class="col-4">สาเหตุการซ่อม</td>
                    <td class="col-5">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-6">เลขที่ใบขอซ่อม</td>
                    <td class="col-7">รายละเอียด</td>
                    <td class="col-8">สถานะของใบสั่ง</td>
                    <td class="col-9">ระยะเวลาที่ใช้</td>
                    <td class="col-10">charge time</td>
                    <td class="col-11">ค่าใช้จ่ายอะไหล่</td>
                    <td class="col-12">ค่าใช้จ่ายแรงงาน</td>
                    <td class="col-13">ค่าใช้จ่ายรวม</td>
                    <td class="col-14">วันที่รับงาน</td>
                    <td class="col-15">วันที่ Completed</td>
                </tr>
                <tr>
                    <td colspan="15">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($department->items ?? '' as $row => $data)
                <tr>
                    <td class="text-center col-1">{{$data->work_order_type_desc}}</td>
                    <td class="col-2">{{$data->wasset_number}} {{$data->wasset_number ? ' : ' : ''}} {{$data->wasset_desc}}</td>
                    <td class="col-3">{{ $data->serial_number }}</td>
                    <td class="col-4">{{$data->item_number}} {{$data->item_number ? ' : ' : ''}} {{$data->item_description}}</td>
                    <td class="text-center col-5">{{ $data->wip_entity_name }}</td>
                    <td class="text-center col-6">{{ $data->work_request_number }}</td>
                    <td class="col-7">{{ $data->description }}</td>		
                    <td class="text-center col-8">{{ $data->status_desc }}</td>		
                    <td class="text-center col-9">{{ $data->actual_duration }}</td>		
                    <td class="text-center col-10">{{ $data->charge_time }}</td>		
                    <td class="text-center col-11">{{ $data->actual_material_cost }}</td>		
                    <td class="text-center col-12">{{ $data->actual_labor_cost }}</td>		
                    <td class="text-center col-13">{{ $data->actual_total_cost }}</td>		
                    @if(isset($data->creation_date))
                        <td class="text-center col-14">{{ $data->creation_date->format('d-M-y') }}</td>
                    @else
                        <td class="text-center col-14"></td>
                    @endif
                    @if(isset($data->date_completed))
                        <td class="text-center col-15">{{ $data->date_completed->format('d-M-y') }}</td>
                    @else
                        <td class="text-center col-15"></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        <table class="table-footer" style="margin-left: auto;">
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายอะไหล่ตามหน่วยงาน</td>
                <td style="text-align: right; width: 150px;">{{ $department->sumDepMaterial }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายแรงงานตามหน่วยงาน</td>
                <td style="text-align: right; width: 150px;">{{ $department->sumDepLabor }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายตามหน่วยงาน</td>
                <td style="text-align: right; width: 150px;">{{ $department->sumDepTotal }}</td>
                <td  style="padding-bottom:20px;"></td>
            </tr>
        </table>
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        @endforeach
        <table class="table-footer" style="margin-left: auto;">
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายอะไหล่</td>
                <td style="text-align: right; width: 150px;">{{ $costs['sumAllMaterial'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายแรงงาน</td>
                <td style="text-align: right; width: 150px;"> {{ $costs['sumAllLabor'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายรวม</td>
                <td style="text-align: right; width: 150px;">{{ $costs['sumAllTotal'] }}</td>
                <td  style="padding-bottom:20px;"></td>
            </tr>
        </table>
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </body>
</html>
