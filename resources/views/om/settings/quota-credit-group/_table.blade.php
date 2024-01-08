<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">รหัสผลิตภัณฑ์</th>
                <th class="text-center">ชื่อตราผลิตภัณฑ์</th>
                <th class="text-center">กลุ่มโควต้า</th>
                <th class="text-center">กลุ่มวงเงินเขื่อ</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                @if (canEnter('/om/settings/quota-credit-group'))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($quotaCreditGroups as $quota)
                <tr>
                    <td>{{ $quota->item_code }}</td>
                    <td>{{ $quota->item_description }}</td>
                    <td>{{ $quota->quotaGroup ? $quota->quotaGroup->meaning : '' }}</td>
                    <td>{{ $quota->creditGroup ? $quota->creditGroup->description : '' }}</td>
                    {{-- <td>{{ $quota->start_date ? date(trans('date.format-date'), strtotime($quota->start_date)) : '' }}</td>
                    <td>{{ $quota->end_date   ? date(trans('date.format-date'), strtotime($quota->end_date)) : '' }}</td> --}}
                    <td>{{ $quota->start_date ? parseToDateTh($quota->start_date) : '' }}</td>
                    <td>{{ $quota->end_date   ? parseToDateTh($quota->end_date)   : '' }}</td>
                    @if (canEnter('/om/settings/quota-credit-group'))
                        <td align="center">
                            <a href="{{ route('om.settings.quota-credit-group.edit', $quota->quota_credit_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $quotaCreditGroups->links() }}
</div>