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

    <div style="min-height: 75px; max-height: 75px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> สรุปรายงานความไม่สอดคล้องแบบตรวจปล่อย </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ {{ $reportPerPageItem["start_page"] }} / {{ $totalPage }} </p>
                </td>
            </tr>
        </table>

    </div>

    <div class="tw-mt-4" style="{{ $reportPerPageItemIndex+1 == count($reportPerPageItems) ? 'min-height: 300px;' : 'min-height: 600px;' }} max-height: 600px;">

        <table border="1" width="100%" style="font-size: 14px;">
            <thead>
                <tr>
                    <th width="3%" class="text-center"> รายการ  </th>
                    <th width="6%" class="text-center"> วันที่  </th>
                    <th width="4%" class="text-center"> เวลา </th>
                    <th width="8%" class="text-center"> ตราบุหรี่  </th>
                    <th width="10%" class="text-center"> ปัญหา/ข้อบกพร่อง  </th>
                    <th width="5%" class="text-center"> จำนวน  </th>
                    <th width="5%" class="text-center"> หน่วยนับ  </th>
                    <th width="10%" class="text-center"> กระบวนการที่พบ </th>
                    <th width="4%" class="text-center"> หมายเลขเครื่อง </th>
                    <th width="4%" class="text-center"> เขตตรวจคุณภาพ </th>
                    <th width="6%" class="text-center"> ระดับความรุนแรง </th>
                    <th width="8%" class="text-center"> สาเหตุ </th>
                    <th width="6%" class="text-center"> หมายเหตุ </th>
                    <th width="20%" class="text-center"> รูปภาพประกอบ </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportPerPageItem["report_items"] as $index => $reportItem)
                    <tr style="height: 90px;">
                        <td class="text-center">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $index+1 }} </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['date_drawn_formatted'] }}  </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> 
                                    {{-- {{ $reportItem['time_drawn_formatted'] }}  --}}
                                    {{ $reportItem['sample_result_test_time'] }} 
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden; line-height: .9rem;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['brand_desc'] }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden; line-height: .9rem;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['test_desc'] }} </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['result_value'] }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['test_unit_desc'] }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['qm_process'] }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['machine_set'] }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;"> {{ $reportItem['qc_area'] }} </div>
                            </div>
                        </td>
                        <td class="text-center" style="background-color: {{ $reportItem['test_serverity_code_color'] }}">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle; font-weight: bold;"> {{ $reportItem['test_serverity_code'] ? $reportItem['test_serverity_code'] : "-" }} </div>
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden; line-height: .9rem;">
                                {{ $reportItem['causes_of_defects'] ? $reportItem['causes_of_defects'] : "-" }}
                            </div>
                        </td>
                        <td class="text-center tw-px-1">
                            <div class="tw-pt-1" style="height: 100%; max-height: 78px; overflow: hidden; line-height: .9rem;">
                                {{ $reportItem['remark'] }}
                            </div>
                        </td>
                        {{-- @if($reportItem['image_base64']) --}}
                        <td class="text-center tw-px-1" style="height: 90px;">
                            @if($reportItem['image_base64'])
                                @if(Storage::disk('public')->exists("qm/finished-products/result-quality-line/images/".$reportItem['image']->file_name))    
                                    <img src="{{ $reportItem['image_base64']->encoded }}" style="max-height: 80px; max-width: 180px;">
                                @endif
                            @endif
                        </td>
                        {{-- @else
                            <td class="text-center tw-px-1" style="height: 90px;"></td>
                        @endif --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endforeach

<div style="{{ $reportPerPageItems[(count($reportPerPageItems)-1)]['row_count'] > 2 ? 'display: block;' : 'display: none;' }} min-height: 75px; max-height: 75px; margin-top: 200px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> สรุปรายงานความไม่สอดคล้องแบบตรวจปล่อย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ {{ $totalPage }} / {{ $totalPage }} </p>
            </td>
        </tr>
    </table>

</div>

<div style="{{ $reportPerPageItems[(count($reportPerPageItems)-1)]['row_count'] > 2 ? 'margin-top: 160px; padding-top: 160px;' : '' }} min-height: 140px;" class="tw-px-10">

    <div style="min-height: 30px; margin-top: 60px;" class="tw-px-4">

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
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p> ผู้รายงาน </p>
                </td>
                <td width="34%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-0"> หัวหน้ากอง / ผู้ช่วยหัวหน้ากอง </p>
                </td>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-0"> ผู้อำนวยการ / รองผู้อำนวยการ / ผู้ช่วยผู้อำนวยการ </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 25px;" class="tw-px-4">
        <table border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p> ผู้ควบคุมการปฏิบัติงาน </p>
                </td>
                <td width="34%" class="text-center" style="vertical-align: top;"> 
                </td>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                </td>
            </tr>
        </table>

    </div>

</div>