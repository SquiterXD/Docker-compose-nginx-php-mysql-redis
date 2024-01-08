<table class="table table-bordered">

{{-- CIG --}}
@if($taskTypeCode == "200")

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="7" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="7" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="7" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : บุหรี่
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>

        <tr>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_Weight </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_SizeL </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_PD Open </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_Tip Vent </th>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรวม </th>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์รวม </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
        </tr>

    </thead>
    <tbody>
        
        @foreach($reportMachineCigItems as $index => $reportMachineCigItem)

            @if($reportMachineCigItem->count_items > 0)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->MACHINE_DATA->machine_set }} 
                </td>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->WEIGHT->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->WEIGHT->percent_failed_items ? number_format($reportMachineCigItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->SIZEL->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->SIZEL->percent_failed_items ? number_format($reportMachineCigItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->PDOPEN->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->PDOPEN->percent_failed_items ? number_format($reportMachineCigItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->TIPVENT->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->TIPVENT->percent_failed_items ? number_format($reportMachineCigItem->TIPVENT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ number_format((floatval($reportMachineCigItem->WEIGHT->percent_failed_items) + floatval($reportMachineCigItem->SIZEL->percent_failed_items) + floatval($reportMachineCigItem->PDOPEN->percent_failed_items) + floatval($reportMachineCigItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                </td>
                
            </tr>

            @endif

        @endforeach

        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->WEIGHT->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->WEIGHT->percent_failed_items ? number_format($reportSummarizedMachineCigItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->SIZEL->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->SIZEL->percent_failed_items ? number_format($reportSummarizedMachineCigItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->PDOPEN->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->PDOPEN->percent_failed_items ? number_format($reportSummarizedMachineCigItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->TIPVENT->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->TIPVENT->percent_failed_items ? number_format($reportSummarizedMachineCigItem->TIPVENT->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineCigItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ number_format((floatval($reportSummarizedMachineCigItem->WEIGHT->percent_failed_items) + floatval($reportSummarizedMachineCigItem->SIZEL->percent_failed_items) + floatval($reportSummarizedMachineCigItem->PDOPEN->percent_failed_items) + floatval($reportSummarizedMachineCigItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

@endif

{{-- FILTER  --}}
@if($taskTypeCode == "300")

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : ก้นกรอง
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>

        <tr>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_Weight </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_SizeL </th>
            <th colspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> QTM_PD Open </th>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรวม </th>
            <th rowspan="2" width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์รวม </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> จำนวนรายการ </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> เปอร์เซ็นต์ </th>
        </tr>

    </thead>
    <tbody>
        
        @foreach($reportMachineFilterItems as $index => $reportMachineFilterItem)

            @if($reportMachineFilterItem->count_items > 0)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->MACHINE_DATA->machine_set }} 
                </td>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->WEIGHT->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->WEIGHT->percent_failed_items ? number_format($reportMachineFilterItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->SIZEL->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->SIZEL->percent_failed_items ? number_format($reportMachineFilterItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->PDOPEN->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->PDOPEN->percent_failed_items ? number_format($reportMachineFilterItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
                </td>
                
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ number_format((floatval($reportMachineFilterItem->WEIGHT->percent_failed_items) + floatval($reportMachineFilterItem->SIZEL->percent_failed_items) + floatval($reportMachineFilterItem->PDOPEN->percent_failed_items) + floatval($reportMachineFilterItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
                </td>
                
            </tr>

            @endif

        @endforeach

        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->WEIGHT->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->SIZEL->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->SIZEL->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->SIZEL->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->PDOPEN->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items ? number_format($reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items, 2) . "%" : "0.00%"  }} 
            </td>
            
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummarizedMachineFilterItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ number_format((floatval($reportSummarizedMachineFilterItem->WEIGHT->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->SIZEL->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->PDOPEN->percent_failed_items) + floatval($reportSummarizedMachineFilterItem->TIPVENT->percent_failed_items)), 2) . "%" }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

@endif

</table>