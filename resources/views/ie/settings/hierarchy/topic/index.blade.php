@extends('layouts.app')

@section('title', 'Hierarchy')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy" /> Hierarchy Topics <br>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Hierarchy Topics</strong>
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
            {!! Form::open(['route' => ['ie.settings.hierarchy-topic.store'],'class' => 'form-horizontal']) !!}
                <div class="row m-b-sm">
                    <label class="col-md-1">
                        <div>Code <span class="text-danger">*</span></div>
                    </label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="code" id="code" autocomplete="off">
                    </div>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            {!! Form::close()!!}
            <div class="row">
                <div class="col-md-12">
                    @include('ie.settings.hierarchy.topic._table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('ie.settings.hierarchy.topic._modal_edit')
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#form_create_hierarchy_topic').submit(function() {
                $('#btn_create_hierarchy_topic').attr('disabled', 'disabled');
            });

            $("[id^='btn_edit_hierarchy_topic_']").click(function(){
                var topicId = $(this).attr('data-hierarchy-topic-id');
                $("#modal-edit-hierarchy-topic").modal('show');
                renderFormEditTopics(topicId);
            });

            function renderFormEditTopics(topicId)
            {
                $.ajax({
                    url: "{{ url('/') }}/ie/settings/hierarchy-topic/"+topicId+"/form_edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal_content_edit_hierarchy_topic").html('\
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
                    $("#modal_content_edit_hierarchy_topic").html(result);
                });
            }

            $("[id^='btn_remove_hierarchy_topic_']").click(function(){
                var topicId = $(this).attr('data-hierarchy-topic-id');
                let formId = '#form_remove_hierarchy_topic_'+topicId;
                swal({
                    html: true,
                    title: 'Remove Topic ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this topic ? </span></h2>',
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