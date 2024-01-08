<div>
    <h4>สูตรการผลิต</h4>
    <div class="row">
        <div class="col-md-4">
            <label class="ml-3"> <b>รหัสสินค้า</b>  </label>
            <label class="ml-3">{{ $header->item ?  $header->item->item_number . ' ' . $header->item->item_desc : '' }}</label>
        </div>
        <div class="col-md-4">
            <label> <b>สถานะ</b> </label>
            <label class="ml-3">
                @if ($header->status == 'Approved for General Use')
                    อนุมัติ
                @elseif ($header->status == 'New')
                    สร้างใหม่
                @elseif ($header->status == 'Obsolete/Archived')
                    ยกเลิก
                @endif
            </label>
        </div>
        <div class="col-md-3">
            <label> <b>ผู้อนุมัติ</b> </label>
            <label class="ml-3">{{ $header->user ? $header->user->user_name : '' }}</label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>ประเภทสูตร</b> </label>
            <label class="ml-3">{{ $header->FormulaType ? $header->FormulaType->description : ''  }}</label>
        </div>
        <div class="col-md-4">
            <label> <b>Version</b> </label>
            <label class="ml-3">{{ $header->version }} </label>
        </div>
        <div class="col-md-3">
            <label> <b>ปีงบประมาณ</b> </label>
            <label class="ml-3">{{ $header->period_year }} </label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>ประเภทสิ่งผลิต</b> </label>
            <label class="ml-3"> {{ $header->routing ? $header->routing->routing_desc : '' }} </label>
        </div>
        <div class="col-md-4">
            <label> <b>จำนวนผลผลิต</b> </label>
            <label class="ml-3">{{ number_format($header->qty) }} {{ $header->uomHeader ? $header->uomHeader->from_unit_of_measure : '' }}</label>
        </div>
        
        <div class="col-md-3">
            <label> <b>วันที่เริ่มใช้งาน</b> </label>
            <label class="ml-3">
                {{-- {{ $header->start_date ? date(trans('date.format-date'),strtotime($header->start_date)) : '' }} --}}
            
                {{ parseToDateTh($header->start_date) }} 
            </label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>ขั้นตอนการทำงาน</b> </label>
            <label class="ml-3"> {{ $header->opmRouting ? $header->opmRouting->oprn_desc : '' }} </label>

            {{-- {{dd($wipSteps)}} --}}
            {{-- @foreach($wipSteps->where('routing_desc', $header->routing_desc) as $wipStepHeader)
                <div class="ml-3">
                    <el-radio v-model="multi_wip_step" label="{{$wipStepHeader->oprn_id}}">
                        {{$wipStepHeader->oprn_desc}}
                    </el-radio>
                </div>                
            @endforeach --}}
            {{-- <div v-for="wipStepHeader in wipSteps[routing_desc]">
                <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id">
                    @{{ wipStepHeader.oprn_desc }}
                </el-radio>
            </div> --}}
        </div>
        <div class="col-md-4">
            <label> <b>ประเภทเครื่องจักร</b> </label>
            <label class="ml-3">
                @if ($header->organization->organization_code == 'M05')
                    {{ $header->machineGroupF  ? $header->machineGroupF->description : '' }}  
                @else
                    {{ $header->machineType  ? $header->machineType->description : '' }}
                @endif
            </label>
        </div>
        <div class="col-md-3">
            <label> <b>วันที่สิ้นสุดการใช้งาน</b> </label>
            <label class="ml-3">
                {{-- {{ $header->end_date ? date(trans('date.format-date'),strtotime($header->end_date)) : '' }} --}}
                {{ parseToDateTh($header->end_date) }} 
            </label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-8">
            <label class="ml-3"> <b>หมายเหตุ</b> </label>
            <label class="ml-3"> {{ $header->comments }} </label>
        </div>
        <div class="col-md-3">
            <label> <b>กองบริหารต้นทุนนำไปใช้แล้ว</b> </label>
            <label class="ml-3">
                @include('shared._status_active', ['isActive' => $header->invoice_flag == 'Y'])
            </label>
        </div>
    </div>
</div>