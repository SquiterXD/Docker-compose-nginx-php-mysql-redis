<div class="table-responsive">
    <table class="table text-nowrap " id="machine-relation-datatable">
        <thead>
            <tr>
                <th class="text-center">สถานะ<br>การใช้งาน</th>
                <th class="text-center">
                    {{-- กลุ่มชุดเครื่องจักร --}}
                    กลุ่มชุดเครื่องจักร(มวน)/<br>กลุ่มผลิตภัณฑ์(ก้นกรอง)
                </th>
                <th class="text-center">เซ็ตเครื่องจักร</th>
                <th class="text-center">หมายเลขเครื่องจักร</th>
                <th class="text-center">ประเภทเครื่องจักร</th>
                <th class="text-center">ขั้นตอนการทำงาน</th>
                {{-- <th class="text-center">ความเร็วเครื่องจักร<br>(หน่วยขั้นตอน/นาที)</th> --}}
                <th class="text-center">ความเร็วเครื่องจักร</th>
                <th class="text-center">หน่วยความเร็วเครื่องจักร</th>
                <th class="text-center">% ประสิทธิภาพ ของ EAM</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($machineRelations as $machineRelation)
                {{-- <tr>
                    <td align="center"> 
                        @include('shared._status_active', ['isActive' => $machineRelation->pm_enable_flag == 'Y'])
                    </td>
                    <td>{{ $machineRelation->machine_group_desc }}</td>
                    <td class="text-center">{{ $machineRelation->machine_set }}</td>
                    <td>{{ $machineRelation->machine_description }}</td>
                    <td>{{ $machineRelation->machineType ? $machineRelation->machineType->description : '' }}</td>
                    <td>{{ $machineRelation->step_description }}</td>
                    <td class="text-right">
                        {{ number_format($machineRelation->machine_speed) }}
                    </td>
                    <td class="text-right">
                        @if ($machineRelation->step_description)
                            {{ $machineRelation->speed_unit_desc }}
                        @endif
                    </td>
                    <td class="text-center">{{ $machineRelation->machine_eamperformance }}</td>
                    <td class="text-center">
                        @if ($machineRelation->machine_relation_id)
                            <a href="{{ route('pm.settings.machine-relation.edit', $machineRelation->machine_relation_id) }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        @endif
                    </td>
                </tr> --}}
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{-- {{ $machineRelations->links() }} --}}
</div>