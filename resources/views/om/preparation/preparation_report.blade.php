<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OMR0002</title>
    <style>
         @font-face {
            font-family: 'THSarabunPSK';
            src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(file_get_contents(public_path('fonts/th-sarabun-psk/THSarabun.ttf')))}})
            format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url(data:font/truetype;charset=utf-8;base64,{{base64_encode(file_get_contents(public_path('fonts/THSarabunNew Bold.ttf')))}})
        }
        html {background-color: #2f4050;}
        body {
            padding: 0;
            background-color: #FFF;
            font-size: 16px;
            margin: 0;
            margin-left: auto;
            margin-right: auto;
        }
        h1 {margin: 0;}
        h5 {margin: 0;padding: 0;font-weight: lighter;}
        h3 {margin: 0;padding: 0;font-weight: bold;}
        .font-thsarabun {font-family: 'THSarabunPSK';}
        .font-cordia {font-family: 'THSarabunPSK';}
        .right {text-align: right;}
        .page-number {padding: 1rem 2rem;font-size: 18px;display: block;text-align: right;}
        h4.title {font-size: 28px;font-weight: 400;text-align: center;margin-bottom: 0;}
        h5.title-desc {font-size: 22px;font-weight: 400;text-align: center;}
        .box-header {border: 1px solid #9E9E9E;padding: 1rem 1rem 2.5rem 1rem;margin: 6px 1rem 6px 1rem;font-size: 20px;}
        ul {padding: 0;list-style: none;margin: 0;}
        ul li {padding: 0;}
        .list .box-list {border: 1px solid #9E9E9E;padding: .5rem .5rem .1rem .5rem;margin: 0px 1rem 0 1rem;font-size: 20px;border-bottom: none;}
        .list .box-list:last-child {border-bottom: 1px solid #9E9E9E;}
        .border-bottom-1 {border-bottom: 1px solid #000;}
        .border-bottom-2 {border-bottom: 3px double #000;}

        .box-table {margin: 1rem 1rem 0 1rem;font-size: 20px;}
        .box-table table {border: 1px solid #9E9E9E;}
        .box-table table thead {background-color: #f6f6f6f6;}
        .box-table table tr th {font-weight: 400;}
        .box-table table tr td {padding: 3px 3px;border-bottom: 1px solid #9E9E9E;border-right: 1px solid #9E9E9E;}
        .box-table table tr td:last-child {padding: 0 3px;border-right: none;}
        .box-table table tr:last-child td {padding: 0 3px;border-bottom: none;}
        .text-right {text-align: right;}
        .text-center {text-align: center;}

        .bt {border-top: 1px solid #3f3f3f;}
        .bl {border-left: 1px solid #3f3f3f;}
        .br {border-right: 1px solid #3f3f3f;}
        .bb {border-bottom: 1px solid #3f3f3f;}

        .table-list {font-size: 16px;}
        .table-list tr.header td {padding: 4px 0;}
        .table-list tr.list td {padding: 1px 6px;}

        table.no-border {border: none;}
        table.no-border tr td {padding: 4px 6px;}

        .table-signature {width: 600px;margin-left:auto;margin-right:auto;margin-top: 1rem;}
        .table-signature tr td {padding: 6px 10px;line-height: 2.4rem;vertical-align: bottom;}
        .tr-hi{
            line-height: 16px;
        }
    </style>
</head>
<body class="font-cordia" style="padding:12px;">
    <table style="width:100%;">
        <tr class="tr-hi">
            <td>ใบเตรียมเลขที่</td>
            <td>{{ $orderHeader->prepare_order_number }}</td>
            <td>วันที่เตรียมขาย</td>
            <td>{{ dateFormatThaiString($orderHeader->order_date) }}</td>
            <td style="color:red;">สถานะ</td>
            <td>
                {{ $customerTypeDomestic->description }}
                {{ ($orderHeader->order_status) }}
            </td>
            <td>เวลา</td>
            <td colspan="2">{{ date('H:i') }}</td>
        </tr>

        <tr class="tr-hi">
            <td>รหัสลูกค้า</td>
            <td>{{ $customer->customer_number }} ({{ $customer->customer_code_tm }})</td>
            <td>ชื่อร้าน</td>
            <td style="font-weight: bold">{{ $customer->customer_name }}</td>
            <td>เลขประจำตัวผู้เสียภาษี</td>
            <td>{{ $customer->taxpayer_id }}</td>
            <td>ที่อยู่</td>
            <td>{{ $orderHeader->attribute6 == 1 && $customer->customer_number == 'D00003' ? $shipSites->province_name : $customer->province_name }}</td>
        </tr>

        <tr class="tr-hi">
            <td>ใบสั่งเลขที่</td>
            <td>{{ ($customer->customer_type_id == 20) ? $orderHeader->cust_po_number : $orderHeader->order_number }}</td>
            <td>วันที่สั่งซื้อ</td>
            <td>{{ dateFormatThaiString($orderHeader->order_date) }}</td>
            <td>งวดที่</td>
            <td>{{ $period->period_no }}</td>
            <td>ภาค</td>
            <td>{{ $customer->region_code }}</td>
        </tr>

        <tr class="tr-hi">
            <td>รายการสั่งทาง</td>
            <td>{{ $orderHeader->source_system }} 
                @if($requestor)
                    {{$requestor->description}}
                @endif
            </td>
            <td>วันที่ส่ง</td>
            <td>({{$customer->delivery_date}}) {{ dateFormatThai($orderHeader->delivery_date) }}</td>
            <td>ส่งที่</td>
            <td>{{ $shipSites->ship_to_site_name }}</td>
            <td>ตลาด</td>
            <td>{{ $orderHeader->attribute6 == 1 && $customer->customer_number == 'D00003' ? $shipSites->province_name : $customer->market }}</td>
        </tr>

        @php 
            $c = (new App\Http\Controllers\OM\Api\OrderEcomController)->remainingAmountCallback($customer->customer_id, Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$orderHeader->delivery_date)->format('d/m/Y'), $orderHeader->period_id);
        @endphp

        @foreach($credit_group as $key => $item)
        @php
            try {
                
                $remaining_base = $c['cusContractGroup']->where('credit_group_code', $item->lookup_code)->first();
                $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
                $ptOmDebtDomV = $c['ptOmDebtDomV']->where('credit_group_code', $item->lookup_code)->sum('outstanding_debt');
                $debtDomV = $c['debtDomV']->where('credit_group_code', $item->lookup_code)->sum('outstanding_debt');
                $orderHeaders = $c['orderHeaders']->where('credit_group_code', $item->lookup_code)
                    ->where('prepare_order_number', '!=', request()->prepare_order_number)
                    ->sum('amount');
                $new_remaining_amount = $remaining_base - $ptOmDebtDomV - $orderHeaders + $debtDomV;
            } catch (\Throwable $th) {
                $new_remaining_amount = 0;
            }
        @endphp

        <tr class="tr-hi">
            @if($key == 0)
            <td>ประเภทลูกค้า</td>
            <td>{{ ($shipSites->province_code == 10) || ($customerTypeDomestic->customer_type == 20) ? 'ไม่อบจ.' : 'อบจ.' }}</td>
            @else
            <td>จัดส่งบุหรี่โดย</td>
            <td>
                @if($shipmentBy->lookup_code == 20)
                {{($transportOwner->transport_owner_name)}}
                @else
                {{ $shipmentBy->description }}
                @endif
            </td>
            @endif
            <td>วงเงินเชื่อ&nbsp;&nbsp;{{ $item->lookup_code }}</td>
            <td style="display: flex;">
                @if ($orderHeader->payment_type_code == '10' || $orderHeader->product_type_code == '20')
                    {{ number_format(0,2) }}
                @else
                    @if ($cusContracts)
                        {{ number_format(0,2) }}
                    @else
                        <span style="text-align: right;">
                            {{  number_format($orderRemainging->{"group{$item->lookup_code}_amount"} ?? 
                                ($new_remaining_amount >= 0 ? $new_remaining_amount :0 ),2) }} บาท
                        </span>
                    @endif
                @endif
            </td>
            <td>วงเงินเชื่อคงเหลือ&nbsp;&nbsp;{{ $item->lookup_code }}</td>
            <td>
                @if ($orderHeader->payment_type_code == '10' || $orderHeader->product_type_code == '20')
                    {{ number_format(0,2) }}
                @else
                    @if ($cusContracts)
                        {{ number_format(0,2) }}
                    @else
                        @php 
                            $remaining_base_call = $new_remaining_amount - ($orderCreditGroup->where('credit_group_code', $item->lookup_code)->first()->amount ?? 0);
                        @endphp
                            {{  number_format($orderRemainging->{"group{$item->lookup_code}_remaining"} ?? 
                                ($remaining_base_call >= 0 ? $remaining_base_call : 0) ?? 0 ,2)             }} บาท
                    @endif
                @endif
            </td>
            <td colspan="2"></td>
        </tr> 

        @endforeach
    </table>
    
    <table style="width: 100%;" cellspacing="0" class="table-list">
        <tr class="header tr-hi">
            <td colspan="3" class="text-center bt">ยอดสั่ง/ส่ง ครั้งหลังสุด</td>
            <td rowspan="2" class="text-center bt bb">รหัสบุหรี่</td>
            <td rowspan="2" style="width: 160px;" class="text-center bt bb">ตรา</td>
            <td rowspan="2" class="text-center bt bb">จำนวนที่เพิ่ม</td>
            <td rowspan="2" class="text-right bt bb">จำนวนที่สั่ง</td>
            <td rowspan="2" class="text-right bt bb">อนุมัติส่ง</td>
            <td rowspan="2" class="text-right bt bb">โควต้า/งวด</td>
            <td rowspan="2" class="text-right bt bb" style="width: 30px;"></td>
            <td rowspan="2" colspan="2" class="text-right bt bb">จำนวนเงินทั้งสิ้น</td>
            <td rowspan="2" style="width: 60px;" class="text-center bt bb"></td>
        </tr>

        <tr class="header tr-hi">
            <td class="text-right bb" style="width: 80px;">วันที่</td>
            <td class="text-right bb" style="width: 100px;">สั่ง (X) {{ ($orderHeader->product_type_code == 20) ? 'หีบ' : 'พันมวน'}}</td>
            <td class="text-center bb" style="width: 100px;">ส่ง (X) {{ ($orderHeader->product_type_code == 20) ? 'หีบ' : 'พันมวน'}}</td>
        </tr>

        @foreach($credit_group as $item)
            @if(count($item->orderLine) > 0)
                @foreach($item->orderLine as $line)
                    <tr class="list tr-hi">
                        <td class="text-right">{{ $line->latest_order_date }}</td>
                        <td class="text-right">{{ $line->latest_order_quantity }}</td>
                        <td class="text-center">{{ $line->latest_approve_quantity }}</td>
                        <td class="text-center">{{ $line->item_code }}</td>
                        <td>{{ $line->item_description }}</td>
                        <td class="text-center">
                            @php
                                $adjust = ($line->approve_quantity != ''? $line->approve_quantity: $line->order_quantity) - $line->order_quantity;
                            @endphp
                            {{ $adjust >= 0? number_format($adjust, 2): '('.number_format(abs($adjust), 2).')' }}
                        </td>
                        <td class="text-right">{{ number_format($line->order_quantity,2) }}</td>
                        <td class="text-right">
                            {{  (($line->approve_quantity != '') ? 
                                number_format($line->approve_quantity,2) : 
                                number_format($line->order_quantity,2))     }}
                        </td>
                        <td class="text-right">{{ number_format($line->received_quota,2) }}</td>
                        <td class="text-right"></td>
                        <td class="text-right" colspan="2">{{ number_format($line->amount,2) }}</td>
                        <td style="padding-left: 10px;">บาท</td>
                    </tr>
                @endforeach
                @php 
                    $sumReceivedQuota = 0;
                    foreach ($item->orderLine as $line) {
                        $sumReceivedQuota += $line['received_quota'];
                    }
                    
                    @$new_remaining_aomunt = @$orderCreditGroup->where('credit_group_code', $item->lookup_code)->first();
                @endphp
                <tr class="list tr-hi" style="color:black; font-weight:bold">
                    <td class="text-right" colspan="4"></td>
                    <td class="text-center">รวม</td>
                    <td class="text-center"></td>
                    <td class="text-right">{{ number_format($item->total_order,2) }}</td>
                    <td class="text-right">{{ number_format($item->total_approve,2) }}</td>
                    <td class="text-right">{{ number_format($sumReceivedQuota,2) }}</td>
                    <td class="text-right"></td>
                    <td class="text-left">รวมเงินสินเชื่อ {{ $item->lookup_code }}</td>
                    <td class="text-right">{{ $new_remaining_aomunt ? number_format($new_remaining_aomunt->amount,2) : 0 }}</td>
                    <td style="padding-left: 10px;">บาท</td>
                </tr>

            @endif
        @endforeach

        @if(count($cash_group->orderLine) > 0)
            @foreach ($cash_group->orderLine->groupBy('old_credit_group_code') as $key => $lines)
                @php
                    $sumOrderGroupBy = 0;
                    $sumOrderApproveGroupBy = 0;
                    $sumReceivedQuotaGroupBy = 0;
                @endphp
                @foreach ($lines->where('promotion_product_id', null) as $line_c)

                    @php
                        $sumOrderGroupBy += $line_c->order_quantity;
                        $sumOrderApproveGroupBy += $line_c->approve_quantity;
                        $sumReceivedQuotaGroupBy += $line_c->received_quota;
                    @endphp
                    <tr class="list tr-hi">
                        <td class="text-right">{{ $line_c->latest_order_date }}</td>
                        <td class="text-right">{{ $line_c->latest_order_quantity }}</td>
                        <td class="text-center">{{ $line_c->latest_approve_quantity }}</td>
                        <td class="text-center">{{ $line_c->item_code }}</td>
                        <td>{{ $line_c->item_description }}</td>
                        <td class="text-center">
                            @php
                                $adjust = ($line_c->approve_quantity != ''? $line_c->approve_quantity: $line_c->order_quantity) - $line_c->order_quantity;
                            @endphp
                            {{ $adjust >= 0? number_format($adjust, 2): '('.number_format(abs($adjust), 2).')' }}
                        </td>
                        <td class="text-right">{{ number_format($line_c->order_quantity,2) }}</td>
                        <td class="text-right">
                            {{ (($line_c->approve_quantity != '') ? 
                                number_format($line_c->approve_quantity,2) : 
                                number_format($line_c->order_quantity,2)) }}
                        </td>
                        <td class="text-right">{{ number_format($line_c->received_quota,2) }}</td>
                        <td class="text-right"></td>
                        <td class="text-right" colspan="2">{{ number_format($line_c->amount,2) }}</td>
                        <td style="padding-left: 10px;">บาท</td>
                    </tr>
                @endforeach
                @if($customer->customer_id != 1)
                <tr class="list tr-hi" style="color:black; font-weight:bold">
                    <td class="text-right" colspan="4"></td>
                    <td class="text-center">รวม</td>
                    <td class="text-center"></td>
                    <td class="text-right">
                        {{ number_format($sumOrderGroupBy,2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($sumOrderApproveGroupBy,2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($sumReceivedQuotaGroupBy,2) }}
                    </td>
                    <td class="text-right"></td>
                    <td class="text-left">รวมเงินสินเชื่อ {{ $key }}</td>
                    <td class="text-right">{{ number_format(0,2) }}</td>
                    <td style="padding-left: 10px;">บาท</td>
                </tr>
                @endif
            @endforeach
            <tr class="list tr-hi">
                <td class="text-right" colspan="4"></td>
                <td class="text-center" 
                    style="color:black; font-weight:bold">
                    รวมทั้งหมด
                </td>
                <td class="text-center"></td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->total_order,2) }}
                </td>
                <td class="text-right" style="color:black; font-weight:bold">
                    {{  (($cash_group->total_approve != '') ? 
                        number_format($cash_group->total_approve,2) : 
                        number_format($cash_group->total_order,2))      }}
                </td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->received_quota,2) }}
                </td>
                <td class="text-right"></td>
                <td class="text-left" 
                    style="color:black; font-weight:bold;">
                    รวมเงินสด
                </td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->totoal_by_group,2) }}
                </td>
                <td style="color:black; font-weight:bold; padding-left: 10px;">บาท</td>
            </tr>
        @else
            <tr class="list tr-hi">
                <td class="text-right" colspan="4"></td>
                <td class="text-center" 
                    style="color:black; font-weight:bold">
                    รวมทั้งหมด
                </td>
                <td class="text-center"></td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->total_order,2) }}
                </td>
                <td class="text-right" style="color:black; font-weight:bold">
                    {{  (($cash_group->total_approve != '') ? 
                        number_format($cash_group->total_approve,2) : 
                        number_format($cash_group->total_order,2))      }}
                </td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->received_quota,2) }}
                </td>
                <td class="text-right"></td>
                <td class="text-left" 
                    style="color:black; font-weight:bold;">
                    รวมเงินสด
                </td>
                <td class="text-right" 
                    style="color:black; font-weight:bold">
                    {{ number_format($cash_group->totoal_by_group,2) }}
                </td>
                <td style="color:black; font-weight:bold; padding-left: 10px;">บาท</td>
            </tr>
        @endif
    </table>

    <table class="no-border" style="margin-top: 12px;width:100%;">
        <tr class="list tr-hi">
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
            <td class="text-center" style="width: 45px;" ></td>
        </tr>

        <tr class="tr-hi">
            <td class="text-left"></td>
            <td class="text-right">ผู้บันทึก
            </td>
            <td class="text-center bb" style="height: 24px;width:100px;">{{optional($userPrint)->name}}</td>
            <td class="text-right">กลุ่ม 2</td>
            <td class="text-left" style="padding-left: 32px;">ครบกำหนดชำระ</td>
            <td class="text-right">
                @if($orderHeader->product_type_code != '20')
                {{ number_format($debt_due_date_amount[2],2) }}
                @else 
                0.00
                @endif
            </td>
            <td class="text-right">บาท</td>
            <td class="text-right"></td>
            <td class="text-left">รวมเงินสด</td>
            <td class="text-right">{{ number_format($orderHeader->cash_amount,2) }}</td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>

        <tr class="tr-hi">
            <td class="text-center"></td>
            <td class="text-left"></td>
            <td class="text-center"></td>
            <td class="text-right">กลุ่ม 3</td>
            <td class="text-left" style="padding-left: 32px;">ครบกำหนดชำระ</td>
            <td class="text-right">
                @if($orderHeader->product_type_code != '20')
                {{ number_format($debt_due_date_amount[3],2) }}
                @else 
                0.00
                @endif
            </td>
            <td class="text-right">บาท</td>
            <td class="text-right"></td>
            <td class="text-left">รวมเงินสินเชื่อ</td>
            <td class="text-right">
                {{ number_format($orderHeader->credit_amount,2) }}
            </td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>

        <tr class="tr-hi">
            <td class="text-right" colspan="4"></td>
            <td class="text-left" style="padding-left: 32px;">เงินโอน</td>
            <td class="text-right">
                @if($orderHeader->product_type_code != '20')
                @if($customer->customer_type_id == 10)
                    {{ number_format((($debt_due_date_amount[2] ? $debt_due_date_amount[2] : 0) + ($debt_due_date_amount[3] ? $debt_due_date_amount[3] : 0) + $cash_group->totoal_by_group),2) }}
                @else
                    {{ number_format($debt_due_date_amount[2] + $debt_due_date_amount[3] + $orderHeader->cash_amount,2) }}
                @endif
                @else 
                {{ number_format( $orderHeader->cash_amount,2) }}
                @endif
            </td>
            <td class="text-right">บาท</td>
            <td class="text-right"></td>
            <td class="text-left">รวมเงินทั้งหมด</td>
            <td class="text-right">
                @if($customer->customer_type_id == 30)
                {{ number_format($orderHeader->cash_amount + $orderHeader->credit_amount,2) }}
                @else
                {{ number_format($orderHeader->grand_total,2) }}
                @endif
            </td>
            <td style="padding-left: 10px;">บาท</td>
        </tr>

        <tr class="tr-hi">
            <td class="text-right" colspan="4"></td>
            <td class="text-left" style="padding-left: 32px;">เงินคงเหลือ</td>
            <td class="text-right">{{ number_format($orderHeader->remaining_amount,2) }}</td>
            <td class="text-right">บาท</td>
            <td class="text-right" colspan="4"></td>
        </tr>

        <tr class="tr-hi">
            <td class="text-right" colspan="3">ผู้ตรวจทาน</td>
            <td class="text-left bb" style="height: 24px;width:130px;"></td>
            <td class="text-right" valign="bottom" style="padding-left: 32px;">หัวหน้ากอง/อนุมัติ</td>
            <td class="text-right bb" style="height: 24px;" colspan="2"></td>
            <td class="text-right" colspan="4"></td>
        </tr>

        <tr class="tr-hi">
            <td class="text-right" colspan="4"></td>
            <td class="text-right" valign="bottom" style="padding-left: 32px;">ผู้อำนวยการฝ่าย</td>
            <td class="text-right bb" style="height: 28px;" colspan="2"></td>
            <td class="text-right" colspan="4"></td>
        </tr>
    </table>
    @if ($customerTypeDomestic->customer_type != 10  || $orderHeader->attribute8 == '1')
        @if ($orderHeader->remark)
            <div style="margin-top: 20px; padding-left: 20px;">
                หมายเหตุรายการ:  {{ $orderHeader->remark }}
            </div>
        @endif
    @endif
</body>
</html>
