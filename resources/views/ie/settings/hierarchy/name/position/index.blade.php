@extends('layouts.app')

@section('title', 'Hierarchies')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy-names" /> Hierarchy Names <br>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Hierarchy Names</strong>
        </li>
    </ol>
@stop

@section('page-title-action')

@stop

@section('content')
<div class="row">
    <div class="col-md-2">
        @include('ie.settings.hierarchy._nav')
    </div>
    <div class="col-md-10">
        <div class="ibox-content">
            <div class="row m-b-sm">
                <div class="col-md-12">
                    <h4>Name : {{$hierarchy->name}}</h4>
                </div>
            </div>
            {!! Form::open(['route' => ['ie.settings.hierarchy-name.position.store', $hierarchy->hierarchy_name_id],'class' => 'form-horizontal']) !!}
                <div class="row m-b-sm">
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-md-3">
                                <div>Seq <span class="text-danger">*</span></div>
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="seq" id="seq" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <label class="col-md-3">
                                <div>Position <span class="text-danger">*</span></div>
                            </label>
                            <div class="col-md-9">
                                <select class="form-control select2" name="hierarchy_position_id" id="hierarchy_position_id">
                                    <option value="">-</option>
                                    @foreach ($positions as $position)
                                        <option value="{{$position->hierarchy_position_id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            {!! Form::close()!!}
            <div class="row">
                <div class="col-md-12">
                    @include('ie.settings.hierarchy.name.position._table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('ie.settings.hierarchy.name.position._modal_edit')
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var nameId = "{{ $hierarchy->hierarchy_name_id }}";

            $(".select2").select2();

            $("[id^='btn_edit_hierarchy_name_position_']").click(function(){
                var namePositionId = $(this).attr('data-hierarchy-name-position-id');
                $("#modal-edit-hierarchy-name-position").modal('show');
                renderFormEditNames(nameId, namePositionId);
            });

            function renderFormEditNames(nameId, namePositionId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/hierarchy-name/"+nameId+"/position/"+namePositionId+"/form_edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_edit_hierarchy_name_position").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                    }
                })
                .done(function(result) {
                    $("#modal_content_edit_hierarchy_name_position").html(result);
                });
            }

            $("[id^='btn_remove_hierarchy_name_position_']").click(function(){
                var namePositionId = $(this).attr('data-hierarchy-name-position-id');
                let formId = '#form_remove_hierarchy_name_position_'+namePositionId;
                swal({
                    html: true,
                    title: 'Remove Hierarchy Sequence ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this Hierarchy sequence ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it !',
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $(formId).submit();
                    }
                });
                event.preventDefault();
            });

        });
    </script>
@stop