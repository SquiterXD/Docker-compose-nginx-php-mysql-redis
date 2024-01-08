{{-- @if ($loop->first)  
    <table width="100%" style="font-size: 16px">
        <tr >
            <td width="20%"></td>
            <td width="70%" align="center"> <span class="p-h2"> <b style="font-size: 16px">  {{ $subInvs[0]->sub_inventory_code }} : {{ $subInvs[0]->sub_inventory_desc }}</b>  </span>  </td>
            <td width="10%"> สถานะ : {{ $locations[0]->status_head }} </td>
        </tr>
        <tr >
            <td width="20%"></td>
            <td width="70%" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ตั้งแต่  {{ $periodFromToIR }} </b>  </span>  </td>
            <td width="10%"> </td>
        </tr>
        <tr >
            <td width="20%"></td>
            <td width="70%" align="center"> <span class="p-h2"> <b style="font-size: 16px"> ปีงบประมาณ  {{ $depts[0]->year + 543}} </b>  </span>  </td>
            <td width="10%"> </td>
        </tr>
    </table>
@endif

<table width="100%" class="table">
    @if ($loop->first)  
        <thead>
            <tr>
                <td colspan="6" align="left" ><b style="font-size: 14px">หน่วยงาน : {{ $depts[0]->department_description }} ,  กลุ่มสินค้าย่อย : {{ $locations[0]->location_desc }}</b></td>
                <td colspan="4"> {{ $company->company_name }} {{ $company->company_percent}}  %</td>
            </td>
        </thead>
        <thead>
            <tr class="body-border-color">
                <th align="center" width="5%"> รหัสพัสดุ</th>
                <th align="left" width="18%"> ชื่อพัสดุ</th>
                <th align="center" width="10%"> Organization</th>
                <th align="center" width="12%"> Item Category</th>
                <th align="center"> ปริมาณ</th>
                <th align="center" > หน่วย</th>
                <th align="center" > ราคา / <br> หน่วย</th>
                <th align="center"> มูลค่าสินค้า <br> (บาท)</th>
                <th align="center"> มูลค่าทุนประกัน <br> (บาท)</th>
                <th align="center"> มูลค่าทุนประกัน <br> (บาท) <br> ตามสัดส่วนบริษัท</th>
            </tr>
        </thead>     
    @endif --}}
        <tbody>
            <tr>
                {{-- {{ dd($items) }} --}}
                <td align="center"                   width="70" class="color-td"> {{ $items[0]->item_code }}  </td>
                <td align="left" class="color-td"   width="250">{{$items[0]->item_description}} {{ $items[0]->line_type == 'MANUAL' ? ' (Manual)' : ""}} </td>
                <td align="center" class="color-td"  width="150">{{$items[0]->organization_code. ': '. $items[0]->organization_name}}</td>
                <td align="center" class="color-td"  width="150">{{$items[0]->itemNumberV->item_cat_code. ' : '. $items[0]->itemNumberV->item_cat_desc}} </td>
                <td align="right" class="color-td"   width="50"> {{ number_format($items[0]->original_quantity, 2) }} </td>
                <td align="center" class="color-td"  width="50">{{ $items[0]->uom->unit_of_measure}}</td>
                <td align="right" class="color-td"   width="50"> {{ number_format($items[0]->unit_price, 2)  }} </td>
                <td align="right" class="color-td"   width="80">{{ number_format($items[0]->line_amount, 2) }} </td>
                <td align="right"  class="color-td"  width="80"> {{ number_format($items[0]->coverage_amount, 2)  }} </td>
                <td align="right" class="color-td"   width="100"> {{ number_format($items[0]->coverage_amount * ($company->company_percent * 0.01), 2)  }} </td>
            </tr>
            @if ($loop->last)
                <tr class="body-border-color">
                    <th align="left" colspan="4" style="padding: 2px"> รวม กลุ่มย่อย : {{ $locations[0]->location_desc }}
                    </th>
                    <th align="right" width="50" style="padding: 2px"> {{ number_format($locations->unique('line_number')->sum('original_quantity'), 2) }} </th>
                    <th align="center" width="50"  style="padding: 2px"> </th>
                    <th align="right" width="50"  style="padding: 2px"></th>
                    <th align="right" width="80" style="padding: 2px"> {{ number_format($locations->unique('line_number')->sum('line_amount'), 2) }} </th>
                    <th align="right" width="80" style="padding: 2px"> {{ number_format($locations->unique('line_number')->sum('coverage_amount'), 2) }} </th>
                    <th align="right" width="100" style="padding: 2px"> {{ number_format($locations->unique('line_number')->sum('coverage_amount') * ($company->company_percent * 0.01), 2) }} </th>
                </tr>
            @endif
            @if ($loop->last && $loop->parent->last)
                <tr class="body-border-color">
                    <th align="left" colspan="4" style="padding: 2px"> รวม คลังสินค้า :  {{ $subInvs[0]->sub_inventory_desc }}
                    </th>
                    <th align="right" width="50"  style="padding: 2px"> {{ number_format($subInvs->unique('line_number')->sum('original_quantity'), 2) }} </th>
                    <th align="center"  width="50"  style="padding: 2px"> </th>
                    <th align="right" width="50"   style="padding: 2px"></th>
                    <th align="right" width="80"  style="padding: 2px"> {{ number_format($subInvs->unique('line_number')->sum('line_amount'), 2) }} </th>
                    <th align="right" width="80" style="padding: 2px"> {{ number_format($subInvs->unique('line_number')->sum('coverage_amount'), 2) }} </th>
                    <th align="right" width="100"  style="padding: 2px"> {{ number_format($subInvs->unique('line_number')->sum('coverage_amount') * ($company->company_percent * 0.01), 2) }} </th>
                </tr>
            @endif
            @if ($loop->parent->parent->last && $loop->last && $loop->parent->last)
                <tr class="body-border-color">
                    <th align="left" colspan="4" style="padding: 2px"> รวม หน่วยงาน :  {{ $depts[0]->department_description }}
                    </th>
                    <th align="right" width="50" style="padding: 2px"> {{ number_format($depts->unique('line_number')->sum('original_quantity'), 2) }} </th>
                    <th align="center" width="50" style="padding: 2px"> </th>
                    <th align="right" width="50"  style="padding: 2px"></th>
                    <th align="right" width="80" style="padding: 2px"> {{ number_format($depts->unique('line_number')->sum('line_amount'), 2) }} </th>
                    <th align="right" width="80" style="padding: 2px"> {{ number_format($depts->unique('line_number')->sum('coverage_amount'), 2) }} </th>
                    <th align="right" width="100" style="padding: 2px"> {{ number_format($depts->unique('line_number')->sum('coverage_amount') * ($company->company_percent * 0.01), 2) }} </th>
                </tr>
            @endif
        </tbody>    
    {{-- </table> --}}