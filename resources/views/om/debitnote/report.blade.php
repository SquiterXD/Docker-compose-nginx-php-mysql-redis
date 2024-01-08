<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OMR0005</title>
    <link href="{!! asset('custom/css-report/style-omr0005.css') !!}" rel="stylesheet">
</head>
<body class="font-thsarabun">
		<div class="header">
			<table style="width: 100%;">
				<tr>
					<td valign="top" style="width: 100px;"></td>
					<td valign="top" class="company-address">
							<span>{{ $company->company_name_thai }} ({{ $company->branch_no }})</span>
							<span>{{ $company->address }}</span>
							<span>โทร {{ $company->phone_number }}</span>
							<span>{{ $company->tax_payer_id }}</span>
					</td>
					<td valign="top" class="invoice-header">
						<table>
							<tr>
								<td>เลขที่ : </td>
								<td>{{ $dataInvoice->invoice_headers_number }}</td>
							</tr>
							<tr>
								<td>วันที่ : </td>
								<td>{{ dateFormatThaiString($dataInvoice->invoice_date) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>

		<h4 class="title">ใบเพิ่มหนี้/ใบแจ้งยอด</h4>

		<div class="box-header">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td class="font-bold customer-topic" style="width: 80px;line-height:2rem;">ชื่อผู้ซื้อ</td>
								<td class="center font-bold" style="width: 10px;">:</td>
								<td>{{ $customer->customer_name }}</td>
							</tr>
							<tr>
								<td class="font-bold customer-topic" style="line-height:2rem;">ที่อยู่</td>
								<td class="center font-bold" style="width: 5px;">:</td>
								<td>{{ $customer->address_line1 }} {{ $customer->district }} {{ $customer->city }} {{ $customer->province_name }} {{ $customer->postal_code }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<div class="desc-invoice">
				<div class="font-bold customer-topic" style="padding-right: 6px;">อ้างอิงใบกำกับภาษีเลขที่</div>
				<div style="width: 30%;">{{ $dataInvoice->ref_invoice_number }}</div>
				<div class="font-bold customer-topic">ลงวันที่</div>
				<div>{{ dateFormatThaiString($data['header']['approve_date']) }}</div>
			</div>

			<div class="reason">
				<div class="font-bold customer-topic">สาเหตุของการเพิ่มหนี้</div>
				<div class="font-bold">:</div>
				<div>-</div>
			</div>

			<div class="font-bold">การยาสูบแห่งประเทศไทย ได้ทำการ เดบิตบัญชีของท่านตามรายการดังนี้</div>
			
		</div>

		<div class="box-table">
			<table style="width: 100%;" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="br bb header-table" rowspan="2">รายการ</th>
						<th class="br bb header-table" rowspan="2">ปริมาณ<br>พันมวน/ซอง</th>
						<th class="br sub-header-table" colspan="2">{{ $data['header']['header_group'] }}<br>({{ $data['header']['header_group_sub'] }})</th>
						<th class="sub-header-table" colspan="2">ราคาขายปลีก<br>({{ $data['header']['header_sale_sub'] }})</th>
					</tr>
					<tr>
						<th class="br bt bb header-table text-center">ราคาเดิม</th>
						<th class="br bt bb header-table text-center">ราคาใหม่</th>
						<th class="br bt bb header-table text-center">ราคาเดิม</th>
						<th class=" bt bb header-table text-center">ราคาใหม่</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($dataInvoice->document_id))
						@foreach($data['line'] as $item_Line)
							<tr>
								<td class="">{{ $item_Line['description'] }}</td>
								<td class="text-center">{{ $item_Line['approve_total'] }}</td>
								<td class="right">{{ number_format($item_Line['old_price_group'],2,'.',',') }}</td>
								<td class="right">{{ number_format($item_Line['new_price_group'],2,'.',',') }}</td>
								<td class="right">{{ number_format($item_Line['old_price_sale'],2,'.',',') }}</td>
								<td class="right">{{ number_format($item_Line['new_price_sale'],2,'.',',') }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="">-</td>
							<td class="text-center">-</td>
							<td class="right">-</td>
							<td class="right">-</td>
							<td class="right">-</td>
							<td class="right">-</td>
						</tr>
					@endif
					<tr class="footer">
						<td class="br-0 left-topic right" style="width: 200px;">รวมมูลค่าสินค้าตามใบกำกับภาษีเดิม</td>
						<td class="right"><span class="number">1</span></td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['total_old_group'],2,'.',',') }}</td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['total_old_sale'],2,'.',',') }}</td>
					</tr>
					<tr class="footer">
						<td class="br-0 left-topic right" style="width: 200px;">รวมมูลค่าสินค้าตามใบกำกับภาษีใหม่</td>
						<td class="right"><span class="number">2</span></td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['total_new_group'],2,'.',',') }}</td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['total_new_sale'],2,'.',',') }}</td>
					</tr>
					<tr class="footer">
						<td class="br-0 left-topic right" style="width: 200px;">ผลต่าง</td>
						<td class="right"><span class="number">1</span> - <span class="number">2</span> = <span class="number">3</span></td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['diff_group'],2,'.',',') }}</td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['diff_sale'],2,'.',',') }}</td>
					</tr>
					<tr class="footer">
						<td class="br-0 left-topic right" style="width: 200px;">ภาษีมูลค่าเพิ่ม 7%</td>
						<td class="right"><span class="number">4</span></td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['tax_group'],2,'.',',') }}</td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['tax_sale'],2,'.',',') }}</td>
					</tr>

					<tr class="">
						<td class="br-0 left-topic right" style="width: 200px;">มูลค่าสินค้าก่อนหักภาษีมูลค่าเพิ่ม</td>
						<td class="right"><span class="number">3</span> - <span class="number">4</span> = <span class="number">5</span></td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['outvat_tax_group'],2,'.',',') }}</td>
						<td class="right"></td>
						<td class="right">{{ number_format($data['outvat_tax_sale'],2,'.',',') }}</td>
					</tr>
				</tbody>
			</table>


			<div class="signhere">ผู้รับมอบอำนาจ</div>
		</div>


</body>
</html>
