{{-- RECEIPT LINE MAIN INFORMATIONS --}}
@php
	$canEditDFF = in_array(optional(optional(optional($receiptLine)->header)->parent)->status, ['CLEARED', 'APPROVED']);
	$readOnly = $canEditDFF ? '' : 'readonly';
@endphp
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Category</div>
                <div><small>ประเภท</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ $receiptLine->category->name }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Sub-Category</div>
                <div><small>ประเภทย่อย</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ $receiptLine->subCategory->name }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <label for="" class="col-md-2 control-label">
                <div>Description</div>
                <div><small>คำอธิบาย</small></div>
            </label>
            <div class="col-md-10">
                <p>{!! $receiptLine->description ?? '-' !!}</p>
            </div>
        </div>
    </div>
</div>

@if ($receiptType != 'CASH-ADVANCE' && !!($receiptLine->distribution_type))
	@if ($canEditDFF)
		{!! Form::open([
			'route' => ['ie.receipts.lines.update_dff_distribution', $receipt->receipt_id, $receiptLine->receipt_line_id],
			'method' => 'patch',
			'id' => 'form-edit-line-dff-distribution',
			'class' => 'form-horizontal'
		]) !!}
	@endif
	
	<div class="row">
		<div class="col-md-12">
			<button id="btn_open_dff_distribution" type="button" class="btn btn-xs btn-info w-100">
				[ ]
			</button>
		</div>
	</div>
	<div class="d-none" id="div_dff_distribution">
		<div class="row">
			<div class="col-md-12">
				<button id="btn_close_dff_distribution" type="button" class="close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		</div>
		<div class="row m-b-sm">
			<div class="col-md-2">

			</div>
			<div class="col-md-8">
                {!! Form::text('distribution_type', array_key_exists(optional($receiptLine)->distribution_type, $distributionTypeLists) ? $distributionTypeLists[optional($receiptLine)->distribution_type] : optional($receiptLine)->distribution_type, ['class'=>'form-control', "id" => 'txt_distribution_type', "autocomplete" => "off", 'readonly']) !!}
			</div>
		</div>
		<div class="row m-b-sm d-none" id="div_dff_distribution_type_wht">
			<div class="col-md-12">
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>วันที่หักภาษี ณ ที่จ่าย</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_wht_date', dateFormatDisplay(optional($receiptLine)->distribution_wht_date), ['class'=>'form-control','id'=>'txt_distribution_wht_date', 'autocomplete'=>'off', 'readonly']) !!}
						@else
							{!! Form::text('distribution_wht_date', dateFormatDisplay(optional($receiptLine)->distribution_wht_date), ['class'=>'form-control','id'=>'txt_distribution_wht_date', 'autocomplete'=>'off']) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>เลขที่หนังสือรับรอง</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_cert_number', optional($receiptLine)->distribution_cert_number, ['class'=>'form-control','id'=>'txt_distribution_cert_number', 'autocomplete'=>'off', 'readonly']) !!}
						@else
							{!! Form::text('distribution_cert_number', optional($receiptLine)->distribution_cert_number, ['class'=>'form-control','id'=>'txt_distribution_cert_number', 'autocomplete'=>'off']) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ประเภทของเงินได้</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_income_type', array_key_exists(optional($receiptLine)->distribution_income_type, $APWTTypeLists) ? $APWTTypeLists[optional($receiptLine)->distribution_income_type] : optional($receiptLine)->distribution_income_type, ['class'=>'form-control', "id" => 'txt_distribution_income_type', "autocomplete" => "off", 'readonly']) !!}
						@else
							{!! Form::select('distribution_income_type', ['' => '-']+$APWTTypeLists, optional($receiptLine)->distribution_income_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_income_type', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
                    </div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ชื่อประเภทเงินได้ (ภงด)</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_income_name', array_key_exists(optional($receiptLine)->distribution_income_name, $WHTRevenueNameLists) ? $WHTRevenueNameLists[optional($receiptLine)->distribution_income_name] : optional($receiptLine)->distribution_income_name, ['class'=>'form-control', "id" => 'txt_distribution_income_name', "autocomplete" => "off", 'readonly']) !!}
						@else
							{!! Form::select('distribution_income_name', ['' => '-']+$WHTRevenueNameLists, optional($receiptLine)->distribution_income_name, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_income_name', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row m-b-sm d-none" id="div_dff_distribution_type_goods">
			<div class="col-md-12">
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ประเภทสินค้านำเข้า</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_import_type', array_key_exists(optional($receiptLine)->distribution_import_type, $APImpItemGroupLists) ? $APImpItemGroupLists[optional($receiptLine)->distribution_import_type] : optional($receiptLine)->distribution_import_type, ['class'=>'form-control', "id" => 'txt_distribution_import_type', "autocomplete" => "off", 'readonly']) !!}
						@else
							{!! Form::select('distribution_import_type', ['' => '-']+$APImpItemGroupLists, optional($receiptLine)->distribution_import_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_import_type', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>อ้างถึงเลขที่ใบสั่งซื้อ</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_po_number', array_key_exists(optional($receiptLine)->distribution_po_number, $PONumberLists) ? $PONumberLists[optional($receiptLine)->distribution_po_number] : optional($receiptLine)->distribution_po_number, ['class'=>'form-control', "id" => 'txt_distribution_po_number', "autocomplete" => "off", 'readonly']) !!}
						@else
							{!! Form::select('distribution_po_number', ['' => '-']+$PONumberLists, optional($receiptLine)->distribution_po_number, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_po_number', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>อ้างอิงรหัสพัสดุ</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_ref_number', array_key_exists(optional($receiptLine)->distribution_ref_number, $INVTobaccoLists) ? $INVTobaccoLists[optional($receiptLine)->distribution_ref_number] : optional($receiptLine)->distribution_ref_number, ['class'=>'form-control', "id" => 'txt_distribution_ref_number', "autocomplete" => "off", 'readonly']) !!}
						@else
							{!! Form::select('distribution_ref_number', ['' => '-']+$INVTobaccoLists, optional($receiptLine)->distribution_ref_number, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_ref_number', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ประเภทค่าใช้จ่าย</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_expense_type', array_key_exists(optional($receiptLine)->distribution_expense_type, $APINVImpExpenseLists) ? $APINVImpExpenseLists[optional($receiptLine)->distribution_expense_type] : optional($receiptLine)->distribution_expense_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_expense_type', "autocomplete" => "off", "style"=>"width:100%", 'readonly']) !!}
						@else
							{!! Form::select('distribution_expense_type', ['' => '-']+$APINVImpExpenseLists, optional($receiptLine)->distribution_expense_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_expense_type', "autocomplete" => "off", "style"=>"width:100%"]) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>Shipment</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_shipment', optional($receiptLine)->distribution_shipment, ['class'=>'form-control','id'=>'txt_distribution_shipment', 'autocomplete'=>'off', 'readonly']) !!}
						@else
							{!! Form::text('distribution_shipment', optional($receiptLine)->distribution_shipment, ['class'=>'form-control','id'=>'txt_distribution_shipment', 'autocomplete'=>'off']) !!}
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row m-b-sm d-none" id="div_dff_distribution_type_receipt">
			<div class="col-md-12">
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ใบเสร็จรับเงินเลขที่</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_receipt_number', optional($receiptLine)->distribution_receipt_number, ['class'=>'form-control','id'=>'txt_distribution_receipt_number', 'autocomplete'=>'off', 'readonly']) !!}
						@else
							{!! Form::text('distribution_receipt_number', optional($receiptLine)->distribution_receipt_number, ['class'=>'form-control','id'=>'txt_distribution_receipt_number', 'autocomplete'=>'off']) !!}
						@endif
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>วันที่ในใบเสร็จรับเงิน</div>
					</label>
					<div class="col-sm-6">
						@if ($readOnly)
							{!! Form::text('distribution_receipt_date', dateFormatDisplay(optional($receiptLine)->distribution_receipt_date), ['class'=>'form-control','id'=>'txt_distribution_receipt_date', 'autocomplete'=>'off', 'readonly']) !!}
						@else
							{!! Form::text('distribution_receipt_date', dateFormatDisplay(optional($receiptLine)->distribution_receipt_date), ['class'=>'form-control','id'=>'txt_distribution_receipt_date', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
						@endif
					</div>
				</div>
			</div>
		</div>
		@if ($canEditDFF)
			<div class="row clearfix">
				<div class="col-sm-12 text-right">
					<button type="submit" class="btn btn-xs btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
						Update
					</button>
				</div>
			</div>
		@endif
	</div>

	@if ($canEditDFF)
		{!! Form::close() !!}
	@endif
@endif

{{-- <div class="row">
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Branch</div>
                <div><small>ค่าใช้จ่ายของสาขา</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ array_key_exists($receiptLine->branch_code, $branchLists) ? $branchLists[$receiptLine->branch_code] : '-'  }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <label for="" class="col-md-4 control-label">
                <div>Department</div>
                <div><small>ค่าใช้จ่ายของแผนก</small></div>
            </label>
            <div class="col-md-8">
                <p>{{ array_key_exists($receiptLine->department_code, $departmentLists) ? $departmentLists[$receiptLine->department_code] : '-' }}</p>
            </div>
        </div>
    </div>
</div> --}}

{{-- FROM SUB-CATEGORIES INFORMATIONS --}}
@if(count($receiptLine->infos) > 0)
	<div class="hr-line-dashed m-t-sm m-b-sm"></div>
	<div class="row">
	@foreach($receiptLine->infos as $index => $info)
		<div class="col-md-4">
			<div>
	            <div><label><small>
	            	{{ $info->subCategoryInfo->attribute_name }}
	            </small></label></div>
	            <p class="form-control-static">
	               {{ $info->description_for_show }}
	            </p>
	        </div>
		</div>
	@if(($index+1)%3 == 0)
	{!! '</div><div class="row">' !!}
	@endif
	@endforeach
	</div>
@endif

@if($receiptLine->policy)

    @if($receiptLine->policy->typeMileage())

    {{-- MILEAGE INFORMATIONS --}}

    <div class="hr-line-dashed m-t-sm m-b-sm"></div>

    <div class="row text-right">

        {{-- <div class="col-sm-6">
            <div>
                <label><small>
                    <div>Odometer Reading</div>
                    <div><small>ค่าจากมาตรวัดระยะทาง</small></div>
                </small></label>
            </div>
            <div class="row">
    	        <div class="col-sm-4">
    	            <p class="form-control-static text-center">
    	            {{ $receiptLine->mileage_start ? number_format($receiptLine->mileage_start,2) : '-' }}
    	            </p>
    	        </div>
    	        <div class="col-sm-2">
    	            <p class="form-control-static text-center">to</p>
    	        </div>
    	        <div class="col-sm-4">
    	            <p class="form-control-static text-center">
    	            {{ $receiptLine->mileage_end ? number_format($receiptLine->mileage_end,2) : '-' }}
    	            </p>
    	        </div>
            </div>
        </div> --}}
        
        <div class="col-md-7 col-md-offset-5">
            <div class="row text-right">
                <div class="col-sm-6"> 
                    <label>
                        <div>Distance</div>
                        <div><small>ระยะทาง</small></div>
                    </label>
                </div>
                <div class="col-sm-6"> 
                    <span style="font-size: 20px;">
                        {{ $receiptLine->mileage_distance ? number_format($receiptLine->mileage_distance,2) : '-' }}
                    </span>
            		<span>{{ $mileageUnitLists[$baseMileageUnit] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-b-sm text-right">
        <div class="col-sm-12">
            <div class="text-navy">
            @if(isset($receiptLine->rate))
                Rate = {{ number_format($receiptLine->rate->rate,2) }} {{ $parentCurrencyId }} per {{ $mileageUnitLists[$baseMileageUnit] }}
            @endif
            </div>
        </div>
    </div>

    @endif
    
@endif

{{-- AMOUNT INFORMATIONS --}}

<div class="hr-line-dashed m-t-sm m-b-sm"></div>

<div class="row m-t-lg m-b-sm">
    <div class="col-md-2">
        <div class="row text-right">
            <div class="col-sm-6"> 
                <label><small>
                    <div>Quantity</div>
                    <div><small>จำนวน</small></div>
                </small></label> 
            </div>
            <div class="col-sm-6">
                @if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ '-' }}
                    @else {{-- EXPENSE --}}
                        {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                        {{-- <span>{{ $receiptLine->subCategory->unit }}</span> --}}
						<span>{{ $receiptLine->uom }}</span>
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receiptLine->quantity ? $receiptLine->quantity : '-' }}
                    {{-- <span>{{ $receiptLine->subCategory->unit }}</span> --}}
					<span>{{ $receiptLine->subCategory->uom }}</span>
                @endif
                @if($receiptLine->subCategory->use_second_unit)
                    @if($receiptLine->policy)
                        @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                            {{ '-' }}
                        @else {{-- EXPENSE --}}
                            {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                            {{-- <span>{{ $receiptLine->subCategory->second_unit }}</span> --}}
							<span>{{ $receiptLine->second_uom }}</span>
                        @endif
                    @else {{-- ACTUAL --}}
                        {{ $receiptLine->second_quantity ? $receiptLine->second_quantity : '-' }}
                        {{-- <span>{{ $receiptLine->subCategory->second_unit }}</span> --}}
						<span>{{ $receiptLine->subCategory->second_uom }}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
	<div class="col-md-5">
		<div class="row text-right">
        	<div class="col-sm-6"> 
        		<label><small>
                    <div>Amount <small>before VAT</small></div>
                    <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_amount ? number_format($receiptLine->total_amount,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>WHT Amount</div>
                    <div><small>ภาษีหัก ณ ที่จ่าย</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->wht_amount ? number_format($receiptLine->wht_amount,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>
        
        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>VAT Amount</div>
                    <div><small>ภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->vat_amount ? number_format($receiptLine->vat_amount,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>Amount <small>Inc. VAT</small></div>
                    <div><small>ยอดเงินรวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_amount_inc_vat ? number_format($receiptLine->total_amount_inc_vat,2) : '0.00' }}
                </span>
        		<span>
				@if($receiptLine->policy)
                    @if($receiptLine->policy->typeMileage()) {{-- MILEAGE --}}
                        {{ $parentCurrencyId }}
                    @else {{-- EXPENSE --}}
                        {{ $receipt->currency_id }}
                    @endif
                @else {{-- ACTUAL --}}
                    {{ $receipt->currency_id }}
                @endif
        		</span>
        	</div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="row text-right">
        	<div class="col-sm-6"> 
        		<label><small>
                    <div>Amount <small>before VAT</small></div>
                    <div><small>ยอดเงินไม่รวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->total_primary_amount ? number_format($receiptLine->total_primary_amount,2) : '0.00' }}
                </span>
        		{{-- <span>{{ $parentCurrencyId }}</span> --}}
                <span> THB </span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>WHT Amount</div>
                    <div><small>ภาษีหัก ณ ที่จ่าย</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->primary_wht_amount ? number_format($receiptLine->primary_wht_amount,2) : '0.00' }}
                </span>
        		{{-- <span>{{ $parentCurrencyId }}</span> --}}
                <span> THB </span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>VAT Amount</div>
                    <div><small>ภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <span style="font-size: 14px;">
        		{{ $receiptLine->primary_vat_amount ? number_format($receiptLine->primary_vat_amount,2) : '0.00' }}
                </span>
        		{{-- <span>{{ $parentCurrencyId }}</span> --}}
                <span> THB </span>
        	</div>
        </div>

        <div class="row text-right">
        	<div class="col-sm-6">
        		<label><small>
                    <div>Amount <small>Inc. VAT</small></div>
                    <div><small>ยอดเงินรวมภาษีมูลค่าเพิ่ม</small></div>
                </small></label> 
        	</div>
        	<div class="col-sm-6">
                <div style="padding-bottom: 5px;border-bottom: 1px solid #DDDDDD;">
                    <span style="font-size: 22px;">
                        {{ $receiptLine->total_primary_amount_inc_vat ? number_format($receiptLine->total_primary_amount_inc_vat,2) : '0.00' }}
                    </span>
            		{{-- <span>{{ $parentCurrencyId }}</span> --}}
                    <span> THB </span>
                </div>
        	</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
		var formId = "#modal_content_show_receipt_line";
		var canEditDFF = "{!! $canEditDFF !!}";

		var distributionType = $(formId).find("#txt_distribution_type").val();
		if(distributionType == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
			toggleShowDFFDistribution(true);
			toggleShowDFFDistributionTypeWHT(true);
		}else if(distributionType == 'สินค้าต่างประเทศ'){
			toggleShowDFFDistribution(true);
			toggleShowDFFDistributionTypeGoods(true);
		}else if(distributionType == 'ใบเสร็จรับเงิน') {
			toggleShowDFFDistribution(true);
			toggleShowDFFDistributionTypeReceipt(true);
		}

		if(canEditDFF){

			// $(formId).find('#txt_distribution_type').select2({width: "100%"});
			$(formId).find('#txt_distribution_income_type').select2({width: "100%"});
			$(formId).find('#txt_distribution_income_name').select2({width: "100%"});
			$(formId).find('#txt_distribution_import_type').select2({width: "100%"});
			$(formId).find('#txt_distribution_po_number').select2({width: "100%"});
			$(formId).find('#txt_distribution_ref_number').select2({
				ajax: {
					url: "{{ url('/') }}/ie/receipts/get_inv_tobacco",
					dataType: 'json',
					delay: 250,
					processResults: function (data) {
						return {
							results: $.map(data, function (item) {
								return {
									text: item.full_description,
									id: item.item_code
								}
							})
						};
					},
				}
			});
			$(formId).find('#txt_distribution_expense_type').select2({width: "100%"});

			$(formId).find('#txt_distribution_wht_date').datepicker({
				format: 'dd/mm/yyyy',
				todayBtn: true,
				multidate: false,
				keyboardNavigation: false,
				autoclose: true,
				todayBtn: "linked"
			});

			$(formId).find('#txt_distribution_receipt_date').datepicker({
				format: 'dd/mm/yyyy',
				todayBtn: true,
				multidate: false,
				keyboardNavigation: false,
				autoclose: true,
				todayBtn: "linked"
			});
		}

		$(formId).find("#btn_open_dff_distribution").click(() => {
			toggleShowDFFDistribution(true);
		});

		$(formId).find("#btn_close_dff_distribution").click(() => {
			toggleShowDFFDistribution(false);
		});

		// $(formId).find("#txt_distribution_type").change(() => {
		// 	let type = $(formId).find("#txt_distribution_type").val();

		// 	resetFormDFFDistribution();
		// 	toggleShowDFFDistributionTypeWHT(false);
		// 	toggleShowDFFDistributionTypeGoods(false);
		// 	toggleShowDFFDistributionTypeReceipt(false);

		// 	if(type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
		// 		toggleShowDFFDistributionTypeWHT(true);
		// 	}else if(type == 'สินค้าต่างประเทศ'){
		// 		toggleShowDFFDistributionTypeGoods(true);
		// 	}else if(type == 'ใบเสร็จรับเงิน') {
		// 		toggleShowDFFDistributionTypeReceipt(true);
		// 	}
		// });

		function toggleShowDFFDistribution(checked)
		{
			if(checked){
				$(formId).find('#btn_open_dff_distribution').addClass('d-none');
				$(formId).find('#div_dff_distribution').removeClass('d-none');
			}else{
				$(formId).find('#btn_open_dff_distribution').removeClass('d-none');
				$(formId).find('#div_dff_distribution').addClass('d-none');
			}
		}

		function toggleShowDFFDistributionTypeWHT(checked)
		{
			if(checked){
				$(formId).find('#div_dff_distribution_type_wht').removeClass('d-none');
			}else{
				$(formId).find('#div_dff_distribution_type_wht').addClass('d-none');
			}
		}

		function toggleShowDFFDistributionTypeGoods(checked)
		{
			if(checked){
				$(formId).find('#div_dff_distribution_type_goods').removeClass('d-none');
			}else{
				$(formId).find('#div_dff_distribution_type_goods').addClass('d-none');
			}
		}

		function toggleShowDFFDistributionTypeReceipt(checked)
		{
			if(checked){
				$(formId).find('#div_dff_distribution_type_receipt').removeClass('d-none');
			}else{
				$(formId).find('#div_dff_distribution_type_receipt').addClass('d-none');
			}
		}

		function resetFormDFFDistribution()
		{
			$(formId).find('#txt_distribution_wht_date').val('');
			$(formId).find('#txt_distribution_cert_number').val('');
			$(formId).find('#txt_distribution_income_type').val('');
			$(formId).find('#txt_distribution_income_name').val('');

			$(formId).find('#txt_distribution_import_type').val('');
			$(formId).find('#txt_distribution_po_number').val('');
			$(formId).find('#txt_distribution_ref_number').val('');
			$(formId).find('#txt_distribution_expense_type').val('');
			$(formId).find('#txt_distribution_shipment').val('');

			$(formId).find('#txt_distribution_receipt_number').val('');
			$(formId).find('#txt_distribution_receipt_date').val('');
		}
    });
</script>