<table class="table table-mini-padding m-b-xs table-hover" style="font-size: 0.95em;">
    <thead>
    <tr>
        <th width="3%">
        </th>
        <th width="28%">
            <div>Description</div>
            <div><small>รายละเอียด</small></div>
        </th>
        {{-- <th width="11%">
            <div>Branch</div>
            <div><small>ค่าใช้จ่ายของสาขา</small></div>
        </th> --}}
        {{-- <th width="10%" class="hidden-xs">
            <div>Department</div>
            <div><small>ค่าใช้จ่ายของแผนก</small></div>
        </th> --}}
        <th width="8%" class="text-right hidden-sm hidden-xs" style="padding-left: 0px !important;">
            <div>Quantity</div>
            <div><small>จำนวน</small></div>
        </th>
        <th width="11%" class="text-right hidden-sm hidden-xs" style="padding-left: 0px !important;">
            <div>Amount <small>before VAT</small></div>
            <div><small>ยอดเงินไม่รวมภาษี</small></div>
        </th>
        <th width="8%" class="text-right hidden-sm hidden-xs" style="padding-left: 0px !important;">
            <div>VAT Code</div>
            <div><small>รหัสภาษีมูลค่าเพิ่ม</small></div>
        </th>
        <th width="8%" class="text-right hidden-sm hidden-xs" style="padding-left: 0px !important;">
            <div>VAT Amount</div>
            <div><small>ภาษีมูลค่าเพิ่ม</small></div>
        </th>
        <th width="8%" class="text-right hidden-sm hidden-xs" style="padding-left: 0px !important;">
            <div>WHT Code</div>
            <div><small>รหัสภาษีหัก ณ ที่จ่าย</small></div>
        </th>
        <th width="10%" class="text-right" style="padding-right: 2px !important;">
            <div>Amount <small>Inc. VAT</small></div>
            <div><small>ยอดเงินรวมภาษี</small></div>
        </th>
        <th width="2%" style="padding-left: 2px !important;"></th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @include('ie.commons.receipts.lines._table_rows')
    </tbody>
</table>