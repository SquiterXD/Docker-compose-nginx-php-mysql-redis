<div class="table-responsive">
    <table class="table program_info_tb">
        <thead>            
            <tr>
                <th class="text-center">สถานะการใช้งาน</th>
                <th>คำอธิบายชุดการผลิต</th>
                <th>Organization</th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($routings as $routing)
                <tr>   
                    <td align="center" data-sort="{{ $routing->active_flag == 'Y' ? true : false }}"> 
                        @include('shared._status_active', ['isActive' => $routing->active_flag == 'Y'])
                    </td> 
                    <td>
                        {{ $routing->routing_description }}
                    </td>     
                    <td>
                        {{ $routing->organization ? $routing->organization->organization_code . ' : ' . $routing->organization->organization_desc : '' }}
                    </td>           
                    <td class="text-center">
                        @if ($routing->routing_id)
                            <a href="{{ route('pm.settings.wip-step.show', $routing->routing_id) }}" class="btn btn-white btn-xs">
                                <i class="fa fa-file-text-o"></i> รายละเอียด
                            </a>
                            <a href="{{ route('pm.settings.wip-step.edit', $routing->routing_id) }}" class="btn btn-warning btn-xs">
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
        