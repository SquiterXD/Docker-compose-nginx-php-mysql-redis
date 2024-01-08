<table>             
    <thead>
        <tr>
            <th width="20" rowspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                รหัส
            </th>
            <th width="70" colspan="2" rowspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                รายละเอียด
            </th>
            <th width="12" rowspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                หน่วยนับ
            </th>
            <th width="20" rowspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                คำสั่งผลิต
            </th>
            <th width="20" rowspan="3" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                <p> ปริมาณผลผลิต </p>
                <p> ระหว่างผลิต (Output) </p> 
            </th>
            <th width="40" colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                ปริมาณมาตรฐาน
            </th>
            <th width="120" colspan="6" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                ต้นทุนมาตรฐาน (บาท) 
            </th>
        </tr>
        <tr>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ปริมาณ
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ราคาต่อหน่วย
            </th>
            <th width="40" colspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าวัตถุดิบ 
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าแรงงาน
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายผันแปร
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายคงที่
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวมทั้งสิ้น
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ปริมาณ 
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; border-bottom: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ต้นทุน
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportLv1Items as $index => $reportLv1Item)
            <tr>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: left;"> 
                    <b>{{ $reportLv1Item['product_item_number'] }}</b>
                </td>
                <td colspan="2" style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px;"> 
                    <b>{{ $reportLv1Item['product_item_description'] }}</b>
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    <b>{{ $reportLv1Item['product_unit_of_measure'] }}</b>
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    {{ $reportLv1Item['batch_no'] }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['transaction_quantity'] != null ? number_format($reportLv1Item['transaction_quantity'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    STD.
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['product_transaction_cost'] != null ? number_format($reportLv1Item['product_transaction_cost'], 9) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['product_wage_amount'] != null ? number_format($reportLv1Item['product_wage_amount'], 9) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['product_vary_amount'] != null ? number_format($reportLv1Item['product_vary_amount'], 9) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['product_fixed_amount'] != null ? number_format($reportLv1Item['product_fixed_amount'], 9) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ number_format($reportLv1Item['product_transaction_cost'] + $reportLv1Item['product_wage_amount'] + $reportLv1Item['product_vary_amount'] + $reportLv1Item['product_fixed_amount'], 9) }}
                </td>

            </tr>

            <?php 

                $filteredReportLv2Items = [];
                foreach($reportLv2Items as $reportLv2Item) {
                    if($reportLv2Item["product_item_number"] == $reportLv1Item["product_item_number"] && $reportLv2Item["batch_no"] == $reportLv1Item["batch_no"]) {
                        $filteredReportLv2Items[] = $reportLv2Item;
                    }
                }

            ?>
            @foreach($filteredReportLv2Items as $index => $filteredReportLv2Item)
                <tr>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                        
                    </td>
                    <td colspan="2" style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px;"> 
                        ขั้นตอนที่ {{ $filteredReportLv2Item['wip_step_no'] }} : {{ $filteredReportLv2Item['wip_description'] }}
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        <p> {{ $filteredReportLv2Item['transaction_quantity'] != null ? number_format($filteredReportLv2Item['transaction_quantity'], 2) : "-" }} </p>
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        <p> EQU. = 100 % </p>
                        <p> {{ $filteredReportLv2Item['transaction_quantity'] != null ? number_format($filteredReportLv2Item['transaction_quantity'], 2) : "-" }} </p>
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        <p> EQU. = {{ $filteredReportLv2Item['dl_absorption_rate'] }} % </p>
                        <p> {{ $filteredReportLv2Item['dl_absorption_rate'] != null ? number_format($filteredReportLv2Item['dl_absorption_rate'] * $filteredReportLv2Item['transaction_quantity'] / 100, 2) : "-" }} </p>
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        <p> EQU. = {{ $filteredReportLv2Item['voh_absorption_rate'] }} % </p>
                        <p> {{ $filteredReportLv2Item['voh_absorption_rate'] != null ? number_format($filteredReportLv2Item['voh_absorption_rate'] * $filteredReportLv2Item['transaction_quantity'] / 100, 2) : "-" }} </p>
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        <p> EQU. = {{ $filteredReportLv2Item['foh_absorption_rate'] }} % </p>
                        <p> {{ $filteredReportLv2Item['foh_absorption_rate'] != null ? number_format($filteredReportLv2Item['foh_absorption_rate'] * $filteredReportLv2Item['transaction_quantity'] / 100, 2) : "-" }} </p>
                    </td>
                    <td style="height: 60px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    
                    </td>

                </tr>

                <?php 

                    $filteredReportItems = [];
                    foreach($reportItems as $reportItem) {
                        if($reportItem["product_item_number"] == $filteredReportLv2Item["product_item_number"] && $reportItem["batch_no"] == $filteredReportLv2Item["batch_no"] && $reportItem["wip_step"] == $filteredReportLv2Item["wip_step"]) {
                            $filteredReportItems[] = $reportItem;
                        }
                    }

                ?>
                @foreach($filteredReportItems as $index => $filteredReportItem)
                    <tr>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: left;"> 
                            {{ $filteredReportItem['item_number'] }}
                        </td>
                        <td width="10" style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: none; border-top: none; border-bottom: none; font-size: 14px; text-align: left;"> 
                            
                        </td>
                        <td width="70" style="height: 30px; background-color: #ffffff; border-left: 1px solid #FFFFFF; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: left;"> 
                            {{ $filteredReportItem['item_description'] }}
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                            {{ $filteredReportItem['transaction_uom'] }}    
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 

                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 

                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                            {{ $filteredReportItem['ing_std_quantity'] != null ? number_format($filteredReportItem['ing_std_quantity'], 6) : "-" }}
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                            {{ $filteredReportItem['ingredient_cost'] != null ? number_format($filteredReportItem['ingredient_cost'], 9) : "-" }}
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                            {{ $filteredReportItem['ingredient_quantity'] != null ? number_format($filteredReportItem['ingredient_quantity'], 6) : "-" }}
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                            {{-- {{ $filteredReportItem['ingredient_quantity'] != null ? number_format($filteredReportItem['ingredient_quantity'] * $filteredReportItem['ingredient_cost'], 2) : "-" }} --}}
                            {{ $filteredReportItem['ingredient_amount'] != null ? number_format($filteredReportItem['ingredient_amount'], 2) : "-" }}
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        </td>
                        <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        </td>

                    </tr>

                @endforeach

                <tr>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    </td>
                    <td colspan="2" style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                        รวม {{ $filteredReportLv2Item['wip_step_no'] }}
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $filteredReportLv2Item['ingredient_amount'] != null ? number_format($filteredReportLv2Item['ingredient_amount'], 2) : "-" }}
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $filteredReportLv2Item['wage_amount'] != null ? number_format($filteredReportLv2Item['wage_amount'], 2) : "-" }}
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $filteredReportLv2Item['vary_amount'] != null ? number_format($filteredReportLv2Item['vary_amount'], 2) : "-" }}
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ $filteredReportLv2Item['fixed_amount'] != null ? number_format($filteredReportLv2Item['fixed_amount'], 2) : "-" }}
                    </td>
                    <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                        {{ number_format($filteredReportLv2Item['ingredient_amount'] + $filteredReportLv2Item['wage_amount'] + $filteredReportLv2Item['vary_amount'] + $filteredReportLv2Item['fixed_amount'], 2) }}
                    </td>

                </tr>

            @endforeach

            <tr>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                </td>
                <td colspan="2" style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px;"> 
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;">     
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    <b>รวมตามคำสั่งผลิต</b>
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['ingredient_amount'] != null ? number_format($reportLv1Item['ingredient_amount'], 2) : "-" }}
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['wage_amount'] != null ? number_format($reportLv1Item['wage_amount'], 2) : "-" }}
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['vary_amount'] != null ? number_format($reportLv1Item['vary_amount'], 2) : "-" }}
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ $reportLv1Item['fixed_amount'] != null ? number_format($reportLv1Item['fixed_amount'], 2) : "-" }}
                </td>
                <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                    {{ number_format($reportLv1Item['ingredient_amount'] + $reportLv1Item['wage_amount'] + $reportLv1Item['vary_amount'] + $reportLv1Item['fixed_amount'], 2) }}
                </td>

            </tr>

        @endforeach

        <tr>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td colspan="2" style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                <b>รวมวัตถุดิบ - มาตรฐาน</b>
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $summarizedReportItem['ingredient_amount'] != null ? number_format($summarizedReportItem['ingredient_amount'], 2) : "-" }}
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $summarizedReportItem['wage_amount'] != null ? number_format($summarizedReportItem['wage_amount'], 2) : "-" }}
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $summarizedReportItem['vary_amount'] != null ? number_format($summarizedReportItem['vary_amount'], 2) : "-" }}
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $summarizedReportItem['fixed_amount'] != null ? number_format($summarizedReportItem['fixed_amount'], 2) : "-" }}
            </td>
            <td style="height: 40px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ number_format($summarizedReportItem['ingredient_amount'] + $summarizedReportItem['wage_amount'] + $summarizedReportItem['vary_amount'] + $summarizedReportItem['fixed_amount'], 2) }}
            </td>

        </tr>
        
    </tbody>

</table>