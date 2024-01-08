<table>
    <thead>
      <tr>
        <th style="text-align: center;">ปี</th>
        <th style="text-align: center;">ชื่อสินค้า</th>
        <th style="text-align: center;">จำนวน</th>
        <th style="text-align: center;">รหัสหน่วยนับ</th>
        <th style="text-align: center;">ชื่อหน่วยนับ</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($data as $value )
            <tr>
                <td style="text-align: right;"> {{ $value->year_budet }} </td>
                <td style="text-align: left;"> {{ $value->ecom_item_description }} </td>
                <td style="text-align: right;"> {{ $value->total }} </td>
                <td style="text-align: left;"> {{ $value->select_uom_code }} </td>
                <td style="text-align: left;"> {{ $value->select_uom }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
