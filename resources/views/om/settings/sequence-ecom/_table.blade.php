<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead>
            <tr>
                <th>รหัสผลิตภัณฑ์</th>
                <th>ชื่อตราผลิตภัณฑ์</th>
                <th>ชื่อที่ปรากฏในหน้าจอ E-Commerce</th>
                <th>ชื่อที่ปรากฏในรายงาน</th>
                <th>ประเภทการขาย</th>
                <th>ชนิดผลิตภัณฑ์</th>
                <th class="text-center">ลำดับหน้าจอ</th>
                <th>รสชาติ</th>
                <th class="text-center">ก้นกรอง</th>
                <th>รหัสบัญชีหลัก</th>
                <th>รหัสบัญชีย่อย</th>
                <th>วันที่เริ่มต้น</th>
                <th>วันที่สิ้นสุด</th>
                <th>สินค้าหมด</th>
                <th>สี</th>
                {{-- @if (canEnter('/om/settings/sequence-ecom')) --}}
                    <th></th>
                {{-- @endif --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($ecoms as $ecom)
                <tr>
                    <td>{{ $ecom->item_code }}</td>
                    <td>{{ $ecom->item_description }}</td>
                    <td>{{ $ecom->taste ? $ecom->ecom_item_description : '' }}</td>
                    <td>{{ $ecom->report_item_display }}</td>
                    <td>{{ $ecom->salesType->description }}</td>
                    <td>
                        @if ($ecom->sale_type_code == 'DOMESTIC')
                            {{ $ecom->productTypeDomestic ? $ecom->productTypeDomestic->description : '' }}
                        @else
                            {{ $ecom->productTypeExport ? $ecom->productTypeExport->description : '' }}
                        @endif
                        {{-- {{ $ecom->sale_type_code == 'DOMESTIC' ? $ecom->productTypeDomestic ? $ecom->productTypeDomestic->description : '' : $ecom->productTypeExport ? $ecom->productTypeExport->description : '' }} --}}
                    </td>
                    <td class="text-center">{{ $ecom->screen_number }}</td>
                    <td>{{ $ecom->taste ? $ecom->taste->description : '' }}</td>
                    <td class="text-center">@include('shared._status_active', ['isActive' => $ecom->filter_flag == 'Y'])</td>
                    <td>{{ $ecom->mainAccount ? $ecom->main_account_code. ' : ' . $ecom->mainAccount->description : '' }}</td>
                    <td>{{ $ecom->subAccount  ? $ecom->sub_account_code  . ' : ' . $ecom->subAccount->description : '' }}</td>
                    <td>
                        {{-- {{ $ecom->start_date  ? date(trans('date.format-date'), strtotime($ecom->start_date)) : '' }} --}}
                        {{ $ecom->start_date ? parseToDateTh($ecom->start_date) : '' }}
                    </td>
                    <td>
                        {{-- {{ $ecom->end_date    ? date(trans('date.format-date'), strtotime($ecom->end_date)) : '' }} --}}
                        {{ $ecom->end_date ? parseToDateTh($ecom->end_date) : '' }}
                    </td>
                    <td class="text-center">@include('shared._status_active', ['isActive' => $ecom->attribute1 == 'Y'])</td>
                    <td style="background-color: {{ $ecom->color_code }};"></td>
                    {{-- @if (canEnter('/om/settings/sequence-ecom')) --}}
                        <td align="center">
                            <a href="{{ route('om.settings.sequence-ecom.edit', $ecom->sequence_ecom_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    {{-- @endif --}}
                </tr>
            @empty
                <tr>
                    <th colspan="14" class="text-center">No Data</th>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $ecoms->withQueryString()->links() }}
</div>