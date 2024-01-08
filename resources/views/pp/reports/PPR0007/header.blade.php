<div class="row col-12">
    <div class=" row col-md-7" style="border: 2px solid #000 !important; border-radius: 8px; margin: 4px; padding: 4px;">
        <div class="col-sm-4">
            <img class="img-circlex" src="{{ base_path() }}/public/img/excise_dept_logo.jpg"
                style="max-height: 150px;
                    position: relative;
                    padding: 6px 0;
                    line-height: 100px;
                    vertical-align: middle; width: 100px; height:80;
                "
            >
        </div>
        <div class="col-sm-8">
            <div style="padding-top: 10px; font-size: 20px;"> <b> กรมสรรพสามิต กระทรวงการคลัง </b> </div>
            <div style="padding-top: 10px; font-size: 20px;"> แบบงบเดือนการปิดแสตมป์ยาสูบ สำหรับสินค้ายาสูบ </div>
        </div>
    </div>
    <div class="col-md-2 text-center" style="border: 2px solid #000 !important; border-radius: 8px; margin: 4px; padding: 4px; vertical-align: middle;">
        <div style="padding-top: 10px;"> <h2>  ภส. ๐๖-๑๙ </h2> </div>
    </div>
    <div class="col-md-3" style="border: 2px solid #000 !important; border-radius: 8px; margin: 4px; padding: 4px 0px 4px 12px; ">
        <div> <b> สำหรับเจ้าหน้าที่ </b> </div>
        <div style="padding-bottom: 5px;"> เลขที่รับ ......................................... </div>
        <div style="padding-bottom: 5px;"> วันที่รับ .......................................... </div>
        <div> เจ้าหน้าที่ผู้รับ </div>
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        เรียน    อธิบดีกรมสรรพสามิต
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        ข้าพเจ้า...........................<b>การยาสูบแห่งประเทศไทย</b>...........................  ผู้รับใบอนุญาตผลิตยาสูบ........................  ข้อความตามแบบคำขอ........................
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        เลขประจำตัวประชาชน/เลขทะเบียนนิติบุคคล/เลขประจำตัวผู้เสียภาษี     
        @include('pp.reports.PPR0007._citizen_no')
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        ทะเบียนสรรพสามิตเลขที่    
        @include('pp.reports.PPR0007._excise_no')
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        ใบอนุญาตเลขที่...................<b>-</b>..................เล่มที่..................<b>-</b>..................สถานที่ผลิตชื่อ....................<b>การยาสูบแห่งประเทศไทย สาขาโรจนะ</b>.....................
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        เลขที่...............<b>๙๙๙</b>................หมูที่.............<b>๔</b>.............ซอย..................<b>-</b>.................ถนน.................<b>-</b>.................แขวง/ตำบล.....................<b>อุทัย</b>.....................
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        เขต/อำเภอ...................<b>อุทัย</b>...................จังหวัด................<b>พระนครศรีอยุธยา</b>................
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        ขอส่งงบเดือนการปิดแสตมป์ยาสูบประจำเดือน..............<b>{{ $month }}</b>.............. พ.ศ......<b>{{ thainumDigit($year) }}</b>......  รายละเอียด ดังนี้
    </div>
</div>
<div class="row col-12">
    <div clsas="text-left" style="margin-top: 10px; font-size: 18px;">
        <table class="table table-footer" style="margin-top: 0px; margin-bottom: 0px; color: #000;">
            <tbody>
                <tr style="line-height: 10px">
                    <td class="text-left" style="width:10%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                       สินค้ายาสูบ
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> ✔ </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:12%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         บุหรี่ซิกาแรต
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:10%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         บุหรี่ซิการ์
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:10%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         บุหรี่อื่นๆ
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:8%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         ยาเส้น
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:10%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         ยาเส้นปรุง
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:10%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         ยาเคี้ยว
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:8%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         ยาอัด
                    </td>
                    <td class="text-left" style="width:1%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                        <div style="width: 10px; height: 10px; margin-bottom: -3px !important; 
                            border-bottom: 1px solid #000;
                            border-left: 1px solid #000;
                            border-right: 1px solid #000;
                            border-top: 1px solid #000;
                            font-family: 'DejaVu Sans', sans-serif;
                            font-size: 18px;
                            display: inline-block;"
                        >
                            <div style="padding-top: -5px;"> </div>
                        </div>
                    </td>
                    <td class="text-left" style="width:18%; padding-right: 0px;padding-left: 0px;padding-top: 0px; vertical-align: middle;">
                         ผลิตภัณฑ์ยาสูบอื่น
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>