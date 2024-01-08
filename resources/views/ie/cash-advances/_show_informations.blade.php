@if(count($cashAdvance->infos) > 0)
	<div class="hr-line-dashed m-t-sm m-b-sm"></div>
	<div class="row">
	@foreach($cashAdvance->infos as $index => $info)
		<div class="col-md-4">
			<div>
	            <div><label>
	            	{{ $info->subCategoryInfo->attribute_name }}
	            </label></div>
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