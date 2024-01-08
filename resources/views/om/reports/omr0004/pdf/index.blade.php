<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ยาสูบ</title>
    <style>
            /* @page {
                margin-top: 20;
                margin-bottom: 0;
                margin-left: 0;
                margin-right: 0;
            } */
            @font-face {
                font-family: 'THSarabunNew';
                font-style: normal;
                font-weight: normal;
                src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: normal;
                font-weight: bold;
                src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: italic;
                font-weight: normal;
                src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: italic;
                font-weight: bold;
                src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
            }
            body {
        margin: 0;
        font-family: "THSarabunNew";
        line-height: 1;
        padding: 0;
    }
        table {
            border-collapse: collapse
        }

        th,
        td {
            border: .4px solid #000;
            padding: 1px 5px;
        }

        div.page {
            page-break-after: avoid;
            page-break-inside: avoid;
        }
    </style>
</head>
@php
    
    function __convertUom($item_id, $from, $to, $amout)
    {
        $sql = "select  (apps.inv_convert.inv_um_convert (
                            item_id           => '{$item_id}',
                            organization_id   => 164,
                            PRECISION         => NULL,
                            from_quantity     => '{$amout}',
                            from_unit         => '{$from}',
                            to_unit           => '{$to}',
                            from_name         => NULL,
                            to_name           => NULL)
                    ) result
                from dual";
        try {
            return \DB::select($sql)[0]->result;
        } catch (\Throwable $th) {
            return false;
        }
    }
    
    function getQty($item, $data)
    {
        $qty = 0;
        $rate = 0;
        try {
            if ($data->order->product_type_code == '10') {
                $rate = 50;
                if ($item->rma_quantity != '') {
                    $qty = $item->rma_quantity * $rate;
                } else {
                    $qty = $item->claim_quantity * $rate;
                }
            } else {
                if ($item->rma_quantity != '') {
                    $convert = __convertUom($item->item_id, $item->rma_uom_code, 'PTN', $item->rma_quantity);
                    $qty = $convert;
                } else {
                    $convert = __convertUom($item->item_id, $item->claim_quantity, 'PTN', $item->rma_quantity);
                    $qty = $convert;
                }
            }
        } catch (\Throwable $th) {
        }
        return $qty;
    }
    
    function getAmount($item, $data)
    {
        $amount = 0;
        try {
            $line = $data->order->lines->where('order_line_id', $item->order_line_id)->first();
            if ($data->order->product_type_code == '10') {
                $amount = $line->unit_price * 0.02;
            } else {
                $amount = __convertUom($item->item_id, $item->rma_uom_code, 'PTN', $item->unit_price);
            }
        } catch (\Throwable $th) {
        }
    
        return $amount;
    }
    
    function getCost($item, $data)
    {
        $cost = 0;
        try {
            $line = $data->order->lines->where('order_line_id', $item->order_line_id)->first();
            if ($data->order->product_type_code == '10') {
                $cost = $line->attribute1 * 0.02;
            } else {
                $cost = __convertUom($item->item_id, $item->rma_uom_code, 'PTN', $item->attribute1);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $cost;
    }
    
    function convertDate($date)
    {
        try {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)
                ->addYears(543)
                ->format('d/m/Y');
        } catch (Exception $er) {
            return '';
        }
    }
    
    function getAtribute1Line($item)
    {
        $attribute1 = 0;
        try {
            $attribute1 = $item->order->lines->sum(function ($i) {
                return $i->attribute1 * $i->approve_quantity;
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
    
        return $attribute1;
    }
    
    function convertImage($path)
    {
        return 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($path)));
    }
@endphp

<body>
    @php
    $n= 0;
    @endphp
    @foreach ($data as $item)
        @for ($i = 0; $i < 7; $i++)
            <div class="page" style="position: relative;">
                <div style="position: absolute;top:20px; right: 20px; font-size:30px">
                @if($n == 0 )
                    ต้นฉบับ
                @else 
                    สำเนา
                @endif
                @php 
                    $n++;
                @endphp
                </div>
                <div class="sec1" style="display: -webkit-box;">
                    <div><img src="{{ convertImage('/img/logo-black.png') }}" alt="" style="height:130px"></div>
                    <div style="line-height: 2rem;padding: 0px 15px">
                        การยาสูบแห่งประเทศไทย <br>
                        ที่อยู่ 184 ถนนพระราม 4 คลองเตย <br>
                        กรุงเทพฯ 10110 <br>
                        เลขประจำตัวผู้เสียภาษีอากร 0994000154769
                    </div>
                </div>

                <div style="width:100%; text-align: center; position: relative;">
                    <h1>ใบลดหนี้ (Credit Note) </h1>
                    <div style="position: absolute; top:0px; right:0px">
                        เลขที่ <span>{{ $item->invoice_headers_number }}</span> <br>
                        วันที่ <span>{{ convertDate($item->invoice_date) }}</span>

                    </div>
                </div>

                <div style="line-height: 1.6rem">
                    <span style="width:150px;display:inline-block"><b>ชื่อผู้ซื้อ</b> </span>
                    <span>{{ $item->customer->customer_name }} {{ $item->customer->branch }}</span> <br>
                    <span style="display:inline-block"><b>เลขประจำตัวผู้เสียภาษีอากร</b></span>
                    <span>{{ $item->customer->taxpayer_id }}</span> <br>
                    <span style="width:150px;display:inline-block; vertical-align: top"><b>ที่อยู่</b></span> <span
                        style="display: inline-block">
                        @php 
                        $customer = $item->customer;
                        $shipTo = $customer->shipTo;
                    @endphp
                        @if($customer->customer_type_id  == 20) 
                           
                            {{$customer->address_line1}} {{$customer->address_line2}} {{$customer->address_line3}} {{$customer->alley}} {{$customer->district}}  
                            {{$customer->city}}
                            จังหวัด
                            {{$customer->province_name}} 
                            {{$customer->postal_code}} 
                            {{$shipTo->ship_to_site_name}} 

                            @else 
                            {{$shipTo->ship_to_site_name}}

                        @endif
                    </span>
                    <br>
                    <div>
                        <span style="margin-right:15px;display:inline-block; vertical-align: top"><b>อ้างอิง</b></span>
                        <span style="display: inline-block">ใบกำกับภาษี / ใบขนส่งสินค้า / ใบแจ้งหนี้เลขที่
                            {{ $item->ref_invoice_number }} ลงวันที่ {{ convertDate($item->invoice_date) }} <br>
                        </span>
                    </div>
                    <div>
                        <span
                            style="margin-right:15px;display:inline-block; vertical-align: top"><b>เหตุผลในการลดหนี้</b></span>
                        <span style="display: inline-block">
                        </span>{{ $item->claim->symptom_description }}<br>
                    </div>
                    <br>
                    <div>การยาสูบแห่งประเทศไทย ได้เครดิตบัญชีของท่านตามรายการต่อไปนี้</div>
                    <table style="width:100%">
                        <thead>
                            <tr>
                                <th>ปริมาณซอง</th>
                                <th>รายการ</th>
                                <th>ราคา/ซอง</th>
                                <th>มูลค่าขาย</th>
                                <th>ราคาปลีก/ซอง</th>
                                <th>มูลค่าขายปลีก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sale_price = 0;
                                $sale_price2 = 0;
                            @endphp
                            @foreach ($item->claim->lines as $line)
                                <tr>
                                    <td align="right">
                                        {{ number_format(getQty($line, $item), 2) }}

                                    </td>
                                    <td>{{ $line->item_description }}</td>
                                    <td align="center">
                                        {{ number_format(getAmount($line, $item), 2) }}
                                    </td>
                                    <td align="right">
                                        @php
                                            $sale_price += getQty($line, $item) * getAmount($line, $item);
                                        @endphp
                                        {{ number_format(getQty($line, $item) * getAmount($line, $item), 2) }}
                                    </td>
                                    <td align="right">{{ number_format(getCost($line, $item), 2) }}</td>
                                    <td align="right">
                                        @php
                                            $sale_price2 += getQty($line, $item) * getCost($line, $item);
                                        @endphp
                                        {{ number_format(getQty($line, $item) * getCost($line, $item), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" rowspan="5" style="line-height: 1.4rem">
                                    รวมมูลค่าสินค้าตามใบกำกับภาษีเดิม
                                    <br>มูลค่าสินค้าที่ถูกต้อง <br> ผลต่าง <br>ภาษีมูลค่าเพิ่ม 7%
                                    <br>มูลค่ารวมก่อนหักภาษีมูลค่าเพิ่ม
                                </th>
                                <th rowspan="5"></th>
                                <th align="right">{{ number_format($item->order->grand_total, 2) }}</th>
                                <th rowspan="5"></th>
                                <th align="right">{{ number_format(getAtribute1Line($item), 2) }}</th>
                            </tr>
                            <tr>
                                <td align="right">{{ number_format($item->order->grand_total - $sale_price, 2) }}</td>
                                <td align="right">{{ number_format(getAtribute1Line($item) - $sale_price2, 2) }}</td>
                            </tr>
                            <tr>
                                <td align="right">{{ number_format($sale_price, 2) }}</td>
                                <td align="right">{{ number_format($sale_price2, 2) }}</td>
                            </tr>
                            <tr>
                                <td align="right">{{ number_format(($sale_price2 * 7) / 107, 2) }}</td>
                                <td align="right">{{ number_format(($sale_price2 * 7) / 107, 2) }}</td>
                            </tr>
                            <tr>
                                <td align="right">
                                    {{ number_format($sale_price - (($sale_price2 * 7) / 107), 2) }}</td>
                                <td align="right">
                                    {{ number_format($sale_price2 - (($sale_price2 * 7) / 107), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br><br>
                <div style="margin-left:80px">( {{baht_text($sale_price)}} )</div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div style="display: -webkit-box; width:100%">
                    <div style="width:49.5%; text-align: center">
                        ....................................................... <br>
                        ลายเซ็นต์ลูกค้า
                    </div>
                    <div style="width:49.5%; text-align: center">

                        ....................................................... <br>
                        ผู้รับมอบอำนาจ
                    </div>
                </div>

                <br>
                <br>
                <br>
                <div style="margin-left:80px"><b>ต้นฉบับ</b> - ลูกค้า</div>
                <div style="margin-left:80px"><b>สำเนา</b>
                    <ol style="margin:0">
                        <li>กองบัญชีรายได้และภาษี(2)</li>
                        <li>กองบริหารขาย ฝ่ายขาย</li>
                        <li>กองลูกค้าสัมพันธ์ฝ่ายขาย</li>
                        <li>กองบัญชีต้นทุน</li>
                        <li>กองคลังผลิตภัณฑ์</li>
                    </ol>
                </div>
            </div>
        @endfor
    @endforeach
</body>

</html>
