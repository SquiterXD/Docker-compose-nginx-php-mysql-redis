<table class="table table-bordered">

@if($taskTypeCode == "200" || $taskTypeCode == "")

    {{-- CIG : WEIGHT --}}
    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : บุหรี่
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineCigWeightItems as $index => $reportMachineCigWeightItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->percent_normal_items ? number_format($reportMachineCigWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigWeightItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigWeightItem->avg_result_value ? number_format($reportMachineCigWeightItem->avg_result_value, 4) : ($reportMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigWeightItem->median_result_value ? number_format($reportMachineCigWeightItem->median_result_value, 4) : ($reportMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigWeightItem->sd_result_value ? number_format($reportMachineCigWeightItem->sd_result_value, 3) : ($reportMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigWeightItem->variance_result_value ? number_format($reportMachineCigWeightItem->variance_result_value, 3) : ($reportMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigWeightItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigWeightItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigWeightItem->percent_normal_items ? number_format($reportSummaryMachineCigWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigWeightItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigWeightItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigWeightItem->avg_result_value ? number_format($reportSummaryMachineCigWeightItem->avg_result_value, 4) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigWeightItem->median_result_value ? number_format($reportSummaryMachineCigWeightItem->median_result_value, 4) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigWeightItem->sd_result_value ? number_format($reportSummaryMachineCigWeightItem->sd_result_value, 3) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigWeightItem->variance_result_value ? number_format($reportSummaryMachineCigWeightItem->variance_result_value, 3) : ($reportSummaryMachineCigWeightItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

    {{-- CIG : SIZEL --}}

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : บุหรี่
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 2 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineCigSizeLItems as $index => $reportMachineCigSizeLItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->percent_normal_items ? number_format($reportMachineCigSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigSizeLItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigSizeLItem->avg_result_value ? number_format($reportMachineCigSizeLItem->avg_result_value, 2) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigSizeLItem->median_result_value ? number_format($reportMachineCigSizeLItem->median_result_value, 2) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigSizeLItem->sd_result_value ? number_format($reportMachineCigSizeLItem->sd_result_value, 3) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigSizeLItem->variance_result_value ? number_format($reportMachineCigSizeLItem->variance_result_value, 3) : ($reportMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigSizeLItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigSizeLItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigSizeLItem->percent_normal_items ? number_format($reportSummaryMachineCigSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigSizeLItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigSizeLItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigSizeLItem->avg_result_value ? number_format($reportSummaryMachineCigSizeLItem->avg_result_value, 2) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigSizeLItem->median_result_value ? number_format($reportSummaryMachineCigSizeLItem->median_result_value, 2) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigSizeLItem->sd_result_value ? number_format($reportSummaryMachineCigSizeLItem->sd_result_value, 3) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigSizeLItem->variance_result_value ? number_format($reportSummaryMachineCigSizeLItem->variance_result_value, 3) : ($reportSummaryMachineCigSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

    {{-- CIG : PD OPEN --}}

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : บุหรี่
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 3 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineCigPdOpenItems as $index => $reportMachineCigPdOpenItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->percent_normal_items ? number_format($reportMachineCigPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigPdOpenItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigPdOpenItem->avg_result_value ? number_format($reportMachineCigPdOpenItem->avg_result_value, 2) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigPdOpenItem->median_result_value ? number_format($reportMachineCigPdOpenItem->median_result_value, 2) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigPdOpenItem->sd_result_value ? number_format($reportMachineCigPdOpenItem->sd_result_value, 3) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigPdOpenItem->variance_result_value ? number_format($reportMachineCigPdOpenItem->variance_result_value, 3) : ($reportMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigPdOpenItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigPdOpenItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigPdOpenItem->percent_normal_items ? number_format($reportSummaryMachineCigPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigPdOpenItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigPdOpenItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigPdOpenItem->avg_result_value ? number_format($reportSummaryMachineCigPdOpenItem->avg_result_value, 2) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigPdOpenItem->median_result_value ? number_format($reportSummaryMachineCigPdOpenItem->median_result_value, 2) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigPdOpenItem->sd_result_value ? number_format($reportSummaryMachineCigPdOpenItem->sd_result_value, 3) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigPdOpenItem->variance_result_value ? number_format($reportSummaryMachineCigPdOpenItem->variance_result_value, 3) : ($reportSummaryMachineCigPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

    {{-- CIG : TIP VENT --}}

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Tip Vent (%) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : บุหรี่
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 4 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineCigTipVentItems as $index => $reportMachineCigTipVentItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->percent_normal_items ? number_format($reportMachineCigTipVentItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineCigTipVentItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigTipVentItem->avg_result_value ? number_format($reportMachineCigTipVentItem->avg_result_value, 2) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigTipVentItem->median_result_value ? number_format($reportMachineCigTipVentItem->median_result_value, 2) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigTipVentItem->sd_result_value ? number_format($reportMachineCigTipVentItem->sd_result_value, 3) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineCigTipVentItem->variance_result_value ? number_format($reportMachineCigTipVentItem->variance_result_value, 3) : ($reportMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigTipVentItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigTipVentItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigTipVentItem->percent_normal_items ? number_format($reportSummaryMachineCigTipVentItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigTipVentItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineCigTipVentItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigTipVentItem->avg_result_value ? number_format($reportSummaryMachineCigTipVentItem->avg_result_value, 2) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigTipVentItem->median_result_value ? number_format($reportSummaryMachineCigTipVentItem->median_result_value, 2) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigTipVentItem->sd_result_value ? number_format($reportSummaryMachineCigTipVentItem->sd_result_value, 3) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineCigTipVentItem->variance_result_value ? number_format($reportSummaryMachineCigTipVentItem->variance_result_value, 3) : ($reportSummaryMachineCigTipVentItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

@endif

@if($taskTypeCode == "300" || $taskTypeCode == "")

    {{-- FILTER : WEIGHT --}}
    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : ก้นกรอง
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 5 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineFilterWeightItems as $index => $reportMachineFilterWeightItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->percent_normal_items ? number_format($reportMachineFilterWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterWeightItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterWeightItem->avg_result_value ? number_format($reportMachineFilterWeightItem->avg_result_value, 4) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterWeightItem->median_result_value ? number_format($reportMachineFilterWeightItem->median_result_value, 4) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterWeightItem->sd_result_value ? number_format($reportMachineFilterWeightItem->sd_result_value, 3) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterWeightItem->variance_result_value ? number_format($reportMachineFilterWeightItem->variance_result_value, 3) : ($reportMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterWeightItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterWeightItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterWeightItem->percent_normal_items ? number_format($reportSummaryMachineFilterWeightItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterWeightItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterWeightItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterWeightItem->avg_result_value ? number_format($reportSummaryMachineFilterWeightItem->avg_result_value, 4) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterWeightItem->median_result_value ? number_format($reportSummaryMachineFilterWeightItem->median_result_value, 4) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.0000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterWeightItem->sd_result_value ? number_format($reportSummaryMachineFilterWeightItem->sd_result_value, 3) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterWeightItem->variance_result_value ? number_format($reportSummaryMachineFilterWeightItem->variance_result_value, 3) : ($reportSummaryMachineFilterWeightItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

    {{-- FILTER : SIZEL --}}

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : ก้นกรอง
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 6 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineFilterSizeLItems as $index => $reportMachineFilterSizeLItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->percent_normal_items ? number_format($reportMachineFilterSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterSizeLItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterSizeLItem->avg_result_value ? number_format($reportMachineFilterSizeLItem->avg_result_value, 2) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterSizeLItem->median_result_value ? number_format($reportMachineFilterSizeLItem->median_result_value, 2) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterSizeLItem->sd_result_value ? number_format($reportMachineFilterSizeLItem->sd_result_value, 3) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterSizeLItem->variance_result_value ? number_format($reportMachineFilterSizeLItem->variance_result_value, 3) : ($reportMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterSizeLItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterSizeLItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterSizeLItem->percent_normal_items ? number_format($reportSummaryMachineFilterSizeLItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterSizeLItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterSizeLItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterSizeLItem->avg_result_value ? number_format($reportSummaryMachineFilterSizeLItem->avg_result_value, 2) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterSizeLItem->median_result_value ? number_format($reportSummaryMachineFilterSizeLItem->median_result_value, 2) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterSizeLItem->sd_result_value ? number_format($reportSummaryMachineFilterSizeLItem->sd_result_value, 3) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterSizeLItem->variance_result_value ? number_format($reportSummaryMachineFilterSizeLItem->variance_result_value, 3) : ($reportSummaryMachineFilterSizeLItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

    {{-- FILTER : PD OPEN --}}

    <thead>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="6" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </p>
            </th>
            <th colspan="2" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
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
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                ประเภท : ก้นกรอง
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 7 / 7
            </th>
        </tr>
        <tr>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> หมายเลขเครื่อง </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ตรวจสอบทั้งหมด (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> อยู่ในเกณฑ์ (%) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ต่ำกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> สูงกว่าเกณฑ์ (รายการ) </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเฉลี่ย </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่ามัธยฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าเบี่ยงเบนมาตรฐาน </th>
            <th width="20" style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> ค่าความแปรปรวน </th>

        </tr>
    </thead>
    <tbody>
        
        @foreach($reportMachineFilterPdOpenItems as $index => $reportMachineFilterPdOpenItem)

            <tr>

                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->machine_set }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->count_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->count_normal_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->percent_normal_items ? number_format($reportMachineFilterPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->count_lower_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                    {{ $reportMachineFilterPdOpenItem->count_higher_items }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterPdOpenItem->avg_result_value ? number_format($reportMachineFilterPdOpenItem->avg_result_value, 2) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterPdOpenItem->median_result_value ? number_format($reportMachineFilterPdOpenItem->median_result_value, 2) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterPdOpenItem->sd_result_value ? number_format($reportMachineFilterPdOpenItem->sd_result_value, 3) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                    {{ $reportMachineFilterPdOpenItem->variance_result_value ? number_format($reportMachineFilterPdOpenItem->variance_result_value, 3) : ($reportMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
                </td>
                
            </tr>

        @endforeach
        
        <tr>

            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                รวมทั้งหมด
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->count_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->count_normal_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->percent_normal_items ? number_format($reportSummaryMachineFilterPdOpenItem->percent_normal_items, 0) . "%" : "0%"  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->count_lower_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: center;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->count_higher_items }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->avg_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->avg_result_value, 2) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->median_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->median_result_value, 2) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.00" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->sd_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->sd_result_value, 3) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            <td style="height: 20px; border: 1px solid #000000; vertical-align: top; text-align: right;"> 
                {{ $reportSummaryMachineFilterPdOpenItem->variance_result_value ? number_format($reportSummaryMachineFilterPdOpenItem->variance_result_value, 3) : ($reportSummaryMachineFilterPdOpenItem->count_items > 0 ? "0.000" : "-")  }} 
            </td>
            
        </tr>
        <tr>
            <td colspan="10" style="height: 20px; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"></td>
        </tr>

    </tbody>

@endif

</table>