<table class="table program_info_tb">
    <thead>
        <tr class="">
            <th width="3%" class="hidden-sm hidden-xs text-center">
                <div>Active</div>
                <div><small>สถานะ</small></div>
            </th>
            <th width="20%" class="text-left">
                <div> Program </div>
                <div><small>โปรแกรม</small></div>
            </th>
            <th width="10%" class="hidden-sm hidden-xs text-left">
                <div> Description </div>
                <div><small>คำอธิบาย</small></div>
            </th>
             <th width="5%" class="hidden-sm hidden-xs text-left">
                <div> Module </div>
                <div><small>โมดูล</small></div>
            </th>
            <th width="7%" class="hidden-sm hidden-xs text-center">
                <div> Action </div>
                <div><small>การทำงาน</small></div>
            </th>
            <th width="8%" class="hidden-sm hidden-xs text-center">
                <div>Create Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th class="no-sort" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($programInfos as $info)
        <tr>
            <td class="text-center">
                @include('shared._status_active', ['isActive' => $info->enable_flag == 'Y'])
            </td>
            <td class="text-left">
                {{ $info->program_code }}
                <div><small> <strong>Program Type: </strong> {{ optional($info->userType)->user_program_type_name }} </small></div>
            </td>
            <td class="text-left"> {{ $info->description }} </td>
            <td class="text-left">
                {{ $info->module_name }}
                <div><small> <strong>Schema: </strong> {{ $info->schemas_name }} </small></div>
            </td>
            <td class="text-left">
                @if ($info->insert_flag == 'Y')
                    <span class="badge badge-success">สร้าง</span>
                @endif

                @if ($info->update_flag == 'Y')
                    <span class="badge badge-warning">แก้ไข</span>
                @endif
                
                @if ($info->delete_flag == 'Y')
                    <span class="badge badge-danger">ลบ</span>
                @endif
            </td>
            <td class="text-center" data-sort="{{ date('Y-m-d H:i:s', strtotime($info->creation_date)) }}">
                {{-- {{ $info->creation_date }} --}}
                {{ date(trans('date.format'),strtotime($info->creation_date)) }}
            </td>
            <td class="text-center">
                <a href="{{ route('program.info.edit', $info->program_code ?? 0000) }}" class="btn btn-warning btn-xs">
                   <i class="fa fa-edit m-r-xs"></i> แก้ไข
                </a> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

