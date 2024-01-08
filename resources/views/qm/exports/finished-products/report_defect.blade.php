<html>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr>
                <th colspan="4" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    โปรแกรม : {{ $programCode }}
                </th>
                <th colspan="9" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    การยาสูบแห่งประเทศไทย
                </th>
                <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    วันที่ {{ $reportDate }}
                </th>
            </tr>
            <tr>
                <th colspan="4" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    
                </th>
                <th colspan="9" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p style="font-size: 16px; font-weight: bold;"> รายงานรายการข้อบกพร่องของผลิตภัณฑ์และวัตถุดิบ </p>
                </th>
                <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    เวลา {{ $reportTime }}
                </th>
            </tr>
            <tr>
                <th colspan="4" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                    หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
                </th>
                <th colspan="9" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                    <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </th>
                <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                    หน้าที่ 1 / 1
                </th>
            </tr>
            <tr>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ลำดับ </th>
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> วันที่  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">เวลา </th>
                <th width="30" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เลขที่การตรวจสอบ  </th>
                <th width="12" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">  เขตตรวจคุณภาพ </th>
                @if($showInputPerson == "SHOW")
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ผู้บันทึก  </th>
                @endif
                <th width="12" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> รหัสตราบุหรี่  </th>
                <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตราบุหรี่  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวน  </th>
                <th width="10" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หน่วยนับ  </th>

                @foreach ($qmProcesses as $index => $qmProcess)

                    @if($index == 0)
                    <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ข้อบกพร่องพบที่เครื่องมวน </th>
                    @endif
                    @if($index == 1)
                    <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ข้อบกพร่องพบที่เครื่องบรรจุซอง </th>
                    @endif
                    @if($index == 2)
                    <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ข้อบกพร่องพบที่เครื่องฟิล์มซอง </th>
                    @endif
                    @if($index == 3)
                    <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ข้อบกพร่องพบที่เครื่องฟิล์มห่อ </th>
                    @endif
                    @if($index == 4)
                    <th width="40" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ข้อบกพร่องพบที่เครื่องบรรจุหีบ </th>
                    @endif

                @endforeach
                
            </tr>
        </thead>
        <tbody>
            @foreach($reportItems as $index => $reportItem)
                <tr>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $index+1 }} </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->date_drawn_formatted }} </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                        {{-- {{ $reportItem->time_drawn_formatted }} --}}
                        {{ $reportItem->sample_result_test_time }}
                    </td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->sample_no }}</td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->machine_set }}</td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->qc_area }}</td>
                    @if($showInputPerson == "SHOW")
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result_created_by_username }}</td>
                    @endif
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->brand_item_number }}</td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->brand_desc }}</td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->result_value }}</td>
                    <td style="border: 1px solid #000000; vertical-align: top; text-align: center;"> {{ $reportItem->result->test_unit_desc }}</td>

                    @foreach ($qmProcesses as $index => $qmProcess)

                        @if($index == 0)
                        <td width="40" style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                            @if($reportItem->result->qm_process_seq == $qmProcess->qm_process_seq)
                                {{ $reportItem->result->test_desc }} 
                            @endif
                        </td>
                        @endif
                        @if($index == 1)
                        <td width="40" style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                            @if($reportItem->result->qm_process_seq == $qmProcess->qm_process_seq)
                                {{ $reportItem->result->test_desc }} 
                            @endif
                        </td>
                        @endif
                        @if($index == 2)
                        <td width="40" style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                            @if($reportItem->result->qm_process_seq == $qmProcess->qm_process_seq)
                                {{ $reportItem->result->test_desc }} 
                            @endif
                        </td>
                        @endif
                        @if($index == 3)
                        <td width="40" style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                            @if($reportItem->result->qm_process_seq == $qmProcess->qm_process_seq)
                                {{ $reportItem->result->test_desc }} 
                            @endif
                        </td>
                        @endif
                        @if($index == 4)
                        <td width="40" style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                            @if($reportItem->result->qm_process_seq == $qmProcess->qm_process_seq)
                                {{ $reportItem->result->test_desc }} 
                            @endif
                        </td>
                        @endif

                    @endforeach
                    
                </tr>
            @endforeach
        </tbody>
    </table>

</html>