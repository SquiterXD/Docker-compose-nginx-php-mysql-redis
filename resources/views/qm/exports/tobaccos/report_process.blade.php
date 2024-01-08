<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> รายงานผลการตรวจสอบคุณภาพในกระบวนการผลิตยาเส้น </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>
        <tr>

            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จุดตรวจสอบ </th>
            <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ชื่อจุดตรวจสอบ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> กลุ่มงาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามาตรฐานความชื้น </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> วันที่ </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เวลา </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรา/ชุด </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นจากหัววัด </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความชื้นจากห้องปฏิบัติการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแตกต่าง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซนต์ความแตกต่าง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความพอง </th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportItems as $index => $reportItem)
            <tr>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->location_desc }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: left;">
                    {{ $reportItem->locator_desc }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->qm_group }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->moist_sensor_min_value }} - {{ $reportItem->moist_sensor_max_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> 
                    {{ $reportItem->date_drawn_formatted }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->time_drawn_formatted }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->sample_opt }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center; background-color: {{ $reportItem->moist_sensor_result_status == 'LOWER' ? '#aaffaa' : ($reportItem->moist_sensor_result_status == 'HIGHER' ? '#ffddaa' : '') }}"> 
                    {{ $reportItem->moist_sensor_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center; background-color: {{ $reportItem->moist_lab_result_status == 'LOWER' ? '#aaffaa' : ($reportItem->moist_lab_result_status == 'HIGHER' ? '#ffddaa' : '') }}"> 
                    {{ $reportItem->moist_lab_result_value }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->moist_diff_value ? number_format($reportItem->moist_diff_value, 2) : '' }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->moist_diff_percent ? number_format($reportItem->moist_diff_percent, 2) ."%" : '' }}
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">
                    {{ $reportItem->expand_result_value }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>