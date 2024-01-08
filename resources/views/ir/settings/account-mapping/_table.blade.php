<div class="table-responsive" style="max-height: 500px;">
    <table class="table text-nowrap table-hover table-bordered" id="data_tb"  style="position: sticky;">
        <thead>
            <tr>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                    <div> รหัส (Code) </div>
                </th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">
                    <div> คำอธิบาย (Description) </div>
                </th>
                <th class="text-center" witdth="20%" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;"> 
                    <div> รหัสบัญชี (Account Code) </div>
                </th>
                <th class="text-center" witdth="20%" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;"> 
                    <div> Active </div>
                </th>
                <th style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accountAlls as $account)
                <tr>
                    <td> {{ $account->account_code }} </td>
                    <td> {{ $account->description }} </td>
                    <td> {{ $account->fullGlCode }} </td>
                    {{-- <td class="text-center">
                        <active-flag-account-mapping 
                            :active-flag="{{ json_encode($account->active_flag) }}"
                            :account-id="{{ json_encode($account->account_id) }}">
                            
                        </active-flag-account-mapping>
                    </td> --}}
                    @if ($account->active_flag == 'Y')
                        <td data-order="1"  align="center">
                            <active-flag-account-mapping 
                                :active-flag="{{ json_encode($account->active_flag) }}"
                                :account-id="{{ json_encode($account->account_id) }}">
                                
                            </active-flag-account-mapping>
                        </td>
                    @else
                        <td data-order="0"  align="center">
                            <active-flag-account-mapping 
                                :active-flag="{{ json_encode($account->active_flag) }}"
                                :account-id="{{ json_encode($account->account_id) }}">
                                
                            </active-flag-account-mapping>
                        </td>
                    @endif
                    <td class="text-center">
                        {{-- <a href="{{ route('ir.settings.account-mapping.edit', $account->account_id) }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a> --}}
                        <a href="{{ route('ir.settings.account-mapping.edit', $account->account_id) }}" class="{{ trans('btn.edit.class') }} btn-xs">
                            <i class="{{ trans('btn.edit.icon') }}"></i> {{ trans('btn.edit.text') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- <div class="m-t-sm text-right">
    {{ $paginations->links() }}
</div> --}}

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('#data_tb');
            // var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 10,
                responsive: true,
                // dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                // language: {
                //     loadingRecords: loadingHtml,
                // },
                buttons: [
                ],
            });
        });
    </script>
@stop