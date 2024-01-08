<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> รายงานรายละเอียดวัตถุดิบใช้ไปจริงรวม ตามผลิตภัณฑ์ </title>
    @include('ct.reports.ctr0091._style')
</head>
<body>
    <div style="page-break-after: always;"> </div>
    @include('ct.reports.ctr0091.header')
    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
        <thead>
            <tr>
                <th rowspan="2" width="auto" class="report_header">รหัสวัตถุดิบ</th>
                <th rowspan="2" width="auto" class="report_header">LOT</th>
                <th rowspan="2" width="auto" class="report_header">รายละเอียด</th>
                <th rowspan="2" width="auto" class="report_header">หน่วยนับ</th>
                <th colspan="3" width="auto" class="report_header">จริง</th>
                <th rowspan="2" width="auto" class="report_header">หมายเหตุ</th>
            </tr>
            <tr>
                <th class="report_header">จำนวน</th>
                <th class="report_header">ราคา</th>
                <th class="report_header">จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody style="page-break-inside: avoid;">
            @foreach ($apIn as $value)
                <tr>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> {{ $value->ct_dm_code }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> {{ $value->ct_dm_lot_inwip }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000;"> {{ $value->ct_dm_name}} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> {{ $value->ct_dm_uom }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($value->ct_dm_aq_inwip, 6) }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($value->ct_dm_ap_inwip, 9) }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"> {{ number_format($value->ct_dm_aqsp_inwip, 2) }} </td>
                    <td style="font-size: 16px; border: 0.5px solid #000000;"></td>
                </tr>
            @endforeach
            <tr>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> </td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"></td>
                <td style="font-size: 16px; border: 0.5px solid #000000;"></td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"></td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;"></td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: center;">รวม</td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">{{ number_format($apIn->sum('ct_dm_aqsp_inwip'), 2)  }}</td>
                <td style="font-size: 16px; border: 0.5px solid #000000; text-align: right;">
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
        <thead>
          <tr>
            <th width="auto" colspan="4" style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> สรุปการใช้วัตถุดิบ ผลิต ตามผลิตภัณฑ์ : {{ $value->ct_product_name }} </th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> ปริมาณจริง </th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> จำนวนเงินจริง</th>
            <th width="auto"></th>
            <th width="auto"></th>
            <th width="auto"></th>
          </tr>
        </thead>
        <tbody style="page-break-inside: avoid;">
            @foreach ($dm_group as $val_g)
                <tr>
                    <td></td>
                    <td colspan="3"> {{ $val_g->ct_dm_group }} {{ $val_g->ct_dm_group_name }}</td>
                    <td style="text-align: right"> {{ number_format($val_g->ct_dm_aq_inwip, 6) }} </td>
                    <td style="text-align: right"> {{ number_format($val_g->ct_dm_aqap_inwip, 2) }} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
        <thead>
          <tr>
            <th width="auto" colspan="4" style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> สรุปการใช้วัตถุดิบ ผลิต ตามหน่วยงาน : {{ $value->ct_dept_code }} {{ $value->ct_dept_name }} </th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> ปริมาณจริง </th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> จำนวนเงินจริง</th>
            <th width="auto"></th>
            <th width="auto">จำนวนที่ผลิต :</th>
            <th width="auto"> </th>
          </tr>
        </thead>
        <tbody style="page-break-inside: avoid;">
            @foreach ($dm_group as $val_g)
                <tr>
                    <td></td>
                    <td colspan="3"> {{ $val_g->ct_dm_group }} {{ $val_g->ct_dm_group_name }}</td>
                    <td style="text-align: right"> {{ number_format($val_g->ct_dm_aq_inwip, 6) }} </td>
                    <td style="text-align: right"> {{ number_format($val_g->ct_dm_aqap_inwip, 2) }} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <table class="table table-bordered" style="border-collapse: collapse; border: 0.5px solid rgb(255, 253, 253); padding: 0px; margin: 0px;">
        <thead>
          <tr>
            <th width="auto" colspan="4" style="font-size: 16px; border: 0.5px solid #000000; text-align: left;"> สรุปการใช้วัตถุดิบรวมทุกผลิตภัณฑ์  : {{ $value->ct_product_name }}</th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> ปริมาณจริง </th>
            <th width="auto" style="font-size: 16px; border: 0.5px solid #000000; text-align: center;"> จำนวนเงินจริง</th>
            <th width="auto"></th>
            <th width="auto">จำนวนที่ผลิต :</th>
            <th width="auto">  </th>
          </tr>
        </thead>
        <tbody style="page-break-inside: avoid;">
            @foreach ($dm_group_dept as $val_dept)
                <tr>
                    <td></td>
                    <td colspan="3"> {{ $val_dept->ct_dm_group }} {{ $val_dept->ct_dm_group_name }}</td>
                    <td style="text-align: right"> {{ number_format($val_dept->ct_dm_aq_inwip, 6) }} </td>
                    <td style="text-align: right"> {{ number_format($val_dept->ct_dm_aqap_inwip, 2) }} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
