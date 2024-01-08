<div>
    @php
        $itemId = array('item' => $list->inventory_item_id)
    @endphp

    <div class="row" style="padding-top: 10px;">
        <div class="col-md-6" style="word-wrap: break-word;">
            {{-- <h4>วันที่  {{ date(trans('date.format'),strtotime($list->plan_date)) }} </h4> --}}
            <h4>วันที่  {{ parseToDateTh($list->plan_date) }} </h4>
            <h4>รายการพัสดุ  {{ $list->item_number }}  {{ $list->description }}</h4>
        </div>
        <div class="col-md-6 text-right">
            <img src="data:image/png;base64, {{\DNS2D::getBarcodePNG($list->item_number, 'QRCODE')}}" alt="barcode" style="height: 100px; width: 100px;" />
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 20px;">
        <thead>
            <tr> 
                <th>ชุดเครื่องจักร</th>
                <th>ปริมาณที่ต้องใช้</th>
                {{-- <th>คงคลังเช้าหน้าเครื่อง</th>
                <th>วางหน้าเครื่องสูงสุด</th>
                <th>ปริมาณที่สามารถเบิกได้</th> --}}
                <th>หน่วยนับ</th>
            </tr>
        </thead>
        <tbody>
            @php
                $lines      = getLineDetail(auth()->user()->organization_id, date('d-M-Y', strtotime($planDate)), $list->inventory_item_id);
                $countLines = count($lines);

                if ($hasM05Data) {
                    $total = $list->b - $list->b_m05;
                } else {
                    $total = $list->b;
                }
                
            @endphp
            {{-- @foreach (getLineDetail(auth()->user()->organization_id, date('d-M-Y', strtotime($planDate)), $list->inventory_item_id) as $detail) --}}
            @foreach ($lines as $detail)
                @if ($hasM05Data)
                    @php
                        if ($list->b_m05 > 0) {
                            $cal      = $list->b_m05 / $countLines;
                            $totalCal = $detail->used_qty - $cal;
                        } else {
                            $totalCal = $detail->used_qty;
                        }
                        
                    @endphp
                    <tr>
                        <td> {{ $detail->machine_set . ' : ' . $detail->machine_description }} </td>
                        <td class="text-right"> {{ number_format(ceil($totalCal)) }} </td>
                        <td class="text-center">
                            {{ optional($detail)->detail_uom_desc }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td> {{ $detail->machine_set . ' : ' . $detail->machine_description }} </td>
                        <td class="text-right"> {{ number_format(ceil($detail->used_qty)) }} </td>
                        {{-- <td class="text-right"> {{ $detail->machine_qty }} </td>
                        <td class="text-right"> {{ $detail->max_machine }} </td>
                        <td class="text-right"> {{ $detail->remaining_qty }} </td> --}}
                        <td class="text-center">
                            {{-- {{ optional($detail)->detail_uom_desc }} --}}
                            {{ optional($detail)->detail_uom_desc }}
                        </td>
                    </tr>
                @endif
            @endforeach
            
            <tr>
                <th>รวม</th>
                <th class="text-right">
                    {{ number_format(ceil($total)) }}
                </th>
                <th></th>
            </tr>
        </tbody>
    </table>
    
</div>