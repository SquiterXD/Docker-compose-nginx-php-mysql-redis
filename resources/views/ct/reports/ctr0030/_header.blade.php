<table>
    <thead>

        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                
            </th>
            <th colspan="6" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; vertical-align: middle; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย </p>
            </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>
        </tr>
        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="6" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: center;">  
                <p> รายงานสรุปสิ่งพิมพ์ระหว่างผลิตปลายงวด ตามผลิตภัณฑ์ </p>
            </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>
        </tr>
        
        <tr>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> ปีงบประมาณ : {{ $periodYearTh }} </p>
            </th>
            
            <th colspan="6" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: center;"> 
                <p> ณ วันที่ : {{ $dateFrom }} - {{ $dateTo }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>

        </tr>

        <tr>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> หน่วยงาน : {{$reportItems[0]['department_code'] }} {{$reportItems[0]['department_description'] }} </p>
            </th>
            
            <th colspan="6" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: center;"> 
                <p> ศูนย์ต้นทุน : {{ $costCode }} - {{ $costCodeDesc }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>

        </tr>

    </thead>

</table>