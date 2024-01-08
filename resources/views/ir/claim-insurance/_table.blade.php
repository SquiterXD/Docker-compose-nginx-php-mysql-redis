<div class="table-responsive table_style_scroll table_style">
    <table class="table table-bordered tb-claim" style="width: auto; max-height: 540px; display: block;">
        <thead>
            <tr>
                <th width="3%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div>Status</div>
                    <div><small>สถานะรายการ</small></div>
                </th>
                <th width="10%" class="text-center" style="position: sticky; top: 0;">
                    <div> Document# </div>
                    <div><small>เลขที่เอกสาร</small></div>
                </th>
                @if ($profile->program_code == 'IRP0011')
                    <th width="10%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                        <div> Reference# </div>
                        <div><small>เลขที่อ้างอิง</small></div>
                    </th>
                @endif
                <th width="5%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Year </div>
                    <div><small>ปี</small></div>
                </th>
                <th width="10%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Date-Time </div>
                    <div><small>วัน-เวลาเกิดเหตุ</small></div>
                </th>
                <th width="20%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Title </div>
                    <div><small>หัวข้อการเกิดเหตุ</small></div>
                </th>
                <th width="20%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Insurance Status </div>
                    <div><small>สถานะปัจจุบัน</small></div>
                </th>
                <th width="10%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Department </div>
                    <div><small>หน่วยงานผู้แจ้งเหตุ</small></div>
                </th>
                <th width="10%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Requestor </div>
                    <div><small>ผู้แจ้งเหตุ</small></div>
                </th>
                <th width="20%" class="hidden-sm hidden-xs text-center" style="position: sticky; top: 0;">
                    <div> Estimate Amount </div>
                    <div><small>จำนวนเงินเรียกชดใช้<br>โดยประมาณ</small></div>
                </th>
                <th class="hidden-sm hidden-xs text-center" width="3%" style="vertical-align: middle; position: sticky; top: 0;"> Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($claims as $claim)
            <tr>
                <td class="text-center" style="vertical-align: middle;"> {{ $profile->program_code == 'IRP0010'? $claim->status: $claim->irp0011_status }} </td>
                <td class="text-center" style="vertical-align: middle;"> {{ $claim->document_number }} </td>
                @if ($profile->program_code == 'IRP0011')
                    <td class="text-center" style="vertical-align: middle;"> {{ $claim->reference_document_number  }} </td>
                @endif
                <td class="text-center" style="vertical-align: middle;"> {{ $claim->year+543  }} </td>
                <td class="text-center" style="vertical-align: middle;">
                    {{ parseToDateTh($claim->accident_date) }} {{ date('H:i', strtotime($claim->accident_time)) }}
                </td>
                <td class="text-left" style="vertical-align: middle;"> {{ $claim->claim_title }} </td>
                <td class="text-left" style="vertical-align: middle;">
                    {{ $profile->program_code == 'IRP0010'? $claim->insurance_status: $claim->irp0011_insurance_status }}
                </td>
                <td class="text-center" style="vertical-align: middle;"> {{ $claim->department_name }} </td>
                <td class="text-left" style="vertical-align: middle;">
                    {{ $claim->requestor_name }}
                    <div><small> <strong>Tel.: </strong> {{ $claim->requestor_tel }} </small></div>
                </td>
                <td class="text-right" style="vertical-align: middle;"> {{ number_format($claim->claim_amount, 2) }} </td>
                <td class="text-center" style="vertical-align: middle;">
                    @if ($profile->program_code == 'IRP0010')
                        <a href="{{ route('ir.claim-insurance.edit', $claim->claim_header_id) }}" class="{{ trans('btn.edit.class') }} btn-xs tw-w-25">
                            <i class="{{ trans('btn.edit.icon') }}"></i> {{ trans('btn.edit.text') }}
                        </a>
                    @else
                        <a href="{{ route('ir.claim-accounting.edit', $claim->claim_header_id) }}" class="{{ trans('btn.edit.class') }} btn-xs tw-w-25">
                            <i class="{{ trans('btn.edit.icon') }}"></i> {{ trans('btn.edit.text') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
