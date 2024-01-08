<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OMR0002</title>
    @include('ct.reports.ctr0101._style')
    <style>
        /* html {
            background-color: #2f4050;
        }

        body {
            padding: 0;
            width: 29.7cm;
            height: 21cm;
            background-color: #FFF;
            font-size: 13px;
            margin: 0;
            margin-left: auto;
            margin-right: auto;
            font-family: 'THSarabunPSK' !important;
        } */

        /* h1 {
            margin: 0;
        }

        h5 {
            margin: 0;
            padding: 0;
            font-weight: lighter;
        }

        h3 {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .font-thsarabun {
            font-family: 'THSarabunPSK';
        }

        .font-cordia {
            font-family: 'Tahoma';
        }

        .right {
            text-align: right;
        } */

        /* .page-number {
            padding: 1rem 2rem;
            font-size: 18px;
            display: block;
            text-align: right;
        } */

        /* h4.title {
            font-size: 28px;
            font-weight: 400;
            text-align: center;
            margin-bottom: 0;
        }

        h5.title-desc {
            font-size: 22px;
            font-weight: 400;
            text-align: center;
        } */
        body {
            width: 29.7cm;
            height: 21cm;
            background-color: #FFF;
            font-size: 17px;
            margin-left: auto;
            margin-right: auto;
        } 
        .box-header {
            border: 1px solid #9E9E9E;
            padding: 1rem 1rem 2.5rem 1rem;
            margin: 6px 1rem 6px 1rem;
            font-size: 20px;
        }

        ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        ul li {
            padding: 0;
        }

        .list .box-list {
            border: 1px solid #9E9E9E;
            padding: .5rem .5rem .1rem .5rem;
            margin: 0px 1rem 0 1rem;
            font-size: 20px;
            border-bottom: none;
        }

        .list .box-list:last-child {
            border-bottom: 1px solid #9E9E9E;
        }

        .border-bottom-1 {
            border-bottom: 1px solid #000;
        }

        .border-bottom-2 {
            border-bottom: 3px double #000;
        }

        .box-table {
            margin: 1rem 1rem 0 1rem;
            font-size: 20px;
        }

        .box-table table {
            border: 1px solid #9E9E9E;
        }

        .box-table table thead {
            background-color: #f6f6f6f6;
        }

        /* .box-table table tr th {
            font-weight: 400;
        } */

        .box-table table tr td {
            padding: 3px 3px;
            border-bottom: 1px solid #9E9E9E;
            border-right: 1px solid #9E9E9E;
        }

        .box-table table tr td:last-child {
            padding: 0 3px;
            border-right: none;
        }

        .box-table table tr:last-child td {
            padding: 0 3px;
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .bt {
            border-top: 1px solid #3f3f3f;
        }

        .bl {
            border-left: 1px solid #3f3f3f;
        }

        .br {
            border-right: 1px solid #3f3f3f;
        }

        .bb {
            border-bottom: 1px solid #3f3f3f;
        }

        .table-list {
            font-size: 17px;
        }

        .table-list tr.header td {
            padding: 4px 0;
        }

        .table-list tr.list td {
            padding: 4px 6px;
        }

        table.no-border {
            border: none;
            font-size: 17px;
        }

        table.no-border tr td {
            padding: 4px 6px;
        }

        .table-signature {
            width: 600px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 1rem;
        }

        .table-signature tr td {
            padding: 6px 10px;
            line-height: 2.4rem;
            vertical-align: bottom;
        }
    </style>
</head>

<body style="padding:12px;">
    <table style="width:100%">
        <tr>
            <td>ใบเตรียมเลขที่</td>
            <td>{{ $order->prepare_order_number }}</td>
            <td>วันที่เตรียมขาย</td>
            <td>{{ $order->prepareDate }}</td>
            <td style="color:red;">สถานะ</td>
            <td>{{ $customerTypeDomestic->description }} {{ $order->order_status }}</td>
        </tr>
        <tr>
            <td>รหัสลูกค้า</td>
            <td>{{ $customer->customer_number }}</td>
            <td>ชื่อร้าน</td>
            <td style="font-weight: bold">{{ $customer->customer_name }}</td>
            <td>เลขประจำตัวผู้เสียภาษี</td>
            <td>{{ $customer->taxpayer_id }}</td>
        </tr>
        <tr>
            <td>รายการสั่งทาง</td>
            <td>{{ $order->saleType }} {{ $order->requestor }}</td>
            <td>วันที่สั่งซื้อ</td>
            <td>{{ $order->prepareDate }}</td>
            <td>งวดที่</td>
            <td>{{ $order->periodData }}</td>
        </tr>
        <tr>
            <td>จัดส่งบุหรี่โดย</td>
            <td>{{ $order->shipType }}</td>
            <td>วันที่ส่ง</td>
            <td>({{ $order->dateName }}) {{ $order->deliDate }}</td>
            <td>ส่งที่</td>
            <td>{{ $order->custoShip }}</td>
        </tr>
        <tr>
            <td>ประเภทลูกค้า</td>
            <td>{{ $order->custoType }}</td>
            {{-- <td>วงเงินเชื่อ</td>
            <td style="display: flex;"><span style="text-align: left;flex:auto;">2</span> <span style="text-align: right;">0.00</span></td>
            <td>บาท</td> --}}
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            {{-- <td>วงเงินเชื่อ</td>
            <td style="display: flex;"><span style="text-align: left;flex:auto;">3</span> <span style="text-align: right;">0.00</span></td>
            <td>บาท</td> --}}
            <td></td>
        </tr>
    </table>
    <table style="width: 100%;" cellspacing="0" class="table-list">
        <tr class="header">
            <td colspan="3" class="text-center bt">ยอดสั่ง/ส่ง ครั้งหลังสุด</td>
            <td rowspan="2" class="text-center bt bb">รหัสบุหรี่</td>
            <td rowspan="2" style="width: 160px;" class="text-center bt bb">ตรา</td>
            <td rowspan="2" class="text-center bt bb">จำนวนที่เพิ่ม</td>
            <td rowspan="2" class="text-right bt bb">จำนวนที่สั่ง</td>
            <td rowspan="2" class="text-right bt bb">อนุมัติส่ง</td>
            {{-- <td rowspan="2" class="text-right bt bb">โควต้า/งวด</td> --}}
            <td rowspan="2" class="text-right bt bb" style="width: 30px;"></td>
            <td rowspan="2" colspan="2" class="text-right bt bb">จำนวนเงินทั้งสิ้น</td>
            <td rowspan="2" style="width: 60px;" class="text-center bt bb"></td>
        </tr>
        <tr class="header">
            <td class="text-right bb" style="width: 80px;">วันที่</td>
            <td class="text-right bb" style="width: 100px;">สั่ง (X) พันมวน</td>
            <td class="text-center bb" style="width: 100px;">ส่ง (X) พันมวน</td>
        </tr>
        @foreach ($order_line as $line_item)
            <tr class="list">
                <td class="text-right">{{ !empty($line_item->lastOrderDate) ? $line_item->lastOrderDate : '-' }}</td>
                <td class="text-right">
                    {{ !empty($line_item->lastOrderQuantity) ? number_format($line_item->lastOrderQuantity, 2, '.', ',') : '-' }}
                </td>
                <td class="text-center">
                    {{ !empty($line_item->lastOrderApprove) ? number_format($line_item->lastOrderApprove, 2, '.', ',') : '-' }}
                </td>
                <td class="text-center">{{ $line_item->item_code }}</td>
                <td>{{ $line_item->item_description }}</td>
                <td class="text-center">-</td>
                <td class="text-right">{{ number_format($line_item->order_quantity, 2, '.', ',') }}</td>
                <td class="text-right">{{ number_format($line_item->approve_quantity, 2, '.', ',') }}</td>
                {{-- <td class="text-right">1,000.0</td> --}}
                <td class="text-right"></td>
                <td class="text-right" colspan="2">{{ number_format($line_item->total_amount, 2, '.', ',') }}</td>
                <td style="padding-left: 10px;">บาท</td>
            </tr>
        @endforeach

        <tr class="list">
            <td class="text-right" colspan="4"></td>
            <td class="text-center">รวม</td>
            <td class="text-center"></td>
            <td class="text-right">{{ number_format($order->orderTotal, 2, '.', ',') }}</td>
            <td class="text-right">{{ number_format($order->approveTotal, 2, '.', ',') }}</td>
            {{-- <td class="text-right">3,000.0</td> --}}
            <td class="text-right"></td>
            <td class="text-left">รวมเงินสินเชื่อ</td>
            <td class="text-right">0.00</td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>
    </table>

    <table class="no-border" style="margin-top: 12px;width:100%;">
        <tr class="list">
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center" style="width: 220px;"></td>
            <td class="text-center"></td>
            <td class="text-right" style="width: 120px;"></td>
            <td class="text-right" style="width: 120px;"></td>
            <td class="text-right" style="width: 30px;"></td>
            <td class="text-right" style="width: 0px;"></td>
            <td class="text-right" style="width: 80px;"></td>
            <td class="text-right" style="width: 90px;"></td>
            <td class="text-center" style="width: 45px;"></td>
        </tr>
        <tr>
            <td class="text-center" width="140px"></td>
            <td class="text-right" width="82px">ผู้บันทึก</td>
            <td class="text-left" style="padding-left: 20px;"> {{ $user->name }}</td>
            <td class="text-right" colspan="4"></td>
            {{-- <td class="text-left" width="132px" style="padding-left: 32px;"></td>
            <td class="text-right" width="132px"></td>
            <td class="text-right" width="132px"></td> --}}
            <td class="text-right"></td>
            <td class="text-left">รวมเงินสด</td>
            <td class="text-right">{{ number_format($order->cash_amount, 2, '.', ',') }}</td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>
        {{-- <tr>
            <td class="text-center" width="140px"></td>
            <td class="text-left" width="82px"></td>
            <td class="text-center"></td>
            <td class="text-right">กลุ่ม 3</td>
            <td class="text-left" style="padding-left: 32px;">ครบกำหนดชำระ</td>
            <td class="text-right">0.00</td>
            <td class="text-right">บาท</td>
            <td class="text-right"></td>
            <td class="text-left">รวมเงินสินเชื่อ</td>
            <td class="text-right">0.00</td>
            <td style="padding-left: 10px;">บาท</td>
        </tr> --}}
        <tr>
            <td class="text-right" colspan="4"></td>
            <td class="text-left" width="132px" style="padding-left: 32px;"></td>
            <td class="text-right" width="132px"></td>
            <td class="text-right" width="132px"></td>
            <td class="text-right"></td>
            <td class="text-left">รวมเงินทั้งหมด</td>
            <td class="text-right">{{ number_format($order->grand_total, 2, '.', ',') }}</td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>
        {{-- <tr>
            <td class="text-right" colspan="4"></td>
            <td class="text-left" style="padding-left: 32px;">เงินคงเหลือ</td>
            <td class="text-right">0.00</td>
            <td class="text-right">บาท</td>
            <td class="text-right" colspan="4"></td>
        </tr> --}}

        <tr>
            <td colspan="13" style="height: 22px;"></td>
        </tr>

        <tr>
            <td class="text-center" colspan="4">ผู้ตรวจทาน</td>
            <td class="text-right" valign="bottom" style="padding-left: 32px;">หัวหน้ากอง/อนุมัติ</td>
            <td class="text-right bb" style="height: 24px;" colspan="2"></td>
            <td class="text-right" colspan="4"></td>
        </tr>
        <tr>
            <td class="text-right" colspan="4"></td>
            <td class="text-right" valign="bottom" style="padding-left: 32px;">ผู้อำนวยการฝ่าย</td>
            <td class="text-right bb" style="height: 28px;" colspan="2"></td>
            <td class="text-right" colspan="4"></td>
        </tr>

    </table>
    @if ($order->remark)
        <div style="margin-top: 20px; padding-left: 20px;">
            หมายเหตุรายการ:  {{ $order->remark }}
        </div>
    @endif
</body>

</html>
