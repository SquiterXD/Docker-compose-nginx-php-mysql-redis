<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table{ 
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black
        }
    </style>
</head>

<body>
    @php
        $group = $data->groupBy(function ($i) {
            return $i->cost_code . $i->locator_code;
        });
    @endphp
    @foreach ($group as $items)
        {{-- {{dd($items)}} --}}
        <table style="width:100%">
            <thead>
                <tr>
                    <td>โปรแกรม : CTR0039</td>
                    <td colspan="12" style="text-align: center">การยาสูบแห่งประเทศไทย</td>
                    <td>วันที่ : {{ now()->addYears(543)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>สั่งพิมพ์ : 002695</td>
                    <td colspan="12" style="text-align: center">รายงานปันส่วนผลต่าง - ใบยาอบแล้ว/ทำความสะอาดแล้ว
                        ประจำปี
                    </td>
                    <td>เวลา : {{ now()->addYears(543)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="12" style="text-align: center">วันที่ 01/10/2560 ถึงวันที่ 31/03/2561
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="12" style="text-align: center">ตั้งแต่ศูนย์ต้นทุน :
                        {{ $group->first()->first()->cost_code }} {{ $group->first()->first()->cost_desc }} ถึง :
                        {{ $group->last()->first()->cost_code }} {{ $group->last()->first()->cost_desc }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">ศูนย์ต้นทุน : {{ $items->first()->cost_code }} {{ $items->first()->cost_desc }} </td>
                    <td colspan="10"> โรงอบ/สถานที่ : {{ $items->first()->locator_desc }}
                    </td>
                    <td></td>
                </tr>


                {{-- header --}}
                <tr>
                    <th style="border:1px solid black" rowspan="3">Item</th>
                    <th style="border:1px solid black" rowspan="3">ปริมาณผลผลิต</th>
                    <th style="border:1px solid black" colspan="3" rowspan="2">ต้นทุนมาตรฐาน</th>
                    <th style="border:1px solid black" rowspan="2">ต้นทุนผลิตรวม</th>
                    <th style="border:1px solid black" rowspan="2">ราคาต่อหน่วย</th>
                    <th style="border:1px solid black" colspan="3">ปันส่วนผลต่าง</th>
                    <th style="border:1px solid black" rowspan="2">ผลต่างรวม</th>
                    <th style="border:1px solid black" rowspan="2">ผลต่าง</th>
                    <th style="border:1px solid black" rowspan="2">ต้นทุนผลิตจริง</th>
                    <th style="border:1px solid black" rowspan="2">ราคาต่อหน่วย</th>
                </tr>
                <tr>
                    <th colspan="3">ต้นทุนจริง สูงกว่า/ (ต่ำกว่า) มาตรฐาน</th>
                </tr>
                <tr>
                    <th style="border:1px solid black">วัตถุดิบ</th>
                    <th style="border:1px solid black">ค่าแรงงาน</th>
                    <th style="border:1px solid black">ค่าใช้จ่ายผลิต</th>

                    <th style="border:1px solid black">มาตรฐาน</th>
                    <th style="border:1px solid black">มาตรฐาน</th>

                    <th style="border:1px solid black">วัตถุดิบ</th>
                    <th style="border:1px solid black">ค่าแรงงานทางตรง</th>
                    <th style="border:1px solid black">ค่าใช้จ่ายผลิต</th>

                    <th style="border:1px solid black">(DM+DL+OH)</th>
                    <th style="border:1px solid black">ต่อหน่วย</th>
                    <th style="border:1px solid black">(หลังปรับผลต่าง)</th>
                    <th style="border:1px solid black">(หลังปรับผลต่าง)</th>
                </tr>
                <tr>
                    <th style="border:1px solid black"></th>
                    <th style="border:1px solid black">ก.ก</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                    <th style="border:1px solid black">บาท</th>
                </tr>
                {{-- endheader --}}

                {{-- body Group Type --}}
                @php 
                    $groupType = $items->groupBy('tobacco_type');
                @endphp
                @foreach($groupType as $label_type => $products) 
                <tr>
                    <td style="border:1px solid black">{{ $label_type }}</td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                </tr>

                {{-- body group product --}}
                @php
                $productGroup = $products->groupBy('product_group');
                @endphp
                @foreach($productGroup as $product_group => $lists)

                {{-- body lists --}}
                @foreach($lists as $list)
                <tr>
                    <td style="border:1px solid black">{{ $list->product_item_no }}</td>
                    <td style="border:1px solid black">{{ $list->wip_complete_qty  }}</td>
                    <td style="border:1px solid black">{{ $list->std21_amount  }}</td>
                    <td style="border:1px solid black">{{ $list->std22_amount }}</td>
                    <td style="border:1px solid black">{{ $list->std2324_amount }}</td>
                    <td style="border:1px solid black">{{ $list->std29_amount }}</td>
                    <td style="border:1px solid black">
                        {{ $list->std29_amount / $list->wip_complete_qty }}
                        {{-- {{ $list->std_dl_oh_amount }} --}}
                    </td>
                    <td style="border:1px solid black">{{ $list->dm_variance_amount }}</td>
                    <td style="border:1px solid black">{{ $list->dl_variance_amount  }}</td>
                    <td style="border:1px solid black">{{ $list->oh_variance_amount  }}</td>
                    <td style="border:1px solid black">{{ $list->total_variance }}</td>
                    <td style="border:1px solid black">{{ $list->diff_amount }}</td>
                    <td style="border:1px solid black">{{ $list->actual_cost_amount }}</td>
                    <td style="border:1px solid black">
                        {{ $list->actual_cost_amount / $list->wip_complete_qty }}
                        {{-- {{ $list->actual_cost_amount }} --}}
                    </td>
                </tr>
                
                @endforeach
                <tr>
                    <th style="border:1px solid black">รวม - {{$product_group}}</th>
                    <td style="border:1px solid black">{{ $lists->sum('wip_complete_qty') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('std21_amount')  }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('std22_amount') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('std2324_amount') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('std29_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $lists->sum('std29_amount') / $lists->sum('wip_complete_qty') }}
                        {{-- {{ $lists->sum('std_dl_oh_amount') }} --}}
                    </td>
                    <td style="border:1px solid black">{{ $lists->sum('dm_variance_amount') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('dl_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('oh_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('total_variance') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('diff_amount') }}</td>
                    <td style="border:1px solid black">{{ $lists->sum('actual_cost_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $lists->sum('actual_cost_amount') / $lists->sum('wip_complete_qty') }}
                        {{-- {{ $lists->sum('actual_cost_amount') }} --}}
                    </td>
                </tr>
                {{-- end body lists --}}
                @endforeach
                {{-- end body group product --}}
                <tr>
                    <th style="border:1px solid black">รวม{{ $label_type }}</th>
                    <td style="border:1px solid black">{{ $products->sum('wip_complete_qty') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std21_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std22_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std2324_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std29_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('std29_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('std_dl_oh_amount') }} --}}
                    </td>
                    <td style="border:1px solid black">{{ $products->sum('dm_variance_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('dl_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('oh_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('total_variance') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('diff_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('actual_cost_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('actual_cost_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('actual_cost_amount') }} --}}
                    </td>
                </tr>
                @endforeach
                {{-- end bodoy Group Type --}}
                <tr>
                    <th style="border:1px solid black">รวม{{ $items->first()->locator_desc }}</th>
                    <td style="border:1px solid black">{{ $products->sum('wip_complete_qty') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std21_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std22_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std2324_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std29_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('std29_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('std_dl_oh_amount') }} --}}
                    </td>
                    <td style="border:1px solid black">{{ $products->sum('dm_variance_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('dl_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('oh_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('total_variance') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('diff_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('actual_cost_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('actual_cost_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('actual_cost_amount') }} --}}
                    </td>
                </tr>
                <tr>
                    <th style="border:1px solid black">รวมทั้งสิ้น</th>
                    <td style="border:1px solid black">{{ $products->sum('wip_complete_qty') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std21_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std22_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std2324_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('std29_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('std29_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('std_dl_oh_amount') }} --}}
                    </td>
                    <td style="border:1px solid black">{{ $products->sum('dm_variance_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('dl_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('oh_variance_amount')  }}</td>
                    <td style="border:1px solid black">{{ $products->sum('total_variance') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('diff_amount') }}</td>
                    <td style="border:1px solid black">{{ $products->sum('actual_cost_amount') }}</td>
                    <td style="border:1px solid black">
                        {{ $products->sum('actual_cost_amount') / $products->sum('wip_complete_qty') }}
                        {{-- {{ $products->sum('actual_cost_amount') }} --}}
                    </td>
                </tr>
                <tr>
                    <th style="border:1px solid black" colspan="2">ผลต่างการผลิต / ต้นทุนผลิตจริง</th>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                    <td style="border:1px solid black"></td>
                </tr>
            </thead>
        </table>
    @endforeach
</body>

</html>
