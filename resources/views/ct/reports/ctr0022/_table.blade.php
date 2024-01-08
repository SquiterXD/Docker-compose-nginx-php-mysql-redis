@foreach($accountTypes as $accountType)

    <?php 

        $filteredAccTypeReportItems = [];
        foreach($filteredReportItems as $filteredReportItem) {
            if($filteredReportItem["account_type"] == $accountType["account_type"]) {
                $filteredAccTypeReportItems[] = $filteredReportItem;
            }
        }

        $filteredAccTypeReportAccountItems = [];
        foreach($filteredReportAccountItems as $filteredReportAccountItem) {
            if($filteredReportAccountItem["account_type"] == $accountType["account_type"]) {
                $filteredAccTypeReportAccountItems[] = $filteredReportAccountItem;
            }
        }

    ?>

    <table>				
        <thead>
            <tr>
                <th width="25" colspan="{{ 3 + (count($filteredRptProductGroups)*2) + 2 }}" style="height: 20px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                    {{ $accountType["account_type_desc"] }}
                </th>
            </tr>
            <tr>
                <th width="20" colspan="2" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                    ค่าใช้จ่าย
                </th>
                <th width="25" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    เกณฑ์การปันส่วน
                </th>
                <th width="25" colspan="{{ count($filteredRptProductGroups) + 1 }}" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    สัดส่วนการปัน ( % )				
                </th>
                <th width="25" colspan="{{ count($filteredRptProductGroups) + 1}}" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    ค่าใช้จ่ายปันส่วน ( บาท )
                </th>
            </tr>
            <tr>
                @foreach($filteredRptProductGroups as $rptProductGroup)
                <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    {{ $rptProductGroup['product_group_desc'] }}
                </th>    
                @endforeach
                <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    รวม
                </th>
                @foreach($filteredRptProductGroups as $rptProductGroup)
                <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    {{ $rptProductGroup['product_group_desc'] }}
                </th>    
                @endforeach
                <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    รวม
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($filteredRptAccountCodes as $reportAccountCode)

                <?php 
                    $foundReportAccountItem = false;
                    foreach($filteredRptProductGroups as $rptProductGroup) {
                        if(count($filteredAccTypeReportAccountItems) > 0) {
                            foreach($filteredAccTypeReportAccountItems as $reportAccountItem) {
                                if($reportAccountCode["account_code"] == $reportAccountItem['account_code'] && $rptProductGroup['product_group'] == $reportAccountItem['product_group']) {
                                    $foundReportAccountItem = true;
                                }
                            }
                        }
                    }
                ?>

                @if($foundReportAccountItem)

                    <tr>
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-right: 1px solid #ffffff; font-size: 14px; text-align: center;"> 
                            {{ $reportAccountCode["account_code"] }}
                        </td>
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-left: 1px solid #ffffff; font-size: 14px; text-align: left;"> 
                            {{ $reportAccountCode["account_code_desc"] }}
                        </td>
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;"> 
                            {{ count($filteredAccTypeReportItems) > 0 ? $filteredAccTypeReportItems[0]["allocate_type_desc"] : "" }}
                        </td>
    
                        @foreach($filteredRptProductGroups as $rptProductGroup)
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            @if(count($filteredAccTypeReportAccountItems) > 0)
                                @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                    @if($reportAccountCode["account_code"] == $reportAccountItem['account_code'] && $rptProductGroup['product_group'] == $reportAccountItem['product_group'])
                                        {{ $reportAccountItem['ratio_rate'] != null ? sprintf("%'04.2f", $reportAccountItem['ratio_rate']) : "-" }}
                                    @endif
                                @endforeach
                            @else
                                0.00
                            @endif
                        </td>    
                        @endforeach
    
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            100.00
                        </td>
    
                        @foreach($filteredRptProductGroups as $rptProductGroup)
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            @if(count($filteredAccTypeReportAccountItems) > 0)
                                @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                @if($reportAccountCode["account_code"] == $reportAccountItem['account_code'] && $rptProductGroup['product_group'] == $reportAccountItem['product_group'])
                                        {{ number_format($reportAccountItem['prd_estimate_expense_amount'], 2) }}
                                    @endif
                                @endforeach
                            @else
                                0.00
                            @endif
                        </td>    
                        @endforeach
    
                        <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        @if(count($filteredRptProductGroups) > 0)
                            @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                @if($reportAccountCode["account_code"] == $reportAccountItem['account_code'] && $filteredRptProductGroups[0]['product_group'] == $reportAccountItem['product_group'])
                                    {{ number_format($reportAccountCode["prd_estimate_expense_amount"], 2) }}
                                @endif
                            @endforeach
                        @endif
                        </td>
    
                    </tr>

                @endif
                
            @endforeach
            
            <tr>

                <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    รวม {{ $accountType["account_type_desc"] }}
                </td>

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>
                
                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>

                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @if(count($filteredAccTypeReportItems) > 0)
                        @foreach($filteredAccTypeReportItems as $filteredAccTypeReportItem)
                            @if($rptProductGroup['product_group'] == $filteredAccTypeReportItem['product_group'])
                                {{ number_format($filteredAccTypeReportItem['prd_estimate_expense_amount'], 3) }}
                            @endif
                        @endforeach
                    @else
                        0.000
                    @endif
                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @foreach($filteredRptCostCodeAccTypes as $reportCostCodeAccType)
                        @if($reportCostCodeAccType['account_type'] == $accountType["account_type"])
                            {{ number_format($reportCostCodeAccType["prd_estimate_expense_amount"], 3) }}
                        @endif
                    @endforeach
                </td>

            </tr>

            <tr>

                <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    @foreach($filteredRptCostCodeAccTypes as $reportCostCodeAccType)
                        @if($reportCostCodeAccType['account_type'] == $accountType["account_type"])
                            ปริมาณการผลิตมาตรฐาน ( {{ number_format($reportCostCodeAccType["cost_quantity"], 2) }} {{ $reportCostCodeAccType["uom_desc"] }} )
                        @endif
                    @endforeach
                </td>

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>
                
                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>

                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @if(count($filteredAccTypeReportItems) > 0)
                        @foreach($filteredAccTypeReportItems as $filteredAccTypeReportItem)
                            @if($rptProductGroup['product_group'] == $filteredAccTypeReportItem['product_group'])
                                {{ number_format($filteredAccTypeReportItem['std_productivity_qty'], 3) }}
                            @endif
                        @endforeach
                    @else
                        0.000
                    @endif
                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @foreach($filteredRptCostCodeAccTypes as $reportCostCodeAccType)
                        @if($reportCostCodeAccType['account_type'] == $accountType["account_type"])
                            {{ number_format($reportCostCodeAccType["std_productivity_qty"], 3) }}
                        @endif
                    @endforeach
                </td>

            </tr>

            <tr>

                <td colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    @foreach($filteredRptCostCodeAccTypes as $reportCostCodeAccType)
                        @if($reportCostCodeAccType['account_type'] == $accountType["account_type"])
                            {{ $accountType["account_type_desc"] }} ( {{ number_format($reportCostCodeAccType["cost_quantity"], 2) }} {{ $reportCostCodeAccType["uom_desc"] }} )
                        @endif
                    @endforeach
                </td>

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>
                
                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>

                @foreach($filteredRptProductGroups as $rptProductGroup)
                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    
                    {{-- @if(count($filteredAccTypeReportItems) > 0)
                        @foreach($filteredAccTypeReportItems as $filteredAccTypeReportItem)
                            @if($rptProductGroup['product_group'] == $filteredAccTypeReportItem['product_group'])
                                {{ floatval($filteredAccTypeReportItem['std_productivity_qty']) > 0 ? number_format(floatval($filteredAccTypeReportItem['prd_estimate_expense_amount']) / floatval($filteredAccTypeReportItem['std_productivity_qty']), 3) : "0.000" }}
                            @endif
                        @endforeach
                    @else
                        0.000
                    @endif --}}

                </td>    
                @endforeach

                <td width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    
                    {{-- @foreach($filteredRptCostCodeAccTypes as $reportCostCodeAccType)
                        @if($reportCostCodeAccType['account_type'] == $accountType["account_type"])
                            {{ floatval($reportCostCodeAccType['std_productivity_qty']) > 0 ? number_format(floatval($reportCostCodeAccType['prd_estimate_expense_amount']) / floatval($filteredAccTypeReportItem['std_productivity_qty']), 3) : "0.000" }}
                        @endif
                    @endforeach --}}

                </td>

            </tr>

        </tbody>
    </table>

@endforeach

<table>
    <thead>
        <tr>
            <th colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                รวมทั้งสิ้น
            </th>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                
            </th>
            
            @foreach($filteredRptProductGroups as $rptProductGroup)
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
            </th>    
            @endforeach

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                
            </th>

            @foreach($filteredRptProductGroups as $rptProductGroup)
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;"> 
                {{ number_format($rptProductGroup['prd_estimate_expense_amount'], 2) }}
            </th>    
            @endforeach

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: right;"> 
                {{ number_format($reportCostCode["prd_estimate_expense_amount"], 2) }}
            </th>

        </tr>
    </thead>
</table>