<table>				
    <thead>
        <tr>
            <th width="20" colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; font-size: 14px; text-align: left;"> 
                กลุ่มผลิตภัณฑ์ :  {{ $reportProductGroup['product_group'] }} {{ $reportProductGroup['product_group_desc'] }}
            </th>
            <th width="20" colspan="6" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; font-size: 14px; text-align: left;"> 
                หน่วย : {{ $reportProductGroup['cost_quantity'] }} {{ $reportProductGroup['uom_desc'] }}
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ผลิตภัณฑ์
            </th>
            <th width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รายละเอียด
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ต้นทุนวัตถุดิบ
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าแรง
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายผันแปร
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายคงที่
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวมต้นทุน
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวมต้นทุน/หน่วยสต็อก
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach(collect($filteredReportItems)->sortBy('product_item_number') as $filteredReportItem)
            <tr>
                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;"> 
                    {{ $filteredReportItem->product_item_number }}
                </td>
                <td width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;"> 
                    {{ $filteredReportItem->product_item_desc }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->cost_raw_mate != null ? number_format($filteredReportItem->cost_raw_mate, 9) : "-" }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->wage_cost != null ? number_format($filteredReportItem->wage_cost, 9) : "-" }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->vary_cost != null ? number_format($filteredReportItem->vary_cost, 9) : "-" }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->fixed_cost != null ? number_format($filteredReportItem->fixed_cost, 9) : "-" }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->total_cost != null ? number_format($filteredReportItem->total_cost, 9) : "-" }}
                </td>
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $filteredReportItem->total_cost_per_unit != null ? number_format($filteredReportItem->total_cost_per_unit, 9) : "-" }}
                </td>
            </tr>
        @endforeach
    </tbody>

</table>