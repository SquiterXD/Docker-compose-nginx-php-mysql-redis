<div class="table-responsive">
    <table class="table text-nowrap table-bordered">
        <thead>            
            <tr>
                <th class="text-center">การใช้งาน</th>
                <th class="text-center">รหัสวัตถุดิบ</th>
                <th class="text-center">รายละเอียด</th>
                <th class="text-center">ประเภทวัตถุดิบจำลอง</th>
                <th class="text-center" width="100px;">ราคาต่อหน่วย (บาท)</th>
                <th class="text-center">หน่วย</th>
                {{-- <th>วันที่เริ่ม</th>
                <th>วันที่สิ้นสุด</th> --}}
                <th class="text-center">หมายเหตุ</th>
                <th class="text-center">วันที่สร้าง</th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            @if ($simuRaws->isNotEmpty())
                @foreach ($simuRaws as $simuRaw)
                    <tr>     
                        <td align="center">
                            @include('shared._status_active', ['isActive' => $simuRaw->active_flag == 'Y'])
                        </td>               
                        <td> {{ $simuRaw->simu_raw_num }} </td>
                        <td> {{ $simuRaw->description }} </td>
                        <td> 
                            {{ $simuRaw->simulationType ? $simuRaw->simulationType->description : '' }} 
                        </td>
                        <td align="right">{{ number_format($simuRaw->price_per_unit, 2) }}</td>
                        <td> 
                            {{ $simuRaw->uom ? $simuRaw->uom->description : '' }} 
                        </td>
                        {{-- <td align="center"> {{ $simuRaw->start_date ? date(trans('date.format'),strtotime($simuRaw->start_date)) : '' }} </td>
                        <td align="center"> {{ $simuRaw->end_date ? date(trans('date.format'),strtotime($simuRaw->end_date)) : '' }} </td> --}}
                        <td> {{ $simuRaw->remark }} </td>
                        <!-- <td align="center"> {{ $simuRaw->created_at ? date(trans('date.format'),strtotime($simuRaw->created_at)) : '' }} </td> -->
                        <td align="center"> {{ $simuRaw->created_at ? parseToDateTh($simuRaw->created_at) : '' }} </td>

                        {{-- <td>
                            <div style="width: 80px;">
                                @if (!$simuRaw->inventory_item_id)
                                    <a href="{{ route('pd.settings.simu-raw-material.createInv', $simuRaw->simu_raw_id) }}" class="btn btn-white btn-xs">
                                        สร้างวัตถุดิบในคงคลัง
                                    </a>
                                @endif
                            </div>
                        </td>    --}}
                        <td>
                            @if (!$simuRaw->inventory_item_id)
                                <a href="{{ route('pd.settings.simu-raw-material.edit', $simuRaw->simu_raw_id) }}" class="btn btn-warning btn-xs">
                                    <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach   
            @else
                <tr>     
                    <td colspan="8" class="text-center">No Data</td>
                </tr>
            @endif         
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $simuRaws->links() }}
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.program_info_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                    // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop
        