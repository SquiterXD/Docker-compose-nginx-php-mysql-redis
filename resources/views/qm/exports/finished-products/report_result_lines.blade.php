<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    โปรแกรม : {{ $programCode }}
                </th>
                <th colspan="15" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    การยาสูบแห่งประเทศไทย
                </th>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    วันที่ {{ $reportDate }}
                </th>
            </tr>
            <tr>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    
                </th>
                <th colspan="15" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p style="font-size: 16px; font-weight: bold;"> รายงานรายการข้อบกพร่องของผลิตภัณฑ์และวัตถุดิบ </p>
                </th>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    เวลา {{ $reportTime }}
                </th>
            </tr>
            <tr>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
                </th>
                <th colspan="15" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </th>
                <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    หน้าที่ 1 / 1
                </th>
            </tr>
            <tr>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  รายการ  </th>
                <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  เลขที่การตรวจสอบ  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ลำดับ  </th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  วันที่  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เวลา </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  หมายเลขเครื่อง  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  เขตตรวจคุณภาพ </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ประเภทเครื่อง  </th>
                <th width="12" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  รหัสตราบุหรี่  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ตราบุหรี่  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  รหัสปัญหา  </th>
                <th width="50" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  รายละเอียดปัญหา/ข้อบกพร่อง  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  หน่วยนับ  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  จำนวน  </th>
                <th width="50" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สถานที่พบ </th>
                <th width="12" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ความรุนแรง </th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">   คลังกระบวนการ </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  กระบวนการตรวจคุณภาพ  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  รายการตรวจคุณภาพ  </th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">   ขนาดบุหรี่ </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">   ขั้นตอน </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  เครื่องจักร  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ผลการตรวจ  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ตามข้อกำหนด  </th>
                @if($showInputPerson == "SHOW")
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  ผู้บันทึก  </th>
                @endif
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการตรวจสอบ  </th>
                <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการลงผล  </th>
                <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการทดสอบ  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการอนุมัติ-Operator  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการอนุมัติ-Supervisor  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  สถานะการอนุมัติ-Leader  </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportItems as $index => $reportItem)
                <tr>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $index+1 }} </td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_no }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result->seq }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->date_drawn_formatted }} </td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> 
                        {{-- {{ $reportItem->time_drawn_formatted }} --}}
                        {{ $reportItem->sample_result_test_time }}
                    </td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->machine_set }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->qc_area }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->qc_process_machine_type_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->brand_item_number }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->brand_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result->test_code }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: left;"> {{ $reportItem->result->test_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result->test_unit_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result->result_value }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->locator_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->test_serverity_code ? $reportItem->test_serverity_code : "-" }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->result->qc_production_process }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->result->qm_process }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->result->check_list }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->brand_category_name }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->operation_class_code }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;">  {{ $reportItem->eam_asset_description }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result_status_label }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->quality_status_label }}</td>
                    @if($showInputPerson == "SHOW")
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->result_created_by_username }}</td>
                    @endif
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_disposition_desc }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_operation_status_desc }} </td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->sample_result_status_desc }} </td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->o_approval_status_label ? $reportItem->o_approval_status_label : "-" }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->s_approval_status_label ? $reportItem->s_approval_status_label : "-" }}</td>
                    <td style="height: 20px; border: 1px solid #000000; vertical-align: middle; text-align: center;"> {{ $reportItem->l_approval_status_label ? $reportItem->l_approval_status_label : "-" }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

</html>