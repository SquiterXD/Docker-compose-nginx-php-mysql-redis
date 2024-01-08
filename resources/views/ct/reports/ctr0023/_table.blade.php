<table>				
    <thead>
        <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รหัสวัตถุดิบ
            </th>
            <th width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                วัตถุดิบ
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                หน่วย
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ปริมาณ
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ราคาต่อหน่วย
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ต้นทุนวัตถุดิบ
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($filteredRptProductGroupItemWipSteps as $filteredRptProductGroupItemWipStep)
        <tr>
            <td colspan="6" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                ขั้นตอน : {{ $filteredRptProductGroupItemWipStep["wip_step_number"] }} {{ $filteredRptProductGroupItemWipStep["wip_step_desc"] }}
            </td>
        </tr>

            <?php 

                $rptProductGroupItemCategories = [];
                foreach($filteredRptProductGroupItemCategories as $filteredRptProductGroupItemCategory) {
                    if($filteredRptProductGroupItemCategory["wip_step"] == $filteredRptProductGroupItemWipStep["wip_step"]) {
                        $rptProductGroupItemCategories[] = $filteredRptProductGroupItemCategory;
                    }
                }

            ?>
            @foreach($rptProductGroupItemCategories as $rptProductGroupItemCategory)
            
            <tr>
                <td colspan="6" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                    {{ $rptProductGroupItemCategory["item_category_number"] }} {{ $rptProductGroupItemCategory["item_category_desc"] }}
                </td>
            </tr>

                <?php 

                    $rptItems = [];
                    foreach($filteredReportItems as $filteredReportItem) {
                        if($filteredReportItem["wip_step"] == $filteredRptProductGroupItemWipStep["wip_step"] && $filteredReportItem["item_category_number"] == $rptProductGroupItemCategory["item_category_number"]) {
                            $rptItems[] = $filteredReportItem;
                        }
                    }

                ?>

                @foreach($rptItems as $rptItem)
            
                <tr>
                    <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;"> 
                        {{ $rptItem["item_number"] }}
                    </td>
                    <td width="40" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: left;"> 
                        {{ $rptItem["item_desc"] }}
                    </td>
                    <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;"> 
                        {{ $rptItem["uom_code"] }}
                    </td>
                    <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $rptItem["quantity_used"] ? number_format($rptItem["quantity_used"], 6) : "0.000000" }}
                    </td>
                    <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $rptItem["std_cost_rate"] ? number_format($rptItem["std_cost_rate"], 9) : "0.000000000" }}
                    </td>
                    <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $rptItem["std_cost_amount"] ? number_format($rptItem["std_cost_amount"], 9) : "0.000000000" }}
                    </td>
                </tr>

                @endforeach

            <tr>
                <td colspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                    รวมต้นทุนวัตถุดิบมาตรฐานตาม {{ $rptProductGroupItemCategory["item_category_number"] }} {{ $rptProductGroupItemCategory["item_category_desc"] }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $rptProductGroupItemCategory["quantity_used"] ? number_format($rptProductGroupItemCategory["quantity_used"], 6) : "0.000000" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    
                </td>
                <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $rptProductGroupItemCategory["std_cost_amount"] ? number_format($rptProductGroupItemCategory["std_cost_amount"], 9) : "0.000000000" }}
                </td>
            </tr>

            @endforeach

        <tr>
            <td colspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                รวมต้นทุนวัตถุดิบมาตรฐานตาม ขั้นตอน : {{ $filteredRptProductGroupItemWipStep["wip_step_number"] }} {{ $filteredRptProductGroupItemWipStep["wip_step_desc"] }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $filteredRptProductGroupItemWipStep["quantity_used"] ? number_format($filteredRptProductGroupItemWipStep["quantity_used"], 6) : "0.000000" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $filteredRptProductGroupItemWipStep["std_cost_amount"] ? number_format($filteredRptProductGroupItemWipStep["std_cost_amount"], 9) : "0.000000000" }}
            </td>
        </tr>

        @endforeach

        <tr>
            <td colspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                รวมต้นทุนวัตถุดิบมาตรฐานต่อ {{ number_format($reportProductGroupItem['cost_quantity'], 2) }} {{ $reportProductGroupItem['uom_desc'] }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["quantity_used"] ? number_format($reportProductGroupItem["quantity_used"], 6) : "0.000000" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportProductGroupItem["std_cost_amount"] ? number_format($reportProductGroupItem["std_cost_amount"], 9) : "0.000000000" }}
            </td>
        </tr>

        <tr>
            <td colspan="5" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                รวมต้นทุนวัตถุดิบมาตรฐานต่อ {{ number_format(1, 2) }} {{ $reportProductGroupItem['uom_prd'] }} 
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;">
                 
                {{ $reportProductGroupItem["std_cost_amount"] ? number_format( $reportProductGroupItem["std_cost_amount_prd"] / $reportProductGroupItem['cost_quantity_cal'] , 9) : "0.000000000" }}
            </td>
        </tr>

    </tbody>
</table>