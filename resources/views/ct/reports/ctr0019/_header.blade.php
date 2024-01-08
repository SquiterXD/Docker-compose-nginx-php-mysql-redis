<table>
    <thead>

        @if($agcIndex == 0)
        <tr>
            <th colspan="12" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย (DR Site-TOT) </p>
            </th>
        </tr>
        @endif
        
        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="8" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: center;">  
                <p> กระดาษทำการปันส่วนค่าใช้จ่ายของ {{ $allocateGroupCode["allocate_group_code_label"] }} ({{ $allocateGroupCode["allocate_group_code"] }}) และค่าใช้จ่ายรับโอน </p>
            </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 

            </th>
        </tr>
        
        <tr>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ปีที่ :  {{ $periodYearTh }} </p>
            </th>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ครั้งที่กระดาษ :  {{ $versionNo }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: left;"> 
                <p> ครั้งที่กระดาษทำการ :  {{ $planVersionNo }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                <p> เปรียบเทียบค่าใช้จ่ายจริงจาก :  {{ $periodNameFromTh }} </p>
            </th>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                <p> เปรียบเทียบค่าใช้จ่ายจริงถึง :  {{ $periodNameToTh }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>

        </tr>

    </thead>
</table>