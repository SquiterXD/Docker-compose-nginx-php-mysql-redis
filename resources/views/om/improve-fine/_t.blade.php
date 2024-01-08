<div>
    {!! Form::open(['route' => ['om.improve-fine.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
        <div class="col-12 text-right mb-2">
            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
        </div>
        <div class="table-responsive">
            <table class="table text-nowrap table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">งวด</th>
                    <th class="text-center">รหัสลูกค้า</th>
                    <th class="text-center">ชื่อลูกค้า</th>
                    <th class="text-center">เลขที่ Invoice</th>
                    <th class="text-center">จำนวนเงิน Invoice</th>
                    <th class="text-center">ยอดค้างชำระ</th>
                    <th class="text-center">วันที่สั่งซื้อ</th>
                    <th class="text-center">วันที่ Invoice</th>
                    <th class="text-center">วันที่ครบกำหนดชำระ</th>
                    <th class="text-center">กลุ่มวงเงิน</th>
                    <th class="text-center">จำนวนวันปลอดดอก</th>
                    <th class="text-center">ค่าปรับสะสม</th>
                    <th class="text-center">ค่าปรับถึงวันที่สิ้นสุดการคำนวณ</th>
                    <th class="text-center">วงเงินเชื่อที่เหลืออยู่</th>
                    <th class="text-center">โควต้าที่มีสิทธิ์ใช้(พันมวน)</th>
                    <th class="text-center">ยกเลิก</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($dataLists as $list)
                        @if ($checkFineFlag)
                            @if (calFineFixDateTest($list, $totalFineDue) > 0)
                                <tr>
                                    <td align="center">{{ $list->period_no }}</td>
                                    <td>{{ $list->customer_number }}</td>
                                    <td>{{ $list->customer_name }}</td>
                                    <td>{{ $list->customer_type_id == 40 ? $list->consignment_no  : $list->pick_release_no }}</td>
                                    <td align="right">{{ number_format($list->invoice_amount, 2) }}</td>
                                    <td align="right">{{ number_format($list->outstanding_debt, 2) }}</td>
                                    <td align="center">{{ $list->order_date ? parseToDateTh($list->order_date) : '' }}</td>
                                    <td align="center">
                                        @if ($list->customer_type_id == 40)
                                            {{ $list->consignment_date ? parseToDateTh($list->consignment_date) : '' }}
                                        @else
                                            {{ $list->pick_release_approve_date ? parseToDateTh($list->pick_release_approve_date) : '' }}
                                        @endif
                                    </td>
                                    {{-- <td align="center">{{ $list->pick_release_approve_date ? parseToDateTh($list->pick_release_approve_date) : '' }}</td> --}}
                                    <td align="center">{{ $list->due_date ? parseToDateTh($list->due_date) : '' }}</td>
                                    <td align="center">
                                        {{ $list->credit_group_code == '0' ? 'สด' : $list->credit_group_code }}
                                    </td>
                                    <td align="center">{{ $list->due_days }}</td>
                                    {{-- <td align="right">{{ number_format(calFine($list), 2) }}</td>
                                    <td align="right">{{ number_format(calFinefFxDate($list, $totalFineDue), 2) }}</td> --}}
                                    <td align="right">{{ number_format(calFineTest($list), 2) }}</td>
                                    <td align="right">{{ number_format(calFineFixDateTest($list, $totalFineDue), 2) }}</td>
                                    <td align="right">{{ number_format($list->remaining_amount, 2) }}</td>
                                    <td align="right">{{ number_format($list->sum_received_quota, 2) }}</td>
                                    <input type="hidden" name="total_fine" value="{{ calFineTest($list) }}">
                                    <input type="hidden" name="total_fine_due" value="{{ calFineFixDateTest($list, $totalFineDue) }}">
                                    {{-- <td align="center"><input type="checkbox" name="cancel_flag[{{ $list->order_header_id }}]"></td> --}}
                                    <td align="center">
                                        <input type="checkbox" name="cancel_flag[{{ $list->order_header_id }}-{{ $list->credit_group_code }}]" {{ checkCancel($list) ? 'disabled' : ''}} {{ checkCancel($list) ? 'checked' : ''}}>
                                    </td>
                                </tr>
                            @endif
                            
                        @else
                            <tr>
                                <td align="center">{{ $list->period_no }}</td>
                                <td>{{ $list->customer_number }}</td>
                                <td>{{ $list->customer_name }}</td>
                                <td>{{ $list->customer_type_id == 40 ? $list->consignment_no  : $list->pick_release_no }}</td>
                                <td align="right">{{ number_format($list->invoice_amount, 2) }}</td>
                                <td align="right">{{ number_format($list->outstanding_debt, 2) }}</td>
                                <td align="center">{{ $list->order_date ? parseToDateTh($list->order_date) : '' }}</td>
                                <td align="center">
                                    @if ($list->customer_type_id == 40)
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
                                {{-- <td align="right">{{ number_format(calFine($list), 2) }}</td>
                                <td align="right">{{ number_format(calFinefFxDate($list, $totalFineDue), 2) }}</td> --}}
                                <td align="right">{{ number_format(calFineTest($list), 2) }}</td>
                                <td align="right">{{ number_format(calFineFixDateTest($list, $totalFineDue), 2) }}</td>
                                <td align="right">{{ number_format($list->remaining_amount, 2) }}</td>
                                <td align="right">{{ number_format($list->sum_received_quota, 2) }}</td>
                                <input type="hidden" name="total_fine" value="{{ calFineTest($list) }}">
                                <input type="hidden" name="total_fine_due" value="{{ calFineFixDateTest($list, $totalFineDue) }}">
                                <td align="center">
                                    {{-- {{ checkCancel($list) }} --}}
                                    <input type="checkbox" name="cancel_flag[{{ $list->order_header_id }}-{{ $list->credit_group_code }}]" {{ checkCancel($list) ? 'disabled' : ''}} {{ checkCancel($list) ? 'checked' : ''}}>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    {{-- <div class="d-flex justify-content-center">
        {{ $dataLists->links() }}
    </div> --}}
    {!! Form::close() !!}
</div>
