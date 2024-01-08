<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="{{ count($reportDates) * 3 }}" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="{{ count($reportDates) * 3 }}" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> รายงานผลการตรวจสอบการระบาดของมอดยาสูบ - สรุปผลการตรวจสอบ </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="{{ count($reportDates) * 3 }}" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>
        <tr>
            <th width="45" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: right;"> 
                วันที่เก็บตัวอย่าง
            </th>
            @foreach($reportDates as $key => $reportDateTh)
                <th width="40" colspan="3"  style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    {{ $reportDateTh->date_drawn_formatted }}
                </th>
            @endforeach
            <th width="40" colspan="3"  style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                ทั้งหมด
            </th>
        </tr>
        <tr>
            <th width="45" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: left;"> 
                อาคาร / โซน 
            </th>
            @foreach($reportDates as $key => $reportDateTh)
                <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    จำนวนรายการ
                </th>
                <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    ผลรวม (ตัว)
                </th>
                <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    ค่าเฉลี่ย (ตัว)
                </th>
            @endforeach
            <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                จำนวนรายการ
            </th>
            <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                ผลรวม (ตัว)
            </th>
            <th width="13" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                ค่าเฉลี่ย (ตัว)
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportBuildNameItems as $key => $reportBuildNameItem)
            <tr>
                <td width="45" style="border: 1px solid #000000; vertical-align: top; text-align: left;"> 
                    {{ $reportBuildNameItem->build_name }} 
                </td>
                @foreach($reportDates as $reportDateTd)
                    <?php $foundBuildFirst = false; ?>
                    @foreach($reportBuildNameItem->results as $reportBuildNameItemIndex => $reportBuildNameItemResult)
                        @if($foundBuildFirst == false && $reportBuildNameItemResult->date_drawn_formatted == $reportDateTd->date_drawn_formatted)
                            <?php $foundBuildFirst = true; ?>
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                <p> {{ $reportBuildNameItemResult->record_count }} </p>
                            </td>
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                <p> {{ $reportBuildNameItemResult->sum_result_value }} </p>
                            </td>
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                <p> {{ $reportBuildNameItemResult->avg_result_value }} </p>
                            </td>
                        @endif
                        @if($reportBuildNameItemIndex+1 == count($reportBuildNameItem->results) && $foundBuildFirst == false)
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                            <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                        @endif
                    @endforeach
                @endforeach

                @foreach($reportSummaryBuildNameItems as $reportSummaryBuildNameItem)
                    @if($reportSummaryBuildNameItem->build_name == $reportBuildNameItem->build_name)
                        <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                            <p> {{ $reportSummaryBuildNameItem->record_count }} </p>
                        </td>
                        <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                            <p> {{ $reportSummaryBuildNameItem->sum_result_value }} </p>
                        </td>
                        <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                            <p> {{ $reportSummaryBuildNameItem->avg_result_value }} </p>
                        </td>
                    @endif
                @endforeach
                
            </tr>

            @foreach($reportDepartmentNameItems as $key => $reportDepartmentNameItem)

                @if($reportBuildNameItem->build_name == $reportDepartmentNameItem->build_name)

                    <tr>
                        <td width="45" style="border: 1px solid #000000; vertical-align: top; text-align: left;"> 
                            &nbsp; {{ $reportDepartmentNameItem->department_name }} 
                        </td>

                        @foreach($reportDates as $reportDateTd)
                            <?php $foundDepartmentFirst = false; ?>
                            @foreach($reportDepartmentNameItem->results as $reportDepartmentNameItemIndex => $reportDepartmentNameItemResult)
                                @if($foundDepartmentFirst == false && $reportDepartmentNameItemResult->date_drawn_formatted == $reportDateTd->date_drawn_formatted)
                                    <?php $foundDepartmentFirst = true; ?>
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                        <p> {{ $reportDepartmentNameItemResult->record_count }} </p>
                                    </td>
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                        <p> {{ $reportDepartmentNameItemResult->sum_result_value }} </p>
                                    </td>
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center; background-color: #ffffff;">
                                        <p> {{ $reportDepartmentNameItemResult->avg_result_value }} </p>
                                    </td>
                                @endif
                                @if($reportDepartmentNameItemIndex+1 == count($reportDepartmentNameItem->results) && $foundDepartmentFirst == false)
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                        <p> &nbsp; </p>
                                    </td>
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                        <p> &nbsp; </p>
                                    </td>
                                    <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                        <p> &nbsp; </p>
                                    </td>
                                @endif
                            @endforeach
                        @endforeach

                        @foreach($reportSummaryDepartmentNameItems as $reportSummaryDepartmentNameItem)
                            @if($reportSummaryDepartmentNameItem->build_name == $reportDepartmentNameItem->build_name && $reportSummaryDepartmentNameItem->department_name == $reportDepartmentNameItem->department_name)
                                <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                    <p> {{ $reportSummaryDepartmentNameItem->record_count }} </p>
                                </td>
                                <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                    <p> {{ $reportSummaryDepartmentNameItem->sum_result_value }} </p>
                                </td>
                                <td width="13" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                    <p> {{ $reportSummaryDepartmentNameItem->avg_result_value }} </p>
                                </td>
                            @endif
                        @endforeach

                    </tr>
                    
                @endif

            @endforeach

        @endforeach
    </tbody>
</table>