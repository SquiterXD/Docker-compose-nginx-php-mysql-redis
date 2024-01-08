<div class="row">
    <small class="col-md-12 font-bold">Reimbursement (จำนวนเงินที่เบิก)</small>
    <div class="col-md-12 text-right m-t-sm">
        <h2 style="font-size: 30px" class="no-margins">
            <span id="receipt_grand_total_amount">
                {{ numberFormatDisplay($reimTotalAmount) }}
            </span>
            <small>{{ $reim->currency_id }}</small>
        </h2>
    </div>
</div>
<hr class="m-b-xs">