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

<div style="height: 120px; min-height: 120px; max-height: 120px; margin-top: 100px;">

    <table border="0" width="100%">
        <tr>
            <td width="30%" class="text-left" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="40%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="30%" class="text-right" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="30%" class="text-left" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;">  </p>
            </td>
            <td width="40%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> ค่าเฉลี่ยผลการตรวจวัดอัตรารั่วฟิล์มห่อซองบุหรี่ </p>
            </td>
            <td width="30%" class="text-right" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="30%" class="text-left" colspan="2"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="40%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="30%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 15px; font-weight: bold;"> หน้าที่ 1 / 1 </p>
            </td>
        </tr>
    </table>

</div>

<div class="text-center" style="height: 540px; min-height: 540px; max-height: 540px;">

    <img style="height: 500px; min-height: 500px; max-height: 500px;" src="{{ $reportImgData }}">

</div>
