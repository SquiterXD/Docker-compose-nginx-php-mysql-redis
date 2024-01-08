<div class="row">
    <div class="col-md-12 no-padding-xs">
        @if($cashAdvance->status == 'CLEARING_REQUEST')
            <div class="text-right m-b-sm mm-sm">
                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal_create_receipt" id="btn-create-receipt" data-backdrop="static" data-keyboard="false">Add Receipt</button>
            </div>
        @endif
		<div class="clearfix" id="div_clearing_receipt_list">

	        @include('ie.commons.receipts._table',['parent'=>$cashAdvance, 'editable'=> canEnter('/ie/cash-advances')])

		</div>
    </div>
</div>
<hr class="m-t-sm m-b-sm">

@include('ie.commons.receipts._modal_create')
@include('ie.commons.receipts._modal_edit')