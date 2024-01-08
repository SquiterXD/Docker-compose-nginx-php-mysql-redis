<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Invoice No</title>

    <link href="{!! asset('custom/omr0003.css') !!}" rel="stylesheet">
    <style>
        .page-break {
            display: block;
            page-break-before: always;
        }
    </style>
</head>
<body class="font-cordia">

    @foreach ($dataAll as $key =>  $dataItem)
    <div class="box-header page {{ ($key > 0)? 'page-break' : '' }} ">
        <table style="width: 100%; margin-top:5mm">
            <tbody><tr>
                <td style="width: 400px;">
                    <table class="header-company" style="width: 100%;">
                        <tbody><tr>
                            <td colspan="2">
                                <span style="padding-left: 55px;">{{ $dataItem['order']->customer_name }}</span>
                                <span class="" style="padding-left: 112px;display: block;"><span class="company_tax">{{ $dataItem['order']->taxpayer_id }}</span>
                                @if($dataItem['order']->customer_id == 3)
                                    @if($dataItem['order']->attribute6 == 0)
                                    <span class="company_branch">{{ $dataItem['order']->head_office_flag == 'Y' ? 'สำนักงานใหญ่' : 'สาขา 00047' }}</span>
                                    @else 
                                    <span class="company_branch">{{ $dataItem['order']->head_office_flag == 'Y' ? 'สำนักงานใหญ่' : 'สาขา 00567' }}</span>
                                    @endif
                                @else 
                                <span class="company_branch">{{ $dataItem['order']->head_office_flag == 'Y' ? 'สำนักงานใหญ่' : $dataItem['order']->branch }}</span>
                                @endif
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @if($dataItem['order']->attribute6 == "1")
                                <span class="line-height-address" style="padding-left: 24px;display: block;"> {{ $dataItem['order']->s_address_line1 }} {{ $dataItem['order']->s_address_line2 }} {{ $dataItem['order']->s_address_line3 }} {{ $dataItem['order']->s_alley != '-' ? $dataItem['order']->s_alley : '' }} </span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">{{ $dataItem['order']->s_district }} {{ $dataItem['order']->s_city }}</span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">จ. {{ $dataItem['order']->s_province_name }} {{ $dataItem['order']->s_postal_code }} <span class="company_phone"> {{ !empty($dataItem['order']->contact_phone) ? 'T. '.$dataItem['order']->contact_phone : '' }}</span></span>
                               
                                @else
                                <span class="line-height-address" style="padding-left: 24px;display: block;"> {{ $dataItem['order']->address_line1 }} {{ $dataItem['order']->address_line2 }} {{ $dataItem['order']->address_line3 }} {{ $dataItem['order']->alley != '-' ? $dataItem['order']->alley : '' }} </span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">{{ $dataItem['order']->district }} {{ $dataItem['order']->city }}</span>
                                <span class="line-height-address" style="padding-left: 10px;display: block;">จ. {{ $dataItem['order']->province_name }} {{ $dataItem['order']->postal_code }} <span class="company_phone"> {{ !empty($dataItem['order']->contact_phone) ? 'T. '.$dataItem['order']->contact_phone : '' }}</span></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;width: 220px; padding-bottom:5px;">
                                <span style="padding-left: 26px;display: block;"> 
                                    {{-- {{ $dataItem['order']->customer_type_id == 20 ? $dataItem['order']->market : $dataItem['order']->s_province_name }} --}}
                                    @if ($dataItem['order']->attribute6 == 1 && $dataItem['order']->customer_number == 'D00003')
                                        {{ $dataItem['order']->s_province_name }}
                                    @else
                                        {{ $dataItem['order']->customer_type_id == 20 ? $dataItem['order']->market : $dataItem['order']->s_province_name }}
                                    @endif
                                 </span>
                            </td>
                            <td style="padding-top: 13px; padding-left:5px; padding-bottom:5px;">
                                {{ $dataItem['order']->customer_number }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="" valign="top" style="padding-top: 43px;">
                    <table class="font-16">
                        <tr>
                            <td style="width: 95px;">
                                {{ $dataItem['order']->pick_release_no }}
                            </td>
                            <td style="width: 120px; padding-left:4mm">
                                {{ $dataItem['order']->pick_release_approve_date }}
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
                                {{ $dataItem['order']->order_date }}
                            </td>
                            <td style="width: 100px;padding-left: 35px;">
                                {{ $dataItem['order']->source_system }}
                            </td>
                            <td class="text-right" stlye="white-spece:nowrap">
                                {{ $dataItem['order']->source_system == 'E-commerce' || $dataItem['order']->source_system == 'E-COMMERCE' ? $dataItem['order']->order_number : Str::limit($dataItem['order']->remark_source_system, '15', '') }}
                            </td>
                            <td class="text-left headers-send" stlye="white-spece:nowrap">
                                {{ $dataItem['order']->requestor_description }}
                            </td>

                        </tr>
                        <tr style="margin-top:-6mm">
                            <td class="text-right" style="width: 72px;">
                                {{ $dataItem['order']->delivery_date }}
                            </td>
                            <td class="" style="width: 100px;padding-left: 36px;">
                                <span style="display: block;line-height: 10px;"> {{ $dataItem['order']->transport_type_description }} </span>
                                <span style="display: block;line-height: 10px;"> เวลา {{ date('H:i') }} </span>
                            </td>
                            <td class="text-right headers-send" style="white-space: nowrap" colspan="2">
                                {{ Str::limit($dataItem['order']->cust_po_number, 30, '')}} <br>
                                {{ Str::limit($dataItem['order']->ship_to_site_name, 30, '') }}
                            </td>

                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
    </div>


    <div class="box-table" >
        <table style="width: 100%; margin-top:2mm" cellspacing="0" cellpadding="0">

            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2" style="text-align:right; padding-right:2.5mm"> {{ $dataItem['order']->product_type_code != 20 ? $dataItem['order']->ship_show_line : 'จำนวนยาเส้น/หีบ' }} </td>
                    <td></td>
                    <td>{{ $dataItem['order']->product_type_code != 20 ? '' : 'บาท/หีบ' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                @if (!empty($dataItem['orderLine']))
                @foreach ($dataItem['orderLine'] as $item)
                <tr>
                    <td class="w-15mm text-center">{{ $item->line_number }}</td>
                    <td class="text-left w-15mm text-center" style="padding-right: 3mm">{{ $item->approve_cardboardbox == 0 ? '' : $item->approve_cardboardbox }}</td>
                    <td class="text-left  w-15mm text-center">{{ $item->approve_carton == 0 ? '' : $item->approve_carton }}</td>
                    <td class="text-left w-20mm text-right" style="padding-right: 3mm">{{ $item->approve_quantity == 0 ? '' : number_format($item->approve_quantity, 2, '.', ',')  }}</td>
                    <td class="w-38mm" style="padding-left: 2.5mm;">{{ $item->item_description }}</td>

                    @if (($dataItem['order']->customer_type_id == '80' && $dataItem['order']->order_type_id != '1109'))
                        <td class="w-20mm text-right" style="padding-right: 2.5mm"> &nbsp; </td>
                        <td class="w-35mm text-right"> &nbsp; </td>
                    @else
                        <td class="w-20mm text-right" style="padding-right: 2.5mm">{{ $dataItem['order']->product_type_code != 20 ? $item->unit_price : $item->attribute2 }}</td>
                        <td class="w-35mm text-right">{{ $item->amount }}</td>
                    @endif

                    <td class="w-25mm text-right">{{ $dataItem['order']->product_type_code != 20 ? $item->operand : '' }}</td>
                    <td class="w-35mm text-right">{{ $dataItem['order']->product_type_code != 20 ? $item->total_operand : '' }}</td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endforeach
                @endif

                <tr>
                    <td class="" width="30"></td>
                    <td class="" colspan="2" width="50">{{ $dataItem['order']->product_type_code != 20 ? 'รวมพันมวน' : 'รวมซอง' }}</td>
                    <td class="text-right padding-r-10" width="50">{{ !empty($dataItem['totalOrderLines']['total_approve_quantity']) ? number_format($dataItem['totalOrderLines']['total_approve_quantity'], 2, '.', ',') : '' }}</td>
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
                    <td class="text-right" width="100">{{ !empty($dataItem['totalOrderLines']['total_cal_amount']) ? $dataItem['totalOrderLines']['total_cal_amount'] : '' }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($dataItem['totalOrderLines']['total_cal_operand']) && $dataItem['order']->product_type_code != 20 ? $dataItem['totalOrderLines']['total_cal_operand'] : '' }}</td>
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
                    <td class="text-center" width="100">{{ $dataItem['order']->tax_rate }}</td>
                    <td class="text-right" width="100">{{ $dataItem['order']->tax }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ $dataItem['order']->product_type_code != 20 ? $dataItem['order']->tax : '' }}</td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">{{ $dataItem['order']->product_type_code != 20 ? 'มูลค่าสินค้ารวมภาษี' : '' }}</td>
                    <td class="" width="100"></td>
                    <td class="text-right" width="100">{{ $dataItem['order']->grand_total }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($dataItem['totalOrderLines']['total_operand']) && $dataItem['order']->product_type_code != 20 ? $dataItem['totalOrderLines']['total_operand'] : '' }}</td>
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

                @if (!empty($dataItem['creditGroupList']) && $dataItem['order']->product_type_code != 20)
                @foreach ($dataItem['creditGroupList'] as $key => $item)
                @if ($item['sum_amount'] != '0.00')
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="300" colspan="3">เงินเชื่อกลุ่ม {{ $item['credit_group_code'] }} กำหนดชำระวันที่</td>
                    <td class="text-center" width="100">{{ $item['credit_group_date'] }}</td>
                    <td class="text-right" width="100">{{ $item['sum_amount'] }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                @endif
                @endforeach
                @endif

                {{-- @if (($dataItem['order']->customer_type_id == '80' && $dataItem['order']->order_type_id != '1109') || ($dataItem['order']->customer_type_id == '30' || $dataItem['order']->customer_type_id == '40' )) --}}
                {{-- @if($dataItem['order']->cash_amount > 0) --}}
                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="300" colspan="3">จำนวนที่ชำระเป็นเงินสด</td>
                    <td class="text-center" width="100" >{{ $dataItem['order']->delivery_date }}</td>
                    <td class="text-right" width="100">{{ !empty($dataItem['order']->cash_amount) ? $dataItem['order']->cash_amount : 0 }}</td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>
                {{-- @endif --}}

                @if (!empty($dataItem['paoPercentINVList']) && $dataItem['order']->product_type_code != 20)
                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>
                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>
                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>
                @foreach ($dataItem['paoPercentINVList'] as $key => $item)
                {{-- <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">{{ 'อบจ.' . $dataItem['paoPercentINVList']->province_name_head }}</td>
                    <td class="" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($dataItem['paoPercentINVList']->approve_quantity_head_office) ? number_format($dataItem['paoPercentINVList']->approve_quantity_head_office, 2, '.', ',') : 0.00 }}</td>
                    <td class="text-right" width="100"> พันมวน </td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr>

                <tr>
                    <td class="" width="30"></td>
                    <td class="" width="50"></td>
                    <td class="text-right padding-r-10" width="50"></td>
                    <td class="text-right padding-r-10" colspan="2" width="200">{{ 'อบจ.' . $dataItem['paoPercentINVList']->province_name_branch }}</td>
                    <td class="" width="100"></td>
                    <td class="text-right" width="100">{{ !empty($dataItem['paoPercentINVList']->approve_quantity_branch) ? number_format($dataItem['paoPercentINVList']->approve_quantity_branch, 2, '.', ',') : 0.00 }}</td>
                    <td class="text-right" width="100"> พันมวน </td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr> --}}

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

                {{-- <tr>
                    <td class="" width="30"></td>
                    <td class="" width="300" colspan="3">{{ 'อบจ.' . $item->province_name }}</td>
                    <td class="text-center" width="100" ></td>
                    <td class="text-right" width="100">{{ !empty($item->tax_per_qty) ? number_format($item->tax_per_qty, 2, '.', ',') : 0.00 }}</td>
                    <td class="text-right" width="100"> พันมวน </td>
                    <td class="text-right" width="100"></td>
                    <td class="text-right" width="100"></td>
                    <td class="" width="10"></td>
                    <td class=""></td>
                    <td class=""></td>
                </tr> --}}
                @endforeach
                @endif

                <tr>
                    <td class="" colspan="11" style="line-height: 22px;">&nbsp;</td>
                </tr>

                <tr>
                    <td class="" width="30"></td>
                    <td class="" colspan="5">
                        @if( $dataItem['order']->program_code == "OMP0020" || $dataItem['order']->customer_type_id == '60' || $dataItem['order']->attribute8== 1)
                        {{ $dataItem['order']->remark }} 
                        @endif
                    </td>
                    <td class="" colspan="5"></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach

</body>
</html>
