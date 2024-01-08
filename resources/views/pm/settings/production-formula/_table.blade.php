<div class="table-responsive">
    <table class="table text-nowrap" id="production-formula-datatable">
        <thead>            
            <tr>
                <th class="text-center">รหัสสินค้า</th>
                <th class="text-center">ชื่อสินค้า</th>
                <th class="text-center">ประเภทสูตร</th>
                <th class="text-center">ประเภทสิ่งผลิต </th>
                <th class="text-center">Version</th>
                <th class="text-center">สถานะ</th>
                <th class="text-center">ขั้นตอนการทำงาน</th>
                <th class="text-center">ประเภทเครื่องจักร</th>
                <th class="text-center">ปีงบประมาณ</th>
                <th class="text-center">วันที่เริ่มใช้งาน</th>
                <th class="text-center">วันที่สิ้นสุดใช้งาน</th>
                <th style="min-width: 160px; max-width: 160px;"></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($dataLists as $header)
                <tr>                    
                    <td> 
                        {{ $header->item ?  $header->item->item_number : '' }} 
                    </td>
                    <td> 
                        {{ $header->item ?  $header->item->item_desc : ''}} 
                    </td>
                    <td> 
                        {{ $header->FormulaType ? $header->FormulaType->description : ''  }} 
                    </td>
                    <td> 
                        {{ $header->routing ? $header->routing->routing_desc : '' }}
                    </td>
                    <td align="center"> 
                        {{ $header->version }} 
                    </td>
                    <td> 
                        @if ($header->status == 'Approved for General Use')
                            อนุมัติ
                        @elseif ($header->status == 'New')
                            สร้างใหม่
                        @elseif ($header->status == 'Obsolete/Archived')
                            ยกเลิก
                        @endif
                    </td>
                    <td> 
                        {{ $header->opmRouting ? $header->opmRouting->oprn_desc : '' }}
                    </td>
                    <td> 
                        @if ($organizationCode == 'M05')
                            {{ $header->machineGroupF ? $header->machineGroupF->description : '' }} 
                        @else
                            {{ $header->machineType ? $header->machineType->description : '' }} 
                        @endif
                        
                    </td> 
                    <td align="center"> 
                        {{ $header->period_year }}
                    </td>
                    <td align="center"> 
                        {{ parseToDateTh($header->start_date) }} 
                    </td>
                    <td align="center"> 
                        {{ parseToDateTh($header->end_date) }} 
                    </td> 
                    <td class="text-center">
                        @if ($header->recipe_id)
                            <a href="{{ route('pm.settings.production-formula.show', $header->secure_id) }}" class="btn btn-white btn-xs pull-left">
                                <i class="fa fa-file-text-o"></i> รายละเอียด
                            </a>
                            @if ($header->status == 'New' || $header->status == 'สร้างใหม่')
                                <a href="{{ route('pm.settings.production-formula.edit', $header->recipe_id) }}" class="btn btn-warning btn-xs pull-right">
                                    <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{-- {{ $dataLists->withQueryString()->links() }} --}}
</div>
