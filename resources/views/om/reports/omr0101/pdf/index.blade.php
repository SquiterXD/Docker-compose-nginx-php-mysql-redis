<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
            /* src: url("/fonts/THSarabunNew.ttf") format("truetype"); */
        }

        /* @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew Italic.ttf") format("truetype");
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ base_path() }}/public/fonts/THSarabunNew BoldItalic.ttf") format("truetype");
        } */

        body {
            font-family: "THSarabunNew";
            font-size: 13px;
        }

        body {
            padding: 5mm 15mm 2mm 10mm;
            margin: 0px;
            width: 210mm;
            line-height: 1.5;
            /* transform: scale(0.7); */
            /* height: 297mm; */
            /* border: 1px solid; */
            box-sizing: border-box;
            font-size: 14pt;
            /* font-size: 11pt; */
        }

        .w-full {
            width: 100%;
        }

        div {
            display: inline-block;
        }

        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div style="width:100%;text-align:center">การยาสูบแห่งประเทศไทย</div>
    <div>
        ที่ ฝบช. 080000/ <br>
        เรื่อง ยอดเงินในบัญชี <br>
        เรียน ผู้จัดการ {{ $customer->customer_name }} <br>
    </div>
    <div style="width:100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การยาสูบแห่งประเทศไทย ขอเรียนว่า
        ณ
        วันที่ {{ $date->addYears(543)->format('d/m/Y') }} บริษัทของท่าน
        มียอดเงินคงเหลือในบัญชี เป็น</div>
    <br>
    {{-- <div style="padding-left: 40mm;width:100%">
        <div style="width:107mm; display:inline-block">- เจ้าหนี้ค่าบุหรี่ (เงินสด) การยาสูบแห่งประเทศไทย</div>
        <div style="display:inline-block;width:17mm;padding-right: 3mm;text-align: right">0</div>
        <div style="display:inline-block">บาท</div>
    </div>
    <div style="padding-left: 40mm;width:100%">
        <div style="width:107mm;display:inline-block">- ลูกหนี้ค่าบุหรี่ (เงินสด) การยาสูบแห่งประเทศไทย</div>
        <div style="display:inline-block;width:17mm;padding-right: 3mm;text-align: right">0</div>
        <div style="display:inline-block">บาท</div>
    </div> --}}
    <div style="padding-left: 40mm;width:100%">
        <div style="width:107mm;display:inline-block">- ลูกหนี้ค่าบุหรี่ (เงินเชื่อ 7 วัน) การยาสูบแห่งประทศไทย
        </div>
        <div style="display:inline-block;width:24mm;padding-right: 3mm;text-align: right">
            @if ($result_3)
                {{ number_format($result_3[0]->debt_amount - $result_3[0]->payment_amount, 2) }}
            @else
                0
            @endif
        </div>
        <div style="display:inline-block">บาท</div>
    </div>
    <div style="padding-left: 40mm;width:100%">
        <div style="width:107mm;display:inline-block">- ลูกหนี้ค่าบุหรี่ (เงินเชื่อ 28 วัน) การยาสูบแห่งประทศไทย
        </div>
        <div style="display:inline-block;width:24mm;padding-right: 3mm;text-align: right">
            @if ($result_2)
                {{ number_format($result_2[0]->debt_amount - $result_2[0]->payment_amount, 2) }}
            @else
                0
            @endif
        </div>
        <div style="display:inline-block">บาท</div>
    </div>
    <br>

    <div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โปรดตรวจทานรายละเอียดของยอดคงเหลือดังกล่าวข้างต้นกับหลักฐานของท่าน ถ้าถูกต้องขอให้ท่านยืนยันยอดตามรายการที่แจ้ง <br>หรือหากไม่ถูกต้องขอให้แจ้งยอดตามบัญชีที่ถูกต้องท้ายแบบฟอร์มข้างล่างนี้ และส่งคืนให้การยาสูบแห่งประเทศไทย <br>หรือส่งอีเมล: revenue_tax@thaitobacco.or.th
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อนึ่ง โปรดสังเกตว่า ยอดลูกหนี้ที่ขอให้ยืนยันเป็นยอด ณ วันที่ {{ $date->format('d/m/Y') }} รายการที่เกิดขึ้นหลังจากนี้ให้ถือว่าไม่เกี่ยวข้อง
    </div>

    <div>
        <div style="width:69mm;display:inline-block"></div>
        <div style="width:69mm;display:inline-block;text-align: center">ขอแสดงความนับถือ</div>
    </div>
    <div>
        <div style="width:69mm;display:inline-block"></div>
        <div style="width:69mm;display:inline-block;text-align: center"></div>
    </div>
    <div>
        <div style="width:69mm;display:inline-block"></div>
        <div style="width:69mm;display:inline-block;text-align: center"></div>
    </div>
    <div>
        <div style="width:69mm;display:inline-block"></div>
        <div style="width:69mm;display:inline-block;text-align: center">({{ request()->signature_name }})</div>
    </div>
    <div>
        <div style="width:69mm;display:inline-block"></div>
        <div style="width:69mm;display:inline-block;text-align: center">{!! str_replace('//','<br>',request()->position) !!}</div>
    </div>
    <div style="text-align: center">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(กรุณาฉีกตามรอยเส้นประ  แล้วส่งส่วนล่าง ซึ่งกรอกข้อความเรียบร้อยแล้วโดยใช้ซองที่แนบมา)
    </div>
    <div style="width:100%;border-bottom:1px dashed black; padding-bottom:10mm"></div>
    <br>
    <div style="width:100%; text-align: center">(ส่วนนี้ส่งคืนการยาสูบ)</div>
    <div style="width:100%;">
        <div style="width:50%;display:inline-block">ชื่อร้านขายส่ง {{ $customer->customer_name }}</div>
        <div style="width:24%;display:inline-block">รหัสลูกค้า {{ $customer->customer_number }}</div>

        <div style="width:24%;display:inline-block">ตลาด {{ $customer->market }}</div>

    </div>
    <div>
        <div style="width:115mm;display:inline-block">เรียน ผู้อำนวยการฝ่ายบัญชีและการเงิน การยาสูบแห่งประเทศไทย </div>
    </div>
    <br>

    <div>
        <div style="padding-left:7mm;width: 115mm;">ข้าพเจ้าขอยืนยันยอดลูกหนี้ค่าบุหรี่ ณ วันที่ {{ $date->format('d/m/Y') }} ดังนี้
            </div>
        <div style="width: 62mm"> </div>
    </div>
    {{-- <div class="w-full">
        <div style="padding-left:7mm;width: 99mm;">- เจ้าหนี้ค่าบุหรี่ (เงินสด) การยาสูบแห่งประเทศไทย</div>
        <div style="width:27mm;text-align: right; padding-right: 2mm"> 0 บาท</div>
        <div style="width:48mm">
            <div>:</div>
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div>
    </div>
    <div class="w-full">
        <div style="padding-left:7mm;width: 99mm;">- ลูกหนี้ค่าบุหรี่ (เงินสด) การยาสูบแห่งประเทศไทย</div>
        <div style="width:27mm;text-align: right; padding-right: 2mm"> 0 บาท</div>
        <div style="width:48mm">
            <div>:</div>
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div>
    </div> --}}
    <div class="w-full">
        <div style="padding-left:7mm;width: 99mm;">- ลูกหนี้ค่าบุหรี่ (เงินเชื่อ 7 วัน) การยาสูบแห่งประทศไทย</div>
        <div style="width:82mm;text-align: right; padding-right: 2mm">
            @if ($result_3)
                {{ number_format($result_3[0]->debt_amount - $result_3[0]->payment_amount, 2) }}
            @else
                0
            @endif
            บาท
        </div>
        {{-- <div style="width:48mm">
            <div>:</div>
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div> --}}
    </div>
    <div class="w-full">
        <div style="padding-left:7mm;width: 130mm;">(&nbsp;&nbsp;&nbsp;&nbsp;) ถูกต้อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;) ไม่ถูกต้อง ที่ถูกต้องคือ</div>
      
        <div style="width:50mm; text-align:right">
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div>
    </div>
    <div class="w-full">
        <div style="padding-left:7mm;width: 99mm;">- ลูกหนี้ค่าบุหรี่ (เงินเชื่อ 28 วัน) การยาสูบแห่งประทศไทย</div>
        <div style="width:82mm;text-align: right; padding-right: 2mm">
            @if ($result_2)
                {{ number_format($result_2[0]->debt_amount - $result_2[0]->payment_amount, 2) }}
            @else
                0
            @endif
            บาท
        </div>
        {{-- <div style="width:48mm">
            <div>:</div>
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div> --}}
    </div>
    <div class="w-full">
        <div style="padding-left:7mm;width: 130mm;">(&nbsp;&nbsp;&nbsp;&nbsp;) ถูกต้อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;) ไม่ถูกต้อง ที่ถูกต้องคือ</div>
      
        <div style="width:50mm; text-align:right">
            <div style="width:56%; border-bottom:1px solid"> &nbsp;</div>
            <div>บาท</div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div style="text-align: right;width:100%">(ลงชื่อ และประทับตรา) _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _
        _ </div>
</body>

</html>
