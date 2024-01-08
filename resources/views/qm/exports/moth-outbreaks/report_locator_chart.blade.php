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

@foreach ($reportBuildNamePerMonthItems as $indexItem => $reportBuildNamePerMonthItem)

    <div style="height: 150px; min-height: 150px; max-height: 150px; margin-top: 100px;">

        <table border="0" width="100%">
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
                </td>
            </tr>
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;">  </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> รายงานผลการตรวจสอบการระบาดของมอดยาสูบ - แผนภูมิผลการตรวจสอบ </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
                </td>
            </tr>
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> ประจำวันที่ {{ $reportBuildNamePerMonthItem->first_thai_date }} ถึงวันที่ {{ $reportBuildNamePerMonthItem->last_thai_date }} </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mb-0" style="font-size: 16px; font-weight: bold;"> หน้าที่ {{ $indexItem+1 }} / {{ $totalPage }} </p>
                </td>
            </tr>
            <tr>
                <td width="25%" class="text-left"> 
                    <p class="tw-mt-4 tw-mb-0" style="font-size: 16px;"> </p>
                </td>
                <td width="50%" class="text-center"> 
                    <p class="tw-mt-4 tw-mb-0" style="font-size: 16px;"> รายงานการระบาดของมอดยาสูบ อาคาร {{ $reportBuildNamePerMonthItem->build_name }} เดือน {{ $reportBuildNamePerMonthItem->thai_month }} </p>
                </td>
                <td width="25%" class="text-right"> 
                    <p class="tw-mt-4 tw-mb-0" style="font-size: 16px;"> </p>
                </td>
            </tr>
        </table>

    </div>

    <div style="height: 640px; min-height: 640px; max-height: 640px;">

        <img style="height: 600px; min-height: 600px; max-height: 600px;" src="{{ $reportBuildNamePerMonthItem->image }}">

    </div>

@endforeach