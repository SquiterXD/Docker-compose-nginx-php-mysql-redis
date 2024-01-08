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


@foreach ($reportPerPageItems as $reportPerPageItem)

    @foreach($reportPerPageItem["report_items"] as $indexItem => $reportItems)

        <div style="min-height: 85px; max-height: 85px; margin-top: 100px;">

            <table border="0" width="100%">
                <tr>
                    <td width="25%" class="text-left"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                    </td>
                    <td width="50%" class="text-center"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                    </td>
                    <td width="25%" class="text-right"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr>
                    <td width="15%" class="text-left"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;">  </p>
                    </td>
                    <td width="70%" class="text-center"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> รายงานตรวจคุณภาพทางฟิสิกส์ของมวนบุหรี่/ก้นกรองโดยเครื่องมือวัด </p>
                    </td>
                    <td width="15%" class="text-right"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr>
                    <td width="30%" class="text-left"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                    </td>
                    <td width="40%" class="text-center"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $reportPerPageItem["thai_date"] }} </p>
                    </td>
                    <td width="30%" class="text-right"> 
                        <p class="tw-mb-1" style="font-size: 14px; font-weight: bold;"> หน้าที่ {{ $reportPerPageItem["start_page"] + $indexItem }} / {{ $totalPage }} </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="min-height: 660px; max-height: 660px;">

            <table border="1" width="100%" style="font-size: 14px;">
                <tbody>
                    <tr>
                        <th width="5%" class="text-center"> วันที่ </th>
                        <th width="5%" class="text-center"> เวลา </th>
                        <th width="5%" class="text-center"> หมายเลขเครื่อง </th>
                        <th width="17%" class="text-center"> บุหรี่ / ก้นกรอง </th>
                        <th width="8%" class="text-center"> ชื่อการทดสอบ </th>
                        <th width="7%" class="text-center"> ผลการทดสอบ </th>
                        <th width="5%" class="text-center"> หน่วยนับ </th>
                        <th width="5%" class="text-center"> ค่าควบคุม-Min </th>
                        <th width="5%" class="text-center"> ค่าควบคุม-Max </th>
                        <th width="5%" class="text-center"> ผลการตรวจ </th>
                    </tr>
                </tbody>
                <tbody>

                    @foreach($reportItems as $index => $reportItem)

                        <tr height="35">
                            
                            @if($index == 0)
                                <td rowspan="{{ count($reportItems) }}" class="tw-px-1 tw-pt-2 text-center" style="vertical-align: top;">
                                    {{ $reportItem["date_drawn_formatted"] }} 
                                </td>
                            @endif

                                
                            @if($reportItem["is_first_time_drawn"])
                                <td rowspan="{{ $reportItem['count_time_drawn'] }}" class="tw-px-1 tw-pt-2 text-center" style="vertical-align: top;">
                                    {{ $reportItem["time_drawn_formatted"] }} 
                                </td>
                            @endif

                            <td class="tw-px-2 text-center">
                                {{ $reportItem["machine_set"] }} 
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["brand"] }} 
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result"]->test_desc }} 
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result"]->result_value ? floatval($reportItem["result"]->result_value) : "" }}
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result"]->test_unit }} 
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result"]->min_value ? floatval($reportItem["result"]->min_value) : "" }}
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result"]->max_value ? floatval($reportItem["result"]->max_value) : "" }}
                            </td>
                            <td class="tw-px-2 text-center">
                                {{ $reportItem["result_status_label"] }}
                            </td>
                            
                        </tr>

                    @endforeach
                    
                </tbody>
            </table>

        </div>

        <div style="min-height: 40px; margin-top: 10px;" class="tw-px-2">

            <table border="0" width="100%" style="font-size: 14px;">
                <tr>
                    <td width="33%" class="text-left" style="vertical-align: top;"> 
                        <p style="font-size: 14px;"> เรียน หัวหน้ากอง ฯ </p>
                    </td>
                    <td width="34%" class="text-left" style="vertical-align: top;"> 
                        <p style="font-size: 14px;"> เรียน ผู้อำนวยการฝ่าย ฯ </p>
                    </td>
                    <td width="33%" class="text-left" style="vertical-align: top;"> 
                        <p style="font-size: 14px;"> เพื่อทราบและดำเนินการ </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="min-height: 50px;" class="tw-px-2">
            <table border="0" width="100%" style="font-size: 15px;">
                <tr>
                    <td width="33%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                        <p class="tw-mb-2">  .................................................................................. </p>
                        <p class="tw-mb-1"> ( ................................................................................... ) </p>
                        <p> ผู้รายงาน </p>
                    </td>
                    <td width="34%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                        <p class="tw-mb-2">  .................................................................................. </p>
                        <p class="tw-mb-1"> ( ................................................................................... ) </p>
                        <p class="tw-mb-1"> หัวหน้ากอง / ผู้ช่วยหัวหน้ากอง </p>
                    </td>
                    <td width="33%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                        <p class="tw-mb-2">  .................................................................................. </p>
                        <p class="tw-mb-1"> ( ................................................................................... ) </p>
                        <p class="tw-mb-1"> ผู้อำนวยการ / รองผู้อำนวยการ / ผู้ช่วยผู้อำนวยการ </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="min-height: 50px;" class="tw-px-2">
            <table border="0" width="100%" style="font-size: 15px;">
                <tr>
                    <td width="33%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                        <p class="tw-mb-2">  .................................................................................. </p>
                        <p class="tw-mb-1"> ( ................................................................................... ) </p>
                        <p> ผู้ควบคุมการปฏิบัติงาน </p>
                    </td>
                    <td width="34%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                    </td>
                    <td width="33%" class="text-center" style="vertical-align: top; font-size: 15px;"> 
                    </td>
                </tr>
            </table>

        </div>

    @endforeach

@endforeach