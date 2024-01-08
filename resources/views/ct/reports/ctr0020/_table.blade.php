@foreach($accountTypes as $accountType)

    <?php 

        $filteredAccTypeReportItems = [];
        foreach($filteredReportItems as $filteredReportItem) {
            if($filteredReportItem["account_type"] == $accountType["account_type"]) {
                $filteredAccTypeReportItems[] = $filteredReportItem;
            }
        }

        $filteredAccTypeTargetAccountCodes = [];
        foreach($filteredTargetAccountCodes as $filteredTargetAccountCode) {
            if($filteredTargetAccountCode["account_type"] == $accountType["account_type"]) {
                $filteredAccTypeTargetAccountCodes[] = $filteredTargetAccountCode;
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
                <th width="20" colspan="{{ 3 + (count($filteredTargetCodes)*2) + 2 }}" style="height: 20px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                    {{ $accountType["account_type_desc"] }}
                </th>
            </tr>
            <tr>
                <th colspan="2" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: left;"> 
                    ค่าใช้จ่าย
                </th>
                <th width="20" rowspan="2" style="height: 60px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                    เกณฑ์การปันส่วน
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

            @foreach($filteredTargetAccountCodes as $targetAccountCode)

                <?php 
                    $foundReportAccountItem = false;
                    foreach($filteredTargetCodes as $targetCode) {
                        if(count($filteredAccTypeReportAccountItems) > 0) {
                            foreach($filteredAccTypeReportAccountItems as $reportAccountItem) {
                                if($targetAccountCode["target_account_code"] == $reportAccountItem['target_account_code'] && $targetCode['target_code'] == $reportAccountItem['target_code']) {
                                    $foundReportAccountItem = true;
                                }
                            }
                        }
                    }
                ?>

                @if($foundReportAccountItem)

                    <tr>
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-right: 1px solid #ffffff; font-size: 14px; text-align: center;"> 
                            {{ $targetAccountCode["target_account_code"] }}
                        </td>
                        <td width="30" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-left: 1px solid #ffffff; font-size: 14px; text-align: left;"> 
                            {{ $targetAccountCode["target_account_code_desc"] }}
                        </td>
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px;"> 
                            {{ count($filteredAccTypeReportItems) > 0 ? $filteredAccTypeReportItems[0]["allocate_type_desc"] : "" }}
                        </td>
    
                        @foreach($filteredTargetCodes as $targetCode)
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            @if(count($filteredAccTypeReportAccountItems) > 0)
                                @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                    @if($targetAccountCode["target_account_code"] == $reportAccountItem['target_account_code'] && $targetCode['target_code'] == $reportAccountItem['target_code'])
                                        {{ $reportAccountItem['ratio_rate'] != null ? sprintf("%'04.2f", $reportAccountItem['ratio_rate']) : "-" }}
                                    @endif
                                @endforeach
                            @else
                                0.00
                            @endif
                        </td>    
                        @endforeach
    
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            100.00
                        </td>
    
                        @foreach($filteredTargetCodes as $targetCode)
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                            @if(count($filteredAccTypeReportAccountItems) > 0)
                                @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                @if($targetAccountCode["target_account_code"] == $reportAccountItem['target_account_code'] && $targetCode['target_code'] == $reportAccountItem['target_code'])
                                        {{ $reportAccountItem['estimate_expense_amount'] != null ? number_format($reportAccountItem['estimate_expense_amount'], 2) : "-" }}
                                    @endif
                                @endforeach
                            @else
                                0
                            @endif
                        </td>    
                        @endforeach
    
                        <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        @if(count($filteredTargetCodes) > 0)
                            @foreach($filteredAccTypeReportAccountItems as $reportAccountItem)
                                @if($reportAccountItem['target_account_code'] == $targetAccountCode["target_account_code"] && $filteredTargetCodes[0]['target_code'] == $reportAccountItem['target_code'])
                                    {{ $targetAccountCode["estimate_expense_amount"] != null ? number_format($targetAccountCode["estimate_expense_amount"], 2) : "-" }}
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

                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>
                
                @foreach($filteredTargetCodes as $targetCode)
                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                </td>    
                @endforeach

                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px;"> 
                    
                </td>

                @foreach($filteredTargetCodes as $targetCode)
                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @if(count($filteredAccTypeReportItems) > 0)
                        @foreach($filteredAccTypeReportItems as $filteredAccTypeReportItem)
                            @if($targetCode['target_code'] == $filteredAccTypeReportItem['target_code'])
                                {{ $filteredAccTypeReportItem['estimate_expense_amount'] != null ? number_format($filteredAccTypeReportItem['estimate_expense_amount'], 2) : "-" }}
                            @endif
                        @endforeach
                    @else
                        0
                    @endif
                </td>    
                @endforeach

                <td width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    @foreach($filteredAgcAccountTypes as $agcAccountType)
                        @if($agcAccountType['account_type'] == $accountType["account_type"])
                            {{ $agcAccountType["estimate_expense_amount"] != null ? number_format($agcAccountType["estimate_expense_amount"], 2) : "-" }}
                        @endif
                    @endforeach
                </td>

            </tr>
        </tbody>
    </table>

@endforeach