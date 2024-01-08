
<table class="border-2">
    <thead>
    <tr>
        <th align="left" colspan="2"> <b>โปรแกรม {{ $programCode }}</b> </th>
        <th colspan="6" align="center"> <b> การยาสูบแห่งประเทศทไทย </b></th>
        <th> <b> วันที่ </b> </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th align="left" colspan="2"> </th>
        <th colspan="6" align="center"> <b> ชุดที่: {{ $loop->iteration }} {{ $policySetDes }} </b></th>
        <th> <b> เวลา </b></th>
    </tr>
    <tr>
        <th colspan="2"></th>
        <th colspan="6" align="center">  <b> ข้อมูลมูลค่าทุนประกัน(inventory) ของ </b></th>
        <th>  <b> หน้า </b> </th>
    </tr>

      @foreach ($ptirStockHeader->groupBy('sub_inventory_desc')->sortBy('sub_inventory_code') as $subInvDes => $subInvs)
        @foreach ($subInvs->groupBy('location_desc')->sortBy('location_code') as $locationDesc => $lines)
            <tr>
                <th colspan="9" align="left"><b> รหัสคลังสินค้า : {{  $subInvDes }}</b> </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="10" align="left" ><b>กลุ่มสินค้าย่อย :{{ $locationDesc }}</b>  </th>
            </tr>
            <tr>
                <th colspan="10" align="left" style=" border-bottom: 1px solid #000000" ></th>
            </tr>
            @if ($loop->first)
                <tr>
                    <td><b> รหัสพัสดุ </b></td>
                    <td><b> ชื่อพัสดุ </b></td>
                    <td><b> Organization </b></td>
                    <td><b> รหัสกลุ่มสินค้า </b></td>
                    <td><b> ชื่อกลุ่มสินค้า </b></td>
                    <td><b> ปริมาณ </b></td>
                    <td><b> หน่วย </b></td>
                    <td><b> มูลค่าสินค้า (บาท) </b></td>
                    <td><b> มูลค่าทุนประกัน (บาท) </b></td>
                </tr>
            <tr>
                <th style="border-top: 1px solid #000000" colspan="10" ></th>
            </tr>
            @endif
                @foreach ($lines as $line)
                    <tr>
                        <td>{{ $line->item_code }}</td>
                        <td>{{ $line->item_description }}</td>
                        <td>{{ $line->organization_code}} :  {{ $line->lineView->organization_name }}</td>
                        <td>{{ $line->item_code }}</td>
                        <td>{{ $line->item_description }}</td>
                        <td>{{  number_format($line->original_quantity, 2)  }}</td>
                        <td>{{ $line->uom_code }}</td>
                        <td>{{ number_format($line->line_amount , 2) }}</td>
                        <td>{{ number_format($line->coverage_amount , 2)  }}</td>
                    </tr>
                    {{-- @if ($loop->last)
                        <tr>
                            <th style="border-top: 1px solid #000000" colspan="10" ></th>
                        </tr>
                    @endif --}}
                @endforeach
        @endforeach
        @if ($loop->last)
        <tr>
            <td colspan="5" align="center">รวม</td>
            <td>{{ number_format($ptirStockHeader->sum('original_quantity'), 2) }}</td>
            <td></td>
            <td>{{ number_format($ptirStockHeader->sum('line_amount'), 2)  }}</td>
            <td>{{ number_format($ptirStockHeader->sum('coverage_amount'), 2)  }}</td>
        </tr>
        <tr>
            <th style="border-top: 1px solid #000000" colspan="10" ></th>
        </tr>
    @endif
      @endforeach
    </tbody>
    </table>
