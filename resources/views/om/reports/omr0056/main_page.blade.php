<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานการจำหน่ายยาสูบ/ยาเส้น (รต/1) ยสท.</title>
</head>

<style>
    @include('om.reports.omr0034._set_font')
</style>

<body>

<div class="row col-lg-12">
    <div class="col-md-4" style="font-size: 16px; text-align: left; width: 150px;">
        <div style="margin-bottom: 15px;">
            <strong> โปรแกรม : </strong> OMR0056
        </div>
        <div style="margin-bottom: 15px;">
            <strong> สั่งพิมพ์ : </strong>
        </div>
    </div>
    <div class="col-md-4" style="font-size: 20px; text-align: center; font-weight: bold;">
        <div style="margin-bottom: 10px;"> การยาสูบแห่งประเทศไทย</div>
        <div style="margin-bottom: 10px;"> ยอดจำหน่ายบุหรี่/ยาเส้น ประจำเดือนกุมภาพันธ์  (รต/3)</div>
        <div style="margin-bottom: 10px;"> ปีงบประมาณ {{ date('Y', strtotime($input['start_date'])) }}</div>
        <div style="margin-bottom: 10px;"> ตั้งแต่วันที่ {{ $input['start_date'] }} ถึงวันที่ {{ $input['end_date'] }}</div>
        <div style="margin-bottom: 10px;"> ยอดจำหน่าย กลุ่มร้านค้า {{ $input['start_date'] }}</div>
    </div>
    <div align="right" class="col-md-4" style="font-size: 16px;">
        <div style="margin-bottom: 15px;"><strong> วันที่ :</strong> {{ $input['now'] }}</div>
        <div style="margin-bottom: 15px;"><strong> เวลา :</strong> {{ date('H:i') }}</div>
        <div style="margin-bottom: 15px;"><strong> หน้า :</strong></div>
    </div>
</div>
<table class="table table-bordered"
       style="border-collapse: collapse; border: 0.5px solid #ddd; padding: 0px; margin: 0px;">
    <thead>
    <tr style="background-color: #C7CCC5;">
        <th rowspan="2" width="8%" class="report_header">
            ตรา
        </th>
        <th colspan="2" width="6%" class="report_header">
            เขต กทม.
        </th>
        <th colspan="2" width="5%" class="report_header">
            เขต ตจว.
        </th>
        <th colspan="2" width="10%" class="report_header">
            รวม
        </th>
    </tr>
    <tr style="background-color: #C7CCC5;">
        <th width="10%" class="report_header">
            พันมวน
        </th>
        <th width="10%" class="report_header">
            บาท
        </th>
        <th width="10%" class="report_header">
            พันมวน
        </th>
        <th width="10%" class="report_header">
            บาท
        </th>
        <th width="10%" class="report_header">
            พันมวน
        </th>
        <th width="10%" class="report_header">
            บาท
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
            <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            </td>
        </tr>
    <tr>
        <td style="text-align: right;padding-right: 20px;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
            รวม
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
        <td style="text-align: left;font-size: 16px; border: 0.5px solid #000000; text-align: center;">
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
