<div class="mt-3">
    <div class="table-responsive">
        <table class="table text-nowrap table-bordered">
            <thead>
            <tr>
                <th class="text-center">รหัสลูกค้า</th>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">ประเภทลูกค้า</th>
                <th class="text-center">วันส่งประจำสัปดาห์</th>
                <th class="text-center">เลขที่ใบสั่งซื้อ</th>
                <th class="text-center">เลขที่ใบเตรียมขาย</th>
                <th class="text-center">เลขที่ Invoice</th>
                <th class="text-center">กลุ่มเงินเชื่อ</th>
                <th class="text-center">จำนวนวันปลอดดอก</th>
                <th class="text-center">ยอดรวม</th>
                <th class="text-center">ยอดหนี้คงเหลือ</th>
                <th class="text-center">ค่าปรับ</th>
                <th class="text-center">วันที่ครบกำหนดชำระ</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($dataLists as $list)         
                    <tr>
                        @php
                            if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
                                // $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();
                                $header =  App\Models\OM\ConsignmentHeaders::where('consignment_no', $list->consignment_no)->first();
      
                                $amount = $header ? $header->total_include_vat : '';
                            } else {
                                $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();
                
                
                                if ($header->payment_type_code == 10) {
                                    $amount = $header->grand_total;
                                } else {
                                    $orderCredit = App\Models\OM\OrderCreditGroups::where('order_header_id', $list->order_header_id)
                                                                            ->where('credit_group_code', $list->credit_group_code)
                                                                            ->where('order_line_id', 0)->first();

                                    $amount = $orderCredit->amount;
                                }
                            }
            
                        @endphp
                        <td>{{ $list->customer_number }}</td>
                        <td>{{ $list->customer_name }}</td>
                        <td>{{ $list->customer_type }}</td>
                        <td>{{ $list->weekly_delivery_day }}</td>
                        <td>{{ $list->order_number }}</td>
                        <td>{{ $list->prepare_order_number }}</td>
                        <td>{{ $list->customer_type_id == 30 || $list->customer_type_id == 40 ? $list->consignment_no : $list->pick_release_no }}</td>
                        <td align="center">
                            {{ $list->credit_group_code == '0' ? 'สด' : $list->credit_group_code }}
                        </td>
                        <td align="center">{{ $list->due_days }}</td>
                        <td align="right">{{ $amount ? number_format($amount, 2) : '0.00' }}</td>
                        <td align="right">{{ number_format($list->outstanding_debt, 2)}}</td>
                        <td align="right">{{ checkCancelOutstanding($list) ? '0.00' : number_format(calFine($list), 2) }}</td>
                        <td align="center">{{ $list->due_date ? parseToDateTh($list->due_date) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $dataLists->withQueryString()->links() }} 
    </div>
</div>
    