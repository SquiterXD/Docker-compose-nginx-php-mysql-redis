@if(isset($CASubCategoryInfos))
	@if(count($CASubCategoryInfos) > 0)
	<label for="" class="col-md-2 control-label" style="padding-top: 20px;color:#999;">
        Informations
    </label>
	<div class="col-md-10">
		<div class="hr-line-dashed m-t-sm m-b-sm"></div>
			<div class="row">
				@foreach($CASubCategoryInfos as $index => $info)
				<div class="col-md-4">
					<div class="m-b-sm">
			            <div><label>
			            	{{ $info->attribute_name }}
			            	@if($info->required)
			            		<span class="text-danger">*</span>
			            	@endif
			            </label></div>
			            @if($info->form_type == 'select') {{-- select --}}
							
							{!! Form::select('ca_sub_category_infos['.$info->casub_cate_info_id.']', $info->input_form_value, isset($cashAdvanceInfoLists) ? array_key_exists($info->casub_cate_info_id, $cashAdvanceInfoLists) ? $cashAdvanceInfoLists[$info->casub_cate_info_id] : null : null , [
									'class' => 'form-control input-sm',
									'style'=>'font-size: 12px;',
									'data-required'=> $info->required ? 'required':'', 
									'data-label'=> $info->attribute_name,
									'id'=>'ip_ca_sub_category_infos_'.$info->casub_cate_info_id]) !!}

			            @elseif($info->form_type == 'date') {{-- date --}}
							
							@if(!isset($cashAdvanceInfoLists))
								{!! Form::text('ca_sub_category_infos['.$info->casub_cate_info_id.']', $info->input_form_value , [
									'class' => 'form-control input-sm date-picker info-date-picker',
									'data-required'=> $info->required ? 'required':'', 
									'data-label'=> $info->attribute_name,
									'id'=>'ip_ca_sub_category_infos_'.$info->casub_cate_info_id]) !!}
							@else
								{!! Form::text('ca_sub_category_infos['.$info->casub_cate_info_id.']', isset($cashAdvanceInfoLists) ? array_key_exists($info->casub_cate_info_id, $cashAdvanceInfoLists) ? dateFormatDisplay($cashAdvanceInfoLists[$info->casub_cate_info_id]) : null : null , [
									'class' => 'form-control input-sm date-picker info-date-picker',
									'data-required'=> $info->required ? 'required':'', 
									'data-label'=> $info->attribute_name,
									'id'=>'ip_ca_sub_category_infos_'.$info->casub_cate_info_id]) !!}

							@endif

			            @else {{-- text --}}

							@if(!isset($cashAdvanceInfoLists))
								{!! Form::text('ca_sub_category_infos['.$info->casub_cate_info_id.']', $info->input_form_value , [	'class' => 'form-control input-sm',
									'data-required'=> $info->required ? 'required':'', 
									'data-label'=> $info->attribute_name,
									'id'=>'ip_ca_sub_category_infos_'.$info->casub_cate_info_id]) !!}
							@else
								{!! Form::text('ca_sub_category_infos['.$info->casub_cate_info_id.']', isset($cashAdvanceInfoLists) ? array_key_exists($info->casub_cate_info_id, $cashAdvanceInfoLists) ? $cashAdvanceInfoLists[$info->casub_cate_info_id] : null : null , [	'class' => 'form-control input-sm',
									'data-required'=> $info->required ? 'required':'', 
									'data-label'=> $info->attribute_name,
									'id'=>'ip_ca_sub_category_infos_'.$info->casub_cate_info_id]) !!}
							@endif

			            @endif
			        </div>
				</div>
				@if(($index+1)%3 == 0)
				{!! '</div><div class="row">' !!}
				@endif
			@endforeach
		</div>
	</div>
	@endif

@endif

