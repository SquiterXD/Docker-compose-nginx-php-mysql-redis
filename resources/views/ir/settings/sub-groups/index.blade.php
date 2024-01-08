@extends('layouts.app')

@section('title', 'Sub-Group')

{{-- @section('page-title')
  <h2>IRM0009: ข้อมูลกลุ่มย่อย (Sub-Group)</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>IR</a>
    </li>
    <li class="breadcrumb-item">
        <a>Settings</a>
    </li>
    <li class="breadcrumb-item active">
      <strong>IRM0009: ข้อมูลกลุ่มย่อย (Sub-Group)</strong>
    </li>
  </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/sub-groups" />
@stop

@section('page-title-action')
    <a  href="{{ route('ir.settings.sub-groups.create') }}" 
        class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
  <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
              <div class="text-center">
                  <h1 class="tw-mt-0"></h1>
                  <div class="ibox-content">
                    @include('ir.settings.sub-groups._search')
                  </div>
              </div>
          </div>
          <div class="col-lg-12">
              <div class="text-center m-t-lg">
                  <h1 class="tw-mt-0"></h1>
                  <div class="ibox-content">
                    @include('ir.settings.sub-groups._table')
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
    <script>
        
    </script>
@endsection