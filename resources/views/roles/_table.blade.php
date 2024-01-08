<table class="table">
    <thead>
        <tr class="">
            {{-- <th class="text-center" width="5%">
                <div>Active</div>
                <div><small>สถานะ</small></div>
            </th> --}}
            <th width="10%" class="hidden-sm hidden-xs text-center">
                <div>Module Name</div>
                {{-- <div><small>รหัสแผนก</small></div> --}}
            </th>
            <th  >
                <div>Role Name</div>
                <div><small>หน้าที่รับผิดชอบ</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Create Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Last Update Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th class="no-sort" width="10%"></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($roles as $role)
        <tr>
            <td class="text-center">{{ $role->module_name }}</td>
            <td>
                {{ $role->name }}
            </td>
            <td class="text-right hidden-sm hidden-xs">
                {{ $role->creation_date->format(trans('date.format')) }}
                {{ $role->creation_date->format(trans('date.time-format')) }}
            </td>
            <td class="text-right hidden-sm hidden-xs">
                {{ $role->last_update_date->format(trans('date.format')) }}
                {{ $role->last_update_date->format(trans('date.time-format')) }}
            </td>
            <td class="text-center">
                <a href="{{ route('roles.edit', [$role]) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit m-r-xs"></i> Edit
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>