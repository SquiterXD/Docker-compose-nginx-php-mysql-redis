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

@foreach ($reportPerPageItems as $reportPerPageItemIndex => $reportPerPageItem)

    <div style="min-height: 105px; max-height: 105px; margin-top: 200px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="text-left" colspan="2"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 17px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="text-right" colspan="2"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="text-left" colspan="2"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบบันทึกการตรวจสอบข้อบกพร่องในกระบวนการผลิต </p>
                </td>
                <td width="30%" class="text-right" colspan="2"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="text-left" colspan="2"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="15%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบ : รายละเอียด </p>
                </td>
                <td width="15%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ {{ $reportPerPageItem["start_page"] }} / {{ $totalPage }} </p>
                </td>
            </tr>
            <tr>
                <td width="20%" class="text-left"> 
                    <p class="tw-mb-0 tw-pt-2" style="font-size: 15px; font-weight: bold;"> กระบวนการตรวจคุณภาพ : {{ $summaryReportItem["qm_process"] }} </p>
                </td>
                <td width="10%" class="text-left"> 
                    <p class="tw-mb-0 tw-pt-2" style="font-size: 15px; font-weight: bold;"> หมายเลขเครื่อง : {{ $summaryReportItem["machine_set"] }} </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-0 tw-pt-2" style="font-size: 15px; font-weight: bold;"> รายการตรวจคุณภาพ : {{ $summaryReportItem["check_list"] }} </p>
                </td>
                <td width="30%" class="text-right" colspan="2"> 
                    
                </td>
            </tr>
        </table>

    </div>

    <div class="tw-mt-4" style="{{ $reportPerPageItemIndex+1 == count($reportPerPageItems) ? 'min-height: 300px;' : 'min-height: 600px;' }} max-height: 600px;">

        <table border="1" width="100%" style="font-size: 15px;">
            <thead>
                <tr>
                    <th width="3%" class="text-center"> รายการ  </th>
                    <th width="10%" class="text-center"> เลขที่การตรวจสอบ  </th>
                    <th width="6%" class="text-center"> วันที่  </th>
                    <th width="4%" class="text-center"> เวลา </th>
                    <th width="8%" class="text-center"> ประเภทเครื่อง  </th>
                    <th width="12%" class="text-center"> ตราบุหรี่  </th>
                    <th width="18%" class="text-center"> รายละเอียดปัญหา/ข้อบกพร่อง </th>
                    <th width="6%" class="text-center"> หน่วยนับ  </th>
                    <th width="6%" class="text-center"> จำนวน  </th>
                    <th width="6%" class="text-center"> ความรุนแรง  </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportPerPageItem["report_items"] as $index => $reportItem)
                    <tr style="height: 25px;">
                        <td class="text-center">
                            {{ $index+1 }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem['sample_no'] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem['date_drawn_formatted'] }} 
                        </td>
                        <td class="text-center">
                            {{ $reportItem['time_drawn_formatted'] }}
                        </td>
                        <td class="text-center tw-px-1">
                            {{ $reportItem['qc_process_machine_type_desc'] }} 
                        </td>
                        <td class="text-center">
                            {{ $reportItem['brand_desc'] }}
                        </td>
                        <td class="text-center tw-px-1">
                            {{ $reportItem['result']['test_desc'] }}
                        </td>
                        <td class="text-center tw-px-1">
                            {{ $reportItem['result']['test_unit_desc'] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem['result']['result_value'] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem['test_serverity_code'] ? $reportItem['test_serverity_code'] : "-" }}
                        </td>
                    </tr>
                @endforeach
                @if($reportPerPageItemIndex == (count($reportPerPageItems)-1))
                    <tr style="height: 25px;">
                        <th class="text-right" colspan="7">
                            <div class="tw-pr-2"> รวม </div> 
                        </th>
                        <th class="text-center">
                            {{ $summaryReportItem['test_unit_desc'] }}
                        </th>
                        <th class="text-center">
                            {{ $summaryReportItem['result_value'] }}
                        </th>
                        <th class="text-center">
                            {{ $summaryReportItem['test_serverity_code'] ? $summaryReportItem['test_serverity_code'] : "-" }} 
                        </th>
                    </tr>
                @endif

            </tbody>
        </table>

    </div>

@endforeach