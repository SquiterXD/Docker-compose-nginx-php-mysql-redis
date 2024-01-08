<div class="row">
    <div class="col-md-12">
        <div class="m-b-sm">
            <div><label for="">
                <div>Line Description <span class="text-danger">*</span></div>
                <div><small>คำอธิบาย</small></div>
            </label></div>
            {!! Form::textarea('description', $defaultDescription, ["class" => 'form-control ', "id"=>"txt_description", "autocomplete" => "off", "style"=>"font-size:12px;width:100%", 'rows' => 2, 'cols' => 40, 'maxlength'=>250]) !!}
        </div>
    </div>
</div>
@if ($receiptType != 'CASH-ADVANCE')
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
				{!! Form::select('distribution_type', ['' => '-']+$distributionTypeLists, $defaultDistributionType, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_type', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
			</div>
		</div>
		<div class="row m-b-sm d-none" id="div_dff_distribution_type_wht">
			<div class="col-md-12">
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>วันที่หักภาษี ณ ที่จ่าย</div>
					</label>
					<div class="col-sm-6">
						{!! Form::text('distribution_wht_date', optional($receiptLine)->distribution_wht_date, ['class'=>'form-control','id'=>'txt_distribution_wht_date', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>เลขที่หนังสือรับรอง</div>
					</label>
					<div class="col-sm-6">
						{!! Form::text('distribution_cert_number', optional($receiptLine)->distribution_cert_number, ['class'=>'form-control','id'=>'txt_distribution_cert_number', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ประเภทของเงินได้</div>
					</label>
					<div class="col-sm-6">
						{!! Form::select('distribution_income_type', ['' => '-']+$APWTTypeLists, optional($receiptLine)->distribution_income_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_income_type', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ชื่อประเภทเงินได้ (ภงด)</div>
					</label>
					<div class="col-sm-6">
						{!! Form::select('distribution_income_name', ['' => '-']+$WHTRevenueNameLists, optional($receiptLine)->distribution_income_name, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_income_name', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
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
						{!! Form::select('distribution_import_type', ['' => '-']+$APImpItemGroupLists, optional($receiptLine)->distribution_import_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_import_type', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>อ้างถึงเลขที่ใบสั่งซื้อ</div>
					</label>
					<div class="col-sm-6">
						{!! Form::select('distribution_po_number', ['' => '-']+$PONumberLists, optional($receiptLine)->distribution_po_number, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_po_number', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>อ้างอิงรหัสพัสดุ</div>
					</label>
					<div class="col-sm-6">
						{!! Form::select('distribution_ref_number', ['' => '-']+$INVTobaccoLists, optional($receiptLine)->distribution_ref_number, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_ref_number', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>ประเภทค่าใช้จ่าย</div>
					</label>
					<div class="col-sm-6">
						{!! Form::select('distribution_expense_type', ['' => '-']+$APINVImpExpenseLists, optional($receiptLine)->distribution_expense_type, ['class'=>'form-control input-sm select2', "id" => 'txt_distribution_expense_type', "autocomplete" => "off", "style"=>"width:100%", optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>Shipment</div>
					</label>
					<div class="col-sm-6">
						{!! Form::text('distribution_shipment', optional($receiptLine)->distribution_shipment, ['class'=>'form-control','id'=>'txt_distribution_shipment', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
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
						{!! Form::text('distribution_receipt_number', optional($receiptLine)->distribution_receipt_number, ['class'=>'form-control','id'=>'txt_distribution_receipt_number', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
				<div class="row m-b-xs">
					<label for="" class="col-sm-4 text-right">
						<div>วันที่ในใบเสร็จรับเงิน</div>
					</label>
					<div class="col-sm-6">
						{!! Form::text('distribution_receipt_date', optional($receiptLine)->distribution_receipt_date, ['class'=>'form-control','id'=>'txt_distribution_receipt_date', 'autocomplete'=>'off', optional(optional($receipt)->parent)->isNotLock() ? '' : 'readonly']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
@if(isset($informations))
	@if(count($informations) > 0)
		<div class="hr-line-dashed m-t-sm m-b-sm"></div>
		<div class="row clearfix">
		@foreach($informations as $index => $info)
			<div class="col-md-4">
				<div class="m-b-sm">
		            <div><label>
		            	{{ $info->attribute_name }}
		            	@if($info->required)
		            		<span class="text-danger">*</span>
		            	@endif
		            </label></div>
		            @if($info->form_type == 'select') {{-- select --}}

						{!! Form::select('sub_category_infos['.$info->sub_category_info_id.']', $info->input_form_value, isset($receiptInfoLists) ? array_key_exists($info->sub_category_info_id, $receiptInfoLists) ? $receiptInfoLists[$info->sub_category_info_id] : null : null , [
								'class' => 'form-control input-sm',
								'style'=>'font-size: 12px;',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->sub_category_info_id]) !!}

		            @elseif($info->form_type == 'date') {{-- date --}}

						@if(!isset($receiptInfoLists))
							{!! Form::text('sub_category_infos['.$info->sub_category_info_id.']', $info->input_form_value , [
								'class' => 'form-control input-sm date-picker info-date-picker',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->sub_category_info_id]) !!}
						@else
							{!! Form::text('sub_category_infos['.$info->sub_category_info_id.']', isset($receiptInfoLists) ? array_key_exists($info->sub_category_info_id, $receiptInfoLists) ? dateFormatDisplay($receiptInfoLists[$info->sub_category_info_id]) : null : null , [
								'class' => 'form-control input-sm date-picker info-date-picker',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->sub_category_info_id]) !!}

						@endif

		            @else {{-- text --}}

						@if(!isset($receiptInfoLists))
							{!! Form::text('sub_category_infos['.$info->sub_category_info_id.']', $info->input_form_value , [	'class' => 'form-control input-sm',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->sub_category_info_id]) !!}
						@else
							{!! Form::text('sub_category_infos['.$info->sub_category_info_id.']', isset($receiptInfoLists) ? array_key_exists($info->sub_category_info_id, $receiptInfoLists) ? $receiptInfoLists[$info->sub_category_info_id] : null : null , [	'class' => 'form-control input-sm',
								'data-required'=> $info->required ? 'required':'', 
								'data-label'=> $info->attribute_name,
								'id'=>'ip_sub_category_infos_'.$info->sub_category_info_id]) !!}
						@endif

		            @endif
		        </div>
			</div>
		@if(($index+1)%3 == 0)
		{!! '</div><div class="row">' !!}
		@endif
		@endforeach
		</div>
	@endif
@endif

<script>
    $(document).ready(function() {
		var formId = "{{ $formId }}";

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

		$(formId).find('#txt_distribution_type').select2({width: "100%"});
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

        $('.info-date-picker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            multidate: false,
            keyboardNavigation: false,
            autoclose: true,
            todayBtn: "linked"
        });

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

		$(formId).find("#btn_open_dff_distribution").click(() => {
			toggleShowDFFDistribution(true);
		});

		$(formId).find("#btn_close_dff_distribution").click(() => {
			toggleShowDFFDistribution(false);
		});

		$(formId).find("#txt_distribution_type").change(() => {
			let type = $(formId).find("#txt_distribution_type").val();

			resetFormDFFDistribution();
			toggleShowDFFDistributionTypeWHT(false);
			toggleShowDFFDistributionTypeGoods(false);
			toggleShowDFFDistributionTypeReceipt(false);

			if(type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
				toggleShowDFFDistributionTypeWHT(true);
			}else if(type == 'สินค้าต่างประเทศ'){
				toggleShowDFFDistributionTypeGoods(true);
			}else if(type == 'ใบเสร็จรับเงิน') {
				toggleShowDFFDistributionTypeReceipt(true);
			}
		});

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
