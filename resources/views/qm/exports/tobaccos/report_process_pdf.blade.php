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

    <div style="min-height: 85px; max-height: 85px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="30%" class="text-left"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="30%" class="text-right"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
        </table>
        <table border="0" width="100%">
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;">  </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> รายงานผลการตรวจสอบคุณภาพในกระบวนการผลิตยาเส้น </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
        </table>
        <table border="0" width="100%">
            <tr>
                <td width="30%" class="text-left"> 
                    <p class="tw-mb-1" style="font-size: 13px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="40%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="30%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> หน้าที่ {{ $reportPerPageItem["start_page"] }} / {{ $totalPage }} </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 830px; max-height: 830px;">

        <table border="1" width="100%" style="font-size: 14px;">
            <thead>
                <tr>
                    <th width="13%" class="text-center"> กลุ่มงาน </th>
                    <th width="10%" class="text-center"> ตรา/ชุด </th>
                    <th width="9%" class="text-center"> วันที่ </th>
                    <th width="5%" class="text-center"> เวลา </th>
                    <th width="8%" class="text-center"> จุดตรวจสอบ </th>
                    <th width="10%" class="text-center"> ค่ามาตรฐานความชื้น </th>
                    <th width="8%" class="text-center"> ค่าความชื้นจากหัววัด </th>
                    <th width="8%" class="text-center"> ค่าความชื้นจากห้องปฏิบัติการ </th>
                    <th width="8%" class="text-center"> ค่าความพอง </th>
                </tr>
            </thead>
            <tbody>

                @foreach($reportPerPageItem["report_items"] as $index => $reportItem)

                    <tr height="30">
                        
                        <td class="text-center">
                            {{ $reportItem["qm_group"] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem["sample_opt"] }}
                        </td>
                        <td class="text-center"> 
                            {{ $reportItem["date_drawn_formatted"] }} 
                        </td>
                        <td class="text-center">
                            {{ $reportItem["time_drawn_formatted"] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem["location_desc"] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem["moist_sensor_min_value"] ? floatval($reportItem["moist_sensor_min_value"]) : '' }} - {{ $reportItem["moist_sensor_max_value"] ? floatval($reportItem["moist_sensor_max_value"]) : '' }}
                        </td>
                        <td class="text-center" style=" background-color: {{ $reportItem["moist_sensor_result_status"] == 'LOWER' ? '#aaffaa' : ($reportItem["moist_sensor_result_status"] == 'HIGHER' ? '#ffddaa' : '') }}"> 
                            {{ $reportItem["moist_sensor_result_value"] }}
                        </td>
                        <td class="text-center" style=" background-color: {{ $reportItem["moist_lab_result_status"] == 'LOWER' ? '#aaffaa' : ($reportItem["moist_lab_result_status"] == 'HIGHER' ? '#ffddaa' : '') }}"> 
                            {{ $reportItem["moist_lab_result_value"] }}
                        </td>
                        <td class="text-center">
                            {{ $reportItem["expand_result_value"] }}
                        </td>
                        
                    </tr>

                @endforeach
                
            </tbody>
        </table>

    </div>

@endforeach