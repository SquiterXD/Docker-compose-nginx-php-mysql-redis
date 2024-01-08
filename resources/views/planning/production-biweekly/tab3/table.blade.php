<div class="table-responsive m-t mb-3">
    <h2 class="mb-1 text-center">สรุปประมาณการผลิต</h2>

    <table class="table text-nowrap table-bordered" border="1">
        <thead>
            <tr>
                @foreach ($plans as $plan)
                    <th colspan="2" class="text-center">
                        {{ $plan->meaning }}
                        @if ($plan->lookup_code == 'KK')
                            Acetate
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>คงคลัง{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ปัจจุบัน</td>
                    <td class="text-right">
                        {{ optional($data)->sumcurr_curr_onhnad_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>
                        ประมาณการ{{ $plan->lookup_code == 'KK'? 'ใช้':'จำหน่าย' }}ถึงสิ้นปักษ์
                        <span class="pull-right label label-default">
                        {{ $main->current_biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->sumcurr_forcast_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>
                        ประมาณการผลิต{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ถึงสิ้นปักษ์
                        <span class="pull-right label label-default">
                        {{ $main->current_biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->sumcurr_planning_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td title="(คงคลังปัจจุบัน + ประมาณการผลิต) - ประมาณการขาย">
                        คงคลัง{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ต้นปักษ์
                        <span class="pull-right label label-default">
                        {{ $main->biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->first_onhand_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>
                        สั่งผลิต{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ปักษ์
                        <span class="pull-right label label-default">
                            {{ $main->biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->efficiency_product_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>คาดว่าจะผลิต{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ได้</td>
                    <td class="text-right">
                        {{ optional($data)->sumplan_planning_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td>
                        ประมาณการ{{ $plan->lookup_code == 'KK'? 'ใช้':'จำหน่าย' }}รายปักษ์
                        <span class="pull-right label label-default">
                            {{ $main->biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->sumplan_forcast_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td title="(คงคลังต้นปักษ์ + คาดว่าจะได้ผลิต) - ประมาณการขาย">
                        คงคลัง{{ $plan->lookup_code == 'KK'? 'ก้นกรอง':'บุหรี่' }}ต้นปักษ์ถัดไป
                        <span class="pull-right label label-default">
                            {{ $main->next_biweekly }}
                        </span>
                    </td>
                    <td class="text-right">
                        {{ optional($data)->next_onhand_qty_format }}
                        ล้าน{{ $plan->lookup_code == 'KK'? 'ชิ้น':'มวน' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($plans as $plan)
                @php
                    $data = $tab31->where('product_plan_id', $plan->product_plan_id)->first();
                @endphp
                    <td title="คงคลังต้นปักษ์ถัดไป / ค่าเฉลี่ยขายย้อนหลัง 10 วัน">
                        คาดว่าจะมีคงคลังพอ{{ $plan->lookup_code == 'KK'? 'ใช้':'จำหน่าย' }}ประมาณ
                    </td>
                    <td class="text-right">
                        {{ optional($data)->onhand_qty_for_sale_format }}
                        {{ $plan->lookup_code == 'KK'? 'ล้านชิ้น':'วัน' }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

@if ($tab32)
<div class="table-responsive m-t mt-1">
    <h2 class="mb-1 text-center">ประมาณค่าใช้จ่ายล่วงเวลา</h2>
    <table class="table text-nowrap table-bordered" border="1">
        <thead>
            <tr>
                <th>หน่วยงาน</th>
                <th>ประเภทพนักงาน</th>
                <th>อัตราค่าใช้จ่ายต่อชั่วโมงล่วงเวลา (บาท)</th>
                <th>ชั่วโมงล่วงเวลา (ชั่วโมง)</th>
                <th>รวมเป็นค่าใช้จ่าย (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tab32 as $departmentCode => $dept)
            <tr>
                <td rowspan="{{ count($dept) }}">{{ $dept->first()->department_desc }}</td>
                @foreach ($dept as $empType)
                    <td>
                        {{ $empType->employee_type_desc }}
                    </td>
                    <td class="text-right">
                        {{ $empType->default_exp_amount_format }}
                    </td>
                    <td class="text-right">
                        {{ $empType->ot_hour_format }}
                    </td>
                    <td class="text-right">
                        {{ $empType->expense_amount_format }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="2" class="text-right">รวม</th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($dept, 'default_exp_amount') }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($dept, 'ot_hour') }}
                    </th>
                    <th  style="background-color: #34d399;" class="text-right text-white">
                        {{ getSumFormat($dept, 'expense_amount') }}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
