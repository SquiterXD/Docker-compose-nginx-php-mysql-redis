<tr>
    <td><strong><small>Total Amount <small>before VAT</small> </small></strong></td>
    <td style="border-bottom: 1px solid #DDDDDD;text-align: right;width: 15%;">
        @if ($receiptType == 'CASH-ADVANCE')
            {{ $parent->ca_total_receipt_amount_before_tax ? numberFormatDisplay($parent->ca_total_receipt_amount_before_tax) : '0.00' }} 
        @else
            {{ $parent->total_receipt_amount_before_tax ? numberFormatDisplay($parent->total_receipt_amount_before_tax) : '0.00' }} 
        @endif
        {{ $parentCurrencyId }}
    </td>
    @if ($parent->currency_id != 'THB')
        <td style="text-align: right;"><strong><small>Total Amount <small>before VAT</small> </small></strong></td>
        <td>
            @if ($receiptType == 'CASH-ADVANCE')
                {{ $parent->ca_total_primary_amount_before_tax ? numberFormatDisplay($parent->ca_total_primary_amount_before_tax) : '0.00' }} 
            @else
                {{ $parent->total_primary_amount_before_tax ? numberFormatDisplay($parent->total_primary_amount_before_tax) : '0.00' }} 
            @endif
            THB
        </td>
    @endif
</tr>
<tr>
    <td><strong><small>VAT Amount</small></strong></td>
    <td style="border-bottom: 1px solid #DDDDDD;text-align: right;width: 15%;">
        @if ($receiptType == 'CASH-ADVANCE')
            {{ $parent->ca_total_receipt_tax ? number_format($parent->ca_total_receipt_tax,2) : '0.00' }} 
        @else
            {{ $parent->total_receipt_tax ? number_format($parent->total_receipt_tax,2) : '0.00' }} 
        @endif
        {{ $parentCurrencyId }}
    </td>
    @if ($parent->currency_id != 'THB')
        <td style="text-align: right;"><strong><small>VAT Amount</small></strong></td>
        <td>
            @if ($receiptType == 'CASH-ADVANCE')
                {{-- {{ $parent->ca_total_receipt_tax ? numberFormatDisplay($parent->ca_total_receipt_tax) : '0.00' }}  --}}
                0.00
            @else
                {{ $parent->total_primary_tax ? numberFormatDisplay($parent->total_primary_tax) : '0.00' }} 
            @endif
            THB
        </td>
    @endif
</tr>
<tr>
    <td><strong><small>Total Amount <small>Inc. VAT</small></small></strong></td>
    <td style="border-bottom: 1px solid #DDDDDD;text-align: right;width: 15%;">
        @if ($receiptType == 'CASH-ADVANCE')
            {{ $parent->ca_total_receipt_amount_inc_tax ? numberFormatDisplay($parent->ca_total_receipt_amount_inc_tax) : '0.00' }} 
        @else
        {{ $parent->total_receipt_amount_inc_tax ? numberFormatDisplay($parent->total_receipt_amount_inc_tax) : '0.00' }} 
        @endif
        {{ $parentCurrencyId }}
    </td>
    @if ($parent->currency_id != 'THB')
        <td style="text-align: right;"><strong><small>Total Amount <small>Inc. VAT</small></small></strong></td>
        <td>
            @if ($receiptType == 'CASH-ADVANCE')
                {{ $parent->ca_total_primary_amount_inc_tax ? numberFormatDisplay($parent->ca_total_primary_amount_inc_tax) : '0.00' }} 
            @else
                {{ $parent->total_primary_amount_inc_tax ? numberFormatDisplay($parent->total_primary_amount_inc_tax) : '0.00' }} 
            @endif
            THB
        </td>
    @endif
</tr>
<tr>
    <td><strong><small>WHT Amount</small></strong></td>
    <td style="border-bottom: 1px solid #DDDDDD;text-align: right;width: 15%;">
        @if ($receiptType == 'CASH-ADVANCE')
            {{ $parent->ca_total_receipt_wht ? numberFormatDisplay($parent->ca_total_receipt_wht) : '0.00' }} 
        @else
            {{ $parent->total_receipt_wht ? numberFormatDisplay($parent->total_receipt_wht) : '0.00' }} 
        @endif
        {{ $parentCurrencyId }}
    </td>
    @if ($parent->currency_id != 'THB')
        <td style="text-align: right;"><strong><small>WHT Amount</small></strong></td>
        <td>
            @if ($receiptType == 'CASH-ADVANCE')
                {{ $parent->ca_total_primary_wht ? numberFormatDisplay($parent->ca_total_primary_wht) : '0.00' }} 
            @else
                {{ $parent->total_primary_wht ? numberFormatDisplay($parent->total_primary_wht) : '0.00' }} 
            @endif
            THB
        </td>
    @endif
</tr>
<tr>
    <td><strong><small>Total Amount</small></strong></td>
    <td style="border-bottom: 1px solid #DDDDDD;text-align: right;width: 15%;">
        @if ($receiptType == 'CASH-ADVANCE')
            {{ $parent->ca_total_receipt_amount ? numberFormatDisplay($parent->ca_total_receipt_amount) : '0.00' }} 
        @else
            {{ $parent->total_receipt_amount ? numberFormatDisplay($parent->total_receipt_amount) : '0.00' }} 
        @endif
        {{ $parentCurrencyId }}
    </td>
    @if ($parent->currency_id != 'THB')
        <td style="text-align: right;"><strong><small>Total Amount</small></strong></td>
        <td>
            @if ($receiptType == 'CASH-ADVANCE')
                {{ $parent->ca_total_primary_amount ? numberFormatDisplay($parent->ca_total_primary_amount) : '0.00' }} 
            @else
                {{ $parent->total_primary_amount ? numberFormatDisplay($parent->total_primary_amount) : '0.00' }} 
            @endif
            THB
        </td>
    @endif
</tr>