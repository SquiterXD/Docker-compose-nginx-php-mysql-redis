<table>
    <thead>
      <tr>
        <th>บริษัท</th>
        <th>ชื่อสินค้า</th>
        <th>จำนวน</th>
        <th>รหัสหน่วยนับ</th>
        <th>หน่วยนับ</th>
        <th>ประเภทสินค้า</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($data as $value)
            <tr>
                <td style="text-align: left;"> {{ $value->customer_name }} </td>
                <td style="text-align: left;"> {{ $value->ecom_item_description }} </td>
                <td style="text-align: right;"> {{ $value->total }} </td>
                <td style="text-align: left;"> {{ $value->select_uom_code }}</td>
                <td style="text-align: left;"> {{ $value->select_uom }}</td>
                <td style="text-align: left;"> {{ $value->description }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
