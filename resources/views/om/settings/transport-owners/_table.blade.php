<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">เจ้าของรถขนส่ง</th>
                <th class="text-center">ชื่อเจ้าของรถขนส่ง</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                <th class="text-center">รหัสเจ้าหนี้</th>
                <th class="text-center">หยุดการใช้งาน</th>
                <th width="17%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tranSportOwners as $tranSportOwner)
                <tr>
                    <td>{{ $tranSportOwner->transport_owner_code }}</td>
                    <td>{{ $tranSportOwner->transport_owner_name }}</td>
                    <td>{{ $tranSportOwner->start_date ? parseToDateTh($tranSportOwner->start_date) : '' }}</td>
                    <td>{{ $tranSportOwner->end_date   ? parseToDateTh($tranSportOwner->end_date) : '' }}</td>
                    <td>{{ $tranSportOwner->vendor_code }}</td>
                    <td valign="center" align="center"> @include('shared._status_active', ['isActive' => $tranSportOwner->stop_flag == 'Y'])</td>
                    <td  align="center">
                        <a href="{{ route('om.settings.transport-owner.edit', $tranSportOwner->transport_owner_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>

                        {{-- <form onsubmit="return
                            confirm('Do you want to delete this item?')" action="{{ route('om.settings.transport-owner.delete', $tranSportOwner->transport_owner_id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-xs">
                                <i class="fa fa-times"></i>
                                ลบ
                            </button>
                        </form> --}}
                        {{-- <delete-item
                            :url="{{ json_encode(route('om.settings.transport-owner.delete', $tranSportOwner->transport_owner_id)) }}"
                            :url-return="{{ json_encode(route('om.settings.transport-owner.index')) }}">
                        </delete-item> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
