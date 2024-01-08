<link rel="stylesheet" href="{{ public_path('css\pdf.css') }}" media="all" />
<link rel="stylesheet" href="{{ public_path('css\app.css') }}" media="all" />
<style>
    
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
    }

    body {
        font-family: "THSarabunNew";
    }

</style>

<div style="min-height: 50px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ข้อสังเกตจากเอกสารบันทึกอัตรารั่วฟิล์มห่อซองบุหรี่ Overwrap Seal Test </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="30%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="40%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="30%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน้าที่ 1 / 1 </p>
            </td>
        </tr>
        
    </table>

</div>

<div class="tw-mt-4">

    <table border="1" width="100%" style="font-size: 12px;">

        <thead>
            <tr>
                <th width="10%" rowspan="2" class="text-center"> หมายเลขเครื่อง </th>
                <th width="15%" rowspan="2" class="text-center"> ประเภทเครื่อง </th>
                <th width="10%" rowspan="2" class="text-center"> ตรวจสอบทั้งหมด (ซอง) </th>
                <th width="10%" rowspan="2" class="text-center"> ไม่ผ่านมาตรฐาน (ซอง) </th>
                <th width="10%" rowspan="2" class="text-center"> ไม่ผ่านมาตรฐาน (%) </th>
                <th width="45%" colspan="6" class="text-center"> ตำแหน่งที่รั่ว </th>
            </tr>
            <tr>
                <th width="9%" class="text-center"> หัวซอง (ซอง) </th>
                <th width="6%" class="text-center"> % </th>
                <th width="9%" class="text-center"> ท้ายซอง (ซอง) </th>
                <th width="6%" class="text-center"> % </th>
                <th width="9%" class="text-center"> ข้างซอง (ซอง) </th>
                <th width="6%" class="text-center"> % </th>
            </tr>
        </thead>

        <tbody>
                
            @foreach($reportItems as $indexItem => $reportItem)
                
                <tr>
                    
                    @if(floatval($reportItem->failed_average) >= $hightlightMachineFromPercent)
                        <td class="text-center" style="background-color: #fff0a0;"> {{ $reportItem->machine_set ? $reportItem->machine_set : "-" }} </td>
                    @else
                        <td class="text-center"> {{ $reportItem->machine_set ? $reportItem->machine_set : "-" }} </td>
                    @endif
                    <td class="text-center"> {{ $reportItem->machine_type_desc ? $reportItem->machine_type_desc : "-" }} </td>

                    <td class="text-center"> {{ $reportItem->count ? $reportItem->count : "0" }} </td>
                    <td class="text-center"> {{ $reportItem->failed_count ? $reportItem->failed_count : "0" }} </td>
                    @if(floatval($reportItem->failed_average) >= $hightlightPositionLeakFromPercent)
                        <td class="text-right tw-pr-2" style="background-color: #fff0a0;"> {{ $reportItem->failed_average ? $reportItem->failed_average . '%' : "-" }} </td>
                    @else
                        <td class="text-right tw-pr-2"> {{ $reportItem->failed_average ? $reportItem->failed_average . '%' : "-" }} </td>
                    @endif

                    <td class="text-right tw-pr-1"> {{ $reportItem->failed_top_count ? $reportItem->failed_top_count : "0" }} </td>
                    @if(floatval($reportItem->failed_top_average) >= $hightlightPositionLeakFromPercent)
                        <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $reportItem->failed_top_average ? $reportItem->failed_top_average . '%' : "-" }} </td>
                    @else
                        <td class="text-right tw-pr-1"> {{ $reportItem->failed_top_average ? $reportItem->failed_top_average . '%' : "-" }} </td>
                    @endif
                    <td class="text-right tw-pr-1"> {{ $reportItem->failed_side_count ? $reportItem->failed_side_count : "0" }} </td>
                    @if(floatval($reportItem->failed_side_average) >= $hightlightPositionLeakFromPercent)
                        <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $reportItem->failed_side_average ? $reportItem->failed_side_average . '%' : "-" }} </td>
                    @else
                        <td class="text-right tw-pr-1"> {{ $reportItem->failed_side_average ? $reportItem->failed_side_average . '%' : "-" }} </td>
                    @endif
                    <td class="text-right tw-pr-1"> {{ $reportItem->failed_bottom_count ? $reportItem->failed_bottom_count : "0" }} </td>
                    @if(floatval($reportItem->failed_bottom_average) >= $hightlightPositionLeakFromPercent)
                        <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $reportItem->failed_bottom_average ? $reportItem->failed_bottom_average . '%' : "-" }} </td>
                    @else
                        <td class="text-right tw-pr-1"> {{ $reportItem->failed_bottom_average ? $reportItem->failed_bottom_average . '%' : "-" }} </td>
                    @endif
    
                </tr>
            
            @endforeach

            <tr>

                <td width="25%" colspan="2" class="text-left tw-pl-2"> รวมทั้งหมด </td>

                <td width="10%" class="text-center"> {{ $summarizedReportItem->count ? $summarizedReportItem->count : "0" }} </td>
                <td width="10%" class="text-center"> {{ $summarizedReportItem->failed_count ? $summarizedReportItem->failed_count : "0" }} </td>
                @if(floatval($summarizedReportItem->failed_average) >= $hightlightPositionLeakFromPercent)
                    <td width="10%" class="text-right tw-pr-2" style="background-color: #fff0a0;"> {{ $summarizedReportItem->failed_average ? $summarizedReportItem->failed_average . '%' : "-" }} </td>
                @else
                    <td width="10%" class="text-right tw-pr-2"> {{ $summarizedReportItem->failed_average ? $summarizedReportItem->failed_average . '%' : "-" }} </td>
                @endif

                <td width="9%" class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_top_count ? $summarizedReportItem->failed_top_count : "0" }} </td>
                @if(floatval($summarizedReportItem->failed_top_average) >= $hightlightPositionLeakFromPercent)
                    <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $summarizedReportItem->failed_top_average ? $summarizedReportItem->failed_top_average . '%' : "-" }} </td>
                @else
                    <td class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_top_average ? $summarizedReportItem->failed_top_average . '%' : "-" }} </td>
                @endif
                <td class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_side_count ? $summarizedReportItem->failed_side_count : "0" }} </td>
                @if(floatval($summarizedReportItem->failed_side_average) >= $hightlightPositionLeakFromPercent)
                    <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $summarizedReportItem->failed_side_average ? $summarizedReportItem->failed_side_average . '%' : "-" }} </td>
                @else
                    <td class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_side_average ? $summarizedReportItem->failed_side_average . '%' : "-" }} </td>
                @endif
                <td class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_bottom_count ? $summarizedReportItem->failed_bottom_count : "0" }} </td>
                @if(floatval($summarizedReportItem->failed_bottom_average) >= $hightlightPositionLeakFromPercent)
                    <td class="text-right tw-pr-1" style="background-color: #fff0a0;"> {{ $summarizedReportItem->failed_bottom_average ? $summarizedReportItem->failed_bottom_average . '%' : "-" }} </td>
                @else
                    <td class="text-right tw-pr-1"> {{ $summarizedReportItem->failed_bottom_average ? $summarizedReportItem->failed_bottom_average . '%' : "-" }} </td>
                @endif

            </tr>
    
        </tbody>
    </table>

    <table border="0" width="100%" class="tw-mt-4">
        <tr>
            <td width="10%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 11px;"> หมายเหตุ </p>
            </td>
            <td width="90%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 11px;"> 
                    1. ค่ามาตรฐานของอัตรารั่วฟิล์มห่อซองบุหรี่ คือ น้อยกว่าหรือเท่ากับ 200 ml/Min
                </p>
            </td>
        </tr>
        @if(count($summarizedReportItem->result_status_passed_machines) > 0)
        <tr>
            <td width="10%" class="text-left"></td>
            <td width="90%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 11px;"> 
                    2. เครื่องหมายเลข 
                    @if(count($summarizedReportItem->result_status_passed_machines) > 1)
                        @foreach($summarizedReportItem->result_status_passed_machines as $pmIndex => $resultStatusPassedMachine)
                            @if($pmIndex == (count($summarizedReportItem->result_status_passed_machines)-1))
                                และ {{ $resultStatusPassedMachine }}
                            @elseif($pmIndex == (count($summarizedReportItem->result_status_passed_machines)-2))
                                {{ $resultStatusPassedMachine }}
                            @else
                                {{ $resultStatusPassedMachine }},
                            @endif
                        @endforeach
                    @else
                        {{ $summarizedReportItem->result_status_passed_machines[0] }}
                    @endif
                    อยู่ในเกณฑ์มาตรฐาน	
                </p>
            </td>
        </tr>
        @endif
    </table>

</div>