<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> รายงานผลการตรวจคุณภาพยาเส้นและมวนบุหรี่ </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>
        <tr>
            <th rowspan="3" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" class="text-center"> วันที่ </th>
            <th rowspan="3" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" class="text-center"> เวลา </th>
            <th rowspan="3" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" class="text-center"> จุดตรวจสอบ </th>
            <th rowspan="3" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" class="text-center"> ตรา/ชุด </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามาตรฐาน {{ $reportHeaderItem->MOIST_SILO_SENSOR->min_value }} - {{ $reportHeaderItem->MOIST_SILO_SENSOR->max_value }} % </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามาตรฐาน {{ $reportHeaderItem->MOIST_CIG_LAB->min_value }} - {{ $reportHeaderItem->MOIST_CIG_LAB->max_value }} % </th>
        </tr>
        <tr>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> SPL {{ ($reportHeaderItem->MOIST_SILO_SENSOR->spl_min_value) }} - {{ ($reportHeaderItem->MOIST_SILO_SENSOR->spl_max_value) }} % </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> > {{ $reportHeaderItem->EXPAND->min_value }} cc/g </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> SPL {{ $reportHeaderItem->MOIST_CIG_LAB->spl_min_value }} - {{ $reportHeaderItem->MOIST_CIG_LAB->spl_max_value }} % </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นในไซโล </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นจ่ายเครื่องมวน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความพอง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่องมวน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นในมวนบุหรี่ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นที่จอแสดงผล </th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportItems as $index => $reportItem)
            <tr>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> 
                    {{ $reportItem->date_drawn_formatted }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->time_drawn_formatted }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->location_desc }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->sample_opt }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center; background-color: {{ $reportItem->moist_silo_sensor_result_status == 'LOWER' ? '#aaffaa' : ($reportItem->moist_silo_sensor_result_status == 'HIGHER' ? '#ffddaa' : '') }}"> 
                    {{ $reportItem->moist_silo_sensor_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center; background-color: {{ $reportItem->moist_silo_lab_result_status == 'LOWER' ? '#aaffaa' : ($reportItem->moist_silo_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }}"> 
                    {{ $reportItem->moist_silo_lab_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->expand_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->roll_mc_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center; background-color: {{ $reportItem->moist_cig_lab_result_status == 'LOWER' ? '#aaffaa' : ($reportItem->moist_cig_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }}"> 
                    {{ $reportItem->moist_cig_lab_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->moist_roll_mc_display_result_value }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>