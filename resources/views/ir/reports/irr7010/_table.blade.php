<!-- <style>
 thead, td,table {
  border: 1px solid;
} -->
</style>
<table width="100%" class="table">
    <thead>
        <tr align="center" style="background-color: #D0CECE;">
            <td >ลำดับ</td>
            <td>รายการ</td>
            <td>ราคาตามบัญชี </br>
                เพิ่ม / (ลด)</br>
                (บาท) 100%
            </td>
            <td>ราคาประกันภัย</br>
            เพิ่ม / (ลด)</br>
            (บาท) 100%
            </td>
            <td>มูลค่าทุนประกัน (บาท)</br>
            เพิ่ม / (ลด)</br>
            {{$dataListByStatus[0]->company_percent }}%
            </td>
            <td>อัตราเบี้ยประกัน</td>
            <td>ระยะเวลาตั้งแต่ - สิ้นสุด</td>
            <td>วัน / {{$dataListByStatus[0]->day_num }}</td>
            <td>ค่าเบี้ยประกันภัย (บาท)</br>
            เพิ่ม / (ลด) {{$dataListByStatus[0]->prepaid_insurance }} %
            </td>
            <td>คำนวณปิดบัญชี (บาท)</br>
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
                foreach($dataListByloca as $dataByloca){
                            $sumLOCurrent = $sumLOCurrent +$dataByloca['current_cost'];
                            $sumLOPercent = $sumLOPercent +$dataByloca['percent'];
                            $sumLoCost   = $sumLoCost   +$dataByloca['cost'];
                        }
            @endphp
            <tr align="right"  style="background-color: #F2F2F2;">
                <td align="center">{{$countLocation}}</td>
                <td align="left">{{$dataListBylocaS}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach($dataListByloca->groupBy('department_name') as $dataListByDepS => $dataListByDep)

            @php
                
                $countDep       =$countDep+1;
                $countCat       =0;
                $sumDeCurrent   =0;
                $sumDePercent   =0;
                $sumDeCost      =0;
                foreach($dataListByDep as $dataByDep){
                            $sumDeCurrent = $sumDeCurrent +$dataByDep['current_cost'];
                            $sumDePercent = $sumDePercent +$dataByDep['percent'];
                            $sumDeCost   = $sumDeCost   +$dataByDep['cost'];
                        }
            @endphp
                <tr align="right">
                    <td align="center">{{$countLocation.'.'.$countDep}}</td>
                    <td align="left">{{$dataListByDepS}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach($dataListByDep->groupBy('category_description') as $dataListByCatS => $dataListByCat)
                    @php
                        $countCat       =$countCat+1;
                        $sumCatCurrent =0;
                        $sumCatPercent =0;
                        $sumCatCost    =0;   
                        
                        foreach($dataListByCat as $dataBycat){
                            
                            $sumCatCurrent = $sumCatCurrent +$dataBycat['current_cost'];
                            $sumCatPercent = $sumCatPercent +$dataBycat['percent'];
                            $sumCatCost = $sumCatCost +$dataBycat['cost'];
                        }

                    @endphp
                    <tr align="right">
                        <td align="center">{{$countLocation.'.'.$countDep.'.'.$countCat}}</td>
                        <td align="left">{{$dataListByCatS}}</td>
                        <td> {{negativeNum($sumCatCurrent)}}</td>
                        <td>{{negativeNum($sumCatPercent)}}</td>
                        <td>{{negativeNum($sumCatCost)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                    <tr align="right">
                        
                        <td colspan="2" align="center">รวม</td>
                        <td>{{negativeNum($sumDeCurrent)}}</td>
                        <td>{{negativeNum($sumDePercent)}}</td>
                        <td>{{negativeNum($sumDeCost)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            @endforeach
            <tr align="right">
                        
                        <td  colspan="2"align="center">รวม {{$dataListBylocaS}}</td>
                        <td>{{negativeNum($sumLOCurrent)}}</td>
                        <td>{{negativeNum($sumLOPercent)}}</td>
                        <td>{{negativeNum($sumLoCost)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
        @endforeach

        <tr align="right">
                        
                        <td colspan="2" align="center">รวมทั้งสิ้น	</td>
                        <td>{{negativeNum($sumStaCurrent)}}</td>
                        <td>{{negativeNum($sumStaPercent)}}</td>
                        <td>{{negativeNum($sumStaCost)}}</td>
                        <td>{{$dataListByStatus[0]->premium_rate }}</td>
                        <td align="center">{{$dataListByStatus[0]->calculate_date }}</td>
                        <td align="center">{{$dataListByStatus[0]->day_num }}</td>
                        <td>{{negativeNum($sumStaInsPre)}}</td>
                        <td>{{negativeNum($sumStaClose)}}</td>
                    </tr>
    
    
        <tr style='border-left-style: hidden;'>
            <td  style='border-bottom-style: hidden;' align="right"colspan="8">ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม</td>
            <td align="right" > {{negativeNum($sumStaInsPre)}}</td>
            
        </tr>
        <tr   style='border-left-style: hidden;' >
            <td style='border-bottom-style: hidden;' align="right"colspan="8">ค่าอากรแสตมป์</td>
            <td align="right" >{{ negativeNum($sumStaDuty)}} </td>
            
        </tr>
        <tr style='border-left-style: hidden;'>
            <td style='border-bottom-style: hidden;' align="right"colspan="8">รวมเบี้ยบวกอากรแสตมป์</td>
            <td align="right">{{negativeNum($sumStaInsPre+$sumStaDuty)}} </td>
            
        </tr >
        <tr style='border-left-style: hidden;'>
            <td style='border-bottom-style: hidden;'  align="right"colspan="8">ค่าภาษีมูลค่าเพิ่ม</td>
            <td align="right"> {{negativeNum($sumStaVat)}}</td>
            
        </tr>
        <tr style='border-left-style: hidden;' >
            <td style='border-bottom-style: hidden;' align="right"colspan="8">รวมเบี้ยบวกอากรแสตมป์ และ ภาษีมูลค่าเพิ่ม</td>
            <td align="right"> {{negativeNum($sumStaInsPre+$sumStaDuty+$sumStaVat)}}</td>
            
        </tr>
        </tbody>
</table>