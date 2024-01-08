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
                vertical-align: text-top;
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

            .col-1  { min-width: 30px; max-width: 30px; }
            .col-2  { min-width: 150px; max-width: 150px; }
            .col-3  { min-width: 80px; max-width: 80px; }
            .col-4  { min-width: 80px; max-width: 80px; }
            .col-5  { min-width: 150px; max-width: 150px; }
            .col-6  { min-width: 60px; max-width: 60px; }
            .col-7  { min-width: 100px; max-width: 100px; }
            .col-8  { min-width: 100px; max-width: 100px; } 
            .col-9  { min-width: 60px; max-width: 60px; }
            .col-10  { min-width: 100px; max-width: 100px; } 
            .col-11  { min-width: 50px; max-width: 50px; }
            .col-12  { min-width: 50px; max-width: 50px; } 
            .col-13  { min-width: 50px; max-width: 50px; }
            .col-14  { min-width: 50px; max-width: 50px; } 
            .col-15  { min-width: 50px; max-width: 50px; }
            .col-16  { min-width: 50px; max-width: 50px; } 
            .col-17  { min-width: 50px; max-width: 50px; }
            .col-18  { min-width: 50px; max-width: 50px; } 
            .col-19  { min-width: 100px; max-width: 100px; } 
            .col-20  { min-width: 100px; max-width: 100px; } 
            .col-21  { min-width: 100px; max-width: 100px; } 
            .col-22  { min-width: 100px; max-width: 100px; } 

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

            td {
                padding: 0 5px;
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
                    <td colspan="18" style="white-space: nowrap; overflow: hidden;">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1">ลำดับ<br>ที่</td>
                    <td class="col-2">เลขที่<br>ใบสั่งซ่อม</td>
                    <td class="col-3">เลขที่<br>ใบขอซ่อม</td>
                    <td class="col-4">รหัส<br>สินทรัพย์</td>
                    <td class="col-5">รายการ</td>
                    <td class="col-6">ประเภท<br>ใบสั่งซ่อม</td>
                    <td class="col-7">หน่วยงาน<br>ที่ซ่อม</td>
                    <td class="col-8">เลขที่ใบขอ<br>อนุมัติ</td>
                    <td class="col-9">เลขที่<br>ใบเบิก</td>
                    <td class="col-10">รายการสั่งซื้อ</td>
                    <td class="col-19" colspan="2" style="white-space: nowrap; overflow: hidden;">สั่งซื้อ<br> -------------------- </td>
                    <td class="col-20" colspan="2" style="white-space: nowrap; overflow: hidden;">รับ<br> -------------------- </td>
                    <td class="col-21" colspan="2">รับ<br> -------------------- </td>
                    <td class="col-22" colspan="2">จ่าย<br> -------------------- </td>
                </tr>
                <tr class="table-header">
                    <td class="col-1"></td>
                    <td class="col-2"></td>
                    <td class="col-3"></td>
                    <td class="col-4">ถาวร<br>ซ่อมบำรุง</td>
                    <td class="col-5"></td>
                    <td class="col-6"></td>
                    <td class="col-7"></td>
                    <td class="col-8">หลักการใช้<br>งบประมาณ/</td>
                    <td class="col-9"></td>
                    <td class="col-10"></td>
                    <td class="col-11">ปริมาณ</td>
                    <td class="col-12">มูลค่า</td>
                    <td class="col-13">ปริมาณ</td>
                    <td class="col-14">มูลค่า</td>
                    <td class="col-15">ปริมาณ</td>
                    <td class="col-16">มูลค่า</td>
                    <td class="col-17">ปริมาณ</td>
                    <td class="col-18">มูลค่า</td>
                </tr>
                <tr class="table-header">
                    <td class="col-1"></td>
                    <td class="col-2"></td>
                    <td class="col-3"></td>
                    <td class="col-4"></td>
                    <td class="col-5"></td>
                    <td class="col-6"></td>
                    <td class="col-7"></td>
                    <td class="col-8">เลขที่ใบสั่ง</td>
                    <td class="col-9"></td>
                    <td class="col-10"></td>
                    <td class="col-11"></td>
                    <td class="col-12"></td>
                    <td class="col-13"></td>
                    <td class="col-14"></td>
                    <td class="col-15"></td>
                    <td class="col-16"></td>
                    <td class="col-17"></td>
                    <td class="col-18"></td>
                </tr>
                <tr>
                    <td colspan="18" style="white-space: nowrap; overflow: hidden;">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($costs['departments'] ?? '' as $department => $dataCost)
                @php
                    $departmentCount += 1;
                    $orderNo = 0;
                @endphp
                <tr class="department-name">
                    <td colspan="18">หน่วยงานเจ้าของสินทรัพย์ : {{ $department }}</td>
                </tr>
                <tr>
                    <td colspan="18" style="white-space: nowrap; overflow: hidden;">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
                @foreach ($data as $dataItem)
                    
                    @if ($dataItem->h1_owning_department_desc == $department)
                        <tr style="vertical-align: text-top;">
                            <td class="text-center">{{ $orderNo+=1 }}</td>
                            <td>{{ $dataItem->h1_wip_entity_name }}</td>
                            <td>{{ $dataItem->work_request_number }}</td>
                            <td>{{ $dataItem->h1_asset_number }}</td>
                            <td>{{ $dataItem->h1_asset_description }}</td>
                            <td class="text-center">{{ $dataItem->h1_work_order_type_disp }}</td>
                            <td>{{ $dataItem->h1_owning_department_code }}</td>
                            <td>{{ $dataItem->h1_reference_document1 }}</td>
                            <td>{{ $dataItem->h1_reference_document2 }}</td>
                            <td class="">{{ $dataItem->h1_concatenated_segments }} <br> {{ $dataItem->h1_item_description }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_purchased_qty, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_purchased_amount, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_received_qty, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_received_amount, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_required_qty, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_required_amount, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_issued_qty, 2) }}</td>
                            <td class="text-right" style="padding-right: 10px;">{{ number_format($dataItem->h1_issued_amount, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="8" style="padding-top: 15px">
                    </td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดปริมาณตามหน่วยงานสั่งซื้อ รับ </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['purchased_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['purchased_amount'], 2) }} </td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดมูลค่าตามหน่วยงานสั่งซื้อ รับ </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['received_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['received_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดปริมาณตามหน่วยงานรับ จ่าย </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['required_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['required_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดมูลค่าตามหน่วยงานรับ จ่าย </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['issued_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($dataCost['issued_amount'], 2) }}</td>
                </tr>
                @if (count($costs['departments']) > $departmentCount)
                    <tr>
                        <td colspan="18" style="white-space: nowrap; overflow: hidden;">
                        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="10"></td>
                    <td colspan="8" style="white-space: nowrap; overflow: hidden;"> --------------------------------------------------------------------------------------------------------------------------------------------------------- 
                </tr>
                
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดปริมาณสั่งซื้อ รับ </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['purchased_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['purchased_amount'], 2) }} </td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดมูลค่าสั่งซื้อ รับ </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['received_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['received_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดปริมาณรับ จ่าย </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['required_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['required_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="10"></td>
                    <td colspan="4">รวมยอดมูลค่ารับ จ่าย </td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['issued_qty'], 2) }}</td>
                    <td colspan="2" class="text-right" style="padding-right: 10px;">{{ number_format($costs['issued_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="18" style="white-space: nowrap; overflow: hidden;">
                    --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
