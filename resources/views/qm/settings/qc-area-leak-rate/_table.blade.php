{!! Form::open([   'route' => ['qm.settings.qc-area-leak-rate.update'], 
                    "method" => "put", 
                    "autocomplete" => "off", 
                    'class' => 'form-horizontal', 
                    'enctype' => 'multipart/form-data',
                    'files'=> true, ]) !!}

<table class="table program_info_tb">
    <thead>
        <tr>
            <th width="5%" class="text-center">
                <div>ลำดับที่</div>
            </th>
            <th width="10%" class="text-center">
                <div>กลุ่มเครื่องจักร</div>
            </th>
            <th width="10%" class="text-center">
                <div>ประเภทเครื่องจักร</div>
            </th>
            <th width="10%" class="text-center">
                <div>หมายเลขเครื่อง</div>
            </th>
            <th width="10%" class="text-center">
                <div>เขตการตรวจคุณภาพ</div>
            </th>
            <th width="5%" class="text-center">
                <div>สถานะการใช้งาน</div>
            </th>
            {{-- <th width="20%" class="text-center">
                <div> </div>
            </th> --}}
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1; 
        @endphp
        
        @if(count($qcAreasQTM) > 0)
            @foreach($qcAreasQTM as $key => $qcArea)
                <tr>
                    <input type="hidden" :name="'dataGroup[{{$key}}][department_code]'" value={{ $qcArea->department_code }}>
                    <td class="text-center">
                        {{ $i++ }}
                    </td>
                    <td class="text-center">
                        <input type="hidden" :name="'dataGroup[{{$key}}][step_num]'" value={{ $qcArea->step_num }}>
                        {{$qcArea->step_description}}
                    </td>
                    <td class="text-center">
                        <input type="hidden" :name="'dataGroup[{{$key}}][step_description]'" value={{ $qcArea->step_description }}>
                        {{$qcArea->machine_description}}
                    </td>
                    <td class="text-center">
                        <input type="hidden" :name="'dataGroup[{{$key}}][machine_set]'" value={{ $qcArea->machine_set }}>
                        {{$qcArea->machine_set}}
                    </td>
                    <td>
                        <input  placeholder="กรอกเขตการตรวจคุณภาพ" 
                                class="form-control form-control-sm" 
                                :name="'dataGroup[{{$key}}][qc_area_leak_rate]'"
                                value={{ $qcArea->qc_area_leak_rate }}>
                    </td>
                    <td class="text-center">
                        <input  type="checkbox" 
                                :name="'dataGroup[{{$key}}][qm_enable_flag]'" 
                                value={{ $qcArea->qm_enable_flag ? 'Y' : 'N'}}
                                {{ $qcArea->qm_enable_flag === 'Y' ? ' checked' : '' }}>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">
                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                </td>
            </tr>
        @endif

    </tbody>
</table>

<div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2" style="padding-top: 10px;">
    {!! $qcAreasQTM->links('shared._pagination') !!}
</div>

<div class="col-12">
    <div class="row clearfix text-center">
        <div class="col-sm-12">
            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i>  บันทึก </button>
            <a href="{{ route('qm.settings.qc-area-leak-rate.index') }}" type="button" class="btn btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i> ยกเลิก 
            </a>
        </div>
    </div>
</div>
{!! Form::close() !!}
