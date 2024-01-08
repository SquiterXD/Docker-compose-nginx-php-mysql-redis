<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request Report</title>
    <style>
        body, h3 {
            font-family: Arial, Helvetica, sans-serif
        }
        h3 {
            font-size:17px;
        }
        .header span {
            display: inline-block;
        }
        .header .logo {
            margin: 0cm 0.5cm;
        }
        .header table {
            border-collapse:collapse
        }
        .header table td {
            /* border:1px solid #000; */
        }
        .header table {
            width: 100%
        }
        .table-in-1 {
            border-collapse:collapse
        }
        .table-in-1 td{
            border:1px solid #000;
        }
        .table-in-1 td span{
            border-bottom: 1px dashed #000;
            padding:0cm 0.2cm 0cm 0cm;
            width: 100%;
        }
        .br-none {
            border-right: none !important;
        }
        .bl-none {
            border-left: none !important;
        }
        .bb-none {
            border-bottom: none !important;
        }
        .bt-none {
            border-top: none !important;
        }
        .b-none {
            border:none !important;
        }
        .item-table {
            border-collapse:collapse
        }
        .item-table td, .item-table th {
            border:1px solid;
            padding: 0px 3px
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td>
                    <img class="logo" style="width:3cm" src="{{ public_path('images/logo-dummy.png') }}" alt="">
                </td>
                <td align="center"><h3>แบบใบขอเปลี่ยนบุหลี่ ชำรุด/เสียหาย หรือขาดบรรจุ</h3></td>
                <td align="right" style="padding:0cm 0.2cm">
                    <table class="table-in-1">
                        <tr>
                            <td class="bb-none" colspan="2" style="padding:0.2cm 0.3cm">กองลูกค้าสัมพันธ์</td>
                        </tr>
                        <tr>
                            <td class="bt-none bb-none" style="padding:0.2cm 0.3cm;border-right:none;">ฝข </td>
                            <td class="bt-none bb-none" style="padding:0.2cm 0.3cm;border-left:none"><span>{{ $fl }}</span></td>
                        </tr>
                        <tr>
                            <td class="bt-none" style="padding:0.2cm 0.3cm;border-right:none">วันที่ </td>
                            <td class="bt-none" style="padding:0.2cm 0.3cm;border-left:none"><span>{{ $date }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:60%">&nbsp;</td>
                <td>วันที่ {{ $claimInfo['claim_date'] }}</td>
            </tr>
        </table>
        <br>
        <table style="width:80%">
            <tr>
                <td>เรียน ผู้อำนวยการฝ่ายขาย</td>
                <td>จาก {{ $customeInfo['customer_name'] }}</td>
                <td>จังหวัด {{ $customeInfo['province_name'] }}</td>
            </tr>
        </table>
        <br>
        <p style="padding-left: 2cm; font-weight:bold">ขอความกรุณาเปลี่ยนบุหรี่ ดังนี้</p>
        <table class="item-table">
            <thead>
                <tr>
                    <th rowspan="2">ลำดับที่</th>
                    <th rowspan="2">รายการ</th>
                    <th colspan="3">จำนวน</th>
                    <th rowspan="2">สาเหตุ</th>
                </tr>
                <tr>
                    <th>หีบ</th>
                    <th>ห่อ</th>
                    <th>ซอง</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($claimLineInfo as $k => $item)
                <tr>
                    <td align="center">{{ $k+1 }}</td>
                    <td>{{ $item['item_description'] }}</td>
                    <td align="center">{{ $item['rma_quantity_cbb'] }}</td>
                    <td align="center">{{ $item['rma_quantity_carton'] }}</td>
                    <td align="center">{{ $item['rma_quantity_pack'] }}</td>
                    <td>{{ $claimInfo['symptom_description'] }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <p style="text-align: right; padding-right:2cm">
            รับเรื่อง/นำส่งกองคลังผลิตภัณฑ์ เพื่อดำเนินการต่อไป
        </p>
        <table>
            <tr>
                <td style="width:50%">&nbsp;</td>
                <td>
                    <table>
                        <tr>
                            <td class="text-right">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                            ({{ $signItAuthor['employee_name'] }})
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">{{ $signDepActingPos['meaning'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center" style="padding:0.2cm">หัวหน้ากองลูกค้าสัมพันธ์</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:50%;">
                    กองคลังผลิตภัณฑ์ได้รับบุหรี่/หนังสือชี้แจงไว้แล้ว
                    <table>
                        <tr>
                            <td class="text-right" style="width:130px">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                                (<span style="width:95%;display:inline-block;border-bottom:1px dotted; padding-bottom:3px">&nbsp;</span>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">ตำแหน่ง</td>
                            <td class="text-center" style="padding:0cm 0.4cm;"><span style="border-bottom:1px dotted;width:100%;padding-top:15px">&nbsp;</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;">
                    กองคลังผลิตภัณฑ์ได้รับเรื่องไว้แล้ว
                    <table>
                        <tr>
                            <td class="text-right" style="width:130px">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                                (<span style="width:95%;display:inline-block;border-bottom:1px dotted; padding-bottom:3px">&nbsp;</span>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">ตำแหน่ง</td>
                            <td class="text-center" style="padding:0cm 0.4cm;"><span style="border-bottom:1px dotted;width:100%;padding-top:15px">&nbsp;</span></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:50%;" verticle-align="middle">
                    <p>
                        เรียน ผู้อำนวยการผ่ายขาย
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผลิตภัณฑ์ ได้ดำเนินการเปลี่ยนบุหรี่/ยาเส้น พร้อมส่งมอบให้ลูกค้าเรียบร้อยแล้ว
                    </p>
                </td>
                <td style="width:50%;">
                    <p>ฝ่ายผลิตภัณฑ์สำเร็จรูป ได้รับเรื่องไว้แล้ว</p>
                    <ul>
                        <li style="list-style: none"><span style="font-size:30px">&#9744;</span> เปลี่ยนบุหรี่ ตามจำนวนที่ลูกค้าแจ้ง</li>
                        <li style="list-style: none"><span style="font-size:30px">&#9744;</span> ไม่เปลี่ยน (พร้อมแนบหนังสือชี้แจง)</li>
                    </ul>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:50%;">
                    กองคลังผลิตภัณฑ์ได้รับบุหรี่/หนังสือชี้แจงไว้แล้ว
                    <table>
                        <tr>
                            <td class="text-right" style="width:130px">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                                (<span style="width:95%;display:inline-block;border-bottom:1px dotted; padding-bottom:3px">&nbsp;</span>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">ตำแหน่ง</td>
                            <td class="text-center" style="padding:0cm 0.4cm;"><span style="border-bottom:1px dotted;width:100%;padding-top:15px">&nbsp;</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;">
                    กองคลังผลิตภัณฑ์ได้รับเรื่องไว้แล้ว
                    <table>
                        <tr>
                            <td class="text-right" style="width:130px">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                                (<span style="width:95%;display:inline-block;border-bottom:1px dotted; padding-bottom:3px">&nbsp;</span>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">ตำแหน่ง</td>
                            <td class="text-center" style="padding:0cm 0.4cm;"><span style="border-bottom:1px dotted;width:100%;padding-top:15px">&nbsp;</span></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td style="width:50%;">
                    <table>
                        <tr>
                            <th colspan="2">ทราบ</th>
                        </tr>
                        <tr>
                            <td>ต้นฉบับ</td>
                            <td>กองลูกค้าสัมพันธ์ เพื่อดำเนินการต่อไป</td>
                        </tr>
                        <tr>
                            <td>สำเนา</td>
                            <td>กองคลังผลิตภัณฑ์ เพื่อทราบ</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="text-right" style="width:130px">
                                ลงชื่อ
                            </td>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td class="text-center" style="padding:0.2cm">
                                (<span style="width:95%;display:inline-block;border-bottom:1px dotted; padding-bottom:3px">&nbsp;</span>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">ตำแหน่ง</td>
                            <td class="text-center" style="padding:0cm 0.4cm;"><span style="border-bottom:1px dotted;width:100%;padding-top:15px">&nbsp;</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;">
                </td>
            </tr>
        </table>
    </div>
</body>
</html>