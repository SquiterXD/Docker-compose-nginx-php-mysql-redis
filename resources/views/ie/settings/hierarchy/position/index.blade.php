@extends('layouts.app')

@section('title', 'Hierarchy')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy" /> Hierarchy Positions <br>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Hierarchy Positions</strong>
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
            {!! Form::open(['route' => ['ie.settings.hierarchy-position.store'],'class' => 'form-horizontal','id'=>'form_create_hierarchy_position']) !!}
                <div class="row m-b-sm">
                    <div class="col-md-5">
                        <div class="row">
                            <label class="col-md-3">
                                <div>Name <span class="text-danger">*</span></div>
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" id="name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-default" id="btn-search">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-submit">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            {!! Form::close()!!}
            <div class="row">
                <div class="col-md-12">
                    @include('ie.settings.hierarchy.position._table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('ie.settings.hierarchy.position.user._modal_create')
@include('ie.settings.hierarchy.position._modal_edit')
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("[id^='btn-search']").click(function(){
                event.preventDefault();
                let name = $("[id^='name']").val();
                window.location.href = '//' + location.host + location.pathname + "?search=" + name;
            });

            $("[id^='btn-submit']").click(function(){
                event.preventDefault();
                $("#form_create_hierarchy_position").submit();
            });

            $("[id^='btn_edit_hierarchy_position_']").click(function(){
                var positionId = $(this).attr('data-hierarchy-position-id');
                $("#modal-edit-hierarchy-position").modal('show');
                renderFormEditPositions(positionId);
            });

            function renderFormEditPositions(positionId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/hierarchy-position/"+positionId+"/form_edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_edit_hierarchy_position").html('\
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
                    $("#modal_content_edit_hierarchy_position").html(result);
                });
            }

            $("[id^='btn_remove_hierarchy_position_']").click(function(){
                var positionId = $(this).attr('data-hierarchy-position-id');
                let formId = '#form_remove_hierarchy_position_'+positionId;
                swal({
                    html: true,
                    title: 'Remove Position ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this position ? </span></h2>',
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

            $("[id^='btn_add_hierarchy_position_user_']").click(function(){
                var positionId = $(this).attr('data-hierarchy-position-id');
                $("#modal-create-hierarchy-position-user").modal('show');
                renderFormCreatePositionUsers(positionId, positionId);
            });

            function renderFormCreatePositionUsers(positionId, positionId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/hierarchy-position/"+positionId+"/user/form_create",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_create_hierarchy_position_user").html('\
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
                    $("#modal_content_create_hierarchy_position_user").html(result);
                    $("#modal_content_create_hierarchy_position_user").find(".select2").select2();
                });
            }

            $("#table_hierarchy_positions .hierarchy-position-collapse-row").click(function(e){
                let icon = $(this).find("i");
                let hierarchy_position_id = $(this).attr('data-hierarchy-position-id');
                let tr = $("tr#tr_"+hierarchy_position_id);
                if (tr.is(':visible')) {
                    tr.addClass('animated fadeOutUp')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeOutUp').hide();
                    });
                    icon.removeClass('fa-caret-down');
                    icon.addClass('fa-caret-right');
                } else {
                    tr.show().addClass('animated fadeInDown')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animated fadeInDown');
                    });
                    icon.removeClass('fa-caret-right');
                    icon.addClass('fa-caret-down');
                }
                e.preventDefault();
            });

            $("[id^='btn_set_default_hierarchy_position_user_']").click(function(){
                var positionUserId = $(this).attr('data-hierarchy-position-user-id');
                let formId = '#form_set_default_hierarchy_position_user_'+positionUserId;
                swal({
                    html: true,
                    title: 'Set Default User ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to set default this user ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, set it !',
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

            $("[id^='btn_remove_hierarchy_position_user_']").click(function(){
                var positionUserId = $(this).attr('data-hierarchy-position-user-id');
                let formId = '#form_remove_hierarchy_position_user_'+positionUserId;
                swal({
                    html: true,
                    title: 'Remove User ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this user ? </span></h2>',
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