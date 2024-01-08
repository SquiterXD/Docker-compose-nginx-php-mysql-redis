<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $programCode->program_code }} - {{ $progTitle }}</title>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('om.reports._style')
        <style>
            body {
                font-size: 13px;
                line-height: 1.35;
            }
            th {
                padding:0px
            }
        </style>
    </head>
    <body>
    @php
        $colspan=13;
        function set_number($number) {
            if($number < 0) {
                $number = "(".number_format(abs($number), 2).")";
            } else {
                $number = number_format(abs($number), 2);
            }

            return $number;
        }
    @endphp
        <table class="table">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}">

                        <div class="row">
                            <div style="width:20%;text-align:left;white-space: nowrap" class="b">
                                โปรแกรม : {{ $programCode->program_code }}
                                
                                @if(request()->has('order_type_code'))
                                @php 
                                $getExportOrderType = collect(DB::select("select *
                                            from ptom_transaction_types_all_v
                                            where order_type_id = '".request()->order_type_code. "'"))->first();
                                @endphp
                                {{ ($getExportOrderType->description)}}
                                @endif
                                <br>
                                สั่งพิมพ์ : {{ optional(auth()->user())->username }}
                            </div>
                            <div style="width:60%;text-align:center;white-space: nowrap;" class="b">
                                การยาสูบแห่งประเทศไทย<br>
                                {{ $progTitle }}<br>
                                {!! request()->batch_name !!}<br>
                                ตั้งแต่วันที่ {{ $date_from->format('d/m/Y') }} ถึง {{ $date_to->format('d/m/Y') }}
                            </div>
                            <div style="width:20%;text-align:right;" class="b">
                                วันที่ : {{ parseToDateTh(now()) }}<br>
                                เวลา :  &nbsp; &nbsp; &nbsp; &nbsp; {{ date('H:i', strtotime(now())) }}<br>
                                หน้า : <span class="pagenum">&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>

                            </div>
                        </div>
                    </th>
                </tr>
                <tr style="border-top: 1px solid #000;height:24px;">
                    <th style="text-align:center; vertical-align: bottom;" rowspan="2"> วันที่ขาย</th>
                    <th style="text-align:center; padding-right:15px; vertical-align: bottom;" rowspan="2"> Group ID</th>
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> เจ้าหนี้</th>
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> ลูกหนี้</th>
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> ยอดจำหน่าย</th>
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> รายได้</th>
                    <th colspan="2">ภาษีขาย</th>
                    @if(request()->batch_name != 'ระบบขายต่างประเทศ')
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> ภาษี อบจ ป 1</th>
                    @endif
                    {{-- <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> ค่าแสตมป์ยาสูบ</th> --}}
                    {{-- <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> เงินบำรุง <br> กองทุน สสส.</th> --}}
                    {{-- <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> เงินบำรุง <br> กองทุน กกท.</th> --}}
                    {{-- <th style="text-align:right; padding-right:15px; vertical-align: bottom;" rowspan="2"> เงินบำรุง <br> องค์การฯ</th> --}}
                </tr>
                <tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;height:24p;">
                    
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;"> ส่วนกลาง</th>
                    <th style="text-align:right; padding-right:15px; vertical-align: bottom;"> ภูมิภาค</th>
                    
                </tr>
                <tr style="height:8px;">
                    <td colspan="{{ $colspan }}"></td>
                </tr>
            </thead>
            <tbody>
                @php 
                    $total = array();
                @endphp
                @foreach($items as $date => $item_group_id)
                @foreach($item_group_id as $group_id =>$item)
                @php 
                    $item = collect($item);
                    @$total['columns_1'] +=  $item->sum('columns_1');
                    @$total['columns_2'] +=  $item->sum('columns_2');
                    @$total['columns_3'] +=  $item->sum('columns_3');
                    @$total['columns_4'] +=  $item->sum('columns_4');
                    @$total['columns_5'] +=  $item->sum('columns_5');
                    @$total['columns_6'] +=  $item->sum('columns_6');
                    @$total['columns_7'] +=  $item->sum('columns_7');
                @endphp
            
                <tr>
                    <td style="text-align:center; padding-right:15px; vertical-align: bottom;">{{ Carbon\Carbon::createFromFormat('Y-m-d', $date)->addYears('543')->format('d/m/Y')}}</td>
                    <td style="text-align:center; padding-right:15px; vertical-align: bottom;">{{ $group_id }}</td>
                    {{-- เจ้าหนี้ --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_1'))}}</td>
                    {{-- ลูกหนี้ --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_2'))}}</td>
                    {{-- ยอดจำหน่าย --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_3'))}}</td>  
                    {{-- รายได้ --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_4'))}}</td>
                    {{-- ภาษีขายส่วนกลาง --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_5'))}}</td>
                    {{-- ภาษีขายภูมิภาค --}}
                    <td style="text-align: right">{{ set_number($item->sum('columns_6'))}}</td>
                    {{-- ภาษี อบจ. 100% --}}
                    @if(request()->batch_name != 'ระบบขายต่างประเทศ')
                    <td style="text-align: right">{{ set_number($item->sum('columns_7'))}}</td>
                    @endif
                    {{-- <td style="text-align: right">0.00</td> --}}
                    {{-- <td style="text-align: right">0.00</td> --}}
                    {{-- <td style="text-align: right">0.00</td> --}}
                    {{-- <td style="text-align: right">0.00</td> --}}
                </tr>
                @endforeach
                @endforeach
                <tr style="height: 28px">
                    <td style="border-top:1px solid #000;"></td>
                    <td style="border-top:1px solid #000;">ยอดสุทธิ</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_1'], 2) }}</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_2'], 2) }}</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_3'], 2) }}</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_4'], 2) }}</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_5'], 2) }}</td>
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_6'], 2) }}</td>
                    @if(request()->batch_name != 'ระบบขายต่างประเทศ')
                    <td style="border-top:1px solid #000;text-align: right">{{ number_format(@$total['columns_7'], 2) }}</td>
                    @endif
                    {{-- <td style="border-top:1px solid #000;text-align: right">0.00</td> --}}
                    {{-- <td style="border-top:1px solid #000;text-align: right">0.00</td> --}}
                    {{-- <td style="border-top:1px solid #000;text-align: right">0.00</td> --}}
                    {{-- <td style="border-top:1px solid #000;text-align: right">0.00</td> --}}
                </tr>
            </tbody>
        </table>

        @if(count($getRMA->where('orderHeader.product_type_code', request()->product_type_code)) > 0) 
        หมายเหตุรายการ : <br>
        <table style="width:100%;">
            <tr>
                <th>ลำดับ</th>
                <th>เลขที่ใบลดหนี้</th>
                <th>วันที่สร้างรายการลดหนี้</th>
                <th>เลขที่ใบ Invoice</th>
                <th>วันที่ Invoice</th>
                <th>ชื่อร้านค้า</th>
                <th>สินค้า</th>
                <th>จำนวน บุหรี่(พันมวน)/ยาเส้น(หีบ)</th>
                <th>มูลค่า</th>
            </tr>
            @php 
                $total_qty = 0;
                $total_amount = 0;
            @endphp
            @foreach($getRMA->where('orderHeader.product_type_code', request()->product_type_code) as $k => $rma) 
                @foreach($rma->lines as $i => $line)
                <tr>
                    <td>
                        @if($i == 0)
                        {{ $k+1 }}
                        @endif
                    </td>
                    <td>
                        @if($i == 0)
                        {{ ($rma->credit_note_number) }}
                        @endif
                    </td>
                    <td> 
                        @if($i == 0)
                            @php
                            try {
                                echo Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rma->rma_date)->format('d/m/Y');
                            } catch (\Throwable $th) {
                                echo 'วันที่ไม่ถูกต้อง';
                            }
                            @endphp
                        @endif
                    </td>
                    <td> 
                        @if($i == 0)
                        {{ ($rma->ref_invoice_number) }}
                        @endif
                    </td>
                    <td>
                        @if($i == 0)
                        @php
                            try {
                                echo Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rma->invoice_date)->format('d/m/Y');
                            } catch (\Throwable $th) {
                                echo 'วันที่ไม่ถูกต้อง';
                            }
                            @endphp
                        @endif
                    </td>
                    <td>
                        @if($i == 0)
                        {{ ($rma->customer->customer_name) }}
                        @endif
                    </td>
                    <td>{{$line->orderLine->item_description}}</td>
                    @php 
                    $total_qty += $line->rma_quantity;
                    $total_amount += $line->rma_quantity * $line->orderLine->unit_price;
                    @endphp
                    <td align="right">{{number_format($line->rma_quantity, 2)}}</td>
                    <td align="right">{{number_format($line->rma_quantity * $line->orderLine->unit_price, 2)}}</td>
                </tr>
                @endforeach
            @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>รวมทั้งสิ้น</th>
                <th align="right">{{ number_format($total_qty, 2) }}</th>
                <th align="right">{{ number_format($total_amount, 2) }}</th>
            </tr>
        </table>

        @endif
        {{-- <div class="row" style="padding-top:20px;text-align:center">จบรายงาน</div> --}}

        {{-- <div style="padding-top:2px;text-align:right">
                <div>ผู้จัดทำ ________________________________ </div><br>
                <div>ผู้ตรวจสอบ ________________________________</div><br>
        </div> --}}
    </body>
</html>
