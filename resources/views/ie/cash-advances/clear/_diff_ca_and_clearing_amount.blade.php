<h1 class="no-margins">
    @if($diffCAAndClearingData['type'] == 'paybacktocompany')
        <small class="text-warning text-left pull-left">
            <span style="font-size: 0.6em;font-weight:700;">
            payback to company</span><br/> 
            <span style="font-size: 0.5em;font-weight:700;">
            ชำระเงินคืนทั้งสิ้น</span>
        </small>
    @elseif($diffCAAndClearingData['type'] == 'paybacktorequester')
        <small class="text-warning text-left pull-left">
            <span style="font-size: 0.6em;font-weight:700;">
            payback to requester</span><br/> 
            <span style="font-size: 0.5em;font-weight:700;">
            ชำระเงินแก่ผู้ขอเบิก</span>
        </small>
    @endif
    {{ number_format($diffCAAndClearingData['amount'],2) }}
</h1>
<small>{{ $cashAdvance->currency_id }}</small>