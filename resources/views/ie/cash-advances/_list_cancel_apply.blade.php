@if ($apply = $cashAdvance->apply)
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    @if($apply->onClearing() && ( canEnter('/ie/cash-advances') || canView('/ie/cash-advances') ) )
                        <span class="text-danger pr-2">Cancel </span>
                        <a href="{{ route('ie.cash-advances.clear', $apply->cash_advance_id) }}">
                            {{ $apply->clearing_invoice_no }}
                        </a> | 
                        <a title="CL PDF" target="_blank" 
                            href="{{ route('ie.report.request', ['CLEARING', $apply->cash_advance_id]) }}">
                            <i class="fa fa-file-text"></i> PDF
                        </a>
                        <button class="btn btn-xs btn-light ml-4 mb-0" id="btn-show-reason-{{$apply->cash_advance_id}}" data-id="{{$apply->cash_advance_id}}">Reason</button>
                    @endif
                </div>
            </div>
            <div class="row mt-1 d-none" id="show-reason-{{$apply->cash_advance_id}}">
                <div class="col-md-12">
                    <div class="card">
                        <div>
                            <button class="close text-right" style="padding-right: 5px;" type="button" aria-label="Close" 
                                id="btn-close-reason-{{$apply->cash_advance_id}}" data-id="{{$apply->cash_advance_id}}" >
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="card-body" style="font-size: 0.8rem; padding-top: 0px;">
                            {{ optional($apply->statusClearCancel)->remittance_message1 ? optional($apply->statusClearCancel)->remittance_message1 : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('ie.cash-advances._list_cancel_apply', $cashAdvance = $apply)
@endif


<script type="text/javascript">
    $(document).ready(function(){

        $("[id^='btn-show-reason-']").click(function() {
            let id = $(this).attr('data-id');
            let show = '#show-reason-'+id;
            $(show).removeClass('d-none');
        });

        $("[id^='btn-close-reason-']").click(function() {
            let id = $(this).attr('data-id');
            let show = '#show-reason-'+id;
            $(show).addClass('d-none');
        });

    });
</script>
