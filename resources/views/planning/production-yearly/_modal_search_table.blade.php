<div class="ibox-content table-responsive m-t mb-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 1px;" class="text-center">
                   <div> สถานะ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                   <div> ปีงบประมาณ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> ครั้งที่ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> วันที่สร้าง </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> วันที่อนุมัติ </div>
                </th>
                <th style="width: 1px;"> </th>
            </tr>
        </thead>
        <tbody>
            @if (count($productYearlies) == 0)
                <td colspan="6">
                    <div class="text-center">
                        <h3> NO DATA FOUND </h3>
                    </div>
                </td>
            @else
                @foreach ($productYearlies as $productYearly)
                   <tr>
                        <td class="text-center">
                            {!! $productYearly->status_lable_html !!}
                        </td>
                        <td class="text-center">
                            {{ $productYearly->budget_year }}
                        </td>
                        <td class="text-center" >
                            {{ $productYearly->version_no }}
                        </td>
                        <td class="text-center">
                            {{ $productYearly->created_at_format }}
                        </td>
                        <td class="text-center">
                            {{ $productYearly->approved_at_format }}
                        </td>
                        <td class="text-center">
                            <a  href="{{ route('planning.production-yearly.show', $productYearly->yearly_main_id) }}"
                                class="{{ trans('btn.detail.class') }} btn-lg tw-w-25">
                                <i class="{{ trans('btn.detail.icon') }}"></i>
                                {{ trans('btn.detail.text') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
