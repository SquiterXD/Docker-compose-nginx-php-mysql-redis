<table class="table program_info_tb">
    <thead>
        <tr>
            <th class="text-center">
                <div>รหัสแผนก</div>
            </th>
            <th class="text-center">
                <div>แผนก</div>
            </th>
            <th class="text-center">
                <div>รหัส</div>
            </th>
            <th class="text-center">
                <div>กลุ่มวัตถุดิบ</div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materialGroups as $materialGroup)
        <tr>
            <td class="text-center">
                {{ $materialGroup->dept_code }}
            </td>
            <td class="text-left">
                {{ $materialGroup->coaDepartment ? $materialGroup->coaDepartment->description : '' }}
            </td>
            <td class="text-center">
                {{ $materialGroup->itemcat_group_code }}
            </td>
            <td class="text-left">
                {{ $materialGroup->itemcatMatGroupV ? $materialGroup->itemcatMatGroupV->type_desc : '' }}
            </td>
        </tr>            
        @endforeach
    </tbody>
</table>

{{-- @section('scripts')
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
@stop --}}