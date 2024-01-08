<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">รหัสลูกค้า</th>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">สั่งซื้อกรณีพิเศษ</th>
                <th class="text-center">สั่งซื้อครั้งที่ 2 ในวัน</th>
                <th class="text-center">วันที่อนุญาติให้สั่งซื้อได้</th>
                {{-- <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th> --}}
                @if (canEnter('/om/settings/grant-spacial-case'))
                    <th></th>
                @endif
                @if (canEnter('/om/settings/grant-spacial-case'))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($grants as $grant)
                <tr>
                    <td>{{ $grant->customer ? $grant->customer->customer_number : '' }}</td>
                    <td>{{ $grant->customer ? $grant->customer->customer_name : '' }}</td>
                    <td align="center">
                        @include('shared._status_active', ['isActive' => $grant->grant_special_flag == 'Y'])
                    </td>
                    <td align="center">
                        @include('shared._status_active', ['isActive' => $grant->second_order_flag == 'Y'])
                    </td>
                    {{-- <td>{{ $grant->allowed_order_date ? date(trans('date.format-date'), strtotime($grant->allowed_order_date)) : '' }}</td> --}}
                    <td>{{ $grant->allowed_order_date ? parseToDateTh($grant->allowed_order_date) : '' }}</td>
                    @if (canEnter('/om/settings/grant-spacial-case'))
                        <td align="center">
                            <a  href="{{ route('om.settings.grant-spacial-case.edit', $grant->grant_special_id) }}" 
                                class="btn btn-warning btn-xs mr-2" 
                                size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    @endif
                    @if (canEnter('/om/settings/grant-spacial-case'))
                        <td align="center">
                            <a  href="{{ route('om.settings.grant-spacial-case.delete', $grant->grant_special_id) }}" 
                                class="btn btn-danger btn-xs mr-2" 
                                size="small">
                                <i class="fa fa-times m-r-xs"></i> ลบข้อมูล
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $grants->links() }}
</div>
