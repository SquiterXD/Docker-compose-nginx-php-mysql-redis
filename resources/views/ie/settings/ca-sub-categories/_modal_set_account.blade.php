<div id="modal-set-account" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-lg">
        <div class="modal-content">
            <div class="modal-body">
				<div class="m-l-xs m-r-lg mm-xs">
                    <button type="button" class="close" id="close_adjust_account" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="m-b-md">Account Code</h3>
				    <hr class="m-b-xs">
				    <div class="row clearfix">
				        <div class="col-sm-12">
							{{-- FORM CASH ADVANCE HTML --}}
	            			@include('ie.settings.ca-sub-categories._form_set_account')
				        </div>
					</div>
					<hr class="m-t-sm m-b-sm">
					<div class="row clearfix">
				        <div class="col-sm-12 text-right">
				        	<button type="submit" class="btn btn-primary" id="submit_adjust_account">
				        		Save
				        	</button>
				        	<button type="button" class="btn btn-danger" id="cancel_adjust_account" data-dismiss="modal">Cancel</button>
					    </div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>