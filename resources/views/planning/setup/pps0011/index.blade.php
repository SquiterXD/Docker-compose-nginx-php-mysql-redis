@extends('layouts.app')
@section('title', $profile->program_code)
@section('page-title')
    <x-get-page-title menu="" url="/planning/setup/pps0011" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5> กำหนดแปลงหน่วยแสตมป์ </h5>
                </div>
                <div class="ibox-content">
                    <table class="table pps0011_tb">
                        <thead>
                            <tr>
                                <th width="18%" class="hidden-sm hidden-xs text-center">
                                    <div> รหัสบุหรี่ </div>
                                </th>
                                <th width="18%" class="hidden-sm hidden-xs text-center">
                                    <div> รหัสแสตมป์ </div>
                                </th>
                                <th width="10%" class="hidden-sm hidden-xs text-center">
                                    <div> ราคาต่อดวง </div>
                                </th>
                                <th width="10%" class="hidden-sm hidden-xs text-center">
                                    <div> ม้วนละ (ดวง) </div>
                                </th>
                                <th width=5%" class="text-left"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pps0011 as $data)
                            <tr>
                                <td class="text-left">
                                    {{ $data->cigarette_code.': '.optional($data->cigarette)->item_description }}
                                </td>
                                <td class="text-left">
                                    {{ $data->item_number.': '.$data->item_description }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($data->unit_price, 8) }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($data->stamp_per_roll, 2) }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('planning.setup.pps0011.edit', [$data->inventory_item_id, $data->formula_no]) }}" class="btn btn-warning btn-xs">
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
            var dataTable = $('.pps0011_tb');
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
                    // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : true },
                    // { className: "text-center", "targets": [ 1 ] , type: "string", orderable : false },
                ],
            });
        });
    </script>
@stop