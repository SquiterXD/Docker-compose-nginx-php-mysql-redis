{{-- <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    <div style="width: 80px;">รหัสลูกค้า</div>
                </th>
                <th class="text-center">
                    <div style="width: 200px;">ชื่อลูกค้า</div>
                </th>
                <th class="text-center"><div style="width: 80px;">ชื่อย่อธนาคาร</div></th>
                <th class="text-center"><div style="width: 200px;">ชื่อธนาคาร</div></th>
                <th class="text-center"><div style="width: 200px;">สาขา</div></th>
                <th class="text-center"><div style="width: 120px;">หมายเลขบัญชี</div></th>
                <th class="text-center"><div style="width: 170px;">ประเภทบัญชี</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่เริ่มต้น</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่สิ้นสุด</div></th>
                @if (canEnter('/om/settings/direct-debit-domestic'))
                    <th><div style="width: 70px;"></div></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($directDebitDomestics as $directDebitDomestic)
                <tr>
                    <td>{{ $directDebitDomestic->customer->customer_number }}</td>
                    <td>{{ $directDebitDomestic->customer->customer_name }}</td>
                    <td>{{ $directDebitDomestic->short_bank_name }}</td>
                    <td>{{ $directDebitDomestic->bank_name }}</td>
                    <td>{{ $directDebitDomestic->branch_name }}</td>
                    <td>{{ $directDebitDomestic->account_number }}</td>
                    <td>{{ $directDebitDomestic->bankAccountType ? $directDebitDomestic->bankAccountType->description : '' }}</td>
                    <td>
                        {{ $directDebitDomestic->start_date ? parseToDateTh($directDebitDomestic->start_date) : '' }}
                    </td>
                    <td>
                        {{ $directDebitDomestic->end_date   ? parseToDateTh($directDebitDomestic->end_date)   : '' }}
                    </td>
                    @if (canEnter('/om/settings/direct-debit-domestic'))
                        <td align="center">
                            <a href="{{ route('om.settings.direct-debit-domestic.edit', $directDebitDomestic->direct_debit_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $directDebitDomestics->links() }}
</div> --}}


<div class="table-responsive mt-2">
    <table class="table text-nowrap table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    <div style="width: 80px;">รหัสลูกค้า</div>
                </th>
                <th class="text-center">
                    <div style="width: 200px;">ชื่อลูกค้า</div>
                </th>
                <th class="text-center"><div style="width: 80px;">ชื่อย่อธนาคาร</div></th>
                <th class="text-center"><div style="width: 200px;">ชื่อธนาคาร</div></th>
                <th class="text-center"><div style="width: 200px;">สาขา</div></th>
                <th class="text-center"><div style="width: 120px;">หมายเลขบัญชี</div></th>
                <th class="text-center"><div style="width: 170px;">ประเภทบัญชี</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่เริ่มต้น</div></th>
                <th class="text-center"><div style="width: 80px;">วันที่สิ้นสุด</div></th>
                @if (canEnter('/om/settings/direct-debit-domestic'))
                    <th><div style="width: 70px;"></div></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                @foreach ($customer->directDebitDomestics as $directDebitDomestic)
                    <tr>
                        <td>{{ $directDebitDomestic->customer->customer_number }}</td>
                        <td>{{ $directDebitDomestic->customer->customer_name }}</td>
                        <td>{{ $directDebitDomestic->short_bank_name }}</td>
                        <td>{{ $directDebitDomestic->bank_name }}</td>
                        <td>{{ $directDebitDomestic->branch_name }}</td>
                        <td>{{ $directDebitDomestic->account_number }}</td>
                        <td>{{ $directDebitDomestic->bankAccountType ? $directDebitDomestic->bankAccountType->description : '' }}</td>
                        <td>
                            {{ $directDebitDomestic->start_date ? parseToDateTh($directDebitDomestic->start_date) : '' }}
                        </td>
                        <td>
                            {{ $directDebitDomestic->end_date   ? parseToDateTh($directDebitDomestic->end_date)   : '' }}
                        </td>
                        @if (canEnter('/om/settings/direct-debit-domestic'))
                            <td align="center">
                                <a href="{{ route('om.settings.direct-debit-domestic.edit', $directDebitDomestic->direct_debit_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                    <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $customers->links() }}
</div>