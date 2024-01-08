{{-- VIEW BUTTON --}}
<a href="{{ route('ie.receipts.show',[$receipt->receipt_id]) }}" title="View" 
    class="btn btn-block btn-default btn-xs" target="_blank"> 
    <i class="fa fa-search"></i> VIEW
</a>
{{-- ACTION BUTTON SHOW ONLY REQUESTER --}}
@if($receipt->isNotLock() && $editable)

    <div class="btn-group btn-block">
        <button data-toggle="dropdown" class="btn btn-block btn-white btn-xs dropdown-toggle">
            ACTION
        </button>
        <ul class="dropdown-menu dropdown-menu-receipt receipt-menu">
            @if($parent->canImportantEditData())
                <li>
                    <a type="button" id="btn_add_receipt_line_{{ $receipt->receipt_id }}" 
                    data-receipt-id="{{ $receipt->receipt_id }}" class="text-success" title="Add Line">
                        <i class="fa fa-plus"></i>&nbsp; Add Line
                    </a>
                </li>
            @endif
            <li>
                <a type="button" id="btn_edit_receipt_{{ $receipt->receipt_id }}" 
                data-receipt-id="{{ $receipt->receipt_id }}" class="text-warning" title="Edit">
                    <i class="fa fa-pencil-square-o"></i>&nbsp; Edit
                </a>
            </li>
            @if($parent->canImportantEditData())
                <li>
                    <a type="button" id="btn_duplicate_receipt_{{ $receipt->receipt_id }}" 
                    data-receipt-id="{{ $receipt->receipt_id }}" class="text-info" 
                    title="Copy">
                        <i class="fa fa-copy"></i>&nbsp; Copy
                    </a>
                </li>
                <li>
                    <a type="button" id="btn_remove_receipt_{{ $receipt->receipt_id }}" 
                    data-receipt-id="{{ $receipt->receipt_id }}" class="text-danger" 
                    title="Remove">
                        <i class="fa fa-times"></i>&nbsp; Remove
                    </a>
                </li>
            @endif
        </ul>
    </div>

@endif