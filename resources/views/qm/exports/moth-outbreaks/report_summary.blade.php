<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <table class="table table-bordered tw-text-xs">
        <thead>
            <tr>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    โปรแกรม : {{ $programCode }}
                </th>
                <th colspan="10" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    การยาสูบแห่งประเทศไทย
                </th>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    วันที่ {{ $reportDate }}
                </th>
            </tr>
            <tr>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    
                </th>
                <th colspan="10" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p style="font-size: 16px; font-weight: bold;"> รายงานผลการตรวจสอบการระบาดของมอดยาสูบ - รายการผลการตรวจสอบ </p>
                </th>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    เวลา {{ $reportTime }}
                </th>
            </tr>
            <tr>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
                </th>
                <th colspan="10" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </th>
                <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    หน้าที่ 1 / 1
                </th>
            </tr>
            <tr>
                <th width="5" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> ลำดับ </th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> เลขที่การตรวจสอบ </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> วันที่เก็บตัวอย่าง </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> อาคาร</th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> โซน</th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> จุดตรวจสอบ</th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> รายละเอียดจุดตรวจสอบ</th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> รหัสการทดสอบ</th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> ชื่อการทดสอบ</th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> หน่วยทดสอบ</th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> ผลการทดสอบ</th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> ค่าควบคุม-Min</th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> ค่าควบคุม-Max</th>
                <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> สถานะการตรวจสอบ</th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> สถานะการอนุมัติ-Supervisor</th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle;" class="text-center"> สถานะการอนุมัติ-Leader</th>
            </tr>
        </thead>
        <tbody v-if="reportItems.length > 0">
            @foreach($reportItems as $index => $reportItem)
                <tr clsss="tw-text-xs">
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center"> 
                        {{ $index+1 }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center"> 
                        {{ $reportItem->sample_no }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->date_drawn_formatted }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        {{ $reportItem->build_name }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->department_name }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->location_desc }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->locator_desc }} 
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->test_code }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->test_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->test_unit }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->result_value }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->min_value ? floatval($reportItem->result->min_value) : '' }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->result->max_value ? floatval($reportItem->result->max_value) : '' }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{-- {{ $reportItem->result_status_label }} --}}
                        {{ $reportItem->sample_operation_status_desc }} {{ $reportItem->sample_result_status_desc }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->s_approval_status_label ? $reportItem->s_approval_status_label : "-" }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; background-color: #ffffff;" class="text-center">
                        {{ $reportItem->l_approval_status_label ? $reportItem->l_approval_status_label : "-" }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</html>