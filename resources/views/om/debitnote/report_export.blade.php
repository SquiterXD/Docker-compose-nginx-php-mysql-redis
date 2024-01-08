<!doctype html>
<html lang="th">

<head>
<meta charset="utf-8">

<title>ใบเพิ่มหนี (Debit Note) - ขายต่างประเทศ</title>

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
                    <img class="w-100" src="{!! asset('custom/img/logo-black.png') !!}" alt="">
                </div>
                <div class="info">
                    <h5>{{ $company->company_name_thai }} ({{ $company->branch_no }})</h5>
                    <p>{{ $company->address }}<br>
                    โทร. {{ $company->phone_number }}<br>
                    เลขประจำตัวผู้เสียภาษี {{ $company->tax_payer_id }}</p>
                </div>
            </div>

            <h2 class="report-title">ใบเพิ่มหนี / ใบกำกับภาษี</h2>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <table>
                        <tr>
                            <td width="40px">เลขที่ : </td>
                            <td>{{ $dataInvoice->invoice_headers_number }}</td>
                        </tr>
                        <tr>
                            <td>วันที่ : </td>
                            <td>{{ dateFormatThaiString($dataInvoice->invoice_date) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <table class="table-report-foreign f12 no-border mt-4">
            	<tr>
            		<td style="width: 115px"><strong>ชื่อผู้ซื้อ</strong></td>
            		<td>{{ $customer->customer_name }} <strong class="pl-4">เลขประจำตัวผู้เสียภาษี</strong> <span class="pl-2">{{ $customer->tax_register_number }} สาขา {{ $customer->branch }}</span></td>
            	</tr>
                <tr>
                    <td><strong>ที่อยู่</strong></td>
                    <td>{{ $customer->address_line1 }} {{ $customer->district }} {{ $customer->city }} {{ $customer->province_name }} {{ $customer->postal_code }}</td>
                </tr>
                <tr>
                    <td><strong>อ้างถึง</strong></td>
                    @if($payment)
                        <td>ใบเสร็จรับเงิน เลขที่ {{ $payment['number'] }} ลงวันที่ {{ dateFormatThaiString($payment['date']) }}</td>
                    @else
                        <td>ใบเสร็จรับเงิน เลขที่ - ลงวันที่ -</td>
                    @endif
                </tr>
                <tr>
                    <td><strong>เหตุในการลดหนี้</strong></td>
                    <td>-</td>
                </tr>
            </table>

            <table class="table-report-foreign has-border f12 mt-4">
                <tr class="has-bg">
                    <th class="text-center" style="width: 5px">ลำดับ</th>
                    <th class="text-center" style="width: 30%">รายการ</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">หน่วยนับ</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center" style="width: 100px">จำนวนเงิน</th>
                </tr>
                @foreach($data['line'] as $key => $data_item)
                    @if($key == count($data['line'])-1)
                        @php $style = '' @endphp
                    @else
                        @php $style = 'border-bottom: 1px solid rgba(255, 255, 255, 0);' @endphp
                    @endif
                    <tr>
                        <td style="{{ $style }}" class="text-center">{{ $data_item['number'] }}</td>
                        <td style="{{ $style }}">{{ $data_item['description'] }}</td>
                        <td style="{{ $style }}" class="text-right">{{ $data_item['quantity'] }}</td>
                        <td style="{{ $style }}">{{ $data_item['uom_description'] }}</td>
                        <td style="{{ $style }}" class="text-right">{{ number_format($data_item['price_unit'],2,'.',',') }}</td>
                        <td style="{{ $style }}" class="text-right">{{ number_format($data_item['total'],2,'.',',') }}</td>
                    </tr>
                @endforeach
            </table>

            <table class="table-report-foreign no-border f12 mt-3">
                <tr>
                   <td style="width: 115px"></td>
                   <td>อ้างอิงเลขที่ {{ $dataInvoice->ref_invoice_number }} ลงวันที่ {{ dateFormatThaiString($order->pick_release_approve_date) }}</td>
                   <td style="width: 140px"></td>
                </tr>
                <tr>
                    <td colspan="3" class="pt-2"></td>
                </tr>
                <tr>
                   <td></td>
                   <td>รวมจำนวนเงินค่าสินค้า/บริการ ตามใบกำกับภาษีเดิม</td>
                   <td class="text-right">{{ number_format($data['total'],2,'.',',') }}</td>
                </tr>
                <tr>
                   <td></td>
                   <td>ภาษีมูลค่าเพิ่ม</td>
                   <td class="text-right"><span class="underline">{{ number_format($data['tax'],2,'.',',') }}</span></td>
                </tr>

                <tr>
                   <td></td>
                   <td>รวมมูลค่าสินค้า/บริการ</td>
                   <td class="text-right"><span class="underline">{{ number_format($data['sumary'],2,'.',',') }}</span></td>
                </tr>

                <tr>
                    <td colspan="3" class="pt-1"></td>
                </tr>

                <tr>
                   <td></td>
                   <td class="text-center"><h5>({{ ConverttoThai($data['sumary']) }})</h5></td>
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
