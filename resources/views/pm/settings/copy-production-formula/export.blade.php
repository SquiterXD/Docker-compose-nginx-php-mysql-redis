<div>
    <table  class="table table-responsive-sm table-bordered" style="border: 1px solid #000000;">
        <thead>            
            <tr>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">รหัสสินค้า</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ชื่อสินค้า</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ประเภทสูตร</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ประเภทสิ่งผลิต </th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Version</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">สถานะ</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ขั้นตอนการทำงาน</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ประเภทเครื่องจักร</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">ปีงบประมาณ</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">วันที่เริ่มใช้งาน</th>
                <th class="text-center" style="border: 1px solid #000000; text-align: center; vertical-align: middle;">วันที่สิ้นสุดใช้งาน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataLists as $header)
                <tr>                    
                    <td style="border: 1px solid #000000;"> 
                        {{ $header->item ?  $header->item->item_number : '' }} 
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        {{ $header->item ?  $header->item->item_desc : ''}} 
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        {{ $header->FormulaType ? $header->FormulaType->description : ''  }} 
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        {{ $header->routing ? $header->routing->routing_desc : '' }}
                    </td>
                    <td align="center" style="border: 1px solid #000000;"> 
                        {{ $header->version }} 
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        @if ($header->status == 'Approved for General Use')
                            อนุมัติ
                        @elseif ($header->status == 'New')
                            สร้างใหม่
                        @elseif ($header->status == 'Obsolete/Archived')
                            ยกเลิก
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        {{ $header->opmRouting ? $header->opmRouting->oprn_desc : '' }}
                    </td>
                    <td style="border: 1px solid #000000;"> 
                        @if ($organizationCode == 'M05')
                            {{ $header->machineGroupF ? $header->machineGroupF->description : '' }} 
                        @else
                            {{ $header->machineType ? $header->machineType->description : '' }} 
                        @endif
                    </td> 
                    <td align="center" style="border: 1px solid #000000;"> 
                        {{ $header->period_year }}
                    </td>
                    <td align="center" style="border: 1px solid #000000;"> 
                        {{ parseToDateTh($header->start_date) }} 
                    </td>
                    <td align="center" style="border: 1px solid #000000;"> 
                        {{ parseToDateTh($header->end_date) }} 
                    </td> 
                </tr>
            @endforeach  
        </tbody>
    </table>
</div>