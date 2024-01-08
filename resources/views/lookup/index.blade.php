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
@if (canEnter('/lookup?programCode='.$program->program_code) && $program->insert_flag == 'Y')
    @section('page-title-action')
        <a href="{{ route('lookup.create', ['programCode' => $program->program_code]) }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i>  สร้าง
        </a>
    @stop
@endif

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>{{ $program->description }}</h5>
                </div>
                <div class="ibox-content">
                  @if ($program->program_code == 'OMS0008')
                    @php
                      $headerDescription = $lookups->isNotEmpty() ? $lookups->first()->attribute1 : ''; 
                    @endphp
                    <div>
                      {!! Form::open(['route' => ['lookup.updateHeaderName', $program->program_code] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                        <div class="row mt-2 mb-3">
                          {{-- @method('PUT') --}}
                          <div class="col-md-2 mt-2">
                            <div class="text-right"><label> <strong>ชื่อ Incoterms</strong> </label></div>
                          </div>
                          <div class="col-md-3">
                            <input type="text" name="header_description" value="{{$headerDescription}}" class="form-control">
                          </div>
                          <div class="col-md-4"></div>
                          <div class="col-md-2">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                          </div>
                        </div>
                      {!! Form::close() !!}
                    </div>
                  @endif
                    @include('shared.lookup._table')
                    {{-- @include('shared.lookup._t') --}}
                </div>
            </div>
        </div>
    </div>
@endsection
