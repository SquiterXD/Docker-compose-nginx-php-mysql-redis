<html>
    <head>
        <title>รายงานสรุปค่าใช้จ่ายของใบสั่งซ่อม</title>
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


            .col-1  { min-width: 40px; }
            .col-2  { min-width: 100px; }
            .col-3  { min-width: 70px; }
            .col-4  { min-width: 110px; }
            .col-5  { min-width: 70px; }
            .col-6  { min-width: 60px; }
            .col-7  { min-width: 100px; }
            .col-8  { min-width: 120px; }
            .col-9  { min-width: 70px; }
            .col-10  { min-width: 70px; }
            .col-11  { min-width: 40px; }
            .col-12  { min-width: 40px; }
            .col-13  { min-width: 40px; }
            .col-14  { min-width: 40px; }
            .col-15  { min-width: 40px; }
            .col-16  { min-width: 40px; }
            .col-17  { min-width: 40px; }
            .col-18  { min-width: 40px; }
            .col-19  { min-width: 40px; }

            .col-1  { max-width: 40px; }
            .col-2  { max-width: 100px; }
            .col-3  { max-width: 70px; }
            .col-4  { max-width: 110px; }
            .col-5  { max-width: 70px; }
            .col-6  { max-width: 60px; }
            .col-7  { max-width: 100px; }
            .col-8  { max-width: 120px; }
            .col-9  { max-width: 70px; }
            .col-10  { max-width: 70px; }
            .col-11  { max-width: 60px; }
            .col-12  { max-width: 60px; }
            .col-13  { max-width: 60px; }
            .col-14  { max-width: 60px; }
            .col-15  { max-width: 60px; }
            .col-16  { max-width: 60px; }
            .col-17  { max-width: 60px; }
            .col-18  { max-width: 60px; }
            .col-19  { max-width: 60px; }


            td {
                word-wrap: break-word;
                padding: 0 2px;
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
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="19">
                    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td rowspan="3" class="col-1">ลำดับที่</td>
                    <td rowspan="3" class="col-2">ใบสั่งซ่อม</td>
                    <td rowspan="3" class="col-3">เลขที่ใบขอซ่อม</td>
                    <td rowspan="3" class="col-4">Asset</td>
                    <td rowspan="3" class="col-5">Asset Activity</td>
                    <td rowspan="3" class="col-6">Job Type</td>
                    <td rowspan="3" class="col-7">หน่วยงานที่ซ่อม</td>
                    <td rowspan="3" class="col-8">งบประมาณ</td>
                    <td rowspan="3" class="col-9">ประมาณการวันที่</td>
                    <td rowspan="3" class="col-10">วันที่เริ่มซ่อม ถึงวันที่ซ่อมเสร็จ</td>
                    <td colspan="3">ค่าใช้จ่ายอะไหล่</td>
                    <td colspan="3">ค่าใช้จ่ายแรงงาน</td>
                    <td colspan="3">ค่าใช้จ่ายรวม</td>
                </tr>
                <tr class="table-header">
                    <td colspan="3">----------------------------------</td>
                    <td colspan="3">----------------------------------</td>
                    <td colspan="3">----------------------------------</td>
                </tr>
                <tr class="table-header">
                    <td class="col-11">ประมาณ</td>
                    <td class="col-12">ใช้จริง</td>
                    <td class="col-13">ผลต่าง</td>
                    <td class="col-14">ประมาณ</td>
                    <td class="col-15">ใช้จริง</td>
                    <td class="col-16">ผลต่าง</td>
                    <td class="col-17">ประมาณ</td>
                    <td class="col-18">ใช้จริง</td>
                    <td class="col-19">ผลต่าง </td>
                </tr>
                <tr>
                    <td colspan="19">
                    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr style="text-align: left;">
                    <td colspan="19">       หน่วยงานเจ้าของทรัพย์สิน  : {{$department->h1_owning_depart_desc}}</td>
                </tr>
                <tr>
                    <td colspan="9">
                    ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($department->items ?? '' as $row => $data)
                <tr>
                    <td class="text-center col-1">{{ $row+1 }}</td>
                    <td class="col-2">{{$data->h1_wip_entity_name }}</td>
                    <td class="text-center col-3">{{ $data->work_request_number }}</td>
                    <td class="col-4">{{$data->h1_asset_number}}</td>
                    <td class="col-5">{{ $data->h1_asset_activity }}</td>
                    <td class="text-center col-6">{{ $data->h1_work_order_type_disp }}</td>
                    <td class="col-7">{{ $data->h1_owning_department_code	 }}</td>		
                    <td class="col-8">{{ $data->h1_class_description }}</td>	
                    @if(isset($data->h1_scheduled_start_date) and isset($data->h1_scheduled_completion_date))
                        <td class="text-center col-9">{{ $data->h1_scheduled_start_date->format('d-M-y') }} {{ $data->h1_scheduled_completion_date->format('d-M-y') }}</td>		
                    @else
                        <td class="text-center col-9"></td>		
                    @endif
                    @if(isset($data->h1_actual_start_date ) and isset($data->h1_date_completed))
                        <td class="text-center col-10">{{ $data->h1_actual_start_date->format('d-M-y')  }} {{ $data->h1_date_completed->format('d-M-y') }}</td>		
                    @else
                        <td class="text-center col-10"></td>		
                    @endif
                    <td class="text-center col-11">{{ number_format($data->h1_estimated_material_cost,2) }}</td>		
                    <td class="text-center col-12">{{ number_format($data->h1_actual_material_cost,2) }}</td>		
                    <td class="text-center col-13">{{ number_format($data->h1_variance_material_cost,2) }}</td>		
                    <td class="text-center col-14">{{ number_format($data->h1_estimated_labor_cost,2) }}</td>		
                    <td class="text-center col-15">{{ number_format($data->h1_actual_labor_cost,2) }}</td>		
                    <td class="text-center col-16">{{ number_format($data->h1_variance_labor_cost,2) }}</td>		
                    <td class="text-center col-17">{{ number_format($data->h1_estimated_total_cost,2) }}</td>		
                    <td class="text-center col-18">{{ number_format($data->h1_sum_actual_total_cost,2) }}</td>
                    		
                    <td class="text-center col-19">{{ number_format($data->h1_variance_total_cost,2) }}</td>		
                </tr>
                @endforeach
            </tbody>
        </table>
        <table style="text-align: right; margin-left: auto; margin-right: -10px;" class="table-footer">
            <tr>
                <td ></td>
                <td >ประมาณ</td>
                <td >ใช้จริง</td>
                <td >ผลต่าง</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายอะไหล่ตามหน่วยงาน</td>
                <td style="width:70px;">{{ number_format($department->sumDepMaterial['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepMaterial['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepMaterial['variance'],2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายแรงงานตามหน่วยงาน</td>
                <td style="width:70px;">{{ number_format($department->sumDepLabor['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepLabor['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepLabor['variance'],2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายรวมตามหน่วยงาน</td>
                <td style="width:70px;">{{ number_format($department->sumDepTotal['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepTotal['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($department->sumDepTotal['variance'],2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; padding-top:10px;" >
                ---------------------------------------------------------------------------------------------------------------------
                </td>
            </tr>
        </table>
        @endforeach
        <table style="text-align: right; margin-left: auto; margin-right: -10px;" class="table-footer">
            <tr>
                <td ></td>
                <td >ประมาณ</td>
                <td >ใช้จริง</td>
                <td >ผลต่าง</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายอะไหล่ </td>
                <td style="width:70px;">{{ number_format($costs['sumAllMaterial']['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllMaterial']['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllMaterial']['variance'],2) }}</td>                
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายแรงงาน</td>
                <td style="width:70px;">{{ number_format($costs['sumAllLabor']['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllLabor']['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllLabor']['variance'],2) }}</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 150px;">รวมค่าใช้จ่ายรวม</td>
                <td style="width:70px;">{{ number_format($costs['sumAllTotal']['estimated'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllTotal']['actual'],2) }}</td>
                <td style="width:70px;">{{ number_format($costs['sumAllTotal']['variance'],2) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; padding-top:10px;" ></td>
            </tr>
        </table>
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </body>
</html>
