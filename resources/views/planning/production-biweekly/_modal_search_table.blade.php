<div class="ibox-content table-responsive m-t mb-3">
    <div class="row col-12" style="font-size: 12px;">
        <div class="col-md-6"> </div>
        <div class="col-md-2 p-1">
            <span> &nbsp; <br> </span>
            <div> <span style="font-size: 10px;" class="label label-primary"> Approved </span> &nbsp; อนุมัติล่าสุด </div>
        </div>
        <div class="col-md-2 p-1">
            <span> &nbsp; <br> </span>
            <div> <span style="font-size: 10px;" class="label label-danger"> Approved </span> &nbsp; ยกเลิกอนุมัติ </div>
        </div>
        <div class="col-md-2 p-1">
            <span> &nbsp; <br> </span>
            <div> <span style="font-size: 10px;" class="label label-default"> Inactive </span> &nbsp; ยังไม่อนุมัติ </div>
        </div>
    </div>
    <div class="hr-line-dashed m-2"></div>
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
                    <div> ประจำเดือน </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> วันที่สร้าง </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> ครั้งที่อนุมัติ </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> วันที่อนุมัติ </div>
                </th>
                <th style="width: 15%;"> </th>
            </tr>
        </thead>
        <tbody>
            @if (count($productBiweeklies) == 0)
                <td colspan="9">
                    <div class="text-center">
                        <h3> NO DATA FOUND </h3>
                    </div>
                </td>
            @else
                @foreach ($productBiweeklies as $productBiweekly)
                   <tr>
                        <td class="text-center">
                            @if ($productBiweekly->approved_date &&  $productBiweekly->approved_status == 'Inactive')
                                <span class="label label-danger">Approved</span>
                            @else
                                {!! $productBiweekly->status_lable_html !!}
                            @endif
                            {{-- {!! $productBiweekly->status_lable_html !!} --}}
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
                        <td class="text-center">
                            {{ $productBiweekly->ppBiWeekly->thai_month }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->created_at_format }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->approved_no ?? 0 }}
                        </td>
                        <td class="text-center">
                            {{ $productBiweekly->approved_at_format }}
                        </td>
                        <td class="text-center">
                            <a  href="{{ route('planning.production-biweekly.show', [$productBiweekly->product_main_id]) }}"
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
