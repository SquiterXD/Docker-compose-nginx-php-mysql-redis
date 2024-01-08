<div class="mt-5">
    <h4>วัตถุดิบที่ใช้</h4>
    <div class="ml-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th> 
                            <div class="text-center" style="width: 80px;">ลำดับขั้นตอน </div> 
                        </th> --}}
                        <th> 
                            <div class="text-center" style="width: 80px;">ลำดับวัตถุดิบ </div>
                        </th>
                        <th> 
                            <div class="text-center" style="width: 80px;">รหัสวัตถุดิบ</div>
                        </th>
                        <th> 
                            <div class="text-center" style="width: 180px;">รายละเอียด</div>
                        </th>
                        <th> <div class="text-center" style="width: 90px;">จำนวนตามสูตร</div>  </th>
                        <th> <div class="text-center" style="width: 60px;">% สูญเสีย</div>      </th>
                        <th> <div class="text-center" style="width: 100px;">ปริมาณที่ต้องใช้</div>  </th>
                        <th> <div class="text-center" style="width: 60px;">หน่วยนับ</div>       </th>
                        <th> <div class="text-center" style="width: 120px;">สถานะการใช้งาน</div> </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $line = 10;
                    @endphp
                    @foreach ($lines as $item)
                        <tr>
                            {{-- <td class="text-center">{{ $item->ingredient_step_line }}</td> --}}
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->segment1 }}</td>
                            <td>{{ $item->description }}</td>
                            {{-- แสดง 5 ตำแหน่ง ตามคุยกับ IT --}}
                            <td class="text-right">{{ number_format($item->ingredient_folmula_qty, 5) }}</td>
                            <td class="text-right">{{ number_format($item->scrap_factor, 5) }}</td>
                            <td class="text-right">{{ number_format($item->ingredient_qty, 5) }}</td>
                            {{-- <td class="text-center">{{ $item->item ?  $item->item->primary_uom_code : '' }}</td> --}}
                            <td>{{ getUomDesc($item) ?  getUomDesc($item) : '' }}</td>
                            <td class="text-center">
                                @include('shared._status_active', ['isActive' => $item->enable_flag == 'Y'])
                            </td>
                        </tr>
                        @php
                            $line += 10;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>