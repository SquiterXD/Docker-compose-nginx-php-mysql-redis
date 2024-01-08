<html>
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		.header{
			text-align: center;
			color:#4f889f;
			text-align: center;
		}
		.col1,.col6,.col7{
			width: 10%;
			float: left;
			text-align: center;
			font-weight: bold;
		}
		.col2,.col5{
			width: 20%;
			float: left;
			text-align: center;
			font-weight: bold;
			
		}
		.col3,.col4{
			width: 15%;
			float: left;
			text-align: center;
			font-weight: bold;
		
		}

		.Datacol1,.Datacol6,.Datacol7{
			width: 10%;
			float: left;
			text-align: center;
			
		}
		.Datacol2{
			width: 20%;
			float: left;
			text-align: center;
		}
		.Datacol5{
			width: 20%;
			float: left;
			
		}

		.Datacol3,.Datacol4{
			width: 15%;
			float: left;
			text-align: center;
			
		}
		.page-break {
	        page-break-after: always;
	    }
	    table {
		  width: 100%;
		  margin: 0px;
		  padding: 0px
		}
		.border-stype-th {
			border-top: 1px solid #000;
			border-bottom:  1px solid #000;
		}
		.border-stype-td{
			border-top: 1px solid #000;

		}
	</style>
	@include('pd.reports.PDR0002._style')
</head>
<body>
<?php $pageNo = 0 ?>

@foreach ($simuAdd as $key =>  $Simus)

<?php $pageNo++ ?>


<table>
<tr>
	<td style="font-weight: bold;">โปรแกรม : PDP0002</td>
	<td style="text-align: center; font-weight: bold;">การยาสูบแห่งประเทศไทย</td>
	<td style="text-align: right; font-weight: bold;">{{$ldate}}</td>
</tr>
<tr>
	<td style="font-weight: bold;">สั่งพิมพ์ : {{ Auth::user()->name }} </td>
	<td style="text-align: center; font-weight: bold;" >รายงานตรวจสอบสารหอม (Flavor No.)</td>
	<td style="text-align: right; font-weight: bold;">{{$time}}</td>
</tr>
<tr>
	<td> </td>
	<td style="text-align: center; font-weight: bold;">Flavor no. {{ $Simus->first()->simu_formula_no }} </td>
	<td style="text-align: right; font-weight: bold;">หน้า : {{ $pageNo }} </td>
</tr>
</table>



<table>
	<thead>
		<tr>
			<th class="border-stype-th" width="7%">Flavor No.</th>
			<th class="border-stype-th" width="25%">รายละเอียด</th>
			<th class="border-stype-th" width="25%">หมายเหตุ</th>
			<th class="border-stype-th">รหัสวัตถุดิบ</th>
			<th class="border-stype-th">รายละเอียด</th>
			<th class="border-stype-th">ปริมาณ</th>
			<th class="border-stype-th">หน่วย</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($Simus as   $Simu)
			<tr>
				<td align="center">
					@if($loop->first) 
	 					{{ $Simu->simu_formula_no }}
	 				@endif
				</td>
				<td>
					@if($loop->first) 
	 					{{ $Simu->description_h }}
	 				@endif
				</td>
				<td>
					@if($loop->first) 
	 					{{ $Simu->remark_formula }}
	 				@endif
				</td>
				<td align="center"><p>{{ $Simu->raw_material_num }}</p></td>
				<td><p>{{ $Simu->description_l }}</p></td>
				<td align="right"><p>{{ $Simu->actual_qty }}</p></td>
				<td  align="center"><p>{{ $Simu->actual_uom }}</p></td>
			</tr>
			@if ($loop->last)	
				<tr>
					<td colspan="5"  align="center"><b> รวม </b></td>
					<td align="right">
						<b> {{ $Simus->first()->sum_qty }} </b>
					</td>
					<td></td>
				</tr>
			@endif
		@endforeach
	</tbody>
</table>
{{-- <div class="info">
	<hr width="100%">
 	<div class="Col1">
 		<p >Flavor No.</p>
 	</div>
 	<div class="Col2">
 		<p >รายละเอียด</p>
 	</div>
 	<div class="Col3">
 		<p >หมายเหตุ</p>
 	</div>
 	<div class="Col4">
 		<p >รหัสวัตถุดิบ</p>
 	</div>
 	<div class="Col5">
 		<p >รายละเอียด</p>
 	</div>
 	<div class="Col6">
 		<p >ปริมาณ</p>
 	</div>
 	<div class="Col7">
 		<p >หน่วย</p>
 	</div>
 	<hr width="100%">
 
</div> --}}
 		{{-- @foreach ($Simus as   $Simu)
 		<div class="data">
		 	<div class="dataCol1">
	 			<p> 
	 				@if($loop->first) 
	 					{{ $Simu->simu_formula_no }}
	 				@endif
	 			</p>
		 	</div>
		 	<div class="dataCol2">
		 		<p> 
	 				@if($loop->first) 
	 					{{ $Simu->description_h }}
	 				@endif
	 			</p>
			</div>
		 	<div class="dataCol3">
		 		<p> 
	 				@if($loop->first) 
	 					{{ $Simu->remark_formula }}
	 				@endif
	 			</p>
		 	</div>
		 	<div class="dataCol4">
		 		<p>{{ $Simu->raw_material_num }}</p>
		 	</div>
		 	<div class="dataCol5">
		 		<p>{{ $Simu->description_l }}</p>
		 		
		 	</div>
		 	<div class="dataCol6">
		 		<p>{{ $Simu->actual_qty }}</p>
		 		@if($loop->last) 
	 				<b>รวม 		{{ $Simus->first()->sum_qty }} </b>
	 		    @endif
		 	</div>
		 	<div class="dataCol7">
		 		<p>{{ $Simu->actual_uom }}</p>
		 	</div>
		 	
		 
		</div>
		 			
 		@endforeach --}}

<table>
	@foreach ($mixProceses->where('simu_formula_id', $key) as   $mixProcese)
	
		<tr>
			<td style="text-align: left;width: 10%;">
				@if($loop->first) 
	 			วิธีผสม
	 			@endif
			</td>
            <td style="text-align: left;width: 90%;">{{$mixProcese->mix_no}} {{$mixProcese->mix_desc}}</td>
        </tr>
    
    @endforeach

	@foreach ($instructions->where('simu_formula_id', $key) as   $instruction)
	
		<tr>
			<td style="text-align: left;width: 10%;">
				@if($loop->first) 
	 			วิธีใช้
	 			@endif
			</td>
            <td style="text-align: left;width: 90%;">{{$instruction->instruction_no}} {{$instruction->instruction_desc}}</td>
        </tr>
    
    @endforeach
</table>

    
	

<div class="page-break"></div>
@endforeach
<hr width="100%">

</body>
</html>




