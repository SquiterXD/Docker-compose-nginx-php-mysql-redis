<div class="table-responsive">
    <table class="table text-nowrap program_info_tb table-bordered">
        <thead>
            <tr>
                <th class="text-center">ลำดับที่</th>
                <th class="text-center">รหัสร้านค้า</th>
                <th class="text-center">ชื่อร้านค้า</th>
                <th class="text-center">อำเภอ/เขต</th>
                <th class="text-center">จังหวัด</th>
                <th class="text-center">วันที่ขนส่ง</th>
                <th class="text-center">ช่วงเวลามาตรฐานการส่งมอบ</th>
                <th class="text-center">วันมาตรฐานการส่งมอบ</th>
                <th class="text-center">เวลามาตรฐานการส่งมอบ</th>
                <th class="text-center">วันที่เริ่มต้น</th>
                <th class="text-center">วันที่สิ้นสุด</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tranSportRoutes as $tranSportRoute)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td align="center">{{ $tranSportRoute->customer ? $tranSportRoute->customer->customer_number : ''  }}</td>
                    <td>{{ $tranSportRoute->customer ? $tranSportRoute->customer->customer_name   : '' }}</td>
                    <td>{{ $tranSportRoute->customer ? $tranSportRoute->customer->city            : ''  }}</td>
                    <td>{{ $tranSportRoute->customer ? $tranSportRoute->customer->province_name   : '' }}</td>
                    <td>{{ $tranSportRoute->transport_day }}</td>
                    <td>{{ $tranSportRoute->time_of_day }} </td>
                    <td>{{ $tranSportRoute->standard_transport_day }}</td>
                    <td align="center">{{ $tranSportRoute->standard_transport_time }}</td>
                    {{-- <td align="center">{{ $tranSportRoute->start_date ? date(trans('date.format-date'), strtotime($tranSportRoute->start_date)) : '' }}</td>
                    <td align="center">{{ $tranSportRoute->end_date   ? date(trans('date.format-date'), strtotime($tranSportRoute->end_date))   : '' }}</td> --}}
                    <td align="center">{{ $tranSportRoute->start_date ? parseToDateTh($tranSportRoute->start_date) : '' }}</td>
                    <td align="center">{{ $tranSportRoute->end_date   ? parseToDateTh($tranSportRoute->end_date)   : '' }}</td>
                    {{-- <td>{{ $tranSportRoute->end_date   ? date(trans('date.format-date'), strtotime($tranSportRoute->end_date)) : '' }}</td> --}}
                    <td align="center">                   
                        <a href="{{ route('om.settings.transportation-route.edit', $tranSportRoute->transport_id) }}" class="btn btn-warning btn-xs mr-2" size="small">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- <div class="d-flex justify-content-center">
    {{ $tranSportRoutes->links() }}
</div> --}}
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