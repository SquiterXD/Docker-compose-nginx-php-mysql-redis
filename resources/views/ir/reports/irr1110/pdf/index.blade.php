<!DOCTYPE html>
<html>
    <head>
        {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
        @include('ir.reports.irr1110._style')
        <script>
            function subst() {
                console.log('xxxxxxx');
                var vars = {};
                var query_strings_from_url = document.location.search.substring(1).split('&');
                for (var query_string in query_strings_from_url) {
                    if (query_strings_from_url.hasOwnProperty(query_string)) {
                        var temp_var = query_strings_from_url[query_string].split('=', 2);
                        vars[temp_var[0]] = decodeURI(temp_var[1]);
                    }
                }
                var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
                for (var css_class in css_selector_classes) {
                    if (css_selector_classes.hasOwnProperty(css_class)) {
                        var element = document.getElementsByClassName(css_selector_classes[css_class]);
                        for (var j = 0; j < element.length; ++j) {
                            element[j].textContent = vars[css_selector_classes[css_class]];
                        }
                    }
                }
            }
            // function subst() {
            //     var vars = {};
            //     var query_strings_from_url = document.location.search.substring(1).split('&');
            //     for (var query_string in query_strings_from_url) {
            //         if (query_strings_from_url.hasOwnProperty(query_string)) {
            //             var temp_var = query_strings_from_url[query_string].split('=', 2);
            //             vars[temp_var[0]] = 1;
            //         }
            //     }
            //     var css_selector_classes = ['page1', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
            //     for (var css_class in css_selector_classes) {
            //         if (css_selector_classes.hasOwnProperty(css_class)) {
            //             var element = document.getElementsByClassName(css_selector_classes[css_class]);
            //             console.log(element)
            //             var c = document.getElementsByTagName('table')

            //             for (var j = 0; j < element.length; ++j) {
                            
            //                 element[j].textContent = document.getElementsByClassName('theader').length;
            //             }
            //         }
            //     }
            // }
            // function subst() {
            //     var c = document.getElementsByTagName('table')
            //     console.log('test')
            //     // document.querySelector('.page_number').innerHTML = 'test'
            //     // document.getElementsByTagName('table').innerHTML = '12312312312';

            //     for(i = 0; i < c.length ; i++ ) {
            //         c[i].querySelector('.page_number').innerHTML = i +1 ;
            //         console.log(c[i].querySelector('.page_number').innerHTML , c[i])
            //     }
            // }
            
          
        </script>
    </head>
    <body  onload="subst()">
        {{-- {{ dd($companies) }} --}}

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
                            <table width="100%" class="table">
                                <thead class="theader">
                                    <tr >
                                        <td colspan="2" > <span class="p-h2">Program Code : {{ $program->program_code}} </span></td>
                                        <td colspan="5" style="padding-right: 4px" align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
                                        <td colspan="2" ></td>
                                        <td  width="100" >   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
                                        <td colspan="5"  align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
                                        <td colspan="2" ></td>
                                        <td   width="100" ><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" ></td>
                                        <td colspan="5"    align="center"> {{$program->description}}   </td>
                                        <td colspan="2" ></td>
                                        <td  width="100"  >
                                            <div style="margin-top: 0px">  หน้า :  </div>
                                        
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px">   {{ $subInvs[0]->sub_inventory_code }} : {{ $subInvs[0]->sub_inventory_desc }}</b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td  width="100" > </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ตั้งแต่  {{ $periodFromToIR }} </b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td   width="100" > </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ปีงบประมาณ  {{ $depts[0]->year + 543}} </b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td  width="100"  > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="left" ><b style="font-size: 16px"> สถานะ : {{ $locations[0]->status_head }} </b></td>
                                    </tr>
                                   
                                    <tr>
                                        <td colspan="5" align="left" ><b style="font-size: 16px">หน่วยงาน :{{ $depts[0]->department_code }}  -  {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย :  {{ $locations[0]->location_code}} - {{ $locations[0]->location_desc }} </b></td>
                                        <td colspan="2"></td>
                                        <td colspan="5" width="100"  align="right" ><b style="font-size: 16px"> {{ $company->company_name }} {{ $company->company_percent}}  % </b></td>
                                    </tr>
                                    <tr class="body-border-color">
                                        <th align="center"  width="70"> รหัสพัสดุ</th>
                                        <th align="center"  width="250"> ชื่อพัสดุ</th>
                                        <th align="center"  width="150"> Organization</th>
                                        <th align="center" width="150" > Item Category</th>
                                        <th align="center"  width="50"> ปริมาณ</th>
                                        <th align="center" width="50" > หน่วย</th>
                                        <th align="center"  width="50"> ราคา / <br> หน่วย</th>
                                        <th align="center" width="80"> มูลค่าสินค้า <br> (บาท)</th>
                                        <th align="center"  width="80"> มูลค่าทุนประกัน <br> (บาท)</th>
                                        <th align="center"  width="100"> มูลค่าทุนประกัน <br> ตามสัดส่วนบริษัท</th>
                                    </tr>
                                </thead>
                            {{-- @foreach ($locations->groupBy('item_code')->chunk(18) as $key =>  $uItems) --}}
                                        @foreach ($locations->sortBy('item_code')->sortBy('line_type')->groupBy(function($q) {
                                                return $q->item_code.'_'.$q->line_type;
                                            }) as $key => $items)    
                                            @include('ir.reports.irr1110.pdf._table_companies')
                                            @if ($loop->last)
                                                <div class="page-break"></div>
                                            @endif
                                        @endforeach
                            </table>
                                {{-- @endforeach --}}
                        <div class="page-break"></div>
                        @endforeach
                        <div class="page-break"></div>
                    @endforeach
                <div class="page-break"></div>
                @endforeach
            @endforeach
        @else
        {{-- {{ dd('xxxxx') }} --}}

            @foreach ($reportStocks->sortBy('department_code')->sortBy('department_code')->groupBy('department_code') as $deptCode => $depts)
                @foreach ($depts->sortBy('sub_inventory_code')->sortBy('sub_inventory_code')->groupBy('sub_inventory_code') as $subInvCode => $subInvs)
                    @foreach ($subInvs->sortBy('location_code')->sortBy('location_code')->groupBy('location_code') as $locationCode => $locations)
                        {{-- @foreach ($locations->groupBy('item_code')->chunk(18) as $key =>  $uItems) --}}

                        <div class="page-break">
                            <div class="page-break"></div>
                            <table width="100%">
                                {{-- <thead>
                                    <tr>
                                        <td colspan="10" align="left" ><b style="font-size: 14px">หน่วยงาน : {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย : {{ $locations[0]->location_desc }}</b>
                                    </td>
                                    </tr>
                                </thead> --}}
                                <thead class="theader">
                                    <tr >
                                        <td colspan="2" > <span class="p-h2">Program Code : {{ $program->program_code}} </span></td>
                                        <td colspan="5" style="padding-right: 4px" align="center"> <span class="p-h2"> การยาสูบแห่งประเทศไทย </span>  </td>
                                        <td colspan="2" ></td>
                                        <td colspan="2"  width="100" >   <span class="p-h2"> วันที่ :  {{ Carbon\Carbon::now()->addYear('543')->format('d/m/Y') }} </span> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >  สั่งพิมพ์ : {{  $userProfile->user_name}} </td>
                                        <td colspan="5" align="center"> <span class="p-h2"> ชุดที่ : {{ $reportStocks[0]->policy_set_header_id. ' : '. $reportStocks[0]->policy_set_description}} </span></td>
                                        <td colspan="2" ></td>
                                        <td colspan="2"  width="100" ><span class="p-h2"> เวลา : {{ Carbon\Carbon::now()->format('H:i') }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" ></td>
                                        <td colspan="5"    align="center"> {{$program->description}}   </td>
                                        <td colspan="2" ></td>
                                        <td colspan="2"  width="100" > <div style="margin-top: 0px">  หน้า :  </div> </td>
  
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px">   {{ $subInvs[0]->sub_inventory_code }} : {{ $subInvs[0]->sub_inventory_desc }}  </b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td colspan="2" width="100"  > </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ตั้งแต่  {{ $periodFromToIR }} </b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td colspan="2"  width="100" > </td>
                                    </tr>
                                    <tr >
                                        <td colspan="2" ></td>
                                        <td colspan="5" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ปีงบประมาณ  {{ $depts[0]->year + 543}} </b>  </span>  </td>
                                        <td colspan="2" ></td>
                                        <td colspan="2"  width="100" > </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" align="left" ><b style="font-size: 16px"> สถานะ : {{ $locations[0]->status_head }} </b></td>
                                    </tr>
                                   
                                    <tr>
                                        <td colspan="10" align="left" ><b style="font-size: 16px">หน่วยงาน :{{ $depts[0]->department_code }}  -  {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย :  {{ $locations[0]->location_code}} - {{ $locations[0]->location_desc }}  </b></td>
                                    </tr>
                                    <tr class="body-border-color">
                                        <th align="center"  width="70"> รหัสพัสดุ</th>
                                        <th align="center" width="250"> ชื่อพัสดุ</th>
                                        <th align="center"width="150" > Organization</th>
                                        <th align="center"width="150" > Item Category</th>
                                        <th align="center" width="50" > ปริมาณ</th>
                                        <th align="center" width="50" > หน่วย</th>
                                        <th align="center" width="50" > ราคา / <br> หน่วย</th>
                                        <th align="center" width="80" > มูลค่าสินค้า <br> (บาท)</th>
                                        <th align="center" width="80" > มูลค่าทุนประกัน <br> (บาท)</th>
                                        <th align="center" width="100" > มูลค่าทุนประกัน <br> ตามสัดส่วนบริษัท</th>
                                    </tr>
                                </thead>   
                                {{-- {{ dd($locations->sortBy('item_code')->groupBy(function($q) {
                                    return $q->item_code.'_'.$q->line_type;
                                    })) }} --}}
                                    @foreach ($locations->sortBy('item_code')->sortBy('line_type')->groupBy(function($q) {
                                        return $q->item_code.'_'.$q->line_type;
                                        }) as $key => $items)  
                
                                        @include('ir.reports.irr1110.pdf._table')
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

