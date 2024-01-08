<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $orderHeader->prepare_order_number }}</title>
    <style>
        @font-face {
            font-family: 'THSarabunPSK';
            src: url(data:font/truetype;charset=utf-8;base64,{{ base64_encode(file_get_contents(public_path('fonts/th-sarabun-psk/THSarabun.ttf'))) }}) format('truetype');
        }

        body {
            padding: 15;
            /* width: 21cm; */
            /* height: 29cm; */
            background-color: #FFF;
            font-size: 18px;
            margin: 15;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
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

        .right {
            text-align: right;
        }

        .page-number {
            padding: 10px 10px;
            font-size: 18px;
            display: block;
            text-align: right;
        }

        h4.title {
            font-size: 32px;
            font-weight: 400;
            text-align: center;
            margin-bottom: 0;
        }

        h5.title-desc {
            font-size: 22px;
            font-weight: 400;
            text-align: center;
        }

        .box-header {
            padding: 1rem 1rem .5rem 1rem;
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

        .header {
            padding: .5rem .5rem 0 .5rem;
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

        .box-table table tr th {
            font-weight: 400;
        }

        .box-table table tr td {
            padding: 0 3px;
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

        .text-center {
            text-align: center;
        }

        .bt {
            border-top: 1px solid #9E9E9E;
        }

        .bl {
            border-left: 1px solid #9E9E9E;
        }

        .br {
            border-right: 1px solid #9E9E9E;
        }

        .br-0 {
            border-right: none !important;
        }

        .bb {
            border-bottom: 1px solid #9E9E9E;
        }

        .number {
            border: 1px solid #000;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-block;
            text-align: center;
            line-height: 18px;
        }

        .company-address span {
            display: block;
            font-size: 20px;
            padding: 2px 0;
        }

        .header span {
            font-weight: 600;
        }

        .header table tr td {
            font-size: 20px;
        }

        .font-bold {
            font-weight: bold;
        }

        .desc-invoice div {
            display: inline-block;
            line-height: 2rem;
        }

        .reason div {
            display: inline-block;
            line-height: 2rem;
        }

        table tr.footer td {
            border-bottom: none !important;
        }

        .signhere {
            float: right;
            padding: 2rem 5rem;
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        table,
        tr,
        td,
        th,
        tbody,
        thead,
        tfoot {
            page-break-inside: avoid !important;
        }
    </style>
    {{-- <link href="{!! asset('custom/css-report/style-omr0001.css') !!}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <style>
        h4.title {
            margin-block-start: 0em;
        }

        .box-header {
            padding: 0rem 1rem 0rem 1rem;
            margin: 0px 1rem 0px 1rem;
            font-size: 18px !important;
        }

        .list .box-list,
        .box-table {
            font-size: 18px !important;
        }
    </style>
</head>

<body class="font-thsarabun">
    <div class="page-number">
        {{-- Page 1 of 2 --}}
    </div>
    <h4 class="title">ใบสั่งซื้อสินค้า({{ $orderHeader->product_type_code == 10 ? 'บุหรี่' : 'ยาเส้น' }})</h4>
    <h5 class="title-desc">กรุณาโทรเช็คยอดเงินโอน ก่อนทำการโอนเงิน เพื่อยืนยันความถูกต้อง ได้ที่ 02-2291625 ,
        02-2291631-2</h5>

    <div class="box-header">
        <table style="width:100%;text-align: right;">
            <tr>
                {{-- <td class="right">เลขที่ใบสั่งซื้อ</td> --}}
                <td>เลขที่ใบสั่งซื้อ : {{ $orderHeader->order_number }}</td>
            </tr>
            <tr>
                {{-- <td class="right">วัน-ที่อยู่ : </td> --}}
                <td>วัน-ที่อยู่ : {{ dateFormatThaiString($orderHeader->order_date) }}</td>
            </tr>
            <tr>
                {{-- <td class="right">วันที่ครบ Due (ออก Invoice) : </td> --}}
                <td>วันที่ครบ Due (ออก Invoice) : {{ dateFormatThaiString($orderHeader->delivery_date) }} 
                    {{ $checkPostpone ? 'เลื่อนวัน' : 'ปกติ' }} งวดที่
                    {{ $period->budget_year + 543 }}/{{ $period->period_no }} </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>ชื่อร้านค้า</td>
                            <td class="right" style="width: 5px;">:</td>
                            <td>({{ $customer->customer_number }}) {{ $customer->customer_name }}</td>
                        </tr>
                        <tr>
                            <td>ที่อยู่</td>
                            <td class="right" style="width: 5px;">:</td>
                            <td>
                                {{ $customer->address_line1 }}
                                {{ $customer->alley }}
                                {{ $customer->district }}
                                {{ $customer->city }}
                                {{ $customer->province_name }}
                                {{ $customer->postal_code }}
                            </td>
                        </tr>
                        @if ($orderHeader->product_type_code == 10)
                            <tr>
                                <td valign="top">ค้างชำระ</td>
                                <td valign="top" class="right" style="width: 5px;">:</td>
                                <td valign="top">
                                    <ul>
                                        @foreach ($releaseCredit as $release)
                                            <li>เงินเชื่อกลุ่ม {{ $release->credit_group_code }}
                                                ({{ $release->invoice_num }}) {{ dateFormatThai($release->due_date) }}
                                                = {{ number_format($release->amount, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>หมายเหตุ</td>
                            <td class="right" style="width: 5px;">:</td>
                            <td>{{ $orderHeader->remark != '' ? $orderHeader->remark : '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    @php
        $hasQueta = false;
        $countQuata = 0;
    @endphp
    @if ($orderHeader->product_type_code == 10)
        <div class="list">
            @foreach ($quota_group as $item)
                <div class="box-list ">
                    <table style="width: 100%;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>รวมจำนวนที่สั่ง</td>
                            <td align="center">โควตา</td>
                            <td class="right border-bottom-1" width="100">
                                {{ number_format($item->received_quota, 2) }}</td>
                            <td align="center" width="70">พันมวน</td>
                            <td align="center">เครดิต</td>
                            <td class="right border-bottom-1" width="100">
                                {{ number_format($item->quota_and_credit, 2) }}</td>
                            <td align="center" width="70">บาท</td>
                        </tr>
                        <tr>
                            <td>({{ $item->meaning }})</td>
                            <td align="center">ยอดสั่ง</td>
                            <td class="right border-bottom-1" width="100">
                                {{ number_format($item->spending_quota, 2) }}</td>
                            <td align="center" width="70">พันมวน</td>
                            <td align="center">เงินสด</td>
                            <td class="right border-bottom-1" width="100">{{ number_format($item->cash, 2) }}</td>
                            <td align="center" width="70">บาท</td>
                        </tr>
                        <tr>
                            <td></td>
                            @if (@$additionQueta[(int) $item->lookup_code])
                                @if (@$additionQueta[(int) $item->lookup_code]->sum('approve_quantity') > 0)
                                    @php
                                        $hasQueta = true;
                                        if ($item->received_quota < 0) {
                                            $countQuata += (int) abs($item->received_quota) + $item->spending_quota;
                                        } else {
                                            $countQuata += $item->spending_quota - $item->received_quota;
                                        }
                                    @endphp
                                    <td align="left" style="font-weight: 900;">(เกินโควต้า)</td>
                                    <td class="right border-bottom-1" width="100">
                                        {{-- {{ number_format(@$additionQueta[(int)$item->lookup_code]->sum('approve_quantity') * 10, 2) }} --}}
                                        {{-- {{ number_format((int)abs($item->received_quota) + $item->spending_quota, 2) }} --}}
                                        @if ($item->received_quota < 0)
                                            {{ number_format((int) abs($item->received_quota) + $item->spending_quota, 2) }}
                                        @else
                                            {{ number_format($item->spending_quota - $item->received_quota, 2) }}
                                        @endif
                                    </td>
                                    <td align="center" width="70">พันมวน</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                            <td align="center">ยอดรวม</td>
                            <td class="right border-bottom-2" width="100">{{ number_format($item->total_amount, 2) }}
                            </td>
                            <td align="center" width="70">บาท</td>
                        </tr>

                    </table>
                </div>
            @endforeach
            <div class="box-list">
                <table style="width: 100%;" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>รวมจำนวนที่สั่ง</td>
                        <td align="center">โควตา</td>
                        <td class="right border-bottom-1" width="100">{{ number_format($received_quota, 2) }}</td>
                        <td align="center" width="70">พันมวน</td>
                        <td align="center">เครดิต</td>
                        <td class="right border-bottom-1" width="100">{{ number_format($total_credit, 2) }}</td>
                        <td align="center" width="70">บาท</td>
                    </tr>
                    <tr>
                        <td>(ทั้งหมด)</td>
                        <td align="center">ยอดสั่ง</td>
                        <td class="right border-bottom-1" width="100">{{ number_format($spending_quota, 2) }}</td>
                        <td align="center" width="70">พันมวน</td>
                        <td align="center">เงินสด</td>
                        <td class="right border-bottom-1" width="100">{{ number_format($total_cash, 2) }}</td>
                        <td align="center" width="70">บาท</td>
                    </tr>
                    <tr>
                        <td></td>
                        @if ($hasQueta)
                            <td align="left" style="font-weight: 900;">(เกินโควต้า)</td>
                            <td class="right border-bottom-1" width="100">{{ number_format($countQuata, 2) }}</td>
                            <td align="center" width="70">พันมวน</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                        <td align="center">ยอดรวม</td>
                        <td class="right border-bottom-2" width="100">{{ number_format($total_credit_cash, 2) }}</td>
                        <td align="center" width="70">บาท</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    <div class="box-table">
        <table style="width: 100%;" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="br bb" rowspan="2">ชื่อสินค้า</th>
                    <th class="br bb" rowspan="2">ราคา/หน่วย</th>
                    <th class="br" colspan="3">ยอดการสั่ง</th>
                    <th class="br" colspan="3">ยอดอนุมัติ</th>
                    <th class="bb" rowspan="2">รวมเงิน</th>
                </tr>
                <tr>
                    <th class="br bt bb text-center">หีบ</th>
                    <th class="br bt bb text-center">ห่อ</th>
                    <th class="br bt bb text-center">{{ $orderHeader->product_type_code == 10 ? 'พันมวน' : 'ซอง' }}
                    </th>
                    <th class="br bt bb text-center">หีบ</th>
                    <th class="br bt bb text-center">ห่อ</th>
                    <th class="br bt bb text-center">{{ $orderHeader->product_type_code == 10 ? 'พันมวน' : 'ซอง' }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $summary_order_cardboardbox = 0;
                    $summary_order_carton = 0;
                    $summary_order_quantity = 0;
                    
                    $summary_approve_cardboardbox = 0;
                    $summary_approve_carton = 0;
                    $summary_approve_quantity = 0;
                    $summary_price = 0;
                @endphp
                @foreach ($orderLine->where('promotion_id', '') as $item)
                    @php
                        if ($item->uom_code == 'CS1') {
                            $summary_order_cardboardbox += $item->order_quantity;
                            $summary_order_carton += $item->order_quantity;
                            $summary_order_quantity += 0;
                        
                            $summary_approve_cardboardbox += $item->approve_quantity;
                            $summary_approve_carton += $item->approve_carton;
                            $summary_approve_quantity += 0;
                        } else {
                            $summary_order_cardboardbox += $item->order_cardboardbox;
                            $summary_order_carton += $item->order_carton;
                            $summary_order_quantity += $item->order_quantity;
                        
                            $summary_approve_cardboardbox += $item->approve_cardboardbox;
                            $summary_approve_carton += $item->approve_carton;
                            $summary_approve_quantity += $item->approve_quantity;
                        }
                        $summary_price += $item->amount;
                        
                    @endphp
                    <tr>
                        <td class="">{{ $item->item_description }}</td>
                        <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format($item->order_quantity, 2) : number_format($item->order_cardboardbox, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->order_carton, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format(0, 2) : number_format($item->order_quantity, 2) }}
                        </td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format($item->approve_quantity, 2) : number_format($item->approve_cardboardbox, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->approve_carton, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format(0, 2) : number_format($item->approve_quantity, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td class=""></td>
                    <td class="">รวม</td>
                    <td class="right">{{ number_format($summary_order_cardboardbox, 2) }}</td>
                    <td class="right">{{ number_format($summary_order_carton, 2) }}</td>
                    <td class="right">{{ number_format($summary_order_quantity, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_cardboardbox, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_carton, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_quantity, 2) }}</td>
                    <td class="right">{{ number_format($summary_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        @if (count($orderLine->where('promotion_product_id', '!=', null)) > 0)
		@php
                    $summary_order_cardboardbox = 0;
                    $summary_order_carton = 0;
                    $summary_order_quantity = 0;
                    
                    $summary_approve_cardboardbox = 0;
                    $summary_approve_carton = 0;
                    $summary_approve_quantity = 0;
                    $summary_price = 0;
                @endphp
            <table style="width: 100%; border-collapse: collapse">
                <thead>
                    <tr>
                        <th class="br bb" rowspan="2">ชื่อสินค้า</th>
                        <th class="br bb" rowspan="2">ราคา/หน่วย</th>
                        <th class="br" colspan="3">ยอดการสั่ง</th>
                        <th class="br" colspan="3">ยอดอนุมัติ</th>
                        <th class="bb" rowspan="2">รวมเงิน</th>
                    </tr>
                    <tr>
                        <th class="br bt bb text-center">หีบ</th>
                        <th class="br bt bb text-center">ห่อ</th>
                        <th class="br bt bb text-center">
                            {{ $orderHeader->product_type_code == 10 ? 'พันมวน' : 'ซอง' }}</th>
                        <th class="br bt bb text-center">หีบ</th>
                        <th class="br bt bb text-center">ห่อ</th>
                        <th class="br bt bb text-center">
                            {{ $orderHeader->product_type_code == 10 ? 'พันมวน' : 'ซอง' }}</th>
                    </tr>
                </thead>
                <tr>
                    <td style="font-weight: 600" colspan="9">ของแถม</td>
                </tr>
                @foreach ($orderLine->where('promotion_product_id', '!=', null) as $item)
                    @php
                        if ($item->uom_code == 'CS1') {
                            $summary_order_cardboardbox += $item->order_quantity;
                            $summary_order_carton += $item->order_quantity;
                            $summary_order_quantity += 0;
                        
                            $summary_approve_cardboardbox += $item->approve_quantity;
                            $summary_approve_carton += $item->approve_carton;
                            $summary_approve_quantity += 0;
                        } else {
                            $summary_order_cardboardbox += $item->order_cardboardbox;
                            $summary_order_carton += $item->order_carton;
                            $summary_order_quantity += $item->order_quantity;
                        
                            $summary_approve_cardboardbox += $item->approve_cardboardbox;
                            $summary_approve_carton += $item->approve_carton;
                            $summary_approve_quantity += $item->approve_quantity;
                        }
                        $summary_price += $item->amount;
                        
                    @endphp
                    <tr>
                        <td class="">{{ $item->item_description }}</td>
                        <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format($item->order_quantity, 2) : number_format($item->order_cardboardbox, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->order_carton, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format(0, 2) : number_format($item->order_quantity, 2) }}
                        </td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format($item->approve_quantity, 2) : number_format($item->approve_cardboardbox, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->approve_carton, 2) }}</td>
                        <td class="right">
                            {{ $item->uom_code == 'CS1' ? number_format(0, 2) : number_format($item->approve_quantity, 2) }}
                        </td>
                        <td class="right">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach
				<tr>
                    <td class=""></td>
                    <td class="">รวม</td>
                    <td class="right">{{ number_format($summary_order_cardboardbox, 2) }}</td>
                    <td class="right">{{ number_format($summary_order_carton, 2) }}</td>
                    <td class="right">{{ number_format($summary_order_quantity, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_cardboardbox, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_carton, 2) }}</td>
                    <td class="right">{{ number_format($summary_approve_quantity, 2) }}</td>
                    <td class="right">{{ number_format($summary_price, 2) }}</td>
                </tr>
            </table>
        @endif
    </div>


</body>

</html>
