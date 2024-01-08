<div class="row m-b-sm">
    <div class="col-md-4 m-t-xs full-size-width-30">
        <div style="border: 1px solid #1ab394;">
            <div class="p-xs">
                <span class="label label-primary">Cash Advance</span>
                <span class="text-navy pull-right">{{ $cashAdvance->document_no }}</span>
            </div>
            <div class="p-sm text-right text-navy" style="border-top: 1px solid #1ab394; border-bottom: 1px solid #1ab394;">
                <h1 class="no-margins">{{ numberFormatDisplay($cashAdvance->amount)}}</h1>
                <small>{{ $cashAdvance->currency_id }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 m-t-xs full-size-width-30">
        <div style="border: 1px solid #23c6c8;">
            <div class="p-xs">
                <span class="label label-info">Clearing</span>
                <span class="text-navy pull-right">{{ $cashAdvance->clearing_document_no }}</span>
            </div>
            <div class="p-sm text-right text-info"  style="border-top: 1px solid #23c6c8; border-bottom: 1px solid #23c6c8;">
                <h1 class="no-margins" id="receipt_grand_total_amount_compare">{{ $cashAdvance->total_receipt_amount ? numberFormatDisplay($cashAdvance->total_receipt_amount) : '0.00' }}</h1>
                <small>{{ $cashAdvance->currency_id }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 m-t-xs full-size-width-40">
        <div style="border: 1px solid #f8ac59;">
            <div class="p-xs">
                <span class="label label-warning">Diff</span>
            </div>
            <div class="p-sm text-right text-warning" id="div_diff_ca_and_clearing_amount"
                style="border-top: 1px solid #f8ac59; border-bottom: 1px solid #f8ac59; padding-left:10px;">
                @include('ie.cash-advances.clear._diff_ca_and_clearing_amount')
            </div>
        </div>
    </div>
</div>