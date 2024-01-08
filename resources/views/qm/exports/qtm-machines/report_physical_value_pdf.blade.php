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

@if($searchInputs['task_type_code'] == "200" || $searchInputs['task_type_code'] == "")

    {{-- CIG : WEIGHT --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : บุหรี่ </span>
                        <span class="tw-pl-20"> หน้าที่ 1 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineCigWeightItems as $index => $reportMachineCigWeightItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->percent_normal_items ? number_format($reportMachineCigWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigWeightItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigWeightItem->avg_result_value ? number_format($reportMachineCigWeightItem->avg_result_value, 4) : ($reportMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigWeightItem->median_result_value ? number_format($reportMachineCigWeightItem->median_result_value, 4) : ($reportMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigWeightItem->sd_result_value ? number_format($reportMachineCigWeightItem->sd_result_value, 3) : ($reportMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigWeightItem->variance_result_value ? number_format($reportMachineCigWeightItem->variance_result_value, 3) : ($reportMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach
                
                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigWeightItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigWeightItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigWeightItem->percent_normal_items ? number_format($reportSummaryMachineCigWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigWeightItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigWeightItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigWeightItem->avg_result_value ? number_format($reportSummaryMachineCigWeightItem->avg_result_value, 4) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigWeightItem->median_result_value ? number_format($reportSummaryMachineCigWeightItem->median_result_value, 4) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigWeightItem->sd_result_value ? number_format($reportSummaryMachineCigWeightItem->sd_result_value, 3) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigWeightItem->variance_result_value ? number_format($reportSummaryMachineCigWeightItem->variance_result_value, 3) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

    {{-- CIG : SizeL --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : บุหรี่ </span>
                        <span class="tw-pl-20"> หน้าที่ 2 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineCigSizeLItems as $index => $reportMachineCigSizeLItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->percent_normal_items ? number_format($reportMachineCigSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigSizeLItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigSizeLItem->avg_result_value ? number_format($reportMachineCigSizeLItem->avg_result_value, 2) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigSizeLItem->median_result_value ? number_format($reportMachineCigSizeLItem->median_result_value, 2) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigSizeLItem->sd_result_value ? number_format($reportMachineCigSizeLItem->sd_result_value, 3) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigSizeLItem->variance_result_value ? number_format($reportMachineCigSizeLItem->variance_result_value, 3) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigSizeLItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigSizeLItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigSizeLItem->percent_normal_items ? number_format($reportSummaryMachineCigSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigSizeLItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigSizeLItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigSizeLItem->avg_result_value ? number_format($reportSummaryMachineCigSizeLItem->avg_result_value, 2) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigSizeLItem->median_result_value ? number_format($reportSummaryMachineCigSizeLItem->median_result_value, 2) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigSizeLItem->sd_result_value ? number_format($reportSummaryMachineCigSizeLItem->sd_result_value, 3) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigSizeLItem->variance_result_value ? number_format($reportSummaryMachineCigSizeLItem->variance_result_value, 3) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

    {{-- CIG : PD Open --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : บุหรี่ </span>
                        <span class="tw-pl-20"> หน้าที่ 3 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineCigPdOpenItems as $index => $reportMachineCigPdOpenItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->percent_normal_items ? number_format($reportMachineCigPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigPdOpenItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigPdOpenItem->avg_result_value ? number_format($reportMachineCigPdOpenItem->avg_result_value, 2) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigPdOpenItem->median_result_value ? number_format($reportMachineCigPdOpenItem->median_result_value, 2) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigPdOpenItem->sd_result_value ? number_format($reportMachineCigPdOpenItem->sd_result_value, 3) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigPdOpenItem->variance_result_value ? number_format($reportMachineCigPdOpenItem->variance_result_value, 3) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigPdOpenItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigPdOpenItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigPdOpenItem->percent_normal_items ? number_format($reportSummaryMachineCigPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigPdOpenItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigPdOpenItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigPdOpenItem->avg_result_value ? number_format($reportSummaryMachineCigPdOpenItem->avg_result_value, 2) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigPdOpenItem->median_result_value ? number_format($reportSummaryMachineCigPdOpenItem->median_result_value, 2) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigPdOpenItem->sd_result_value ? number_format($reportSummaryMachineCigPdOpenItem->sd_result_value, 3) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigPdOpenItem->variance_result_value ? number_format($reportSummaryMachineCigPdOpenItem->variance_result_value, 3) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

    {{-- CIG : Tip Vent --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Tip Vent (%) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : บุหรี่ </span>
                        <span class="tw-pl-20"> หน้าที่ 4 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineCigTipVentItems as $index => $reportMachineCigTipVentItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->percent_normal_items ? number_format($reportMachineCigTipVentItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigTipVentItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigTipVentItem->avg_result_value ? number_format($reportMachineCigTipVentItem->avg_result_value, 2) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigTipVentItem->median_result_value ? number_format($reportMachineCigTipVentItem->median_result_value, 2) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigTipVentItem->sd_result_value ? number_format($reportMachineCigTipVentItem->sd_result_value, 3) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineCigTipVentItem->variance_result_value ? number_format($reportMachineCigTipVentItem->variance_result_value, 3) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigTipVentItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigTipVentItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigTipVentItem->percent_normal_items ? number_format($reportSummaryMachineCigTipVentItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigTipVentItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineCigTipVentItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigTipVentItem->avg_result_value ? number_format($reportSummaryMachineCigTipVentItem->avg_result_value, 2) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigTipVentItem->median_result_value ? number_format($reportSummaryMachineCigTipVentItem->median_result_value, 2) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigTipVentItem->sd_result_value ? number_format($reportSummaryMachineCigTipVentItem->sd_result_value, 3) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineCigTipVentItem->variance_result_value ? number_format($reportSummaryMachineCigTipVentItem->variance_result_value, 3) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

@endif

@if($searchInputs['task_type_code'] == "300" || $searchInputs['task_type_code'] == "")

    {{-- FILTER : WEIGHT --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : ก้นกรอง </span>
                        <span class="tw-pl-20"> หน้าที่ 5 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineFilterWeightItems as $index => $reportMachineFilterWeightItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->percent_normal_items ? number_format($reportMachineFilterWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterWeightItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterWeightItem->avg_result_value ? number_format($reportMachineFilterWeightItem->avg_result_value, 4) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterWeightItem->median_result_value ? number_format($reportMachineFilterWeightItem->median_result_value, 4) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterWeightItem->sd_result_value ? number_format($reportMachineFilterWeightItem->sd_result_value, 3) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterWeightItem->variance_result_value ? number_format($reportMachineFilterWeightItem->variance_result_value, 3) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterWeightItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterWeightItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterWeightItem->percent_normal_items ? number_format($reportSummaryMachineFilterWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterWeightItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterWeightItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterWeightItem->avg_result_value ? number_format($reportSummaryMachineFilterWeightItem->avg_result_value, 4) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterWeightItem->median_result_value ? number_format($reportSummaryMachineFilterWeightItem->median_result_value, 4) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterWeightItem->sd_result_value ? number_format($reportSummaryMachineFilterWeightItem->sd_result_value, 3) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterWeightItem->variance_result_value ? number_format($reportSummaryMachineFilterWeightItem->variance_result_value, 3) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

    {{-- FILTER : SizeL --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : ก้นกรอง </span>
                        <span class="tw-pl-20"> หน้าที่ 6 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineFilterSizeLItems as $index => $reportMachineFilterSizeLItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->percent_normal_items ? number_format($reportMachineFilterSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterSizeLItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterSizeLItem->avg_result_value ? number_format($reportMachineFilterSizeLItem->avg_result_value, 2) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterSizeLItem->median_result_value ? number_format($reportMachineFilterSizeLItem->median_result_value, 2) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterSizeLItem->sd_result_value ? number_format($reportMachineFilterSizeLItem->sd_result_value, 3) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterSizeLItem->variance_result_value ? number_format($reportMachineFilterSizeLItem->variance_result_value, 3) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterSizeLItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterSizeLItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterSizeLItem->percent_normal_items ? number_format($reportSummaryMachineFilterSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterSizeLItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterSizeLItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterSizeLItem->avg_result_value ? number_format($reportSummaryMachineFilterSizeLItem->avg_result_value, 2) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterSizeLItem->median_result_value ? number_format($reportSummaryMachineFilterSizeLItem->median_result_value, 2) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterSizeLItem->sd_result_value ? number_format($reportSummaryMachineFilterSizeLItem->sd_result_value, 3) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterSizeLItem->variance_result_value ? number_format($reportSummaryMachineFilterSizeLItem->variance_result_value, 3) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

    {{-- FILTER : PD Open --}}

    <div style="min-height: 55px; min-height: 55px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;">  </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="30%" class="tw-p-0 text-left"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="tw-p-0 text-center"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="tw-p-0 text-right"> 
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> 
                        <span> ประเภท : ก้นกรอง </span>
                        <span class="tw-pl-20"> หน้าที่ 7 / 7  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th width="10%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="10%" class="text-center"> ตรวจสอบทั้งหมด (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> อยู่ในเกณฑ์ (%) </th>
                    <th width="10%" class="text-center"> ต่ำกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> สูงกว่าเกณฑ์ (รายการ) </th>
                    <th width="10%" class="text-center"> ค่าเฉลี่ย </th>
                    <th width="10%" class="text-center"> ค่ามัธยฐาน </th>
                    <th width="10%" class="text-center"> ค่าเบี่ยงเบนมาตรฐาน </th>
                    <th width="10%" class="text-center"> ค่าความแปรปรวน </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineFilterPdOpenItems as $index => $reportMachineFilterPdOpenItem)

                    <tr height="13">
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->count_normal_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->percent_normal_items ? number_format($reportMachineFilterPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->count_lower_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterPdOpenItem->count_higher_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterPdOpenItem->avg_result_value ? number_format($reportMachineFilterPdOpenItem->avg_result_value, 2) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterPdOpenItem->median_result_value ? number_format($reportMachineFilterPdOpenItem->median_result_value, 2) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterPdOpenItem->sd_result_value ? number_format($reportMachineFilterPdOpenItem->sd_result_value, 3) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-right"> 
                            {{ $reportMachineFilterPdOpenItem->variance_result_value ? number_format($reportMachineFilterPdOpenItem->variance_result_value, 3) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                        </td>
                        
                    </tr>
        
                @endforeach

                <tr height="13">
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->count_normal_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->percent_normal_items ? number_format($reportSummaryMachineFilterPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->count_lower_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->count_higher_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->avg_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->avg_result_value, 2) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->median_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->median_result_value, 2) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->sd_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->sd_result_value, 3) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-right"> 
                        {{ $reportSummaryMachineFilterPdOpenItem->variance_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->variance_result_value, 3) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

@endif