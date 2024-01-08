<table>				
    <thead>
        <tr>					
            <th width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รายการ
            </th>
            <th width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ปริมาณที่ใช้
            </th>
            {{-- <th width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ราคามาตรฐาน
            </th> --}}
            <th colspan="2" width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ต้นทุนมาตรฐาน
            </th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="4" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ต้นทุนวัตถุดิบมาตรฐาน
            </td>
        </tr>

        @foreach($filteredReportItems as $rptItem)
    
        <tr>
            <td width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: left; paddind-left: 10px;"> 
                {{ $rptItem->item_category_desc }}
            </td>
            <td width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $rptItem->sum_quantity_used ? number_format($rptItem->sum_quantity_used, 9) : "0.000000000" }}
            </td>
            {{-- <td width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $rptItem->sum_std_cost_rate ? number_format($rptItem->sum_std_cost_rate, 9) : "0.000000000" }}
            </td> --}}
            <td colspan="2" width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $rptItem->sum_std_cost_amount ? number_format($rptItem->sum_std_cost_amount, 9) : "0.000000000" }}
            </td>
        </tr>

        @endforeach

        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right; paddind-right: 10px;"> 
                รวมต้นทุนวัตถุดิบ
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["sum_quantity_used"] ? number_format($reportProductGroupItem["sum_quantity_used"], 9) : "0.000000000" }}
            </td>
            {{-- <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["sum_std_cost_rate"] ? number_format($reportProductGroupItem["sum_std_cost_rate"], 9) : "0.000000000" }}
            </td> --}}
            <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["sum_std_cost_amount"] ? number_format($reportProductGroupItem["sum_std_cost_amount"], 9) : "0.000000000" }}
            </td>
        </tr>

        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ค่าแรง (100%)
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            {{-- <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td> --}}
            <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["wage_cost"] ? number_format($reportProductGroupItem["wage_cost"], 9) : "0.000000000" }}
            </td>
        </tr>
        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ค่าใช้จ่ายผลิตผันแปร (100%)
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            {{-- <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td> --}}
            <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["vary_cost"] ? number_format($reportProductGroupItem["vary_cost"], 9) : "0.000000000" }}
            </td>
        </tr>
        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ค่าใช้จ่ายผลิตคงที่ (100%)
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            {{-- <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td> --}}
            <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["fixed_cost"] ? number_format($reportProductGroupItem["fixed_cost"], 9) : "0.000000000" }}
            </td>
        </tr>
        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                รวมต้นทุนตามผลิตภัณฑ์
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            {{-- <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td> --}}
            <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["total_cost"] ? number_format($reportProductGroupItem["total_cost"], 9) : "0.000000000" }}
            </td>
        </tr>

    </tbody>
</table>