
<table class="table program_info_tb" id="program_info_tb_datatable">
    <thead>
        <tr>
            {{-- <th class="text-center" width="10%">
                <div>หน่วยงาน</div>
            </th> --}}
            <th class="text-center">
                <div>สถานะการใช้งาน</div>
            </th>
            <th class="text-center">
                <div>คลังสำหรับทำรายการ</div>
            </th>
            <th class="text-center">
                <div>ประเภท สินค้า</div>
            </th>
            <th class="text-center">
                <div>ต้นทาง</div>
                <div><small>Organization</small></div>
            </th>
            <th class="text-center">
                <div><br></div>
                <div><small>คลังจัดเก็บ</small></div>
            </th>
            <th class="text-center">
                <div><br></div>
                <div><small>สถานที่จัดเก็บ</small></div>
            </th>
            <th class="text-center">
                <div>ปลายทาง</div>
                <div><small>Organization</small></div>
            </th>
            <th class="text-center">
                <div><br></div>
                <div><small>คลังจัดเก็บ</small></div>
            </th>
            <th class="text-center">
                <div><br></div>
                <div><small>สถานที่จัดเก็บ</small></div>
            </th>
            <th class="text-left">
                <div>Transaction Type</div>
            </th>
            {{-- <th class="text-center" width="10%">
                <div>วันที่เริ่มต้น</div>
            </th>  
            <th class="text-center" width="10%">
                <div>วันที่สิ้นสุด</div>
            </th> --}}
            @if ($organizationId == '174')
                <th class="text-center">
                    <div>ประเภทวัตถุดิบ</div>
                </th>
            @endif
            <th class="text-center">
            </th>
        </tr>
    </thead>
    <tbody>
        {{-- @if (count($setupMfgDeprtments) > 0)
            @foreach ($setupMfgDeprtments as $setupMfgDeprtment)
                <tr>
                    <td class="text-center">@include('shared._status_active', [
                        'isActive' => $setupMfgDeprtment->enable_flag == 'Y' ? true : false,
                    ])</td>
                    <td class="text-center">{{ $setupMfgDeprtment->wip_transaction_type_name2 }}</td>
                    <td class="text-left">{{ $setupMfgDeprtment->tobacco_group }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->from_organization_code }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->from_subinventory }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->from_location_code }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->to_organization_code }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->to_subinventory }}</td>
                    <td class="text-center">{{ $setupMfgDeprtment->to_locator_code }}</td>
                    <td class="text-left">{{ $setupMfgDeprtment->transaction_type_name }}</td>
                   
                    @if ($organizationId == '174')
                        <td class="text-center">{{ $setupMfgDeprtment->itemTypeTH }}</td>
                    @endif
                    <td>
                        <a href="{{ route('pm.settings.org-tranfer.edit', $setupMfgDeprtment->id) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> แก้ไข
                        </a>
                    </td>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="11">
                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                </td>
            </tr>
        @endif --}}
    </tbody>
</table>
