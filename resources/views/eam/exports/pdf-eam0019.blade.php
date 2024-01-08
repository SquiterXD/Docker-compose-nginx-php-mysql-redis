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

</style>
@foreach ($workOrders as $data)
    <div class="page">
        <div style="position: absolute; right: 0">หน้า {{$loop->index + 1}}</div>
        <div style="text-align: center; margin-top: 15px;">การยาสูบแห่งประเทศไทย</div>
        <div style="text-align: center;">184 ถนนพระราม 4 เขตคลองเตย กทม. 10110</div>
        <div style="text-align: center; margin-top: 20px">ใบรับงาน</div>
        <div style="margin-top: 10px;">
            <div class="d-inblock alTop alRight" style="width: 22%;">เลขที่ใบรับงาน (Work Order) :</div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;">{{($data["data"]->wip_entity_name)}}</div>
@if(isset($data["data"]->creation_date))
            <div class="d-inblock alTop alRight" style="width: 10%;">วันที่รับงาน : </div>
            <div class="d-inblock alTop" style=" width: 12%; margin-left: 15px;">
                {{Str::upper(Carbon\Carbon::parse($data["data"]->creation_date)->format('d-M-y'))}}
            </div>
@else
            <div class="d-inblock alTop alRight" style="width: 10%;">วันที่รับงาน : </div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;"></div>
@endif
            <div class="d-inblock alTop alRight" style="width: 23%;">เลขที่ใบสั่งงาน (Work Request) : </div>
            <div class="d-inblock alTop" style="width:12%; margin-left: 15px;">{{$data["data"]->work_request_number}}</div>
        </div>
        <div>
            <div class="d-inblock alTop alRight" style="width: 22%;">กลุ่มสินทรัพย์ :</div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;">{{$data["data"]->asset_group_desc}}</div>

            <div class="d-inblock alTop alRight" style="width: 10%;">ประเภท JOB : </div>
            <div class="d-inblock alTop" style="width: 23%; margin-left: 15px;">{{$data["data"]->work_order_type_desc}}</div>

@if(isset($data["data"]->work_req_creation_date))
            <div class="d-inblock alTop alRight" style="width: 12%;">วันที่เปิด JOB : </div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;">
                {{Str::upper(Carbon\Carbon::parse($data["data"]->work_req_creation_date)->format('d-M-y'))}}
            </div>
@else
            <div class="d-inblock alTop alRight" style="width: 12%;">วันที่เปิด JOB : </div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;"></div>
@endif
        </div>
        <div>
            <div class="d-inblock alTop alRight" style="width: 22%;">PM Schedule : </div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;"></div>

            <div class="d-inblock alTop alRight" style="width: 10%;">ที่ตั้ง : </div>
            <div class="d-inblock alTop" style="width: 22%; margin-left: 15px;">{{$data["data"]->area_code}}</div>

            <div class="d-inblock alTop alRight" style="width: 13%;">Shutdown Type : </div>
            <div class="d-inblock alTop" style="width: 12%; margin-left: 15px;">{{$data["data"]->shutdown_desc}}</div>
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">รหัสเครื่อง/อะไหล่ : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->asset_number}} {{$data["data"]->asset_number ? ' : ' : ''}} {{$data["data"]->asset_desc}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">Parent Asset : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data["data"]->parent}}</div>

        <div class="d-inblock alTop alRight" style="width: 22%;">ผู้แจ้งซ่อม : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->work_req_employee_code}}&nbsp;
            {{$data["data"]->work_req_employee_code ? ' : ' : ''}}&nbsp;
            {{$data["data"]->work_req_employee_desc}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">ผู้รับงาน : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->employee_code}}&nbsp;
            {{$data["data"]->employee_code ? ' : ' : ''}}&nbsp;
            {{$data["data"]->employee_desc}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">งบประมาณ : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->wip_class_code}} {{$data["data"]->wip_class_description}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">หน่วยงานแจ้งซ่อม : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->inform_dept_code}}&nbsp;
            {{$data["data"]->inform_dept_code ? ' : ' : ''}}&nbsp;
            {{$data["data"]->inform_dept_desc}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">หน่วยงานรับงาน : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">
            {{$data["data"]->owning_department_code}}&nbsp;
            {{$data["data"]->owning_department_code ? ' : ' : ''}}&nbsp;
            {{$data["data"]->owning_department_desc}}
        </div>

        <div class="d-inblock alTop alRight" style="width: 22%;">รายละเอียดใบรับงาน : </div>
        <div class="d-inblock alTop" style="width: 70%; margin-left: 15px; word-break: break-all;">{{$data["data"]->description}}</div>

        <div style="border-top: 1px solid; margin-top: 50px;"></div>
        <div style="margin-top: 5px; margin-bottom: 10px;">
            <div class="d-inblock alTop" style="width: 49%; text-align: center;">รหัสอาการเสีย</div>
            <div class="d-inblock alTop" style="width: 49%; text-align: center;">รายละเอียด</div>
        </div>
        <div style="border-top: 1px solid; margin-bottom: 15px;"></div>
        <div class="d-inblock alTop" style="width: 45%; margin-left: 15px;"></div>
        <div class="d-inblock alTop" style="width: 45%; margin-left: 15px;"></div>

        <div style="position: absolute; top: 425px; left: 0; width: 100%;">
            <div style="display: inline-block; width: 50%; margin-top: 50px; text-align: center;">
                <div> </div>
            </div>
            @php
                $pnps = $data["data"]->pnps ? explode(",", $data["data"]->pnps) : ['', ''];
            @endphp
            @if($data["data"]->pnps)
            <div style="display: inline-block; width: 49%; text-align: center;">
                <div>({{$pnps[0]}})</div>
            </div>
            <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center; margin-top:5px;">
                <div>{{$pnps[1]}}</div>
            </div>
            @endif
        </div>

        <div style="margin-top: 80px;">
            <div style="border-top: 1px solid; margin-bottom: 10px;"></div>
            <div class="d-inblock alTop" style="width: 80px;">หมายเหตุ :</div>
            <div class="d-inblock alTop" style="width: 280px;">{{$data["data"]->wo_reference ? 'เลขที่ใบรับงานอ้างอิง : ' . $data["data"]->wo_reference : ''}}</div>
            <div class="d-inblock alTop" style="width: 260px;">
                @if($data["data"]->wo_reference != "")
                    เลขที่ใบสั่งงานอ้างอิง :
                    @if(isset($data["data"]->reference_work_order))
                        {{$data["data"]->reference_work_order->work_request_number}}
                    @endif
                @endif
            </div>
        </div>
        @if($data["data"]->wo_reference != "")
        <div style="margin-top: 5px;">
            <div class="d-inblock alTop" style="margin-left: 135px; width: 238px;">
                ผู้แจ้งซ่อม :
                @if(isset($data["data"]->reference_work_request))
                    {{$data["data"]->reference_work_request->employee_code}}&nbsp;
                    {{$data["data"]->reference_work_request->employee_code ? ' : ' : ''}}&nbsp;
                    {{$data["data"]->reference_work_request->employee_desc}}
                @endif
            </div>
            <div class="d-inblock alTop">
                ผู้รับงาน :
                @if(isset($data["data"]->reference_work_order))
                    {{$data["data"]->reference_work_order->employee_code}}&nbsp;
                    {{$data["data"]->reference_work_order->employee_code ? ' : ' : ''}}&nbsp;
                    {{$data["data"]->reference_work_order->employee_desc}}
                @endif
            </div>
        </div>
        @endif

        <div style="border-top: 1px solid; margin-top: 10px;"></div>
        <div style="margin-top: 10px;">
@if(isset($data["data"]->scheduled_start_date))
            <div class="d-inblock alTop alRight" style="width: 22%;">ประมาณการ<div style="display: inline; margin-left: 35px;">วันที่เริ่ม : </div></div>
            <div class="d-inblock alTop" style="width: 20%; margin-left: 15px;">{{Str::upper($data["data"]->scheduled_start_date->format('d-M-y'))}}</div>
@else
            <div class="d-inblock alTop alRight" style="width: 22%;">ประมาณการ<div style="display: inline; margin-left: 35px;">วันที่เริ่ม : </div></div>
            <div class="d-inblock alTop" style="width: 20%; margin-left: 15px;"></div>
@endif
            <div class="d-inblock alTop alRight" style="width: 12%;">ค่าใช้จ่าย : </div>
            <div class="d-inblock alTop" style="width: 37%; margin-left: 15px;">
                {{$data["data"]->actual_total_cost ? $data["data"]->actual_total_cost : '0'}} บาท
            </div>
        </div>
        <div>
@if(isset($data["data"]->scheduled_completion_date))
            <div class="d-inblock alTop alRight" style="width: 22%;">วันที่เสร็จ : </div>
            <div class="d-inblock alTop" style="width: 20%; margin-left: 15px;">
                {{Str::upper($data["data"]->scheduled_completion_date->format('d-M-y'))}}
            </div>
@else
            <div class="d-inblock alTop alRight" style="width: 22%;">วันที่เสร็จ : </div>
            <div class="d-inblock alTop" style="width: 20%; margin-left: 15px;"></div>
@endif
            <div class="d-inblock alTop alRight" style="width: 12%;">Workhour : </div>
            <div class="d-inblock alTop" style="width: 37%; margin-left: 15px;">
                {{$data["data"]->actual_duration ? $data["data"]->actual_duration : '0'}} ชม.
            </div>
        </div>
        <div style="margin-bottom: 10px;">
            <div class="d-inblock alTop alRight" style="width: 22%;">ระดับความสำคัญของงาน : </div>
            <div class="d-inblock alTop" style="width: 70%; margin-left: 15px;">{{$data["data"]->work_request_priority_desc}}</div>
        </div>

        <div style="border-top: 1px solid; margin-bottom: 15px;"></div>

        <div style="margin-top: 20px;">
        @foreach ($data["images"] as $image)
            @if(isset($image->file_name))
                <div style="display: inline-block; width: 49.5%; {{$loop->index == 0 ? 'text-align:left;' : 'text-align:right;'}}">
                    <img src="{{storage_path('app/'.$image->path.$image->file_name)}}" height="230px;"/>
                </div>
            @endif
        @endforeach
        {{-- @foreach ($data->images as $image)
            <img src="{{storage_path('app/'.$image->path.$image->file_name)}}" width="33%" height="150px;"/>
        @endforeach --}}
        {{-- @if(count($newImages) && isset($newImages[$loop->index]))
            @foreach ($newImages[$loop->index] as $image)
                <div style="display: inline-block; width: 49.5%; {{$loop->index == 0 ? 'text-align:left;' : 'text-align:right;'}}">
                    <img src="{{storage_path('app/'.$image->path.$image->file_name)}}" height="230px;"/>
                </div>
            @endforeach
        @endif --}}
        </div>
        <div style="clear: both;"></div>


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
                <div>{{$data["data"]->employee_code}} {{$data["data"]->employee_desc}}</div>
            </div>
            <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                <div> </div>
            </div>
            <div style="display: inline-block; width: 49%; text-align: center; margin-top:10px;">
                <div>ผู้รับงาน</div>
            </div>
        </div>
    </div>
@endforeach
