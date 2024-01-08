@extends('layouts.app')

@section('title', 'Cash Advance Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> 
        <div><x-get-program-code url="/ie/settings/ca-categories" />Edit CA Category : {{ $ca_category->name }} </div>
        <div><small>แก้ไขข้อมูลประเภทการเบิกเงินทดรอง</small></div>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.ca-categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Edit CA Category : {{ $ca_category->name }}</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        Edit CA Category : {{ $ca_category->name }} <br>
        <small>แก้ไขข้อมูลประเภทการเบิกเงินทดรอง</small>
    </h3>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        {!! Form::open(['route' => ['ie.settings.ca-categories.remove',$ca_category->ca_category_id], 
                    'method' => 'POST',
                    'id' => 'form-remove-ca-category']) !!}
        
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-times"></i> Remove
            </button>

        {!! Form::close() !!}
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                {!! Form::model($ca_category, ['route' => ['ie.settings.ca-categories.update', $ca_category->ca_category_id], 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
                @include('ie.settings.ca-categories._form')
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#form-remove-ca-category").submit(function( event ) {
                var form = this;
                swal({   
                    html: true,
                    title: 'Are you sure ?',   
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">You will not able to recover this category.</span></h2>',   
                    // type: "info",   
                    showCancelButton: true,   
                    confirmButtonText: 'Yes, remove it !',   
                    cancelButtonText: 'cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-white',   
                    closeOnConfirm: true,   
                    closeOnCancel: true 
                }, 
                function(isConfirm){   
                    if (isConfirm) {     
                        form.submit(); 
                    }else{
                        $("button[type='submit']").removeAttr('disabled');
                    }
                });
                event.preventDefault();
            });
        });
    </script>
@endsection