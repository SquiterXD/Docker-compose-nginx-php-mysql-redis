<table class="table program_info_tb">
    <thead>
        <tr>
            <th class="text-center">
                <div>สถานะการใช้งาน</div>
            </th>
            <th class="text-center">
                <div>กลุ่มชุดเครื่องจักร</div>
            </th>
            <th class="text-center">
                <div>หัวจ่าย</div>
            </th>
            <th class="text-center">
                <div> </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($relationFeeders as $relationFeeder)
        <tr>
            <td class="text-center">          
                @include('shared._status_active', ['isActive' => $relationFeeder->enabled_flag == 'Y'])
            </td>
            <td class="text-left">
                {{ $relationFeeder->machineGroupS ? $relationFeeder->machineGroupS->description : '' }}
            </td>
            <td class="text-center">
                {{ $relationFeeder->feederName ? $relationFeeder->feederName->meaning : '' }}
            </td>
            <td class="text-center" style="font-size:12px">
                <a  type="button" 
                    href="{{ route('pm.settings.relation-feeder.edit', [$relationFeeder->machnie_group, $relationFeeder->feeder_code]) }}" 
                    class="{{ $btnTrans['edit']['class'] }}">
                    <i class="{{ $btnTrans['edit']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['edit']['text'] }}
                </a>
            </td>
        </tr>            
        @endforeach
    </tbody>
</table>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.program_info_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> </div>';
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