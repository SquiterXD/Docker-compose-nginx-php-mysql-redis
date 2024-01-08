@extends('layouts.app')

@section('title', 'Hierarchy')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy" /> Hierarchy Names <br>
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
            {!! Form::open(['route' => ['ie.settings.hierarchy-name.store'],'class' => 'form-horizontal','id'=>'form_create_hierarchy_name']) !!}
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
                    @include('ie.settings.hierarchy.name._table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('ie.settings.hierarchy.name._modal_edit')
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
                $("#form_create_hierarchy_name").submit();
            });

            $("[id^='btn_edit_hierarchy_name_']").click(function(){
                var nameId = $(this).attr('data-hierarchy-name-id');
                $("#modal-edit-hierarchy-name").modal('show');
                renderFormEditNames(nameId);
            });

            function renderFormEditNames(nameId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/hierarchy-name/"+nameId+"/form_edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_edit_hierarchy_name").html('\
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
                    $("#modal_content_edit_hierarchy_name").html(result);
                });
            }

            $("[id^='btn_remove_hierarchy_name_']").click(function(){
                var nameId = $(this).attr('data-hierarchy-name-id');
                let formId = '#form_remove_hierarchy_name_'+nameId;
                swal({
                    html: true,
                    title: 'Remove Hierarchy ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this hierarchy ? </span></h2>',
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