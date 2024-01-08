@if($cashAdvance->isNotLock())
<div id="modal-edit-form-ca" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0" style="max-width: 850px;">
        <div class="modal-content">
            <div class="modal-body" id="modal-body-edit-form">
				<div class="m-l-xs m-r-lg mm-xs">
	            	{!! Form::model($cashAdvance, ['route' => ['ie.cash-advances.update', $cashAdvance->cash_advance_id], 'class' => 'form-horizontal', 'method' => 'patch', 'id' => 'form-edit-cash-advance'] ) !!}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="m-b-md">Edit Cash Advance : {{ $cashAdvance->document_no }}</h3>
				    <hr class="m-b-xs">
					{!! Form::hidden('process_type', 'CASH-ADVANCE', ["id" => 'txt_process_type']) !!}
				    <div class="row clearfix">
				        <div class="col-sm-12" id="modal_content_edit_ca">
							{{-- FORM CASH ADVANCE HTML --}}
	            			{{-- @include('ie.cash-advances._form', ['action' => 'edit']) --}}
				        </div>
					</div>
					<hr class="m-t-sm m-b-sm">
					<div class="row clearfix">
				        <div class="col-sm-12 text-right">
				        	<button type="submit" class="btn btn-primary" id="btn-submit-edit-ca" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
				        		Save
				        	</button>
				        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					    </div>
					</div>
	                {!! Form::close()!!}
				</div>
            </div>
        </div>
    </div>
</div>
@endif
