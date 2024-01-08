<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    <div style="width: 80px;">ช่วงหีบ</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">กองบริหารขาย</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ตำแหน่ง</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ผู้เรียนพิจารณา 1</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ตำแหน่ง</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ผู้เรียนพิจารณา 2</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ตำแหน่ง</div>
                </th>
                <th class="text-center">
                    <div style="width: 150px;">ผู้มีอำนาจอนุมัติ</div>
                </th>
                <th class="text-center">
                    <div style="width: 180px;">ตำแหน่ง</div>
                </th>
                <th class="text-center">
                    <div style="width: 100px;">วันที่เริ่มต้น</div>
                </th>
                <th class="text-center">
                    <div style="width: 100px;">วันที่สิ้นสุด</div>
                </th>
                @if (canEnter('/om/settings/over-quota-approval'))
                    <th><div style="width: 100px;"></div></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($overQuotaApprovals as $overQuotaApproval)
                <tr>
                    <td class="text-right">
                        {{ $overQuotaApproval->cbb_range_from . ' - ' . $overQuotaApproval->cbb_range_to }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->salesDivision ? $overQuotaApproval->salesDivision->employee_name : '' }}
                    </td>
                    <td>
                        {{-- {{ $overQuotaApproval->salesDivision ? $overQuotaApproval->salesDivision->position_name : '' }} --}}
                        {{ $overQuotaApproval->sales_division_additional ? $overQuotaApproval->sales_division_additional : '' }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->authority1 ? $overQuotaApproval->authority1->employee_name : '' }}
                    </td>
                    <td>
                        {{-- {{ $overQuotaApproval->authority1 ? $overQuotaApproval->authority1->position_name : '' }} --}}
                        {{ $overQuotaApproval->authority_id1_additional ? $overQuotaApproval->authority_id1_additional : '' }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->authority2 ? $overQuotaApproval->authority2->employee_name : '' }}
                    </td>
                    <td>
                        {{-- {{ $overQuotaApproval->authority2 ? $overQuotaApproval->authority2->position_name : '' }} --}}
                        {{ $overQuotaApproval->authority_id2_additional ? $overQuotaApproval->authority_id2_additional : '' }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->authority3 ? $overQuotaApproval->authority3->employee_name : '' }}
                    </td>
                    <td>
                        {{-- {{ $overQuotaApproval->authority3 ? $overQuotaApproval->authority3->position_name : '' }} --}}
                        {{ $overQuotaApproval->authority_id3_additional ? $overQuotaApproval->authority_id3_additional : '' }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->start_date ? parseToDateTh($overQuotaApproval->start_date) : '' }}
                    </td>
                    <td>
                        {{ $overQuotaApproval->end_date   ? parseToDateTh($overQuotaApproval->end_date) : '' }}
                    </td>
                    @if (canEnter('/om/settings/over-quota-approval'))
                        <td  align="center">
                            <a href="{{ route('om.settings.over-quota-approval.edit', $overQuotaApproval->over_quota_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
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
    {{ $overQuotaApprovals->links() }}
</div>