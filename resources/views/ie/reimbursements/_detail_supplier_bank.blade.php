<div class="col-md-6">
    <label>
        <div>Supplier Bank (ธนาคารผู้ขาย)</div>
    </label>
    <div>
        {{ optional(optional($supplier)->bank)->short_bank_name ?? '-' }}
        {!! Form::hidden('supplier_bank_name', optional(optional($supplier)->bank)->short_bank_name ?? null, ["id" => 'txt_supplier_bank_name']) !!}
    </div>
</div>
<div class="col-md-6">
    <label>
        <div>Supplier Account No (เลขที่บัญชีผู้ขาย)</div>
    </label>
    <div>
        {{ optional(optional($supplier)->bank)->bank_account_num ?? '-' }}
        {!! Form::hidden('supplier_bank_account_no', optional(optional($supplier)->bank)->bank_account_num ?? null, ["id" => 'txt_supplier_bank_account_no']) !!}
    </div>
</div>