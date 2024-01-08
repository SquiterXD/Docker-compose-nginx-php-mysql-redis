@php
    $i =1;
    $total = $ptirStockHeader->groupBy('sub_inventory_desc')->count();
@endphp
@foreach ($ptirStockHeader->groupBy('department_code')->sortBy('department_code') as $deptCode => $depts)
    @foreach ($depts->groupBy('sub_inventory_desc')->sortBy('sub_inventory_code') as $subInvDes => $subInvs)
        @foreach ($subInvs->groupBy('location_desc')->sortBy('lcation_code') as $locationDesc => $lines)
            @include('ir.reports.irr1010e.pdf._header')
            <table class="table">
                @foreach ($lines as $line)
                    @if ($loop->first)
                        <thead>
                            @php
                                $totalQty =0;
                                $totalLineAmount =0;
                                $totalCoverageAmount =0;
                                $totalQty += $lines->sum('original_quantity');
                                $totalLineAmount += $lines->sum('line_amount');
                                $totalCoverageAmount += $lines->sum('coverage_amount');
                            @endphp
                            
                            <tr>
                                <th colspan="9" align="left"><b> หน่วยงาน : {{  $depts->first()->department_description }}</b> </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="9" align="left"><b> คลังสินค้า : {{  $subInvDes }}</b> </th>
                                <th>หน้า : {{ $i++ }} / {{ $total  }}</th>
                            </tr>
                            <tr>
                                <th colspan="10" align="left" ><b>กลุ่มสินค้าย่อย :{{ $locationDesc }}</b>
                                </th>
                            </tr>
                        <tr class="body-border-color">
                            <td align="center" width="5%"> รหัสพัสดุ</td>
                            <td align="center" width="20%"> ชื่อพัสดุ</td>
                            <td align="center" width="15%"> Organization</td>
                            <td align="center"> Item Category <br> Code </td>
                            <td align="center"> Item Category <br> Description</td>
                            <td align="center"> ปริมาณ</td>
                            <td align="center"> หน่วย</td>
                            <td align="center"> ราคา / หน่วย</td>
                            <td align="center"> มูลค่าสินค้า (บาท)</td>
                            <td align="center"> มูลค่าทุนประกัน (บาท)</td>
                        </tr>
                    </thead>
                    @endif
                        <tr>
                            <td align="center">{{ $line->item_code }} </td>
                            <td>{{ $line->item_description }}</td>
                            <td>{{ $line->organization_code}} :  {{ $line->organization_name }}</td>
                            <td align="center">{{ $line->item_cat_code }}</td>
                            <td align="center">{{ $line->item_cat_segment2_desc}}</td>
                            <td align="right">{{  number_format($line->original_quantity, 2)  }}</td>
                            <td align="center">{{ $line->uom_desc }}</td>
                            <td align="right">{{ number_format($line->unit_price , 2) }}</td>
                            <td align="right">{{ number_format($line->line_amount , 2) }}</td>
                            <td align="right">{{ number_format($line->coverage_amount , 2)  }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5">รวม กลุ่มสินค้าย่อย :{{ $locationDesc }}</td>
                        <td align="right">{{ number_format($lines->sum('original_quantity'), 2) }}</td>
                        <td></td>
                        <td></td>
                        <td align="right">{{ number_format($lines->sum('line_amount'), 2)  }}</td>
                        <td align="right">{{ number_format($lines->sum('coverage_amount'), 2)  }}</td>
                    </tr>
                    @if ($loop->last)

                        <tr>
                            <td colspan="5" >รวม คลังสินค้า :{{ $subInvDes }}</td>
                            <td align="right">{{ number_format($subInvs->sum('original_quantity'), 2) }}</td>
                            <td></td>
                            <td></td>
                            <td align="right">{{ number_format($subInvs->sum('line_amount'), 2)  }}</td>
                            <td align="right">{{ number_format($subInvs->sum('coverage_amount'), 2)  }}</td>
                        </tr>
                    @endif
                    @if ($loop->parent->last)
                        <tr>
                            <td colspan="5" >รวม คลังสินค้า :{{ $depts->first()->department_description }}</td>
                            <td align="right">{{ number_format($depts->sum('original_quantity'), 2) }}</td>
                            <td></td>
                            <td></td>
                            <td align="right">{{ number_format($depts->sum('line_amount'), 2)  }}</td>
                            <td align="right">{{ number_format($depts->sum('coverage_amount'), 2)  }}</td>
                        </tr>
                        <tr>
                            <th colspan="10" ></th>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="page-break"></div>
            @endforeach
    @endforeach
@endforeach

