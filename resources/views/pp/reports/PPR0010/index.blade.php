<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	@include('pp.reports.PPR0010._style')
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="table-responsive">
                    @php
                        $page_no = 0;
                        $totalP09 = [];
                        $page = countPagePPR0010($itemCigarettes);
                    @endphp
                    @foreach ($itemCigarettes as $group => $stamps)
                        @php
                            $dataStampChunk = array_chunk($stamps->toArray(), 6);
                        @endphp
                        @foreach ($dataStampChunk as $index => $items)
                            @php
                                $page_no++;
                                $totalP08 = 0;
                                $totalAll = 0;
                                $totalActualUsed = 0;
                                $totalLoss = 0;
                                $totalBroken = 0;
                                $totalIncomplete = 0;
                                $totalBalance = 0;
                            @endphp
                            <div style="page-break-after: always;"> </div>
                            @include('pp.reports.PPR0010.header')
                            <table class="table table-bordered" style=" border: #000000 solid 0.5px; padding: 0px; margin-top: 30px; font-size: 14px;">
                                <!-- header -->
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="8%" style="border:#000 0.5px solid; text-align: center;"> ว.ด.ป </th>
                                        <th rowspan="2" width="6%" style="border:#000 0.5px solid; text-align: center;"> หลักฐาน <br> การรับจ่าย <br> เลขที่</th>
                                        <th rowspan="2" width="6%" style="border:#000 0.5px solid; text-align: center;"> รับแสตมป์ </th>
                                        <th rowspan="2" width="6%" style="border:#000 0.5px solid; text-align: center;"> รับจากการโอนร.5 </th>
                                        @foreach ($items as $item)
                                            <th rowspan="2" width="6%" style="border:#000 0.5px solid; text-align: center;">
                                                {{ $item['cigarettes_description'] }}
                                            </th>
                                        @endforeach
                                        <th colspan="6" width="12%" style="border:#000 0.5px solid; text-align: center;"> จ่าย </th>
                                        <th rowspan="2" width="6%" style="border:#000 0.5px solid; text-align: center;"> คงเหลือ </th>
                                        <th rowspan="2" width="5%" style="border:#000 0.5px solid; text-align: center;"> ลงชื่อผู้ผลิตยาสูบ <br> หรือผู้แทน </th>
                                        <th rowspan="2" width="5%" style="border:#000 0.5px solid; text-align: center;"> หมายเหตุ </th>
                                    </tr>
                                    <tr>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> จำนวน <br> แสตมป์ <br> ที่ใช้ปิด </th>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> เสียหาย </th>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> สูญหาย </th>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> ไม่สมบูรณ์ </th>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> โอนออก </th>
                                        <th width="4%" style="border:#000 0.5px solid; text-align: center;"> รวม </th>
                                    </tr>
                                </thead>
                                <!-- Line -->
                                @php
                                    $res = calPMStamp($st, $ed, $group, $stamps);
                                @endphp
                                <tbody>
                                    <tr style="font-weight: bold;">
                                        <td style="border:#000 0.5px solid; text-align: center;"> ยอดยกมา </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        @foreach ($items as $item)
                                            <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        @endforeach
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: right;">
                                            {{ number_format($res['onhandForward']) }}
                                        </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                    </tr>
                                    @foreach ($stampFollows as $index => $stamp)
                                        @php
                                            $total = 0;
                                            $total = number_format($actualUsed[$stamp->follow_date] ?? 0) + number_format($loss[$stamp->follow_date] ?? 0) + number_format($broken[$stamp->follow_date] ?? 0) + number_format($incomplete[$stamp->follow_date] ?? 0);
                                            // Summary
                                            $totalP08 += isset($receiveQtyP08[$stamp->follow_date])? $receiveQtyP08[$stamp->follow_date][0]: 0;
                                            $totalAll += $total;
                                        @endphp
                                        <tr>
                                            <td style="border:#000 0.5px solid; text-align: center;">
                                                {{ convertFormatDateToFullThai($stamp->follow_date, null) }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ isset($receiveQtyP08[$stamp->follow_date])? $receiveQtyP08[$stamp->follow_date][0]: 0 }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                            @php
                                                $totalActualUsed += $res['actualUsed']? $res['actualUsed'][$stamp->follow_date][0]: 0;
                                                $totalLoss += $res['loss']? $res['loss'][$stamp->follow_date][0]: 0;
                                                $totalBroken += $res['broken']? $res['broken'][$stamp->follow_date][0]: 0;
                                                $totalIncomplete += $res['incomplete']? $res['incomplete'][$stamp->follow_date][0]: 0;
                                                if ($loop->last) {
                                                    $totalBalance = $res['balance']? $res['balance'][$stamp->follow_date][0]: 0;
                                                }
                                            @endphp
                                            @foreach ($items as $item)
                                                @php
                                                    if (!array_key_exists($item['cigarettes_code'], $totalP09)) {
                                                        $totalP09[$item['cigarettes_code']] = $receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']]
                                                                    ? $receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']][0]
                                                                    : 0;
                                                    }else{
                                                        $totalP09[$item['cigarettes_code']] += $receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']]
                                                                    ? $receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']][0]
                                                                    : 0;
                                                    }
                                                @endphp
                                                <td style="border:#000 0.5px solid; text-align: right;">
                                                    {{ optional($receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']])
                                                        ? number_format($receiveQtyP09[$stamp->follow_date.'|'.$item['cigarettes_code']][0])
                                                        : number_format(0)
                                                    }}
                                                </td>
                                            @endforeach
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ $res['actualUsed']? number_format($res['actualUsed'][$stamp->follow_date][0]): 0}}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ $res['loss']? number_format($res['loss'][$stamp->follow_date][0]): 0 }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ $res['broken']? number_format($res['broken'][$stamp->follow_date][0]): 0 }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ $res['incomplete']? number_format($res['incomplete'][$stamp->follow_date][0]): 0 }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> </td>
                                            <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($total) }} </td>
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ $res['balance']? number_format($res['balance'][$stamp->follow_date][0]): 0 }}
                                            </td>
                                            <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                            <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold;">
                                        <td style="border:#000 0.5px solid; text-align: center;"> รวม </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> - </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($totalP08) }} </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> - </td>
                                        @foreach ($items as $item)
                                            <td style="border:#000 0.5px solid; text-align: right;">
                                                {{ isset($totalP09[$item['cigarettes_code']])? number_format($totalP09[$item['cigarettes_code']]): 0 }}
                                            </td>
                                        @endforeach
                                        <td style="border:#000 0.5px solid; text-align: right;">
                                            {{ number_format($totalActualUsed) }}
                                        </td>
                                        <td style="border:#000 0.5px solid; text-align: right;">
                                            {{ number_format($totalLoss) }}
                                        </td>
                                        <td style="border:#000 0.5px solid; text-align: right;">
                                            {{ number_format($totalBroken) }}
                                        </td>
                                        <td style="border:#000 0.5px solid; text-align: right;">
                                            {{ number_format($totalIncomplete) }}
                                        </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> - </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($totalAll) }} </td>
                                        <td style="border:#000 0.5px solid; text-align: right;"> {{ number_format($totalBalance) }} </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                        <td style="border:#000 0.5px solid; text-align: center;"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>




