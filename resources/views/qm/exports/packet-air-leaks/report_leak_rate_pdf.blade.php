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

        <div style="min-height: 50px; max-height: 50px; margin-top: 70px;">

            <table border="0" width="100%">
                <tr>
                    <td width="28%" class="text-left"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                    </td>
                    <td width="44%" class="text-center"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                    </td>
                    <td width="28%" class="text-right"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                    </td>
                </tr>
                <tr>
                    <td width="28%" class="text-left"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;">  </p>
                    </td>
                    <td width="44%" class="text-center"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> รายงานผลการตรวจวัดอัตรารั่วของฟิล์มห่อซองบุหรี่ ( PP film ) โดยเครื่องมือวัด </p>
                    </td>
                    <td width="28%" class="text-right"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                    </td>
                </tr>
                <tr>
                    <td width="28%" class="text-left"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                    </td>
                    <td width="44%" class="text-center"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> ประจำวันที่ {{ $reportPerPageItem["thai_date"] }} </p>
                    </td>
                    <td width="28%" class="text-right"> 
                        <p class="tw-mb-0" style="font-size: 13px; font-weight: bold;"> หน้าที่ {{ $reportPerPageItem["start_page"] + $indexItem }} / {{ $totalPage }} </p>
                    </td>
                </tr>
            </table>

        </div>

        <div class="tw-mt-4" style="min-height: 320px; min-height: 320px;">

            <table border="1" width="100%" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2" width="5%"> หมายเลขเครื่อง </th>
                        <th class="text-center" rowspan="2" width="8%"> ประเภทเครื่อง </th>
                        <th class="text-center" rowspan="2" width="5%"> วันที่บันทึก </th>
                        <th class="text-center" rowspan="2" width="3%"> เวลา </th>
                        <th class="text-center" rowspan="2" width="12%"> ตราบุหรี่ </th>
                        <th class="text-center" colspan="11"> ค่ามาตรฐาน ≤ 200 มล./นาที</th>
                        <th class="text-center" rowspan="2" width="9%"> ตำแหน่งที่รั่ว </th>
                    </tr>
                    <tr>
                        <th class="text-center" width="4%"> ซองที่ 1 </th>
                        <th class="text-center" width="2%"> P1 </th>
                        <th class="text-center" width="4%"> ซองที่ 2 </th>
                        <th class="text-center" width="2%"> P2 </th>
                        <th class="text-center" width="4%"> ซองที่ 3 </th>
                        <th class="text-center" width="2%"> P3 </th>
                        <th class="text-center" width="4%"> ซองที่ 4 </th>
                        <th class="text-center" width="2%"> P4 </th>
                        <th class="text-center" width="4%"> ซองที่ 5 </th>
                        <th class="text-center" width="2%"> P5 </th>
                        <th class="text-center" width="5%"> ค่าเฉลี่ย </th>
                    </tr>
                </thead>
                <tbody>
                        
                    @foreach($reportItems as $indexItem => $reportItem)
                        
                        <tr>
                            @if($reportItem->result_status == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->machine_set ? $reportItem->machine_set : "-" }} </td>
                            @else
                                <td class="text-center" style=""> 
                                    <div style="height: 100%; max-height: 24px; overflow: hidden;">
                                        <div style="position: inline-block; vertical-align: middle;">
                                            {{ $reportItem->machine_set ? $reportItem->machine_set : "-" }} 
                                        </div>
                                    </div>
                                </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->machine_type_desc ? $reportItem->machine_type_desc : "-" }} </td>
                            
                            <td class="text-center" style=""> {{ $reportItem->date_drawn_formatted ? $reportItem->date_drawn_formatted : "-" }} </td>
            
                            <td class="text-center" style=""> {{ $reportItem->time_drawn_formatted ? $reportItem->time_drawn_formatted : "-" }} </td>
                            
                            <td class="text-center" style=""> 
                                <div style="height: 100%; max-height: 24px; overflow: hidden;">
                                    <div style="position: inline-block; vertical-align: middle;">
                                        {{ $reportItem->brand_desc ? $reportItem->brand_desc : "-" }} 
                                    </div>
                                </div>
                            </td>
                            
                            @if($reportItem->status1 == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->leak1 !== null ? $reportItem->leak1 : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->leak1 !== null ? $reportItem->leak1 : "-" }} </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->position1 ? $reportItem->position1 : "-" }} </td>
                            
                            @if($reportItem->status2 == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->leak2 ? $reportItem->leak2 : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->leak2 !== null ? $reportItem->leak2 : "-" }} </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->position2 ? $reportItem->position2 : "-" }} </td>
                            
                            @if($reportItem->status3 == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->leak3 !== null ? $reportItem->leak3 : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->leak3 !== null ? $reportItem->leak3 : "-" }} </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->position3 ? $reportItem->position3 : "-" }} </td>
                            
                            @if($reportItem->status4 == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->leak4 !== null ? $reportItem->leak4 : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->leak4 !== null ? $reportItem->leak4 : "-" }} </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->position4 ? $reportItem->position4 : "-" }} </td>
                            
                            @if($reportItem->status5 == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->leak5 !== null ? $reportItem->leak5 : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->leak5 !== null ? $reportItem->leak5 : "-" }} </td>
                            @endif
                            <td class="text-center" style=""> {{ $reportItem->position5 ? $reportItem->position5 : "-" }} </td>

                            @if($reportItem->status_average == "FAILED")
                                <td class="text-center" style=" background-color: #fff0a0;"> {{ $reportItem->average !== null ? $reportItem->average : "-" }} </td>
                            @else
                                <td class="text-center" style=""> {{ $reportItem->average !== null ? $reportItem->average : "-" }} </td>
                            @endif

                            <td class="text-center" style=""> {{ $reportItem->position_leak_desc ? $reportItem->position_leak_desc : "-" }} </td>
            
                        </tr>
                    
                    @endforeach
            
                </tbody>
            </table>

            <table border="0" width="100%">
                <tr>
                    <td width="100%" class="text-left"> 
                        <p class="tw-mb-1" style="font-size: 13px;"> ตัวย่อตำแหน่งรั่วของฟิล์มซองบุหรี่ : T = ผนึกหัวซอง, S = ผนึกข้างซอง, B = ผนึกท้ายซอง </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="min-height: 15px; margin-top: 10px;" class="tw-px-4">

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

        <div style="min-height: 25px;" class="tw-px-4">
            <table border="0" width="100%" style="font-size: 14px;">
                <tr>
                    <td width="33%" class="text-center" style="vertical-align: top;"> 
                        <p class="tw-mb-2">  ...................................................................................... </p>
                        <p class="tw-mb-1"> ( ...................................................................................... ) </p>
                        <p> ผู้รายงาน </p>
                    </td>
                    <td width="34%" class="text-center" style="vertical-align: top;"> 
                        <p class="tw-mb-2">  ...................................................................................... </p>
                        <p class="tw-mb-1"> ( ...................................................................................... ) </p>
                        <p class="tw-mb-1"> หัวหน้ากอง / ผู้ช่วยหัวหน้ากอง </p>
                    </td>
                    <td width="33%" class="text-center" style="vertical-align: top;"> 
                        <p class="tw-mb-2">  ...................................................................................... </p>
                        <p class="tw-mb-1"> ( ...................................................................................... ) </p>
                        <p class="tw-mb-1"> ผู้อำนวยการ / รองผู้อำนวยการ / ผู้ช่วยผู้อำนวยการ </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="min-height: 25px;" class="tw-px-4">
            <table border="0" width="100%" style="font-size: 14px;">
                <tr>
                    <td width="33%" class="text-center" style="vertical-align: top;"> 
                        <p class="tw-mb-2">  ...................................................................................... </p>
                        <p class="tw-mb-1"> ( ...................................................................................... ) </p>
                        <p class="tw-mb-1"> ผู้ควบคุมการปฏิบัติงาน </p>
                    </td>
                    <td width="34%" class="text-center" style="vertical-align: top;"> 
                    </td>
                    <td width="33%" class="text-center" style="vertical-align: top;"> 
                    </td>
                </tr>
            </table>

        </div>

    @endforeach

@endforeach