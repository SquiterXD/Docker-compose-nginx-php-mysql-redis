<table>
    <thead>
        <tr>
            <th>ปี พศ</th>
            <th>เดือน</th>
            <th>รหัสร้านค้า</th>
            <th>ชื่อร้านค้า</th>
            <th>จังหวัด</th>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th>จำนวน(มวน)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($defaultItems as $item)
            <tr>
                <td>{{ (int)($year)+543 }}</td>
                <td>{{ monthFormatThaiString( $monthNo ?? (int)date('m')) }}</td>
                <td>{{ $customer->customer_number }}</td>
                <td>{{ $customer->customer_name }}</td>
                <td></td>
                {{-- <td>{{ $item->province_name }}</td> --}}
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->report_item_display }}</td>
                <td></td>
                {{-- <td>{{ $item->quantity_cg }}</td> --}}
            </tr>
        @empty
            <tr>
                <td>{{ (int)($year)+543 }}</td>
                <td>{{ monthFormatThaiString( $monthNo ?? (int)date('m')) }}</td>
                <td>{{ $customer->customer_number }}</td>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ 'กระบี่' }}</td>
                <td>{{ '15012301' }}</td>
                <td>{{ '000887048 กรุงทอง90บุหรี่' }}</td>
                <td>{{ '100' }}</td>
            </tr>
        @endforelse
    </tbody>
</table>