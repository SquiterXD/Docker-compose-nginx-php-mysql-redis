<table>				
    <thead>
        <tr>
            <th colspan="2" width="20" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ค่าใช้จ่าย
            </th>
            <th width="20" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                เกณฑ์การปันส่วน
            </th>
            <th width="20" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                จำนวนเงิน (บาท)
            </th>
            <th width="20" colspan="{{ count($filteredTargetCodes) + 1 }}" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                สัดส่วนการปัน ( % )				
            </th>
            <th width="20" colspan="{{ count($filteredTargetCodes) + 1}}" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายปันส่วน ( บาท )
            </th>
        </tr>
        <tr>
            @foreach($filteredTargetCodes as $targetCode)
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                {{ $targetCode['target_code_desc'] }}
            </th>    
            @endforeach
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวม
            </th>
            @foreach($filteredTargetCodes as $targetCode)
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                {{ $targetCode['target_code_desc'] }}
            </th>    
            @endforeach
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวม
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;"> 
                {{ $allocateGroupCode["allocate_group_code_label"] }}
            </td>
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;"> 
                {{ count($filteredReportItems) > 0 ? $filteredReportItems[0]["allocate_type_desc"] : "" }}
            </td>
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ number_format($allocateGroupCode["estimate_expense_amount"], 2) }}
            </td>
            @foreach($filteredTargetCodes as $targetCode)
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                @foreach($filteredReportItems as $filteredReportItem)
                    @if($targetCode['target_code'] == $filteredReportItem['target_code'])
                        {{ $filteredReportItem['ratio_rate'] != null ? sprintf("%'04.2f", $filteredReportItem['ratio_rate']) : "-" }}
                    @endif
                @endforeach
            </td>    
            @endforeach
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                100.00
            </td>
            @foreach($filteredTargetCodes as $targetCode)
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                @foreach($filteredReportItems as $filteredReportItem)
                    @if($targetCode['target_code'] == $filteredReportItem['target_code'])
                        {{ number_format($filteredReportItem['estimate_expense_amount'], 2) }}
                    @endif
                @endforeach
            </td>    
            @endforeach
            <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ number_format($allocateGroupCode["estimate_expense_amount"], 2) }}
            </td>
        </tr>
    </tbody>
</table>