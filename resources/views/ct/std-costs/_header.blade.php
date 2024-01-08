<table>
    <thead>

        {{-- <tr>
            <th colspan="12" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย (DR Site-TOT) </p>
            </th>
        </tr> --}}
        
        <tr>
            <th colspan="9" style="height: 40px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 24px; text-align: center;">  
                <p> {{ $programCode }} : ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต </p>
            </th>
        </tr>
        
        <tr>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> ปีงบประมาณ : </p>
            </th>
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $periodYearTh }} </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> แผนการผลิตครั้งที่ : </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $planVersionNo }} </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 

            </th>
            
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> เปรียบเทียบค่าใช้จ่ายจริงจาก : </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $periodNameFromTh }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>

        </tr>

        <tr>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> เกณฑ์การปันส่วนครั้งที่ : </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $versionNo }} </p>
            </th>

            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                
            </th>
            
            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> ถึง : </p>
            </th>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $periodNameToTh }} </p>
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: right;"> 

            </th>

        </tr>

        <tr>

            <th width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> หน่วยงานที่ปัน : </p>
            </th>

            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                <p> {{ $allocateGroupCodeLabel }} </p>
            </th>
            
            <th colspan="3" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: left;"> 
                
            </th>
            
            <th colspan="2" width="20" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 16px; text-align: right;"> 

            </th>

        </tr>

    </thead>
</table>