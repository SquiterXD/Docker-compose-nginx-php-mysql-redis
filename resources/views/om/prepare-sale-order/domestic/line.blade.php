แสดงทั้งหมด {{ number_format(count($orderLists),0) }} รายการ

<table class="table table-hover table-responsive domestic_tablex" style="font-size: 14px;">
    <thead>
        <tr>
            <th style="width: 5%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบสั่งซื้อ </div> 
            </th>
            <th style="width: 8%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบเตรียมขาย </div>
            </th>
            {{-- <th style="width: 7%;" class="text-center" style="vertical-align: middle;">
               <div> รหัสลูกค้า </div>
            </th> --}}
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> ประเภทสินค้า </div>
            </th>
            <th style="width: 15%;" class="text-left" style="vertical-align: middle;">
               <div> ชื่อลูกค้า </div>
            </th>
            <th style="width: 8%;" class="text-center" style="vertical-align: middle;">
               <div> วันส่งประจำสัปดาห์ </div>
            </th>
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> วันที่สั่ง </div>
            </th>
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> วันที่ส่ง </div>
            </th>
            <th style="width: 7%;" class="text-center" style="vertical-align: middle;">
               <div> ยอด </div>
            </th>
            <th style="width: 10%;" class="text-center" style="vertical-align: middle;">
               <div> ประเภทการจ่ายเงิน </div>
            </th>
            {{-- <th style="width: 10%;" class="text-left" style="vertical-align: middle;">
               <div> Order Type </div>
            </th> --}}
            {{-- <th style="width: 12%;" class="text-center" style="vertical-align: middle;">
               <div> สถานะใบสั่งซื้อ </div>
            </th> --}}
        </tr>
    </thead>
    <tbody>
        @if (count($orderLists) == 0)
            <tr>
                <td colspan="10" class="text-center" style="vertical-align: middle; width: 100%;">
                    <h2> ไม่พบข้อมูลที่ค้นหา </h2>
                </td>
            </tr>
        @else
            @foreach ($orderLists as  $line)
                @php
                @endphp
                <tr style="{{ $line->is_over_quota ? 'color: red;' : '' }}">
                    <td class="text-center">
                        <div > <small>{{ $line->order_number ?? '-' }}</small> </div>
                    </td>
                    <td class="text-center">
                        <div >
                            <small>
                                @if ($line->prepare_order_number)
                                    @if ($line->program_code == 'OMP0020')
                                        <a href="{{ route('om.prepare-saleorder.omp0020', $line->prepare_order_number) }}" target="_blank">
                                            {{ $line->prepare_order_number }} &nbsp; @include('om.prepare-sale-order._status', ['status' =>  $line->order_status ])
                                        </a>
                                    @else
                                        <a href="{{ route('om.order.prepare.search', ['prepare_order_number' => $line->prepare_order_number]) }}" target="_blank">
                                            {{ $line->prepare_order_number }} &nbsp; @include('om.prepare-sale-order._status', ['status' =>  $line->order_status ])
                                        </a>
                                    @endif
                                @else
                                    -
                                @endif
                            </small>
                        </div>
                    </td>
                    {{-- <td class="text-center">
                        <div > <small>{{ optional($line->customer)->customer_number ?? '-' }}</small> </div>
                    </td> --}} 
                    <td class="text-center">
                        <div > <small>{{ optional($line->producttype)->description ?? '-' }}</small> </div>
                    </td>
                    <td class="text-left">
                        <div >
                            <small>{{ optional($line->customer)->customer_number ?? '-' }} : {{ optional($line->customer)->customer_name ?? '-' }}</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <div > <small>{{ optional($line->customer)->delivery_date ?? '-' }}</small> </div>
                    </td>
                    <td class="text-center">
                        <div > <small>{{ $line->order_date? parseToDateTh(date('d/m/Y', strtotime($line->order_date))): '-' }}</small> </div>
                    </td>
                    <td class="text-center"> 
                        <div > <small>{{ $line->delivery_date? parseToDateTh(date('d/m/Y', strtotime($line->delivery_date))): '-' }}</small> </div>
                    </td>
                    <td class="text-right">
                        <div > <small>{{ number_format((($line->cash_amount + $line->fines_amount) - $line->remaining_amount), 2) }}</small> </div>
                    </td>
                    <td class="text-center">
                        <div > <small>{{ optional($line->paymentType)->description ?? '-' }}</small> </div>
                    </td>
                    {{-- <td class="text-left">
                        <div > <small>{{ optional($line->orderType)->order_type_name ?? '-' }}</small> </div>
                    </td> --}}
                   {{--  <td class="text-center">
                        <div > @include('om.prepare-sale-order._status', ['status' =>  $line->order_status ]) </div>
                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if(count($orderLists) > 0)
    {{-- <div class="ibox-content"> --}}
        <div class="text-right">
            {{-- {!! $orderLists->appends($_GET)->links() !!} --}}
        </div>
    {{-- </div> --}}
@endif