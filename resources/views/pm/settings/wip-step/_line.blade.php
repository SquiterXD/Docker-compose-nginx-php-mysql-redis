<div class="table-responsive">
    <table class="table table-bordered" id="tableReimbursements">
        <thead>
            <tr>
                <td>ลำดับ</td>
                <td>ขั้นตอนการทำงาน</td>
                <td>ชื่อขั้นตอนการทำงาน</td>
                <td>หน่วยนับผลผลิต</td>
                <td class="text-center">WIP ที่ใช้ตัดวัตถุดิบ</td>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($routing->wipSteps)}} --}}
            @foreach ($routing->wipSteps->where('web_status', '!=', 'DELETE')->sortBy('wip_step_id') as $step)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- <td>{{ $step->openClass ? $step->openClass->oprn_class_desc : '' }}</td> --}}
                    <td>{{ $step->wip_step }}</td>
                    <td>{{ $step->wip_step_desc }}</td>
                    <td>{{ $step->ptinvUom ? $step->ptinvUom->unit_of_measure : '' }}</td>
                    <td align="center"> 
                        @include('shared._status_active', ['isActive' => $step->attribute4 == 'Y'])
                    </td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</div>