<div class="table-responsive margin_top_20" style="max-height: 500px;">
    <table class="table text-nowrap data_tb table-bordered" style="position: sticky;">
      <thead>
        <tr class="text-center">
          <th class="text-center" style="width: 150px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">กรมธรรม์ชุดที่<br>(Policy No)</th>
          <th class="text-center" style="width: 450px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">คำอธิบาย<br>(Description)</th>
          <th class="text-center" style="width: 300px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">แบบของการประกัน<br>(Policy Type)</th>
          <th class="text-center" style="width: 80px; vertical-align: middle; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Active</th>
          <th class="text-center" style="width: 50px; vertical-align: middle; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dataLists as $data)
            <tr>
                <td class="text-center">{{ $data->policy_set_number }}</td>
                <td>{{ $data->policy_set_description }}</td>
                <td class="text-center">{{ $data->policyType ? $data->policyType->description : '' }}</td>
                <td class="text-center" data-sort="{{ $data->active_flag == 'Y' ? true : false }}">
                    <policy-active-flag 
                        :policy="{{ json_encode($data) }}">
                    </policy-active-flag>
                </td>
                <td class="width_table text-center">
                    <a href="{{ route('ir.settings.policy.edit', $data->policy_set_header_id) }}" class="{{ trans('btn.edit.class') }} btn-sm tw-w-25">
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