<div class="table-responsive mt-2" style="max-height: 500px;">
    <table class="table text-nowrap data_tb table-bordered">
        <thead>
            <tr>
              <th style="min-width: 70px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Code <br>รหัส</th>
              <th style="min-width: 160px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Name <br>ชื่อ</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Active</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataLists as $data)
                <tr>
                    <td class="text-center"> 
                        {{ $data->company_number }}
                    </td>
                    <td class="text-left"> 
                        {{ $data->company_name }}
                    </td>
                    <td class="text-center" data-sort="{{ $data->active_flag == 'Y' ? true : false }}">
                        <company-active-flag 
                            :company="{{ json_encode($data) }}">
                        </company-active-flag>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ir.settings.company.edit', $data->company_id) }}" class="{{ trans('btn.edit.class') }} btn-sm tw-w-25">
                            <i class="{{ trans('btn.edit.icon') }}"></i> {{ trans('btn.edit.text') }}
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
            var dataTable = $('.data_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 10,
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