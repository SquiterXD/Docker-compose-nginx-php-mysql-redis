<div class="table-responsive">
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th>ทวีป</th>
                <th>ชื่อประเทศ</th>
                <th class="text-center">รหัสประเทศ</th>
                <th class="text-center">Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($countries as $country)
                <tr>                    
                    <td> {{ $country->continent_name }} </td>
                    <td> {{ $country->country_name }} </td>
                    <td align="center"> {{ $country->country_code }} </td>
                    <td align="center">
                        @include('shared._status_active', ['isActive' => $country->status == 'Active'])
                    </td> 
                    <td class="text-center">
                        @if (canEnter('/om/settings/country'))
                            <a href="{{ route('om.settings.country.edit', $country->country_id) }}" class="btn btn-warning btn-xs">
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
        