<table class="table program_info_tb">
    <thead>
        <tr>
            <th>program code</th>
            <th>description</th>
            <th>program type name</th>
            <th></th>
        </tr>
    </thead>
    <tbody> 
        {{-- {{dd($programNames)}} --}}
        @foreach ($programNames as $programName)
            <tr>
                <td class="text-center">{{ $programName->program_code }}</td>
                <td class="text-left">{{ $programName->description }}</td>
                <td class="text-center">{{ $programName->program_type_name }}</td>
                <td align="center">
                    {{-- {{dd($programName)}} --}}
                    <a  class="btn btn-sm btn btn-light"  
                        href="{{ route('set-up.show', $programName->program_code) }}">
                        <i class="fas fa-file-alt"></i> View
                    </a>
                    {{-- <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal" data-target="#popUp_{{$programName->program_code}}">
                        Edit
                    </button>

                    @include('pd.setting.set-up._modal_edit') --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

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