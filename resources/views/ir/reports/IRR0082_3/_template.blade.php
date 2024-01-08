<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>IRR0082-3 : รายงานดุลค่าเบี้ยประกันภัยทรัพย์สิน ประจำเดือน</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports.IRR0082_3._style')
    </head>
    <body>
        @php
            $dt = explode('-', $req_period);
            $deptAmount = collect([
                'beginning_amount' => 0,
                'activity_ap_amount' => 0,
                'net_amount' => 0,
                'ending_amount' => 0
            ]);
            $totalAmount = collect([
                'beginning_amount' => 0,
                'activity_ap_amount' => 0,
                'net_amount' => 0,
                'ending_amount' => 0
            ]);
        @endphp
        @foreach ($data as $page => $array)
            @php
                $total_page = $loop->count;
            @endphp
            <div style="margin-bottom: 0.25rem;">
                <div class="inline-block" style="width: 30%">
                    <div >
                        <span class="b">โปรแกรม :</span> IRR0082-3
                    </div>
                    <div>
                        <span class="b">สั่งพิมพ์ :</span> {{ \Auth::user()->username }}
                    </div>
                </div>
                <div class="inline-block text-center" style="width: 39%">
                    <div>
                        <span class="b">การยาสูบแห่งประเทศไทย</span>
                    </div>
                    <div>
                        <span class="b">รายงานดุลค่าเบี้ยประกันภัยทรัพย์สิน ประจำเดือน</span> {{ $thaimonths[$dt[1]] }} {{ \Carbon\Carbon::parse($req_period)->format('Y')+543 }}
                    </div>
                    <div>
                        <span class="b">ตั้งแต่วันที่</span> {{ dateFormatThaiString(\Carbon\Carbon::parse($range->start_date)->format('Y-m-d')) }} <span class="b">ถึงวันที่</span> {{ dateFormatThaiString(\Carbon\Carbon::parse($range->end_date)->format('Y-m-d')) }}
                    </div>
                </div>
                <div class="inline-block text-right" style="width: 30%">
                    <div>
                        <span class="b">วันที่ :</span> {{ dateFormatThai(date('d-M-Y')) }}
                    </div>
                    <div>
                        <span class="b">เวลา : </span> {{ strtoupper(date('H:i')) }}
                    </div>
                    <div>
                        <span class="b">หน้า : </span> {{ $page+1 }} / {{ $total_page }}
                    </div>
                </div>
            </div>
            @foreach ($array['data'] as $policy => $groupUser)
                <div style="margin-bottom: 0.25rem;">
                    <div class="inline-block" style="width: 22%">
                        <div class="b">
                            {{ $policy }}
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td rowspan="2" class="b text-center">
                                รายการ
                            </td>
                            <td rowspan="2" class="b text-center">
                                รหัสบัญชี
                            </td>
                            <td rowspan="2" class="text-center">
                                <span class="b">ดุล</span><br>
                                {{ dateFormatShortThaiString($begin_header) }}
                            </td>
                            <td colspan="2" class="b text-center">
                                {{ $thaimonths[$dt[1]] }} {{ \Carbon\Carbon::parse($req_period)->format('Y')+543 }}
                            </td>
                            <td rowspan="2" class="text-center">
                                <span class="b">ดุล</span><br>
                                {{ dateFormatShortThaiString($end_header) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="b text-center" width="80px;">
                                ลูกหนี้
                            </td>
                            <td class="b text-center" width="80px;">
                                เจ้าหนี้
                            </td>
                        </tr>
                    </thead>
                    <tbody style="border: 0.5px solid rgb(100, 100, 100) !important;">
                        @foreach ($groupUser as $user => $groupDepartment)
                            <tr>
                                <td class="b">
                                    {{-- รายการ --}}
                                    ประกันแบบ Replacement Value ( {{ $user }} )
                                </td>
                                <td>
                                    {{-- รหัสบัญชี --}}
                                </td>
                                <td>
                                    {{-- ดุล --}}
                                </td>
                                <td>
                                    {{-- ลูกหนี้ --}}
                                </td>
                                <td>
                                    {{-- เจ้าหนี้ --}}
                                </td>
                                <td>
                                    {{-- ดุล --}}
                                </td>
                            </tr>
                            @foreach ($groupDepartment as $department => $groupCategory)
                                <tr>
                                    <td class="b">
                                        {{-- รายการ --}}
                                        &nbsp; &nbsp; {{ $department }}
                                    </td>
                                    <td>
                                        {{-- รหัสบัญชี --}}
                                    </td>
                                    <td>
                                        {{-- ดุล --}}
                                    </td>
                                    <td>
                                        {{-- ลูกหนี้ --}}
                                    </td>
                                    <td>
                                        {{-- เจ้าหนี้ --}}
                                    </td>
                                    <td>
                                        {{-- ดุล --}}
                                    </td>
                                </tr>
                                @foreach ($groupCategory as $category => $groupAccount)
                                    @foreach ($groupAccount as $account => $items)
                                        @php
                                            $item = $items->first();
                                            $sumBegin = $items->sum('beginning_amount');
                                            $sumAct = $items->sum('activity_ap_amount');
                                            $sumNet = $items->sum('net_amount');
                                            $sumEnd = $items->sum('ending_amount');
                                            $deptAmount['beginning_amount'] += $sumBegin;
                                            $deptAmount['activity_ap_amount'] += $sumAct;
                                            $deptAmount['net_amount'] += $sumNet;
                                            $deptAmount['ending_amount'] += $sumEnd;
                                            $totalAmount['beginning_amount'] += $sumBegin;
                                            $totalAmount['activity_ap_amount'] += $sumAct;
                                            $totalAmount['net_amount'] += $sumNet;
                                            $totalAmount['ending_amount'] += $sumEnd;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{-- รายการ --}}
                                                &nbsp; &nbsp; &nbsp; &nbsp; {{ $category }}
                                            </td>
                                            <td class="text-center">
                                                {{-- รหัสบัญชี --}}
                                                {{ $account }}
                                            </td>
                                            <td class="text-right">
                                                {{-- ดุล --}}
                                                {{ number_format($sumBegin, 2) }}
                                            </td>
                                            <td class="text-right">
                                                {{-- ลูกหนี้ --}}
                                                {{ number_format($sumAct, 2) }}
                                            </td>
                                            <td class="text-right">
                                                {{-- เจ้าหนี้ --}}
                                                {{ number_format($sumNet, 2) }}
                                            </td>
                                            <td class="text-right">
                                                {{-- ดุล --}}
                                                {{ number_format($sumEnd, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                @if ($array['show_sum_dept'][$department])
                                    <tr>
                                        <td class="b text-center">
                                            {{-- รายการ --}}
                                            รวม
                                        </td>
                                        <td class="b text-center" style="border-bottom: 0.5px solid rgb(100, 100, 100) !important;">
                                            {{-- รหัสบัญชี --}}
                                        </td>
                                        <td class="b text-right" style="border: 0.5px solid rgb(100, 100, 100) !important; background-color: rgb(220, 220, 220);">
                                            {{-- ดุล --}}
                                            {{ number_format($deptAmount['beginning_amount'], 2) }}
                                        </td>
                                        <td class="b text-right" style="border: 0.5px solid rgb(100, 100, 100) !important; background-color: rgb(220, 220, 220);">
                                            {{-- ลูกหนี้ --}}
                                            {{ number_format($deptAmount['activity_ap_amount'], 2) }}
                                        </td>
                                        <td class="b text-right" style="border: 0.5px solid rgb(100, 100, 100) !important; background-color: rgb(220, 220, 220);">
                                            {{-- เจ้าหนี้ --}}
                                            {{ number_format($deptAmount['net_amount'], 2) }}
                                        </td>
                                        <td class="b text-right" style="border: 0.5px solid rgb(100, 100, 100) !important; background-color: rgb(220, 220, 220);">
                                            {{-- ดุล --}}
                                            {{ number_format($deptAmount['ending_amount'], 2) }}
                                        </td>
                                    </tr>
                                    @php
                                        $deptAmount = collect([
                                            'beginning_amount' => 0,
                                            'activity_ap_amount' => 0,
                                            'net_amount' => 0,
                                            'ending_amount' => 0
                                        ]);
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                        @if ($array['show_sum_all'])
                            <tr style="border: 0.5px solid rgb(100, 100, 100) !important; background-color: rgb(220, 220, 220);">
                                <td colspan="2" class="b text-center">
                                    {{-- รายการ --}}
                                    รวมทั้งสิ้น
                                </td>
                                <td class="b text-right">
                                    {{-- ดุล --}}
                                    {{ number_format($totalAmount['beginning_amount'], 2) }}
                                </td>
                                <td class="b text-right">
                                    {{-- ลูกหนี้ --}}
                                    {{ number_format($totalAmount['activity_ap_amount'], 2) }}
                                </td>
                                <td class="b text-right">
                                    {{-- เจ้าหนี้ --}}
                                    {{ number_format($totalAmount['net_amount'], 2) }}
                                </td>
                                <td class="b text-right">
                                    {{-- ดุล --}}
                                    {{ number_format($totalAmount['ending_amount'], 2) }}
                                </td>
                            </tr>
                            @php
                                $totalAmount = collect([
                                    'beginning_amount' => 0,
                                    'activity_ap_amount' => 0,
                                    'net_amount' => 0,
                                    'ending_amount' => 0
                                ]);
                            @endphp
                        @endif
                    </tbody>
                </table>
            @endforeach

            <div class="page-break"></div>

        @endforeach
    </body>
</html>