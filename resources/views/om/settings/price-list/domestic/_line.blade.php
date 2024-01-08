<div class="table-responsive mt-4">
    <table class="table table-bordered" id="tableReimbursements">
        <thead>
            <tr>
                <th class="text-center">รหัสผลิตภัณฑ์</th>
                <th class="text-center">ชื่อผลิตภัณฑ์</th>
                <th class="text-center">หน่วยผลิตภัณฑ์</th>
                <th class="text-center">ราคาต่อหน่วย</th>
                <th class="text-center">วันที่เริ่มใช้งาน</th>
                <th class="text-center">วันที่สิ้นสุดการใช้งาน</th>
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
                        {{ $line->start_date ? parseToDateTh($line->start_date) : '' }}
                        {{-- {{ $line->start_date ? date(trans('date.format-date'),strtotime($line->start_date)) : '' }} --}}
                    </td>
                    <td>
                        {{ $line->end_date ? parseToDateTh($line->end_date) : '' }}
                        {{-- {{ $line->end_date ? date(trans('date.format-date'),strtotime($line->end_date)) : '' }} --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>