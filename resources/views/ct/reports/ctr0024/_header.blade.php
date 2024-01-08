<table>
    <thead>

        @if($pgIndex == 0)

        <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                
            </th>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 14px; vertical-align: middle; text-align: center;"> 
                <p> การยาสูบแห่งประเทศไทย (DR Site-TOT) </p>
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>
        </tr>

        <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> รหัสโปรแกรม : {{ $programCode }} </p>
            </th>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 15px; vertical-align: middle; text-align: center;">  
                <p> รายงานบัตรต้นทุนมาตรฐาน </p>
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                <p> หน้าที่ : 1 / 1 </p>
            </th>
        </tr>

        <tr>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                
            </th>
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 15px; vertical-align: middle; text-align: center;">  
                
            </th>
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                <p> วันที่พิมพ์ : {{ $reportDate }} {{ $reportTime }} </p>
            </th>
        </tr>
        
        <tr>

            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> ปีบัญชีงบประมาณ : {{ $periodYearTh }} </p>
            </th>
            
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                ครั้งที่ : {{ $versionNo }}
            </th>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                แผนผลิตครั้งที่ : {{ $planVersionNo }}
            </th>

        </tr>

        <tr>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                วันที่เริ่มต้นใช้อัตรามาตรฐาน  : {{ $reportProductGroupItem['start_date_thai'] }}
            </th>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                วันที่สิ้นสุด : {{ $reportProductGroupItem['end_date_thai'] }}
            </th>

        </tr>

        @endif

        <tr>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> ศูนย์ต้นทุน : {{ $reportProductGroupItem['cost_code'] }} {{ $reportProductGroupItem['cost_desc'] }} </p>
            </th>
            
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> กลุ่มผลิตภัณฑ์ : {{ $reportProductGroupItem['product_group'] }} {{ $reportProductGroupItem['product_group_desc'] }} </p>
            </th>
            
            <th width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> หน่วยนับ : {{ $reportProductGroupItem['cost_quantity'] }} {{ $reportProductGroupItem['uom_desc'] }} </p>
            </th>

        </tr>

        <tr>

            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: left;"> 
                <p> ผลิตภัณฑ์ : {{ $reportProductGroupItem['product_item_number'] }} {{ $reportProductGroupItem['product_item_desc'] }} </p>
            </th>
            
            <th colspan="2" width="25" style="height: 30px; background-color: #ffffff; border: 1px solid #ffffff; font-weight: bold; font-size: 13px; vertical-align: middle; text-align: right;"> 
                
            </th>

        </tr>

    </thead>

</table>