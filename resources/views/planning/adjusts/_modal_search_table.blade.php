<div class="ibox-content table-responsive m-t mb-3">
    <table class="table table-hover"> {{-- table-bordered --}}
        <thead>
            <tr>
                <th style="width: 1px;" class="text-center">
                   <div> สถานะ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                   <div> ปีงบประมาณ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                   <div> ปักษ์ที่ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> ครั้งที่ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> ครั้งที่ปรับ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> ประจำเดือน </div>
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
            @if (count($productBiweeklies) == 0)
                <td colspan="8">
                    <div class="text-center">
                        <h3> NO DATA FOUND </h3>
                    </div>
                </td>
            @else
                @foreach ($productBiweeklies as $productBiweekly)
                   <tr>
                        <td class="text-center">
                            {!! $productBiweekly->status_lable_html !!}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->ppBiWeekly->thai_year }}
                        </td>
                        <td class="text-center" >
                            {{ $productBiweekly->ppBiWeekly->biweekly }}
                        </td>
                        <td class="text-center" >
                            {{ $productBiweekly->version_no }}
                        </td>

                        <td class="text-center" >
                           {{ $productBiweekly->adjust_no }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->ppBiWeekly->thai_month }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->created_at_format }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->approved_at_format }}
                        </td>
                        <td class="text-center">
                            <a  href="{{ route('planning.adjusts.show', [$productBiweekly->product_main_id]) }}"
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
