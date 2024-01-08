@extends('layouts.app')

@section('title', 'Hierarchy')

@section('page-title')
    <h2>
        <x-get-program-code url="/ie/settings/hierarchy" /> Hierarchy Setups <br>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Hierarchy Setups</strong>
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
            @include('ie.settings.hierarchy.setup._search_form')
            <div class="row">
                <div class="col-md-12">
                    @include('ie.settings.hierarchy.setup._table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".select2").select2({width: "100%"});

            var search = @json( $search );
            if(search){
                setSearch(search);
                toggleSearchForm('open');
            }

            $("[id^='btn_remove_hierarchy_setup_']").click(function(){
                var setupId = $(this).attr('data-hierarchy-setup-id');
                let formId = '#form_remove_hierarchy_setup_'+setupId;
                swal({
                    html: true,
                    title: 'Remove Setup ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> Are you sure to remove this setup ? </span></h2>',
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

            //// OPEN SEARCH FORM
            $("[id^='btn_open_search_form']").click(function(e){
                e.preventDefault();
                toggleSearchForm('open');
            });

            //// CLOSE SEARCH FORM
            $("[id^='btn_close_search_form']").click(function(e){
                e.preventDefault();
                toggleSearchForm('close');
            });

            //// SUBMIT SEARCH FORM
            $("[id^='btn_submit_search_form']").click(function(e){
                e.preventDefault();
                $("#hierarchy-setup-search-form").submit();
            });

            function setSearch(search)
            {
                console.log(search);
                $("select[name='search[type]']").val(search.type).trigger('change');
                $("select[name='search[department]']").val(search.department).trigger('change');
                $("select[name='search[hierarchy]']").val(search.hierarchy).trigger('change');
            }
            
            function toggleSearchForm(action)
            {
                if(action == 'open'){
                    $("#div-btn").addClass('d-none');
                    $("#div-hierarchy-setup-search-form").removeClass('d-none');
                }else {
                    $("#div-btn").removeClass('d-none');
                    $("#div-hierarchy-setup-search-form").addClass('d-none');
                }
            }
        });
    </script>
@stop