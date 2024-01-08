<title>ใบปิดงานซ่อม</title>
<style type="text/css">
    @font-face{
        font-family: 'SarabunSans';
        font-style: 'normal';
        src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
    }
    .page {
        overflow: hidden;
        page-break-after: always;
        position: relative;
        min-height: 1050px;
    }
    .page:last-of-type {
        page-break-after: auto
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

</style>
@php $currentWipEntityName = null; @endphp
@foreach ($data as $itemMain)
    @if ($itemMain->wip_entity_name != $currentWipEntityName)
        @php $currentWipEntityName = $itemMain->wip_entity_name; @endphp
        <div class="page">
            <div style="text-align: center; margin-top: 15px;">การยาสูบแห่งประเทศไทย</div>
            <div style="text-align: center;">184 ถนนพระราม 4 เขตคลองเตย กทม. 10110</div>
            <div style="text-align: center;">ใบปิด Job (อะไหล่)</div>
            <div>
                <div style="display: inline-block; width: 40%; margin-top: 50px;">เลขที่ใบรับงาน (Work Order) :
                    <div style="display: inline; margin-left: 15px;">{{$itemMain->wip_entity_name}} </div>
                </div>
                <div style="display: inline-block; width: 20%; margin-top: 50px;">วันที่ :
                    <div style="display: inline; margin-left: 15px;">{{Str::upper($itemMain->creation_date->format('d-M-y'))}}</div>
                </div>
                <div style="display: inline-block; width: 35%; margin-top: 50px;">เลขที่ใบสั่งงาน (Work Request) :
                    <div style="display: inline; margin-left: 15px;">{{$itemMain->work_request_number}}</div>
                </div>
            </div>
            <div>
                <div style="display: inline-block; width: 26%; margin-left: 66px;">ประเภท Job :
                    <div style="display: inline; margin-left: 15px;">{{$itemMain->work_order_type_desc}}</div>
                </div>
                <div style="display: inline-block; width: 46%;">สถานะใบรับงาน :
                    <div style="display: inline; margin-left: 15px;">{{$itemMain->status_desc}}</div>
                </div>
            </div>
            <div style="margin-top: 20px; width: 100%; margin-left: 61px;">รหัสเครื่องจักร :
                <div style="display: inline; margin-left: 15px;">{{$itemMain->asset_number}}: {{$itemMain->asset_desc}}</div>
            </div>
            <div style="width: 100%; margin-left: 76px;">ผู้แจ้งซ่อม :
                <div style="display: inline; margin-left: 15px;">{{$itemMain->inform_emp}}</div>
            </div>
            <div style="width: 100%; margin-left: 70px;">งบประมาณ :
                <div style="display: inline; margin-left: 15px;">{{$itemMain->class_code}}: {{$itemMain->class_desc}}</div>
            </div>
            <div style="width: 100%; margin-left: 82px;">ผู้ปิดงาน :
                <div style="display: inline; margin-left: 15px;">{{$itemMain->closed_emp}}</div>
            </div>
            <div style="width: 100%; margin-left: 33px;">รายละเอียดใบสั่งงาน :
                <div style="display: inline; margin-left: 15px;">{{$itemMain->description}}</div>
            </div>

            <table class="table-content">
                <thead>
                    <tr>
                        <td colspan="2">
                        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                    <tr class="table-header">
                        <td class="col-1">รหัสซ่อม</td>
                        <td class="col-2">รายละเอียดการซ่อม</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table-content">
                <thead>
                    <tr>
                        <td colspan="5" style="color: white;">
                        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                    <tr class="table-header">
                        <td class="col-1">รหัสอะไหล่</td>
                        <td class="col-2">รายละเอียดอะไหล่</td>
                        <td class="col-3">จำนวน</td>
                        <td class="col-4">ราคา</td>
                        <td class="col-5">จำนวนเงิน</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="color: white;">
                        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $itemSub)
                        @if ($itemSub->wip_entity_name == $currentWipEntityName)
                            <tr>
                                <td style="text-align: center; width:20%;">{{ $itemSub->item_code_line }}</td>
                                <td style="width:45%;">{{ $itemSub->item_desc_line }}</td>
                                <td style="text-align: center; width:5%;">{{ $itemSub->quantity_issued_line }}</td>
                                <td style="text-align: right; width:15%;">{{ number_format($itemSub->item_cost_line, 2) }}</td>
                                <td style="text-align: right; width:15%;">{{ number_format($itemSub->sum_cost_line, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 30px;">
                <div style="display: inline-block; width: 60%;">รวมค่าแรง :
                    <div style="display: inline; margin-left: 15px;">{{ number_format($itemMain->actual_labor_cost, 2) }}</div>
                    <div style="display: inline; margin-left: 15px;">บาท</div>
                </div>
                <div style="display: inline-block; width: 39%;">รวมค่าอะไหล่ :
                    <div style="display: inline; margin-left: 15px;">{{ number_format($itemMain->actual_material_cost, 2) }}</div>
                    <div style="display: inline; margin-left: 15px;">บาท</div>
                </div>
            </div>
            <div style="margin-top: 15px; width: 100%;">
                <div style="display: inline-block; width: 60%;">
                </div>
                <div style="display: inline-block; width: 39%;">รวมทั้งสิ้น (ค่าแรง + ค่าอะไหล่) :
                    <div style="display: inline; margin-left: 15px;">{{ number_format($itemMain->actual_total_cost, 2) }}</div>
                    <div style="display: inline; margin-left: 15px;">บาท</div>
                </div>
            </div>
            <div style="margin-top: 15px;">หมายเหตุ :</div>
            <div style="margin-top: 10px;">
            </div>

            <div style="position: absolute; bottom: 10px; left: 0; width: 100%;">
                <div style="display: inline-block; width: 50%; margin-top: 50px; text-align: center;">
                    <div></div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    <div>..............................................</div>
                </div>
                <div style="display: inline-block; width: 50%; text-align: center;">
                    <div></div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    <div>{{$itemMain->closed_emp}}</div>
                </div>
                <div style="display: inline-block; width: 50%; text-align: center;">
                    <div style="margin-top: 10px;"></div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    <div style="margin-top: 10px;">___/___/_____</div>
                </div>
                <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                    <div></div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center; margin-top:10px;">
                    <div>ผู้ปิดงาน</div>
                </div>
            </div>
        </div>
    @endif

@endforeach
