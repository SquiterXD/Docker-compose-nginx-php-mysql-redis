<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">

    <title>ใบเสร็จรับเงิน - Export </title>

    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ public_path('css/printomp0067.css') }}">

</head>

<body style="padding-left: 2%; padding-right:2%; padding-top:2%;padding-bottom:2%;">
    <div>
        <div>
            <div>
                <div class="report-content">
                    <div class="report-header d-flex">
                        <table border="0" width="100%">
                            <tr>
                                <td width="10%" style="vertical-align: text-top; padding-top:20px;">
                                    <div class="logo p-0">
                                        <img class="w-100" src="{{ public_path('img/logo-black.png') }}" alt="">
                                    </div>
                                </td>
                                <td width="60%">
                                    <h3 class="mb-2">การยาสูบแห่งประเทศไทย</h3>
                                    <h3 class="mb-2">TOBACCO AUTHORITY OF THAILAND (HEAD OFFICE)</h3>

                                    <h6 class="p">184 ถนนพระราม 4 เขต คลองเตย กรุงเทพ 10110</h6>
                                    <h6 class="p">184 RAMA IV ROAD, KHLONG TOEI, BANGKOK 10110 THAILAND</h6>
                                </td>
                                <td width="30%">
                                    <div class="ml-auto">
                                        <div class="report-stamp">
                                            <h5 style="font-weight: 600;">ใบเสร็จรับเงิน</h5>
                                            <h5 class="mb-0" style="font-weight: 600;">OFFICIAL RECIEPT</h5>
                                        </div>
            
                                        <table class="mt-3 mb-3">
                                            <tr>
                                                <td class="pr-2 text-right">เลขประจำตัวผู้เสียภาษี :</td>
                                                <td>{{ $data_2['tax_id']->tax_register_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-2 text-right">TAX ID NO. :</td>
                                                <td>{{ $data_2['tax_id']->tax_register_number }}</td>
                                            </tr>
                                        </table>
            
                                        <div class="report-stamp">
                                            <h5 class="mb-0" style="font-weight: 600;">สำหรับกองบัญชีรายได้และภาษี</h5>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--report-header-->

                    <table class="table-report-foreign f12 no-border mt-3">
                        <tr>
                            <td style="width: 16%"><strong>เลขที่ :<br>No.</strong></td>
                            <td>{{ $data_2['prints']->payment_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>วันที่ :<br>Date</strong></td>
                            <td>{{ strtoupper(\Carbon\Carbon::parse($data_2['prints']->payment_date)->format('F d,Y')) }}</td>
                        </tr>
                        <tr>
                            <td><strong>ชื่อลูกค้า :<br>Customer Name</strong></td>
                            <td>{{ $data_2['prints']->customer_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>ที่อยู่ :<br>Address</strong></td>
                            <td>{{ $data_2['prints']->address_line1 }} {{ $data_2['prints']->address_line2 }} {{ $data_2['prints']->address_line3 }} {{ $data_2['prints']->state }} {{ $data_2['prints']->city }} {{ $data_2['prints']->postal_code }}, <br>{{ $data_2['prints']->country_name }}</td>
                        </tr>
                    </table>
                    <?php
                    $sum = 0;
                    ?>

                    <table class="table-report-foreign has-border f12 mt-3" style="vertical-align: text-top;">
                        <tr class="has-bg">
                            <th class="text-center">รายการสินค้าหรือบริการ<br>Description</th>
                            <th class="text-center">จำนวนเงิน<br>Amount</th>
                        </tr>
                        @foreach($data_2['details'] as $detail)
                        <tr>
                            <td>{{ printDetailsOMP0067($detail) }}</td>
                            <td class="text-right">{{ number_format($detail->payment_amount,2) }}</td>
                        </tr>
                        <?php $sum += $detail->payment_amount; ?>
                        @endforeach
                    </table>

                    <div class="row mt-3">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ตัวอักษร :<br>Alphabet</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ strtoupper(convert_number($sum)) }}</td>
                                    <td style="width: 15%; padding-top: 2%;">จำนวนเงินรวม :<br>Amount Total</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">{{ number_format($sum,2) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">ได้รับชำระเป็น :<br>Date</td>
                                    {{-- <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_2['payments']->meaning ?? '' }} เลขที่ {{ $data_2['payments']->payment_no ?? '' }} {{ $data_2['payments']->bank_desc ?? '' }}</td> --}}
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_2['payments']->meaning ?? '' }} {{ $data_2['payments']->bank_desc ?? '' }}</td>
                                    <td style="width: 15%; padding-top: 2%;">ภาษีมูลค่าเพิ่ม {{ printVatOMP0067($data_2['details0']) }}% :<br>Amount Vat</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">{{ printAmountVatOMP0067($data_2['details0']) }}</td>
                                </tr>

                                <tr>
                                    <td style="width: 15%; padding-top: 2%;">หมายเหตุ :<br>Comment</td>
                                    <td style="width: 50%;vertical-align: text-top; padding-top: 2%;">{{ $data_2['prints']->remark }}</td>
                                    <td style="width: 15%; padding-top: 2%;">มูลค่าสินค้าและบริการ :<br>Amount Line</td>
                                    <td class="text-right" style="width: 20%;vertical-align: text-top; padding-top: 2%;">{{ number_format($sum,2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->

                    <div class="row mt-3">
                        <div class="col-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์เมื่อมีลายเซ็นของผู้รับมอบอำนาจ<br>
                                        ในกรณีที่มีการชำระด้วยเช็ค<br>
                                    </td>
                                    <td style="width: 15%">สกุลเงิน :<br>Rate</td>
                                    <td class="text-right" style="width: 20%;padding-top: 2%;vertical-align: text-top;">{{ strtoupper($data_2['prints']->currency) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ก็ต่อเมื่อการยาสูบได้รับเงินตามเช็คจากธนาคารเรียบร้อยแล้ว
                                    </td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 20%;padding-top: 2%;vertical-align: text-top;"></td>
                                </tr>
                            </table>
                        </div>
                        <!--col-->

                        <div class="col-12">
                            <table border="0" width="100%" style="vertical-align: text-top;">
                                <tr>
                                    <td style="width: 65%;padding-top: 2%;vertical-align: text-top;">
                                        THE COMPLETED RECEIPT MUST HAVE AUTHORIZED SIGNATURE IN CASE RECEIVED
                                    </td>
                                    <td style="width: 35%;padding-top: 2%;vertical-align: text-top;">
                                        <div class="signature-row">
                                            <span class="text-label">ผู้รับมอบอำนาจ</span>
                                            <span>......................................................................................................................</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--row-->
                </div>
                <!--border-->
            </div>
            <!--subpage-->
        </div>
        <!--page-a4-->
</body>

</html>