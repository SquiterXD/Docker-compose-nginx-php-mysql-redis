{{-- <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">รหัสลูกค้า</th>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">ชื่อย่อธนาคาร</th>
                <th class="text-center">ชื่อธนาคาร</th>
                <th class="text-center"><div style="width: 200px;">สาขา</div></th>
                <th class="text-center">หมายเลขบัญชี</th>
                <th class="text-center">ประเภทบัญชี</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                <th width="17%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($directDebitExports as $directDebitExport)
                <tr>
                    <td>{{ $directDebitExport->customer->customer_number }}</td>
                    <td>{{ $directDebitExport->customer->customer_name }}</td>
                    <td>{{ $directDebitExport->short_bank_name }}</td>
                    <td>{{ $directDebitExport->bank_name }}</td>
                    <td>{{ $directDebitExport->branch_name }}</td>
                    <td>{{ $directDebitExport->account_number }}</td>
                    <td>{{ $directDebitExport->bankAccountType ? $directDebitExport->bankAccountType->description : '' }}</td>
                    <td>
                        {{ $directDebitExport->start_date   ? date(trans('date.format-date'), strtotime($directDebitExport->start_date))   : '' }}
                    </td>
                    <td>
                        {{ $directDebitExport->end_date   ? date(trans('date.format-date'), strtotime($directDebitExport->end_date))   : '' }}
                    </td>
                    <td align="center">
                        <a href="{{ route('om.settings.direct-debit-export.edit', $directDebitExport->direct_debit_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead>
            <tr>
                <th class="text-center">รหัสลูกค้า</th>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">ชื่อย่อธนาคาร</th>
                <th class="text-center">ชื่อธนาคาร</th>
                <th class="text-center">สาขา</th>
                <th class="text-center">หมายเลขบัญชี</th>
                <th class="text-center">ประเภทบัญชี</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)            
                @foreach ($customer->directDebitExports as $directDebitExport)
                    <tr>
                        <td>{{ $directDebitExport->customer->customer_number }}</td>
                        <td>{{ $directDebitExport->customer->customer_name }}</td>
                        <td>{{ $directDebitExport->short_bank_name }}</td>
                        <td>{{ $directDebitExport->bank_name }}</td>
                        <td>{{ $directDebitExport->branch_name }}</td>
                        <td>{{ $directDebitExport->account_number }}</td>
                        <td>{{ $directDebitExport->bankAccountType ? $directDebitExport->bankAccountType->description : '' }}</td>
                        <td>
                            {{ $directDebitExport->start_date   ? date(trans('date.format-date'), strtotime($directDebitExport->start_date))   : '' }}
                        </td>
                        <td>
                            {{ $directDebitExport->end_date   ? date(trans('date.format-date'), strtotime($directDebitExport->end_date))   : '' }}
                        </td>
                        <td align="center">
                            <a href="{{ route('om.settings.direct-debit-export.edit', $directDebitExport->direct_debit_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>