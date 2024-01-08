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

<div style="min-height: 85px; max-height: 85px; margin-top: 100px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบบันทึกการตรวจสอบข้อบกพร่องในกระบวนการผลิต </p>
            </td>
            <td width="25%" class="text-right" colspan="2"> 
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
            <td width="10%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบ : สรุป </p>
            </td>
            <td width="15%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ 1 / 2 </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 550px; max-height: 550px;">

    <table border="1" width="100%">
        <thead style="font-size: 14px;">
            <tr>
                <th class="text-center"> กระบวนการผลิต </th>
                @foreach($reportQmProcesses as $reportQmProcess)
                    <th class="text-center" colspan="{{ $reportQmProcess->count_check_lists }}">
                        {{ $reportQmProcess->qm_process }}
                    </th>
                @endforeach
                <th class="text-center" style="min-width: 60px;" rowspan="2"> รวม </th>
            </tr>
            <tr>
                <th class="text-center" style="line-height: .95rem;"> 
                    <div> รายการตรวจ / </div>
                    <div> หมายเลขเครื่อง </div> 
                </th>
                @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)
                    <th class="text-center" style="line-height: .95rem;">
                        {{ $reportQmProcessCheckList->check_list }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody style="font-size: 16px;">

            @foreach($reportMachineSets as $index => $reportMachineSet)

                @if($index < 25)

                    <tr style="height: 20px;">

                        <td class="text-center tw-pt-0"> 
                            <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;">
                                    {{ $reportMachineSet->machine_set  }} 
                                </div>
                            </div>
                        </td>

                        @foreach($reportItems as $reportItem)

                            @if($reportItem->machine_set == $reportMachineSet->machine_set)

                                @if(count($reportItem->results) > 0)

                                    @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)

                                        <?php 
                                            $foundCountResultValue = null;
                                            foreach($reportItem->results as $rsItem) {
                                                if($reportQmProcessCheckList->qm_process_seq == $rsItem->qm_process_seq && $reportQmProcessCheckList->check_list_code == $rsItem->check_list_code) {
                                                    $foundCountResultValue = $rsItem->count_result_value ? $rsItem->count_result_value : null;
                                                }

                                            }
                                        ?>
                                        @if($foundCountResultValue) 
                                            <td class="text-center tw-font-bold tw-pt-0" style="background-color: #fff0a0;">
                                                <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                    <div style="position: inline-block; vertical-align: middle;">
                                                        <a href="{{ route('qm.finished-products.report-issue-details') }}?{{ http_build_query($searchInputs) }}&machine_set={{ $reportMachineSet->machine_set }}&qm_process_seq={{ $reportQmProcessCheckList->qm_process_seq }}&check_list_code={{ $reportQmProcessCheckList->check_list_code }}" target="_blank">
                                                            {{ $foundCountResultValue }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td class="text-center tw-pt-0">
                                                <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                    <div style="position: inline-block; vertical-align: middle;">
                                                        -
                                                    </div>
                                                </div>
                                            </td>
                                        @endif

                                    @endforeach

                                    <td class="text-center tw-pt-0"> 
                                        <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;"> 
                                            <div style="position: inline-block; vertical-align: middle;">
                                                {{ $reportItem->total_count_result_value }} 
                                            </div>
                                        </div>
                                    </td>

                                @else

                                    @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)

                                        <td class="text-center tw-pt-0">
                                            <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                <div style="position: inline-block; vertical-align: middle;">
                                                    -
                                                </div>
                                            </div>
                                        </td>

                                    @endforeach

                                    <td class="text-center tw-pt-0"> 
                                        <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;"> 
                                            <div style="position: inline-block; vertical-align: middle;">
                                                -
                                            </div>
                                        </div>
                                    </td>

                                @endif

                            @endif
                            
                        @endforeach

                    </tr>

                @endif

            @endforeach

        </tbody>
    </table>

</div>

<div style="min-height: 85px; max-height: 85px; margin-top: 100px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 17px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบบันทึกการตรวจสอบข้อบกพร่องในกระบวนการผลิต </p>
            </td>
            <td width="25%" class="text-right" colspan="2"> 
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
            <td width="10%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> แบบ : สรุป </p>
            </td>
            <td width="15%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ 2 / 2 </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 300px; max-height: 300px;">

    <table border="1" width="100%">
        <thead style="font-size: 14px;">
            <tr>
                <th class="text-center"> กระบวนการผลิต </th>
                @foreach($reportQmProcesses as $reportQmProcess)
                    <th class="text-center" colspan="{{ $reportQmProcess->count_check_lists }}">
                        {{ $reportQmProcess->qm_process }}
                    </th>
                @endforeach
                <th class="text-center" style="min-width: 60px;" rowspan="2"> รวม </th>
            </tr>
            <tr>
                <th class="text-center" style="line-height: .95rem;"> 
                    <div> รายการตรวจ / </div>
                    <div> หมายเลขเครื่อง </div> 
                </th>
                @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)
                    <th class="text-center" style="line-height: .95rem;">
                        {{ $reportQmProcessCheckList->check_list }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody style="font-size: 16px;">

            @foreach($reportMachineSets as $index => $reportMachineSet)

                @if($index >= 25)

                    <tr style="height: 20px;">

                        <td class="text-center tw-pt-0"> 
                            <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                <div style="position: inline-block; vertical-align: middle;">
                                    {{ $reportMachineSet->machine_set  }} 
                                </div>
                            </div>
                        </td>

                        @foreach($reportItems as $reportItem)

                            @if($reportItem->machine_set == $reportMachineSet->machine_set)

                                @if(count($reportItem->results) > 0)

                                    @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)

                                        <?php 
                                            $foundCountResultValue = null;
                                            foreach($reportItem->results as $rsItem) {
                                                if($reportQmProcessCheckList->qm_process_seq == $rsItem->qm_process_seq && $reportQmProcessCheckList->check_list_code == $rsItem->check_list_code) {
                                                    $foundCountResultValue = $rsItem->count_result_value ? $rsItem->count_result_value : null;
                                                }

                                            }
                                        ?>
                                        @if($foundCountResultValue) 
                                            <td class="text-center tw-font-bold tw-pt-0" style="background-color: #fff0a0;">
                                                <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                    <div style="position: inline-block; vertical-align: middle;">
                                                        <a href="{{ route('qm.finished-products.report-issue-details') }}?{{ http_build_query($searchInputs) }}&machine_set={{ $reportMachineSet->machine_set }}&qm_process_seq={{ $reportQmProcessCheckList->qm_process_seq }}&check_list_code={{ $reportQmProcessCheckList->check_list }}" target="_blank">
                                                            {{ $foundCountResultValue }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td class="text-center tw-pt-0">
                                                <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                    <div style="position: inline-block; vertical-align: middle;">
                                                        -
                                                    </div>
                                                </div>
                                            </td>
                                        @endif

                                    @endforeach

                                    <td class="text-center tw-pt-0"> 
                                        <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;"> 
                                            <div style="position: inline-block; vertical-align: middle;">
                                                {{ $reportItem->total_count_result_value }} 
                                            </div>
                                        </div>
                                    </td>

                                @else

                                    @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)

                                        <td class="text-center tw-pt-0">
                                            <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;">
                                                <div style="position: inline-block; vertical-align: middle;">
                                                    -
                                                </div>
                                            </div>
                                        </td>

                                    @endforeach

                                    <td class="text-center tw-pt-0"> 
                                        <div class="tw-pt-0" style="height: 100%; max-height: 16px; overflow: hidden;"> 
                                            <div style="position: inline-block; vertical-align: middle;">
                                                -
                                            </div>
                                        </div>
                                    </td>

                                @endif

                            @endif
                            
                        @endforeach

                    </tr>

                @endif

            @endforeach

            <tr>
                <td class="text-center tw-font-bold"> รวม </td>

                @foreach($reportQmProcessCheckLists as $reportQmProcessCheckList)
                    <td class="text-center tw-font-bold">
                        {{ $reportQmProcessCheckList->total_count_result_value }}
                    </td>
                @endforeach

                <td class="text-center tw-font-bold"> {{ $allTotalCountResultValue }} </td>
                
            </tr>

        </tbody>
    </table>

</div>

<div style="height: 140px; min-height: 140px; max-height: 140px;" class="tw-px-10">

    <div style="min-height: 40px; margin-top: 50px;" class="tw-px-4">

        <table border="0" width="100%" style="font-size: 15px;">
            <tr>
                <td width="33%" class="text-left" style="vertical-align: top;"> 
                    <p style="font-size: 15px;"> เรียน หัวหน้ากอง ฯ </p>
                </td>
                <td width="34%" class="text-left" style="vertical-align: top;"> 
                    <p style="font-size: 15px;"> เรียน ผู้อำนวยการฝ่าย ฯ </p>
                </td>
                <td width="33%" class="text-left" style="vertical-align: top;"> 
                    <p style="font-size: 15px;"> เพื่อทราบและดำเนินการ </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 35px;" class="tw-px-4">
        <table border="0" width="100%" style="font-size: 15px;">
            <tr>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p> ผู้รายงาน </p>
                </td>
                <td width="34%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-1"> หัวหน้ากอง / ผู้ช่วยหัวหน้ากอง </p>
                </td>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-1"> ผู้อำนวยการ / รองผู้อำนวยการ / ผู้ช่วยผู้อำนวยการ </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="min-height: 35px;" class="tw-px-4">
        <table border="0" width="100%" style="font-size: 15px;">
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
