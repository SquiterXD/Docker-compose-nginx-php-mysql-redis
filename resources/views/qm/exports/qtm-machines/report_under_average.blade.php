<table class="table table-bordered">

    {{-- WEIGHT --}}
    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
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
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> ผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน - QTM_Weight (g) </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th width="15" colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : {{ $taskTypeCodeDesc }}
            </th>
            <th width="15" colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / {{ $totalPage }}
            </th>
        </tr>
        <tr>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">เวลา</th>
            @foreach($reportWeightDates as $key => $reportWeightDateTh)
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    {{ $reportWeightDateTh->date_drawn_formatted }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($reportWeightMachineItems as $key => $reportWeightMachineItem)
            <tr>
                @if($reportWeightMachineItem->is_first_row)
                <td width="25" rowspan="{{ $reportWeightMachineItem->count_time_items }}" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportWeightMachineItem->machine_set }} 
                </td>
                @endif
                <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportWeightMachineItem->time_drawn_formatted }} 
                </td>
                @foreach($reportWeightDates as $reportWeightDateTd)
                    <?php $foundFirst = false; ?>
                    @foreach($reportWeightMachineItem->results as $reportWeightMachineItemIndex => $reportWeightMachineItemResult)
                        @if($reportWeightMachineItemResult->date_drawn_formatted == $reportWeightDateTd->date_drawn_formatted && $reportWeightMachineItemResult->time_drawn_formatted == $reportWeightMachineItem->time_drawn_formatted && $reportWeightMachineItemResult->result_value)
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> {{ floatval($reportWeightMachineItemResult->result_value) }} </p>
                            </td>
                        @else
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>

{{-- SIZEL --}}

<table class="table table-bordered">

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
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
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> ผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน - QTM_SizeL (mm) </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th width="15" colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : {{ $taskTypeCodeDesc }}
            </th>
            <th width="15" colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 2 / {{ $totalPage }}
            </th>
        </tr>
        <tr>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">เวลา</th>
            @foreach($reportSizelDates as $key => $reportSizelDateTh)
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    {{ $reportSizelDateTh->date_drawn_formatted }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($reportSizelMachineItems as $key => $reportSizelMachineItem)
            <tr>
                @if($reportSizelMachineItem->is_first_row)
                <td width="25" rowspan="{{ $reportSizelMachineItem->count_time_items }}" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportSizelMachineItem->machine_set }} 
                </td>
                @endif
                <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportSizelMachineItem->time_drawn_formatted }} 
                </td>
                @foreach($reportSizelDates as $reportSizelDateTd)
                    <?php $foundFirst = false; ?>
                    @foreach($reportSizelMachineItem->results as $reportSizelMachineItemIndex => $reportSizelMachineItemResult)
                        @if($reportSizelMachineItemResult->date_drawn_formatted == $reportSizelDateTd->date_drawn_formatted && $reportSizelMachineItemResult->time_drawn_formatted == $reportSizelMachineItem->time_drawn_formatted && $reportSizelMachineItemResult->result_value)
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> {{ floatval($reportSizelMachineItemResult->result_value) }} </p>
                            </td>
                        @else
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

{{-- PD OPEN --}}
<table class="table table-bordered">

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
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
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> ผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน - QTM_PD Open (mmWg) </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th width="15" colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : {{ $taskTypeCodeDesc }}
            </th>
            <th width="15" colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 3 / {{ $totalPage }}
            </th>
        </tr>
        <tr>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">เวลา</th>
            @foreach($reportPdOpenDates as $key => $reportPdOpenDateTh)
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    {{ $reportPdOpenDateTh->date_drawn_formatted }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($reportPdOpenMachineItems as $key => $reportPdOpenMachineItem)
            <tr>
                @if($reportPdOpenMachineItem->is_first_row)
                <td width="25" rowspan="{{ $reportPdOpenMachineItem->count_time_items }}" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportPdOpenMachineItem->machine_set }} 
                </td>
                @endif
                <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportPdOpenMachineItem->time_drawn_formatted }} 
                </td>
                @foreach($reportPdOpenDates as $reportPdOpenDateTd)
                    <?php $foundFirst = false; ?>
                    @foreach($reportPdOpenMachineItem->results as $reportPdOpenMachineItemIndex => $reportPdOpenMachineItemResult)
                        @if($reportPdOpenMachineItemResult->date_drawn_formatted == $reportPdOpenDateTd->date_drawn_formatted && $reportPdOpenMachineItemResult->time_drawn_formatted == $reportPdOpenMachineItem->time_drawn_formatted && $reportPdOpenMachineItemResult->result_value)
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> {{ floatval($reportPdOpenMachineItemResult->result_value) }} </p>
                            </td>
                        @else
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>

@if($taskTypeCode == "200")

{{-- TIP VENT --}}
<table class="table table-bordered">

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
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
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> ผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน - QTM_Tip Vent (%) </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th width="15" colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : {{ $taskTypeCodeDesc }}
            </th>
            <th width="15" colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 4 / {{ $totalPage }}
            </th>
        </tr>
        <tr>
            <th width="25" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">เวลา</th>
            @foreach($reportTipVentDates as $key => $reportTipVentDateTh)
                <th width="15" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;">
                    {{ $reportTipVentDateTh->date_drawn_formatted }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($reportTipVentMachineItems as $key => $reportTipVentMachineItem)
            <tr>
                @if($reportTipVentMachineItem->is_first_row)
                <td width="25" rowspan="{{ $reportTipVentMachineItem->count_time_items }}" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportTipVentMachineItem->machine_set }} 
                </td>
                @endif
                <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportTipVentMachineItem->time_drawn_formatted }} 
                </td>
                @foreach($reportTipVentDates as $reportTipVentDateTd)
                    <?php $foundFirst = false; ?>
                    @foreach($reportTipVentMachineItem->results as $reportTipVentMachineItemIndex => $reportTipVentMachineItemResult)
                        @if($reportTipVentMachineItemResult->date_drawn_formatted == $reportTipVentDateTd->date_drawn_formatted && $reportTipVentMachineItemResult->time_drawn_formatted == $reportTipVentMachineItem->time_drawn_formatted && $reportTipVentMachineItemResult->result_value)
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> {{ floatval($reportTipVentMachineItemResult->result_value) }} </p>
                            </td>
                        @else
                            <td width="15" style="border: 1px solid #000000; vertical-align: top; text-align: center;">
                                <p> &nbsp; </p>
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>

@endif