<div class="table-responsive" style="max-height: 500px;">
    <table class="table table-bordered sub_group_tbx" style="position: sticky;">
        <thead>
            <tr>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                    <div> กรมธรรม์ชุดที่ </div>
                </th>
                <th style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;"></th>
            </tr>
        </thead>
        <tbody>
            @if ($subGroups->isEmpty())
                <td colspan="2" class="text-center" style="width=100%">
                    <div style="margin-top: 1px;" style="vertical-align: middle;">
                        <h2> ไม่มีข้อมูล </h2>
                    </div>
                </td>
            @else
                @foreach ($subGroups as $subGroup)
                    <tr>
                        <td align="left" style="vertical-align: middle;" data-sort="{{ $subGroup->policySetHeaders->policy_set_number }}">
                            {{ $subGroup->policySetHeaders->policy_set_number. " : " . $subGroup->policySetHeaders->policy_set_description}}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <a  type="button" 
                                href="{{ route('ir.settings.sub-groups.edit', $subGroup->policy_set_header_id) }}" 
                                class="{{ $btnTrans['edit']['class'].' btn-xs'}}">
                                <i class="{{ $btnTrans['edit']['icon']}}" aria-hidden="true"></i> 
                                {{ $btnTrans['edit']['text']}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.sub_group_tbx');
            dataTable.DataTable({
                bPaginate: true,
                searching: false,
                bInfo: false,
                columnDefs: [
                   { orderable: false, targets: 1 }
                ]
            });
        });
    </script>
@stop