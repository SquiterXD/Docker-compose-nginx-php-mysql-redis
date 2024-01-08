<table>             
    <thead>
        <tr>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                รหัส
            </th>
            <th width="40" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                รายละเอียด
            </th>
            <th width="10" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                หน่วยนับ
            </th>
            <th width="20" rowspan="2" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                <p> ปริมาณผลผลิต </p>
                <p> ระหว่างผลิต (Output) </p> 
            </th>
            <th width="120" colspan="6" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 13px; font-size: 14px; text-align: center;"> 
                ต้นทุนมาตรฐาน (บาท) 
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าวัตถุดิบ
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าแรงงาน
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายผันแปร
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ค่าใช้จ่ายคงที่
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                รวมทั้งสิ้น
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-weight: bold; font-size: 14px; text-align: center;"> 
                ราคา/พัน 
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none; font-size: 14px; text-align: center;"></td>
            <td align="center" style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: none; font-size: 14px;"> 
                <b>ศูนย์ต้นทุน :{{ $costCode }} - {{ $costCodeDesc }}</b>
            </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
            <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000000; border-bottom: none;"> </td>
        </tr>
        @foreach($reportItems as $reportItem)
            <tr>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: left;"> 
                    {{ $reportItem['item_number'] }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px;"> 
                    {{ $reportItem['item_description'] }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: center;"> 
                    {{ $reportItem['transaction_uom'] }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['transaction_quantity'] != null ? number_format($reportItem['transaction_quantity'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['ingredient_amount'] != null ? number_format($reportItem['ingredient_amount'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['wage_amount'] != null ? number_format($reportItem['wage_amount'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['vary_amount'] != null ? number_format($reportItem['vary_amount'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['fixed_amount'] != null ? number_format($reportItem['fixed_amount'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['total_amount'] != null ? number_format($reportItem['total_amount'], 2) : "-" }}
                </td>
                <td style="height: 30px; background-color: #ffffff; border-left: 1px solid #000000; border-right: 1px solid #000000; border-top: none; border-bottom: none; font-size: 14px; text-align: right;"> 
                    {{ $reportItem['transaction_cost'] != null ? number_format($reportItem['transaction_cost'], 2) : "-" }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                <b>รวมตามศูนย์ต้นทุน - {{ $costCodeDesc }}</b>
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['ingredient_amount'] != null ? number_format($reportSummary['ingredient_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['wage_amount'] != null ? number_format($reportSummary['wage_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['vary_amount'] != null ? number_format($reportSummary['vary_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['fixed_amount'] != null ? number_format($reportSummary['fixed_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['total_amount'] != null ? number_format($reportSummary['total_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 

            </td>
        </tr>
        <tr>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: center;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                <b>รวมวัตถุดิบ - มาตรฐาน</b>
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['ingredient_amount'] != null ? number_format($reportSummary['ingredient_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['wage_amount'] != null ? number_format($reportSummary['wage_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['vary_amount'] != null ? number_format($reportSummary['vary_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['fixed_amount'] != null ? number_format($reportSummary['fixed_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 
                {{ $reportSummary['total_amount'] != null ? number_format($reportSummary['total_amount'], 2) : "-" }}
            </td>
            <td style="height: 30px; background-color: #ffffff; border: 1px solid #000000; font-size: 14px; text-align: right;"> 

            </td>
        </tr>
    </tbody>

</table>