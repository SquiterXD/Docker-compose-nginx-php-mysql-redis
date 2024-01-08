<table class="table invoice-total">
    <tbody>
    <tr>
        <td><strong>Total Amount <small>before VAT</small> :</strong></td>
        <td> 
            {{ count($receipt->lines) > 0 ? numberFormatDisplay($receipt->lines->sum('total_primary_amount')) : '0.00' }} 
            {{ $currencyLists[$parentCurrencyId] }}
        </td>
    </tr>
    <tr>
        <td><strong>VAT Amount:</strong></td>
        <td>
            {{-- {{ count($receipt->lines) > 0 ? numberFormatDisplay($receipt->lines->sum('primary_vat_amount') + $receipt->lines->sum('primary_wht_amount')) : '0.00' }}  --}}

            {{ count($receipt->lines) > 0 ? numberFormatDisplay($receipt->lines->sum('primary_vat_amount')) : '0.00' }} 

            {{ $currencyLists[$parentCurrencyId] }}
        </td>
    </tr>
    <tr>
        <td><strong>Total Amount <small>Inc. VAT :</strong></td>
        <td>
            {{ count($receipt->lines) > 0 ? numberFormatDisplay($receipt->lines->sum('total_primary_amount_inc_vat')) : '0.00' }} 
            {{ $currencyLists[$parentCurrencyId] }}
        </td>
    </tr>
    </tbody>
</table>