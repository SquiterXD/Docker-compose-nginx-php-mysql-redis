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

{{-- CIGARETTE WEIGHT --}}

<div style="min-height: 240px; min-height: 240px; margin-top: 120px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน้าที่ 1 / {{ $totalPage }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM : น้ำหนักบุหรี่ (g) </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 620px; max-height: 620px;" class="tw-pt-10">

    <img style="height: 560px;" src="{{ $reportWeight }}">

</div>

{{-- CIGARETTE SIZEL --}}

<div style="min-height: 240px; min-height: 240px; margin-top: 120px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน้าที่ 2 / {{ $totalPage }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM : เส้นรอบวงบุหรี่ (mm) </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 620px; max-height: 620px;" class="tw-pt-10">

    <img style="height: 560px;" src="{{ $reportSizel }}">

</div>

{{-- PD OPEN --}}

<div style="min-height: 240px; min-height: 240px; margin-top: 120px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน้าที่ 3 / {{ $totalPage }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM : PD Open (mmWg) </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 620px; max-height: 620px;" class="tw-pt-10">

    <img style="height: 560px;" src="{{ $reportPdOpen }}">

</div>

{{-- TIP VENT --}}

<div style="min-height: 240px; min-height: 240px; margin-top: 120px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-2" style="font-size: 18px; font-weight: bold;"> หน้าที่ 4 / {{ $totalPage }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM : Tip Vent (%) </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mt-4 tw-mb-2" style="font-size: 18px;"> </p>
            </td>
        </tr>
    </table>

</div>

<div style="min-height: 560px; max-height: 560px;" class="tw-pt-10">

    <img style="height: 520px;" src="{{ $reportTipVent }}">

</div>