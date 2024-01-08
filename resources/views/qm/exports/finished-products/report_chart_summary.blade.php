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

<div style="height: 90px; min-height: 90px; max-height: 90px; margin-top: 100px;">

    <table border="0" width="100%">
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> โปรแกรม : {{ $programCode }} </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> การยาสูบแห่งประเทศไทย </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> วันที่ {{ $reportDate }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;">  </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> แผนภูมิการตรวจพบข้อบกพร่องในกระบวนการผลิตบุหรี่สำเร็จรูป </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> เวลา {{ $reportTime }} </p>
            </td>
        </tr>
        <tr>
            <td width="25%" class="text-left"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ </p>
            </td>
            <td width="50%" class="text-center"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </td>
            <td width="25%" class="text-right"> 
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> หน้าที่ 1 / 1 </p>
            </td>
        </tr>
    </table>

</div>

<div class="text-center" style="height: 410px; min-height: 410px; max-height: 410px;">

    <img style="height: 405px; min-height: 405px; max-height: 405px;" src="{{ $reportImgData }}">

</div>

<div style="height: 90px; min-height: 90px; max-height: 90px;" class="tw-px-10">

    <div style="min-height: 30px; margin-top: 0px;" class="tw-px-4">

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

    <div style="min-height: 35px;" class="tw-px-4">
        <table border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-1"> ผู้รายงาน </p>
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
        <table border="0" width="100%" style="font-size: 14px;">
            <tr>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                    <p class="tw-mb-2">  ........................................................................................... </p>
                    <p class="tw-mb-1"> ( ........................................................................................... ) </p>
                    <p class="tw-mb-1"> ผู้ควบคุมการปฏิบัติงาน </p>
                </td>
                <td width="34%" class="text-center" style="vertical-align: top;"> 
                </td>
                <td width="33%" class="text-center" style="vertical-align: top;"> 
                </td>
            </tr>
        </table>

    </div>

</div>