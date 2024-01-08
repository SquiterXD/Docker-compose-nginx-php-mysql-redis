<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Invoice No : {{ $order->pick_release_no }}</title>

    <link href="{!! asset('custom/omr0003.css') !!}" rel="stylesheet">
</head>
<body class="font-cordia">
    <div class="box-header page">
        <table style="width: 100%; margin-top:5mm">
            <tbody><tr>
                <td style="width: 400px;">
                    <table class="header-company" style="width: 100%;">
                        <tbody><tr>
                            <td colspan="2">
                                <span style="padding-left: 55px;">{{ $order->customer_name }}</span>
                                <span class="" style="padding-left: 112px;display: block;"><span class="company_tax">{{ $order->taxpayer_id }}</span><span class="company_branch">{{ $order->head_office_flag == 'Y' ? 'สำนักงานใหญ่' : $order->branch }}</span></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="line-height-address" style="padding-left: 24px;display: block;"> {{ $order->address_line1 }} {{ $order->address_line2 }} {{ $order->address_line3 }} {{ $order->alley != '-' ? $order->alley : '' }} </span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">{{ $order->district }} {{ $order->city }}</span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">จ. {{ $order->province_name }} {{ $order->postal_code }} <span class="company_phone"> {{ !empty($order->contact_phone) ? 'T. '.$order->contact_phone : '' }}</span></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;width: 220px; padding-bottom:5px;">
                                <span style="padding-left: 26px;display: block;"> {{ $order->province_name }} </span>
                            </td>
                            <td style="padding-top: 13px; padding-left:5px; padding-bottom:5px;">
                                {{ $order->customer_number }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="" valign="top" style="padding-top: 43px;">
                    <table class="font-16">
                        <tr>
                            <td style="width: 95px;">
                                {{ $order->pick_release_no }}
                            </td>
                            <td style="width: 120px; padding-left:4mm">
                                {{ $order->pick_release_approve_date }}
                            </td>
                            <td style="width: 70px; padding-left:3mm">
                                1
                            </td>
                            <td style="width: 70px; padding-left:2mm">
                                1
                            </td>
                        </tr>
                    </table>

                    <table class="font-16" style="margin-top: 13px;">
                        <tr>
                            <td class="text-right" style="width: 72px;">
                                {{ $order->order_date }}
                            </td>
                            <td style="width: 100px;padding-left: 35px;">
                                {{ $order->source_system }}
                            </td>
                            <td style="width: 20px;">
                            </td>
                            <td class="text-right">
                                {{ $order->source_system == 'E-commerce' || $order->source_system == 'E-COMMERCE' ? $order->order_number : $order->remark_source_system }}
                            </td>

                        </tr>
                        <tr style="margin-top:-6mm">
                            <td class="text-right" style="width: 72px;">
                                {{ $order->delivery_date }}
                            </td>
                            <td class="" style="width: 100px;padding-left: 36px;">
                                <span style="display: block;line-height: 10px;"> {{ $order->transport_type_description }} </span>
                                <span style="display: block;line-height: 10px;"> {{ $order->shipment_time }} </span>
                            </td>
                            <td class="text-right headers-send" colspan="2">
                                {{ $order->ship_to_site_name }}
                            </td>

                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
    </div>


    <div class="box-table">
        <table style="width: 100%; margin-top:2mm" cellspacing="0" cellpadding="0">

            <tbody>
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td style="text-align:right; padding-right:2.5mm"> {{ $order->product_type_code != 20 ? $order->ship_show_line : 'จำนวนยาเส้น/หีบ' }} </td>
                    <td></td>
                    <td>{{ $order->product_type_code != 20 ? '' : 'บาท/หีบ' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                @if (!empty($orderLine))
                @foreach ($orderLine as $item)
                <tr>
                    <td class="w-15mm text-center">{{ $item->line_number }}</td>
                    <td class="text-left w-15mm text-center" style="padding-right: 3mm">{{ $item->approve_cardboardbox == 0 ? '' : $item->approve_cardboardbox }}</td>
                    <td class="text-left  w-15mm text-center">{{ $item->approve_carton == 0 ? '' : $item->approve_carton }}</td>
                    <td class="text-left w-20mm text-right" style="padding-right: 3mm">{{ $item->approve_quantity == 0 ? '' : $item->approve_quantity  }}</td>
                    <td class="w-38mm" style="padding-left: 2.5mm;">{{ $item->item_description }}</td>

                    @if (($order->customer_type_id == '80' && $order->order_type_id != '1109'))
                        <td class="w-20mm text-right" style="padding-right: 2.5mm"> &nbsp; </td>
                        <td class="w-35mm text-right"> &nbsp; </td>
                    @else
                        <td class="w-20mm text-right" style="padding-right: 2.5mm">{{ $item->unit_price }}</td>
                        <td class="w-35mm text-right">{{ $item->amount }}</td>
                    @endif

                    <td class="w-25mm text-right">{{ $order->product_type_code != 20 ? $item->operand : '' }}</td>
                    <td class="w-35mm text-right">{{ $order->product_type_code != 20 ? $item->total_operand : '' }}</td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endforeach
                @endif

                <tr>
                    <td class="" width="30"></td>
                    <td class="" colspan="2" width="50">{{ $order->product_type_code != 20 ? 'รวมพันมวน' : 'รวมซอง' }}</td>
                    <td class="text-right padding-r-10" width="50">{{ !empty($totalOrderLines['total_approve_quantity']) ? $totalOrderLines['total_approve_quantity'] : '' }}</td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="" width="150"></td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($totalOrderLines['total_cal_amount']) ? $totalOrderLines['total_cal_amount'] : '' }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($totalOrderLines['total_cal_operand']) && $order->product_type_code != 20 ? $totalOrderLines['total_cal_operand'] : '' }}</td>
                    <td class="text-right" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">ภาษีมูลค่าเพิ่มร้อยละ</td>
                    <td class="text-center" width="100">{{ $order->tax_rate }}</td>
                    <td class="text-right" width="100">{{ $order->tax }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ $order->product_type_code != 20 ? $order->tax : '' }}</td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">{{ $order->product_type_code != 20 ? 'มูลค่าสินค้ารวมภาษี' : '' }}</td>
                    <td class="" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($totalOrderLines['total_amount']) ? $totalOrderLines['total_amount'] : '' }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($totalOrderLines['total_operand']) && $order->product_type_code != 20 ? $totalOrderLines['total_operand'] : '' }}</td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>


                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>


                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>

                @if (!empty($creditGroupList) && $order->product_type_code != 20)
                @foreach ($creditGroupList as $key => $item)
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="300" colspan="3">เงินเชื่อกลุ่ม {{ $item['credit_group_code'] }} กำหนดชำระวันที่</td>
                    <td class="text-left" width="100">{{ $item['credit_group_date'] }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ $item['sum_amount'] }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endforeach
                @endif

                @if (($order->customer_type_id == '80' && $order->order_type_id != '1109') || $order->customer_type_id == 20)
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="300" colspan="3">จำนวนที่ชำระเป็นเงินสด</td>
                    <td class="text-left" width="100" >{{ $order->payment_date }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($order['cash_amount']) ? $order['cash_amount'] : 0.00 }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endif

                @if (!empty($paoPercentINVList) && $order->product_type_code != 20)
                @foreach ($paoPercentINVList as $key => $item)
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">{{ 'อบจ.' . $item->province_name }}</td>
                    <td class="" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($item->tax_per_qty) ? number_format($item->tax_per_qty, 2, '.', ',') : 0.00 }}</td>
                    <td class="text-right" width="100"> พันมวน </td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endforeach
                @endif

                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>

                <tr>
                    <td class="" width="30"></td>
                    <td class="" colspan="5">{{ $order->remark }} </td>
                    <td class="" colspan="5"></td>
                </tr>
            </tbody>
        </table>
    </div>


</body>
</html>
