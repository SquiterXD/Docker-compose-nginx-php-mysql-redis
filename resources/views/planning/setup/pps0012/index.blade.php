@extends('layouts.app')
@section('title', $profile->program_code)
@section('page-title')
    <x-get-page-title menu="" url="/planning/setup/pps0012" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5> กำหนดสั่งซื้อแสตมป์ </h5>
                </div>
                <div class="ibox-content">
                    <table class="table pps0012_tb">
                        <thead>
                            <tr>
                                {{-- <th width="15%" class="hidden-sm hidden-xs text-center">
                                    <div> สถานะ </div>
                                </th> --}}
                                <th width="15%" class="hidden-sm hidden-xs text-center">
                                    <div> วันที่สั่งซื้อในสัปดาห์ </div>
                                </th>
                                <th width="15%" class="hidden-sm hidden-xs text-center">
                                    <div> ปริมาณที่สั่งซื้อล่วงหน้าเพียงพอ (วัน) </div>
                                </th>
                                <th width=10%" class="text-left"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pps0012 as $data)
                            <tr>
                                {{-- <td class="text-center">
                                    @include('shared._status_active', ['isActive' => $data->enabled_flag == 'Y'])
                                </td> --}}
                                <td class="text-center">
                                    {{ $data->description }}
                                </td>
                                <td class="text-center">
                                    {{ $data->past_days > 0? $data->past_days: ''}}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('planning.setup.pps0012.edit', $data->day_code ?? '') }}" class="btn btn-warning btn-xs">
                                       <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                    </a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.pps0012_tbx');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                // dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                    { className: "text-center", "targets": [ 0 ] , type: "string", orderable : true },
                    { className: "text-center", "targets": [ 1 ] , type: "string", orderable : false },
                ],
            });
        });
    </script>
@stop