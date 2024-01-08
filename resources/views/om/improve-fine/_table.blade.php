<div>
    {!! Form::open(['route' => ['om.improve-fine.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
        <div class="col-12 text-right mb-2">
            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
        </div>
        <div class="table-responsive">
            <table class="table text-nowrap table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">งวด</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">รหัสลูกค้า</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">ชื่อลูกค้า</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">เลขที่เตรียมใบขาย</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">เลขที่ Invoice</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">จำนวนเงิน Invoice</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">ยอดค้างชำระ</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">วันที่สั่งซื้อ</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">วันที่ส่ง</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">วันที่ Invoice</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">วันที่ครบกำหนดชำระ</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">กลุ่มวงเงิน</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">จำนวนวันปลอดดอก</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">ค่าปรับสะสม</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">ค่าปรับถึงวันที่สิ้นสุดการคำนวณ</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2">วงเงินเชื่อที่เหลืออยู่</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">โควต้าที่มีสิทธิ์ใช้(พันมวน)</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">ยกเลิก</th>
                </tr>
                <tr>
                    <th class="text-center">เงินเชื่อกลุ่ม 2</th>
                    <th class="text-center">เงินเชื่อกลุ่ม 3</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($dataLists as $list)
                        <tr>
                            <td align="center">{{ $list->period_no }}</td>
                            <td>{{ $list->customer_number }}</td>
                            <td>{{ $list->customer_name }}</td>
                            <td>{{ $list->prepare_order_number }}</td>
                            <td>{{ $list->customer_type_id == 40 || $list->customer_type_id == 30 && $list->product_type_code == 10 ? $list->consignment_no  : $list->pick_release_no }}</td>
                            <td align="right">{{ number_format($list->invoice_amount, 2) }}</td>
                            <td align="right">{{ number_format($list->outstanding_debt, 2) }}</td>
                            <td align="center">{{ $list->order_date ? parseToDateTh($list->order_date) : '' }}</td>
                            <td align="center">{{ $list->delivery_date ? parseToDateTh($list->delivery_date) : '' }}</td>
                            <td align="center">
                                @if ($list->customer_type_id == 40 || $list->customer_type_id == 30 && $list->product_type_code == 10)
                                    {{ $list->consignment_date ? parseToDateTh($list->consignment_date) : '' }}
                                @else
                                    {{ $list->pick_release_approve_date ? parseToDateTh($list->pick_release_approve_date) : '' }}
                                @endif
                            </td>
                            <td align="center">{{ $list->due_date ? parseToDateTh($list->due_date) : '' }}</td>
                            <td align="center">
                                {{ $list->credit_group_code == '0' ? 'สด' : $list->credit_group_code }}
                            </td>
                            <td align="center">{{ $list->due_days }}</td>
                            <td align="right">{{ checkCancel($list) ? '0.00' : number_format(calFine($list), 2) }}</td>
                            <td align="right">{{ checkCancel($list) ? '0.00' : number_format(calFineFixDate($list, $totalFineDue), 2) }}</td>
                            {{-- <td align="right">{{ number_format($list->remaining_amount, 2) }}</td> --}}
                            <td align="right">{{ number_format($list->remaining_amount2, 2) }}</td>
                            <td align="right">{{ number_format($list->remaining_amount3, 2) }}</td>
                            <td align="right">{{ number_format($list->sum_received_quota, 2) }}</td>
                            <input type="hidden" name="total_fine" value="{{ calFine($list) }}">
                            <input type="hidden" name="total_fine_due" value="{{ calFineFixDate($list, $totalFineDue) }}">
                            <td align="center">
                                @php
                                    if ($list->customer_type_id == 40 || $list->customer_type_id == 30 && $list->product_type_code == 10) {
                                        $invoice = $list->consignment_no;
                                    } else {
                                        $invoice = $list->order_header_id;
                                    }
                                @endphp
                                <input type="checkbox" name="cancel_flag[{{ $list->customer_type_id }}-{{ $list->product_type_code }}-{{ $invoice }}-{{ $list->credit_group_code }}]" {{ checkCancel($list) ? 'disabled' : ''}} {{ checkCancel($list) ? 'checked' : ''}}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $dataLists->withQueryString()->links() }} 
        </div>
    {!! Form::close() !!}
</div>
