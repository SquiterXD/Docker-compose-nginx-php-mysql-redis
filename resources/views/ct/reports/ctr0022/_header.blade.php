<table>
    <thead>

        @if($agcIndex == 0)
        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                
            </th>
            <th colspan="4" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย (DR Site-TOT) </p>
            </th>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                
            </th>
        </tr>
        @endif
        
        <tr>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="4" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: center;">  
                <p> กระดาษทำการปันส่วนของ {{ $reportCostCode['cost_desc'] }} ({{ $reportCostCode['cost_code'] }} ) และค่าใช้จ่ายที่รับโอนมาปันให้แต่ละกระบวนการผลิต </p>
            </th>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                
            </th>
        </tr>
        
        <tr>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ปีงบประมาณ : {{ $periodYearTh }} </p>
            </th>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ครั้งที่กระดาษ :  {{ $versionNo }} </p>
            </th>
            
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ครั้งที่กระดาษทำการ :  {{ $ct14VersionNo }} </p>
            </th>
            
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>

        </tr>

    </thead>

</table>