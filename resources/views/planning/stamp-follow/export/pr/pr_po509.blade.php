<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> CT ใบขออนุมัติหลักการใช้งบประมาณ </title>
    @include('planning.stamp-follow.export._style')
</head>
<body>
    @include('planning.stamp-follow.export.pr.header')
    <div style="margin-bottom: 5px;" class="text-center">
        ใบขออนุมัติหลักการใช้งบประมาณ
    </div>
    <div>
        <table class="table table-bordered" style="border: 0.5px solid #fff; padding: 0px; margin: 0px; padding: 4px; margin-top: 5px; margin-bottom: 5px;">
            <tbody>
                <tr>
                    <td width="60%" style="border: 0.5px solid #fff; text-align: left; height: 10px;">
                        ส่วนที่ 1 หน่วยงานที่ขอใช้ ชื่อ/รหัสหน่วยงาน {{ getUserDetail($header->head_attribute7)['department'] }},
                    </td>
                    <td width="30%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                        ...............รายละเอียดแนบ...............แผ่น...............มีถัวจ่ายหรือเจียดจ่าย
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom: 5px; padding-left: 4px;">
        เรื่อง &nbsp; {{ $header->description_header }}
    </div>
    <div style="margin-bottom: 5px; padding-left: 4px;">
        เหตุผลและความจำเป็น &nbsp; {{ $header->head_attribute2 }}
    </div>
    <table class="table table-bordered" style="border: 0.5px solid #fff; padding: 0px; margin: 0px;">
        <thead>
            <tr>
                <td width="1%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    ลำดับ
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    รหัสพัสดุ
                </td>
                <td width="12%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    ชื่อพัสดุ
                </td>
                <td width="4%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    ราคาต่อหน่วย
                </td>
                <td width="4%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    จำนวน
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    หน่วยนับ
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    จำนวนเงิน<br>(ต่างประเทศ)
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    อัตราแลกเปลี่ยน<br>สกุลเงิน
                </td>
                <td width="6%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    จำนวนเงิน<br>(บาท)
                </td>
                <td width="6%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    วันที่ต้องการพัสดุ
                </td>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($prSatamps as $stamp)
                <tr style="font-size: 16px;">
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                        {{ $stamp->item_code }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                        {{ $stamp->item_description }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                        {{ $stamp->unit_price }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                        {{ number_format($stamp->quantity, 2) }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                        {{ $stamp->unit_meas_lookup_code }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;"> </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;"> </td>
                    <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                        @php
                            $total += $stamp->quantity * $stamp->unit_price;
                        @endphp
                        {{ number_format($stamp->quantity * $stamp->unit_price, 2) }}
                    </td>
                    <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                        {{ date('d-M-y', strtotime($stamp->need_by_date)) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- -------------------------------------------------------------------------------------------------------- --}}
    <table class="table table-bordered" style="border: 0.5px solid #fff; padding: 0px; margin: 0px; margin-top: 5px;">
        <tbody>
            <tr>
                <td width="10%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px; padding-left: 4px;">
                    สถานที่ส่งของ
                </td>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    {{ $header->location_ship_to }}
                </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    ราคาประมาณการ
                </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{ number_format($total, 2) }}
                </td>
            </tr>
            <tr>
                <td width="10%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px; padding-left: 4px;">
                    ตัวอักษร
                </td>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    {{ (new \App\Models\Planning\StampFollow\PRPOStampV)->numberToTextConverter($total) }}
                </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    ค่าใช้จ่ายการออกของ
                </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{ $header->head_attribute4 }}
                </td>
            </tr>
            <tr>
                <td width="10%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;"> </td>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;"> </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    รวม
                </td>
                <td width="8%" style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{ number_format($total, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    {{-- -------------------------------------------------------------------------------------------------------- --}}
    <table class="table table-bordered" style="border: 0.5px solid #fff; padding: 0px; margin: 0px; margin-top: 5px;">
        <thead>
            <tr>
                <td width="2%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    ปีงบประมาณ
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    รหัสงบบประมาณ
                </td>
                <td width="15%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    งบประมาณ
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    งบประมาณที่ตั้งไว้
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    ขออนุมัติแล้ว
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    จ่ายจริง
                </td>
                <td width="7%" style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    งบประมาณคงเหลือยกไป
                </td>
            </tr>
        </thead>
        <tbody>
            @php
                $resAccount = getPRPOStampAcc($header->budget_account_code);
            @endphp
            <tr style="font-size: 16px;">
                <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    {{ $resAccount['budgetYear'] }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: center; padding: 4px; height: 10px;">
                    {{ $resAccount['budgetCode'] }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    {{ $resAccount['desc'] }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{ number_format($header->budget_amount, 2) }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{ number_format($header->encumbrance_amount, 2) }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                   {{ number_format($header->actual_amount, 2) }}
                </td>
                <td style="border: 0.5px solid #fff; text-align: right; padding: 4px; height: 10px;">
                    {{-- budget - ขออนุมัติแล้ว - จ่ายจริง --}}
                    {{ number_format($header->budget_amount - $header->encumbrance_amount - $header->actual_amount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    {{-- -------------------------------------------------------------------------------------------------------- --}}
    @include('planning.stamp-follow.export.pr.sign')
    <div class="row col-12" style="text-align: left !important; padding-left: 4px;">
        <div class="col-md-2">
            หมายเหตุ
        </div>
        <div class="col-md-10"> </div>
    </div>

    <table class="table table-bordered" style="border: 0.5px solid #fff; padding: 0px; margin: 0px; margin-top: 5px;">
        <tbody>
            <tr>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ส่วนที่ 2 หน่วยงานงบประมาณ ( กรณีงบประมาณที่ต้องผ่านการตรวจสอบและยืนยันจากหน่วยงานงบประมาณ )
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ผู้ตรวจสอบ
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    _________________________
                </td>
            </tr>
            <tr>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ผลการตรวจสอบและยืนยันงบประมาณ &nbsp;&nbsp;&nbsp;&nbsp; ผ่าน &nbsp; X  &nbsp;&nbsp;&nbsp;&nbsp; ไม่ผ่าน
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;"> </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    (________________________)
                </td>
            </tr>
            <tr>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ความเห็น __________________________________________________________________________
                </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ตำแหน่ง
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    _________________________
                </td>
            </tr>
            <tr>
                <td width="40%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;"> </td>
                <td width="3%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    วันที่
                </td>
                <td width="5%" style="border: 0.5px solid #fff; text-align: left; padding: 4px; height: 10px;">
                    ________/________/_______
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
