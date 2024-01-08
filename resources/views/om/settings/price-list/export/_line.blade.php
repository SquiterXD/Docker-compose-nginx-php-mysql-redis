<div class="table-responsive mt-4">
    <table class="table table-bordered" id="tableReimbursements">
        <thead>
            <tr>
                <th>รหัสผลิตภัณฑ์</th>
                <th>ชื่อผลิตภัณฑ์</th>
                <th>หน่วยผลิตภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>วันที่เริ่มใช้งาน</th>
                <th>วันที่สิ้นสุดการใช้งาน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($header->listLines->sortBy('product_code') as $line)
                <tr>
                    <td>{{ $line->sequenceEcom ? $line->sequenceEcom->item_code : '' }}</td>
                    <td>{{ $line->product_description }}</td>
                    <td>{{ $line->uom }}</td>
                    <td class="text-right">{{ number_format($line->value, 2) }}</td>
                    <td>
                        {{ $line->start_date ? date(trans('date.format-date'),strtotime($line->start_date)) : '' }}
                    </td>
                    <td>
                        {{ $line->end_date ? date(trans('date.format-date'),strtotime($line->end_date)) : '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>