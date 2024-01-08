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

{{-- CIG --}}
@if($taskTypeCode == "200")

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
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน </p>
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
                        <span class="tw-pl-20"> หน้าที่ 1 / 1  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th rowspan="2" width="12%" class="text-center"> หมายเลขเครื่อง </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_Weight </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_SizeL </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_PD Open </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_Tip Vent </th>
                    <th rowspan="2" width="10%" class="text-center"> จำนวนรวม </th>
                    <th rowspan="2" width="10%" class="text-center"> เปอร์เซ็นต์รวม </th>
                </tr>
                <tr>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineCigItems as $index => $reportMachineCigItem)

                    @if($reportMachineCigItem->count_items > 0)

                    <tr height="13">

                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->MACHINE_DATA->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->WEIGHT->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->WEIGHT->percent_failed_items ? number_format($reportMachineCigItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->SIZEL->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->SIZEL->percent_failed_items ? number_format($reportMachineCigItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->PDOPEN->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->PDOPEN->percent_failed_items ? number_format($reportMachineCigItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->TIPVENT->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->TIPVENT->percent_failed_items ? number_format($reportMachineCigItem->TIPVENT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineCigItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ number_format((floatval($reportMachineCigItem->WEIGHT->percent_failed_items) + floatval($reportMachineCigItem->SIZEL->percent_failed_items) + floatval($reportMachineCigItem->PDOPEN->percent_failed_items) + floatval($reportMachineCigItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                        </td>
                        
                    </tr>

                    @endif
        
                @endforeach
                
                <tr height="13">

                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->WEIGHT->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->WEIGHT->percent_failed_items ? number_format($reportSummarizedMachineCigItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->SIZEL->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->SIZEL->percent_failed_items ? number_format($reportSummarizedMachineCigItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->PDOPEN->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->PDOPEN->percent_failed_items ? number_format($reportSummarizedMachineCigItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->TIPVENT->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->TIPVENT->percent_failed_items ? number_format($reportSummarizedMachineCigItem->TIPVENT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineCigItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ number_format((floatval($reportSummarizedMachineCigItem->WEIGHT->percent_failed_items) + floatval($reportSummarizedMachineCigItem->SIZEL->percent_failed_items) + floatval($reportSummarizedMachineCigItem->PDOPEN->percent_failed_items) + floatval($reportSummarizedMachineCigItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

@endif

{{-- FILTER --}}
@if($taskTypeCode == "300")

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
                    <p class="tw-mb-0" style="font-size: 12px; font-weight: bold;"> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน </p>
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
                        <span class="tw-pl-20"> หน้าที่ 1 / 1  </span>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 600px; max-height: 600px;" class="tw-pt-2">

        <table border="1" width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <th rowspan="2" width="12%" class="text-center"> หมายเลขเครื่อง </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_Weight </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_SizeL </th>
                    <th colspan="2" width="12%" class="text-center"> QTM_PD Open </th>
                    <th rowspan="2" width="10%" class="text-center"> จำนวนรวม </th>
                    <th rowspan="2" width="10%" class="text-center"> เปอร์เซ็นต์รวม </th>
                </tr>
                <tr>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                    <th width="6%" class="text-center"> จำนวนรายการ </th>
                    <th width="6%" class="text-center"> เปอร์เซ็นต์ </th>
                </tr>
            </tbody>
            <tbody>

                @foreach($reportMachineFilterItems as $index => $reportMachineFilterItem)

                    @if($reportMachineFilterItem->count_items > 0)

                    <tr height="13">

                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->MACHINE_DATA->machine_set }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->WEIGHT->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->WEIGHT->percent_failed_items ? number_format($reportMachineFilterItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->SIZEL->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->SIZEL->percent_failed_items ? number_format($reportMachineFilterItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->PDOPEN->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->PDOPEN->percent_failed_items ? number_format($reportMachineFilterItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ $reportMachineFilterItem->count_items }} 
                        </td>
                        <td class="tw-px-2 tw-py-0 text-center"> 
                            {{ number_format((floatval($reportMachineFilterItem->WEIGHT->percent_failed_items) + floatval($reportMachineFilterItem->SIZEL->percent_failed_items) + floatval($reportMachineFilterItem->PDOPEN->percent_failed_items) + floatval($reportMachineFilterItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                        </td>
                        
                    </tr>

                    @endif
        
                @endforeach

                <tr height="13">

                    <td class="tw-px-2 tw-py-0 text-center"> 
                        รวมทั้งหมด
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->WEIGHT->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->SIZEL->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->SIZEL->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->PDOPEN->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ $reportSummarizedMachineFilterItem->count_items }} 
                    </td>
                    <td class="tw-px-2 tw-py-0 text-center"> 
                        {{ number_format((floatval($reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->SIZEL->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                    </td>
                    
                </tr>

            </tbody>

        </table>

    </div>

@endif