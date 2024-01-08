<!DOCTYPE html>
<html>
    <head>
        {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
        @include('ir.reports.irr1010._style')
            <script>
                function subst() {
                    var vars={};
                    var x=document.location.search.substring(1).split('&');
                    console.log(x);
                    for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
                    var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
                    for (var i in x) {
                        var y = document.getElementsByClassName(x[i]);
                        for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
                    }
                }
            </script>
    </head>
    <body>
        @if ($companies)
            @foreach ($companies as  $company)
                @foreach ($reportStocks->sortBy('department_code')->groupBy('department_code') as $deptCode => $depts)
                    @foreach ($depts->sortBy('sub_inventory_code')->groupBy('sub_inventory_code') as $subInvCode => $subInvs)
                        @foreach ($subInvs->sortBy('location_code')->groupBy('location_code') as $locationCode => $locations)
                        @php
                            $sumLocationQty = 0;             
                            $sumLocationLineAmount  = 0;
                            $sumLocationCA  = 0;
                            $sumLocationCAp  = 0;
                        @endphp 
                        <div class="page-break">
                            <div class="page-break"></div>
                                <table width="1080" class="table">
                                    <thead>
                                        <tr >
                                            <td colspan="2"> <span class="p-h2">Program Code : {{$program->program_code}} </span>  </td>
                                            <td colspan="5"   align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
                                            <td colspan="2"></td>
                                            <td width="100">   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
                                            <td colspan="5" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
                                            <td colspan="2"></td>
                                            <td width="100"><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="5"   align="center"> {{$program->description}} </td>
                                            <td colspan="2"></td>
                                            <td  width="100"><div style="margin-top: 5px">  หน้า :  </div> </td>
                                        </tr>
                                        <tr >
                                            <td colspan="2"></td>
                                            <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px">   {{ $subInvs[0]->sub_inventory_code }} : {{ $subInvs[0]->sub_inventory_desc }}  </b>  </span>  </td>
                                            <td colspan="2"></td>
                                            <td width="100"> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="5"   align="center">  {{ $date['month'] }} </td>
                                            <td colspan="2"></td>
                                            <td width="100"> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">   </td>
                                            <td colspan="5"   align="center">  {{  $date['month_off'] }} </td>
                                            <td colspan="2"></td>
                                            <td width="100"> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="10">
                                                สถานะ : {{ $locations[0]->status_head }} 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" align="left" ><b>หน่วยงาน :{{ $depts[0]->department_code }}  -  {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย :  {{ $locations[0]->location_code}} - {{ $locations[0]->location_desc }}</b>
                                            <td colspan="5" align="right" ><b> {{ $company->company_name }} {{ $company->company_percent}}  % </b></td>
                                        </tr>
                                        <tr class="body-border-color">
                                            <th align="center" width="70"> รหัสพัสดุ</th>
                                            <th align="center" width="250"> ชื่อพัสดุ</th>
                                            <th align="center" width="150"> Organization</th>
                                            <th align="center" width="150"> Item Category</th>
                                            <th align="center" width="50"> ปริมาณ</th>
                                            <th align="center" width="50"> หน่วย</th>
                                            <th align="center" width="50"> ราคา / <br> หน่วย</th>
                                            <th align="center" width="80"> มูลค่าสินค้า <br> (บาท)</th>
                                            <th align="center" width="80"> มูลค่าทุนประกัน <br> (บาท)</th>
                                            <th align="center" width="100"> มูลค่าทุนประกัน <br> ตามสัดส่วนบริษัท</th>
                                        </tr>
                                    </thead>     
                                    @foreach ($locations->sortBy('item_code')->sortBy('line_type')->groupBy(function($q) {
                                        return $q->item_code.'_'.$q->line_type;
                                        }) as $key => $items)  
                                        @include('ir.reports.irr1010.pdf._table_companies')
                                        @if ($loop->last)
                                            <div class="page-break"></div>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            {{-- @foreach ($locations->groupBy('item_code')->chunk(18) as $key =>  $uItems)
                                @foreach ($uItems as $key => $items)
                                    @include('ir.reports.irr1010.pdf._table_companies')
                                    @if ($loop->last)
                                        <div class="page-break"></div>
                                    @endif
                                    @endforeach
                                @endforeach --}}
                        {{-- <div class="page-break"></div> --}}
                        @endforeach
                        {{-- <div class="page-break"></div> --}}
                    @endforeach
                {{-- <div class="page-break"></div> --}}
                @endforeach
            @endforeach
        @else
            @foreach ($reportStocks->sortBy('department_code')->groupBy('department_code') as $deptCode => $depts)
                @foreach ($depts->sortBy('sub_inventory_code')->groupBy('sub_inventory_code') as $subInvCode => $subInvs)
                    @foreach ($subInvs->sortBy('location_code')->groupBy('location_code') as $locationCode => $locations)
                        {{-- @foreach ($locations->groupBy('item_code')->chunk(18) as $key =>  $uItems) --}}
                        <div class="page-break">
                            <div class="page-break"></div>
                            <table width="1080" class="table">
                                <thead>
                                    <tr >
                                        <td colspan="2"> <span class="p-h2">Program Code : {{$program->program_code}} </span>  </td>
                                        <td colspan="5"   align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
                                        <td colspan="2" ></td>
                                        <td width="100">   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">  สั่งพิมพ์ : {{  $userProfile->user_name}}   </td>
                                        <td colspan="5" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
                                        <td colspan="2" ></td>
                                        <td width="100"><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="5"   align="center"> {{$program->description}} </td>
                                        <td colspan="2" ></td>
                                        <td width="100"> <div style="margin-top: 5px">  หน้า :  </div></td>
                                    </tr>
                                    <tr >
                                        <td colspan="2"></td>
                                        <td colspan="5" align="center"> <span class="p-h2">    {{ $subInvs[0]->sub_inventory_code }} : {{ $subInvs[0]->sub_inventory_desc }}   </span>  </td>
                                        <td colspan="2" ></td>
                                        <td width="100" > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="5"   align="center">  {{ $date['month'] }} </td>
                                        <td colspan="2" ></td>
                                        <td  width="100"> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> </td>
                                        <td colspan="5"   align="center">  {{  $date['month_off'] }} </td>
                                        <td colspan="2" ></td>
                                        <td width="100">  </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            สถานะ : {{ $locations[0]->status_head }} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="left" >  <b> หน่วยงาน :{{ $depts[0]->department_code }}  -  {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย :  {{ $locations[0]->location_code}} - {{ $locations[0]->location_desc }} </b></td>
                                    </tr>
                                    
                                    <tr class="body-border-color">
                                        <th align="center" width="70"> รหัสพัสดุ</th>
                                        <th align="center"width="250"> ชื่อพัสดุ</th>
                                        <th align="center"  width="150"> Organization</th>
                                        <th align="center" width="150"> Item Category</th>
                                        <th align="center" width="50"> ปริมาณ</th>
                                        <th align="center" width="50"> หน่วย</th>
                                        <th align="center" width="50"> ราคา / <br> หน่วย</th>
                                        <th align="center" width="80"> มูลค่าสินค้า <br> (บาท)</th>
                                        <th align="center" width="80"> มูลค่าทุนประกัน <br> (บาท)</th>
                                        <th align="center" width="100"> มูลค่าทุนประกัน <br> ตามสัดส่วนบริษัท</th>
                                    </tr>
                                </thead>     
                                @foreach ($locations->sortBy('item_code')->sortBy('line_type')->groupBy(function($q) {
                                    return $q->item_code.'_'.$q->line_type;
                                    }) as $key => $items)  
                                    @include('ir.reports.irr1010.pdf._table')
                                    @if ($loop->last)
                                        <div class="page-break"></div>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                        {{-- @endforeach --}}
                    {{-- <div class="page-break"></div> --}}
                    @endforeach
                    {{-- <div class="page-break"></div> --}}
                @endforeach
                {{-- <div class="page-break"></div> --}}
            @endforeach
        @endif

    </body>
</html>

