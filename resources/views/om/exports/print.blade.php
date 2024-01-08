<html>
<head>
    <style>
        @page {
            size: 9.5in 12in;
            margin-top: 50px;
            margin-bottom: 40px;
        }
        body {
            background: rgb(204,204,204);
            font-size:18px;
            font-family: Cordia New, Arial, sans-serif;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        page[size="A4"] {
            width: 9.5in;
            height: 12in;
        }
        @media print {
            body, page {
                size: 9.5in 12in;
                margin: 0;
                box-shadow: 0;
            }
        }
        table{
            width: 100%;
        }
        .pull-left{
            text-align: left;
        }
        .pull-right{
            text-align: right;
        }
        .hidden{
            visibility: hidden;
        }


        .floatLeft { width: 50%; float: left; }
        .floatRight {width: 50%; float: right; }
        .container { overflow: hidden; }


    </style>
</head>
<body onload="window.print()">
    @foreach($invoices as $key => $invoice)
    <page size="A4" class="print" >
        <div style="padding-top: 100px" >
            <div class="container">
                <div class="address floatLeft" style="width: 50%">
                    <table>
                        <tr>
                            <td class="hidden">ร้านขายส่ง</td>
                            <td colspan="3">{{$invoice->customer_name}}</td>
                        </tr>
                        <tr>
                            <td class="hidden">เลขประจำตัวผู้เสียภาษีอากร</td>
                            <td>{{$invoice->taxpayer_id??""}}</td>
                            <td class="hidden">ออกโดย</td>
                            <td>@if($invoice->head_office_flag??"" == "Y") สำนักงานใหญ่ @else {{$invoice->branch??""}} @endif</td>
                        </tr>
                        <tr>
                            <td class="hidden">ที่อยู่</td>
                            <td colspan="3">{{$invoice->address_line1??""}} {{$invoice->address_line2??""}}</td>
                        </tr>
                        <tr>
                            <td class="hidden">ที่อยู่</td>
                            <td colspan="3">{{$invoice->address_line3??""}} {{$invoice->city??""}} {{$invoice->district??""}}</td>
                        </tr>
                        <tr>
                            <td class="hidden">ที่อยู่</td>
                            <td colspan="3">{{$invoice->province_name}} {{$invoice->postal_code}} @if(!empty($invoice->contact_phone))T.{{$invoice->contact_phone}} @endif</td>
                        </tr>
                        <tr>
                            <td class="hidden">ตลาด</td>
                            <td>{{$invoice->province_name??""}}</td>
                            <td class="hidden">รหัส</td>
                            <td>{{$invoice->customer_id??""}}</td>
                        </tr>
                    </table>
                </div>
                <div class="customerDetail floatRight" style="width: 50%">
                    <table style="padding-top: 10px">
                        <tr>
                            <td class="hidden">เลขที่</td>
                            <td>{{$invoice->pick_release_no??""}}</td>
                            <td class="hidden">วันที่</td>
                            <td>@if(!empty($invoice->start_period)) {{parseToDateTh(\Carbon\Carbon::parse($invoice->start_period)->format('d/m/Y'))}} @endif</td>
                            <td colspan="2">
                                <span class="hidden">แผ่นที่</span>
                                <span>{{$key+1}}</span>
                                <span class="hidden">จาก</span>
                                <span>{{count($invoices)}}</span>
                                <span class="hidden">แผ่น</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="hidden">test</td>
                        </tr>
                        <tr>
                            <td class="hidden">วันที่สั่งสินค้า</td>
                            <td>@if(!empty($invoice->order_date)){{parseToDateTh(\Carbon\Carbon::parse($invoice->order_date)->format('d/m/Y'))}} @endif</td>
                            <td class="hidden">สั่งทาง</td>
                            <td>{{$invoice->source_system??""}}</td>
                            <td class="hidden">อ้างอิงใบสั่งซื้อเลขที่</td>
                            <td> @if(!empty($invoice->source_system) && $invoice->source_system== "E-commerce")
                                    {{$invoice->order_number??""}}
                                 @else
                                    {{$invoice->source_system??""}}
                                 @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="hidden">วันที่ส่งสินค้า</td>
                            <td>@if(!empty($invoice->delivery_date)) {{parseToDateTh(\Carbon\Carbon::parse($invoice->delivery_date)->format('d/m/Y'))}} @endif</td>
                            <td class="hidden">ส่งโดย</td>
                            <td>{{$invoice->transport_type_code??""}}<br>
                                @if(!empty($invoice->transport_type_code??"")) <span>{{parseToDateTh(\Carbon\Carbon::now()->format('H:i'))}}</span> @endif
                            </td>
                            <td class="hidden">สถานที่ส่ง</td>
                            <td>{{$invoice->ship_to_site_name??""}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <br>
            <br>
            @if(!empty($invoice['order_line']))
            <table>
                <thead class="hidden">
                    <tr>
                        <td rowspan="2" style="width: 50px">รายการ</td>
                        <td colspan="2" style="width: 180px">จำนวนบรรจุ</td>
                        <td rowspan="2">จำนวนยาสูบ <br> พันมวน</td>
                        <td rowspan="2" style="width: 170px">ตรา</td>
                        <td colspan="2">ราคาขาย</td>
                        <td colspan="2">ราคาขายปลีก</td>
                    </tr>
                    <tr>
                        <td>หีบ</td>
                        <td>ห่อ</td>
                        <td>บาท/หน่วย</td>
                        <td>จำนวนเงิน(บาท)</td>
                        <td>บาท/หน่วย</td>
                        <td>จำนวนเงิน(บาท)</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"></td>
                        <td> @if(!empty($invoice->province_name) && $invoice->province_name == "กรุงเทพมหานคร") ไม่อบจ. @else อบจ. @endif</td>
                        <td></td>
                        <td>@if($invoice->sale_classification_code == "DOMESTIC" && $invoice['customer_promo'][0]->meaning == "Modern trade") ราคา/หีบ @endif</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach($invoice['order_line'] as $orderLine)
                    <tr>
                        <td>{{$orderLine->line_number??""}}</td>
                        <td>@if(!empty($orderLine->approve_quantity) && $orderLine->uom_code == "cgc") {{$orderLine->approve_quantity/$orderLine->conversion_rate??1}} @endif</td>
                        <td>@if(!empty($orderLine->approve_quantity) && $orderLine->uom_code == "cg2") {{$orderLine->approve_quantity/$orderLine->conversion_rate??1}}@endif</td>
                        <td>@if(!empty($orderLine->approve_quantity)) {{$orderLine->approve_quantity}} @endif</td>
                        <td>{{$orderLine->item_description??""}}</td>
                        <td @if($invoice->customer_id == 2101017) style="visibility: hidden" @endif></td>
                        <td @if($invoice->customer_id == 2101017) style="visibility: hidden" @endif> {{ number_format(($orderLine->amount??0),2)}}</td>
                        <td @if($invoice->product_type == "ยาเส้นไม่ปรุง") style="visibility: hidden" @endif> {{$orderLine->rounding_factor??0}}</td>
                        <td>{{$orderLine->approve_quantity*$orderLine->rounding_factor??0}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($orderLines->pluck('amount')->sum(),2)??0}}</td>
                        <td></td>
                        <td></td>
                        <td>{{number_format(($orderLines->pluck('approve_quantity')->sum()*$orderLines->pluck('rounding_factor')->sum()),2)??0}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> ภาษีมูลค่าเพิ่มร้อยละ</td>
                        <td> {{$invoice->tax_rate??0}}</td>
                        <td>{{$invoice->tax_amount??0}}</td>
                        <td></td>
                        <td>{{number_format(($orderLines->pluck('amount')->sum()+$invoice->tax_amount),2)??0}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> ภาษีมูลค่าสินค้ารวมภาษี</td>
                        <td> </td>
                        <td>{{$invoice->total_amount??0}}</td>
                        <td></td>
                        <td>{{number_format((($orderLines->pluck('approve_quantity')->sum()*$orderLines->pluck('rounding_factor')->sum())+$invoice->total_amount),2)??0}}</td>
                    </tr>
                    @foreach($orderLines['credit_note'] as $creditNote)
                    <tr>
                        <td></td>
                        <td>เงินเชื่อกลุ่ม @if($invoice->sale_classification_code == "DOMESTIC" && $invoice['customer_promo'][0]->meaning == "Modern trade") 3 @else {{$creditNote->credit_group_code}} @endif</td>
                        <td></td>
                        <td>กำหนดชำระวันที่</td>
                        <td>@if(!empty($invoice->payment_duedate)) {{parseToDateTh(\Carbon\Carbon::parse($invoice->payment_duedate)->format('d/m/Y'))}} @endif</td>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>จำนวนเงินที่ชำระเป็นเงินสด</td>
                        <td></td>
                        <td></td>
                        <td>{{$invoice->cash_amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="9">{{$invoice->remark??""}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </page>
    @endforeach
</body>
</html>