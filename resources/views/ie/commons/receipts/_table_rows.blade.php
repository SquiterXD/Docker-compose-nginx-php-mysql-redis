@if(count($receipts) > 0)
    @foreach($receipts as $receipt)
    <tr style="background-color:#e6e6e6;">
        <td>
            <a style="margin-right: 5px"
                class="receipt-collapse-row"
                data-receipt="{{ $receipt->receipt_id }}">
                <i class="fa fa-caret-down"></i>
            </a>
        </td>
        <td>{{ $receipt->receipt_number ? $receipt->receipt_number : '-'  }}</td>
        <td class="hidden-sm hidden-xs">{{ $receipt->receipt_date ? dateFormatDisplay($receipt->receipt_date) : '-' }}</td>
        <td class="hidden-xs">
            {{ $receipt->vendor_id 
                ? ($receipt->vendor_id == 'other' 
                        ? $receipt->vendor_name 
                        : ($receipt->vendor->vendor_no.' : '.$receipt->vendor->vendor_name)) 
                : 'None' }}
        </td>
        <td class="hidden-xs">
            {{ $receipt->vendor_site_code ?? 'None' }}
        </td>
        {{-- <td>{{ $receipt->recharge ? $rechargeLists[$receipt->recharge] : '-' }}</td> --}}
        <td class="text-right"> 
            <div id="div_td_receipt_amount_{{ $receipt->receipt_id }}">
            {{ count($receipt->lines) > 0 ? numberFormatDisplay($receipt->lines->sum('total_amount_inc_vat')) : '0.00' }}<br class="show-xs-only"><small class="texts-muted"> {{ $parentCurrencyId }}</small>
            </div>
        </td>
        <td class="text-right">
            {{-- RECEIPT BUTTON --}}
            @include('ie.commons.receipts._btn')
        </td>
    </tr>
    <tr style="border-style: none;" id="tr_{{ $receipt->receipt_id }}">
        <td colspan="1" style="font-size: 0.9em;padding-top: 0px;"></td>
        <td colspan="6" style="font-size: 0.9em;padding-top: 0px;">
            {{-- RECEIPT LINES TABLE --}}
            @include('ie.commons.receipts.lines._table',['removable'=>true])
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="7">
            <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">
                Not Found Receipt.
            </h2>
        </td>
    </tr>
@endif