<table>
    <thead>

        <tr>
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: left;"> 
                
            </th>
            <th colspan="{{ $reportType == 'ITEM' ? '7' : '8' }}" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; vertical-align: middle; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย </p>
            </th>
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: right;"> 
                
            </th>
        </tr>
        <tr>
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="{{ $reportType == 'ITEM' ? '7' : '8' }}" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: center;">  
                <p> กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต (ปลายงวด) : {{ $reportTypeDesc }} </p>
            </th>
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>
        </tr>
        
        <tr>

            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: left;"> 
                <p> ปีงบประมาณ : {{ $periodYearTh }} </p>
            </th>
            
            <th colspan="{{ $reportType == 'ITEM' ? '7' : '8' }}" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: center;"> 
                <p> ณ วันที่ : {{ $dateFrom }} - {{ $dateTo }} </p>
            </th>
            
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: right;"> 
                
            </th>

        </tr>

        <tr>

            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: left;"> 
                <p> หน่วยงาน : {{ $reportHeader->department_code }} {{ $reportHeader->department_description }} </p>
            </th>
            
            <th colspan="{{ $reportType == 'ITEM' ? '7' : '8' }}" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: center;"> 
                <p> ศูนย์ต้นทุน : {{ $costCode }} - {{ $costCodeDesc }} </p>
            </th>
            
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; vertical-align: middle; text-align: right;"> 
                
            </th>

        </tr>

    </thead>

</table>