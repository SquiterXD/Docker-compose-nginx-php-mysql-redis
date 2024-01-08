<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}

    </head>
    <body>
        @php
            $styleTh = 'border:  1px solid black; line-height: 100px';
            $styleFont16 = 'border:  1px solid black; font-size: 16px';
            $styleFont14 = 'border:  1px solid black; font-size: 14px';
            $font18 = 'font-size: 18px; ';
            $font16 = 'font-size: 16px; ';
            $font14 = 'font-size: 14px; ';
            $lineNo = 0;
        @endphp
        @foreach ($transactions->groupBy('period_name') as  $period => $transactionsByPeriod)
        
        <table>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>โปรแกรม : </b>  CTR0001</td>
                <td  align="center" height="20" colspan=3  style="{{ $font18 }}"><b> การยาสูบแห่งประเทศไทย </b></td>
                <td  align="right" height="20" colspan="2" style="{{ $font18 }}"><b>วันที่พิมพ์ : </b> {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y H:i') }} </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>พิมพ์โดย : </b> {{$userProfile->user_name }}</td>
                <td  align="center" height="20" colspan=3  style="{{ $font18 }}"><b> รายงานตรวจสอบยอดรวมการบันทึกบัญชีประจำวัน </b></td>
                <td  align="center" height="20" colspan="2" style="{{ $font18 }}">  </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>หนวยงาน : {{ $cost->dept_code. ' ' . $cost->dept_code_desc}}</b> </td>
                <td  align="center" height="20" colspan=3  style="{{ $font18 }}">
                    ประจำเดือน  {{ periodCT($period) }}
                            {{-- <b>{{ ctDateText($formDate , $toDate)}}</b> --}}
                </td>
                <td  align="center" height="20" colspan="2" style="{{ $font18 }}">  </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"><b>แหล่งที่มา : </b> Web ระบบต้นทุน </td>
                <td  align="center" height="20" colspan=3  style="{{ $font18 }}"><b> {{ $transactionsByPeriod[0]->cost_desc . ' : ' . $transactionsByPeriod[0]->cost_code
                     }}</b></td>
                <td  align="center" height="20" colspan="2" style="{{ $font18 }}">  </td>
            </tr>
            <tr>
                <td  align="left"   height="20" colspan="2"  style="{{ $font18 }}"></td>
                {{-- <td  align="center" height="20" colspan="4"  style="{{ $font18 }}"><b> สถานะการส่งเข้าG/L : {{ $transactionsByPeriod[0]->gl_interface_flag == 'Y'? ' ส่งเข้า G/L แล้ว' : 'ยังไม่ส่งเข้า G/L' }}  </b></td> --}}
                <td  align="center" height="20" colspan="2"  style="{{ $font18 }}"><b> สถานะการส่งเข้าG/L : {{ $transactionsByPeriod[0]->process_status }}  </b></td>
                <td  align="center" height="20" colspan="2"  style="{{ $font18 }}"><b> สถานะการยกเลิก : {{  optional($reverseData)->label }}  </b></td>
                <td  align="center" height="20" style="{{ $font18 }}">  </td>
            </tr>

        </table>
        <table>
            <thead>
                <tr>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b>ลำดับ</b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> การบันทึกบัญชี </b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> เลขที่ชุดของการส่งข้อมูล </b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> รหัสบัญชี </b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> ชื่อบัญชี  </b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> จำนวนเงินเดบิต  </b></td>
                    <td  align="center" height="30"  style="{{ $styleFont16 }}"><b> จำนวนเงินเครดิต  </b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactionsByPeriod->groupBy('ct_group_code') as $ctGroupCode =>  $transactionByBatch)
                    @foreach ($transactionByBatch->sortBy('batch_no')->groupBy('batch_no') as $batchNo =>  $transaction)

                        <tr>
                            <td  align="center" style="{{ $font14 }}">
                                @if ($loop->first)
                                @php
                                    $lineNo += 1;
                                @endphp
                                    <b> {{ $lineNo }}</b>
                                @endif
                            </td>
                            <td  align="left"   style="{{ $font14 }}">
                                @if ($loop->first)
                                <b> {{ $transaction[0]->ct_group_code}} </b>
                                @endif
                            </td>
                            <td  align="center" style="{{ $font14 }}"> <b> {{ $batchNo}} </b> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        @foreach ($transaction->sortBy('cost_group_ordering')->groupBy('account_code') as $data)
                            <tr>
                                <td></td>
                                <td align="left" style="{{ $font14 }}">
                                    <b>
                                        @if ($loop->parent->first && $loop->first)
                                            {{ $data[0]->group_code_desc}}
                                        @endif
                                    </b>

                                </td>
                                <td></td>
                                <td style="{{ $font14 }}"> {{ $data[0]->account_code }} </td>
                                <td style="{{ $font14 }}"> {{ $data[0]->acc_des}} </td>
                                <td style="{{ $font14 }}"> {{ $data[0]->amount_type == "DR"? $data->sum('amount') : "" }} </td>
                                <td style="{{ $font14 }}"> {{ $data[0]->amount_type == "CR"? $data->sum('amount') : "" }} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"  style="border-bottom: 1px solid black; font-size: 16px"><b>{{ $transaction->where('amount_type', 'DR')->sum('amount') }} </b></td>
                            <td height="25"  style="border-bottom: 1px solid black; font-size: 16px"><b>{{ $transaction->where('amount_type', 'CR')->sum('amount') }} </b></td>
                        </tr>
                    @endforeach
                    @if ($loop->last)
                        <tr>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25"></td>
                            <td height="25" style="{{ $font16 }}" align="right"><b>รวมตามศูนย์ต้นทุน</b></td>
                            <td height="25"  style="border-bottom:  1px double black; border-top:  1px solid black; font-size: 16px"><b>{{ $transactionsByPeriod->where('amount_type', 'DR')->sum('amount') }} </b></td>
                            <td height="25"  style="border-bottom:  1px double black; border-top:  1px solid black; font-size: 16px"><b>{{ $transactionsByPeriod->where('amount_type', 'CR')->sum('amount') }} </b></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td  height="120" colspan="7"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td ></td>
                    <td height="50"  colspan="2" style="text-align: center; {{ $font14 }}">
                        ผู้จัดทำ.........................................................................................<br>
                        (.........................................................................................)
                    </td>
                     <td height="50"  colspan="2" style="text-align: center; {{ $font14 }}">
                        ผู้ตรวจสอบ.........................................................................................<br>
                        (.........................................................................................)
                    </td>
                </tr>
            </tfoot>
        </table>
        @endforeach
    </body>
</html>
