<table>		

    <thead>
        <tr>
            <th colspan="2" width="20" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; border-right: 1px solid #f5f5f6; font-weight: bold; font-size: 18px; text-align: center;">
                @if($allocateGroup == "DEPT")
                    หน่วยงาน ปันหน่วยงาน
                @elseif($allocateGroup == "COST")
                    หน่วยงาน ปันศูนย์ต้นทุน
                @endif
            </th>
            <th colspan="7" width="20" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; border-left: 1px solid #f5f5f6; font-weight: bold; font-size: 18px; text-align: center;">
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> หน่วยงานที่ปัน </th>
            <th width="20" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> รหัสบัญชี </th>
            <th width="30" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> ชื่อบัญชี </th>
            <th width="20" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> เกณฑ์การปันส่วน </th>
            <th width="25" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> ค่าใช้จ่ายจริง </th>
            <th width="25" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> ค่าใช้จ่ายจริงเฉลี่ย </th>
            <th width="25" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> ค่าใช้จ่ายตามงบประมาณ </th>
            <th width="25" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> ค่าใช้จ่ายประมาณการ </th>
            <th width="25" style="height: 40px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> หมายเหตุ </th>
        </tr>
    </thead>
    <tbody>
    
        @foreach($reportItems as $reportItem)

            @foreach($reportItem->account_items as $accountItem)

                <tr>

                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;">
                        {{ $reportItem->allocate_group_code }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;">
                        {{ $accountItem->target_account_code }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;">
                        {{ $accountItem->target_sub_acc_code_desc }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;">
                        {{ $accountItem->allocate_type_label }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;">
                        {{ $accountItem->actual_amount ? number_format($accountItem->actual_amount, 2) : "0.00" }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;">
                        {{ $accountItem->avg_actual_amount ? number_format($accountItem->avg_actual_amount, 2) : "0.00" }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;">
                        {{ $accountItem->budget_amount ? number_format($accountItem->budget_amount, 2) : "0.00" }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;">
                        {{ $accountItem->estimate_expense_amount ? number_format($accountItem->estimate_expense_amount, 2) : "0.00" }}
                    </td>
                    <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;">
                        {{ $accountItem->reason_name }}
                    </td>

                </tr>

            @endforeach

        @endforeach

        <tr>

            <td colspan="3" style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px;">
                @if($allocateGroup == "DEPT")
                    ประเภทการปันส่วน : 1 หน่วยงาน ปันหน่วยงาน
                @elseif($allocateGroup == "COST")
                    ประเภทการปันส่วน : 2 หน่วยงาน ปันศูนย์ต้นทุน
                @endif
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                รวม
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                {{ $reportSummaryItem->actual_amount ? number_format($reportSummaryItem->actual_amount, 2) : "0.00" }}    
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                {{ $reportSummaryItem->avg_actual_amount ? number_format($reportSummaryItem->avg_actual_amount, 2) : "0.00" }}    
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                {{ $reportSummaryItem->budget_amount ? number_format($reportSummaryItem->budget_amount, 2) : "0.00" }}    
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                {{ $reportSummaryItem->estimate_expense_amount ? number_format($reportSummaryItem->estimate_expense_amount, 2) : "0.00" }}    
            </td>
            <td style="height: 30px; background-color: #f5f5f6; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;">
                
            </td>

        </tr>
        
    </tbody>

</table>