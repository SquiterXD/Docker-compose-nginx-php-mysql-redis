<table class="table table-hover table-responsive export_tablex">
    <thead>
        <tr>
            <th style="width: 10%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบสั่งซื้อ </div> 
            </th>
            <th style="width: 7%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบ SA </div>
            </th>
            <th style="width: 7%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบ PI </div>
            </th>
            <th style="width: 10%;" class="text-center" style="vertical-align: middle;">
               <div> เลขที่ใบ Invoice </div>
            </th>
            <th style="width: 7%;" class="text-center" style="vertical-align: middle;">
               <div> รหัสลูกค้า </div>
            </th>
            <th style="width: 7%;" class="text-left" style="vertical-align: middle;">
               <div> ชื่อลูกค้า </div>
            </th>
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> วันที่สั่ง </div>
            </th>
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> วันที่ส่ง </div>
            </th>
            <th style="width: 12%;" class="text-center" style="vertical-align: middle;">
               <div> ประเภทการจ่ายเงิน </div>
            </th>
            <th style="width: 10%;" class="text-center" style="vertical-align: middle;">
               <div> Order Type </div>
            </th>
            <th style="width: 6%;" class="text-center" style="vertical-align: middle;">
               <div> สกุลเงิน </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($orderLists) == 0)
            <tr>
                <td colspan="11" class="text-center" style="vertical-align: middle; width: 100%;">
                    <h2> ไม่พบข้อมูลที่ค้นหา </h2>
                </td>
            </tr>
        @else
            @foreach ($orderLists as $header)
                @if (count($header->lines) > 0)
                    @foreach ($header->lines as $line)
                        <tr>
                            <td class="text-center">
                                <div style="width: 150px;"> <small>{{ $header->order_number ?? '-' }}</small> </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 150px;">
                                    @if ($header->prepare_order_number)
                                        <small> <a href="{{ route('om.sale-confirmation.index', ['prepare_order_number' => $header->prepare_order_number, 'order_number' => $header->prepare_order_number? '': $header->order_number]) }}"> {{ $header->prepare_order_number }} </a> </small>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 150px;">
                                    @if (optional($line)->pi_number)
                                        <small>
                                            <a href="{{ route('om.proforma-invoice.index', ['pi_number' => optional($line)->pi_number]) }}"> {{ optional($line)->pi_number }} </a>
                                        </small>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 150px;">
                                    @if ($line->pick_release_no && optional($line)->pi_number != null)
                                        <small> <a href="{{ route('om.tax-invoice-export.index', ['pick_release_no' => $line->pick_release_no, 'pi_number' => optional($line)->pi_number]) }}"> {{ $line->pick_release_no }} </a> </small>
                                    @elseif ($line->pick_release_no)
                                        <small> {{ $line->pick_release_no }} </small>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 150px;"> <small>{{ optional($header->customer)->customer_number ?? '-' }}</small> </div>
                            </td>
                            <td class="text-left">
                                <div style="width: 200px;"> <small>{{ optional($header->customer)->customer_name ?? '-' }}</small> </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 100px;"> <small>{{ $header->order_date? date('d/m/Y', strtotime($header->order_date)): '-' }}</small> </div>
                            </td>
                            <td class="text-center"> 
                                <div style="width: 100px;">
                                    @if (optional($line)->pi_number)
                                        <small>{{ $line->delivery_date? date('d/m/Y', strtotime($line->delivery_date)): '-' }} </small>
                                    @else
                                        <small>{{ $header->delivery_date? date('d/m/Y', strtotime($header->delivery_date)): '-' }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 130px;"> <small>{{ optional($header->paymentType)->description ?? '-' }}</small> </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 120px;"> <small>{{ optional($header->orderType)->order_type_name ?? '-' }}</small> </div>
                            </td>
                            <td class="text-center">
                                <div style="width: 100px;"> <small>{{ $header->currency ?? '-' }}</small> </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">
                            <div style="width: 150px;"> <small>{{ $header->order_number ?? '-' }}</small> </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 150px;">
                                @if ($header->prepare_order_number)
                                    <small> <a href="{{ route('om.sale-confirmation.index', ['prepare_order_number' => $header->prepare_order_number, 'order_number' => $header->prepare_order_number? '': $header->order_number]) }}"> {{ $header->prepare_order_number }} </a> </small>
                                @else
                                    -
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 150px;">
                                @if (optional($header)->pi_number)
                                    <small>
                                        <a href="{{ route('om.proforma-invoice.index', ['pi_number' => optional($line)->pi_number]) }}"> {{ optional($line)->pi_number }} </a>
                                    </small>
                                @else
                                    -
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 150px;">
                                @if ($header->pick_release_no && optional($header)->pi_number != null)
                                    <small> <a href="{{ route('om.tax-invoice-export.index', ['pick_release_no' => $header->pick_release_no, 'pi_number' => optional($header)->pi_number]) }}"> {{ $header->pick_release_no }} </a> </small>
                                @elseif ($header->pick_release_no)
                                    <small> {{ $header->pick_release_no }} </small>
                                @else
                                    -
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 150px;"> <small>{{ optional($header->customer)->customer_number ?? '-' }}</small> </div>
                        </td>
                        <td class="text-left">
                            <div style="width: 200px;"> <small>{{ optional($header->customer)->customer_name ?? '-' }}</small> </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 100px;"> <small>{{ $header->order_date? date('d/m/Y', strtotime($header->order_date)): '-' }}</small> </div>
                        </td>
                        <td class="text-center"> 
                            <div style="width: 100px;"> <small>{{ $header->delivery_date? date('d/m/Y', strtotime($header->delivery_date)): '-' }}</small> </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 130px;"> <small>{{ optional($header->paymentType)->description ?? '-' }}</small> </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 120px;"> <small>{{ optional($header->orderType)->order_type_name ?? '-' }}</small> </div>
                        </td>
                        <td class="text-center">
                            <div style="width: 100px;"> <small>{{ $header->currency ?? '-' }}</small> </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
    </tbody>
</table>
@if(count($orderLists) > 0)
    <div class="text-right">
        {{-- {!! $orderLists->appends($_GET)->links() !!} --}}
    </div>
@endif