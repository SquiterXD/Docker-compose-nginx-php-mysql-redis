<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    @php
        $styleTh = 'border:  1px solid black; line-height: 50px';
        $styleFont16 = 'border:  1px solid black; font-size: 16px';
        $styleFont14 = 'border:  1px solid black; font-size: 14px';
        $font18 = 'font-size: 18px';
    @endphp
    <body>
        @foreach ($assetsByPolicy->groupBy('policy_set_number') as $policyNumber => $assetByConpany)
        @foreach ($assetByConpany->groupBy('company_id') as $assets)
        <table>
            @php
                $userPolicyNumbers  = $assets->where('user_policy_number','!=', null )->unique('user_policy_number')->pluck('user_policy_number');
                $companyComments    = $assets->where('company_comments','!=', null )->unique('company_comments')->pluck('company_comments');
            @endphp
            <thead>
                <tr>
                    <th height="30"  style="{{$font18}}">โปรแกรม : IRR6010 </th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"><b>การยาสูบแห่งประเทศไทย</b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th align="center" height="30" style="{{$font18}}"><b> </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th height="30" style="{{$font18}}"><b>วันที่ : {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }}</b></th>
                </tr>
                <tr>
                    <th height="30"  style="{{$font18}}">สั่งพิมพ์ : {{ auth()->user()->username }}  </th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"><b>ชุดที่ {{ $assets[0]->policy_set_number }} : {{ $assets[0]->policy_set_description }}</b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th align="center" height="30" style="{{$font18}}"><b> </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th height="30" style="{{$font18}}"><b>เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</b></th>
                </tr>
                <tr>
                    <th align="center" height="30"  style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" colspan="3" style="{{$font18}}"><b>รายละเอียดมูลค่าทุนประกันภัยทรัพย์สินและการคำนวณค่าเบี้ยประกันภัย  โดยการประกันแบบ </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b> </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th height="30" style="{{$font18}}"> </th>
                </tr>
                <tr>
                    <th align="center" height="30"  style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" colspan="3" style="{{$font18}}"> <b>{{ $assets[0]->company_name }}</b>  </th>
                    <th align="center" height="30" style="{{$font18}}"><b> </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th height="30" style="{{$font18}}"> </th>
                </tr>
                <tr>
                    <th align="center" height="30"  style="{{$font18}}"></th>
                    <th align="center" height="30" style="{{$font18}}"></th>
                    <th align="center" height="30" colspan="3" style="{{$font18}}"> 
                       <b> {{  $dateDisplay }} </b>  
                    </th>
                    <th align="center" height="30" style="{{$font18}}"><b> </b></th>
                    <th align="center" height="30" style="{{$font18}}"><b></b></th>
                    <th height="30" style="{{$font18}}"> </th>
                </tr>
            </thead>
            </table>
            <table >
                <thead>
                    <tr>
                        <th height="30" colspan="3" style="{{$font18}}"> เลขที่กรมธรรม์ :
                            @foreach ($userPolicyNumbers as  $userPolicyNumber)
                                {{ $userPolicyNumber }} 
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach 
                        </th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"> เลขที่สลักหลัง : 
                            @foreach ($companyComments as  $companyComment)
                            {{ $companyComment }} 
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach  </th>
                    </tr>
                    <tr>
                        <th height="30" style="{{$font18}}"> สถานะ  : {{ $assets[0]->status }}</th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                        <th height="30"  style="{{$font18}}"></th>
                    </tr>
                    <tr>
                        <th align="center" height="30"  style="{{ $styleFont16 }}"><b> ลำดับ </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>รายการ </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>ราคาตามบัญชี
                            (บาท) {{ $assets[0]->company_percent }} </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>ราคาประกันภัย
                            (บาท) {{ $assets[0]->company_percent }} </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>มูลค่าทุนประกัน (บาท)
                            {{ $assets[0]->company_percent }} </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>อัตราเบี้ยประกัน </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>ค่าเบี้ยประกันภัย (บาท)
                            {{ $assets[0]->company_percent }} </b></th>
                        <th align="center" height="30" style="{{ $styleFont16 }}"><b>คำนวณปิดบัญชี (บาท) </b></th>
                    </tr>
                </thead>
                @foreach ($assets->groupBy('location_code') as $locationCode =>  $locations)
                        <tr>
                            <td height="30"  align="center" style="{{ $styleFont14 }}"> {{ $loop->iteration }}   </td>
                            <td height="30"  style="{{ $styleFont14 }}" ><b>{{ $locations[0]->location_name }} </b></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                            <td height="30"  style="{{ $styleFont14 }}"></td>
                        </tr>
                    @foreach ($locations->groupBy('department_code') as $deptCode => $departments)
                            <tr >
                                <td height="30" align="center" style="border-right: 1px solid black; font-size: 14px"> {{ $loop->parent->iteration }}.  {{ $loop->iteration }}</td>
                                <td height="30" style="border-right: 1px solid black; font-size: 14px"><b>{{ $locations[0]->department_name }} </b> </td>
                                <td height="30"></td>
                                <td height="30"></td>
                                <td height="30" style="border-right: 1px solid black"></td>
                                <td height="30"></td>
                                <td height="30"></td>
                                <td height="30" style="{{ $styleFont14 }}"></td>
                            </tr>
                        @php
                            $sum = 0;
                        @endphp
                        @foreach ($departments->groupBy('category_code') as $categoryCode => $categories)
                        @php
                            if($categories[0]->include_tax_flag == 'Y'){
                                $sum +=  $categories->unique('line_id')->sum('net_amount') * (1 * round($categories[0]->prepaid_insurance * 0.01, 2 ));
                            } else {
                                $sum += ($categories->unique('line_id')->sum('insurance_amount') + $categories->unique('line_id')->sum('duty_amount')) * (1 * round($categories[0]->prepaid_insurance * 0.01, 2 ));
                            }
                        @endphp
                                <tr>
                                    <td height="30" align="center" style="border-right: 1px solid black; font-size: 14px">{{ $loop->parent->iteration }}. {{ $loop->parent->iteration }}.  {{ $loop->iteration }} </td>
                                    <td height="30" style="border-right: 1px solid black; font-size: 14px"> {{ $categories[0]->category_description }} </td>
                                    <td height="30" align="right" style="{{ $styleFont14 }}">{{ $categories->unique('line_id')->sum('current_cost') }}</td>
                                    <td height="30" align="right" style="{{ $styleFont14 }}"> {{ $categories->unique('line_id')->sum('coverage_amount') }} </td>
                                    <td height="30" align="right" style="border-right: 1px solid black ; {{ $styleFont14 }}"> {{ $categories->unique('line_id')->sum('coverage_amount') }} </td>
                                    <td height="30"></td>
                                    <td height="30"></td>
                                    <td height="30" style="border-right: 1px solid black ; border-left: 1px solid black ; font-size: 14px"> 
                                        @if ($categories[0]->include_tax_flag == 'Y')
                                            {{ $categories->unique('line_id')->sum('net_amount') * (1 * round($categories[0]->prepaid_insurance * 0.01, 2 )) }}
                                        @else
                                            {{ ($categories->unique('line_id')->sum('insurance_amount') + $categories->unique('line_id')->sum('duty_amount')) * (1 * round($categories[0]->prepaid_insurance ?? 0 * 0.01, 2 )) }}
                                        @endif
                                    </td>
                                </tr>
                                @if ($loop->last)
                                    <tr>
                                        <td height="30" align="center" style="border-right: 1px solid black; font-size: 14px"></td>
                                        <td height="30" align="center" style="border-right: 1px solid black; font-size: 14px"> <b>รวม</b> </td>
                                        <td height="30" align="right" style="{{ $styleFont14 }}">  <b>  {{ $departments->unique('line_id')->sum('current_cost') }} </b> </td>
                                        <td height="30" align="right" style="{{ $styleFont14 }}"> <b>   {{ $departments->unique('line_id')->sum('coverage_amount') }} </b></td>
                                        <td height="30" align="right" style="{{ $styleFont14 }}"> <b>  {{ $departments->unique('line_id')->sum('coverage_amount') }} </b></td>
                                        <td height="30" ></td>
                                        <td height="30" ></td>
                                        <td height="30"  style="{{ $styleFont14 }}"> <b> {{ $sum }} </b> </td>
                                    </tr>
                                @endif
                        @endforeach
                        @if ($loop->last)
                            <tr>
                                <td height="30" colspan="2" align="center" style="{{ $styleFont14 }}">  <b> รวม {{  $locations[0]->location_name }} {{ $locations[0]->department_name  }} </b></td>
                                <td height="30"  style="{{ $styleFont14 }}" align="right"><b> {{ $locations->unique('line_id')->sum('current_cost')}}  </b> </td>
                                <td height="30"  style="{{ $styleFont14 }}" align="right"><b> {{ $locations->unique('line_id')->sum('coverage_amount')}} </b></td>
                                <td height="30"  style="{{ $styleFont14 }}" align="right"> <b>{{ $locations->unique('line_id')->sum('coverage_amount')}} </b></td>
                                <td height="30"></td>
                                <td height="30" > </td>
                                <td height="30" style="{{ $styleFont14 }}"></td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($loop->last)
                        <tr>
                            <td height="30" style="{{ $styleFont14 }}"  align="center" colspan="2"><b>รวมทั้งสิ้น</b></td>
                            <td height="30"  style="{{ $styleFont14 }}" align="right"><b>{{ $assets->unique('line_id')->sum('current_cost') }} </b></td>
                            <td height="30"  style="{{ $styleFont14 }}" align="right"><b>{{ $assets->unique('line_id')->sum('coverage_amount') }} </b></td>
                            <td height="30" style="{{ $styleFont14 }}"  align="right"><b>{{ $assets->unique('line_id')->sum('coverage_amount') }} </b></td>
                            <td height="30" style="{{ $styleFont14 }}" > {{ $assets[0]->premium_rate }} </td>
                            <td height="30" style="{{ $styleFont14 }}" > <b>{{ $assets->unique('line_id')->sum('insurance_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 )) }} </b></td>
                            <td  height="30" style="{{ $styleFont14 }}"></td>
                        </tr>
                    @endif
                @endforeach
                    <tr>
                        <td style="font-size: 14px" height="30" align="right" colspan="6">   <b>ค่าเบี้ยประกันภัยก่อนคำนวณภาษีมูลค่าเพิ่ม </b></td>
                        <td style="font-size: 14px" height="30"><b> {{ $assets->unique('line_id')->sum('insurance_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 )) }} </b> </td>
                        <td style="font-size: 14px" height="30"> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" height="30" align="right" colspan="6">  <b> ค่าอากรแสตมป์ </b></td>
                        <td style="font-size: 14px" height="30"> <b>{{ $assets->unique('line_id')->sum('duty_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 ))  }}</b>  </td>
                        <td style="font-size: 14px" height="30"> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" height="30" align="right" colspan="6">  <b> รวมเบี้ยบวกอากรแสตมป์ </b></td>
                        <td style="font-size: 14px" height="30"> <b> {{  ($assets->unique('line_id')->sum('insurance_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 ))) + $assets->unique('line_id')->sum('duty_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 ))  }}</b>  </td>
                        <td style="font-size: 14px" height="30"> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" height="30" align="right" colspan="6"> <b>ค่าภาษีมูลค่าเพิ่ม </b> </td>
                        <td style="font-size: 14px" height="30"><b> {{   $assets->unique('line_id')->sum('vat_amount')  *  (1 * round($assets[0]->prepaid_insurance * 0.01, 2 )) }} </b></td>
                        <td style="font-size: 14px" height="30"> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" height="30" align="right" colspan="6"><b> รวมเบี้ยบวกอากรแสตมป์ และ ภาษีมูลค่าเพิ่ม </b> </td>
                        <td style="font-size: 14px" height="30"> <b>{{ (($assets->unique('line_id')->sum('insurance_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 ))) + $assets->unique('line_id')->sum('duty_amount') * (1 * round($assets[0]->prepaid_insurance * 0.01, 2 ))) +  $assets->unique('line_id')->sum('vat_amount')  *  (1 * round($assets[0]->prepaid_insurance * 0.01, 2 )) }} </b> </td>
                        <td style="font-size: 14px" height="30"> </td>
                    </tr>
            </table>
            @endforeach
        @endforeach
    </body>
</html>