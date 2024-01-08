<table>
    <thead>

        @if($pgIndex == 0)

        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                
            </th>
            <th colspan="4" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; vertical-align: middle; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย </p>
            </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>
        </tr>
        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="4" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: center;">  
                <p> รายงานอัตรามาตรฐาน {{ $productOfYear == 'Y' ? "(เพิ่มผลิตภัณฑ์ใหม่)" : "" }} </p>
            </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>
        </tr>

        @endif
        
        <tr>

            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> ปีงบประมาณ : {{ $periodYearTh }} </p>
            </th>
            
            <th colspan="4" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: center;"> 
                <p> ศูนย์ต้นทุน : {{ $reportProductGroup['cost_code'] }} {{ $reportProductGroup['cost_desc'] }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                <p> สถานะ : {{ $reportProductGroup['approved_status'] ? ( $reportProductGroup['approved_status'] == "อนุมัติ" ? "อนุมัติ" : "ไม่อนุมัติ") : "-" }} </p>
            </th>

        </tr>

    </thead>

</table>