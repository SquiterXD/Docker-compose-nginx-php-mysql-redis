<div class="table-responsive">
    <table class="table text-center" id="max-storage-datatable">
        <thead>
            <tr>
                <th class="text-center">สถานะการใช้งาน</th>
                <th class="text-center">ประเภทวัตถุดิบ</th>
                <th class="text-center">จำนวนพัสดุต่อพื้นที่</th>
                <th class="text-center">หน่วยนับ</th>
                <th class="text-center">Organization</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($maxStorages as $maxStorage)
                <tr>
                    <td align="center"> 
                        @include('shared._status_active', ['isActive' => $maxStorage->enable_flag == 'Y'])
                    </td>
                    <td>{{ $maxStorage->itemGroup ? $maxStorage->itemGroup->item_cat_segment2_desc : '' }}</td>
                    <td  align="center">{{ $maxStorage->max_qty }}</td>
                    <td>{{ $maxStorage->uom ? $maxStorage->uom->unit_of_measure : '' }}</td>
                    <td>{{ $maxStorage->organization ? $maxStorage->organization->organization_code . ' : ' . $maxStorage->organization->organization_name : '' }}</td>
                    <td class="text-center">
                        @if ($maxStorage->id)
                            <a href="{{ route('pm.settings.max-storage.edit', $maxStorage->id) }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{-- {{ $maxStorages->links() }} --}}
</div>