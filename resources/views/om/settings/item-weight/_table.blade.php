<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead>
            {{-- <tr>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">รหัสสินค้า</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">
                    <div style="width: 120px;">ชื่อผลิตภัณฑ์</div> 
                </th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">
                    <div style="width: 100px;">UOM Code</div> 
                </th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">
                    <div style="width: 120px;">หน่วยนับ</div> 
                </th>
                <th class="text-center" colspan="2">Weight/Unit(KG)</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">วันที่เริ่มต้น</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">วันที่สิ้นสุด</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">
                    <div style="width: 80px;">การใช้งาน</div> 
                </th>
                @if (canEnter('/om/settings/item-weight'))
                    <th rowspan="2">
                        <div style="width: 70px;"></div> 
                    </th>
                @endif
            </tr> --}}
            <tr>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">รหัสสินค้า</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">ชื่อผลิตภัณฑ์</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">UOM<br>Code</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">หน่วยนับ</th>
                <th class="text-center" colspan="2">Weight/Unit(KG)</th>
                <th class="text-center" colspan="3">Dimensions</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">วันที่เริ่มต้น</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">วันที่สิ้นสุด</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">การใช้งาน</th>
                {{-- @if (canEnter('/om/settings/item-weight')) --}}
                    <th rowspan="2">
                    </th>
                {{-- @endif --}}
            </tr>
            <tr>
                <th class="text-center">NET</th>
                <th class="text-center">Gross</th>
                <th class="text-center" style="min-width: 70px;">กว้าง</th>
                <th class="text-center" style="min-width: 70px;">ยาว</th>
                <th class="text-center" style="min-width: 70px;">สูง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemWeights as $itemWeight)
                <tr>
                    <td>{{ $itemWeight->item_code }}</td>
                    <td>{{ $itemWeight->item_description }}</td>
                    <td>{{ $itemWeight->uom }}</td>
                    <td>{{ $itemWeight->uomV->description }}</td>
                    <td class="text-center">{{ $itemWeight->net_weight }}</td>
                    <td class="text-center">{{ $itemWeight->net_gross }}</td>

                    <td class="text-center">{{ $itemWeight->length ? number_format($itemWeight->length, 2) : '' }}</td>
                    <td class="text-center">{{ $itemWeight->width ? number_format($itemWeight->width, 2) : '' }}</td>
                    <td class="text-center">{{ $itemWeight->height ? number_format($itemWeight->height, 2) : '' }}</td>
                    <td>
                        {{-- {{ $itemWeight->start_date ? date(trans('date.format-date'), strtotime($itemWeight->start_date)) : '' }} --}}
                        {{ $itemWeight->start_date_format }}
                    </td>
                    <td>
                        {{-- {{ $itemWeight->end_date   ? date(trans('date.format-date'), strtotime($itemWeight->end_date)) : '' }} --}}
                        {{ $itemWeight->end_date_format }}
                    </td>
                    <td class="text-center">
                        @include('shared._status_active', ['isActive' => $itemWeight->active_flag == 'Y'])
                    </td>
                    {{-- @if (canEnter('/om/settings/item-weight')) --}}
                        <td align="center">
                            <a href="{{ route('om.settings.item-weight.edit', $itemWeight->weight_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        </td>
                    {{-- @endif --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $itemWeights->links() }}
</div>