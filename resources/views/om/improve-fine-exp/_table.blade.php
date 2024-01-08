<div>
    {!! Form::open(['route' => ['om.improve-fine-exp.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
        <div class="col-12 text-right mb-2">
            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
        </div>
        <div class="table-responsive">
            <table class="table text-nowrap table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">รหัสลูกค้า</th>
                    <th class="text-center" style="vertical-align: middle;">ชื่อลูกค้า</th>
                    <th class="text-center" style="vertical-align: middle;">เลขที่ใบสั่งซื้อ</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่สั่งซื้อ</th>
                    <th class="text-center" style="vertical-align: middle;">เลขที่ใบ SA</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่ใบ SA</th>
                    <th class="text-center" style="vertical-align: middle;">เลขที่ใบ PI</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่ใบ PI</th>
                    <th class="text-center" style="vertical-align: middle;">เลขที่ใบ Invoice</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่ Invoice</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่ส่ง</th>
                    <th class="text-center" style="vertical-align: middle;">วันที่ครบกำหนดชำระ</th>
                    <th class="text-center" style="vertical-align: middle;">จำนวนวันปลอดดอก</th>
                    <th class="text-center" style="vertical-align: middle;">ประเภทการจ่ายเงิน</th>
                    <th class="text-center" style="vertical-align: middle;">หนี้ค้างชำระ</th>
                    <th class="text-center" style="vertical-align: middle;">ค่าปรับสะสม</th>
                    <th class="text-center" style="vertical-align: middle;">ค่าปรับถึงวันที่สิ้นสุดการคำนวณ</th>
                    <th class="text-center" style="vertical-align: middle;">ยกเลิก</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($dataLists as $list)
                    {{-- {{dd(calFineExpFixDate($list, $totalFineDue))}} --}}
                        <tr>
                            {{-- <td>{{calFineExpFixDate($list, $totalFineDue)}}</td> --}}
                            <td>{{ $list->customer_number }}</td>
                            <td>{{ $list->customer_name }}</td>
                            <td>{{ $list->order_number }}</td>
                            <td align="center">{{ $list->order_date ? date(trans('date.format'), strtotime($list->order_date)) : '' }}</td>
                            <td>{{ $list->sa_number }}</td>
                            <td>{{ $list->sa_date ? date(trans('date.format'), strtotime($list->sa_date)) : '' }}</td>
                            <td>{{ $list->pi_number }}</td>
                            <td>{{ $list->pi_date ? date(trans('date.format'), strtotime($list->pi_date)) : '' }}</td>
                            <td>{{ $list->pick_release_no }}</td>
                            <td>{{ $list->pick_release_approve_date ? date(trans('date.format'), strtotime($list->pick_release_approve_date)) : '' }}</td>
                            <td align="center">{{ $list->delivery_date ? date(trans('date.format'), strtotime($list->delivery_date)) : '' }}</td>
                            <td align="center">{{ $list->due_date ? date(trans('date.format'), strtotime($list->due_date)) : '' }}</td>
                            <td align="center">{{ $list->due_days }}</td>
                            <td align="center">{{ $list->payment_type }}</td>
                            <td align="right">{{ number_format($list->outstanding_debt, 2) }}</td>	
                            <td align="right">{{ checkCancelExp($list) ? '0.00' : number_format(calFineExp($list), 2) }}</td>
                            <td align="right">{{ checkCancelExp($list) ? '0.00' : number_format(calFineExpFixDate($list, $totalFineDue), 2) }}</td>
                            <td align="center">
                                <input type="hidden" name="total_fine[{{ $list->order_header_id }}-{{ $list->pick_release_no }}]" value="{{ calFineExp($list) }}">
                                <input type="hidden" name="total_fine_due[{{ $list->order_header_id }}-{{ $list->pick_release_no }}]" value="{{ calFineExpFixDate($list, $totalFineDue) }}">
                                <input type="checkbox" name="cancel_flag[{{ $list->order_header_id }}-{{ $list->pick_release_no }}]" {{ checkCancelExp($list) ? 'disabled' : ''}} {{ checkCancelExp($list) ? 'checked' : ''}}>
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