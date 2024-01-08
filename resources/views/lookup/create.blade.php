@extends('layouts.app')
@section('title', $program->program_code)
@section('page-title')
  <x-get-page-title :menu="$menu" url="" />
  {{-- <h2>{{ $program->program_code . ' : ' . $program->description }}</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>{{ $program->module_name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a>Setting</a>
      </li>
    <li class="breadcrumb-item active">
      <strong>{{ $program->description }}</strong>
    </li>
  </ol> --}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ $program->description }} </h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['lookup.store', ['programCode' => $program->program_code]] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        
                    @if ($program->program_code == 'QMS0021')
                      @include('shared.lookup._form_QMS0021')
                    @elseif ($program->program_code == 'QMS0004')
                      @include('shared.lookup._form_QMS0004')
                    @else
                      @include('shared.lookup._form')
                    @endif

                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                                <a href="{{ route('lookup.index', ['programCode' => $program->program_code]) }}" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> ยกเลิก </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection