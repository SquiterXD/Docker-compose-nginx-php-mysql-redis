<html>
    <head>
        <title>รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย</title>
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
                width: 100%;
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

            .col-1  { min-width: 60px; }
            .col-2  { min-width: 160px; }
            .col-3  { min-width: 160px; padding-left: 10px; }
            .col-4  { min-width: 160px; padding-left: 10px; }
            .col-5  { min-width: 100px; }
            .col-6  { min-width: 100px; }
            .col-7  { min-width: 100px; }
            .col-8  { min-width: 80px; } 

            .col-1  { max-width: 60px; }
            .col-2  { max-width: 160px; }
            .col-3  { max-width: 160px; }
            .col-4  { max-width: 160px; }
            .col-5  { max-width: 100px; }
            .col-6  { max-width: 100px; }
            .col-7  { max-width: 100px; }
            .col-8  { max-width: 100px; } 

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
                margin-top: 15px;
                margin-left: auto;
                margin-right: auto;
                font-family: 'SarabunSans';
                font-size: 10px;
            }

        </style>
    </head>
    <body>
        @php
            $departmentCount = 0;
        @endphp
        <table class="table-content">
            <thead>
                <tr>
                    <td colspan="8" style="overflow: hidden;">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1"></td>
                    <td class="col-2">เลขที่ใบสั่งซ่อม</td>
                    <td class="col-3">รหัสสินทรัพย์ถาวร</td>
                    <td class="col-4">ประเภทใบสั่งซ่อม</td>
                    <td class="col-5">ประมาณการวันที่ซ่อม</td>
                    <td class="col-6">วันที่เริ่มจริง</td>
                    <td class="col-7">ค่าใช้จ่ายอะไหล่</td>
                    <td class="col-8"></td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ลำดับที่</td>
                    <td class="col-2" style="overflow: hidden;"> ------------------------------------------- </td>
                    <td class="col-3" style="overflow: hidden;"> ------------------------------------------- </td>
                    <td class="col-4" style="overflow: hidden;"> ------------------------------------------- </td>
                    <td class="col-5" style="overflow: hidden;"> ------------------------------- </td>
                    <td class="col-6" style="overflow: hidden;"> ---------------------------- </td>
                    <td class="col-7" style="overflow: hidden;"> ----------------------------- </td>
                    <td class="col-8">ค่าใช้จ่ายรวม</td>
                </tr>
                <tr class="table-header">
                    <td class="col-1"></td>
                    <td class="col-2">เลขที่ใบขอซ่อม</td>
                    <td class="col-3">รายการ</td>
                    <td class="col-4">หน่วยงานที่ซ่อม</td>
                    <td class="col-5">ประมาณการวันที่ซ่อมเสร็จ</td>
                    <td class="col-6">วันที่เสร็จจริง</td>
                    <td class="col-7">ค่าใช้จ่ายแรงงาน</td>
                    <td class="col-8"></td>
                </tr>
                <tr>
                    <td colspan="8" style="overflow: hidden;">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($costs['departments'] ?? '' as $department => $dataCost)
                @php
                    $departmentCount += 1;
                    $orderNo = 0;
                @endphp
                <tr>
                    <td colspan="8">หน่วยงานเจ้าของทรัพย์สิน : {{ $department }}</td>
                </tr>
                <tr>
                    <td colspan="8" style="overflow: hidden;">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                @foreach ($data as $dataItem)
                    @php
                        $dateService = new \Carbon\Carbon();
                        $dataItem->h1_scheduled_start_date = $dateService::createFromFormat('Y-m-d H:i:s',  $dataItem->h1_scheduled_start_date);
                        $dataItem->h1_actual_start_date = $dateService::createFromFormat('Y-m-d H:i:s',  $dataItem->h1_actual_start_date);
                        $dataItem->h1_scheduled_completion_date = $dateService::createFromFormat('Y-m-d H:i:s',  $dataItem->h1_scheduled_completion_date);
                        $dataItem->h1_date_completed = $dateService::createFromFormat('Y-m-d H:i:s',  $dataItem->h1_date_completed);
                    @endphp
                    @if ($dataItem->h1_owning_department_desc == $department)
                        <tr style="vertical-align: text-top;">
                            <td class="col-1">{{ $orderNo+=1 }}</td>
                            <td class="col-2">{{ $dataItem->h1_wip_entity_name }}</td>
                            <td class="col-3">{{ $dataItem->h1_asset_number }}</td>
                            <td class="text-center col-4">{{ $dataItem->h1_work_order_type_disp }}</td>
                            <td class="text-center col-5">{{ Str::upper($dataItem->h1_scheduled_start_date->format('d-M-y H:i:s')) }} </td>
                            <td class="text-center col-6">{{ Str::upper($dataItem->h1_actual_start_date->format('d-M-y H:i:s')) }}</td>
                            <td class="text-right col-7" style="padding-right: 20px;">{{ number_format($dataItem->h1_actual_material_cost, 2) }}</td>
                            <td class="text-right col-8" style="padding-right: 20px;">{{ number_format($dataItem->h1_sum_actual_total_cost, 2) }} </td>
                        </tr>
                        <tr style="vertical-align: text-top;">
                            <td class="col-1"></td>
                            <td class="col-2">{{ $dataItem->work_request_number }}</td>
                            <td class="col-3">{{ $dataItem->h1_asset_description }}</td>
                            <td class="col-4">{{ $dataItem->h1_owning_department_code }}</td>
                            <td class="text-center col-5">{{ Str::upper($dataItem->h1_scheduled_completion_date->format('d-M-y H:i:s')) }}</td>
                            <td class="text-center col-6">{{ Str::upper($dataItem->h1_date_completed->format('d-M-y H:i:s')) }}</td>
                            <td class="text-right col-7" style="padding-right: 20px;">{{ number_format($dataItem->h1_actual_labor_cost, 2) }}</td>
                            <td class="col-8"></td>
                        </tr>
                        
                    @endif
                @endforeach
                <tr>
                    <td colspan="8" style="padding-top: 15px">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">รวมค่าใช้จ่ายอะไหล่ตามหน่วยงาน </td>
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($dataCost['material'], 2) }}</td>
                    <td class="text-right" style="padding-right: 20px;">รวมตามหน่วยงาน </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">รวมค่าใช้จ่ายแรงงานตามหน่วยงาน 
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($dataCost['labor'], 2) }}</td>
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($dataCost['total'], 2) }}</td>
                </tr>
                @if (count($costs['departments']) > $departmentCount)
                    <tr>
                        <td colspan="8" style="overflow: hidden;">
                        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="4" style="
                    white-space: nowrap; overflow: hidden;"> --------------------------------------------------------------------------------------------------------------------------------------------------------- 
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">รวมค่าใช้จ่ายอะไหล่ทุกหน่วยงาน </td>
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($costs['material'], 2) }}</td>
                    <td class="text-right" style="padding-right: 20px;">รวมทุกหน่วยงาน </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">รวมค่าใช้จ่ายแรงงานทุกหน่วยงาน 
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($costs['labor'], 2) }}</td>
                    <td class="text-right" style="padding-right: 20px;">{{ number_format($costs['total'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="8" style="overflow: hidden;">
                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
