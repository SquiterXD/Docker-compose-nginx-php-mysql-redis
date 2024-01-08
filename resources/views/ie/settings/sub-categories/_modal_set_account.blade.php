<div id="modal-set-account" class="modal fade" aria-hidden="true">
    <div class="modal-dialog pt-0 modal-lg">
		<div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-left" > 
                    Account Code
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
					<div class="col-sm-12" id="modal_content_set_account">
						{{-- FORM CASH ADVANCE HTML --}}
						{{-- @include('ie.settings.sub-categories._form_set_account') --}}
					</div>
				</div>
				<hr class="m-t-sm m-b-sm">
				<div class="row clearfix">
					<div class="col-sm-12 text-right">
						<button type="submit" class="btn btn-primary" id="btn-confirm-set-account">
							Confirm
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>