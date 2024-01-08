<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TOAT - พิมพ์ขออนุมัติขอเพิ่มเพดานการจำหน่าย</title>
    <link rel="stylesheet" href="{{ public_path('css/reports/addition_quota/print.css') }}">
</head>
<body class="font-thsarabun">
<div class="ibox">
	<div class="header"></div>
	<h4 class="title" style="font-weight: bold;">ใบอนุมัติเพิ่มโควต้า</h4>
	<div class="box-header" style="font-size: 17px;">
		<span>
			@if($addtion->approve_status == 'อนุมัติ') 
				อนุมัติครั้งที่ : {{ $pers }} 
			@else 
				{{ $addtion->approve_status }} 
			@endif
		</span>
		<table style="width: 100%;">
			<tr>
				<td style="width: 50%;"></td>
				<td valign="top">
					<table cellspacing="0" style="padding: 0 0 0 4rem;">
						<tr>
							<td valign="top" style="width: 60px; line-height:1rem;">ชื่อร้าน : </td>
							<td>{{ $datacustomer[0]->customer_name }} ({{ $datacustomer[0]->customer_number }})</td>
						</tr>
						<tr>
							<td valign="top" style="width: 60px; line-height:1rem;">ที่อยู่ : </td>
							<td>{{ $datacustomer[0]->address_line1 ?? '' }} {{ $datacustomer[0]->address_line2 ?? '' }} {{ $datacustomer[0]->address_line3 ?? '' }} {{ $datacustomer[0]->alley ?? '' }} {{ $datacustomer[0]->tambon_thai ?? '' }} {{ $datacustomer[0]->city_thai ?? '' }} {{ $datacustomer[0]->province_thai ?? '' }} {{ $datacustomer[0]->postal_code ?? '' }}</td>
						</tr>
						<tr>
							<td valign="top" style="width: 60px; line-height:1rem;">โทรศัพท์ : </td>
							<td>{{ $datacustomer[0]->contact_phone }}</td>
						</tr>
						<tr>
							<td valign="top" style="width: 60px; line-height:1rem;">วันที่ : </td>
							<td>{{ FormatDate::DateThaiNumericWithSplash($orders[0]->order_date) }}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
			<tr>
				<td>
					<table cellspacing="0">
						<tr>
							<td style="width: 50px; line-height:1rem;">เรื่อง</td>
							<td>ขอเพิ่มเพดานการจำหน่าย</td>
						</tr>
						<tr>
							<td style="width: 50px; line-height:1rem;">เรียน</td>
							<td> ผู้ว่าการ{{-- $total_approve_amount <= 200 ? 'ผู้ว่าการ' : 'ผู้อำนวยการฝ่ายขาย' --}} </td>
						</tr>
						<tr>
							<td style="width: 50px; line-height:1rem;">อ้างถึง</td>
							<td>เพดานการจำหน่ายเดือน {{ FormatDate::Monthonly($orders[0]->delivery_date) }}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<div style="padding: 1rem 1rem 0 4rem; width:65%;"> 
			ด้วยทางร้าน มีความประสงค์ขอเพิ่มเพดานการจำหน่าย ประจำงวด {{ $orders[0]->delivery_date == null ? '' : FormatDate::DateThaiNumericWithSplash($orders[0]->delivery_date) }} 
			<span style="display: block;"> เนื่องจาก </span>
			<span style="display: block;"> {{ $addtion->reason }} </span>
			<span class="font-bold" style="display: block;">มีรายละเอียดดังต่อไปนี้</span> 
		</div>
	</div>

	<div class="box-table" style="font-size: 17px;">
		<span style="text-align: right; display: block;">หน่วย:หีบ</span>
		<table style="width: 100%;" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="br bb">ลำดับ</th>
					<th class="br bb">กลุ่ม</th>
					<th class="br bb">เพดาน</th>
					<th class="br bb">ขอเพิ่มก่อนหน้า<br>ในสัปดาห์</th>
					<th class="br bb">ขอเพิ่มงวดนี้</th>
					<th class="br bb">ยอดซื้อ<br>สัปดาห์นี้</th>
					<th class="br bb">ยอดซื้องวดล่าสุด<br>{{ ($last_datr == '') ? '' : FormatDate::DateThaiNumericWithSplash($last_datr) }}</th>
					<th class="bb">อนุมัติ</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sum1	= 0;
					$sum2	= 0;
					$sum3	= 0;
					$sum4	= 0;
					$sum5	= 0;
				?>
				@foreach($meaning as $key => $mean)
					<tr class="align-middle">
						<td class="text-center">{{ $key +1 }}</td>
						<td> {{ $mean }} </td>
						<td class="text-center">{{ $received_quota[$key]/10 }}</td>
						<td class="text-center">@if($last_approve_quantity[$key] == 0) - @else {{ ceil($last_approve_quantity[$key])  }} @endif</td>
						<td class="text-center">{{ ceil($order_quantity[$key]) }}</td>
						<td class="text-center">{{ getAmountSellThisWeek($headers, $mean) }}</td>
						<td class="text-center">@if($arraylastinfosumorder[$key] == '-') - @else {{ ceil($arraylastinfosumorder[$key]/10) }} @endif</td>
						<td></td>
					</tr>
				<?php
					$sum1 += $received_quota[$key]/10;
					$sum2 += $arraylastinfosumorder[$key] == '-' ? 0 : ceil($arraylastinfosumorder[$key]/10);
					$sum3 += getAmountSellThisWeek($headers, $mean) == '-' ? 0 : ceil(getAmountSellThisWeek($headers, $mean));
					$sum4 += $last_approve_quantity[$key] == '-' ? 0 : ceil($last_approve_quantity[$key]);
					$sum5 += ceil($order_approve[$key]);
				?>
				@endforeach
					<tr class="align-middle text-center">
						<td colspan="2" style="font-weight: bold;">รวม</td>
						<td class="text-left" style="font-weight: bold;">{{ $sum1 }}</td>
						<td class="text-left" style="font-weight: bold;">@if($sum4 == 0) - @else {{ $sum4 }} @endif</td>
						<td class="text-left" style="font-weight: bold;">{{ $sum5 }}</td>
						<td class="text-left" style="font-weight: bold;">@if($sum3 == 0) - @else {{ $sum3 }} @endif</td>
						<td class="text-left" style="font-weight: bold;">@if($sum2 == 0) - @else {{ $sum2 }} @endif</td>
						<td></td>
					</tr>
			</tbody>
		</table>

		<div style="padding: 3rem 3rem 0 1rem;">จึงเรียนมาเพื่อโปรดพิจารณา</div>
		<div class="clearfix"></div>
		<div class="signhere-footer" style="padding-bottom: 20px;">
			<table border="1" class="signhere" style="width: 100%;" cellpadding="0">
				<tr>
					@if (!empty($emp1->employee_name))
						<td width="33%">
							<div> เรียน ผู้ว่าการ </div>
							<div style="padding: 0 0 0 1rem;"> เพื่อโปรดพิจารณา </div>
						</td>
					@else
						<td width="33%"></td>
					@endif
					<td width="33%"></td>
					<td width="33%" class="text-center">
						ขอแสดงความนับถือ
					</td>
				</tr>

				<tr>		
					@if (!empty($emp1->employee_name) && $approvers[0]->status_empolyee_approve1  == 'A')
						@php
							if(!empty($emp1->employee_name)){
								$emp1Arr = explode(" ", $emp1->employee_name);
							}
						@endphp
						<td width="33%" class="text-center" style="font-weight: bold;">
							{{ $emp1Arr[1].' '.$emp1Arr[2] ?? '' }}
						</td>
					@else
						<td width="33%"></td>
					@endif
					<td  width="33%"></td>
					<td width="33%" class="text-center">
						<div style="font-weight: bold;">
							{{ $dataOwner[0]->owner_first_name ?? '' }}  
							{{ $dataOwner[0]->owner_last_name ?? '' }}
						</div>						
					</td>
				</tr>

				<tr>
					@if(!empty($emp1->employee_name))
						@php
							if($datainfoss->acting_position3 != null){
								$arrPosition = explode(" ",omp0015($datainfoss->acting_position3));
							}	
						@endphp
				
						<td width="33%" class="text-center">
							<div>
								({{ $emp1->employee_name ?? '' }})
							</div>
							<div>
								{{ 	
									$emp1->authority_id1_additional != null ? 
									$emp1->authority_id1_additional : 
									$emp1->position_name 
								}}
				
								{{ 
									$datainfoss->acting_position1 != null ? 
									$arrPosition[0] : ''
								}}
							</div>
							<div>
								{{	
									$datainfoss->acting_position1 != null ? 
									$arrPosition[1] : ''
								}}
							</div>
						</td>	
					@else
						<td class="text-center" style="height: 20px; padding:0;" width="33%"></td>
					@endif
					<td width="33%"></td>
					<td width="33%" class="text-center">
						<div> 	 ({{ $dataOwner[0]->prefix ?? '' }} 
								{{ $dataOwner[0]->owner_first_name ?? '' }}  
								{{ $dataOwner[0]->owner_last_name ?? '' }})
						</div>
						<div>ผู้ทรงสิทธิ์</div>
					</td>				
				</tr>

				<tr>
					<td width="33%"></td>
					<td width="33%"></td>
					<td width="33%"></td>
				</tr>

				<tr style="height: 20px;">
					<td width="33%"></td>
					<td width="33%"></td>
					<td width="33%"></td>
				</tr>

				<tr>						
					@if (!empty($emp2->employee_name))
						@php
							if(!empty($emp2->employee_name) && $approvers[0]->status_empolyee_approve2 == 'A'){
								$emp2Arr = explode(" ", $emp2->employee_name);
							}
						@endphp
						<td width="33%" class="text-center" style="font-weight: bold;">
							{{ $emp2Arr[1].' '.$emp2Arr[2] ?? '' }}
						</td>
					@else
						<td width="33%"></td>
					@endif	
					<td width="33%"></td>
					@if (!empty($empsale->employee_name) && $approvers[0]->status_empolyee_approve4 == 'A')
						<td width="33%" class="text-center" style="font-weight: bold;">
							@php
								if(!empty($empsale->employee_name)){
									$empSaleArr = explode(" ", $empsale->employee_name);
								}else {
									$empSaleArr = [];
								}
							@endphp
							{{ $empSaleArr[1].' '.$empSaleArr[2] ?? '' }}
						</td>
					@else
						<td width="33%"></td>
					@endif
					
				</tr>

				<tr>
					@if(!empty($emp2->employee_name))
						@php
							if($datainfoss->acting_position2 != null){
								$arrPosition = explode(" ",omp0015($datainfoss->acting_position2));
							}	
						@endphp
						<td width="33%" class="text-center">
							<div>({{ $emp2->employee_name ?? '' }})</div>
							<div>
								{{ 
									$emp2->authority_id2_additional != null ? 
									$emp2->authority_id2_additional : 
									$emp2->position_name 
								}}
				
								{{
									$datainfoss->acting_position2 != null ? 
									$arrPosition[0] : ''
								}}
							</div>
							<div>
								{{
									$datainfoss->acting_position2 != null ? 
									$arrPosition[1] : ''
								}}
							</div>
						</td>	
					@else
						<td class="text-center" style="height: 20px; padding:0;" width="33%"></td>
					@endif					
					<td width="33%"></td>
					<td width="33%" class="text-center">
						@php
							if($datainfoss->acting_position_sale != null){
								$arrPosition = explode(" ",omp0015($datainfoss->acting_position_sale));
							}	
						@endphp
						<div> 
							({{ $empsale->employee_name ?? '' }}) 
						</div>
						<div> 	
							{{ $empsale ? $empsale->sales_division_additional : $empsale->position_name }} 
							{{ $datainfoss->acting_position_sale != null ? $arrPosition[0] : '' }}
						</div>
						<div>
							{{ 	$datainfoss->acting_position_sale != null ? $arrPosition[1] : '' }}
						</div>
					</td>
				</tr>

				<tr>
					<td width="33%"></td>
					<td width="33%"></td>
					<td width="33%"></td>
				</tr>

				<tr>
					<td width="33%"></td>
					<td width="33%" 
						style="font-weight: bold; text-align: right;">
						{{ 'อนุมัติ' }}
					</td>
					<td width="33%"></td>
				</tr>

				<tr>	
					<td width="33%"></td>
					<td width="33%"></td>		
					@if (!empty($emp3->employee_name) && $approvers[0]->status_empolyee_approve3  == 'A')
						<td width="33%" style="font-weight: bold;" class="text-center">
							@php
								if(!empty($emp3->employee_name)){
									$emp3Arr = explode(" ", $emp3->employee_name);
								}
							@endphp
							{{ $emp3->employee_name ? $emp3Arr[1].' '.$emp3Arr[2] : '' }}
						</td>
					@else
						<td width="33%"></td>
					@endif		
				</tr>

				<tr>
					<td width="33%"></td>
					<td width="33%"></td>
					@if (!empty($emp3->employee_name))
						<td class="text-center" style="height: 20px;padding:0;" width="33%">
							@php
								if($datainfoss->acting_position3 != null){
									$arrPosition = explode(" ",omp0015($datainfoss->acting_position3));
								}
							@endphp
				
							<div>({{ $emp3->employee_name ?? '' }})</div>
							<div>
								{{ 	
									$emp3->authority_id3_additional != null ? 
									$emp3->authority_id3_additional : 
									$emp3->position_name 
								}}
				
								{{
									$datainfoss->acting_position3 != null ? 
									$arrPosition[0] : ''
								}}
							</div>
							<div>
								{{ 
									$datainfoss->acting_position3 != null ? 
									$arrPosition[1] : '' 
								}}
							</div>
						</td>
					@else
						<td class="text-center" style="height: 20px;padding:0;" width="33%"></td>
					@endif						
				</tr>
				
			</table>
		</div>

	</div>

</div>
</body>
</html>
