<div class="table-responsive m-t">
    <table class="table text-nowrap table-bordered table-hover">
        <thead>
            <tr>
                <th  class="text-center"> รหัสวัตถุดิบ </th>
                <th  class="text-center"> รายละเอียด </th>
                <th  class="text-center"> Lot </th>
                <th  class="text-center"> ต้นทุนต่อหน่วย (บาท) </th>
                <th  class="text-center"> ปริมาณที่ใช้ (กก.) </th>
                <th  class="text-center"> หน่วย </th>
                <th  class="text-center"> ปรับราคา (%) </th>
                <th  class="text-center"> ราคาปรับลด/เพื่ม (บาท) </th>
                <th  class="text-center"> ต้นทุนหลังปรับราคา (บาท) </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($set1 as $key => $data)
            <tr>
                <td>{{ $data->item_code }}</td>
                <td>{{ $data->item_desc }}</td>
                <td>{{ $data->lot_number }}</td>
                <td class="text-right">{{ number_format($data->unit_cost ?? 0, 4) }}</td>
                <td class="text-right">{{ number_format($data->quantity_used ?? 0, 2) }}</td>
                <td class="text-center">{{ $data->uom }}</td>
                <td class="text-right">{{ number_format($data->price_adjus ?? 0, 2) }}</td>
                <td class="text-right">{{ number_format($data->price_reduc_increase ?? 0, 2) }}</td>
                <td class="text-right">{{ number_format($data->cost_after_price_adjus ?? 0, 4) }}</td>
            </tr>
            @endforeach
            <tr>
                <td class="text-right" colspan="7"><strong>รวมต้นทุนทั้งหมด</strong></td>
                <td class="text-right">-</td>
                <td class="text-right">{{ number_format($set1->sum('price_reduc_increase') ?? 0, 4) }}</td>
            </tr>
        </tbody>
    </table>

    @if (count($set2))
    <br>
    <h4>
        อ้างอิงต้นทุนมวน <span class="text-muted">{{ $set2->first()->product_item_number }} {{ $set2->first()->product_item_desc }}</span>
    </h4>
        <table class="table text-nowrap table-bordered table-hover">
            <thead>
                <tr>
                    <th  class="text-center"> รหัสวัตถุดิบ </th>
                    <th  class="text-center"> รายละเอียด </th>
                    <th  class="text-center"> ปริมาณที่ใช้สำหรับ 1 พันมวน </th>
                    <th  class="text-center"> หน่วย </th>
                    <th  class="text-center"> ต้นทุนต่อ 1 พันมวน (บาท) </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($set2 as $key => $data)
                <tr>
                    <td>{{ $data->item_number }}</td>
                    <td>{{ $data->item_desc }}</td>
                    <td class="text-right">{{ number_format($data->quantity_used ?? 0, 2) }}</td>
                    <td  class="text-center">{{ $data->uom_code }}</td>
                    <td class="text-right">{{ number_format($data->std_cost_amount ?? 0, 4) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-right" ></td>
                    <td class="text-right" ><strong>ต้นทุนค่าแรง</strong></td>
                    <td class="text-right" ></td>
                    <td class="text-right" ></td>
                    <td class="text-right">{{ number_format($set2->first()->wage_cost ?? 0, 4) }}</td>
                </tr>
                <tr>
                    <td class="text-right" ></td>
                    <td class="text-right" ><strong>ต้นทุนผันแปร</strong></td>
                    <td class="text-right" ></td>
                    <td class="text-right" ></td>
                    <td class="text-right">{{ number_format($set2->first()->vary_cost ?? 0, 4) }}</td>
                </tr>
                <tr>
                    <td class="text-right" ></td>
                    <td class="text-right" ><strong>ต้นทุนคงที่</strong></td>
                    <td class="text-right" ></td>
                    <td class="text-right" ></td>
                    <td class="text-right">{{ number_format($set2->first()->fixed_cost ?? 0, 4) }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="4"><strong>รวมต้นทุนต่อ 1 พันมวน</strong></td>
                    <td class="text-right">{{ number_format($set2->sum('std_cost_amount') ?? 0, 4) }}</td>
                </tr>
            </tbody>
        </table>
        {{-- expr --}}
    @endif
</div>




