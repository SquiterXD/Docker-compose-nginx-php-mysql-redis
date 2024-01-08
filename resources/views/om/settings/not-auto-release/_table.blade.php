<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">รหัสร้านค้า</th>
                <th class="text-center">ชื่อร้านค้า</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                @if (canEnter('/om/settings/not-auto-release'))
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($notAutoReleases as $notAutoRelease)
                <tr>
                    <td>{{ $notAutoRelease->customer->customer_number }}</td>
                    <td>{{ $notAutoRelease->customer->customer_name }}</td>
                    <td>
                        {{ $notAutoRelease->start_date ? parseToDateTh($notAutoRelease->start_date) : '' }}
                    </td>
                    <td>
                        {{ $notAutoRelease->end_date   ? parseToDateTh($notAutoRelease->end_date)   : '' }}
                    </td>
                    @if (canEnter('/om/settings/not-auto-release'))
                        <td align="center">
                            <a href="{{ route('om.settings.not-auto-release.edit', $notAutoRelease->release_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
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
    {{ $notAutoReleases->links() }}
</div>
