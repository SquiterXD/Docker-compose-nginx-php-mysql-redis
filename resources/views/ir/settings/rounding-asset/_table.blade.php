<div class="table-responsive" style="max-height: 500px;">
    <table class="table text-nowrap table-hover table-bordered" id="data_tb" style="position: sticky;">
        <thead>
            <tr>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">กรมธรรม์ชุดที่<br>(Policy No.)</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">รหัสทรัพย์สิน<br>(Asset Number)</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">คำอธิบาย<br>(Description)</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td class="text-center"> {{ $data->policy ? $data->policy->policy_set_number : '' }} </td>
                    <td class="text-center"> {{ $data->policy ? $data->asset->asset_number : '' }} </td>
                    <td> {{ $data->policy ? $data->asset->description : '' }} </td>
                    <td class="text-center">
                        <a href="{{ route('ir.settings.rounding-asset.edit', $data->id) }}" class="{{ trans('btn.edit.class') }} btn-xs">
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
            var dataTable = $('#data_tb');
            dataTable.DataTable({
                pageLength: 10,
                responsive: true,
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                buttons: [
                ],
            });
        });
    </script>
@stop