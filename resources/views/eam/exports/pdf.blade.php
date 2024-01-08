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
    .page_break { page-break-before: always; }
    body {
        font-family: 'SarabunSans'
    }

</style>
@foreach ($workRequests as $data)
    <?php
        if(count($data->images) == 0){
            $data->images = ['noImages'];
        }
        for($i=0;$i<count($data->images)/6;$i++)
        {
    ?>
        <div class="page">
            <div style="text-align: center; margin-top: 15px;">การยาสูบแห่งประเทศไทย</div>
            <div style="text-align: center;">184 ถนนพระราม 4 เขตคลองเตย กทม. 10110</div>
            <div style="text-align: center; margin-top: 20px">ใบสั่งงาน</div>
            <div>
                <div style="display: inline-block; width: 50%; margin-top: 50px;">เลขที่ ใบสั่งงาน : <div style="display: inline; margin-left: 15px;">{{$data->work_request_number}} </div></div>
                <div style="display: inline-block; width: 49%; margin-top: 50px;">
                    วันที่แจ้งซ่อม :
                    <div style="display: inline; margin-left: 15px;">
                        {{$data->expected_start_date ? Str::upper($data->expected_start_date->format('d-M-y')) : ''}}
                        {{-- @if ($data->creation_date->format('ymd') > $data->expected_start_date->format('ymd'))
                            {{Str::upper($data->expected_start_date->format('d-M-y'))}}
                        @else
                            {{Str::upper($data->creation_date->format('d-M-y'))}}
                        @endif --}}
                    </div>
                </div>
            </div>
            <div>รหัสเครื่องจักร : <div style="display: inline; margin-left: 15px;">{{$data->asset_number}}: {{$data->asset_desc}}</div></div>
            <div>
                <div style="display: inline-block; width: 46%;">ผู้แจ้งซ่อม : <div style="display: inline; margin-left: 60px;">{{$data->employee_desc}}</div></div>
                <div style="display: inline-block; width: 49%;">สถานะใบสั่งซ่อม : <div style="display: inline; margin-left: 15px;">{{$data->work_request_status_desc}}</div></div>
            </div>
            <div style="margin-top: 20px;">จากหน่วยงาน : <div style="display: inline; margin-left: 51px;">{{$data->owning_dept_code}}: {{$data->owning_dept_desc}}</div></div>
            <div>ถึงหน่วยงาน : <div style="display: inline; margin-left: 60px;">{{$data->receiving_dept_code}}: {{$data->receiving_dept_desc}}</div></div>

            <div style="border-top: 1px solid; margin-top: 50px;"></div>
            <div style="text-align: center; margin-bottom: 10px;">รายละเอียด</div>
            <div style="border-top: 1px solid; margin-bottom: 15px;"></div>

            <div style="width: 80%; margin: auto;">{{$data->description}} </div>

            <div style="margin-top: 50px;">หมายเหตุ :</div>
            <div style="margin-top: 10px;">
            @foreach ($data->images as $key=>$image)
                @if ($image != 'noImages')
                    @if($key <= ((($i+1)*6)-1) && $key > (($i*6)-1))
                        <img src="{{storage_path('app/'.$image->path.$image->file_name)}}" width="33%" height="150px;" alt=""/>
                    @endif
                @endif
            @endforeach
            </div>

            <div style="position: absolute; bottom: 10px; left: 0; width: 100%;">
                <div style="display: inline-block; width: 50%; margin-top: 50px; text-align: center;">
                    <div>..............................................</div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    <div>..............................................</div>
                </div>
                <div style="display: inline-block; width: 50%; text-align: center;">
                    <div>{{$data->employee_desc}}</div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    <div>{{$data->approver_desc}}</div>
                </div>
                <div style="display: inline-block; width: 50%; text-align: center;">
                @if(isset($data->expected_start_date))
                    <div style="margin-top: 10px;">{{ $data->expected_start_date->format('d/M/y') }}</div>
                @else
                    <div style="margin-top: 10px;">___/___/_____</div>
                @endif
                </div>
                <div style="display: inline-block; width: 49%; text-align: center;">
                    @if(isset($data->approved_date))
                        <div style="margin-top: 10px;">{{ $data->approved_date->format('d/M/y') }}</div>
                    @else
                    <div style="margin-top: 10px;">___/___/_____</div>
                    @endif
                </div>
                <div style="display: inline-block; width: 50%; text-align: center; margin-top:10px;">
                    <div>ผู้แจ้งซ่อม</div>
                </div>
                <div style="display: inline-block; width: 49%; text-align: center; margin-top:10px;">
                    <div>ผู้อนุมัติ</div>
                </div>
            </div>
        </div>
    <?php
        }
    ?>
@endforeach
