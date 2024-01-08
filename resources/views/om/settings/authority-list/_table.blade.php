<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">ลำดับที่</th>
                <th class="text-center">ผู้มีอำนาจ</th>
                <th class="text-center">ตำแหน่ง</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                @if (canEnter('/om/settings/authority-list'))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($authorities as $authority)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                        {{-- {{ $authority->authority_number }} --}}
                    </td>
                    <td>
                        {{ $authority->employee_name }}
                    </td>
                    <td>
                        {{ $authority->position_name }}
                    </td>
                    {{-- <td>{{ $authority->start_date ? date(trans('date.format-date'), strtotime($authority->start_date)) : '' }}</td>
                    <td>{{ $authority->end_date ? date(trans('date.format-date'), strtotime($authority->end_date)) : '' }}</td> --}}
                    <td>{{ $authority->start_date ? parseToDateTh($authority->start_date) : '' }}</td>
                    <td>{{ $authority->end_date   ? parseToDateTh($authority->end_date)   : '' }}</td>
                    @if (canEnter('/om/settings/authority-list'))
                        <td align="center">
                            <a href="{{ route('om.settings.authority-list.edit', $authority->authority_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>