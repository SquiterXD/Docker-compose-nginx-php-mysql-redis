<div style="min-height: 400px; max-height: 400px;">

    <table width="100%" border="1" style="font-size: 15px;">
        <thead>
            <tr>					
                <th width="30%" class="text-center"> 
                    รายการ
                </th>
                <th width="20%" class="text-center"> 
                    ปริมาณที่ใช้
                </th>
                {{-- <th width="20%" class="text-center"> 
                    ราคามาตรฐาน
                </th> --}}
                <td colspan="2" width="20%" class="text-center"> 
                    ต้นทุนมาตรฐาน
                </th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td colspan="4" class="text-left tw-px-1"> 
                    ต้นทุนวัตถุดิบมาตรฐาน
                </td>
            </tr>

            @foreach($filteredReportItems as $rptItem)
        
            <tr>
                <td class="text-left tw-px-1"> 
                    <div style="padding-left: 20px;"> {{ $rptItem->item_category_desc }} </div>
                </td>
                <td class="text-right tw-px-1"> 
                    {{ $rptItem->sum_quantity_used ? number_format($rptItem->sum_quantity_used, 9) : "0.000000000" }}
                </td>
                {{-- <td class="text-right tw-px-1"> 
                    {{ $rptItem->sum_std_cost_rate ? number_format($rptItem->sum_std_cost_rate, 9) : "0.000000000" }}
                </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $rptItem->sum_std_cost_amount ? number_format($rptItem->sum_std_cost_amount, 9) : "0.000000000" }}
                </td>
            </tr>

            @endforeach

            <tr>
                <td class="text-right tw-px-1"> 
                    <div style="padding-right: 20px;"> รวมต้นทุนวัตถุดิบ </div>
                </td>
                <td class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["sum_quantity_used"] ? number_format($reportProductGroupItem["sum_quantity_used"], 9) : "0.000000000" }}
                </td>
                {{-- <td class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["sum_std_cost_rate"] ? number_format($reportProductGroupItem["sum_std_cost_rate"], 9) : "0.000000000" }}
                </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["sum_std_cost_amount"] ? number_format($reportProductGroupItem["sum_std_cost_amount"], 9) : "0.000000000" }}
                </td>
            </tr>

            <tr>
                <td class="text-left tw-px-1 tw-font-bold"> 
                    ค่าแรง (100%)
                </td>
                <td class="text-right tw-px-1"> </td>
                {{-- <td class="text-right tw-px-1"> </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["wage_cost"] ? number_format($reportProductGroupItem["wage_cost"], 9) : "0.000000000" }}
                </td>
            </tr>
            <tr>
                <td class="text-left tw-px-1 tw-font-bold"> 
                    ค่าใช้จ่ายผลิตผันแปร (100%)
                </td>
                <td class="text-right tw-px-1"> </td>
                {{-- <td class="text-right tw-px-1"> </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["vary_cost"] ? number_format($reportProductGroupItem["vary_cost"], 9) : "0.000000000" }}
                </td>
            </tr>
            <tr>
                <td class="text-left tw-px-1 tw-font-bold"> 
                    ค่าใช้จ่ายผลิตคงที่ (100%)
                </td>
                <td class="text-right tw-px-1"> </td>
                {{-- <td class="text-right tw-px-1"> </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["fixed_cost"] ? number_format($reportProductGroupItem["fixed_cost"], 9) : "0.000000000" }}
                </td>
            </tr>
            <tr>
                <td class="text-left tw-px-1 tw-font-bold"> 
                    รวมต้นทุนตามผลิตภัณฑ์
                </td>
                <td class="text-right tw-px-1"> </td>
                {{-- <td class="text-right tw-px-1"> </td> --}}
                <td colspan="2" class="text-right tw-px-1"> 
                    {{ $reportProductGroupItem["total_cost"] ? number_format($reportProductGroupItem["total_cost"], 9) : "0.000000000" }}
                </td>
            </tr>

        </tbody>

    </table>

</div>