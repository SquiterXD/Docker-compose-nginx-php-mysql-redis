@php
    $page_no = 0;
@endphp
@foreach ($G2_DATA as $policy => $datas)
    @foreach ($datas->groupBy('polycy_form') as $polycyForm  => $G2Ds)
        @php
            $lineLimit = 17;
            $dataChunk = array_chunk($G2Ds->toArray(), $lineLimit);
            $page = getCountPageAll($G1_DATA->toArray(), $lineLimit);
        @endphp
        @foreach ($dataChunk as $index => $lines)
        @php
            $page_no++;
        @endphp
        <div style="page-break-after: always;"> </div>
        @include('ir.reports.irr2210.header-html')
            <table class="table">
                <thead>
                    <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                        <th rowspan=2 style="border-right:1px solid #000;border-left:1px solid #000;min-width:120px;text-align:center;padding-left:5px; border-bottom: 1px solid #000; border-top: 1px solid #000;"> รายการ </th>
                        <th rowspan=2 style="border-right:1px solid #000;text-align:center"> รหัสบัญชี </th>
                        <th rowspan=2 style="border-right:1px solid #000;text-align:center"> ดุล </th>
                        <th colspan=2 style="border-right:1px solid #000;text-align:center"> MONTH </th>
                        <th rowspan=2 style="border-right:1px solid #000;text-align:center"> ดุลรับคืน </th>
                        <th rowspan=2 style="border-right:1px solid #000;width:150px;text-align:center"> ค้างจ่าย </th>
                    </tr>
                    <tr style="border-bottom: 1px solid #000;height:30px;">
                        <th style="border-right:1px solid #000;width:150px;text-align:center">ลูกหนี้</th>
                        <th style="border-right:1px solid #000;width:150px;text-align:center">เจ้าหนี้</th>
                    </tr>
                </thead>
                <tbody>
                    @if($loop->first)
                        <tr style="border: 1px solid #000; height:30px;">
                            <td style="text-decoration: underline; min-width:150px;text-align:left;padding-left:5px; border: 1px solid #000; border-bottom: 1px solid #fff;"> <b>{{$polycyForm}}</b> </td>
                            <td style="text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                            <td style="text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                            <td style="text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                            <td style="text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                            <td style="width:150px;text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                            <td style="width:150px;text-align:center; border: 1px solid #000; border-bottom: 1px solid #fff;"></td>
                        </tr>
                    @endif()
                    @foreach ($lines as  $G2D)
                        <tr style="border: 1px solid #000; height:30px;">
                            <td style="min-width:150px; text-align:left; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">
                                {{$G2D['description']}}
                            </td>
                            <td style="border-right:1px solid #000;text-align:center; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['account_code']}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['amount']}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['amount_receivable']}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['amount_payable']}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;width:150px;text-align:right; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['amount_take']}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;width:150px;text-align:right; {{ !$loop->last? 'border: 1px solid #000; border-bottom: 1px solid #fff;': 'border: 1px solid #000;' }}">{{$G2D['amount_outstanding']}}</td>
                        </tr>
                        @endforeach
                        {{-- <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:30px;">
                            <th style="border-right:1px solid #000;border-left:1px solid #000;min-width:150px;text-align:center;"><b>รวมทั้งสิ้น</b></th>
                            <td style="border-right:1px solid #000;text-align:center;"></td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right">{{$lines->sum('amount')}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right">{{$lines->sum('amount_receivable')}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;text-align:right">{{$lines->sum('amount_payable')}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;width:150px;text-align:right">{{$lines->sum('amount_take')}}</td>
                            <td style="border-right:1px solid #000;min-width:150px;width:150px;text-align:right">{{$lines->sum('amount_outstanding')}}</td>
                        </tr> --}}
                </tbody>
            </table>
    @endforeach
    @endforeach
@endforeach