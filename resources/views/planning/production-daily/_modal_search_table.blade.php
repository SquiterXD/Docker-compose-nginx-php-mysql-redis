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
                {{-- <th style="width: 1px;" class="text-center">
                    <div> ส่งข้อมูลครั้งที่ </div>
                </th> --}}
                <th style="width: 1px;" class="text-center">
                    <div> ประจำเดือน </div>
                </th>
                <th style="width: 1px;" class="text-center">
                    <div> อนุมัติวันที </div>
                </th>
                <th style="width: 1px;"> </th>
            </tr>
        </thead>
        <tbody>
            @if (!$planDaily)
                <td colspan="8">
                    <div class="text-center">
                        <h2> ไม่มีข้อมูลในระบบ </h2>
                    </div>
                </td>
            @else
                {{-- @foreach ($planDailies as $planDaily) --}}
                {{-- {{ dd($planDaily) }} --}}
                   <tr>
                        <td class="text-center">
                            {!! $planDaily->status_lable_html !!}
                        </td>
                        <td class="text-center">
                            {{ $planDaily->ppBiWeekly->period_year_thai }}
                        </td>
                        <td class="text-center">
                            {{ $planDaily->ppBiWeekly->biweekly }}
                        </td>
                        {{-- <td class="text-center"> --}}
                            {{-- {{ $planDaily->version_no }} --}}
                        {{-- </td> --}}
                        <td class="text-center">
                            {{ $planDaily->ppBiWeekly->thai_month }}
                        </td>
                        <td class="text-center">
                            {{ $planDaily->approved_at_format }}
                        </td>
                        <td class="text-center">
                            <a  href="{{ route('planning.production-daily.show', [$planDaily->res_plan_h_id ?? -1]) }}"
                                class="btn btn-white btn-md">
                                ดูรายละเอียด
                            </a>
                        </td>
                    </tr>
                {{-- @endforeach --}}
            @endif
        </tbody>
    </table>
</div>
