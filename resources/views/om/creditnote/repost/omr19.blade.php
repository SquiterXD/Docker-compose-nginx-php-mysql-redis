<!doctype html>
<html lang="th">

<head>
<meta charset="utf-8">

<title>ใบลดหนี้ (Credit Note) - ขายต่างประเทศ</title>

<link href="https://fonts.googleapis.com/css?family=Sarabun:300,300i,400,400i,700,700i,800,800i&display=swap&subset=thai" rel="stylesheet">
<link href="{!! asset('custom/css-report/bootstrap.min.css') !!}" rel="stylesheet">
<link href="{!! asset('custom/css-report/print.css') !!}" rel="stylesheet">
</head>

<body class="font10">
<div class="page-a4">
    <div class="subpage smallgap">
    	<div class="border">
    		<div class="report-content">
            <div class="report-header">
                <div class="logo pt-0">
                    <img class="w-100" src="{!! asset('custom/css-report/logo-black.png') !!}" alt="">
                </div>
                <div class="info">
                    <h5>การยาสูบแห่งประเทศไทย (สำนักงานใหญ่)</h5>
                    <p>184 ถนนพระราม 4 เขต คลองเตย กรุงเทพ 10110<br>
                    โทร. 02-229-1217<br>
                    เลขประจำตัวผู้เสียภาษี 099-4000-164-769</p>
                </div>
            </div>

            <h2 class="report-title">ใบลดหนี้ / ใบกำกับภาษี</h2>

            <table class="table-report-foreign f12 no-border mt-4">
            	<tr>
            		<td style="width: 115px"><strong>ชื่อผู้ซื้อ</strong></td>
            		<td>{{ $rest['data']->customer_name }} <strong class="pl-4">เลขประจำตัวผู้เสียภาษี</strong> <span class="pl-2">{{ $rest['data']->customer_tax }}</span></td>
            	</tr>
                <tr>
                    <td><strong>ที่อยู่</strong></td>
                    <td>{{ $rest['data']->customer_addr }}</td>
                </tr>
                <tr>
                    <td><strong>อ้างถึง</strong></td>
                    <td>ใบเสร็จรับเงิน เลขที่ {{ $rest['data']->paymentNumber }}  ลงวันที่ {{ $rest['data']->paymentDate }}</td>
                </tr>
                <tr>
                    <td><strong>เหตุในการลดหนี้</strong></td>
                    <td>-</td>
                </tr>
            </table>

            <table class="table-report-foreign has-border f12 mt-4">
                <tr class="has-bg">
                    <th class="text-center" style="width: 115px">ลำดับ</th>
                    <th class="text-center" style="width: 40%">รายการ</th>
                    <th class="text-center">จำนวน(ห่อ)</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center" style="width: 140px">จำนวนเงิน</th>
                </tr>
                @php
                    $i = 1;
                    $height = 165;
                @endphp
                @foreach ($proformaLine as $item_per)
                    @if($proformaLine->count() != $i)
                        @php
                            $height -= 15;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $item_per->item_description }}</td>
                            <td class="text-right">{{ $item_per->approve_quantity }}</td>
                            <td class="text-right">{{ number_format($item_per->unit_price,2,'.',',') }}</td>
                            <td class="text-right">{{ number_format($item_per->amount,2,'.',',') }}</td>
                        </tr>
                    @else
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>{{ $item_per->item_description }}</td>
                        <td class="text-right">{{ $item_per->approve_quantity }}</td>
                        <td class="text-right">{{ number_format($item_per->unit_price,2,'.',',') }}</td>
                        <td class="text-right">{{ number_format($item_per->amount,2,'.',',') }}</td>
                    </tr>
                    @endif
                    @php
                        $i ++;
                    @endphp
                @endforeach
            </table>

            <table class="table-report-foreign no-border f12 mt-3">
                <tr>
                   <td style="width: 115px"></td>
                   <td>อ้างอิงเลขที่  {{ $rest['data']->proforma }} ลงวันที่  {{ $rest['data']->invoice_date }}</td>
                   <td style="width: 140px"></td>
                </tr>
                <tr>
                    <td colspan="3" class="pt-2"></td>
                </tr>
                <tr>
                   <td></td>
                   <td>รวมจำนวนเงินค่าสินค้า/บริการ ตามใบกำกับภาษีเดิม</td>
                   <td class="text-right">{{ number_format($proforma->sub_total,2,'.',',') }}</td>
                </tr>
                <tr>
                   <td></td>
                   <td>ภาษีมูลค่าเพิ่ม</td>
                   <td class="text-right"><span class="underline">{{ number_format($proforma->tax,2,'.',',') }}</span></td>
                </tr>

                <tr>
                    <td></td>
                    <td>รวมมูลค่าสินค้า/บริการ</td>
                    <td class="text-right"><span class="underline">{{ number_format($total_payment,2,'.',',') }}</span></td>
                </tr>

                <tr>
                    <td colspan="3" class="pt-1"></td>
                </tr>

                <tr>
                   <td></td>
                   <td class="text-center"><h5>(แปดหมื่นสามพันหนึ่งร้อยสามสิบเก้าบาทถ้วน)</h5></td>
                   <td class="text-right"></td>
                </tr>
            </table>

            <div class="d-flex mt-5" style="max-width: 50%">
                <div class="col text-center">
                    <div class="signature w-100"></div>
                    <p class="mt-3 mb-0 f12">ผู้มีอำนาจลงนาม</p>
                </div>

                <div class="col text-center">
                    <div class="signature w-100"></div>
                    <p class="mt-3 mb-0 f12">ผู้รับเอกสาร</p>
                </div>
            </div><!--d-flex-->

		</div><!--border-->
    </div><!--subpage-->
</div><!--page-a4-->

<script type="text/javascript">

</script>
</body>
</html>
