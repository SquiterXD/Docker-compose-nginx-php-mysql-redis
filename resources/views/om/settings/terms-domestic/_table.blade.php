<div class="table-responsive">
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th class="text-center">รหัสการชำระเงิน</th>
                <th class="text-center">เงื่อนไขการชำระเงิน</th>
                <th class="text-center">วันที่เริ่มใช้งาน</th>
                <th class="text-center">วันที่สิ้นสุดการใช้งาน</th>
                <th class="text-center">จำนวนวันปลอดดอก</th>
                <th width="8%"></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($terms as $term)
                <tr>                    
                    <td> {{ $term->term_name }} </td>
                    <td> {{ $term->description }} </td>
                    {{-- <td align="center"> {{ $term->start_date_active ? date(trans('date.format'),strtotime($term->start_date_active)) : '' }} </td>
                    <td align="center"> {{ $term->end_date_active ? date(trans('date.format'),strtotime($term->end_date_active)) : '' }} </td> --}}
                    <td align="center">{{ $term->start_date_active ? parseToDateTh($term->start_date_active) : '' }}</td>
                    <td align="center">{{ $term->end_date_active   ? parseToDateTh($term->end_date_active)   : '' }}</td>
                    <td align="center"> {{ $term->due_days }} </td> 
                    <td align="center">
                        @if (canEnter('/om/settings/term'))
                            <a href="{{ route('om.settings.term.edit', $term->term_name) }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-edit m-r-xs"></i> แก้ไข
                            </a>
                        @endif
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
        