@if ($apply = $item->apply)
    @include('ie.cash-advances._cancel_apply', $item = $apply)
    <hr class="m-t-xs m-b-xs">
    <div>
        <div class="pull-left d-none d-md-block" style="font-size: 0.8em;">
            clear 
        </div>
        @if ($apply->statusClearCancel)
            <div class="pull-right d-none d-md-block text-danger" style="font-size: 0.8em;">cancel</div>
        @endif
        <div>{{ $apply->clearing_invoice_no ?? '-' }}</div>
    </div>
@endif