<div class="row">
    <div class="col-sm-12">
        <select name="dff_type" id="txt_dff_type" class="form-control select2" {{ $isNotLock ? '' : 'disabled' }}>
            @if ( in_array($requestType, ['REIMBURSEMENT']) && in_array($formType, ['HEADER']) )
                <option value="invoice">ใบแจ้งหนี้</option>
            @endif
            @if ( in_array($formType, ['HEADER']) )
                <option value="cash_advance" {{ $dffType == 'cash_advance' ? 'selected' : '' }}>เงินทดรอง/เงินสดย่อย</option>
            @endif
            @if ( in_array($requestType, ['RECEIPT-LINE']) && in_array($formType, ['LINE']) )
                <option value="tax_invoice">ใบแจ้งหนี้/ใบกำกับภาษี</option>
            @endif
        </select>
    </div>
</div>