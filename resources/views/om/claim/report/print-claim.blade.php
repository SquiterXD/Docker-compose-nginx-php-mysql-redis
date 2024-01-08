<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporting</title>
</head>
<style>
    @font-face {
        font-family: 'myFont';
        /* ----- src: url(url('/fonts/th-sarabun-psk/THSarabun.ttf')) format('truetype');*/
        src: url('{{ public_path('/fonts/th-sarabun-psk/THSarabun.ttf') }}') format('truetype');
    }

    table {
        width: 100%
    }

    .item-table {
        border-collapse: collapse;
        margin-top: 1cm;
        margin-bottom: 1cm;
    }

    .item-table td,
    .item-table th {
        border: 1px solid;
        padding: 0px 3px
    }

    .text-center {
        text-align: center;
    }

    body {
         font-family: 'myFont'; 
    }

    .page {
        page-break-after: always;
        page-break-inside: avoid;
    }

</style>

<body>
    <h2 class="text-center">ใบคำร้องขอเปลี่ยนบุหรี่ชำรุด/เสียหาย ขาดบรรจุ</h2>
    <div style="border: 1px solid #ccc; padding: 0.5cm 0.5cm; margin-bottom:0.2cm">
        <table>
            <tr>
                <td style="width:60%"></td>
                <td>
                    <p>
                        เลขที่ใบคำร้อง : {{ $claimInfo['claim_number'] }} <br>
                        วัน-เวลา ที่สร้าง : {{ $claimInfo['claim_date'] }} น.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">เรียน <span style="margin-left: 0.5cm">ผู้อำนวยการฝ่ายตลาด</span></td>
            </tr>

            <tr>
                <td colspan="2">
                    <span style="margin-left: 0.5cm">ด้วย {{ @$customeInfo['customer_name'] }}
                        {{ @$customeInfo['address_line1'] }} {{ @$customeInfo['address_line2'] }}
                        {{ @$customeInfo['address_line3'] }} {{ @$customeInfo['district'] }}
                        {{ @$customeInfo['city'] }} {{ @$customeInfo['province_name'] }}
                        {{ @$customeInfo['postal_code'] }}</span><br>
                    <span style="margin-left: 0.5cm">ได้รับสินค้าจากการยาสูบแห่งประเทศไทย พบว่ามีบุหรี่ชำรุด/เสียหาย ขาดบรรจุ
                        ดังรายการต่อไปนี้</span>
                </td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid #ccc; padding: 0.1cm 0.5cm;  margin-bottom:0.2cm">
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
                @foreach ($claimLineInfo as $key => $value)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $value['item_description'] }}</td>
                        <td class="text-center">{{ $value['claim_quantity_cbb'] }}</td>
                        <td class="text-center">{{ $value['claim_quantity_carton'] }}</td>
                        <td class="text-center">{{ $value['claim_quantity_pack'] }}</td>
                        <td>{{ $claimInfo['symptom_description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>
        <ul>
            @foreach ($attech as $key => $item)
                <li>ไฟล์รูปภาพแนบ {{ $key + 1 }} {{ $item['file_name'] }}</li>
            @endforeach

        </ul>
        </p>
    </div>
    <div style="border: 1px solid #ccc; padding: 0.1cm 0.5cm;  margin-bottom:0.2cm">
        <p>จึงเรียนมาเพื่อโปรดดำเนินการต่อไป พร้อมนี้ได้ส่งบุหรี่ที่ขาดบรรจุ มาพร้อมด้วยกันแล้ว</p>
        <table>
            <tr>
                <td style="width:70%;">

                </td>
                <td>
                    <div class="text-center">ขอแสดงความนับถือ</div>
                    <table>
                        <tr>
                            <td style="padding:0.5cm"></td>
                        </tr>
                        <tr>
                            <td class="text-center" style="padding:0.2cm">
                                นางสาว พจนีย์ เทศสิริ
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" style="padding:0cm 0.4cm;">ผู้จัดการ</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <p>
            หมายเหตุ
        <ul>
            <li style="list-style: none">
                1. กรณีบุหรี่ชำรุด/เสียหาย ขาดบรรจุภายในซอง/ห่อ ให้ส่งซองหรือห่อที่ชำรุด/เสียหาย ขาดบรรจุมาที่
                กองพัฒนาการตลาด ฝ่ายตลาดพร้อมทั้งแนบรูปถ่าย ดังนี้
                <ul>
                    <li style="list-style: none">1.1 ถ่ายภาพลักษณะการชำรุด/เสียหาย ขาดบรรจุภายในซอง/ห่อ ทันทีที่พบ 2 จุด
                        ดังนี้
                        <ul>
                            <li style="list-style: none">- หัวห่อ หรือวันที่ข้างของบุหรี่ที่ชำรุด/เสียหายขาดบรรจุ</li>
                            <li style="list-style: none">- ลักษณะการชำรุด/เสียหาย ขาดบรรจุในซอง/ห่อ</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li style="list-style: none">
                2. กรณีบรรจุไม่ครบหีบ ให้แนบรูปถ่ายดังนี้
                <ul>
                    <li style="list-style: none">2.1 ถ่ายภาพลักษณะการขาดบรรจุทันทีที่พบ 3 จุดดังนี้
                        <ul>
                            <li style="list-style: none">- ข้างหีบบุหรี่จุดที่พิมพ์รหัสการผลิต </li>
                            <li style="list-style: none">- หน้าหีบบุหรี่จุดที่พิมพ์รหัสการผลิต </li>
                            <li style="list-style: none">- ลักษณะการขาดบรรจุ</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        </p>
    </div>
    <div class="page"></div>
    @foreach ($attech as $key => $item)
        <i>แนบไฟล์รูปภาพที่ {{ $key + 1 }}</i> <br>
        <img style="width:50%" src="{{ public_path(str_replace('public','storage',$item['path_name'])) }}" alt=""> <br><br>
    @endforeach
</body>

</html>
