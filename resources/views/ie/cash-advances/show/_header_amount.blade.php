<div class="row">
    <small class="col-md-12 font-bold">Amount (จำนวนเงินที่ยืม)</small>
    <div class="col-md-12 text-right m-t-sm">
        <h2 style="font-size: 36px" class="no-margins">
            <span id="receipt_grand_total_amount">
                {{ numberFormatDisplay($cashAdvance->amount)}} 
            </span>
            <small>{{ $cashAdvance->currency_id }}</small>
        </h2>
    </div>
</div>
<hr class="m-b-xs">