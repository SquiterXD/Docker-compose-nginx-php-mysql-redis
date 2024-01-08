<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="8" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                
            </th>
            <th colspan="8" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p style="font-size: 16px; font-weight: bold;"> รายงานสรุปผลการตรวจสอบ : กลุ่มผลิตด้านใบยา </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;"> 
                หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ
            </th>
            <th colspan="8" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th colspan="3" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;"> 
                หน้าที่ 1 / 1
            </th>
        </tr>
</table>

@foreach($reportQmGroups as $index => $reportQmGroup)
    <table>
        <thead>
            <tr>
                <th style="height: 30px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: left;" 
                colspan="{{ 3 + ($reportQmGroup->count_locators * 2) }}"> 
                {{ $reportQmGroup->qm_group }} 
            </th>
            </tr>
            <tr>
                <th width="20" style="background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" rowspan="2"> วันที่ </th>
                <th width="20" style="background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" rowspan="2"> เวลา </th>
                <th width="20" style="background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" rowspan="2"> ตรา/ชุด </th>
                @foreach($reportQmGroupLocators as $indexLH => $reportQmGroupLocatorLH)
                    @if($reportQmGroupLocatorLH->qm_group == $reportQmGroup->qm_group)
                        <th style="height: 20px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;" colspan="2"> 
                            ค่ามาตรฐาน {{ $reportQmGroupLocatorLH->min_value }}-{{ $reportQmGroupLocatorLH->max_value }}% 
                        </th>
                    @endif
                @endforeach
            </tr>
            <tr>
                @foreach($reportQmGroupLocators as $indexLL => $reportQmGroupLocatorLL)
                    @if($reportQmGroupLocatorLL->qm_group == $reportQmGroup->qm_group)
                        <th width="20" style="height: 45px; background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> 
                            <p> หัววัด {{ $reportQmGroupLocatorLL->location_desc }}  </p>
                            <p> {{ $reportQmGroupLocatorLL->locator_desc }} </p>
                        </th>
                        <th width="20" style="background-color: #F5F5F6; border: 1px solid #000000; font-weight: bold; vertical-align: middle; text-align: center;"> Lab {{ $reportQmGroupLocatorLL->location_desc }} </th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>

            @foreach($reportItems as $reportItem)

                @if($reportItem->qm_group == $reportQmGroup->qm_group)

                    <tr>
                        <td style="border: 1px solid #000000; text-align: center;"> {{ $reportItem->date_drawn_formatted }} </td>
                        <td style="border: 1px solid #000000; text-align: center;"> {{ $reportItem->time_drawn_formatted }} </td>
                        <td style="border: 1px solid #000000; text-align: center;"> {{ $reportItem->sample_opt }} </td>

                        @foreach($reportQmGroupLocators as $indexLI => $reportQmGroupLocatorLI)

                            @if($reportQmGroupLocatorLI->qm_group == $reportQmGroup->qm_group)
                                
                                {{-- MOISTURE_METER --}}
                                @foreach($reportItem->locators as $reportItemLocator)
                                    @if($reportItemLocator->locator_id == $reportQmGroupLocatorLI->locator_id)
                                        @if($reportItemLocator->moisture_meter_under)
                                            <td style="background-color: #ffe699; border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_meter }}
                                            </td>
                                        @elseif($reportItemLocator->moisture_meter_over)
                                            <td style="background-color: #ffc1c1; border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_meter }}
                                            </td>
                                        @else
                                            <td style="border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_meter }}
                                            </td>    
                                        @endif
                                    @endif
                                @endforeach

                                {{-- MOISTURE_LAB_AVERAGE --}}
                                @foreach($reportItem->locators as $reportItemLocator)
                                    @if($reportItemLocator->locator_id == $reportQmGroupLocatorLI->locator_id)
                                        @if($reportItemLocator->moisture_lab_under)
                                            <td style="background-color: #ffe699; border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_lab_average }}
                                            </td>
                                        @elseif($reportItemLocator->moisture_lab_over)
                                            <td style="background-color: #ffc1c1; border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_lab_average }}
                                            </td>
                                        @else
                                            <td style="border: 1px solid #000000; text-align: center;">
                                                {{ $reportItemLocator->moisture_lab_average }}
                                            </td> 
                                        @endif
                                    @endif
                                @endforeach

                            @endif
                        @endforeach
                    </tr>
                    
                @endif
                
            @endforeach

        </tbody>
    </table>
@endforeach
