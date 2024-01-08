<div class="table-responsive">
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th class="text-center">ชื่อรายการราคาสินค้า</th>
                <th class="text-center">รายละเอียด</th>
                <th class="text-center">วันที่ใช้งาน</th>
                <th class="text-center">วันที่สิ้นสุดใช้งาน</th>
                <th class="text-center">สกุลเงิน</th>
                <th class="text-center">หมายเหตุรายการ
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($headers as $header)
                <tr>                    
                    <td> 
                        {{ $header->name }} 
                    </td>
                    <td> 
                        {{ $header->description}} 
                    </td>
                    <td align="center"> 
                        {{ $header->effective_dates_from ? date(trans('date.format-date'),strtotime($header->effective_dates_from)) : '' }} 
                    </td>
                    <td align="center"> 
                        {{ $header->effective_dates_to ? date(trans('date.format-date'),strtotime($header->effective_dates_to)) : '' }} 
                    </td> 
                    <td align="center"> 
                        {{ $header->currency }} 
                    </td>
                    <td> 
                        {{ $header->comments }} 
                    </td> 
                    <td class="text-center">
                        <a href="{{ route('om.settings.price-list-export.show', $header->list_header_id) }}" class="btn btn-white btn-xs">
                            <i class="fa fa-file-text-o"></i> รายละเอียด
                        </a>
                        <a href="{{ route('om.settings.price-list-export.edit', $header->list_header_id) }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
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
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop
        