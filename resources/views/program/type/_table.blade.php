<table class="table program_type_tb">
    <thead>
        <tr class="">
            <th width="3%" class="hidden-sm hidden-xs text-center">
                <div>Active</div>
                <div><small>สถานะ</small></div>
            </th>
            <th width="18%" class="text-left">
                <div> Program Type </div>
                <div><small>ชนิดโปรแกรม</small></div>
            </th>
            <th width="18%" class="hidden-sm hidden-xs text-left">
                <div> Description </div>
                <div><small>คำอธิบาย</small></div>
            </th>
            <th width="8%" class="hidden-sm hidden-xs text-center">
                <div>Create Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th class="no-sort" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($programTypes as $type)
        <tr>
            <td class="text-center">
                @include('shared._status_active', ['isActive' => $type->enable_flag == 'Y'])
            </td>
            <td class="text-left">
                {{ $type->program_type_name }}
                <div><small> <strong>User Type :</strong> {{ $type->user_program_type_name }} </small></div>
            </td>
            <td class="text-left"> {{ $type->description }} </td>
            <td class="text-center hidden-sm hidden-xs" data-sort="{{ date('Y-m-d H:i:s', strtotime($type->creation_date)) }}">
                {{ date(trans('date.format'),strtotime($type->creation_date)) }} {{-- ->format(trans('date.time-format')) --}}
            </td>
            <td class="text-center">
                <a href="{{ route('program.type.edit', $type->program_type_name) }}" class="btn btn-primary btn-xs">
                   <i class="fa fa-edit m-r-xs"></i> Edit
                </a> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>