<div class="table-responsive" style="max-height: 500px;">
    <table class="table text-nowrap table-hover table-bordered" id="data_tb" style="position: sticky;">
        <thead>
            <tr>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">ลำดับ</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Name ชื่อ </th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Email</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Active</th>
                <th class="text-center" style="position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emails as $email)
                <tr>
                    <td class="text-center"> {{ $loop->iteration }} </td>
                    <td>
                        @if ($email->company_flag == 'Y')
                            {{ $email->company_name }}
                            {{ $email->company ? $email->company->vendorBranch ? $email->company->vendorBranch->vendor_site_code : '' : '' }}
                        @elseif ($email->employee_flag == 'Y')
                            {{ $email->employee_name }}
                        @elseif ($email->department_flag == 'Y')
                            {{ $email->department_name }}
                        @endif
                    </td>
                    <td> {{ $email->email }} </td>
                    <td align="center" data-sort="{{$email->active_flag == 'Y' ? true : false}}">
                        <active-flag-email 
                            :active-flag="{{ json_encode($email->active_flag) }}"
                            :email-id="{{ json_encode($email->email_id) }}">
                        </active-flag-email>
                    </td>
                    {{-- @if ($email->active_flag == 'Y')
                        <td data-order="1"  align="center">
                            <active-flag-email 
                                :active-flag="{{ json_encode($email->active_flag) }}"
                                :email-id="{{ json_encode($email->email_id) }}">
                            </active-flag-email>
                        </td>
                    @else
                        <td data-order="0"  align="center">
                            <active-flag-email 
                                :active-flag="{{ json_encode($email->active_flag) }}"
                                :email-id="{{ json_encode($email->email_id) }}">
                            </active-flag-email>
                        </td>
                    @endif --}}
                    <td class="text-center">
                        <a href="{{ route('ir.settings.email.edit', $email->email_id) }}" class="{{ trans('btn.edit.class') }} btn-xs">
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