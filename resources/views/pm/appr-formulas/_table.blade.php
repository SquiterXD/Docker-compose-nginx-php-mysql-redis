<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">รหัสสินค้า</th>
                <th class="text-center"><div style="width: 200px;">ชื่อสินค้า</div></th>
                <th class="text-center"><div style="width: 80px;">ประเภทสูตร</div></th>
                <th class="text-center">Version</th>
                <th class="text-center"><div style="width: 80px;">สถานะ</div></th>
                <th class="text-center"><div style="width: 80px;">ประเภทเครื่องจักร</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่สร้าง</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่เริ่มใช้งาน</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่สิ้นสุดใช้งาน</div></th>
                <th><div style="width: 100px;"></div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($headers as $header)
                <tr>
                    <td>
                        <input type="checkbox" name="" value="" placeholder="">
                    </td>
                    <td>
                        {{ $header->item ?  $header->item->item_number : '' }}
                    </td>
                    <td>
                        {{ $header->item ?  $header->item->item_desc : ''}}
                    </td>
                    <td>
                        {{ $header->folmula_type }}
                    </td>
                    <td align="center">
                        {{ $header->version }}
                    </td>
                    <td align="center">
                        รออนุมัติ
                    </td>
                    <td>
                        {{ $header->machineType  ? $header->machineType->description : '' }}
                    </td>
                    <td align="center">
                        {{ $header->created_at ? parseToDateTh($header->created_at) : '' }}
                    </td>
                    <td align="center">
                        {{ $header->start_date ? parseToDateTh($header->start_date) : '' }}
                    </td>
                    <td align="center">
                        {{ $header->end_date ? parseToDateTh($header->end_date) : '' }}
                    </td>
                    <td class="text-center">
                        @if ($header->ingredient_id)
                            <a href="{{ route('pm.appr-formulas.show', $header->ingredient_id) }}" class="btn btn-white btn-xs">
                                <i class="fa fa-file-text-o"></i> รายละเอียด
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $headers->links() }}
</div>
