@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    @foreach ($names as $name)
                        <h5> ตั้งค่า : {{ $name->program_code }} : {{ $name->description }} </h5>
                    @endforeach
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table program_info_tb">
                            <thead>
                                <tr>
                                    <th>column name</th>
                                    <th>column prompt</th>
                                    <th>enable flag</th>
                                    <th>column seq num</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($programColumns as $programColumn)
                                    <tr>
                                        <td class="text-left">{{ $programColumn->column_name }}</td>
                                        <td class="text-left">{{ $programColumn->column_prompt }}</td>
                                        <td class="text-center">{{ $programColumn->enable_flag }}</td>
                                        <td class="text-center">{{ $programColumn->column_seq_num }}</td>
                                        <td align="center">
                                            {{-- <a  class="btn btn-sm btn-primary btn-outline"  
                                                data-target="#popUp_{{$programName->program_code}}"
                                                href="{{ route('pd.settings.set-up.edit', [$programColumn->program_code, $programColumn->column_name]) }}" 
                                                style="font-size: 0.6rem;" > Edit </a> --}}
                                                <button type="button" class="btn btn-sm btn btn-warning" data-toggle="modal" data-target="#popUp_{{$programColumn->column_name}}">
                                                    <i class="fa fa-edit"></i> แก้ไข
                                                </button>
                        
                                                @include('pd.settings.set-up._modal_edit')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
@endsection

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

