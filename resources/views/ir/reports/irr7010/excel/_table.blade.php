
<table width="100%" style="border: 1px solid #000000; font-size: 12px;">
    <thead>
        <tr align="center">
            <td align="center" style="width: 125 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;" >ลำดับ</td>
            <td align="center" style="width: 500 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">รายการ</td>
           
            <td align="center" style="width: 100 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">ราคาตามบัญชี <br>
                เพิ่ม / (ลด)<br>
                (บาท) 100%
            </td>
            <td align="center" style="width: 100 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">ราคาประกันภัย<br>
            เพิ่ม / (ลด)<br>
            (บาท) 100%
            </td >
            <td align="center"style="width: 150 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;" >มูลค่าทุนประกัน (บาท)<br>
            เพิ่ม / (ลด)<br>
            {{$dataListByStatus[0]->company_percent }}%
            </td>
            <td align="center" style="width: 120 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">อัตราเบี้ยประกัน</td>
            <td align="center" style="width: 200 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">ระยะเวลาตั้งแต่ - สิ้นสุด</td>
            <td align="center" style="width: 80 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">วัน / {{$dataListByStatus[0]->day_num }}</td>
            <td align="center" style="width: 150 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;">ค่าเบี้ยประกันภัย (บาท) <br>
            เพิ่ม / (ลด) {{$dataListByStatus[0]->prepaid_insurance }} %
            </td>
            <td align="center" style="width: 110 px; border-collapse: collapse; border: 1px solid #000000; background-color: #D0CECE;" >คำนวณปิดบัญชี (บาท) <br>
            เพิ่ม / (ลด)
            </td>            
        </tr>
    </thead>
    <tbody>
        @php
        
        $countLocation          =   0;
        $sumStaCurrent          =   0;
        $sumStaPercent          =   0;
        $sumStaCost             =   0;
        $sumStaInsPre           =   0;
        $sumStaClose            =   0;
        $sumStaDuty            =   0;
        $sumStaVat            =   0;
        foreach($dataListByStatus as $dataByStatus){
                        $sumStaCurrent = $sumStaCurrent +$dataByStatus['current_cost'];
                        $sumStaPercent = $sumStaPercent+$dataByStatus['percent'];
                        $sumStaCost   = $sumStaCost   +$dataByStatus['cost'];
                        $sumStaInsPre   = $sumStaInsPre   +$dataByStatus['insurance_premium'];
                        $sumStaClose   = $sumStaClose   +$dataByStatus['close'];
                        $sumStaDuty   = $sumStaDuty   +$dataByStatus['duty_amount'];
                        $sumStaVat   = $sumStaVat   +$dataByStatus['vat_amount'];
                    }

        
        @endphp
        @foreach($dataListByStatus->groupBy('location_name') as $dataListBylocaS => $dataListByloca)
        @php
            $countLocation = $countLocation+1;
            $countDep       =0;
            $sumLOPercent          =0;
            $sumLOCurrent           =0;
            $sumLoCost      =0;
            $sumLoClose     =0;
            foreach($dataListByloca as $dataByloca){
                        $sumLOCurrent = $sumLOCurrent +$dataByloca['current_cost'];
                        $sumLOPercent = $sumLOPercent +$dataByloca['percent'];
                        $sumLoCost   = $sumLoCost   +$dataByloca['cost'];
                        $sumLoClose   = $sumLoClose   +$dataByloca['close'];
                       
                    }
        @endphp
        <tr align="right" >
            <th align="center" style="  border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;">{{$countLocation}}</th>
            <th align="left" style="  border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;">{{$dataListBylocaS}}</th>
            <th style="  border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style="  border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style="  border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style=" border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style=" border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style=" border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style=" border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
            <th style=" border-collapse: collapse; border: 1px solid #000000; background-color: #F2F2F2;"></th>
        </tr> 
        @foreach($dataListByloca->groupBy('department_name') as $dataListByDepS => $dataListByDep)

        @php
            
            $countDep       =$countDep+1;
            $countCat       =0;
            $sumDeCurrent   =0;
            $sumDePercent   =0;
            $sumDeCost      =0;
            $sumDeClose     =0;
            foreach($dataListByDep as $dataByDep){
                        $sumDeCurrent = $sumDeCurrent +$dataByDep['current_cost'];
                        $sumDePercent = $sumDePercent +$dataByDep['percent'];
                        $sumDeCost   = $sumDeCost   +$dataByDep['cost'];
                        $sumDeClose   = $sumDeClose   +$dataByDep['close'];
                    }
        @endphp
            <tr align="right">
                <th align="center" style=" border-collapse: collapse; border-right: 1px solid #000000;">{{$countLocation.'.'.$countDep}}</th>
                <th align="left" style=" border-collapse: collapse; border-right: 1px solid #000000;">{{$dataListByDepS}}</th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
            </tr> 
            @foreach($dataListByDep->groupBy('category_description') as $dataListByCatS => $dataListByCat)
                @php
                    $countCat       =$countCat+1;
                    $sumCatCurrent =0;
                    $sumCatPercent =0;
                    $sumCatCost    =0;   
                    $sumCatClose    =0;
                    foreach($dataListByCat as $dataBycat){
                        
                        $sumCatCurrent = $sumCatCurrent +$dataBycat['current_cost'];
                        $sumCatPercent = $sumCatPercent +$dataBycat['percent'];
                        $sumCatCost = $sumCatCost +$dataBycat['cost'];
                        $sumCatClose   = $sumCatClose   +$dataBycat['close'];
                    }

                @endphp
                <tr align="right">
                    <th align="center" style=" border-collapse: collapse; border-right: 1px solid #000000; ">{{$countLocation.'.'.$countDep.'.'.$countCat}}</th>
                    <th align="left" style=" border-collapse: collapse; border-right: 1px solid #000000; ">{{$dataListByCatS}}</th>
                    <th align="right" style=" border-collapse: collapse; border-right: 1px solid #000000; "> {{negativeNum($sumCatCurrent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border-right: 1px solid #000000; ">{{negativeNum($sumCatPercent)}}</th>
                    <th align="right" style=" border-collapse: collapse;border-right: 1px solid #000000; ">{{(string)negativeNum($sumCatCost)}}</th>
                    <th style=" border-collapse: collapse;  border-right: 1px solid #000000; "></th>
                    <th style=" border-collapse: collapse;  border-right: 1px solid #000000; "></th>
                    <th style=" border-collapse: collapse;  border-right: 1px solid #000000; "></th>
                    <th style=" border-collapse: collapse;  border-right: 1px solid #000000; "></th>
                    <th align="right" style=" border-collapse: collapse;  border-right: 1px solid #000000; ">{{negativeNum($sumCatClose)}}</th>
                </tr>
            @endforeach
                <tr align="right">
                    <th style=" border-collapse: collapse; border-bottom: 1px solid #000000; border-right: 1px solid #000000;"></th>
                    <th  align="center" style=" border-collapse: collapse; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">รวม</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumDeCurrent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumDePercent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumDeCost)}}</th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th align="right"style=" border-collapse: collapse; border-right: 1px solid #000000;">{{negativeNum($sumDeClose)}}</th>
                </tr>
        @endforeach
        <tr align="right">
                    
                    <th  colspan="2"align="center" style=" border-collapse: collapse; border: 1px solid #000000;">รวม {{$dataListBylocaS}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumLOCurrent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumLOPercent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumLoCost)}}</th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th style=" border-collapse: collapse; border-right: 1px solid #000000;"></th>
                    <th align="right" style=" border-collapse: collapse; border-right: 1px solid #000000;">{{negativeNum($sumLoClose)}}</th>
                </tr>
        @endforeach

        <tr align="right">
                    
                    <th colspan="2" align="center" style=" border-collapse: collapse; border: 1px solid #000000;">รวมทั้งสิ้น	</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaCurrent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaPercent)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaCost)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{$dataListByStatus[0]->premium_rate }}</th>
                    <th align="center" style=" border-collapse: collapse; border: 1px solid #000000;">{{$dataListByStatus[0]->calculate_date }}</th>
                    <th align="center" style=" border-collapse: collapse; border: 1px solid #000000;">{{$dataListByStatus[0]->day_num }}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaInsPre)}}</th>
                    <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaClose)}}</th>
                </tr>


        <tr >
        <th   align="right"colspan="8" >ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม</th>
        <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;"> {{negativeNum($sumStaInsPre)}}</th>
        
        </tr>
        <tr    >
        <th align="right"colspan="8" >ค่าอากรแสตมป์</th>
        <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;" >{{ negativeNum($sumStaDuty)}} </th>
        
        </tr>
        <tr >
        <th align="right"colspan="8" >รวมเบี้ยบวกอากรแสตมป์</th>
        <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;">{{negativeNum($sumStaInsPre+$sumStaDuty)}} </th>
        
        </tr >
        <tr >
        <th align="right"colspan="8" >ค่าภาษีมูลค่าเพิ่ม</th>
        <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;"> {{negativeNum($sumStaVat)}}</th>
        
        </tr>
        <tr  >
        <th align="right"colspan="8" >รวมเบี้ยบวกอากรแสตมป์ และ ภาษีมูลค่าเพิ่ม</th>
        <th align="right" style=" border-collapse: collapse; border: 1px solid #000000;"> {{negativeNum($sumStaInsPre+$sumStaDuty+$sumStaVat)}}</th>
        
        </tr>
    </tbody>

</table>
        

        
     
