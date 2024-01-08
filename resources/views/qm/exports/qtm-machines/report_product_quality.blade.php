<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="20" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="20" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปผลการตรวจวัดคุณภาพของผลิตภัณฑ์บุหรี่ โดยเครื่อง QTM </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="20" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>
        <tr>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> วันที่ </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เวลา </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> บุหรี่ / ก้นกรอง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ชื่อการทดสอบ </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ผลการทดสอบ </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หน่วยนับ </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าควบคุม-Min </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าควบคุม-Max </th>
            <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ผลการตรวจ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตามข้อกำหนด </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เลขที่การตรวจสอบ </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> รหัสการทดสอบ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง Maker </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ประเภทเครื่อง Maker </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง QTM </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ประเภทเครื่อง QTM </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เวลาวัดผล </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> รหัสบุหรี่ / ก้นกรอง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ขนาดบุหรี่ </th>
            <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานะการตรวจสอบ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานะการยืนยันผล </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการลงผล  </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการทดสอบ  </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานะการอนุมัติ-Operator </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานะการอนุมัติ-Supervisor </th>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานะการอนุมัติ-Leader </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ชื่อไฟล์ผลการทดสอบ  </th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($reportItems as $index => $reportItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportItem->date_drawn_formatted }} 
                </td>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportItem->time_drawn_formatted }} 
                </td>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->machine_set }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->brand }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->test_desc }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ floatval($reportItem->result->result_value) }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->test_unit }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->min_value ? floatval($reportItem->result->min_value) : '' }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->max_value ? floatval($reportItem->result->max_value) : '' }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result_status_label }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->quality_status_label }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->sample_no }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->test_code }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->maker }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->machine_type_desc }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->machine_name ? "QTM" . $reportItem->machine_name : "" }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->equipment_type ? "QTM " . $reportItem->equipment_type : "" }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->test_time }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->lot_number }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->brand_category_name }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->sample_disposition_desc }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->confirm_status ? $reportItem->confirm_status : "" }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_operation_status_desc }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_result_status_desc }} </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->o_approval_status_label ? $reportItem->o_approval_status_label : "-" }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->s_approval_status_label ? $reportItem->s_approval_status_label : "-" }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->l_approval_status_label ? $reportItem->l_approval_status_label : "-" }}</td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->file_name }}  </td>
                
            </tr>

        @endforeach

    </tbody>
    
</table>