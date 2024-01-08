<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">ลำดับที่</th>
                <th class="text-center">ผู้อนุมัติ</th>
                <th class="text-center">ตำแหน่ง</th>
                <th class="text-center">Default</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                <th></th>
                @if (canEnter('/om/settings/approver-order-export'))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($approverOrders as $approverOrder)
                <tr>
                    <td class="text-center">{{ $approverOrder->approver_number }}</td>
                    <td>{{ $approverOrder->approver_name }}</td>
                    <td>{{ $approverOrder->authoRity ? $approverOrder->authoRity->position_name : '' }}</td>
                    <td class="text-center">
                        @include('shared._status_active', ['isActive' => $approverOrder->default_flag == 'Y'])
                    </td>
                    <td>{{ $approverOrder->start_date ? date(trans('date.format-date'), strtotime($approverOrder->start_date)) : '' }}</td>
                    <td>{{ $approverOrder->end_date   ? date(trans('date.format-date'), strtotime($approverOrder->end_date)) : '' }}</td>
                    {{-- @if (canEnter('/om/settings/approver-order-export')) --}}
                        <td align="center">
                            <a href="{{ route('om.settings.approver-order-export.edit', $approverOrder->approver_order_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    {{-- @endif --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $approverOrders->links() }}
</div>
