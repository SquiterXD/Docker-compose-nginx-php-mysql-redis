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
        font-size: 12px;
    }
    .alTop {
        vertical-align: top;
        margin-top: 5px;
    }
    .alRight {
        text-align: right;
    }
    .d-inblock {
        display: inline-block;
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

    .col-1  { width: 60px; }
    .col-2  { width: 120px; }
    .col-3  { width: 190px; }
    .col-4  { width: 90px; }
    .col-5  { width: 90px; }
    .col-6  { width: 90px; }

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
@foreach ($workOrders as $data)
    <div class="page">
        <div style="text-align: center; margin-top: 15px;">การยาสูบแห่งประเทศไทย</div>
        <div style="text-align: center;">184 ถนนพระราม 4 เขตคลองเตย กทม. 10110</div>
        <div style="text-align: center; margin-top: 20px">ใบปิดงานผลิตชื้นส่วนอะไหล่และอุปกรณ์</div>
        <div style="margin-top: 50px;">
            <div class="d-inblock alTop alRight" style="width: 22%;">เลขที่ใบรับงาน (Work Order) :</div>
            <div class="d-inblock alTop" style="width: 14%; margin-left: 20px;">{{(string)($data->wip_entity_name)}}</div>
@if(isset($data->creation_date))
            <div class="d-inblock alTop alRight" style="width: 6%;">วันที่ : </div>
            <div class="d-inblock alTop" style=" width: 12%; ">{{Str::upper($data->creation_date->format('d-M-y'))}}</div>
@else
            <div class="d-inblock alTop alRight" style="width: 6%;">วันที่ : </div>
            <div class="d-inblock alTop" style="width: 12%; "></div>
@endif
            <div class="d-inblock alTop alRight" style="width: 22%;">เลขที่ JOB(Work Request) : </div>
            <div class="d-inblock alTop" style="width: 14%; margin-left: 20px;">{{$data->work_request_number}}</div>
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">ผู้ปิดงาน : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data->closed_emp}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">หน่วยงานสั่งผลิต : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data->owning_department_code}} {{$data->owning_department_code ? ' : ' : ''}} {{$data->owning_department_desc}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">วัสดุ/อะไหล่ : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data->asset_number}} {{$data->asset_number ? ' : ' : ''}} {{$data->asset_desc}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">จำนวนที่สั่งผลิต  : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data->order_qty}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">จำนวนที่ผลิตได้ : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data->produce_qty}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">รายละเอียดใบสั่งงาน : </div>
        <div class="d-inblock alTop" style="width: 28%; margin-left: 15px;">{{$data->description}}</div>

        <div class="d-inblock alTop alRight" style="width: 15%;">ราคาต้นทุน/หน่วย : </div>
        <div class="d-inblock alTop" style="width: 28%; margin-left: 15px;">{{number_format($data->unit_cost, 2)}} {{$data->unit_cost ? ' บาท' : ''}}</div>

        <div style="border-top: 1px solid; margin-top: 50px;"></div>
        <div style="margin-top: 10px; margin-bottom: 10px;">
            <div class="d-inblock alTop" style="width: 49%; text-align: center;">รหัสซ่อม</div>
            <div class="d-inblock alTop" style="width: 49%; text-align: center;">รายละเอียดการซ่อม</div>
        </div>
        <div style="border-top: 1px solid; margin-bottom: 15px;"></div>

    <div class="d-inblock alTop body" style="width: 22%;">วัสดุ/อะไหล่ที่ใช้ในการผลิต</div>      
        <table class="table-content" style="margin-bottom: 30px;">
            <thead>
                <tr class="table-header">
                    <td class="col-1 body">NO.</td>
                    <td class="col-2 body">รหัสอะไหล่</td>
                    <td class="col-3 body">รายละเอียดอะไหล่</td>
                    <td class="col-4 body alRight">จำนวน</td>
                    <td class="col-5 body alRight">ราคา</td>
                    <td class="col-6 body alRight">รวมราคา</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data->items ?? '' as $row => $itemdata)
                <tr>
                    <td style="text-align: center;">{{ $row+1 }}</td>
                    <td>{{ $itemdata->item_code_line }}</td>
                    <td>{{ $itemdata->item_desc_line }}</td>
                    <td style="text-align: right;">{{ number_format($itemdata->quantity_issued_line, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($itemdata->item_cost_line, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($itemdata->sum_cost_line, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>  

        <div class="d-inblock alTop alRight" style="width: 22%;">รวมค่าแรง : </div>
        <div class="d-inblock alTop" style="width: 30%; margin-left: 15px;">{{number_format($data->actual_labor_cost, 2)}} {{$data->actual_labor_cost ? ' บาท' : ''}}</div>

        <div class="d-inblock alTop alRight" style="width: 12%;">รวมค่าอะไหล่ : </div>
        <div class="d-inblock alTop" style="width: 30%; margin-left: 15px;">{{number_format($data->actual_material_cost, 2)}} {{$data->actual_material_cost ? ' บาท' : ''}}</div>

        <div class="d-inblock alTop alRight" style="width: 27%;"></div>
        <div class="d-inblock alTop" style="width: 15%; margin-left: 15px;"></div>

        <div class="d-inblock alTop alRight" style="width: 22%;">รวมทั้งสิ้น (ค่าแรง+ค่าอะไหล่) : </div>
        <div class="d-inblock alTop" style="width: 30%; margin-left: 15px;">{{number_format($data->actual_total_cost, 2)}} {{$data->actual_total_cost ? ' บาท' : ''}}</div>

        <div style="position: absolute; bottom: 10px; left: 0; width: 100%;">
            <div style="display: inline-block; width: 50%; margin-top: 50px; text-align: center;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center;">
                <div>..............................................</div>
            </div>
            <div style="display: inline-block; width: 50%; text-align: center;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center;">
                <div>{{$data->closed_emp}}</div>
            </div>
            <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center; margin-top:10px;">
                <div>_____/_____/_____</div>
            </div>
            <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center; margin-top:10px;">
                <div>ผู้ปิดงาน</div>
            </div>
        </div>

    </div>
@endforeach
