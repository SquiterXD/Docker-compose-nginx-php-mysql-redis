<div class="row">
    <div class="col-md-6">
        <h3>
            Document # : {{ $cashAdvance->document_no }}
        </h3>
    </div>
    <div class="col-md-6 text-right">
        <span>{!! statusIconCA($cashAdvance->status) !!}</span>
    </div>
</div>
<hr class="m-t-sm">