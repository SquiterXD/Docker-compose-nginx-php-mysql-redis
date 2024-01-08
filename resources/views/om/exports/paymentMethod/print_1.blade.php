<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">

    <title>ใบเสร็จรับเงิน - Export </title>

    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ public_path('css/printomp0067.css') }}">

</head>

<style>
    body {
        text-transform: uppercase !important;
    }
</style>

<body>
                <div class="report-content" style="padding-left: 2%; padding-right:2%; padding-top:2%;padding-bottom:2%;">
                    <div class="report-header d-flex">
                        <table border="0" width="100%">
                            <tr>
                                <td width="10%" style="vertical-align: text-top; padding-top:20px;">
                                    <div class="logo p-0">
                                        <img class="w-100" src="{{ public_path('img/logo-black.png') }}" alt="">
                                    </div>
                                </td>
                                <td width="60%">
                                    <h3 class="mb-2">{{ $data_1['toatAddress']->company_name_thai }} ({{ $data_1['toatAddress']->branch_no }})</h3>
                                    <h3 class="mb-2">{{ $data_1['toatAddress']->company_name_eng }}</h3>

                                    <h6 class="p">{{ $data_1['toatAddress']->address }}</h6>
                                    <h6 class="p">{{ $data_1['toatAddress']->address1_eng }} {{ $data_1['toatAddress']->address2_eng }}</h6>
                                </td>
                                <td width="30%">
                                    <div class="ml-auto">
                                        <div class="report-stamp">
                                            <h5 style="font-weight: 600;">ใบเสร็จรับเงิน 
                                                @if(!empty($data_1['details0']))
                                                @if(printVatOMP0067($data_1['details0']) != '0' && $data_1['details0']->payment_type_code == 10)/ ใบกำกับภาษี @endif
                                                @endif
                                            </h5>
                                            <h5 class="mb-0" style="font-weight: 600;">OFFICIAL RECIEPT 
                                                @if(!empty($data_1['details0']))
                                                @if(printVatOMP0067($data_1['details0']) != '0' && $data_1['details0']->payment_type_code == 10)/ TAX INVOICE @endif
                                                @endif
                                            </h5>
                                        </div>

                                        <table class="mt-3 mb-3">
                                            <tr>
                                                <td class="pr-2 text-right">เลขประจำตัวผู้เสียภาษี :</td>
                                                <td>{{ $data_1['tax'] == null ? '' : $data_1['tax']->tax_payer_id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-2 text-right">TAX ID NO. :</td>
                                                {{-- <td>{{ $data_1['tax_id']->tax_register_number }}</td> --}}
                                                <td></td>
                                            </tr>
                                        </table>

                                        {{-- <div class="report-stamp">
                                            <h5 class="mb-0" style="font-weight: 600;">สำหรับกองบัญชีรายได้และภาษี</h5>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--report-header-->

                    <table class="table-report-foreign f12 no-border">
                        <tr>
                            <td style="width: 16%"><strong>เลขที่ :<br>No.</strong></td>
                            <td>{{ $data_1['prints']->payment_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>วันที่ :<br>Date</strong></td>
                            <td>{{ strtoupper(\Carbon\Carbon::parse($data_1['prints']->payment_date)->format('F d,Y')) }}</td>
                        </tr>
                        <tr>
                            <td><strong>ชื่อลูกค้า :<br>Customer Name</strong></td>
                            <td>{{ $data_1['prints']->customer_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>ที่อยู่ :<br>Address</strong></td>
                            <td>{{ !empty($data_1['prints']->address_line1) ? $data_1['prints']->address_line1.', ' : '' }} {{ !empty($data_1['prints']->address_line2) ? $data_1['prints']->address_line2.', ' : '' }} {{ !empty($data_1['prints']->address_line3) ? $data_1['prints']->address_line3.', ' : '' }} {{ !empty($data_1['prints']->state) ? $data_1['prints']->state.', ' : '' }} {{ !empty($data_1['prints']->district) ? $data_1['prints']->district.', ' : '' }} {{ !empty($data_1['prints']->city) ? $data_1['prints']->city.', ' : '' }} {{ !empty($data_1['prints']->province_name) ? $data_1['prints']->province_name.', ' : '' }} {{ !empty($data_1['prints']->postal_code) ? $data_1['prints']->postal_code.', ' : '' }} <br>{{ $data_1['prints']->country_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>เลขประจำตัวผู้เสียภาษี :<br>TAX ID</strong></td>
                            <td>{{ $data_1['tax_id']->tax_register_number }}</td>
                        </tr>
                    </table>
                    <?php
                    $sum = 0;
                    ?>

                    <table class="table-report-foreign has-border f12" style="vertical-align: text-top;">
                        <tr class="has-bg">
                            <th class="text-center">รายการสินค้าหรือบริการ<br>Description</th>
                            <th class="text-center">จำนวนเงิน<br>Amount</th>
                        </tr>
                        @forelse($data_1['details'] as $detail)
                        <tr>
                            {{-- <td>{{ printDetailsOMP0067($detail) }}</td> --}}
                            <td>{{ $detail->remarkDes }}</td>
                            <td class="text-right">{{  number_format($conver_amount->where('prepare_order_number', $detail->prepare_order_number)->first()->conversion_amount, 2) }}</td>
                            {{-- <td class="text-right">{{ number_format($detail->payment_amount * $data_1['payments'][0]->conversion_rate,2) }}</td> --}}
                        </tr>
                        <?php /*$sum += $detail->payment_amount * $data_1['payments'][0]->conversion_rate;*/ ?>
                        <?php $sum += $conver_amount->where('prepare_order_number', $detail->prepare_order_number)->first()->conversion_amount; ?>
                        @empty
                        <tr>
                            <td>ADVANCE PAYMENT</td>
                            <td class="text-right">{{ number_format(collect($data_1['payments'])->sum('payment_amount')* collect($data_1['payments'])->first()->conversion_rate,2) }}</td>
                        </tr>
                        @endforelse
                    </table>

                    <div class="row">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ตัวอักษร :<br>Alphabet</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ strtoupper($data_1['sumText']) }}</td>
                                    <td style="width: 15%; padding-top: 2%;">จำนวนเงินรวม :<br>Amount Total</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($sum))
                                        {{ number_format($sum,2) }}
                                        @else
                                        {{ number_format(collect($data_1['payments'])->sum('payment_amount')* collect($data_1['payments'])->first()->conversion_rate,2) }}
                                        @endif
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ได้รับชำระเป็น :<br>Date</td>
                                    {{-- <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_1['payments'][0]->meaning ?? '' }} เลขที่ {{ $data_1['payments'][0]->payment_no ?? '' }} {{ $data_1['payments'][0]->bank_desc ?? '' }}</td> --}}
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">@foreach($data_1['payments'] as $payment) {{ $payment->meaning ?? '' }} {{ $payment->bank_desc ?? '' }} <br/> @endforeach</td>
                                    <td style="width: 15%; padding-top: 2%;">ภาษีมูลค่าเพิ่ม 
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? '' : printVatOMP0067($data_1['details0']) }}@if(printVatOMP0067($data_1['details0']) != '0')%@endif
                                        @endif 
                                        :<br>Amount Vat</td>
                                    {{-- <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">{{ printAmountVatOMP0067($data_1['details0']) }}</td> --}}
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? '0.00' : number_format($sum - ($sum * (100/(100 + printVatOMP0067($data_1['details0'])) )), 2) }}
                                        @endif 
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>

                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">หมายเหตุ :<br>Comment</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">
                                        {{ $data_1['prints']->remark }}
                                        @if(Str::lower($data_1['prints']->payment_status) == Str::lower("CANCEL"))
                                        ยกเลิกใบเสร็จรับเงิน
                                        @endif
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">มูลค่าสินค้าและบริการ :<br>Amount Line</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? number_format($sum,2) : number_format($sum * (100/(100 + printVatOMP0067($data_1['details0']))),2) }}
                                        @else 
                                        {{ number_format(collect($data_1['payments'])->sum('payment_amount')* collect($data_1['payments'])->first()->conversion_rate,2) }}
                                        @endif 
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>
                            </table>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->

                    <div class="row">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์เมื่อมีลายเซ็นของผู้รับมอบอำนาจ<br>
                                        ในกรณีที่มีการชำระด้วยเช็ค<br>
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ก็ต่อเมื่อการยาสูบได้รับเงินตามเช็คจากธนาคารเรียบร้อยแล้ว <br>
                                    </td>
                                    <td style="width: 15%"></td>
                                    <td class="text-right" style="width: 20%;padding-top: 2%;vertical-align: text-top;"></td>
                                </tr>
                                {{-- <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ก็ต่อเมื่อการยาสูบได้รับเงินตามเช็คจากธนาคารเรียบร้อยแล้ว
                                    </td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 20%;padding-top: 2%;vertical-align: text-top;"></td>
                                </tr> --}}
                            </table>
                        </div>
                        <!--col-->

                        <div class="col-12">
                            <table border="0" width="100%" style="vertical-align: text-top;">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        THE COMPLETED RECEIPT MUST HAVE AUTHORIZED SIGNATURE IN CASE RECEIVED <br>
                                        BY CHEQUE, THIS RECEIPT IS VALID ONLY WHEN CHEQUE IS CLEARED WITH THE BANK
                                    </td>
                                    <td style="width: 35%;padding-top: 2%;vertical-align: text-top;">
                                        <div class="signature-row">
                                            <span class="text-label">ผู้รับมอบอำนาจ _______________________________________</span>
                                            <span class="text-label">Approve by  ____________/____________/_____________</span>
                                            {{-- <span>......................................................................................................................</span> --}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--row-->
                </div>

                <div style='page-break-after: always;'></div>


                <div class="report-content" style="padding-left: 2%; padding-right:2%; padding-top:2%;padding-bottom:2%;">
                    <div class="report-header d-flex">
                        <table border="0" width="100%">
                            <tr>
                                <td width="10%" style="vertical-align: text-top; padding-top:20px;">
                                    <div class="logo p-0">
                                        <img class="w-100" src="{{ public_path('img/logo-black.png') }}" alt="">
                                    </div>
                                </td>
                                <td width="60%">
                                    <h3 class="mb-2">{{ $data_1['toatAddress']->company_name_thai }} ({{ $data_1['toatAddress']->branch_no }})</h3>
                                    <h3 class="mb-2">{{ $data_1['toatAddress']->company_name_eng }}</h3>

                                    <h6 class="p">{{ $data_1['toatAddress']->address }}</h6>
                                    <h6 class="p">{{ $data_1['toatAddress']->address1_eng }} {{ $data_1['toatAddress']->address2_eng }}</h6>
                                </td>
                                <td width="30%">
                                    <div class="ml-auto">
                                        <div class="report-stamp">
                                            <h5 style="font-weight: 600;">ใบเสร็จรับเงิน 
                                                @if(!empty($data_1['details0']))
                                                @if(printVatOMP0067($data_1['details0']) != '0' && $data_1['details0']->payment_type_code == 10)/ ใบกำกับภาษี @endif
                                                @endif 
                                            </h5>
                                            <h5 class="mb-0" style="font-weight: 600;">OFFICIAL RECIEPT 
                                                @if(!empty($data_1['details0']))
                                                @if(printVatOMP0067($data_1['details0']) != '0' && $data_1['details0']->payment_type_code == 10)/ TAX INVOICE @endif
                                                @endif 
                                            </h5>
                                            <h5 style="font-weight: 600;">สำเนา</h5>
                                            <h5 class="mb-0" style="font-weight: 600;">COPY</h5>
                                        </div>

                                        <table class="mt-3 mb-3">
                                            <tr>
                                                <td class="pr-2 text-right">เลขประจำตัวผู้เสียภาษี :</td>
                                                <td>{{ $data_1['tax'] == null ? '' : $data_1['tax']->tax_payer_id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-2 text-right">TAX ID NO. :</td>
                                                {{-- <td>{{ $data_1['tax_id']->tax_register_number }}</td> --}}
                                                <td></td>
                                            </tr>
                                        </table>

                                        {{-- <div class="report-stamp">
                                            <h5 class="mb-0" style="font-weight: 600;">สำหรับกองบัญชีรายได้และภาษี</h5>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--report-header-->

                    <table class="table-report-foreign f12 no-border">
                        <tr>
                            <td style="width: 16%"><strong>เลขที่ :<br>No.</strong></td>
                            <td>{{ $data_1['prints']->payment_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>วันที่ :<br>Date</strong></td>
                            <td>{{ strtoupper(\Carbon\Carbon::parse($data_1['prints']->payment_date)->format('F d,Y')) }}</td>
                        </tr>
                        <tr>
                            <td><strong>ชื่อลูกค้า :<br>Customer Name</strong></td>
                            <td>{{ $data_1['prints']->customer_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>ที่อยู่ :<br>Address</strong></td>
                            <td>{{ !empty($data_1['prints']->address_line1) ? $data_1['prints']->address_line1.', ' : '' }} {{ !empty($data_1['prints']->address_line2) ? $data_1['prints']->address_line2.', ' : '' }} {{ !empty($data_1['prints']->address_line3) ? $data_1['prints']->address_line3.', ' : '' }} {{ !empty($data_1['prints']->state) ? $data_1['prints']->state.', ' : '' }} {{ !empty($data_1['prints']->district) ? $data_1['prints']->district.', ' : '' }} {{ !empty($data_1['prints']->city) ? $data_1['prints']->city.', ' : '' }} {{ !empty($data_1['prints']->province_name) ? $data_1['prints']->province_name.', ' : '' }} {{ !empty($data_1['prints']->postal_code) ? $data_1['prints']->postal_code.', ' : '' }} <br>{{ $data_1['prints']->country_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>เลขประจำตัวผู้เสียภาษี :<br>TAX ID</strong></td>
                            <td>{{ $data_1['tax_id']->tax_register_number }}</td>
                        </tr>
                    </table>
                    <?php
                    $sum = 0;
                    ?>

                    <table class="table-report-foreign has-border f12" style="vertical-align: text-top;">
                        <tr class="has-bg">
                            <th class="text-center">รายการสินค้าหรือบริการ<br>Description</th>
                            <th class="text-center">จำนวนเงิน<br>Amount</th>
                        </tr>
                        @forelse($data_1['details'] as $detail)
                        <tr>
                            {{-- <td>{{ printDetailsOMP0067($detail) }}</td> --}}
                            <td>{{ $detail->remarkDes }}</td>
                            <td class="text-right">{{  number_format($conver_amount->where('prepare_order_number', $detail->prepare_order_number)->first()->conversion_amount, 2) }}</td>
                            {{-- <td class="text-right">{{ number_format($detail->payment_amount * $data_1['payments'][0]->conversion_rate,2) }}</td> --}}
                        </tr>
                        <?php $sum += $conver_amount->where('prepare_order_number', $detail->prepare_order_number)->first()->conversion_amount; ?>
                        @empty
                        <tr>
                            <td>ADVANCE PAYMENT</td>
                            <td class="text-right">{{ number_format(collect($data_1['payments'])->sum('payment_amount') * collect($data_1['payments'])->first()->conversion_rate,2) }}</td>
                        </tr>
                        @endforelse
                    </table>

                    <div class="row">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ตัวอักษร :<br>Alphabet</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ strtoupper($data_1['sumText']) }}</td>
                                    <td style="width: 15%; padding-top: 2%;">จำนวนเงินรวม :<br>Amount Total</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($sum))
                                        {{ number_format($sum,2) }}
                                        @else
                                        {{ number_format(collect($data_1['payments'])->sum('payment_amount')* collect($data_1['payments'])->first()->conversion_rate,2) }}
                                        @endif
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ได้รับชำระเป็น :<br>Date</td>
                                    {{-- <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_1['payments'][0]->meaning ?? '' }} เลขที่ {{ $data_1['payments'][0]->payment_no ?? '' }} {{ $data_1['payments'][0]->bank_desc ?? '' }}</td> --}}
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">@foreach($data_1['payments'] as $payment) {{ $payment->meaning ?? '' }} {{ $payment->bank_desc ?? '' }} <br/> @endforeach</td>
                                    <td style="width: 15%; padding-top: 2%;">ภาษีมูลค่าเพิ่ม 
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? '' : printVatOMP0067($data_1['details0']) }}@if(printVatOMP0067($data_1['details0']) != '0')%@endif
                                        @endif
                                        :<br>Amount Vat</td>
                                    {{-- <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">{{ printAmountVatOMP0067($data_1['details0']) }}</td> --}}
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? '0.00' : number_format($sum - ($sum * (100/(100 + printVatOMP0067($data_1['details0'])))), 2) }}</td>
                                        @endif
                                        <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">หมายเหตุ :<br>Comment</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_1['prints']->remark }}
                                    @if(Str::lower($data_1['prints']->payment_status) == Str::lower("CANCEL"))
                                    ยกเลิกใบเสร็จรับเงิน
                                    @endif
                                    </td>
                                    <td style="width: 15%; padding-top: 2%;">มูลค่าสินค้าและบริการ :<br>Amount Line</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">
                                        @if(!empty($data_1['details0']))
                                        {{ printVatOMP0067($data_1['details0']) == '0' ? number_format($sum,2) : number_format($sum * (100/(100 + printVatOMP0067($data_1['details0']))),2) }}
                                        @else 
                                        {{ number_format(collect($data_1['payments'])->sum('payment_amount')* collect($data_1['payments'])->first()->conversion_rate,2) }}
                                        @endif
                                    </td>
                                        <td style="width: 15%; padding-top: 2%;">บาท<br>Baht</td>
                                </tr>
                            </table>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->

                    <div class="row">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์เมื่อมีลายเซ็นของผู้รับมอบอำนาจ<br>
                                        ในกรณีที่มีการชำระด้วยเช็ค<br>
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ก็ต่อเมื่อการยาสูบได้รับเงินตามเช็คจากธนาคารเรียบร้อยแล้ว <br>
                                    </td>
                                    <td style="width: 15%"></td>
                                    <td class="text-right" style="width: 20%;padding-top: 2%;vertical-align: text-top;"></td>
                                </tr>
                                {{-- <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ก็ต่อเมื่อการยาสูบได้รับเงินตามเช็คจากธนาคารเรียบร้อยแล้ว
                                    </td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 20%;padding-top: 2%;vertical-align: text-top;"></td>
                                </tr> --}}
                            </table>
                        </div>
                        <!--col-->

                        <div class="col-12">
                            <table border="0" width="100%" style="vertical-align: text-top;">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        THE COMPLETED RECEIPT MUST HAVE AUTHORIZED SIGNATURE IN CASE RECEIVED<br>
                                        BY CHEQUE, THIS RECEIPT IS VALID ONLY WHEN CHEQUE IS CLEARED WITH THE BANK
                                    </td>
                                    <td style="width: 35%;padding-top: 2%;vertical-align: text-top;">
                                        <div class="signature-row">
                                            <span class="text-label">ผู้รับมอบอำนาจ _______________________________________</span>
                                            <span class="text-label">Approve by  ____________/____________/_____________</span>
                                                                           {{-- <span>......................................................................................................................</span> --}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--row-->
                </div>
</body>

</html>
